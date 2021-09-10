<?php

namespace Database\Seeders;

use App\Models\CommunityPermission;
use Illuminate\Database\Seeder;

class CommunityPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('permissions.communities') as $name => $id) {
            CommunityPermission::create([
                CommunityPermission::getId() => $id,
                'name' => $name
            ]);
        }
    }
}
