<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use HasFactory, 
    SoftDeletes,
    ModelTraits;

    public const CREATED_AT = 'liked_at';
    public const UPDATED_AT = null;

    protected $guarded = [];


    public function likeable()
    {
        return $this->morphTo();
    }

    public function liker()
    {
        return $this->belongsTo(Profile::class, 'liker_id');
    }
}
