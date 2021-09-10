<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NormalSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $this
            ->call(CommunityPermissionsSeeder::class)
            ->call(CommunityRolesSeeder::class)
        ;
        });
    }
}
