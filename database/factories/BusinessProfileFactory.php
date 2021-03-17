<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\BusinessProfile;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BusinessProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BusinessProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition()
    {
//        Log::debug("Entering BusinessProfileFactory definition");

        $data = (object)[
            "business_details" => (object)[
                "name" => $this->faker->words(),
                "location" => $this->faker->address,
                "yearly_income" => random_int(120000, random_int(120000, 5000000))
            ],
        ];
        $atts =  [
            'data' => $data
        ];
//        Log::debug("Leaving BusinessProfileFactory definition");
        return $atts;
    }

    public function configure()
    {
        return $this->afterMaking(function(BusinessProfile $businessProfile){
//            Log::debug("Entering BusinessProfileFactory afterMaking");
            $acc = User::query()->whereDoesntHave('businessProfile')->first();
            if($acc && FactoryHelper::randc(.9))
            {
                $businessProfile->account()->associate($acc);
            }else{
                $businessProfile->account()->associate(User::factory()->create());
            }
//            Log::debug("Leaving BusinessProfileFactory afterMaking");
        });
    }
}
