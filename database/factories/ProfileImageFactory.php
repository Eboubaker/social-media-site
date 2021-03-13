<?php

namespace Database\Factories;

use App\Models\ProfileImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProfileImage::class;
    private static $image;
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        $uuid = Str::uuid();

        $disk = Storage::disk('faker_images');
        $files = $disk->files();
        $chosen = $files[random_int(0, count($files)-1)];
        self::$image = $disk->path($chosen);
        $hash = hash('sha256', $disk->get($chosen));
        return [
            ProfileImage::PKEY => $uuid,
            'sha256' => $hash,
            'meta' => json_encode(new \stdClass(), JSON_THROW_ON_ERROR),
            'type' => ProfileImage::getAllowedTypes()->where('fileSuffix', 'png')->keys()->first(),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function(ProfileImage  $image){
            copy(self::$image, $image->realPath);
        });
    }
}
