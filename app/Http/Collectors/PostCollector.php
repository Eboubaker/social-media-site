<?php


namespace App\Http\Collectors;


use App\Models\BusinessProfile;
use App\Models\Morphs\Profileable;
use App\Models\Post;
use App\Models\SocialProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpKernel\Profiler\Profile;

class PostCollector
{
    private Builder $query;

    public function __construct()
    {
        $this->query = Post::query();
    }

    /**
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function collect()
    {
        return $this->query->get();
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return $this->query;
    }

    /**
     * @param Profileable $profile
     * @return $this
     */
    public function forProfile(Profileable $profile)
    {
        $this->query->where([['profileable_type', $profile->getMorphClass()],
                             ['profileable_id'  , $profile->getKey()]]);
        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function forUser(User $user)
    {
        $this->forUserBusinessProfiles($user);
        $this->forUserSocialProfiles($user);
        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function forUserSocialProfiles(User $user)
    {
        // TODO: eagerLoad socialProfiles into the query itself
        $profiles = $user->socialProfiles->map(fn($p)=>$p->getKey());
        if(count($profiles) > 0)
        {
            $this->query->where('profileable_type', $profiles->first()->getMorphClass())->whereIn('profileable_id', $profiles->all());
        }
        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function forUserBusinessProfiles(User $user)
    {
        // TODO: eagerLoad socialProfiles into the query itself
        $profiles = $user->businessProfiles->map(fn($p)=>$p->getKey());
        if(count($profiles) > 0)
        {
            $this->query->where('profileable_type', $profiles->first()->getMorphClass())->whereIn('profileable_id', $profiles->all());
        }
        return $this;
    }

    /**
     * @param string $hashTag
     * @return $this
     */
    public function forHashTag(string $hashTag)
    {
        // TODO: maybe... just maybe.. search in comments of the posts too ???
        $this->query->whereRaw("JSON_SEARCH(content, 'one', ?, '', '$.body')", "%#$hashTag%");
        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function whereUserTagged(User $user)
    {

    }
    public function whereProfileTagged(Profile $profile)
    {
        $this->query->where();
    }
}