<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Morphs\Postable;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
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
        $morph = random_int(0, 100) > 50 ? Post::query()->offset(random_int(0,Post::count()))->first()
            : Comment::query()->offset(random_int(0,Comment::count()))->first();
        $morph = $morph ?: Post::make();
        $uuid = Str::uuid()->toString();

        $disk = Storage::disk('faker_videos');
        $files = $disk->files();
        $chosen = $files[random_int(0, count($files)-1)];
        self::$video = $disk->path($chosen);
        $hash = hash('sha256', $disk->get($chosen));
        return [
            Video::PKEY => $uuid,
            'sha256' => $hash,
            Postable::$morphRelationName.'_type' => $morph->getMorphClass(),
            Postable::$morphRelationName.'_id' => $morph->getKey() ?? 0,
            'meta' => json_encode(new \stdClass(), JSON_THROW_ON_ERROR),
            'type' => Video::getAllowedTypes()->keys()->first()
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(Video $video){
            copy(self::$video, $video->realPath);
        });
    }
}
