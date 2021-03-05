<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\Vet;
use App\Models\HospitalizedService;
use Illuminate\Database\Eloquent\Factories\Factory;

class HospitalizedServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HospitalizedService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date('Y-m-d'),
            'diagnosis' => $this->faker->paragraph(1),
            'description' => $this->faker->paragraph(1),
            'treatment' => $this->faker->paragraph(1),
            'cost' => $this->faker->randomFloat(2, 0, 100),
            'weight' => $this->faker->randomFloat(2, 0, 20),
            'temperature' => $this->faker->randomFloat(2, 20, 30),
            'symptoms' => $this->faker->paragraph(1),
            'observations' => $this->faker->paragraph(1),
            // 'initial_date' => $this->faker->date('Y-m-d'),
            // 'final_date' => $this->faker->date('Y-m-d'),
            'fk_id_pet' => $this->faker->numberBetween(1, count(Pet::all())),
            'fk_id_vet' => (Vet::all()->random(1)->pluck('fk_id_user'))[0]
        ];
    }
}
