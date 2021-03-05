<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

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
            'image' => 'https://www.radionacional.com.pe/sites/default/files/styles/note/public/noticias/perritos_3.jpg?itok=LfQbMhE5'
        ];
    }
}
