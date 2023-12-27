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
        $project_id = DB::table('projects')->select('id')->whereNull('deleted_at')->get()->toArray();        
        $authority_id = DB::table('basedata')->select('data_content_code')->where('data_title_code', '4')->get()->toArray();        
        $member_id = DB::table('users')->select('id')->whereNotNull('email_verified_at')->whereNotNull('remember_token')->get()->toArray();
        
        $random_user = $this->faker->randomElement($project_id);
        Log::debug($random_user->created_at);
        $created_at = $this->faker->dateTimeBetween($random_user->created_at);
        $updated_at = $this->faker->dateTimeBetween($created_at);
        $start_date = $this->faker->dateTimeBetween('-6 month');
        $end_date = $this->faker->dateTimeBetween($start_date, '6 month');
        return [
            'project_id'=>$this->faker->randomNumber(1, 15), // 프로젝트 pk
            'authority_id'=>$this->faker->numberBetween(0,1), // 권한 pk
            'member_id'=>$this->faker->randomNumber(1,10), // 참여자 pk
            'created_at'=> $date, // 작성일자
            'updated_at'=> $date, // 수정일자
        ];
    }
}
