<?php

namespace App\Models;

use App\Exceptions\FileNotDeletedException;
use App\Models\Traits\Commentable;
use App\Models\Traits\HasAttachements;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasViews;
use App\Models\Traits\Imageable;
use App\Models\Traits\Likeable;
use App\Models\Traits\ModelTraits;
use App\Models\Traits\Videoable;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableObserver;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements HasAttachements
{
    use HasFactory, 
    HasAuthor, 
    HasViews, 
    Commentable, 
    Imageable, 
    Videoable, 
    ModelTraits, 
    SoftDeletes, 
    Likeable, 
    Sluggable;

    protected $guarded = [];
    public $table = 'posts';


    public static function boot()
    {
        parent::boot();
        static::deleting(function(Post $post){
            $post->deleteAttachements();
        });
    }
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
        try{
            if(!unlink($this->realPath))
            {
                throw new Exception();
            }
        }catch(\Throwable $e)
        {
            throw new FileNotDeletedException("not deleted: " . $this->realpath);
        }
    }
    public function getAttachementsAttribute()
    {
        $this->videos->merge($this->images);
    }
    public function getUrlAtrribute(): string
    {
        return route('posts.show', $this->slug);
    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['id', 'title']
            ],
            'maxLengthKeepWords' => 80
        ];
    }
    public function sluggableEvent(): string
    {
        // /**
        //  * Default behaviour -- generate slug before model is saved.
        //  */
        // return SluggableObserver::SAVING;

        /**
         * Optional behaviour -- generate slug after model is saved.
         * This will likely become the new default in the next major release.
         */
        return SluggableObserver::SAVED;
    }
}
