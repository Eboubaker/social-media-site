<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property bool $allow_non_followers_to_comment_on_my_profile_posts
 * @property bool $allow_followers_to_comment_on_my_profile_posts
 * @property bool $allow_followings_to_comment_on_my_profile_posts
 * @property bool $allow_friends_to_comment_on_my_profile_posts
 * 
 * @property bool $allow_non_followers_to_view_my_profile_posts
 * @property bool $allow_followers_to_view_my_profile_posts
 * @property bool $allow_followings_to_view_my_profile_posts
 * @property bool $allow_friends_to_view_my_profile_posts
 * 
 * @property bool $allow_others_to_follow_me
 * @property bool $allow_followings_to_follow_me_back
 * 
 * 
 * 
 * 
 */
class ProfileSettings extends Model
{
    use HasFactory, ModelTraits;

    protected $table = 'profiles_settings';
    
    protected $guarded = [];

    public const CREATED_AT = null;
    public const UPDATED_AT = null;
    public const DELETED_AT = null;

    public function profile():BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }


    public static function permsList()
    {
        return [
            'allow_non_followers_to_comment_on_my_profile_posts' => true,
            'allow_followers_to_comment_on_my_profile_posts' => true,
            'allow_followings_to_comment_on_my_profile_posts' => true,
            'allow_friends_to_comment_on_my_profile_posts' => true,

            'allow_non_followers_to_view_my_profile_posts' => true,
            'allow_followers_to_view_my_profile_posts' => true,
            'allow_followings_to_view_my_profile_posts' => true,
            'allow_friends_to_view_my_profile_posts' => true,

            'allow_others_to_follow_me' => true,
            'allow_followings_to_follow_me_back' => true,
        ];
    }
}
