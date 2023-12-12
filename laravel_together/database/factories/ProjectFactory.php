<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1 years');
        return [
            'user_id'=>$this->faker->randomNumber(1),         
            'color_code'=> $this->faker->numberBetween(0,4), // 색상코드 pk
            'project_title'=> $this->faker->realText(15), // 프로젝트명
            'project_content'=> $this->faker->realText(43), // 설명
            'flg'=> $this->faker->numberBetween(0,1), // 조직구분
            'start_date'=> $date, // 시작일자
            'end_date'=> $date, // 마감일자
            'created_at'=> $date, // 작성일자
            'updated_at'=> $date, // 수정일자
        ];
    }
}
