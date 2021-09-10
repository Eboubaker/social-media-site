<?php


namespace App\Models\Traits;


use App\Models\PostView;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanView
{
    public static function bootCanView()
    {
        static::deleting(function(Model $viewer){
            $viewer->cascadeDeleteRelation(PostView::make(), 'views');
        });
        if(self::canBeSoftDeleted())
        {
            static::restored(function(Model $viewer){
                $viewer->restoreCascadedRelation('views');
            });
        }
    }
    
    public function views():HasMany
    {
        return $this->hasMany(PostView::class, 'viewer_id');
    }
}
