<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->firstname,
            'lastname' => $this->faker->lastname,
            'dni' => $this->faker->randomNumber(8),
            'phone' => $this->faker->randomNumber(9),
            'address' => $this->faker->streetAddress,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('123456'),
            'verification_token' => Str::random(40),
            'state' => $this->faker->randomElement([User::USER_HABILITADO, User::USER_DESHABILITADO]),

            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }
}
