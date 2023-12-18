<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\Project;

class TestController extends Controller
{
    public function index()
    {
        // 프로젝트와 업무들을 모두 호출 (나중에 조건 추가가능, 허나 정렬은 여기서 못함, TODO: project_id와 task_parent의 관계성 정해야 함)
        $project = Project::project_depth();
        $depth_0 = Task::depth(0); // 모델에서 만들어 놓은 쿼리로 하위 업무 각자 가져옴
        $depth_1 = Task::depth(1);
        $depth_2 = Task::depth(2);
        // 변수에 프로젝트와 하위 업무들을 다차원으로 합친다
        $data = [];
        // foreach ($depth_1 as $key_1 => $value_1) {
        //     foreach ($depth_2 as $key_2 => $value_2) {
        //         if($value_1->id === $value_2->task_parent){
        //             $value_1->depth_2[] = $value_2;
        //         }
        //     }
        // }
        // foreach ($depth_0 as $key_0 => $value_0) {
        //     foreach ($depth_1 as $key_1 => $value_1) {
        //         if($value_0->id === $value_1->task_parent){
        //             $value_0->depth_1[] = $value_1;
        //             $data[] = $value_0;
        //         }
        //     }
        // }
        foreach ($project as $key_pj => $value_pj) {
            foreach ($depth_0 as $key_0 => $value_0) { // 위에꺼랑 속도 테스트 필요
                if($value_pj->id === $value_0->project_id){
                    $value_pj->depth_0[] = $value_0;
                    foreach ($depth_1 as $key_1 => $value_1) {
                        if($value_0->id === $value_1->task_parent){
                            $value_0->depth_1[] = $value_1;
                            foreach ($depth_2 as $key_2 => $value_2) {
                                if($value_1->id === $value_2->task_parent){
                                    $value_1->depth_2[] = $value_2;
                                    $data[$value_pj->id] = $value_pj;
                                }
                            }
                        }
                    }
                }
            }
        }
        // dd($data);  
        // 정렬 (data배열의 값에 상응하는 key값을 따로 변수로 선언해, (0 => title_6, 1 => title_9 ...)
        //     그 변수를 정렬하고 (4 => title_1, 6 => title_2, ...) 그 정렬 순으로 data[4], data[6], ... data값과 키를 이용해 부를 예정)

        // 정렬하고 싶은 값을 빼온다
        // foreach ($data as $key => $item) {
        //     $sort[$key] = $item['project']->project_title;
        // }

        // // asort로 키값과 value를 정렬
        // asort($sort);

        // // data에 정렬된 배열 key값대로 변경
        // foreach ($sort as $key => $item) {
        //     $sorted_data[] = $data[$key]; // 배열로 넣어서 자동으로 배열 뒤로 들어가게
        // }

        return view('modal/modaltest')->with('data', $data);
    }

    public function view($id){
        $result['task'] = Task::task_detail($id);
        $result['children'] = Task::task_detail_children($id);
        $result['comment'] = Task::task_detail_comment($id);

        return $result;
    }
}
