@extends('layout.layout')
@section('gantt_link')
<link rel="stylesheet" href="/css/ganttchart.css">
@endsection
@section('title', '간트차트')
@section('main')
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
				<div>
					<button onclick="openModal()">상세모달</button>
				</div>
			</div>
			<div class="gantt-chart-wrap">
				<div>
					
				</div>
			</div>
			
			<div>
				
			</div>
		</section>	
	</div>
	<div class="main-container">
		<div class="content-wrapper">
			@extends('modal.detail')
		</div>
	</div>
	@endsection