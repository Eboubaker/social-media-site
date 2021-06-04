<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostView;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostViewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $posts = Post::all();
            $profiles = Profile::all();
            $combinations = [];
            foreach (range(1, 500) as $i) {
                $post = $posts->random();
                $profile = $profiles->random();
                $combo = $post->getKey() . '|' . $profile->getKey();
                if(!isset($combinations[$combo]))
                {
                    PostView::create([
                        'viewer_id' => $profile->getKey(),
                        'post_id' => $post->getKey()
                    ]);
                    $combinations[$combo] = true;
                }
            }
        });
    }
}
