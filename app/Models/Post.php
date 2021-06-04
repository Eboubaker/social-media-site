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
use App\Models\Traits\Viewable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Post extends Model implements HasAttachementsInterface
{
    use HasFactory, 
    HasAuthor, 
    Commentable, 
    HasImages, 
    HasVideos, 
    ModelTraits, 
    SoftDeletes, 
    Likeable,
    Viewable, 
    Sluggable;

    protected $guarded = [];

    public function __construct(array $attributes = [], $pass = false)
    {
        parent::__construct($attributes, $pass);
    }

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
    public function getUrlAtrribute(): string
    {
        return route('posts.show', $this->slug);
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
}
