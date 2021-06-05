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
            assertInTransaction();
            if($viewer->forceDeleting())
            {
                $viewer->views()->delete();
            }
        });
    }
    
    public function views():HasMany
    {
        return $this->hasMany(PostView::class, 'viewer_id');
    }

    
}
