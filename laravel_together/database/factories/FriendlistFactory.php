<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Friendlist>
 */
class FriendlistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'=>(string)$this->faker->randomNumber(2), 
            'friend_id'=>(string)$this->faker->randomNumber(2), 
            'created_at' => $date, //생성일
        ];
    }
}
