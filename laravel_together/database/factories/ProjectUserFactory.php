<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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
        // Log::debug('$project_id:');
        // Log::debug($project_id);
        $authority_id = DB::table('basedata')->select('data_content_code')->where('data_title_code', '4')->get()->toArray();
        // Log::debug('$authority_id:');
        // Log::debug($authority_id);
        $member_id = DB::table('users')->select('id', 'created_at')->get()->toArray();
        // Log::debug('$member_id:');
        // Log::debug($member_id);

        $random_project = $this->faker->randomElement($project_id);
        Log::debug('$random_project:');
        Log::debug([$random_project]);
        $random_user = $this->faker->randomElement($member_id);
        Log::debug('$random_user:');
        Log::debug([$random_user]);

        $old_date = new Carbon($random_user->created_at);
        $new_date = Carbon::now();

        $diff = $old_date->diff($new_date)->days;

        $created_at = $this->faker->dateTimeBetween('-' . $diff . ' days');
        Log::debug('$created_at:');
        Log::debug([$created_at]);

        // Log::debug([
        //     'project_id'=>$this->faker->randomElement($project_id)->id, // 프로젝트 pk
        //     'authority_id'=>$this->faker->randomElement($authority_id)->data_content_code, // 권한 pk
        //     'member_id'=>$random_user->id, // 참여자 pk
        //     'created_at'=> $created_at, // 작성일자
        // ]);

        $issetSameMember = DB::table('project_users')->where('member_id', $random_user->id)->where('project_id', $random_project->id)->count();

        if ($issetSameMember) {
            Log::debug('있음 $project_id:');
            Log::debug($project_id);
            Log::debug('$member_id:');
            Log::debug($member_id);
            Log::debug('$issetSameMember:');
            // TODO
        } else {
            Log::debug('없음');
            return [
                'project_id' => $random_project->id, // 프로젝트 pk
                'authority_id' => $this->faker->randomElement($authority_id)->data_content_code, // 권한 pk
                'member_id' => $random_user->id, // 참여자 pk
                'created_at' => $created_at, // 작성일자
            ];
        }
    }
}
