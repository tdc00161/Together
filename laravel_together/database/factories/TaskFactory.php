<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date1 = $this->faker->dateTimeBetween('-1 years');
        $date2 = $this->faker->dateTimeBetween('-1 years');
        $date3 = $this->faker->dateTimeBetween('-1 years');
        $date4 = $this->faker->dateTimeBetween('-1 years');
        return [
            
            'project_id'=>$this->faker->randomNumber(1,10), // 프로젝트 pk
            'task_responsible_id'=>$this->faker->randomNumber(1,15), // 담당자 pk
            'task_writer_id'=>$this->faker->randomNumber(1), // 작성자 pk
            'task_status_id'=>$this->faker->numberBetween(0,3), // 업무상태 pk
            'priority_id'=>$this->faker->numberBetween(0,4), // 우선순위 pk
            'category_id'=>$this->faker->numberBetween(0,1), // 카테고리 pk
            'task_number'=>$this->faker->randomNumber(2), // 업무번호
            'task_parent'=>$this->faker->randomNumber(1), // 상위업무
            'task_depth'=>$this->faker->numberBetween(0,2),// 업무깊이 1
            'title'=>$this->faker->realText(50), // 제목 50
            'content'=>$this->faker->realText(500), // 내용 500
            'start_date'=> null, // 시작일자
            'end_date'=> null, // 마감일자
            // 'start_date'=> $date1, // 시작일자
            // 'end_date'=> $date2, // 마감일자
            // 'created_at'=> $date3, // 작성일자
            // 'updated_at'=> $date4, // 수정일자
            
            
        ];    }}