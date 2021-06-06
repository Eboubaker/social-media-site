<?php

namespace App\Models;

use App\Models\Traits\Commentable;
use App\Models\Traits\HasImages;
use App\Models\Traits\HasVideos;
use App\Models\Traits\Imageable;
use App\Models\Traits\Likeable;
use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, 
    SoftDeletes,

    ModelTraits,
    HasImages,
    HasVideos,
    Commentable,
    Likeable;

    
    public $table = 'comments';
    public const CREATED_AT = "created_at";
    public const UPDATED_AT = "updated_at";
    protected $guarded = [];

    public function commentable()
    {
        return $this->morphTo();
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function commentor()
    {
        return $this->belongsTo(Profile::class, 'commentor_id');
    }
}
