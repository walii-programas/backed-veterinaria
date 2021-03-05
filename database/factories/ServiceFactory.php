<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->firstname,
            'description' => $this->faker->paragraph(1),
            'image' => 'https://www.triada.com.pe/wp-content/uploads/2019/03/escoger-mejor-mascota-para-tu-departamento-en-Lima-perros-1024x499.jpg'
        ];
    }
}
