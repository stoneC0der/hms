<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tenant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name'    => $this->faker->firstName,
            'last_name'     => $this->faker->lastName,
            'phone'         => '0575261829',
            'email'         => $this->faker->email,
            'picture'       => $this->faker->imageUrl(640,480,'people',true),
            'occupation'    => 'student',
            'where'         => $this->faker->company,
            'user_id'       => null,
        ];
    }
}
