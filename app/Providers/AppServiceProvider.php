<?php

namespace App\Providers;

use App\Models\Events\ModelEvents;
use App\Models\Image;
use App\Models\Morphs\Postable;
use App\Models\Morphs\PostableAttachement;
use App\Models\Morphs\Profileable;
use App\Models\ProfileImage;
use App\Models\Video;
use App\Observers\PostableAttachementObserver;
use App\Observers\PostableObserver;
use App\Observers\ProfileableObserver;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->when([Video::class])
//            ->needs(FilesystemAdapter::class)
//            ->give(Storage::disk('videos'));
//        $this->app->when([Image::class])
//            ->needs(FilesystemAdapter::class)
//            ->give(Storage::disk('images'));
//        $this->app->when([ProfileImage::class])
//            ->needs(FilesystemAdapter::class)
//            ->give(Storage::disk('profile_images'));

        if(strtolower(date_default_timezone_get()) !== "africa/algiers")
        {
            date_default_timezone_set("Africa/Algiers");
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
