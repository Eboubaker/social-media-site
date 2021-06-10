<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Video;
use DB;
use Illuminate\Database\Seeder;

class VideosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
            $videoables = Comment::get('id')->merge(Post::get('id'));
            foreach(range(1, $videoables->count() / 2) as $iter)
            {
                $videoables->random()->videos()->save(Video::factory()->make());
            }
        });
    }
}
