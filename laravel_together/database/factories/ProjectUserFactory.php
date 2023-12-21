<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            'project_id'=>$this->faker->randomNumber(1, 15), // 프로젝트 pk
            'authority_id'=>$this->faker->numberBetween(0,1), // 권한 pk
            'member_id'=>$this->faker->randomNumber(1,10), // 참여자 pk
            'created_at'=> $date, // 작성일자
            'updated_at'=> $date, // 수정일자
        ];
    }
}
