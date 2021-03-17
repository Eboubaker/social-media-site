<?php

namespace Database\Factories;

use App\Models\BusinessProfile;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use App\Models\SocialProfile;
use App\Models\Video;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
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
//        Log::debug("Entering PostFactory definition");
        $content = new stdClass();
        $content->body = implode(' ', $this->faker->sentences(FactoryHelper::nestedRandomStep(20, 5, 1, 1)));
        $atts = [
            'content' => $content,
        ];
//        Log::debug("Leaving PostFactory definition");
        return $atts;
    }

    public function configure()
    {
        return $this->afterMaking(static function(Post $post){
//            Log::debug("Entering PostFactory AfterMaking");
            $profile = FactoryHelper::randc(.5) ? new BusinessProfile() : new SocialProfile();
            $author = $profile::inRandomOrder()->first();
            if(!$author || !$author->exists()  || FactoryHelper::randc(.9))
            {
//                Log::debug("Creating a ". $profile->getMorphClass() ." profile for the post " . $post->getKey());
                $author = $profile::factory()->create();
            }
            $post->profileable()->associate($author);
//            Log::debug("Leaving PostFactory AfterMaking");
        })->afterCreating(function(Post $post){
            DB::transaction(function() use ($post) {
                $created = 0;
                for ($i = FactoryHelper::nestedRandom(3, 4); $i > 0; $i--) {
//                    Log::debug("Creating an image for the post " . $post->getKey());
                    $post->images()->save(Image::factory()->make());
                    $created++;
                }
                for ($i = FactoryHelper::nestedRandom(3, 4); $i > 0; $i--) {
//                    Log::debug("Creating a video for the post " . $post->getKey());
                    $post->videos()->save(Video::factory()->make());
                    $created++;
                }
                for($i = FactoryHelper::nestedRandom(20, 4); $i > 0; $i--)
                {
//                    Log::debug("Creating a comment for the post " . $post->getKey());
                    $post->comments()->attach(Comment::factory()->create());
                }
                if($created === 0)
                {
                    $post->images()->save(Image::factory()->make());
                }
            });
        });
    }
}
