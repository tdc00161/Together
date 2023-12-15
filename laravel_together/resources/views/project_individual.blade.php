@extends('layout.layout')

@section('link')
<link rel="stylesheet" href="/css/project_individual.css">
<script src="/js/project.js" defer></script>
@endsection

@section('title', '개인프로젝트')

@section('main')
    {{-- 상단바 --}}
    <div class="first_menu">
        <div class="menu_title">
            <div class="project_color"></div>
            <div>
                <input type="text" name="title" placeholder="프로젝트명">
                {{-- <br> --}}
                <textarea name="content" id="content" placeholder="설명"></textarea>
            </div>    
        </div>    
        <div class="date_set">
            <label for="d_day"> D-day
                <span class="date" id="dday"></span>
            </label>
            <label for="start_date"> 시작일
                <input class="date" type="date" name="start_date" id="start_date" onchange="total()">
            </label>
            <label for="end_date"> 마감일
                <input class="date" type="date" name="end_date" id="end_date" onchange="total()">
            </label>
        </div>
    </div>
    <div class="tabset">
        <button class="tabmenu active" onclick="openTab(event,field)">피드</button>
        <button class="tabmenu" onclick="openTab(event,gantt)">간트차트</button>
    </div>
    {{-- <div class="hr"></div> --}}
{{-- 피드안에 정보 --}}
<div class="tabcontent" id="field" style="display: block">
    <div class="grid_div">
        <div class="gird_row1">
            {{-- 업무상태 현황 --}}
            <div class="status_box"> 
                <div class="status_title">업무상태 현황</div>
                <canvas id="chartcanvas" width="800" height="800"></canvas>
                <div class="color_div">
                    <div class="color_set">
                        <div class="color_box"></div>
                        <div class="color_name">요청</div>
                    </div>
                    <div  class="color_set">
                        <div class="color_box"></div>
                        <div class="color_name">진행</div>
                    </div>
                    <div class="color_set">
                        <div class="color_box"></div>
                        <div class="color_name">피드백</div>
                    </div>
                    <div  class="color_set">
                        <div class="color_box"></div>
                        <div class="color_name">완료</div>
                    </div>
                </div>
            </div>

            {{-- 구성원 --}}
            <div class="invite_box">
                <div class="mini_box">+</div>
                <div class="mini_box">구성원</div>
                <div class="mini_box">구성원</div>
                <div class="mini_box">구성원</div>
            </div>
        </div>

        <div class="gird_row2">
            <div class="right_box1">
                {{-- 공지/업데이트 항목 --}}
                <div class="point_box">
                    <div class="point_box_title">
                        <div class="point_text">공지</div>
                        <button class="point_button" onclick="openTaskModal(0,1)">+</button>
                    </div>
                    <table>
                        <colgroup>
                            <col class="col1">
                            <col class="col2">
                            <col class="col3">
                        </colgroup>
                        <tr class="box_ul">
                            <th>제목</th>
                            <th>내용</th>
                            <th>작성자</th>
                        </tr>
                        @foreach ($data as $item)
                            <tr id="box_ul">
                                <td class="project_title" onclick="openTaskModal(1,1)">{{$item->project_title}}</td>
                                <td>{{$item->project_content}}</td>
                                <td>{{$item->user_id}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="point_box">
                    <div class="point_text">업데이트 목록</div>
                    <table>
                        <colgroup>
                            <col class="col1">
                            <col class="col2">
                            <col class="col3">
                        </colgroup>
                        <tr class="box_ul">
                            <th>제목</th>
                            <th>내용</th>
                            <th>담당자</th>
                        </tr>
                        @foreach ($data as $item)
                            <tr class="box_ul">
                                <td class="project_title" onclick="openTaskModal(1,0)">{{$item->project_title}}</td> {{-- 나중에 글/업무 플래그 변수로 삽입 --}}
                                <td>{{$item->project_content}}</td>
                                <td>{{$item->user_id}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            {{-- 마감순 업무 목록 --}}
            <div class="right_box2">
                <div class="point_text">마감순 업무 목록</div>
                <table>
                    <colgroup>
                        <col class="col1">
                        <col class="col2">
                        <col class="col3">
                        <col class="col4">
                    </colgroup>
                    <tr class="box_ul">
                        <th>D-day</th>
                        <th>업무명</th>
                        <th>담당자</th>
                        <th>진행상태</th>
                    </tr>
                    @foreach ($data as $item)
                        <tr class="box_ul">
                            <td>{{$item->id}}</td>
                            <td class="project_title" onclick="openTaskModal(1,0)">{{$item->project_content}}</td>
                            <td>{{$item->user_id}}</td>
                            <td>{{$item->user_id}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

@endsection