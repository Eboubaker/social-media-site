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
    private static $video;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        Log::debug("Entering VideoFactory definition");
        $disk = Storage::disk('faker_videos');
        $files = $disk->files();
        $chosen = $files[random_int(0, count($files)-1)];
        self::$video = $disk->path($chosen);
        $atts = [
            'meta' => (object)["with" => 1024, "height" => 1280],
            'type' => Video::getAllowedTypes()->keys()->first()
        ];
        Log::debug("Leaving VideoFactory definition");
        return $atts;
    }

    public function configure()
    {
        return $this->afterMaking(function(Video $video){
            Log::debug("Entering VideoFactory afterMaking");
            $video->makeUuid();
            copy(self::$video, $video->realPath);
            Log::debug("Leaving VideoFactory afterMaking");
        });
    }
}
