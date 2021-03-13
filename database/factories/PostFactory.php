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
use Illuminate\Support\Facades\Log;
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
        Log::debug("Entering PostFactory definition");
        $uuid = Str::uuid();

        $content = new stdClass();
        $content->body = $this->faker->sentence;

        $atts = [
            Post::PKEY => $uuid,
            'content' => $content,
        ];
        Log::debug("Leaving PostFactory definition");
        return $atts;
    }

    public function configure()
    {
        return $this->afterMaking(static function(Post $post){
            Log::debug("Entering PostFactory AfterMaking");
            $profile = random_int(0, 100) > 50 ? new BusinessProfile() : new SocialProfile();
            $prof = $profile::inRandomOrder()->first();
            if(!$prof || !$prof->exists || random_int(0, 100) > 80)
            {
                Log::debug("Creating a ". $profile->getMorphClass() ." profile for the post " . $post->getKey());
                $prof = $profile::factory()->create();
            }
            $post->profileable()->associate($prof);

            DB::transaction(function() use ($post) {
                for ($i = random_int(0, random_int(0, random_int(0, random_int(0, 3)))); $i > 0; $i--) {
                    Log::debug("Creating an image for the post " . $post->getKey());
                    $post->images()->create(Image::factory()->make()->attributesToArray());
                }
                for ($i = random_int(0, random_int(0, random_int(0, random_int(0, 3)))); $i > 0; $i--) {
                    Log::debug("Creating a video for the post " . $post->getKey());
                    $post->videos()->create(Video::factory()->make()->attributesToArray());
                }
                for($i = random_int(0, random_int(0, random_int(0, random_int(0, 20)))); $i > 0; $i--)
                {
                    Log::debug("Creating a comment for the post " . $post->getKey());
                    $post->comments()->create(Comment::factory()->make()->attributesToArray());
                }
            });
            Log::debug("Leaving PostFactory AfterMaking");
        });
    }
}
