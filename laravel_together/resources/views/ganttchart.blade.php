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
	<div>
		<div class="tab_menu">피드</div>
		<div  class="tab_menu">간트차트</div>
	</div>
	<div class="hr"></div>
	{{-- 피드공통 헤더끝 --}}
	<div class="gantt-content-wrap">
		<div class="gantt-btn-wrap">
			<input class="gantt-search" type="search" placeholder="   업무명, 업무번호 검색">
			<div>
				<img src="/img/filter.png" alt="filter">
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
						<li><input type="checkbox" >긴급</li>
						<li><input type="checkbox" >높음</li>
						<li><input type="checkbox" >보통</li>
						<li><input type="checkbox" >낮음</li>
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
				<button class="gantt-add-btn">업무추가</button>
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
				<div class="gantt-task">
					<div id="gantt-editable-div" class="editable">업무명</div>
					<div>김민주</div>
					<div>시작전</div>
					<div><input type="date" name="sat" id="start-row1" onchange="test('1');"></div>
					<div><input type="date" name="eat" id="end-row1" onchange="test('1');"></div>
				</div>
				<div class="gantt-task">
					<div id="gantt-editable-div" class="editable">업무명</div>
					<div>김민주</div>
					<div>시작전</div>
					<div><input type="date" name="sat" id="start-row1" onchange="test('1');"></div>
					<div><input type="date" name="eat" id="end-row1" onchange="test('1');"></div>
				</div>
				<div class="gantt-task">
					<div id="gantt-editable-div" class="editable">업무명</div>
					<div>김민주</div>
					<div>시작전</div>
					<div><input type="date" name="sat" id="start-row1" onchange="test('1');"></div>
					<div><input type="date" name="eat" id="end-row1" onchange="test('1');"></div>
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
						{{-- <div id="gantt-chart">

						</div> --}}
						{{-- 간트 차트 본문 부분 --}}
						<div id="row1-20231201"></div>
						<div id="row1-20231202"></div>
						<div id="row1-20231203"></div>
						<div id="row1-20231204"></div>
						<div id="row1-20231205"></div>
						<div id="row1-20231206"></div>
						<div id="row1-20231207"></div>
						<div id="row1-20231208"></div>
						<div id="row1-20231209"></div>
						<div id="row1-20231210"></div>
					</div>
				</div>
			</div>
			
			<div>

			</div>
		</section>	
	</div>
@endsection