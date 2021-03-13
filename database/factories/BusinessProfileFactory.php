<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\BusinessProfile;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
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
        $data = (object)[
            "business_details" => (object)[
                "name" => $this->faker->words(),
                "location" => $this->faker->address,
                "yearly_income" => random_int(120000, random_int(120000, 5000000))
            ],
        ];
        return [
            BusinessProfile::PKEY => Str::uuid(),
            'data' => json_encode($data, JSON_THROW_ON_ERROR)
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function(BusinessProfile $businessProfile){
            $acc = Account::query()->whereDoesntHave('businessProfile')->first();
            if($acc && random_int(0, 100) > 80)
            {
                $businessProfile->account()->associate($acc);
            }else{
                $businessProfile->account()->associate(Account::factory()->create());
            }
        });
    }
}
