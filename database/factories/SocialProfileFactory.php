<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\AccountSettings;
use App\Models\ProfileImage;
use App\Models\SocialProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SocialProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SocialProfile::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        Log::debug("Entering SocialProfileFactory definition");
        $data = (object)[
            "personal_info" => (object)[
                "bio" => $this->faker->sentence,
                "location" => $this->faker->address,
                "job" => $this->faker->jobTitle,
                "study" => $this->faker->words,
            ],
        ];
        $atts = [
            SocialProfile::PKEY => Str::uuid(),
            'data' => $data
        ];
        Log::debug("Leaving SocialProfileFactory definition");
        return $atts;
    }

    public function configure()
    {
        return $this->afterMaking(function(SocialProfile $socialProfile){
            Log::debug("Entering SocialProfileFactory AfterMaking");
            $acc = Account::query()->whereDoesntHave('socialProfile')->first();
            if($acc && random_int(0, 100) > 80)
            {
                $socialProfile->account()->associate($acc);
            }else{
                $socialProfile->account()->associate(Account::factory()->create());
            }
            Log::debug("Leaving SocialProfileFactory AfterMaking");
        });
    }

}
