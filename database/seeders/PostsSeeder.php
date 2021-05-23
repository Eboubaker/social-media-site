<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::transaction(function () {
            $profiles = Profile::all();
            $comunities = Community::all();
            foreach (range(0, 600) as  $i) {
                $author = $profiles->random();
                $post = Post::factory()->make()->author()->associate($author);
                $post->pageable()->associate(random_int(0, 1) == 1 ? $author : $comunities->random());
                $post->save();
            }
        });
    }
}
