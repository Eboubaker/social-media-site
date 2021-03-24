<?php

use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;


// anything that does NOT start with "storage/" (which is where we store videos & images)
// will be mapped to vue routers

//$i = imagecreatefrompng('D:\Users\MCS\Downloads\1044147.png');
//imagewebp($i, "C:\Users\me\Pictures\Camera Roll\out.webp");
Auth::routes();





Route::get('/sms/send/{to}', function(\Vonage\Client $nexmo, $to){
    $message = $nexmo->message()->send([
        'to' => $to,
        'from' => '@leggetter',
        'text' => 'PIN CODE #5145'
    ]);
    Log::info('sent message: ' . $message['message-id']);
});





//-- Verification Routes --//
Route::get('/email/verify', function () {
    // TODO: create this view
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    // TODO: set the proper redirection
    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
