<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstname,
            'species' => $this->faker->randomElement(['mamiferos', 'oviparos', 'aves', 'reptiles']),
            'breed' => $this->faker->randomElement(['perro', 'gato', 'pollo', 'pato']),
            'color' => $this->faker->colorName,
            'birthdate' => $this->faker->date('Y-m-d'),
            'sex' => $this->faker->randomElement([Pet::PET_MALE, Pet::PET_FEMALE]),
            'photo' => Str::random(20),
            'fk_id_user' => Client::all()->random()->fk_id_user
        ];
    }
}
