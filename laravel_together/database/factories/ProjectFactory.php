<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $user_pk = DB::table('users')->select('id')->get()->toArray();
        $color_code_pk = DB::table('basedata')->select('data_content_code')->where('data_title_code', '3')->get()->toArray();        
        $created_at = $this->faker->dateTimeBetween('-1 years');
        $updated_at = $this->faker->dateTimeBetween($created_at);
        $start_date = $this->faker->dateTimeBetween('-6 month');
        $end_date = $this->faker->dateTimeBetween($start_date, '6 month');
        // Log::debug([
        //     'user_pk' => $this->faker->randomElement($user_pk)->id,
        //     'color_code_pk' => $this->faker->randomElement($color_code_pk)->data_content_code,
        //     'project_title' => $this->faker->realText(15), // 프로젝트명
        //     'project_content' => $this->faker->realText(43), // 설명
        //     'flg' => $this->faker->numberBetween(0, 1), // 조직구분
        //     'start_date' => $start_date, // 시작일자
        //     'end_date' => $end_date, // 마감일자
        //     'created_at' => $created_at, // 작성일자
        //     'updated_at' => $updated_at, // 수정일자
        // ]);
        return [
            'user_pk' => $this->faker->randomElement($user_pk)->id,
            'color_code_pk' => $this->faker->randomElement($color_code_pk)->data_content_code,
            'project_title' => $this->faker->realText(15), // 프로젝트명
            'project_content' => $this->faker->realText(43), // 설명
            'flg' => $this->faker->numberBetween(0, 1), // 조직구분
            'start_date' => $start_date, // 시작일자
            'end_date' => $end_date, // 마감일자
            'created_at' => $created_at, // 작성일자
            'updated_at' => $updated_at, // 수정일자
        ];
    }
}
