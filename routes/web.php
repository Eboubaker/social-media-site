<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

// set default locale
// Group all routes with the locale
// NOTE: API routes should not be added here instead they should be in ~/routes/api.php

App\Http\Api::routes();


Route::group([
    'prefix' => '{locale}',
], function() {
    Route::get("/posts/create", [PostController::class, "create"])->name('posts.create');

    //-- Legal stuff
    Route::get('/terms',function(){
        return "The terms blade-view";
    })->name('legal.terms');
    Route::get('/privacy',function(){
        return "The privacy blade-view";
    })->name('legal.privacy');

    //-- Authentication Routes --//
    Auth::routes();

    //-- Custom Verification Routes --//
    Route::post('/verify/attempt', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/verify/resend', [VerificationController::class, 'resend'])->name('verification.resend');
    Route::get('/verify/{method}/notice', [VerificationController::class, 'show'])->name('verification.notice');

    //--- AUTH TEST
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/feed',function(){
        return view('feed');
    });
    Route::get('/play',function(){
        return view('welcome');
    });
    Route::get('/profile-form', [RegisterController::class, 'profile-form'])->name('profile-form');
    Route::get('/test', function()
    {
        return view('test');
    });
});
Route::post('/api/setLocale', [\App\Http\Controllers\AppLanguageController::class, 'update'])->name('locale.update');


// redirect with default locale if no locale is in the url
Route::get('/', function () {
    return redirect(app('locale-for-client'));
});
\Illuminate\Support\Facades\URL::defaults(['locale' => app('locale-for-client')]);






//$i = imagecreatefrompng('D:\Users\MCS\Downloads\1044147.png');
//imagewebp($i, "C:\Users\me\Pictures\Camera Roll\out.webp");






// Route::get('/sms/send/{to}', function(\Vonage\Client $nexmo, $to){
//     $message = $nexmo->message()->send([
//         'to' => $to,
//         'from' => '@leggetter',
//         'text' => 'PIN CODE #5145'
//     ]);
//     Log::info('sent message: ' . $message['message-id']);
// });

