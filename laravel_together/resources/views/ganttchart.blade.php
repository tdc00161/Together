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
		<button class="tabmenu" onclick="openTab(event,field)">피드</button>
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
						<li><input type="checkbox" checked>시작전</li>
						<li><input type="checkbox" checked>진행중</li>
						<li><input type="checkbox" checked>피드백</li>
						<li><input type="checkbox" checked>완료</li>
					</ul>
				</div>	
				<div id="list2" class="gantt-dropdown-check-list" tabindex="100">
					<span class="gantt-span">우선순위</span>
					<ul class="gantt-items">
						<li><input type="checkbox" ><img class="gantt-rank" src="/img/gantt-bisang.png" alt="">긴급</li>
						<li><input type="checkbox" ><img class="gantt-rank" src="/img/gantt-up.png" alt="">높음</li>
						<li><input type="checkbox" ><img class="gantt-rank" src="/img/gantt-line.png" alt="">보통</li>
						<li><input type="checkbox" ><img class="gantt-rank" src="/img/gantt-down.png" alt="">낮음</li>
						<li><input type="checkbox" >없음</li>
					</ul>
				</div>
				<div id="list3" class="gantt-dropdown-check-list" tabindex="100">
					<span class="gantt-span">담당자</span>
					<ul class="gantt-items">
						<li><input type="checkbox" >김관호</li>
						<li><input type="checkbox" >김민주</li>
						<li><input type="checkbox" >양수진</li>
						<li><input type="checkbox" >양주은</li>
					</ul>
				</div>
				<div id="list4" class="gantt-dropdown-check-list" tabindex="100">
					<span class="gantt-span">시작일</span>
					<ul class="gantt-items">
						<li><input name="start" type="radio" checked>전체</li>
						<li><input name="start" type="radio" >오늘</li>
						<li><input name="start" type="radio" >이번주</li>
						<li><input name="start" type="radio" >이번달</li>
					</ul>
				</div>
				<div id="list5" class="gantt-dropdown-check-list" tabindex="100">
					<span class="gantt-span">마감일</span>
					<ul class="gantt-items">
						<li><input name="end" type="radio" checked>전체</li>
						<li><input name="end" type="radio" >오늘</li>
						<li><input name="end" type="radio" >이번주</li>
						<li><input name="end" type="radio" >이번달</li>
					</ul>
				</div>
				<button class="gantt-add-btn" onclick="">업무추가</button>
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
				<div class="gantt-task ganttTask">
					<div id="gantt-editable-div" class="editable">업무명<img class="gantt-plus-img" src="/img/gantt-plus.png" alt=""></div>
					<div class="gantt-dropdown" id="gantt-teamDropdown">
						<span id="gantt-currentTeam" onclick="toggleDropdown()">김민주</span>
						<ul class="gantt-dropdown-content" id="gantt-teamOptions">
							<li><a href="#" onclick="changeName('김관호')">김관호</a></li>
							<li><a href="#" onclick="changeName('김민주')">김민주</a></li>
							<li><a href="#" onclick="changeName('양수진')">양수진</a></li>
							<li><a href="#" onclick="changeName('양주은')">양주은</a></li>
						</ul>
					</div>
					<div>시작전</div>
					<div><input type="date" name="start" id="start-row1" onchange="test('1');"></div>
					<div><input type="date" name="end" id="end-row1" onchange="test('1');"></div>
				</div>
				<div class="gantt-task ganttTask">
					<div id="gantt-editable-div" class="editable">업무명<img class="gantt-plus-img" src="/img/gantt-plus.png" alt=""></div>
					<div class="gantt-dropdown" id="gantt-teamDropdown">
						<span>김민주</span>
					</div>
					<div>시작전</div>
					<div><input type="date" name="start" id="start-row2" onchange="test('2');"></div>
					<div><input type="date" name="end" id="end-row2" onchange="test('2');"></div>
				</div>
				<div class="gantt-task ganttTask">
					<div id="gantt-editable-div" class="editable">업무명<img class="gantt-plus-img" src="/img/gantt-plus.png" alt=""></div>
					<div>김민주</div>
					<div>시작전</div>
					<div><input type="date" name="start" id="start-row3" onchange="test('3');"></div>
					<div><input type="date" name="end" id="end-row3" onchange="test('3');"></div>
				</div>
				<div class="gantt-task ganttTask">
					<div id="gantt-editable-div" class="editable">업무명<img class="gantt-plus-img" src="/img/gantt-plus.png" alt=""></div>
					<div>김민주</div>
					<div>시작전</div>
					<div><input type="date" name="start" id="start-row4" onchange="test('4');"></div>
					<div><input type="date" name="end" id="end-row4" onchange="test('4');"></div>
				</div>
			</div>
			<div class="gantt-chart-wrap">
				<div class="gantt-chart-container">
					<div class="gantt-chart-header">
						<div class="gantt-header-scroll">
							{{-- 날짜를 가로로 나열할 부분 --}}
						</div>
					</div>
					<div class="gantt-chart-body">
						<div class="gantt-chart">
							@php
								$startDate = new DateTime('2023-12-01');
								$endDate = new DateTime('2023-12-31');

								for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
									echo "<div id='row1-" . $date->format('Ymd') . "'></div>";
								}
							@endphp
						</div>
						{{-- <tr>
							<td id="row1-20231201"></td>
							<td id="row1-20231202"></td>
							<td id="row1-20231203"></td>
							<td id="row1-20231204"></td>
							<td id="row1-20231205"></td>
						</tr> --}}
						<div class="gantt-chart">
							@php
								$startDate = new DateTime('2023-12-01');
								$endDate = new DateTime('2023-12-31');

								for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
									echo "<div id='row2-" . $date->format('Ymd') . "'></div>";
								}
							@endphp
						</div>
						<div class="gantt-chart">
							@php
								$startDate = new DateTime('2023-12-01');
								$endDate = new DateTime('2023-12-31');

								for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
									echo "<div id='row3-" . $date->format('Ymd') . "'></div>";
								}
							@endphp
						</div>
						<div class="gantt-chart">
							@php
								$startDate = new DateTime('2023-12-01');
								$endDate = new DateTime('2023-12-31');

								for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
									echo "<div id='row4-" . $date->format('Ymd') . "'></div>";
								}
							@endphp
						</div>
					</div>
				</div>
			</div>
			
			<div>

				</div>
			</section>	
		</div>
	</div>

	<script src="/js/ganttchart.js"></script>
@endsection