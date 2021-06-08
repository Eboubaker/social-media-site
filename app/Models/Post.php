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
 * @property Community|Profile $pageable
 * 
 * @mixin \Eloquent
 */
class Post extends Model implements HasAttachementsInterface
{
    use HasFactory, 
    HasUUid62,
    SoftDeletes,
    Sluggable,
    ValidatingTrait,

    ModelTraits,
    Urlable,
    HasAuthor, 
    HasImages,
    HasVideos,
    Commentable,
    Viewable,
    Likeable;

    protected $rules = [
        '*' => 'allowed_attributes:slug,uuid62,author_id,title,body,pageable_id,pageable_type',
        'author_id' => ['exists:App\Models\Profile,id'],
        'title' => ['required', 'min:3', 'max:255'],
        'body' => ['max:10000'],
    ];
    protected $validationMessages = [
        'author_id.exists' => "post author not found.",
    ];
    protected $validationAttributeNames = [
        'pageable_id' => 'liker'
    ];
    protected $throwValidationExceptions = true;

    public function __construct($atts=[])
    {
        parent::__construct($atts);
        $this->rules['pageable_id'][] = new PolymorphicRelationExists($this, 'pageable');
    }
    protected $guarded = [];

    public function pageable()
    {
        return $this->morphTo('pageable');
    }

    public function deleteAttachements()
    {
        $post = $this;
        DB::transaction(function() use ($post){
            $post->videos()->cursor()->each(function(Video $video){
                $video->delete();
            });
            $post->images()->cursor()->each(function(Image $image){
                $image->delete();
            });
        });
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
}
