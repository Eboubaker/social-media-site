<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepliesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $comments = Comment::all();
            $profiles = Profile::all();

            foreach(range(1, $comments->count() / 2) as $i)
            {
                $commentable = $comments->random();
                $comment = Comment::factory()->make(['commentor_id' => $profiles->random()->getKey()]);
                
                $commentable->comments()->save($comment);
                $comments->add($comment);
            }
        });
    }
}
