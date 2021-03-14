<?php

namespace Database\Factories;

use App\Models\BusinessProfile;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Morphs\Postable;
use App\Models\Morphs\Profileable;
use App\Models\Post;
use App\Models\SocialProfile;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws \Exception
     */
    public function definition()
    {
        Log::debug("Entering CommentFactory definition");
        $comment = (object)["body"=>$this->faker->sentence];
        $atts = [
            'content' => $comment,
        ];
        Log::debug("Leaving CommentFactory definition");
        return $atts;
    }

    public function configure()
    {
        return $this->afterMaking(static function(Comment $comment)
        {
            Log::debug("Entering CommentFactory afterMaking");
            $comment->makeUuid();
            $profile = FactoryHelper::randc(.5) ? new BusinessProfile() : new SocialProfile();
            $author = $profile::inRandomOrder()->first();
            if(!$author || !$author->exists() || random_int(0, 100) > 80)
            {
                $author = $profile::factory()->create();
            }
            $comment->profileable()->associate($author);
            DB::transaction(function() use ($comment) {
                if(count(debug_backtrace()) < 50) {
                    for ($i = FactoryHelper::nestedRandom(100, 7); $i > 0; $i--) {
                        Log::debug("Creating a comment for the comment " . $comment->getKey());
                        $comment->comments()->attach(Comment::factory()->create());
                    }
                }
                for ($i = FactoryHelper::nestedRandom(4, 4); $i > 0; $i--) {
                    Log::debug("Creating a Image for the comment " . $comment->getKey());
                    $comment->images()->save(Image::factory()->make());
                }
                for ($i = FactoryHelper::nestedRandom(4, 4); $i > 0; $i--) {
                    Log::debug("Creating a Video for the comment " . $comment->getKey());
                    $comment->videos()->save(Video::factory()->make());
                }
            });
            Log::debug("Leaving CommentFactory afterMaking");
        })->afterCreating(function(Comment $comment){

        });
    }
}
