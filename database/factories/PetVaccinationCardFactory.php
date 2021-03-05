<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\PetVaccinationCard;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetVaccinationCardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PetVaccinationCard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date('Y-m-d'),
            'description' => $this->faker->paragraph(1),
            'cost' => $this->faker->randomFloat(2, 0, 100),
            'fk_id_pet' => $this->faker->numberBetween(1, count(Pet::all()))
        ];
    }
}
