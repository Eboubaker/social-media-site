<?php

use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// profile channel
Broadcast::channel('App.Models.Profile.{id}', function ($user, $id) {
    info("exists: " . $user->profiles()->where('profiles.id', $id)->exists());
    return $user->profiles()->where('profiles.id', $id)->exists();
});

// post events channel
Broadcast::channel('App.Models.Post.{id}', function (User $user, $id) {
    $profile = $user->activeProfile;
    $post = Post::with('pageable', 'author')->find($id);
    $author = $post->author;
    $pageable = $post->pageable;
    if($pageable instanceof Community)
    {
        /** @var CommunityMember $member */
        if($post->author_id === $author->id
        || $pageable->visitorRole->can(config('permissions.communities.can-view-posts'))
        || ($member = $pageable->members()->where('profile_id', $profile->id)->first()) && $member->can(config('permissions.communities.can-view-posts'))
        )
        {
            return true;
        }
    }
    return false;
});
