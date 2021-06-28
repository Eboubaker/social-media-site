<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Storage;

class DefaultsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
            $p = Profile::factory()->create([
                'user_id' => User::where('email', 'admin@test.com')->first('id')->id
            ]);
            $im_defaults = [
                'imageable_id' => 1,
                'imageable_type' => 'DEFAULT_IMAGE',
            ];
            Image::extractModelFromFile(Storage::disk('seeds')->path('/defaults_minified/community_iconImage.jpg'), $im_defaults+['id' => Image::DEFAULT_COMMUNITY_ICON_IMAGE_ID,'purpose' => 'default_community_iconImage'])->save();
            Image::extractModelFromFile(Storage::disk('seeds')->path('/defaults_minified/community_coverImage.jpg'), $im_defaults+['id' => Image::DEFAULT_COMMUNITY_COVER_IMAGE_ID,'purpose' => 'default_community_coverImage'])->save();
            Image::extractModelFromFile(Storage::disk('seeds')->path('/defaults_minified/profile_profileImage.jpg'), $im_defaults+['id' => Image::DEFAULT_PROFILE_PROFILE_IMAGE_ID,'purpose' => 'default_profile_profileImage'])->save();
            Image::extractModelFromFile(Storage::disk('seeds')->path('/defaults_minified/profile_coverImage.jpg'), $im_defaults+['id' => Image::DEFAULT_PROFILE_COVER_IMAGE_ID,'purpose' => 'default_profile_coverImage'])->save();
        });
    }
}
