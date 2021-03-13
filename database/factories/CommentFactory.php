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

        $comment = json_encode((object)["body"=>$this->faker->sentence], JSON_THROW_ON_ERROR);
        return [
            'content' => $comment,
            Comment::PKEY => Str::uuid()
        ];
    }

    public function configure()
    {
        return $this->afterMaking(static function(Comment $comment)
        {
            $profile = random_int(0, 100) > 50 ? new BusinessProfile() : new SocialProfile();
            if(!$profile || !$profile->exists || random_int(0, 100) > 80)
            {
                $profile = $profile::factory()->create();
            }
            $comment->profileable()->associate($profile);
            if(count(debug_backtrace()) < 50) {
                for ($i = random_int(0, random_int(0, random_int(0, random_int(0, random_int(0, random_int(0, random_int(0, 100))))))); $i > 0; $i--) {
                    $comment->comments()->create(Comment::factory()->make()->attributesToArray());
                }
            }
            for ($i = random_int(0, random_int(0, random_int(0, random_int(0, 4)))); $i > 0; $i--) {
                $comment->images()->create(Image::factory()->make()->attributesToArray());
            }
            for ($i = random_int(0, random_int(0, random_int(0, random_int(0, 4)))); $i > 0; $i--) {
                $comment->videos()->create(Video::factory()->make()->attributesToArray());
            }
        });
    }
}
