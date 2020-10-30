<?php

namespace Database\Factories;

use App\Models\Creator;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
class CreatorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Creator::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "username"=> strtolower($this->faker->lastName) . $this->faker->randomDigit,
            "email"=> $this->faker->safeEmail ,
            "name"=> $this->faker->name,
            "password" => Hash::make('123456'),
        ];
    }
}