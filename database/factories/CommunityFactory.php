<?php

namespace Database\Factories;

use App\Models\Community;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CommunityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Community::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => Str::camel(substr(str_replace('.', '', str_replace(' ', '_', $this->faker->unique()->sentence(rand(1, 6)))), 0, 20)),
            'description' => $this->faker->realText()
        ];
    }
}
