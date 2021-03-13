<?php

namespace Database\Factories;

use App\Models\BusinessProfile;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Morphs\Commentable;
use App\Models\Morphs\Postable;
use App\Models\Morphs\Profileable;
use App\Models\Post;
use App\Models\SocialProfile;
use App\Models\Video;
use Closure;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use stdClass;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {

        $uuid = Str::uuid();

        $content = new stdClass();
        $content->body = $this->faker->sentence;
        $content = json_encode($content, JSON_THROW_ON_ERROR);

        return [
            Post::PKEY => $uuid,
            'content' => $content,
        ];
    }

    public function configure()
    {
        return $this->afterMaking(static function(Post $post){
            $profile = random_int(0, 100) > 50 ? new BusinessProfile() : new SocialProfile();
            $prof = $profile::inRandomOrder()->first();
            if(!$prof || !$prof->exists || random_int(0, 100) > 80)
            {
                $prof = $profile::factory()->create();
            }
            $post->profileable()->associate($prof);

            DB::transaction(function() use ($post) {
                for ($i = random_int(0, random_int(0, random_int(0, random_int(0, 3)))); $i > 0; $i--) {
                    $post->images()->create(Image::factory()->make()->attributesToArray());
                }
                for ($i = random_int(0, random_int(0, random_int(0, random_int(0, 3)))); $i > 0; $i--) {
                    $post->videos()->create(Video::factory()->make()->attributesToArray());
                }
                for($i = random_int(0, random_int(0, random_int(0, random_int(0, 20)))); $i > 0; $i--)
                {
                    $post->comments()->create(Comment::factory()->make()->attributesToArray());
                }
            });
        });
    }
}
