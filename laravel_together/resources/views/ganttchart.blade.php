@extends('layout.layout')
@section('gantt_link')
<script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
<link href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css" rel="stylesheet">
@endsection
@section('title', '대시보드')
@section('main')
	<div class="gantt-content-wrap">
		<div class="gantt-btn-wrap">
			<input type="search" name="" id="" value="업무명, 업무번호 검색">
			<ul class="gantt-btn-drop">
				<li>상태</li>
				<li>우선순위</li>
				<li>담당자</li>
				<li>시작일</li>
				<li>마감일</li>
				<button class="gantt-add-btn">업무추가</button>
			</ul>
		</div>
		<div class="gantt-task-wrap">
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
		<div class="gantt-chart-wrap">

		</div>
	</div>
@endsection