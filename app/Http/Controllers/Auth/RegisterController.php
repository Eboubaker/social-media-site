<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserSettings;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\Phone;
use App\Verify\Service;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\View\View;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo;
    /**
     * @var string
     */
    protected $loginFieldName;
    /**
     * Twilio's verify Service
     * @var Service
     */
    protected $verify;
    private $validatedPhone;
    /**
     * @var string
     */
    private $loginMethod;
    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;
    /**
     * Create a new controller instance.
     *
     * @param Service $verify
     */
    public function __construct(Service $verify)
    {
        $this->middleware('guest');
        $this->loginFieldName = 'login';
        $this->redirectTo = RouteServiceProvider::HOME;
        $this->verify = $verify;
        $this->phoneUtil = app('phoneNumberUtil');
        $l = $this->getLoginMethod();
        $this->validatedPhone = $l === 'phone' ? $this->getValidatedPhone() : '';

//        $request = [
//            "login" => "email_text|phone_text",
//            "password" => "password"
//        ];
//        $response = redirect-to ValidationController@show or back() with errors
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'password' => ['required', 'string', 'min:8'],
        ];
        if($this->getLoginMethod() === 'email')
        {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:'.User::TABLE.',email'];
            $data['email'] = $data[$this->loginFieldName];
            unset($data['login']);
        }else{
            $rules['phone'] = ['required', 'string', new Phone, 'unique:'.User::TABLE.',phone'];
            $data['phone'] = $this->getValidatedPhone();
            unset($data[$this->loginFieldName]);
        }
        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $userData = [
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(80),
        ];
        if($this->getLoginMethod() === 'email')
        {
            $userData['email'] = $data[$this->loginFieldName];
        }else{
            $userData['phone'] = $this->getValidatedPhone();
        }
        return DB::transaction(function() use ($userData) {
            $user = User::create($userData);
            $user->settings()->create(UserSettings::getDefault());
            return $user;
        });
    }
    private function getValidatedPhone():string
    {
        if(!$this->validatedPhone)
        {
            try {
                $phone = $this->phoneUtil->parse(\request($this->loginFieldName), app()->get('country-code-for-client'));
                if($phone === null)
                {
                    throw new \Exception("phoneUtil->parse(" . request($this->loginFieldName) . ") returned null");
                }
                $this->validatedPhone = $this->phoneUtil->format($phone, PhoneNumberFormat::INTERNATIONAL);
            }catch (\Exception $e)
            {
                report($e);
                $this->validatedPhone  = ' ';
            }
        }
        return $this->validatedPhone;
    }
    private function getLoginMethod(): string
    {
        if(!$this->loginMethod)
        {
            $this->loginMethod = preg_match('/[A-Za-z]/', \request($this->loginFieldName), $matches) ? "email" : "phone";
        }
        return $this->loginMethod;
    }
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     * @throws AuthenticationException
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());
        if($validator->fails())
        {
            return $request->wantsJson()
                ? new JsonResponse(['success' => false, 'messages' => $validator->getMessageBag()->all()], 403)
                : back()->withErrors($validator->errors());
        }
        $user = $this->create($request->all());
        // event(new Registered($user));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse(['success' => true, 'messages' => 'you are registered'], 201)
            : redirect($this->redirectPath());
    }

    /**
     * The user has been registered.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     * @throws AuthenticationException
     * @throws \Exception
     */
    protected function registered(Request $request,User $user)
    {

        $method = $this->getLoginMethod();
        $messages = [];
        if($method === 'phone') {
            $returned = $request->user()->sendPhoneVerificationNotification();
            if(is_object($returned) && $returned instanceof View)
            {
                return $returned;
            }
            $messages['login'] = $request->user()->phoneNumber;
        }else if($method === 'email')
        {
            $request->user()->sendEmailVerificationNotification();
            $messages['login'] = $request->user()->email;
        }else{
            $user->delete();
            throw new AuthenticationException("invalid verification method was given");
        }

        $messages['message'] = __("auth.code_sent");
        return $request->wantsJson() ? new JsonResponse(['success' => true], 200)
             : redirect(route('verification.notice', ['method' => $method]))->with('messages', $messages);

    }
    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
    }
}
