<?php

namespace App\Models;

use App\Models\Traits\Commentable;
use App\Models\HasAttachements as HasAttachementsInterface;
use App\Models\Traits\HasAttachements;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasImages;
use App\Models\Traits\HasVideos;
use App\Models\Traits\HasViews;
use App\Models\Traits\Likeable;
use App\Models\Traits\ModelTraits;
use App\Models\Traits\Urlable;
use App\Models\Traits\Viewable;
use App\Rules\PageAbleExists;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableObserver;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Watson\Validating\ValidatingTrait;

class Post extends Model implements HasAttachementsInterface
{
    use HasFactory, 
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
        'author_id' => ['exists:App\Models\Profile,id'],
        'pageable_id' => [], // in constructor
        'title' => ['required', 'min:3', 'max:255'],
        'body' => ['max:10000'],
    ];
    protected $validationMessages = [
        'author_id.exists' => "post author not found.",
    ];
    protected $throwValidationExceptions = true;

    public function __construct(...$atts)
    {
        parent::__construct(...$atts);
        $this->rules['pageable_id'][] = new PageAbleExists($this);
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
        if($this->pageable instanceof Community)
        {
            return route('community-post.show', [$this->pageable->name, $this->slug]);
        }else if($this->pageable_type instanceof Profile){
            return route('profile-post.show', [$this->pageable->username, $this->slug]);
        }
        return '';
    }
}
