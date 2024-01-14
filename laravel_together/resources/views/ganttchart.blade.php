@extends('layout.layout')
@section('link')
    <link rel="stylesheet" href="/css/ganttchart.css">
    <script src="/js/ganttchart.js" defer></script>
    {{-- 헤더 js --}}
    {{-- 모달 js, css --}}
    <link rel="stylesheet" href="/css/insert_detail.css">
	<script src="/js/insert_detail.js" defer></script>
    {{-- <script src="/js/project.js" defer></script> --}}
@endsection
@section('title', '간트차트')
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
<div class="grid_div">
    
    <div class="gantt-btn-wrap">
        <input class="gantt-search" type="input" id="keySearch" onkeyup="enterkeySearch()" placeholder="'업무명'으로 검색">
        <div class="filter-div">

            <div id="list1" class="gantt-dropdown-check-list" tabindex="100">
                <div id="gantt-filter-dropdown-btn" class="gantt-span">
                    <img class="gantt-filter" src="/img/Group_136.png" alt="filter">
                    <span style="font-size: 12px;">상태</span>
                </div>
                <ul id="myganttDropdown" class="gantt-items">
                    <li><input id="statusAll" class="status-radio radio-checked" type="radio" name="status" value="전체" checked>
                        <label for="statusAll" class="gantt-item status-value">전체</label>
                    </li>
                    <li><input id="status1" class="status-radio" type="radio" name="status" value="시작전"> {{-- onclick="filtering()" --}}
                        <div class="gantt-color gantt-status1"></div><label for="status1" class="gantt-item status-value">시작전</label>
                    </li>
                    <li><input id="status2" class="status-radio" type="radio" name="status" value="진행중"> {{-- onclick="filtering()" --}}
                        <div class="gantt-color gantt-status2"></div><label for="status2" class="gantt-item status-value">진행중</label>
                    </li>
                    <li><input id="status3" class="status-radio" type="radio" name="status" value="피드백"> {{-- onclick="filtering()" --}}
                        <div class="gantt-color gantt-status3"></div><label for="status3" class="gantt-item status-value">피드백</label>
                    </li>
                    <li><input id="status4" class="status-radio" type="radio" name="status" value="완료"> {{-- onclick="filtering()" --}}
                        <div class="gantt-color gantt-status4"></div><label for="status4" class="gantt-item status-value">완료</label>
                    </li>
                </ul>
            </div>

            <div id="list2" class="gantt-dropdown-check-list" tabindex="100">
                <div id="gantt-filter-dropdown-btn" class="gantt-span">
                    <img class="gantt-filter" src="/img/Group_136.png" alt="filter">
                    <span style="font-size: 12px;">중요도</span>
                </div>
                <ul id="myganttDropdown" class="gantt-items">
                    <li><input id="priorityAll" class="priority-radio radio-checked" type="radio" name="priority" value="priorityAll">
                        <label for="priorityAll" class="gantt-item priority-value">전체</label>
                    </li>
                    <li><input id="priority1" class="priority-radio" type="radio" name="priority" value="priority1"><img class="gantt-rank" src="/img/gantt-bisang.png" alt="">
                        <label for="priority1" class="gantt-item priority-value">긴급</label>
                    </li>
                    <li><input id="priority2" class="priority-radio" type="radio" name="priority" value="priority2"><img class="gantt-rank" src="/img/gantt-up.png" alt="">
                        <label for="priority2" class="gantt-item priority-value">높음</label>
                    </li>
                    <li><input id="priority3" class="priority-radio" type="radio" name="priority" value="priority3"><img class="gantt-rank" src="/img/gantt-line.png" alt="">
                        <label for="priority3" class="gantt-item priority-value">보통</label>
                    </li>
                    <li><input id="priority4" class="priority-radio" type="radio" name="priority" value="priority4"><img class="gantt-rank" src="/img/gantt-down.png" alt="">
                        <label for="priority4" class="gantt-item priority-value">낮음</label>
                    </li>
                    <li><input id="priorityNot" class="priority-radio" type="radio" name="priority" value="priorityNot">
                        <label for="priorityNot" class="gantt-item priority-value">없음</label>
                    </li>
                </ul>
            </div>

            <div id="list3" class="gantt-dropdown-check-list" tabindex="100">
                <div id="gantt-filter-dropdown-btn" class="gantt-span">
                    <img class="gantt-filter" src="/img/Group_136.png" alt="filter">
                    <span style="font-size: 12px;">담당자</span>
                </div>
                <ul id="myganttDropdown" class="gantt-items">
                    <li><input id="resAll" class="respon-radio radio-checked" type="radio" name="respon" checked> {{-- onclick="filtering()" --}}
                        <label class="gantt-item respon-value" for="resAll">전체</label>
                    </li>
                    @php
                        $resNames = array_unique(array_column($data['task'], 'res_name'));
                        $resNames = array_filter($resNames, function($name) {
                            return $name !== null;
                        });
                        $resNames[] = null; // null 값을 배열에 추가하여 '없음'을 마지막에 표시
                    @endphp

                    @foreach($resNames as $index => $resName)
                        <li>
                            @if ($resName !== null)
                                <input class="respon-radio" id="res{{ $index + 1 }}" type="radio" name="respon"> {{-- onclick="filtering()" --}}
                                <label for="res{{ $index + 1 }}" class="gantt-item respon-value">{{ $resName }}</label>
                            @else
                                <input class="respon-radio" id="res-none" type="radio" name="respon"> {{-- onclick="filtering()" --}}
                                <label for="res-none" class="gantt-item respon-value">없음</label>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <div id="list4" class="gantt-dropdown-check-list" tabindex="100">
                <div id="gantt-filter-dropdown-btn" class="gantt-span">
                    <img class="gantt-filter" src="/img/Group_136.png" alt="filter">
                    <span style="font-size: 12px;">시작일</span>
                </div>
                <ul id="myganttDropdown" class="gantt-items">
                    <li><input name="start" class="start-radio radio-checked" type="radio" id="start1" checked> {{-- onclick="filtering()" --}}
                        <label for="start1" class="gantt-item start-value">전체</label>
                    </li>
                    <li><input name="start" class="start-radio" type="radio" id="start2"> {{-- onclick="filtering()" --}}
                        <label for="start2" class="gantt-item start-value">오늘</label>
                    </li>
                    <li><input name="start" class="start-radio" type="radio" id="start3"> {{-- onclick="filtering()" --}}
                        <label for="start3" class="gantt-item start-value">이번주</label>
                    </li>
                    <li><input name="start" class="start-radio" type="radio" id="start4"> {{-- onclick="filtering()" --}}
                        <label for="start4" class="gantt-item start-value">이번달</label>
                    </li>
                </ul>
            </div>
            <div id="list5" class="gantt-dropdown-check-list" tabindex="100">
                <div id="gantt-filter-dropdown-btn" class="gantt-span">
                    <img class="gantt-filter" src="/img/Group_136.png" alt="filter">
                    <span style="font-size: 12px;">마감일</span>
                </div>
                <ul id="myganttDropdown" class="gantt-items">
                    <li><input name="end" class="end-radio radio-checked" type="radio" id="end1" checked> {{-- onclick="filtering()" --}}
                        <label for="end1" class="gantt-item end-value">전체</label>
                    </li>
                    <li><input name="end" class="end-radio" type="radio" id="end2"> {{-- onclick="filtering()" --}}
                        <label for="end2" class="gantt-item end-value">오늘</label>
                    </li>
                    <li><input name="end" class="end-radio" type="radio" id="end3"> {{-- onclick="filtering()" --}}
                        <label for="end3" class="gantt-item end-value">이번주</label>
                    </li>
                    <li><input name="end" class="end-radio" type="radio" id="end4"> {{-- onclick="filtering()" --}}
                        <label for="end4" class="gantt-item end-value">이번달</label>
                    </li>
                </ul>
            </div>

            <span style="color: rgb(202, 202, 202)">｜</span>

            <div id="list6" class="gantt-dropdown-check-list" tabindex="100">
                <div class="gantt-span">
                    <img class="gantt-align" src="/img/Group 136.png" alt="filter">
                    <span style="font-size: 12px;">정렬</span>
                </div>
                <ul class="gantt-items">
                    <li class="gantt-task-header-div">
                        <button type="button"><img src="/img/table4.png" alt=""></button>
                        <label for="end1" class="gantt-item">업무명</label>
                    </li>
                    <li class="gantt-task-header-div">
                        <button type="button"><img src="/img/table4.png" alt=""></button>
                        <label for="end2" class="gantt-item">담당자</label>
                    </li>
                    <li class="gantt-task-header-div">
                        <button type="button"><img src="/img/table4.png" alt=""></button>
                        <label for="end3" class="gantt-item">상태</label>
                    </li>
                    <li class="gantt-task-header-div">
                        <button type="button"><img src="/img/table4.png" alt=""></button>
                        <label for="end4" class="gantt-item">시작일</label>
                    </li>
                    <li class="gantt-task-header-div">
                        <button type="button"><img src="/img/table4.png" alt=""></button>
                        <label for="end5" class="gantt-item">마감일</label>
                    </li>
                </ul>
            </div>

        </div>
            <div class="add-btn-section">
            <button class="gantt-add-btn" onclick="openTaskModal(0)">
                <img class="task-add-btn" src="/img/Group 164.png">
                업무추가
            </button>
            </div>
            {{-- <button class="gantt-update-btn gantt-add-btn" type="submit">업무수정</button> --}}
    </div>
    
    <!-- 팝업 모달 창 -->
    <div id="ganttPopupModal" class="gantt-update-modal">
        <div class="gantt-modal-content">
            <p class="gantt-modal-content-p" id="ganttPopupMessage"></p>
        </div>
    </div>
    {{-- 새 업무 추가 문구 --}}
    <div class="new-task-add-please" style="display: none">
        <div class="new-task-add">
            <p class="new-task-add-p">새 업무를 추가해주세요.</p>
        </div>
    </div>
    <div class="gantt-content-wrap">
        <section class="gantt-all-task scroll-style-parent">
            <div class="gantt-task-wrap">
                <div class="gantt-task-header">
                    <div class="gantt-task-header-div" style="width: 34%">
                        {{-- <span class="gantt-order">업무명</span> --}}
                        {{-- <button type="button"><img src="/img/table4.png" alt=""></button> --}}
                    </div>
                    <div class="gantt-task-header-div" style="width: 14%">
                        {{-- <span class="gantt-order">담당자</span>
                        <button type="button"><img src="/img/table4.png" alt=""></button> --}}
                    </div>
                    <div class="gantt-task-header-div" style="width: 16%">
                        {{-- <span class="gantt-order">상태</span>
                        <button type="button"><img src="/img/table4.png" alt=""></button> --}}
                    </div>
                    <div class="gantt-task-header-div" style="width: 18%">
                        {{-- <span class="gantt-order">시작일</span>
                        <button type="button"><img src="/img/table4.png" alt=""></button> --}}
                    </div>
                    <div class="gantt-task-header-div" style="width: 18%">
                        {{-- <span class="gantt-order">마감일</span>
                        <button type="button"><img src="/img/table4.png" alt=""></button> --}}
                    </div>
                </div>
                <div class="gantt-task-body" id="otherDiv">
                    {{-- 상위 업무 --}}
                    @forelse ($data['task'] as $key => $item)
                        <div class="gantt-task" id="gantt-task-{{$item->id}}">
                            <div class="gantt-editable-div editable">
                                <div class="task-top-icon">
                                    @if($item->depth_1)
                                    <button onclick="toggleChildTask({{$item->id}})" id="toptaskbtn{{$item->id}}"><img id="iconimg{{$item->id}}" class="task-top-icon-img" src="/img/Group 202.png"></button>
                                @else
                                <button onclick="toggleChildTask({{$item->id}})" id="toptaskbtn{{$item->id}}"><img id="iconimg{{$item->id}}" class="task-top-icon-img" src=""></button>
                                @endif
                                </div>
                            
                                <div class="taskKey">{{$item->task_number}}</div>
                                <div class="taskChildPosition" style="display: none"></div>
                                <div class="taskName editable-title" spellcheck="false" contenteditable="true">{{$item->title}}</div>
                            </div>
                            {{-- 담당자/상태/시작일/마감일/더보기버튼 --}}
                            <div class="task-flex">
                                <div class="responName">
                                    <span class="respon-name-span" id="responNameSpan">{{$item->res_name}}</span>
                                    <div class="add_responsible_gantt d-none"></div>
                                </div>
                                
                                <div class="gantt-status-name">
                                    <div class="statusName gantt-status-color" data-status="{{$item->status_name}}">
                                        <span class="status-name-span" id="statusNameSpan">{{$item->status_name}}</span>
                                    </div>
                                    <div class="add_status_gantt d-none"></div>
                                </div>
                                <div class="gantt-task-4">
                                    <input type="date" class="start-date" name="start" id="start-row{{$item->id}}" onchange="test({{$item->id}});" value="{{$item->start_date}}">
                                </div>
                                <div class="gantt-task-5">
                                    <input type="date" class="end-date" name="end" id="end-row{{$item->id}}" onchange="test({{$item->id}});" value="{{$item->end_date}}">
                                </div>
                                <div class="gantt-more-btn">
                                    <button class="gantt-task-detail-click">
                                        <span class="gantt-task-detail-click-span">…</span>
                                    </button>
                                    <div class="gantt-detail" style="display: none">
                                        <button class="gantt-detail-btn" onclick="openTaskModal(1,0,{{$item->id}})">자세히보기</button>
                                        <br>
                                        <button class="gantt-detail-btn" onclick="addSubTask(event, {{$item->id}})">하위업무 추가</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- 하위 업무 --}}
                        @forelse ($item->depth_1 as $item2)
                            <div class="gantt-task gantt-child-task" id="gantt-task-{{$item2->id}}" parent="{{$item2->task_parent}}">
                                <div class="gantt-editable-div editable">
                                    
                                    <div class="taskKey" style="display: none">{{$item2->task_number}}</div>
                                    <div class="taskChildPosition"></div>
                                    <div class="task-top-icon"><img class="task-bottom-icon-img" src="/img/Groupfdg.png" alt=""></div>
                                    <div class="taskName editable-title" spellcheck="false" contenteditable="true">{{$item2->title}}</div>
                                </div>
                                <div class="task-flex">
                                    <div class="responName">
                                        <span class="respon-name-span" id="responNameSpan">{{$item2->res_name}}</span>
                                        <div class="add_responsible_gantt otherColor d-none"></div>
                                    </div>
                                    
                                    <div class="gantt-status-name">
                                        <div class="statusName gantt-status-color" data-status="{{$item2->status_name}}">
                                            <span class="status-name-span" id="statusNameSpan">{{$item2->status_name}}</span>
                                        </div>
                                        <div class="add_status_gantt d-none"></div>
                                    </div>
                                    <div class="gantt-task-4">
                                        <input type="date" class="start-date" name="start" id="start-row{{$item2->id}}" onchange="test({{$item2->id}});" value="{{$item2->start_date}}">
                                    </div>
                                    <div class="gantt-task-5">
                                        <input type="date" class="end-date" name="end" id="end-row{{$item2->id}}" onchange="test({{$item2->id}});" value="{{$item2->end_date}}">
                                    </div>
                                    <div class="gantt-more-btn">
                                        <button class="gantt-task-detail-click">
                                            <span class="gantt-task-detail-click-span">…</span>
                                        </button>
                                        <div class="gantt-detail" style="display: none">
                                            <button class="gantt-detail-btn" onclick="openTaskModal(1,0,{{$item2->id}})">자세히보기</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            
                        @endforelse
                    @empty
                        <div class="gantt-task d-none" id="gantt-task-000">
                            <div class="gantt-editable-div editable">
                                <button class="gantt-task-detail-click"><span class="gantt-task-detail-click-span">…</span></button>
                                <div class="gantt-detail" style="display: none">
                                    <button class="gantt-detail-btn" onclick="openTaskModal(1,0,000)">자세히보기</button>
                                    <br>
                                    <button class="gantt-detail-btn" onclick="addSubTask(event, 000)">하위업무 추가</button>
                                </div>     
                                <div class="taskKey" style="display: none">000</div>
                                <div class="taskChildPosition" style="display: none"></div>
                                <div class="taskName editable-title" spellcheck="false" contenteditable="true"></div>
                            </div>
                            <div class="responName"><span id="responNameSpan"></span></div>
                            <div class="gantt-status-name">
                                <div class="statusName gantt-status-color" data-status="000"><span id="statusNameSpan"></span></div>
                            </div>
                            <div class="gantt-task-4">
                                <input type="date" class="start-date" name="start" id="start-row000" onchange="test(000);" value="">
                            </div>
                            <div class="gantt-task-5">
                                <input type="date" class="end-date" name="end" id="end-row000" onchange="test(000);" value="">
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            <div  class="resizer" id="dragMe"></div>
            <div class="gantt-chart-wrap scroll-style">
                <div class="gantt-chart-container">
                    <div class="gantt-chart-header">
                        {{-- <div class="gantt-header-month"></div> --}}
                        <div class="gantt-header-scroll">
                            {{-- 날짜를 가로로 나열할 부분 --}}
                        </div>
                    </div>
                    <div class="gantt-chart-body" id="ganttTaskWrap">
                        @forelse ($data['task'] as $key => $item)
                            <div class="gantt-chart" id="gantt-chart-{{$item->id}}">
                                @php
                                    $startDate = new DateTime('2024-01-01');
                                    $endDate = new DateTime('2024-03-31');

                                    for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
                                        echo "<div id='row" . ($item->id) . "-" . $date->format('Ymd') . "'></div>";
                                    }
                                @endphp
                            </div>
                            @forelse ($item->depth_1 as $item2)
                                <div class="gantt-chart gantt-child-chart" id="gantt-chart-{{$item2->id}}" parent="{{$item2->task_parent}}">
                                    @php
                                        $startDate = new DateTime('2024-01-01');
                                        $endDate = new DateTime('2024-03-31');

                                        for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
                                            echo "<div id='row" . ($item2->id) . "-" . $date->format('Ymd') . "'></div>";
                                        }
                                    @endphp
                                </div>
                            @empty
                                
                            @endforelse
                        @empty
                        <div class="gantt-chart" id="gantt-chart-000">
                            @php
                                $startDate = new DateTime('2024-01-01');
                                $endDate = new DateTime('2024-03-31');

                                for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
                                    echo "<div id='row"."-" . $date->format('Ymd') . "' class='d-none'></div>";
                                }
                            @endphp
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
    @include('modal.insert') 
    {{-- include 순서 중요: 작성/상세 --}}
    @include('modal.detail')

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endsection