<?php

use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
Route::get('/c/{community:name}/p/{post:uuid62}/r/{comment:uuid62}', [CommentController::class, 'show'])->name('community.posts.comments.show');
Route::get('/u/{profile:username}/p/{post:uuid62}/r/{comment:uuid62}', [CommentController::class, 'show'])->name('community.posts.comments.show');

Route::get('/c/{community:name}', [CommunityController::class, 'show'])->name('community.show');
Route::get('/c/{community:name}/p/{post:uuid62}/{post_by_slug}', [PostController::class, 'show'])->name('community-post.show');
Route::get('/u/{profile:username}/p/{post:uuid62}/{post_by_slug}', [PostController::class, 'show'])->name('profile-post.show');
Route::get('/u/{profile:username}', [ProfileController::class, 'show'])->name('profile.show');
#endregion

#region browser redirections
// Route::get('/r/{comment:uuid62}', [CommentController::class, 'redirectToPage']);
// Route::get('/r/{comment}', [CommentController::class, 'redirectToPage']);

// Route::get('/p/{post:uuid62}/{garbage?}', [PostController::class, 'redirectToPage'])->name('post.show');
// Route::get('/c/{community:name}/p/{post:uuid62}/{garbage?}', [PostController::class, 'redirectToPage']);
// Route::get('/u/{profile:username}/p/{post:uuid62}/{garbage?}', [PostController::class, 'redirectToPage']);
#endregion

#region form requests
Route::get('/community/create', [CommunityController::class, 'create'])->name('community.create');
Route::get('/c/{community:name}/edit', [CommunityController::class, 'edit'])->name('community.edit');
#endregion

#region backend submits
Route::post('/c/{comment}/update', [CommentController::class, 'update'])->name('comments.update');

Route::post('/p/{post}/like', [LikeController::class, 'likePost'])->name('post.like');
Route::post('/p/{post}/unlike', [LikeController::class, 'unlikePost'])->name('post.unlike');

Route::post('/r/{comment}/like', [LikeController::class, 'likeComment'])->name('comment.like');
Route::post('/r/{comment}/unlike', [LikeController::class, 'unlikeComment'])->name('comment.unlike');

Route::post('/p/{post}/comment', [CommentController::class, 'storeComment'])->name('post.storeComment');
Route::post('/r/{comment}/comment', [CommentController::class, 'storeReply'])->name('comment.storeComment');
Route::post('/r/{comment}/update', [CommentController::class, 'update'])->name('comment.update');

Route::post('/c/{community}/posts', [PostController::class, 'storeCommunityPost'])->name('community.posts.store');
Route::post('/u/posts', [PostController::class, 'storeProfilePost'])->name('profile.posts.store');
Route::post('/community', [CommunityController::class, 'store'])->name('community.store');
Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');

Route::put('/community/{community}', [CommunityController::class, 'update'])->name('community.update');
Route::delete('/community/{community}', [CommunityController::class, 'destroy'])->name('community.destory');


Route::post('/c/{community}/posts', [PostController::class, 'storeCommunityPost'])->name('community.posts.store');
Route::post('/u/posts', [PostController::class, 'storeProfilePost'])->name('profile.posts.store');
#endregion

#region backend requests
Route::post('/token/update', [ApiTokenController::class, 'update'])->name('token.update');
Route::get('/permissions/{community}', [PermissionsController::class, 'permissionsForCommunity'])->name('permissions.forCommunity');
Route::get('/permissions', [PermissionsController::class, 'permissionsList'])->name('permissions.all');
Route::post('/profile/switch/{profile}', [ProfileController::class, 'switch'])->name('profile.switch');
Route::post('/api/setLocale', [\App\Http\Controllers\AppLanguageController::class, 'update'])->name('locale.update');
#endregion

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

