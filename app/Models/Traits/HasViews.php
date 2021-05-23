<?php


namespace App\Models\Traits;


use App\Models\PostView;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasViews
{
    public function views():MorphMany
    {
        return $this->hasMany(PostView::class);
    }
}
