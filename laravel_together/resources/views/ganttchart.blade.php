@extends('layout.layout')
@section('gantt_link')
<link rel="stylesheet" href="/css/ganttchart.css">
@endsection
@section('title', '대시보드')
@section('main')
	<div class="gantt-content-wrap">
		<div class="gantt-btn-wrap">
			<input class="gantt-search" type="search" name="" id="" value="업무명, 업무번호 검색">
			<ul class="gantt-btn-drop">
				<li class="gantt-li">상태</li>
				<li class="gantt-li">우선순위</li>
				<li class="gantt-li">담당자</li>
				<li class="gantt-li">시작일</li>
				<li class="gantt-li">마감일</li>
			</ul>
			<button class="gantt-add-btn">업무추가</button>
		</div>
		<section class="gantt-task-wrap">
			<div>
				<div class="gantt-task-header">
					<div>업무명</div>
					<div>담당자</div>
					<div>상태</div>
					<div>시작일</div>
					<div>마감일</div>
				</div>
				<div>

				</div>
			</div>
			<div>
				<div class="gantt-chart-wrap">

				</div>
			</div>
			
			<div>

			</div>
		</section>	
	</div>
@endsection