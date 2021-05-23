<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class ImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Image::class;
    private static $temp;
    private static $allImages;
    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \Exception
     */
    public function definition()
    {
        if(empty(self::$allImages))
        {
            self::$allImages = collect(Storage::disk('faker_images')->files());
        }
        $chosen = Storage::disk('faker_images')->path(self::$allImages->random());
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
            "extension" => mimetoextension($mime),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function(Image $image){
            $image->temporaryFileLocation = self::$temp;
        });
    }
}
