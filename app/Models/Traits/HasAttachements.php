<?php
namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasAttachements
{
    public function bootHasAttachements()
    {
        static::deleting(function(Model $attacheable){
            assertInTransaction();
            $attacheable->deleteAttachements();
        });
    }
}