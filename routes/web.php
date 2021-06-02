<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// set default locale
// Group all routes with the locale
// NOTE: API routes should not be added here instead they should be in ~/routes/api.php

App\Http\Api::routes();


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



#region browser urls
Route::get('/c/{community:name}', [CommunityController::class, 'show'])->name('community.show');
Route::get('/p/{post:slug}', [PostController::class, 'redirectToPage'])->name('post.show');
Route::get('/c/{community:name}/p/{post:slug}', [PostController::class, 'show'])->name('community-post.show');
Route::get('/u/{profile:username}/p/{post:slug}', [PostController::class, 'show'])->name('profile-post.show');
#endregion

#region form requests
Route::get('/community/create', [CommunityController::class, 'create'])->name('community.create');

Route::get('/c/{community:name}/edit', [CommunityController::class, 'edit'])->name('community.edit');
#endregion

#region backend submits
Route::post('/community', [CommunityController::class, 'store'])->name('community.store');
Route::put('/community/{community}', [CommunityController::class, 'update'])->name('community.update');
Route::delete('/community/{community}', [CommunityController::class, 'destroy'])->name('community.destory');
#endregion

Route::post('/api/setLocale', [\App\Http\Controllers\AppLanguageController::class, 'update'])->name('locale.update');


// redirect with default locale if no locale is in the url
Route::get('/', function () {
    return view('landing');
})->name('landing');






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

