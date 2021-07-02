<?php

namespace App\Listeners;

use App\Events\StorableRemoved;
use App\Models\Image;
use App\Models\Video;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StorableRemovedListener implements ShouldQueue
{
    public function handle($id, $type, $extension)
    {
        if($type === 'Image')
        {
            (new Image(compact('id', 'extension')))->trashFile();
        }else if($type === 'Video'){
            (new Video(compact('id', 'extension')))->trashFile();
        }
    }
}
