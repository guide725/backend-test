<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'POST#'.$this->faker->randomDigit(),
            'content' => $this->faker->text($maxNbChars = 200),
            'author' => $this->faker->name,
            'published' => $this->faker->numberBetween($min = 0, $max = 1)
        ];
    }
}