@extends('layout.layout')
@section('title', '대시보드')
@section('main')
  {{-- 컨텐츠 헤더 --}}
  <div class="content-wrapper-header">
    {{-- 유저 이름 --}}
    <span>{{$user->name}}님</span>
    {{-- 오늘 날짜 --}}
    <span>🌈 2023년 12월 11일 월요일</span>
  </div>
 
  {{-- 컨텐츠 섹션 --}}
  <div class="content-section">

  {{-- 1 업무상태 --}}
  <div class="app-card1"> 
    <span class="app-card-title">
     업무상태
    </span>
    <div class="app-card__subtext"></div>
    <div class="app-card-buttons"></div>
   </div>

   {{-- 2 공지 --}}
   <div class="app-card2"> 
    <span class="app-card-title">
     공지
    </span>
    <div class="app-card__subtext"></div>
    <div class="app-card-buttons"></div>
   </div>
    {{-- 2섹션 --}}
    <div class="content-section-2">
      <div class="content-section-3">
    {{-- 3  --}}
    <div class="app-card3"> 
      <span class="app-card-title">
      개인 프로젝트 진척률
      </span>
      <div class="app-card__subtext"></div>
      <div class="app-card-buttons"></div>
    </div>
      {{-- 3  --}}
      <div class="app-card3-2"> 
        <span class="app-card-title">
      팀 프로젝트 진척률
        </span>
        <div class="app-card__subtext"></div>
        <div class="app-card-buttons"></div>
       </div>
      </div>
   
    {{-- 3  --}}
    <div class="app-card4"> 
      <span class="app-card-title">
       마감
      </span>
      <div class="app-card__subtext"></div>
      <div class="app-card-buttons"></div>
     </div>
  
    </div>

 </div>

@endsection