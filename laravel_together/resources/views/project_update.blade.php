@extends('layout.layout')
@section('link')
    <link rel="stylesheet" href="/css/project_update.css">
    <script src="/js/projectupdate.js" defer></script>
@endsection
@section('main')
    <header>
        <button class="project-update" type="button" onclick="goBack()"><</button>
        <span class="project-update" style="margin-left: 24px">프로젝트 수정</span>
    </header>

    @forelse ($project_info as $item)
    <form action="{{ route('project.updateput', ['id' => $projectid]) }}" method="post">
    @csrf
    @method('PUT')
    <div class="section-content">
        <div class="section-0">
            <p style="font-size: 15px;">프로젝트 제목</p>
            <span class="d-inline-block" name="project_content" id="project_content" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="프로젝트 제목은 최대 16자 까지 작성 가능 합니다.">
                <div class="explanation-icon-update">?</div>
            </span>
            <input class="project-start-date" name="start_date" type="date" value="{{$item->start_date}}">
            <span class="project_date_ing">~</span>
            <input class="project-end-date" name="end_date" type="date" value="{{$item->end_date}}">
        </div>
        
        <div class="section-1">
            <input class="project-update-input" maxlength="16" name="project_title" type="text" autocomplete="off" value="{{$item->project_title}}">
        </div>

        <div class="section-2">
            <div class="section-0">
            <p style="font-size: 15px;">프로젝트 설명</p>
            <span class="d-inline-block" name="project_content" id="project_content" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="프로젝트 설명은 최대 44자 까지 작성 가능 합니다.">
                <div class="explanation-icon-update">?</div>
            </span>
            </div>
            <textarea class="project-content" maxlength="44" name="project_content" autocomplete="off" cols="30" rows="10">{{$item->project_content}}</textarea>
        </div>
    </div>

    <div class="center"><button class="update-btn" type="submit">수정 완료</button></div>
    </form>
    @empty
        
    @endforelse

@endsection