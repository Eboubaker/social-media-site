<?php

namespace Database\Factories;

use App\Models\BusinessProfile;
use App\Models\Comment;
use App\Models\Image;
use App\Models\Morphs\Commentable;
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
            Comment::PKEY => Str::uuid()->toString(),
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
            $profile = random_int(0, 100) > 50 ? new BusinessProfile() : new SocialProfile();
            if(!$profile || !$profile->exists || random_int(0, 100) > 80)
            {
                $profile = $profile::factory()->create();
            }
            $comment->profileable()->associate($profile);
            if(count(debug_backtrace()) < 50) {
                for ($i = random_int(0, random_int(0, random_int(0, random_int(0, random_int(0, random_int(0, random_int(0, 100))))))); $i > 0; $i--) {
                    Log::debug("Creating a comment for the comment " . $comment->getKey());
                    $comment->comments()->create(Comment::factory()->make()->attributesToArray());
                }
            }
            for ($i = random_int(0, random_int(0, random_int(0, random_int(0, 4)))); $i > 0; $i--) {
                Log::debug("Creating a Image for the comment " . $comment->getKey());
                $comment->images()->create(Image::factory()->make()->attributesToArray());
            }
            for ($i = random_int(0, random_int(0, random_int(0, random_int(0, 4)))); $i > 0; $i--) {
                Log::debug("Creating a Video for the comment " . $comment->getKey());
                $comment->videos()->create(Video::factory()->make()->attributesToArray());
            }
            Log::debug("Leaving CommentFactory afterMaking");
        });
    }
}
