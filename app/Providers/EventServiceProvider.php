<?php

namespace App\Providers;

use App\Events\NewFollowCreated;
use App\Events\PostLiked;
use App\Events\ProfileFollowed;
use App\Events\StorableRemoved;
use App\Listeners\PostLikedListener;
use App\Listeners\ProfileFollowedListener;
use App\Listeners\StorableRemovedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
        //    SendEmailVerificationNotification::class,

        ],
        StorableRemoved::class => [
            StorableRemovedListener::class,
        ],
        ProfileFollowed::class => [
            ProfileFollowedListener::class,
        ],
        PostLiked::class => [
            PostLikedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
