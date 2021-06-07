<?php

namespace App\Models;

use App\Models\Traits\ModelTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileSettings extends Model
{
    use HasFactory, ModelTraits;

    protected $table = 'profiles_settings';
    
    protected $guarded = [];


    public function profile():BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
