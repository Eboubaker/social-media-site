<?php

namespace App\Models;

use App\Models\Morphs\Postable;
use App\Models\Traits\Authorable;
use App\Models\Traits\Commentable;
use App\Models\Traits\HasAuthor;
use App\Models\Traits\Imageable;
use App\Models\Traits\Likeable;
use App\Models\Traits\ModelTraits;
use App\Models\Traits\Videoable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Comment extends Model
{
    use HasFactory, ModelTraits, 
    Commentable, 
    Videoable, 
    Imageable, 
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
