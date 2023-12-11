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
        DB::table('base_data')->insert([
            ['class1' => '0','class1_name'=> '업무상태','class2'=> '0', 'class2_name'=> '시작전']
            ,['class1' => '0','class1_name'=> '업무상태','class2'=> '1', 'class2_name'=> '진행중']
            ,['class1' => '0','class1_name'=> '업무상태','class2'=> '2', 'class2_name'=> '피드백']
            ,['class1' => '0','class1_name'=> '업무상태','class2'=> '3', 'class2_name'=> '완료']
            ,['class1' => '1','class1_name'=> '우선순위','class2'=> '0', 'class2_name'=> '없음']
            ,['class1' => '1','class1_name'=> '우선순위','class2'=> '1', 'class2_name'=> '낮음']
            ,['class1' => '1','class1_name'=> '우선순위','class2'=> '2', 'class2_name'=> '보통']
            ,['class1' => '1','class1_name'=> '우선순위','class2'=> '3', 'class2_name'=> '높음']
            ,['class1' => '1','class1_name'=> '우선순위','class2'=> '4', 'class2_name'=> '긴급']
            ,['class1' => '2','class1_name'=> '카테고리','class2'=> '0', 'class2_name'=> '업무']
            ,['class1' => '2','class1_name'=> '카테고리','class2'=> '1', 'class2_name'=> '공지']
            ,['class1' => '3','class1_name'=> '프로젝트 색상','class2'=> '0', 'class2_name'=> '#21D9AD']
            ,['class1' => '3','class1_name'=> '프로젝트 색상','class2'=> '1', 'class2_name'=> '#FFD644']
            ,['class1' => '3','class1_name'=> '프로젝트 색상','class2'=> '2', 'class2_name'=> '#F18434']
            ,['class1' => '3','class1_name'=> '프로젝트 색상','class2'=> '3', 'class2_name'=> '#DD62B3']
            ,['class1' => '3','class1_name'=> '프로젝트 색상','class2'=> '4', 'class2_name'=> '#B172E3']
            ,['class1' => '4','class1_name'=> '프로젝트 권한','class2'=> '0', 'class2_name'=> '관리자']
            ,['class1' => '4','class1_name'=> '프로젝트 권한','class2'=> '1', 'class2_name'=> '구성원']
        ]);
    }
}
