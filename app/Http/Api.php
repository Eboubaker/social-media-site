<?php


namespace App\Http;


use App\Http\Controllers\FeedController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

class Api
{
    public static function routes()
    {
        Route::group([
            'prefix' => 'api',
        ], function(){
            Route::post('feed', [FeedController::class, 'index'])->name('feed.index');
            Route::post('posts', [PostController::class, 'store'])->name('posts.store');
        });
    }
}