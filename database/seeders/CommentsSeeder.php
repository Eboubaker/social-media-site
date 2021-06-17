<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
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
            DB::transaction(function () use ($posts, $profiles) {
                foreach(range(1, $posts->count()) as $i)
                {
                    $commentable = $posts->random();
                    $comment = Comment::factory()->make([
                        'commentor_id' => $profiles->random()->id,
                        'post_id' => $commentable->id,
                    ]);
                    $commentable->comments()->save($comment);
                }
            });
        });
    }
}
