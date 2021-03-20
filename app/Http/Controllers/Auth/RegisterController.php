<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ProfileImage;
use App\Models\UserSettings;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $method = preg_match('/[A-Za-z]/', $data['login'], $matches) ? "email" : "phone";
        $rules = [
            'password' => ['required', 'string', 'min:8'],
        ];
        if($method === 'email')
        {
            $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:'.User::TABLE.'.email'];
            $data['email'] = $data['login'];
            unset($data['login']);
        }else{
            $rules['phone'] = ['required', 'string', 'phone', 'max:16', 'unique:'.User::TABLE.'.phone'];
            $data['phone'] = $data['login'];
            unset($data['login']);
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
        if(isset($data['email']))
        {
            $userData['email'] = $data['email'];
        }
        if(isset($data['phone']))
        {
            $userData['phone'] = $data['phone'];
        }
        $user = User::create($userData);
        $user->settings()->create(UserSettings::getDefault());
        $user->profileImage()->create(ProfileImage::getDefault());
        return $user;
    }
}
