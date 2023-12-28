<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
        
        // $project_id = DB::table('tasks')
        //                 ->select('tasks.project_id')
        //                 ->join('projects', function($join){
        //                     $join->on('tasks.project_id','=','projects.id');
        //                 })
        //                 ->get();

        $project_id = DB::table('projects')->whereNull('deleted_at')->select('id')->get();
        
        $random_project_id = $this->faker->randomElement($project_id)->id;
        Log::debug($random_project_id);
        
        $task_responsible_id = DB::table('project_users')->join('users','users.id','project_users.member_id')->where('project_users.project_id',$random_project_id)->select('users.id')->get();
        Log::debug($task_responsible_id);
        $task_writer_id = DB::table('users')->select('id')->get();
        $task_status_id = DB::table('basedata')->select('data_content_code')->where('data_title_code','0')->get();
        $priority_id = DB::table('basedata')->select('data_content_code')->where('data_title_code','1')->get();
        $category_id = DB::table('basedata')->select('data_content_code')->where('data_title_code','2')->get();
        $task_parent = DB::table('tasks')->select('id')->whereNull('deleted_at')->get();
        $task_depth = DB::table('tasks')->select('task_parent')->whereNull('deleted_at')->get();
        $title = DB::table('tasks')->select('id')->whereNull('deleted_at')->get();
        $content = DB::table('tasks')->select('id')->whereNull('deleted_at')->get();
        $start_date = $this->faker->dateTimeBetween('-6 month');
        $end_date = $this->faker->dateTimeBetween($start_date, '6 month');
        $created_at = $this->faker->dateTimeBetween('-1 years');
        $updated_at = $this->faker->dateTimeBetween($created_at);
        Log::debug();
        
        
        
        
        
        
        $date1 = $this->faker->dateTimeBetween('-1 years');
        $date2 = $this->faker->dateTimeBetween('-1 years');
        $date3 = $this->faker->dateTimeBetween('-1 years');
        $date4 = $this->faker->dateTimeBetween('-1 years');
        Log::debug([
            
            'project_id'=>16, // 프로젝트 pk
            'task_responsible_id' => $arr[$this->faker->randomNumber($arr)], // 담당자 pk
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
            
            
        ]);
        // return [
            
        //     'project_id'=>16, // 프로젝트 pk
        //     'task_responsible_id' => $arr[$this->faker->randomNumber($arr)], // 담당자 pk
        //     'task_writer_id'=>$this->faker->randomNumber(1), // 작성자 pk
        //     'task_status_id'=>$this->faker->numberBetween(0,3), // 업무상태 pk
        //     'priority_id'=>$this->faker->numberBetween(0,4), // 우선순위 pk
        //     'category_id'=>$this->faker->numberBetween(0,1), // 카테고리 pk
        //     'task_number'=>$this->faker->randomNumber(2), // 업무번호
        //     'task_parent'=>$this->faker->randomNumber(1), // 상위업무
        //     'task_depth'=>$this->faker->numberBetween(0,2),// 업무깊이 1
        //     'title'=>$this->faker->realText(50), // 제목 50
        //     'content'=>$this->faker->realText(500), // 내용 500
        //     'start_date'=> null, // 시작일자
        //     'end_date'=> null, // 마감일자
        //     // 'start_date'=> $date1, // 시작일자
        //     // 'end_date'=> $date2, // 마감일자
        //     // 'created_at'=> $date3, // 작성일자
        //     // 'updated_at'=> $date4, // 수정일자
            
            
        // ];  
      }}