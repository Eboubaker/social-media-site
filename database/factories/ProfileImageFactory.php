<?php

namespace Database\Factories;

use App\Models\ProfileImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
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
        Log::debug("Entering ProfileImageFactory definition");

        $uuid = Str::uuid()->toString();

        $disk = Storage::disk('faker_images');
        $files = $disk->files();
        $chosen = $files[random_int(0, count($files)-1)];
        self::$image = $disk->path($chosen);
        $hash = hash('sha256', $disk->get($chosen));
        $atts =  [
            ProfileImage::PKEY => $uuid,
            'sha256' => $hash,
            'meta' => (object)["with" => 1024, "height" => 1280],
            'type' => ProfileImage::getAllowedTypes()->where('fileSuffix', 'png')->keys()->first(),
        ];
        Log::debug("Leaving ProfileImageFactory definition");
        return $atts;
    }
    public function configure()
    {
        return $this->afterMaking(function(ProfileImage  $image){
            Log::debug("Entering ProfileImageFactory afterMaking");

            copy(self::$image, $image->realPath);
            Log::debug("Entering ProfileImageFactory afterMaking");

        });
    }
}
