<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommunitiesSeeder extends Seeder
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
            foreach(range(0, 20) as $_)
            {
                Community::factory()->make()->owner()->associate($profiles->random())->save();
            }
        });
    }
}
