<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\PetClinicalHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetClinicalHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PetClinicalHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date('Y-m-d'),
            'weight' => $this->faker->randomFloat(1, 0, 100),
            'temperature' => $this->faker->randomFloat(1, 0, 50),
            'observations' => $this->faker->paragraph(1),
            'fk_id_pet' => $this->faker->numberBetween(1,count(Pet::all())),
        ];
    }
}
