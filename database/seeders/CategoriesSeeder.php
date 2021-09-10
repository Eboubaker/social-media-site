<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ["name" => "videos", "emojie_icon" => '🎥'],
            ["name" => "funny", "emojie_icon" => '😄'],
            ["name" => "books_and_writing", "emojie_icon" => '📚'],
            ["name" => "learning", "emojie_icon" => '🧐'], 
            ["name" => "art", "emojie_icon" => '🎨'], 
            ["name" => "photography", "emojie_icon" => '📷'],
            ["name" => "tv", "emojie_icon" => '📺'], 
            ["name" => "finance", "emojie_icon" => '💸'],
            ["name" => "science", "emojie_icon" => '🔬'],
            ["name" => "tech", "emojie_icon" => '💻'], 
            ["name" => "poetry", "emojie_icon" => '📜'], 
            ["name" => "pictures_and_gifs", "emojie_icon" => '🖼'],
            ["name" => "travel", "emojie_icon" => '🛫']
        ]);
    }
}
