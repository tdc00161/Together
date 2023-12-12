<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
           'task_id'=>$this->faker->numberBetween(0,50), // 업무 pk
           'user_id'=>$this->faker->randomNumber(2), // 작성자 pk
           'content'=>$this->faker->sentence(500), // 내용
           'created_at' => $date, //생성일
           'updated_at' => $date, //수정일
        ];
    }
}
