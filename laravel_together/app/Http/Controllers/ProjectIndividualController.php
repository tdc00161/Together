<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Project;
use App\Http\Models\ProjectUser;
use App\Http\Models\Task;
use App\Http\Models\User;
use App\Http\Models\BaseData;
use App\Http\Models\Friendlist;
use Illuminate\Support\Facades\DB;

class ProjectIndividualController extends Controller
{
    public function main() {

        $data = DB::table('Projects')->get();
        // var_dump($data);

        return view('project_individual')->with('data',$data);
    }
}
