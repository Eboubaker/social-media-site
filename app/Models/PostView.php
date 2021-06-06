<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostView extends Model
{
    use HasFactory,
    SoftDeletes,
    ModelTraits;

    public const CREATED_AT = 'viewed_at';
    public const UPDATED_AT = null;

    protected $guarded = [];

    public function viewer()
    {
        return $this->belongsTo(Profile::class, 'viewer_id');
    }
    public function post()
    {
        return $this->hasOne(Post::class);
    }
}
