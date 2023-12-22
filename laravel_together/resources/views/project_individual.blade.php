@extends('layout.layout')


@section('link')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="/js/project.js" defer></script>
<script src="/js/insert_detile.js" defer></script>
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
@endsection

@section('title', '개인프로젝트')

@section('main')
    <input type="hidden" id="user" value="{{$user}}">
    {{-- 상단바 --}}
    <div class="first_menu">
        <div class="menu_title">
            <div class="title_bar">
                <div class="project_color" style="background-color:{{$color_code->data_content_name}}"></div>
                <input class="title" type="text" name="project_title" placeholder="프로젝트명" value="{{$result->project_title}}">
                <div class="title_img"><button id=delete onclick="deleteProject({{$result->id}})"><img class="title_img2"src="/img/garbage(white).png" alt=""></button></div>
                {{-- <br> --}}
            </div>
            <textarea class="content" name="project_content" id="content" placeholder="설명">{{$result->project_content}}</textarea>
        </div>    
        <div class="date_set">
            {{-- <div class="dday">D-{{$result->dday}}</div> --}}
            <label for="dday">
                <div class="dday" id="dday">D-{{$result->dday}}</div>
            </label>
            <label class="label" for="start_date"> 시작일
                <input class="date" type="date" name="start_date" id="start_date" onchange="total()" value="{{$result->start_date}}">
            </label>
            <label class="label" for="end_date"> 마감일
                <input class="date" type="date" name="end_date" id="end_date" onchange="total()" value="{{$result->end_date}}">
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
                        <div class="color_box1"></div>
                        <div class="color_name">시작전</div>
                    </div>
                    <div  class="color_set">
                        <div class="color_box2"></div>
                        <div class="color_name">진행중</div>
                    </div>
                    <div class="color_set">
                        <div class="color_box3"></div>
                        <div class="color_name">피드백</div>
                    </div>
                    <div  class="color_set">
                        <div class="color_box4"></div>
                        <div class="color_name">완료</div>
                    </div>
                </div>
            </div>

            {{-- 구성원 --}}
            <div class="invite_box">
                <button class="invite-btn"><img class="invite-img" src="/img/Group 115.png" alt=""></button>
                <div class="invite-member-div"><img class="invite-img" src="/img/Group 114.png" alt=""></div>
            </div>
        </div>

        <div class="gird_row2">
            <div class="right_box1">
                {{-- 공지/업데이트 항목 --}}
                <div class="point_box">
                    <div class="point_title">
                        <div class="point_box_title">
                            <div class="point_text">공지</div>
                            <button class="point_button" onclick="openTaskModal(0,1)">+</button>
                        </div>
                        <div class="div_text1">제목</div>
                        <hr id="titleline">
                    </div>
                    <div class="listscroll">
                        <table class="listtable">
                            <colgroup>
                                <col class="col1">
                            </colgroup>
                            @foreach ($data as $item)
                                <tr class="box_ul">
                                    <td class="project_title td_pd" onclick="openTaskModal(1,1)">{{Str::limit($item->title,50,'...')}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="point_box">
                    <div class="point_text">업데이트 목록</div>
                    <div class="div_text2">
                        <div>카테고리</div>
                        <div>제목</div>
                    </div>
                    <hr id="titleline">
                    <div class="listscroll">
                        <table class="listtable">
                            <colgroup>
                                <col class="col2">
                                <col class="col3">
                            </colgroup>
                            @foreach ($data as $item)
                                <tr class="box_ul">
                                    <td class="project_title td_pd" onclick="openTaskModal(1,0)">{{$item->category_name}}</td> {{-- 나중에 글/업무 플래그 변수로 삽입 --}}
                                    <td class="td_pd">{{Str::limit($item->title,40,'...')}}</td>
                                    {{-- <td>{{$item->user_id}}</td> --}}
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            {{-- 마감순 업무 목록 --}}
            <div class="right_box2">
                <div class="point_text">마감순 업무 목록</div>
                <div class="div_text3">
                    <div></div>
                    <div>D-day</div>
                    <div>업무명</div>
                    <div>담당자</div>
                    <div>진행상태</div>
                </div>
                <hr id="titleline">
                <div class="listscroll">
                    <table class="listtable">
                        <colgroup>
                            <col class="col4">
                            <col class="col5">
                            <col class="col6">
                            <col class="col7">
                            <col class="col8">
                        </colgroup>
                        @foreach ($data as $item)
                            <tr class="box_ul">
                                <td class="td_pd"></td>
                                <td class="td_pd">{{$item->dday}}</td>
                                <td class="project_title td_pd" onclick="openTaskModal(1,0)">{{Str::limit($item->title,53,'...')}}</td>
                                <td class="td_pd">{{$item->name}}</td>
                                <td class="td_pd">{{$item->status_name}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
        <!-- {{-- 다크모드 --}} -->
        <div class="dark-light">
            <button type="button" style="background:transparent; border:none; cursor:pointer"><img src="/img/free-icon-moon-7682051.png" style="width: 30px; height: auto;" alt="이미지 설명"></button>
        </div>
</div>

@endsection

@section('project_css')
<link rel="stylesheet" href="/css/project_individual.css" defer>
@endsection