<?php


namespace App\Models\Traits;


use App\Models\Profile;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasAuthor
{
    public function author():BelongsTo
    {
        return $this->belongsTo(Profile::class, 'author_id');
    }
}
