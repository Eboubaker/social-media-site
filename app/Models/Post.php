<?php

namespace App\Models;

use App\Models\Traits\Commentable;
use App\Models\HasAttachements as HasAttachementsInterface;
use App\Models\Traits\HasAttachements;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasImages;
use App\Models\Traits\HasUUid62;
use App\Models\Traits\HasVideos;
use App\Models\Traits\Likeable;
use App\Models\Traits\ModelTraits;
use App\Models\Traits\Urlable;
use App\Models\Traits\Viewable;
use App\Rules\PolymorphicRelationExists;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Watson\Validating\ValidatingTrait;
/**
 * App\Models\Post
 *
 * @property Community|Profile $pageable
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $author_id
 * @property string $title
 * @property string $uuid62
 * @property string $pageable_type
 * @property int $pageable_id
 * @property string|null $body
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $reason_deleted
 * @property-read \App\Models\Profile|null $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read mixed $attachements
 * @property-read mixed $created
 * @property-read string $url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Image[] $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Like[] $likes
 * @property-read int|null $likes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Video[] $videos
 * @property-read int|null $videos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PostView[] $views
 * @property-read int|null $views_count
 * @method static \Database\Factories\PostFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Post findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Query\Builder|Post onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePageableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post wherePageableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereReasonDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUuid62($value)
 * @method static \Illuminate\Database\Query\Builder|Post withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Post withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Query\Builder|Post withoutTrashed()
 */
class Post extends Model
{
    use HasFactory, 
    HasUUid62,
    SoftDeletes,
    Sluggable,

    ModelTraits,
    Urlable,
    HasAuthor, 
    HasImages,
    HasVideos,
    Commentable,
    Viewable,
    Likeable;


    protected $guarded = [];


    public function pageable()
    {
        return $this->morphTo('pageable');
    }

    public function getAttachementsAttribute()
    {
        $this->images->merge($this->videos);
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title'],
                'maxLengthKeepWords' => 80
            ],
        ];
    }
    public function sluggableEvent(): string
    {
        // /**
        //  * Default behaviour -- generate slug before model is saved.
        //  */
        return SluggableObserver::SAVING;

        /**
         * Optional behaviour -- generate slug after model is saved.
         * This will likely become the new default in the next major release.
         */
        // return SluggableObserver::SAVED;
    }

    public function getUrlAttribute():string
    {
        if($this->pageable_type === Community::make()->getMorphClass())
        {
            return route('community-post.show', [$this->pageable->name, $this->uuid62, $this->slug]);
        }else if($this->pageable_type  === Profile::make()->getMorphClass()){
            return route('profile-post.show', [$this->pageable->username, $this->uuid62, $this->slug]);
        }
        return '';
    }
    public function viewCountForCurrent():int
    {
        return DB::table('post_views')
                ->where('viewer_id', Profile::current_id())
                ->where('post_id', $this->id)
                ->first('viewed_count')->viewed_count ?? 0;
    }
}
