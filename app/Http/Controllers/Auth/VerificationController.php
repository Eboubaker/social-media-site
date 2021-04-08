<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Verify\Service;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo;
    /**
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
        $this->middleware('auth');
//        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
        $this->verify = $verify;
        $this->redirectTo = route('profile-form');
//        route = verification.notice
//        [
//            "verification?" => "error_text"
//        ]
//        [
//            "method" => "email|phone",
//            "messages?" => [
//                "login?" => "email_text|phone_number",
//                "message?" => "text"
//            ]
//        ];
    }

    /**
     * Show the verification required notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show(Request $request)
    {
        $method = \request('method');
        $user = $request->user();
        $ev = $user->hasVerifiedEmail();
        $pv = $user->hasVerifiedPhone();
        if(($method === 'email' && $ev) ||
           ($method === 'phone' && $pv))
        {
            return redirect($this->redirectPath());
        }
        $login = null;
        if($method === 'email')
            $login = $user->email;
        else if($method === 'phone')
            $login = $user->phoneNumber;
        return view('auth.verify', [
            'messages' => [
                "message" =>__('auth.code_sent'),
                "login" => $login
            ],
            "method" => $method
        ]);
    }

    /**
     * Mark the authenticated user's login method(email or phone) as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        $method = $this->getLoginMethod($request);
        $errors = new MessageBag();
        if($method === 'phone')
        {
            if ($request->user()->hasVerifiedPhone())
            {
                return redirect($this->redirectPath());
            }

            $code = $request->post('code');
            $phone = $request->user()->phoneNumber;

            $verification = $this->verify->checkVerification($phone, $code);

            if ($verification->isValid())
            {
                $wasNotVerified = !$request->user()->isVerified();
                $result = $request->user()->markPhoneAsVerified();
                if ($result && $wasNotVerified) {
                    event(new Verified($request->user()));
                }
                return \request()->wantsJson()
                    ? new JsonResponse(["success" => true, "messages" => ["result" => "verification was successful"]], 200)
                    : redirect($this->redirectPath());
            }
            $errors->add('result', __("verification code does not match"));
            return \request()->wantsJson()
                ? new JsonResponse(["success" => false, "messages" => $errors->all()], 406)
                : view('auth.verify')->with("method", $method)->withErrors($errors);
        }

        if($method === 'email')
        {
            if(request('code') && \request('code') !== $request->user()->getCodeForVerification())
            {
                $errors->add('result', __("verification code does not match"));
                return \request()->wantsJson()
                    ? new JsonResponse(["success" => false, "messages" => $errors->all()], 406)
                    : view('auth.verify')->with("method", $method)->withErrors($errors);
            }
            if ($request->user()->hasVerifiedEmail())
            {
                return $request->wantsJson()
                    ? new JsonResponse(["success" => true, "messages"=>[]], 301)
                    : redirect($this->redirectPath());
            }
            $wasNotVerified = !$request->user()->isVerified();
            $result = $request->user()->markEmailAsVerified();
            if ($result && $wasNotVerified) {
                event(new Verified($request->user()));
            }
            $this->verified($request);
            return $request->wantsJson()
                ? new JsonResponse(["success" => true, "messages" => ["result" => "verification was successful"]], 201)
                : redirect($this->redirectPath());
        }
        throw new AuthorizationException("invalid verification method was given");
    }

    /**
     * an event called when The user has been verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function verified(Request $request)
    {
        //
    }

    /**
     * Resend the verification notification using the user's login method (either via phone or email).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws AuthorizationException
     */
    public function resend(Request $request)
    {
        $method = $this->getLoginMethod($request);
        if($method === 'phone') {
            $returned = $request->user()->sendPhoneVerificationNotification();
            if(is_object($returned) && $returned instanceof \Illuminate\View\View)
            {
                return $returned;
            }
            $messages['login'] = $request->user()->phoneNumber;
        }else if($method === 'email')
        {
            $request->user()->sendEmailVerificationNotification();
            $messages['login'] = $request->user()->email;
        }else{
            throw new AuthenticationException("invalid verification method was given");
        }
        $messages['message'] = __("auth.code_sent");
        return $request->wantsJson()
            ? new JsonResponse(['success' => true], 200)
            : redirect(route('verification.notice', ['method' => $method]))->with('messages', $messages);
    }
    private function getLoginMethod(Request $request)
    {
        return request('method');
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
