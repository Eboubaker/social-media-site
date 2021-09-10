<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Post;
use DB;
use Illuminate\Database\Seeder;

class ImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
            $imageables = Comment::get('id')->merge(Post::get('id'));
            foreach(range(1, $imageables->count() / 2) as $iter)
            {
                $imageables->random()->images()->save(Image::factory()->make());
            }
        });
    }
}
