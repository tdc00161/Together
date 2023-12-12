@extends('layout.layout')
{{-- css링크 --}}
@section('link')
<link rel="stylesheet" href="/css/modal.css">
@endsection
@section('title', '작성모달')

@section('main')
<div class="insert_page">
	<div class="modal">
		<div class="modal_header">
			<div>
				<span>ㅁ</span>
				<span>Project</span>
				<span>|</span>
				<span>글</span>
			</div>
			<span>X</span>
		</div>
		<div class="modal_main">
			<input class="modal_title" type="text" placeholder="제목을 입력하세요">
			<textarea class="modal_content" name="" id="" cols="30" rows="10" placeholder="내용을 입력하세요"></textarea>
		</div>
		<div class="modal_footer">
			<button>등록</button>
		</div>
	</div>
</div>
@endsection