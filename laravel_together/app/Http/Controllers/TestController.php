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
        // $result = Comment::with(['tasks','users'])->find(1);
        // $result = [
        //     $result->tasks->title,
        //     $result->users->name
        // ];
        $proejct = Project::where('id','<','9')->get();
        $depth_0 = Task::depth(0);
        $depth_1 = Task::depth(1);
        $depth_2 = Task::depth(2);
        // dd($proejct);

        // 배열화 가능 테스트
        $data = [];
        // foreach ($depth_2 as $row) {
        //     $data[$row->task_parent] = $row;
        // }
        // foreach ($depth_1 as $row) {
        //     if (array_key_exists($row->id,$data)) {
        //         $row->children = $data[$row->id];
        //         $data[]
        //     }
        //     // $parent = $row->task_parent;
        //     // $row->$parent = [
        //     //     'depth_1' => $row
        //     // ];
        // }
        foreach ($proejct as $row){
            $data[$row->id]['project'] = $row;
        }
        foreach ($depth_0 as $row){ 
            if(array_key_exists($row->task_parent, $data)){
                if(array_key_exists('depth_0', $data[$row->task_parent])){
                    $data[$row->task_parent]['depth_0']['length']++;
                    $data[$row->task_parent]['depth_0'][$data[$row->task_parent]['depth_0']['length']] = $row;
                } else {
                    $data[$row->task_parent]['depth_0']['length'] = 0;
                    $data[$row->task_parent]['depth_0'][$data[$row->task_parent]['depth_0']['length']] = $row;
                }
            }            
        }
        foreach ($depth_1 as $row){ 
            if(array_key_exists($row->task_parent, $data)){
                if(array_key_exists('depth_1', $data[$row->task_parent])){
                    $data[$row->task_parent]['depth_1']['length']++;
                    $data[$row->task_parent]['depth_1'][$data[$row->task_parent]['depth_1']['length']] = $row;
                } else {
                    $data[$row->task_parent]['depth_1']['length'] = 0;
                    $data[$row->task_parent]['depth_1'][$data[$row->task_parent]['depth_1']['length']] = $row;
                }
            }              
        }
        foreach ($depth_2 as $row){ 
            if(array_key_exists($row->task_parent, $data)){
                if(array_key_exists('depth_2', $data[$row->task_parent])){
                    $data[$row->task_parent]['depth_2']['length']++;
                    $data[$row->task_parent]['depth_2'][$data[$row->task_parent]['depth_2']['length']] = $row;
                } else {
                    $data[$row->task_parent]['depth_2']['length'] = 0;
                    $data[$row->task_parent]['depth_2'][$data[$row->task_parent]['depth_2']['length']] = $row;
                }
            }              
        }
        dd($data);

        // 버블링과 배열화를 동시에 하는 함수구축

        return view('modal/modaltest');
    }
}
