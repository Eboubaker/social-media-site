<?php


namespace App\Http\Collectors;


use App\Models\BusinessProfile;
use App\Models\Morphs\Profileable;
use App\Models\Post;
use App\Models\SocialProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class PostCollector
{
    private Builder $query;

    public function __construct()
    {
        $this->query = Post::query();
    }

    public function get()
    {
        return $this->query->get();
    }

    public function query()
    {
        return $this->query;
    }

    public function forProfile(Profileable $profile)
    {
        $this->query->where([['profileable_type', $profile->getMorphClass()],
                             ['profileable_id'  , $profile->getKey()]]);
    }
    public function forUser(User $user)
    {
        $this->forUserBusinessProfiles($user);
        $this->forUserSocialProfiles($user);
    }
    public function forUserSocialProfiles(User $user)
    {
        // TODO: eagerLoad socialProfiles into the query itself
        $profiles = $user->socialProfiles->map(fn($p)=>$p->getKey());
        if(count($profiles) > 0)
        {
            $this->query->where('profileable_type', $profiles->first()->getMorphClass())->whereIn('profileable_id', $profiles->all());
        }
    }
    public function forUserBusinessProfiles(User $user)
    {
        // TODO: eagerLoad socialProfiles into the query itself
        $profiles = $user->businessProfiles->map(fn($p)=>$p->getKey());
        if(count($profiles) > 0)
        {
            $this->query->where('profileable_type', $profiles->first()->getMorphClass())->whereIn('profileable_id', $profiles->all());
        }
    }
    public function forHashTag(string $hashTag)
    {
        
    }
}