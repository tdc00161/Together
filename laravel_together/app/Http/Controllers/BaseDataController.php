<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BaseDataController extends Controller
{
    public function get_priority_list($id){
        $responseData = [
            "code" => "0",
            "msg" => ""
        ];

        $result = DB::table('basedata')->where('data_title_code',$id)->get();
        Log::debug($result);
        if ($result === []) {
            $responseData['code'] = 'E01';
            $responseData['msg'] = $id.' is no where';
        } else {
            $responseData['data'] = $result;
            $responseData['code'] = 'D01';
            $responseData['msg'] = 'basedata: '.$id.' come';
        }

        return $responseData;
    }
}
