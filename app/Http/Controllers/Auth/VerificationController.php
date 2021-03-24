<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Verify\Service;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

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
    protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * @var Service
     */
    protected $verify;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Service $verify)
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
        $this->verify = $verify;
    }

    /**
     * Show the verification required notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectPath())
            : view('auth.verify');
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
        if($method === 'phone') {
            if ($request->user()->hasVerifiedPhone()) {
                return redirect($this->redirectPath());
            }

            $code = $request->post('code');
            $phone = $request->user()->phoneNumber;

            $verification = $this->verify->checkVerification($phone, $code);

            if ($verification->isValid()) {
                $request->user()->markPhoneAsVerified();
                return redirect($this->redirectPath());
            }

            $errors = new MessageBag();
            foreach ($verification->getErrors() as $error) {
                $errors->add('verification', $error);
            }

            return view('auth.verify')->withErrors($errors);
        }

        if($method === 'email') {
            if (!hash_equals((string)$request->route('id'), (string)$request->user()->getKey())) {
                throw new AuthorizationException;
            }

            if (!hash_equals((string)$request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
                throw new AuthorizationException;
            }

            if ($request->user()->hasVerifiedEmail()) {
                return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect($this->redirectPath());
            }

            if ($request->user()->markEmailAsVerified()) {
                event(new Verified($request->user()));
            }

            if ($response = $this->verified($request)) {
                return $response;
            }

            return $request->wantsJson()
                ? new JsonResponse([], 204)
                : redirect($this->redirectPath())->with('verified', true);
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws AuthorizationException
     */
    public function resend(Request $request)
    {
        $method = $this->getLoginMethod($request);
        if($method === 'email') {
            if ($request->user()->hasVerifiedEmail()) {
                return $request->wantsJson()
                    ? new JsonResponse(['redirect' => $this->redirectPath()], 204)
                    : redirect($this->redirectPath());
            }
            $request->user()->sendEmailVerificationNotification();
        }else if($method === 'phone')
        {
            if ($request->user()->hasVerifiedPhone()) {
                return redirect($this->redirectPath());
            }
            $request->user()->sendEmailVerificationNotification();
            $phone = $request->user()->phoneNumber;
            $verification = $this->verify->startVerification($phone, 'sms');

            if (!$verification->isValid()) {

                $errors = new MessageBag();
                foreach($verification->getErrors() as $error) {
                    $errors->add('verification', $error);
                }
                return redirect('/verify')->withErrors($errors);
            }
            $messages = new MessageBag();
            $messages->add('verification', "Another code was sent to $phone");

            return redirect('/verify')->with('messages', $messages);
        }else{
            throw new AuthorizationException("invalid verification method was given");
        }
        return $request->wantsJson()
            ? new JsonResponse(['resent' => true], 202)
            : back()->with('resent', true);
    }
    private function getLoginMethod(Request $request)
    {
        return $request->post('verificationMethod');
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

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
}
