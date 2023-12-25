<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class BaseDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('basedata')->insert([
            ['data_title_code' => 0,'data_title_name'=> '업무상태','data_content_code'=> 0, 'data_content_name'=> '시작전']
            ,['data_title_code' => 0,'data_title_name'=> '업무상태','data_content_code'=> 1, 'data_content_name'=> '진행중']
            ,['data_title_code' => 0,'data_title_name'=> '업무상태','data_content_code'=> 2, 'data_content_name'=> '피드백']
            ,['data_title_code' => 0,'data_title_name'=> '업무상태','data_content_code'=> 3, 'data_content_name'=> '완료']
            ,['data_title_code' => 1,'data_title_name'=> '우선순위','data_content_code'=> 0, 'data_content_name'=> '없음']
            ,['data_title_code' => 1,'data_title_name'=> '우선순위','data_content_code'=> 1, 'data_content_name'=> '낮음']
            ,['data_title_code' => 1,'data_title_name'=> '우선순위','data_content_code'=> 2, 'data_content_name'=> '보통']
            ,['data_title_code' => 1,'data_title_name'=> '우선순위','data_content_code'=> 3, 'data_content_name'=> '높음']
            ,['data_title_code' => 1,'data_title_name'=> '우선순위','data_content_code'=> 4, 'data_content_name'=> '긴급']
            ,['data_title_code' => 2,'data_title_name'=> '카테고리','data_content_code'=> 0, 'data_content_name'=> '업무']
            ,['data_title_code' => 2,'data_title_name'=> '카테고리','data_content_code'=> 1, 'data_content_name'=> '공지']
            ,['data_title_code' => 3,'data_title_name'=> '프로젝트 색상','data_content_code'=> 0, 'data_content_name'=> '#21D9AD']
            ,['data_title_code' => 3,'data_title_name'=> '프로젝트 색상','data_content_code'=> 1, 'data_content_name'=> '#FFD644']
            ,['data_title_code' => 3,'data_title_name'=> '프로젝트 색상','data_content_code'=> 2, 'data_content_name'=> '#F18434']
            ,['data_title_code' => 3,'data_title_name'=> '프로젝트 색상','data_content_code'=> 3, 'data_content_name'=> '#DD62B3']
            ,['data_title_code' => 3,'data_title_name'=> '프로젝트 색상','data_content_code'=> 4, 'data_content_name'=> '#B172E3']
            ,['data_title_code' => 4,'data_title_name'=> '프로젝트 권한','data_content_code'=> 0, 'data_content_name'=> '관리자']
            ,['data_title_code' => 4,'data_title_name'=> '프로젝트 권한','data_content_code'=> 1, 'data_content_name'=> '구성원']
        ]);

        
    }
}
