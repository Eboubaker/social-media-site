<?php

namespace Database\Factories\Morphs;

use App\Models\Morphs\Commentable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CommentableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Commentable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        Log::debug("Entering CommentableFactory definition");

        $atts = [
            Commentable::PKEY => Str::uuid()
        ];
        Log::debug("Leaving CommentableFactory definition");
        return $atts;

    }
}
