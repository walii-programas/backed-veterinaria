<?php

namespace Database\Factories;

use App\Models\Vet;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fk_id_user' => $this->faker->unique()->numberBetween(1,count(User::all())),
            'cmvp' => Str::random(6)
        ];
    }
}
