<?php


namespace App\Models\Traits;


use App\Models\PostView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasViews
{
    public function views():HasMany
    {
        return $this->hasMany(PostView::class);
    }

    public function bootHasViews()
    {
        static::deleting(function(Model $viewable){
            assertInTransaction();
            $viewable->views()->delete();
        });
    }
}
