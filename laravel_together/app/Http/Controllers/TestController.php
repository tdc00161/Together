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
        // 프로젝트와 업무들을 모두 호출 (나중에 조건 추가가능, 허나 정렬은 여기서 못함)
        $proejct = Project::where('id', '<', '9')->get();
        $depth_0 = Task::depth(0);
        $depth_1 = Task::depth(1);
        $depth_2 = Task::depth(2);

        // 변수에 프로젝트와 하위 업무들을 다차원으로 합친다
        $data = [];
        foreach ($proejct as $row) {
            $data[$row->id]['project'] = $row;
        }
        foreach ($depth_0 as $row) {
            if (array_key_exists($row->task_parent, $data)) { // 한 레코드의 부모값이 데이터(프로젝트)에 있는 값인지 체크 (있으면 연결)
                if (array_key_exists('depth_0', $data[$row->task_parent])) { // 2. 먼저 작업한 흔적이 있으면 배열 뒤에 붙여주는 식으로
                    $data[$row->task_parent]['depth_0']['length']++;
                    $data[$row->task_parent]['depth_0'][$data[$row->task_parent]['depth_0']['length']] = $row;
                } else { // 1. 이 작업을 먼저하고
                    $data[$row->task_parent]['depth_0']['length'] = 0;
                    $data[$row->task_parent]['depth_0'][$data[$row->task_parent]['depth_0']['length']] = $row;
                }
            }
        } // 이하 동일
        foreach ($depth_1 as $row) {
            if (array_key_exists($row->task_parent, $data)) {
                if (array_key_exists('depth_1', $data[$row->task_parent])) {
                    $data[$row->task_parent]['depth_1']['length']++;
                    $data[$row->task_parent]['depth_1'][$data[$row->task_parent]['depth_1']['length']] = $row;
                } else {
                    $data[$row->task_parent]['depth_1']['length'] = 0;
                    $data[$row->task_parent]['depth_1'][$data[$row->task_parent]['depth_1']['length']] = $row;
                }
            }
        }
        foreach ($depth_2 as $row) {
            if (array_key_exists($row->task_parent, $data)) {
                if (array_key_exists('depth_2', $data[$row->task_parent])) {
                    $data[$row->task_parent]['depth_2']['length']++;
                    $data[$row->task_parent]['depth_2'][$data[$row->task_parent]['depth_2']['length']] = $row;
                } else {
                    $data[$row->task_parent]['depth_2']['length'] = 0;
                    $data[$row->task_parent]['depth_2'][$data[$row->task_parent]['depth_2']['length']] = $row;
                }
            }
        }

        // 정렬 (data배열의 값에 상응하는 key값을 따로 변수로 선언해, (0 => title_6, 1 => title_9 ...)
        //     그 변수를 정렬하고 (4 => title_1, 6 => title_2, ...) 그 정렬 순으로 data[4], data[6], ... data값과 키를 이용해 부를 예정)

        // 정렬하고 싶은 값을 빼온다
        foreach ($data as $key => $item) {
            echo $item['project']->project_title . '<br>';
            $sort[$key] = $item['project']->project_title;
        }

        // asort로 키값과 value를 정렬
        asort($sort);

        // data에 정렬된 배열 key값대로 변경
        foreach ($sort as $key => $item) {
            echo $key.'<br>';
            $sorted_data[] = $data[$key]; // 배열로 넣어서 자동으로 배열 뒤로 들어가게
        }
        dd($sorted_data);

        // return view('modal/modaltest');
    }
}
