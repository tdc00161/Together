@extends('layout.layout')


@section('link')
{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
<script src="/js/project.js" defer></script>
<script src="/js/project_member.js" defer></script>
<link rel="stylesheet" href="/css/insert_detail.css">
<script defer src="/js/insert_detail.js"></script>
<link rel="stylesheet" href="/css/project_individual.css">
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
@endsection

@section('title', '개인프로젝트')

@section('main')
    <input type="hidden" id="user" value="{{$user}}">
    {{-- 헤더 --}}
    <div class="first_menu">
        <div class="project-header">
            {{-- 프로젝트컬러, 명 --}}
            <div class="title_bar">
                <div class="project_color" style="background-color:{{$color_code[0]->data_content_name}}"></div>   
                <input autocomplete="off" class="project_title" type="text" name="project_title" id="project_title" placeholder="프로젝트명" value="{{$result->project_title}}" onchange="titleupdate({{$result->id}})">
            </div>

            {{-- 프로젝트 날짜 --}}
            <div class="date_set">
                <label for="dday">
                    {{-- 240101 수정 --}}
                    <div class="dday" id="dday">
                        @if($projectDday === 0)
                            {{-- <div class="dday">D-day</div> --}}
                            D-day
                        @elseif($projectDday > 0)
                            {{-- <div class="dday">D-{{$projectDday}}</div> --}}
                            D-{{$projectDday}}
                        @elseif($projectDday < 0)
                        @endif
                    </div>
                </label>
                <label class="project_label" for="start_date"> 
                    <input class="project_date" type="date" name="start_date" id="start_date" onchange="titleupdate({{$result->id}})" value="{{$result->start_date}}">
                </label>
                <span class="project_date_ing">~</span>
                <label class="project_label" for="end_date">
                    {{-- <input class="date" type="date" name="end_date" id="end_date" onchange="total()" value="{{$result->end_date}}" min="{{$result->start_date}}"> --}}
                    <input class="project_date" type="date" name="end_date" id="end_date" onchange="titleupdate({{$result->id}})" value="{{$result->end_date}}">
                </label>
            </div>

            {{-- 버튼 공간 --}}
            <div class="project-header-btn-section">
                {{-- 버튼 --}}
                @forelse ($authoritychk as $item)
                {{-- <div class="title_img"><button onclick="openDeleteModal()"><img class="title_img2"src="/img/garbage(white).png" alt=""></button></div> --}}
                @if ($item->authority_id == '0')
                    <div><button onclick="openExitModal()"><img class="title_img2"src="/img/exit.png" alt=""></button></div>
                        {{-- 나가기 모달창 --}}
                        <div id="exitModal">
                            <div class="deletemodal-content">
                                <p class="deletespan">정말로 나가기를 하시겠습니까?</p>
                                <div class="gridbutton">
                                    <button class="closebutton" type="button" onclick="closeExitModal()">취소</button>
                                    <button class="deletebutton" type="button" id=exit onclick="deleteProject({{$result->id}})">나가기</button>
                                </div>
                            </div>
                        </div>
                @elseif ($item->authority_id == '1')
                    <button class="project-delete-btn" onclick="openDeleteModal()"><img class="title_img2"src="/img/garbage(white).png" alt=""></button>
                    {{-- 삭제 모달창 --}}
                    <div id="deleteModal">
                        <div class="deletemodal-content">
                            <p class="deletespan">정말로 삭제하시겠습니까?</p>
                            <div class="gridbutton">
                                <button class="closebutton" type="button" onclick="closeDeleteModal()">취소</button>
                                <button class="deletebutton" type="button" id=delete onclick="deleteProject({{$result->id}})">삭제</button>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
            @endforelse 
            </div>
        </div>
        <textarea class="project_content" name="project_content" id="project_content" placeholder="설명을 입력하세요." onchange="titleupdate({{$result->id}})">{{$result->project_content}}</textarea>
    </div>
    

    <div class="tabset">
        <div class="feeddiv">
            <a class="goFeed" href="{{ route('individual.get', ['id' => $result->id]) }}">피드</a>
        </div>
        <div class="ganttdiv">
            <a class="goGantt" href="{{ route('gantt.index', ['id' => $result->id]) }}">간트차트</a>
        </div>
       
    </div>
{{-- 헤더 끝 --}}

{{-- 피드안에 정보 --}}
<div class="tabcontent" id="field" style="display: block">
    <div class="grid_div">
        <div class="gird_row1">
            {{-- 업무상태 현황 --}}
            <div class="status_box"> 
                <div class="status_title">업무상태 현황</div>
                <canvas id="chartcanvas" width="900" height="900"></canvas>
                <div class="color_div">
                        <div class="color_set">
                            <div class="color_box1"></div>
                            <div class="color_name">시작전:{{$statuslist['before'][0]->cnt}}</div>
                        </div>
                        <div  class="color_set">
                            <div class="color_box2"></div>
                            <div class="color_name">진행중:{{$statuslist['ing'][0]->cnt}}</div>
                        </div>
                </div>
                <div class="color_div">
                        <div class="color_set">
                            <div class="color_box3"></div>
                            <div class="color_name">피드백:{{$statuslist['feedback'][0]->cnt}}</div>
                        </div>
                        <div  class="color_set">
                            <div class="color_box4"></div>
                            <div class="color_name">완료:{{$statuslist['complete'][0]->cnt}}</div>
                        </div>
                </div>
            </div>

            {{-- 구성원 --}}
            <div class="invite_box">
                <div class="m_first">
                    <div class="m_title">구성원</div>
                    @if($result->flg === "0")

                    @elseif($result->flg === "1")
                        <button onclick="projectMemberAddOpenModal()" id="projectmemberadd" class="member_titbtn">+</button>
                    @endif
                </div>
                {{-- 프로젝트 구성원 초대 --}}
                @forelse ($projectmemberdata as $item)
                    <div class="invite_grid">
                        <div id="{{'project_num'.$item->project_id.'_user'.$item->member_id}}" class="invite_member_div">
                            <img class="invite-img" src="/img/Group 114.png" alt="">
                        </div>
                        <div class="name_total">
                            <div class="member_name1">{{$item->name}}</div>
                            <div class="member_name1">admin@naver.com</div>
                        </div>
                    </div>
                @empty
                    
                @endforelse 
                </div>
            </div>

            {{-- 프로젝트 구성원 초대 모달 --}}
            <div id="projectMemberaddModal" class="projectMemberaddModalcss">
                <div class="projectMemberaddModalContent">
                    <span class="memberaddclosebtn" onclick="projectMemberAddCloseModal()">&times;</span>
                    <div>이메일로 추가</div>
                    <div>친구에서 추가</div>
                    <div>초대 링크로 추가</div>
                    <input type="text" style="color: black"; value="{{$inviteLink}}"><button type="button" class="copy-btn" onclick="copyUrl()">ㅁㅁ</button>
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
                        <table class="listtable project_task_notice_list_parent">
                            <colgroup>
                                <col class="col1">
                            </colgroup>
                            @forelse ($first_data as $item)
                                <tr class="box_ul project_task_notice_list notice-layout-{{$item->id}}">
                                    <td class="td_pd notice-{{$item->id}}" onclick="openTaskModal(1,1,{{$item->id}})">{{Str::limit($item->title,46,'...')}}</td>
                                </tr>
                                @empty
                                <tr class="box_ul project_task_notice_list">
                                    <td class="td_pd" onclick="openTaskModal(1,1)"></td>
                                </tr>
                            @endforelse
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
                        <table class="listtable project_task_update_list_parent">
                            <colgroup>
                                <col class="col2">
                                <col class="col3">
                            </colgroup>
                            @forelse ($update_data as $item)

                                <tr class="box_ul project_task_update_list update-layout-{{$item->id}}">
                                    <td class="td_pd update-{{$item->id}}" onclick="openTaskModal(1,0,{{$item->id}})">
                                        @if ($item->data_content_name == "공지")
                                            <div style="color:rgb(255, 196, 0); font-weight:bold;">{{$item->data_content_name}}</div>
                                        @elseif ($item->data_content_name == "업무")
                                            <div style="color:rgb(0, 174, 255); font-weight:bold;">{{$item->data_content_name}}</div>
                                        @endif
                                    </td> 
                                    {{-- 나중에 글/업무 플래그 변수로 삽입 --}}

                                    <td class="td_pd" onclick="openTaskModal(1,0,{{$item->id}})">{{Str::limit($item->title,35,'...')}}</td>
                                </tr>
                                @empty
                                <tr class="box_ul project_task_update_list">
                                    <td class="td_pd" onclick="openTaskModal(1,1)">
                                            <div style="color:rgb(255, 196, 0); font-weight:bold;"></div>
                                    </td> 
                                    {{-- 나중에 글/업무 플래그 변수로 삽입 --}}

                                    <td class="td_pd" onclick="openTaskModal(1,0)"></td>
                                </tr>
                            @endforelse
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
                        @foreach ($deadline_data as $item)
                            @if($item->dday === 0)
                                <tr class="box_ul">
                                    <td class="td_pd"></td>
                                    <td class="td_pd">
                                            <div style="color: rgb(207, 25, 25)">D-day</div>
                                    </td>
                                    <td class="td_pd" onclick="openTaskModal(1,0,{{$item->id}})">{{Str::limit($item->title,50,'...')}}</td>
                                    <td class="td_pd">{{$item->name}}</td>
                                    <td class="td_pd"><div class="statuscolor" data-status="{{$item->data_content_name}}">{{$item->data_content_name}}</div></td>
                                </tr>
                            @elseif($item->dday > 0)
                                <tr class="box_ul">
                                    <td class="td_pd"></td>
                                    <td class="td_pd">D-{{$item->dday}}</td>
                                    <td class="td_pd" onclick="openTaskModal(1,0,{{$item->id}})">{{Str::limit($item->title,50,'...')}}</td>
                                    <td class="td_pd">{{$item->name}}</td>
                                    <td class="td_pd"><div class="statuscolor" data-status="{{$item->data_content_name}}">{{$item->data_content_name}}</div></td>
                                </tr>
                            @elseif($item->dday == null || $item->dday == "")

                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
        <!-- {{-- 다크모드 --}} -->
        {{-- <div class="dark-light">
            <button type="button" style="background:transparent; border:none; cursor:pointer"><img src="/img/free-icon-moon-7682051.png" style="width: 30px; height: auto;" alt="이미지 설명"></button>
        </div> --}}
</div>

    @include('modal.insert') 
    {{-- include 순서 중요: 작성/상세 --}}
    @include('modal.detail')

@endsection

@section('project_css')
<link rel="stylesheet" href="/css/project_individual.css" defer>
@endsection