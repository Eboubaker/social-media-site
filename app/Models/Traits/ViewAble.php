<?php


namespace App\Models\Traits;

use App\Models\PostView;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait Viewable
{
    public static function bootViewable()
    {
        static::deleting(function(Model $viewable){
            $viewable->cascadeDeleteRelation(PostView::make(), 'views');
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $viewable){
                $viewable->restoreCascadedRelation('views');
            });
        }
    }

    public function views():HasMany
    {
        return $this->hasMany(PostView::class);
    }
}
