<?php

namespace App\Models\Morphs;

use App\Casts\JsonObject;
use App\Models\BaseModel;
use App\Models\Image;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\DB;

class Postable extends BaseModel
{
    use HasFactory, Commentable;

    public const PKEY = 'id';
    protected $primaryKey = self::PKEY;
    protected $guarded = [];
    // TODO: remove this in production
    protected $fillable = ['id','content', 'public_id', 'profileable_type', 'profileable_id', 'created_at', 'updated_at', 'content'];
    // TODO: in production mode check for unnecessary eager loaded relations, exclude them using $model->without(...)
    protected $with = ['videos', 'images', 'profileable'];

    function __construct(array $attributes = [], $pass = false)
    {
        $this->casts['content'] = JsonObject::class;
        parent::__construct($attributes);
    }
    public function videos(): MorphMany
    {
        return $this->morphMany(Video::class, 'postable');
    }
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'postable');
    }
    public function profileable(): MorphTo
    {
        return $this->morphTo('profileable');
    }

    public function taggedSocialProfiles()
    {
        return $this->morphToMany();
    }

    public function read(User $user)
    {
        DB::table('seen_postables')->insert([
            'postable_id' => $this->getKey(),
            'postable_type' => $this->getMorphClass(),
            'user_id' => $user->getKey(),
            'seen_at' => now()
        ]);
    }

    public function like($profile)
    {
        DB::table('postables_likes')->insert([
            'postable_id' => $this->getKey(),
            'postable_type' => $this->getMorphClass(),
            'profileable_id' => $profile->getKey(),
            'profileable_type' => $profile->getMorphClass(),
            'liked_at' => now()
        ]);
    }

    public function likes()
    {
        return $this->morphToMany(Model::class, 'postable', 'postables_likes')->count();
    }
}
