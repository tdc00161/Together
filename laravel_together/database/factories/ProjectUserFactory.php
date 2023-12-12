<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProjectUser>
 */
class ProjectUserFactory extends Factory
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
            'project_id'=>$this->faker->randomNumber(4) // 프로젝트 pk
            'authority_id'=>$this->faker->numberBetween(1,2) // 권한 pk
            'member_id'$this->faker->randomNumber(2) // 참여자 pk
            'created_at'=> $date, // 작성일자
            'update_at'=> $date, // 수정일자
        ];
    }
}
