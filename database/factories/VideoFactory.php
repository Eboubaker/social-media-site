<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Morphs\Postable;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Video::class;
    /**
     * @var string
     */
    private static $temp;
    private static $allVideos;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        if(empty(self::$allVideos))
        {
            self::$allVideos = collect(Storage::disk('faker_videos')->files());
        }
        $chosen = Storage::disk('faker_videos')->path(self::$allVideos->random());
        $temp = Storage::disk('temp')->path("tmp");
        if(file_exists($temp))
            unlink($temp);
        copy($chosen, $temp);
        self::$temp = $temp;
        list(0 => $width, 1 => $height, 2 => $type, 'mime' => $mime) = getimagesize(self::$temp);
        return [
            "width" => $width, 
            "height" => $height,
            "size" => filesize(self::$temp),
            "mime" => $mime,
            'type' => $type,
            "seconds" => 20,
            "extension" => mimetoextension($mime),
        ];
        $disk = Storage::disk('faker_videos');
        $files = $disk->files();
        $chosen = $files[random_int(0, count($files)-1)];
        self::$video = $disk->path($chosen);
        $atts = [
            'meta' => (object)["with" => 1024, "height" => 1280],
            'type' => Video::getAllowedTypes()->keys()->first()
        ];
        return $atts;
    }

    public function configure()
    {
        return $this->afterMaking(function(Video $video){
            copy(self::$video, $video->realPath);
        });
    }
}
