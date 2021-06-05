<?php


namespace App\Models\Traits;

use App\Models\PostView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Viewable
{
    public static function bootViewable()
    {
        static::deleting(function(Model $viewable){
            assertInTransaction();
            if($viewable->forceDeleting())
            {
                $viewable->views()->delete();
            }
        });
    }

    public function views():HasMany
    {
        return $this->hasMany(PostView::class);
    }
}
