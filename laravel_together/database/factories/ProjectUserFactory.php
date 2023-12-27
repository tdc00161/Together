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
        $member_id = DB::table('users')->select('id','created_at')->whereNotNull('email_verified_at')->whereNotNull('remember_token')->get()->toArray();
        
        $random_user = $this->faker->randomElement($member_id);

        $created_at = $this->faker->dateTimeBetween($random_user->created_at);
        // Log::debug([
        //     'project_id'=>$this->faker->randomElement($project_id)->id, // 프로젝트 pk
        //     'authority_id'=>$this->faker->randomElement($authority_id)->data_content_code, // 권한 pk
        //     'member_id'=>$random_user->id, // 참여자 pk
        //     'created_at'=> $created_at, // 작성일자
        // ]);
        return [
            'project_id'=>$this->faker->randomElement($project_id)->id, // 프로젝트 pk
            'authority_id'=>$this->faker->randomElement($authority_id)->data_content_code, // 권한 pk
            'member_id'=>$random_user->id, // 참여자 pk
            'created_at'=> $created_at, // 작성일자
        ];
    }
}
