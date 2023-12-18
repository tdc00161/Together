<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;

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
        $date = $this->faker->dateTimeBetween('-1 years');
        $task = Task::all()->pluck('id')->toArray();
        return [
           'task_id'=>$this->faker->randomElement($task), // 업무 pk
           'user_id'=>$this->faker->randomNumber(1), // 작성자 pk
           'content'=>$this->faker->realText(500), // 내용
           'created_at' => $date, //생성일
           'updated_at' => $date, //수정일
        ];
    }
}
