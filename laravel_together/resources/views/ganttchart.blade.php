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
{{-- 상단바 --}}
<div class="first_menu">
    <div class="menu_title">
        <div class="title_bar">
            <div class="project_color" style="background-color:{{$color_code[0]->data_content_name}}"></div>
            <input class="project_title" type="text" name="project_title" id="project_title" placeholder="프로젝트명" value="{{$result->project_title}}" onchange="titleupdate({{$result->id}})">
        </div>
        <textarea class="project_content" name="project_content" id="project_content" placeholder="설명" onchange="titleupdate({{$result->id}})">{{$result->project_content}}</textarea>
    </div>

    <div class="title_rightgrid">
        <div class="title_img"><button onclick="openDeleteModal()"><img class="title_img2"src="/img/garbage(white).png" alt=""></button></div>
            {{-- 삭제 모달창 --}}
            <div id="deleteModal">
                <div class="deletemodal-content">
                    <p class="deletespan">정말로 삭제하시겠습니까?</p>
                    <div class="gridbutton">
                        <button class="deletebutton" type="button" onclick="closeDeleteModal()">취소</button>
                        <button class="closebutton" type="button" id=delete onclick="deleteProject({{$result->id}})">삭제</button>
                    </div>
                </div>
            </div>
        {{-- <div class="dday">D-{{$result->dday}}</div> --}}
        <div class="date_set">
            <label for="dday">
                <div class="dday" id="dday">
                    @if($result->dday === 0)
                        <div class="dday">D-day</div>
                    @elseif($result->dday > 0)
                        <div class="dday">D-{{$result->dday}}</div>
                    @else
                        
                    @endif
                </div>
            </label>
            <label class="project_label" for="start_date"> 시작일
                {{-- <input class="date" type="date" name="start_date" id="start_date" onchange="total()" value="{{$result->start_date}}"> --}}
                <input class="project_date" type="date" name="start_date" id="start_date" onchange="titleupdate({{$result->id}})" value="{{$result->start_date}}">
            </label>
            <label class="project_label" for="end_date"> 마감일
                {{-- <input class="date" type="date" name="end_date" id="end_date" onchange="total()" value="{{$result->end_date}}" min="{{$result->start_date}}"> --}}
                <input class="project_date" type="date" name="end_date" id="end_date" onchange="titleupdate({{$result->id}})" value="{{$result->end_date}}">
            </label>
        </div>
    </div>
</div>
<div class="tabset">
    <a href="{{ route('individual.get', ['id' => $result->id]) }}">피드</a>
    <a href="">간트차트</a>
    {{-- <button class="tabmenu active" onclick="openTab(event,field)">피드</button>
    <button class="tabmenu" onclick="openTab(event,gantt)">간트차트</button> --}}
</div>
    {{-- <div class="hr"></div> --}}
    {{-- 피드공통 헤더끝 --}}
    <div class="gantt-btn-wrap">
        <input class="gantt-search" type="input" id="keySearch" onkeyup="enterkeySearch()" placeholder="   업무명, 담당자, 상태 검색">
        <div>
            <div id="list1" class="gantt-dropdown-check-list" tabindex="100">
                <div class="gantt-span">
                    <span>상태</span>
                    <img class="gantt-filter" src="/img/gantt-filter.png" alt="filter">
                </div>
                <ul class="gantt-items">
                    <li><input type="checkbox" name="status" value="status1" onclick="getCheckboxValue()" checked><div class="gantt-color gantt-status1"></div><span class="gantt-item">시작전</span></li>
                    <li><input type="checkbox" name="status" value="status2" onclick="getCheckboxValue()" checked><div class="gantt-color gantt-status2"></div><span class="gantt-item">진행중</span></li>
                    <li><input type="checkbox" name="status" value="status3" onclick="getCheckboxValue()" checked><div class="gantt-color gantt-status3"></div><span class="gantt-item">피드백</span></li>
                    <li><input type="checkbox" name="status" value="status4" onclick="getCheckboxValue()" checked><div class="gantt-color gantt-status4"></div><span class="gantt-item">완료</span></li>
                </ul>
            </div>
            <div id="list2" class="gantt-dropdown-check-list" tabindex="100">
                <div class="gantt-span">
                    <span>우선순위</span>
                    <img class="gantt-filter" src="/img/gantt-filter.png" alt="filter">
                </div>
                <ul class="gantt-items">
                    <li><input type="checkbox" name="priority" value="priority1" onclick="getCheckboxValue()"><img class="gantt-rank" src="/img/gantt-bisang.png" alt=""><span
                            class="gantt-item">긴급</span></li>
                    <li><input type="checkbox" name="priority" value="priority1" onclick="getCheckboxValue()"><img class="gantt-rank" src="/img/gantt-up.png" alt=""><span
                            class="gantt-item">높음</span></li>
                    <li><input type="checkbox" name="priority" value="priority1" onclick="getCheckboxValue()"><img class="gantt-rank" src="/img/gantt-line.png" alt=""><span
                            class="gantt-item">보통</span></li>
                    <li><input type="checkbox" name="priority" value="priority1" onclick="getCheckboxValue()"><img class="gantt-rank" src="/img/gantt-down.png" alt=""><span
                            class="gantt-item">낮음</span></li>
                    <li><input type="checkbox" name="priority" value="priority1" onclick="getCheckboxValue()"><span class="gantt-item">없음</span></li>
                </ul>
            </div>
            <div id="list3" class="gantt-dropdown-check-list" tabindex="100">
                <div class="gantt-span">
                    <span>담당자</span>
                    <img class="gantt-filter" src="/img/gantt-filter.png" alt="filter">
                </div>
                <ul class="gantt-items">
                    @foreach (array_unique(array_column($data, 'name')) as $itemName)
                        <li><input type="checkbox" onclick="getCheckboxValue()"><span class="gantt-item">{{ $itemName }}</span></li>
                    @endforeach
                </ul>
            </div>
            <div id="list4" class="gantt-dropdown-check-list" tabindex="100">
                <div class="gantt-span">
                    <span>시작일</span>
                    <img class="gantt-filter" src="/img/gantt-filter.png" alt="filter">
                </div>
                <ul class="gantt-items">
                    <li><input name="start" type="radio" onclick="getCheckboxValue()" checked><span class="gantt-item">전체</span></li>
                    <li><input name="start" type="radio" onclick="getCheckboxValue()"><span class="gantt-item">오늘</span></li>
                    <li><input name="start" type="radio" onclick="getCheckboxValue()"><span class="gantt-item">이번주</span></li>
                    <li><input name="start" type="radio" onclick="getCheckboxValue()"><span class="gantt-item">이번달</span></li>
                </ul>
            </div>
            <div id="list5" class="gantt-dropdown-check-list" tabindex="100">
                <div class="gantt-span">
                    <span>마감일</span>
                    <img class="gantt-filter" src="/img/gantt-filter.png" alt="filter">
                </div>
                <ul class="gantt-items">
                    <li><input name="end" type="radio" checked><span class="gantt-item">전체</span></li>
                    <li><input name="end" type="radio"><span class="gantt-item">오늘</span></li>
                    <li><input name="end" type="radio"><span class="gantt-item">이번주</span></li>
                    <li><input name="end" type="radio"><span class="gantt-item">이번달</span></li>
                </ul>
            </div>
            <button class="gantt-add-btn" onclick="openTaskModal(0)">업무추가</button>
            {{-- <button class="gantt-update-btn gantt-add-btn" type="submit">업무수정</button> --}}
        </div>
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
                    <div class="gantt-task-header-div" style="width: 30%">
                        <span class="gantt-order">업무명</span>
                        <button type="button"><img src="/img/table4.png" alt=""></button>
                    </div>
                    <div class="gantt-task-header-div" style="width: 16%">
                        <span class="gantt-order">담당자</span>
                        <button type="button"><img src="/img/table4.png" alt=""></button>
                    </div>
                    <div class="gantt-task-header-div" style="width: 18%">
                        <span class="gantt-order">상태</span>
                        <button type="button"><img src="/img/table4.png" alt=""></button>
                    </div>
                    <div class="gantt-task-header-div" style="width: 18%">
                        <span class="gantt-order">시작일</span>
                        <button type="button"><img src="/img/table4.png" alt=""></button>
                    </div>
                    <div class="gantt-task-header-div" style="width: 18%">
                        <span class="gantt-order">마감일</span>
                        <button type="button"><img src="/img/table4.png" alt=""></button>
                    </div>
                </div>
                <div class="gantt-task-body">
                    @forelse ($data['task'] as $key => $item)
                        <div class="gantt-task" id="gantt-task-{{$item->id}}">
                            <div class="gantt-editable-div editable">
                                <button class="gantt-task-detail-click"><span class="gantt-task-detail-click-span">…</span></button>
                                <div class="gantt-detail" style="display: none">
                                    <button class="gantt-detail-btn" onclick="openTaskModal(1,0,{{$item->id}})">자세히보기</button>
                                    <br>
                                    <button class="gantt-detail-btn" onclick="addSubTask(event, {{$item->id}})">하위업무 추가</button>
                                </div>     
                                <div class="taskKey" style="display: none">{{$item->task_number}}</div>
                                <div class="taskChildPosition" style="display: none"></div>
                                <div class="taskName editable-title" spellcheck="false" contenteditable="true">{{$item->title}}</div>
                            </div>
                            <div class="responName gantt-update-dropdown"><span id="responNameSpan">{{$item->res_name}}</span></div>
                            <div class="gantt-status-name">
                                <div class="statusName gantt-status-color gantt-update-dropdown" data-status="{{$item->status_name}}"><span id="statusNameSpan">{{$item->status_name}}</span></div>
                            </div>
                            <div class="gantt-task-4">
                                <input type="date" class="start-date" name="start" id="start-row{{$item->id}}" onchange="test({{$item->id}});" value="{{$item->start_date}}">
                            </div>
                            <div class="gantt-task-5">
                                <input type="date" class="end-date" name="end" id="end-row{{$item->id}}" onchange="test({{$item->id}});" value="{{$item->end_date}}">
                            </div>
                        </div>
                        @forelse ($item->depth_1 as $item2)
                        <div class="gantt-task gantt-child-task" id="gantt-task-{{$item2->id}}" parent="{{$item2->task_parent}}">
                            <div class="gantt-editable-div editable">
                                <button class="gantt-task-detail-click"><span class="gantt-task-detail-click-span">…</span></button>
                                <div class="gantt-detail" style="display: none">
                                    <button class="gantt-detail-btn" onclick="openTaskModal(1,0,{{$item2->id}})">자세히보기</button>
                                </div>     
                                <div class="taskKey" style="display: none">{{$item2->task_number}}</div>
                                <div class="taskChildPosition"></div>
                                <div class="taskName editable-title" spellcheck="false" contenteditable="true">{{$item2->title}}</div>
                            </div>
                            <div class="responName gantt-update-dropdown"><span id="responNameSpan">{{$item2->res_name}}</span></div>
                            <div class="gantt-status-name">
                                <div class="statusName gantt-status-color gantt-update-dropdown" data-status="{{$item2->status_name}}"><span id="statusNameSpan">{{$item2->status_name}}</span></div>
                            </div>
                            <div class="gantt-task-4">
                                <input type="date" class="start-date" name="start" id="start-row{{$item2->id}}" onchange="test({{$item2->id}});" value="{{$item2->start_date}}">
                            </div>
                            <div class="gantt-task-5">
                                <input type="date" class="end-date" name="end" id="end-row{{$item2->id}}" onchange="test({{$item2->id}});" value="{{$item2->end_date}}">
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
                            <div class="responName gantt-update-dropdown"><span id="responNameSpan"></span></div>
                            <div class="gantt-status-name">
                                <div class="statusName gantt-status-color gantt-update-dropdown" data-status="000"><span id="statusNameSpan"></span></div>
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
            <div class="gantt-chart-wrap scroll-style">
                <div class="gantt-chart-container">
                    <div class="gantt-chart-header">
                        <div class="gantt-header-scroll">
                            {{-- 날짜를 가로로 나열할 부분 --}}
                        </div>
                    </div>
                    <div class="gantt-chart-body">
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

    @include('modal.insert') 
    {{-- include 순서 중요: 작성/상세 --}}
    @include('modal.detail')

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endsection