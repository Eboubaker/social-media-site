<?php

namespace Database\Factories\Morphs;

use App\Models\Morphs\Postable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Postable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
//        Log::debug("Entering PostableFactory definition");

        $atts = [
            Postable::PKEY => Str::uuid()
        ];
//        Log::debug("Leaving PostableFactory definition");
        return $atts;

    }
}
