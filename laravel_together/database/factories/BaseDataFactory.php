<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BaseData>
 */
class BaseDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // return [
        //     'id'=>$this->faker->randomNumber(2), // pk
        //     'class1'=>$this->faker->numberBetween(0,1), // 대분류
        //     'class1_name'=>(string)$this->faker->sentence(20), // 대분류 이름
        //     'class2'=>$this->faker->numberBetween(0,1), // 소분류
        //     'class2_name'=>(string)$this->faker->sentence(20), // 소분류 이름
        // ];
    }
}
