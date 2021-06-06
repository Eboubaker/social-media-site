<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $likeables = Comment::all()->merge(Post::all())->shuffle();
            $profiles = Profile::all();
            $combinations = [];

            foreach(range(1, $likeables->count()) as $i)
            {
                $likeable = $likeables->random();
                $profile = $profiles->random();
                $combo = "" . $likeable->getKey() . get_class($likeable) . $profile->getKey();
                
                if(empty($combinations[$combo]))
                {
                    $likeable->likes()->save(Like::make([
                        'liker_id' => $profile->getKey()
                    ]));
                    $combinations[$combo] = true;
                }
            }
        });
    }
}
