<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Morphs\Postable;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mockery\Exception;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;
    private static $image;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Exception
     */
    public function definition()
    {
        $uuid = Str::uuid();
        $morph = random_int(0, 100) > 50 ? Post::offset(random_int(0,Post::count()))->first()
            : Comment::offset(random_int(0,Comment::count()))->first();
        $morph = $morph ?: Post::factory()->create();

        $disk = Storage::disk('faker_images');
        $files = $disk->files();
        $chosen = $files[random_int(0, count($files)-1)];
        self::$image = $disk->path($chosen);
        $hash = hash('sha256', $disk->get($chosen));
        return [
            Image::PKEY => $uuid,
            'sha256' => $hash,
            Postable::$morphRelationName.'_type' => $morph->getMorphClass(),
            Postable::$morphRelationName.'_id' => $morph->getKey() ?? 0,
            'meta' => json_encode(new \stdClass(), JSON_THROW_ON_ERROR),
            'type' => Image::getAllowedTypes()->where('fileSuffix', 'png')->keys()->first(),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function(Image $image){
            copy(self::$image, $image->realPath);
        });
    }
}
