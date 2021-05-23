<?php


namespace App\Models\Traits;

use Illuminate\Support\Facades\Storage;

trait HasStorageUrl
{
    use HasStorageFile;
    
    public function getUrlAttribute(): string
    {
        return Storage::disk($this->storage)->url($this->fileName);
    }
}
