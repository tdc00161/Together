@extends('modal.detail')
@extends('modal.insert')
{{-- @extends('layout.layout') --}}

<head>
    <link rel="stylesheet" href="/css/insert_detail.css">
	<script defer src="/js/insert_detail.js"></script>
</head>

<body>
    {{-- @section('main') --}}
        <button onclick="openDetailModal()">상세모달 오픈</button>
        <button onclick="openInsertModal()">작성모달 오픈</button>
        <button onclick="changTaskNotice()">상세모달 업무/글</button>
    {{-- @endsection --}}
</body>