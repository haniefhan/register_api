<?php

namespace Database\Factories;

use App\Models\Registrant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistrantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Registrant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // generate 16 digit id card number
        $id_card_number = (string)$this->faker->randomNumber(9, true).(string)$this->faker->randomNumber(7, true);
        return [
            'name' => $this->faker->name,
            'id_card_number' => $id_card_number,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
