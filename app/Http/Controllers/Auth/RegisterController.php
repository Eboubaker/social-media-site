<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ProfileImage;
use App\Models\UserSettings;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\Phone;
use App\Verify\Service;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

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
        if($this->getLoginMethod($data) === 'email')
        {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:'.User::TABLE.',email'];
            $data['email'] = $data[$this->loginFieldName];
            unset($data['login']);
        }else{
            $rules['phone'] = ['required', 'string', new Phone, 'max:16', 'unique:'.User::TABLE.',phone'];
            $data['phone'] = $data[$this->loginFieldName];
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
        if($this->getLoginMethod($data) === 'email')
        {
            $userData['email'] = $data[$this->loginFieldName];
        }else{
            $userData['phone'] = $data[$this->loginFieldName];
        }
        return DB::transaction(function() use ($userData) {
            $user = User::create($userData);
            $user->settings()->create(UserSettings::getDefault());
            return $user;
        });
    }

    private function getLoginMethod(array $data)
    {
        return preg_match('/[A-Za-z]/', $data[$this->loginFieldName], $matches) ? "email" : "phone";
    }
    public function showRegistrationForm()
    {
        return view('auth.register-test');
    }
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }
    /**
     * The user has been registered.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     * @throws AuthenticationException
     */
    protected function registered(Request $request, $user)
    {
        $method = $this->getLoginMethod($request->all());
        $messages = new MessageBag();
        if($method === 'phone') {
            // --------- Phone auth can be changed here
            $verification = $this->verify->startVerification($user->phone_number, $request->post('channel', 'sms'));
            if (!$verification->isValid()) {
                $user->delete();
                $errors = new MessageBag();
                foreach ($verification->getErrors() as $error) {
                    $errors->add('verification', $error);
                }
                return view('auth.register')->withErrors($errors);
            }
            // ---------
            $messages->add('verification', "Code sent to {$request->user()->phoneNumber}");
        }else if($method === 'email')
        {
            $request->user()->sendEmailVerificationNotification();
            $messages->add('verification', "Code sent to {$request->user()->email}");
        }else{
            $user->delete();
            throw new AuthenticationException("invalid verification method was given");
        }
        return redirect(route('verification.notice'))->with('messages', $messages);
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
