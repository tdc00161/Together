@extends('layout.layout')
@section('gantt_link')
    <link rel="stylesheet" href="/css/ganttchart.css">
@endsection
@section('title', '간트차트')
@section('main')
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
                <span class="date"></span>
            </label>
            <label for="start_date"> 시작일
                <input class="date" type="date" name="start_date">
            </label>
            <label for="end_date"> 마감일
                <input class="date" type="date" name="end_date">
            </label>
        </div>
    </div>
    <div class="tabset">
        <a href="" class="tabmenu">피드</a>
        <button class="gantt-tabmenu active" onclick="openTab(event,gantt)">간트차트</button>
    </div>
    {{-- <div class="hr"></div> --}}
    {{-- 피드공통 헤더끝 --}}
    <div class="gantt-content-wrap">
        <div class="gantt-btn-wrap">
            <input class="gantt-search" type="search" placeholder="   업무명, 업무번호 검색">
            <div>
                <img class="gantt-filter" src="/img/gantt-filter.png" alt="filter">
                <div id="list1" class="gantt-dropdown-check-list" tabindex="100">
                    <span class="gantt-span">상태</span>
                    <ul class="gantt-items">
                        <li><input type="checkbox" checked><span class="gantt-item">시작전</span></li>
                        <li><input type="checkbox" checked><span class="gantt-item">진행중</span></li>
                        <li><input type="checkbox" checked><span class="gantt-item">피드백</span></li>
                        <li><input type="checkbox" checked><span class="gantt-item">완료</span></li>
                    </ul>
                </div>
                <div id="list2" class="gantt-dropdown-check-list" tabindex="100">
                    <span class="gantt-span">우선순위</span>
                    <ul class="gantt-items">
                        <li><input type="checkbox"><img class="gantt-rank" src="/img/gantt-bisang.png" alt=""><span
                                class="gantt-item">긴급</span></li>
                        <li><input type="checkbox"><img class="gantt-rank" src="/img/gantt-up.png" alt=""><span
                                class="gantt-item">높음</span></li>
                        <li><input type="checkbox"><img class="gantt-rank" src="/img/gantt-line.png" alt=""><span
                                class="gantt-item">보통</span></li>
                        <li><input type="checkbox"><img class="gantt-rank" src="/img/gantt-down.png" alt=""><span
                                class="gantt-item">낮음</span></li>
                        <li><input type="checkbox"><span class="gantt-item">없음</span></li>
                    </ul>
                </div>
                <div id="list3" class="gantt-dropdown-check-list" tabindex="100">
                    <span class="gantt-span">담당자</span>
                    <ul class="gantt-items">
                        <li><input type="checkbox"><span class="gantt-item">김관호</span></li>
                        <li><input type="checkbox"><span class="gantt-item">김민주</span></li>
                        <li><input type="checkbox"><span class="gantt-item">양수진</span></li>
                        <li><input type="checkbox"><span class="gantt-item">양주은</span></li>
                    </ul>
                </div>
                <div id="list4" class="gantt-dropdown-check-list" tabindex="100">
                    <span class="gantt-span">시작일</span>
                    <ul class="gantt-items">
                        <li><input name="start" type="radio" checked><span class="gantt-item">전체</span></li>
                        <li><input name="start" type="radio"><span class="gantt-item">오늘</span></li>
                        <li><input name="start" type="radio"><span class="gantt-item">이번주</span></li>
                        <li><input name="start" type="radio"><span class="gantt-item">이번달</span></li>
                    </ul>
                </div>
                <div id="list5" class="gantt-dropdown-check-list" tabindex="100">
                    <span class="gantt-span">마감일</span>
                    <ul class="gantt-items">
                        <li><input name="end" type="radio" checked><span class="gantt-item">전체</span></li>
                        <li><input name="end" type="radio"><span class="gantt-item">오늘</span></li>
                        <li><input name="end" type="radio"><span class="gantt-item">이번주</span></li>
                        <li><input name="end" type="radio"><span class="gantt-item">이번달</span></li>
                    </ul>
                </div>
                <button class="gantt-add-btn" onclick="openTaskModal(0)">업무추가</button>
            </div>
        </div>
        <section class="gantt-all-task">
            <div class="gantt-task-wrap">
                <div class="gantt-task-header">
                    <div>업무명</div>
                    <div>담당자</div>
                    <div>상태</div>
                    <div>시작일</div>
                    <div>마감일</div>
                </div>
                <div class="gantt-task-body">
                    @foreach ($data as $key => $item)
                        <div class="gantt-task" id="ganttTask">
                            <div class="gantt-editable-div editable" onmouseover="showDropdown(this)" onmouseout="hideDropdown(this)">
                                <span class="editable-title">{{$item->title}}</span>
                                <img class="gantt-plus-img" src="/img/gantt-plus.png" alt="">
                                <div class="gantt-detail">
                                    <button class="gantt-detail-btn" onclick="openTaskModal(1)">자세히보기</button>
                                </div>
                            </div>
                            <div class="gantt-dropdown">
                                <span>{{$item->task_responsible_id}}</span>
                            </div>
                            <div>{{$item->task_status_name}}</div>
                            <div><input type="date" name="start" id="start-row{{$key+1}}" onchange="test('{{$key+1}}');" value="{{$item->start_date}}"></div>
                            <div><input type="date" name="end" id="end-row{{$key+1}}" onchange="test('{{$key+1}}');" value="{{$item->end_date}}"></div>
                        </div>
                    @endforeach
                </div>
                {{-- <div class="gantt-task ganttTask">
                    <div id="gantt-editable-div" class="editable">업무명<img class="gantt-plus-img"
                            src="/img/gantt-plus.png" alt=""></div>
                    <div class="gantt-dropdown" id="gantt-teamDropdown">
                        <span id="gantt-currentTeam" onclick="toggleDropdown(this)">김민주</span>
                        <ul class="gantt-dropdown-content" id="gantt-teamOptions">
                            <li><a href="#" onclick="changeName('김관호')">김관호</a></li>
                            <li><a href="#" onclick="changeName('김민주')">김민주</a></li>
                            <li><a href="#" onclick="changeName('양수진')">양수진</a></li>
                            <li><a href="#" onclick="changeName('양주은')">양주은</a></li>
                        </ul>
                    </div>
                    <div>{{$item->task_status_name}}</div>
                    <div><input type="date" name="start" id="start-row1" onchange="test('1');"></div>
                    <div><input type="date" name="end" id="end-row1" onchange="test('1');"></div>
                </div> --}}
            </div>
            <div class="gantt-chart-wrap">
                <div class="gantt-chart-container">
                    <div class="gantt-chart-header">
                        <div class="gantt-header-scroll">
                            {{-- 날짜를 가로로 나열할 부분 --}}
                        </div>
                    </div>
                    <div class="gantt-chart-body">
                        @foreach ($data as $key => $item)
                            <div class="gantt-chart" id="ganttChart">
                                @php
                                    $startDate = new DateTime('2023-12-01');
                                    $endDate = new DateTime('2023-12-31');

                                    for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
                                        echo "<div id='row" . ($key + 1) . "-" . $date->format('Ymd') . "'></div>";
                                    }
                                @endphp
                            </div>
                        @endforeach
                        {{-- <div class="gantt-chart">
                            @php
                                $startDate = new DateTime('2023-12-01');
                                $endDate = new DateTime('2023-12-31');

                                for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
                                    echo "<div id='row2-" . $date->format('Ymd') . "'></div>";
                                }
                            @endphp
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="/js/ganttchart.js"></script>
@endsection
