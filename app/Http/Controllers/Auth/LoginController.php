<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\Phone;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use libphonenumber\PhoneNumberFormat;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $loginFieldName;
    private $validatedPhone;
    private $phoneUtil;
    private $loginMethod;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->phoneUtil = app('phoneNumberUtil');
        $this->loginFieldName = 'login';
    }

    public function username()
    {
        return $this->getLoginMethod();
    }

    private function getLoginMethod(): string
    {
        if(!$this->loginMethod)
        {
            $this->loginMethod = preg_match('/[A-Za-z]/', \request($this->loginFieldName), $matches) ? "email" : "phone";
        }
        return $this->loginMethod;
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        
        $validator = $this->validator($request->all());
        if($validator->fails())
        {
            return $request->wantsJson()
                   ? response()->json(["success" => false, "errors" => $validator->errors()->all()])
                   : back()->withErrors($validator->errors());
        }
        $request[$this->username()] = $request->get('login');
        if(isset($request['phone']))
        {
            $request['phone'] = $this->getValidatedPhone();
        }
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'login' => [trans('auth.failed')],
        ]);
    }
    
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'password' => ['required'],
            'remember_me' => []
        ];
        if($this->username() === 'email')
        {
            $rules['email'] = ['required', 'min:4', 'email'];
            $data['email'] = $data[$this->loginFieldName];
            unset($data['login']);
        }else{
            $rules['phone'] = ['required', 'string', 'min:4'];
            $data['phone'] = $this->getValidatedPhone();
            unset($data[$this->loginFieldName]);
        }
        return Validator::make($data, $rules);
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
}
