@extends('layout.layout')
@section('title', '대시보드')
@section('main')
  {{-- 컨텐츠 헤더 --}}
  <div class="content-wrapper-header">
    {{-- 유저 이름 --}}
    <span><span class="font-b">{{$user->name}}</span>님</span>
    {{-- 오늘 날짜 --}}
    <p class="today-date">🌈 {{$formatDate1}} {{$koreanDayOfWeek}}</p>
  </div>
 
  {{-- 컨텐츠 섹션 --}}
  <div class="content-section">

  {{-- 1 업무상태 --}}
  <div class="app-card1"> 
    <div class="app-card-title2">업무상태 현황</div>
    <canvas id="chartcanvas2" width="800" height="800"></canvas>
    <div class="color_div">
        <div class="color_set">
            <div class="color_box1"></div>
            <div class="color_name">시작전</div>
        </div>
        <div  class="color_set">
            <div class="color_box2"></div>
            <div class="color_name">진행중</div>
        </div>
        <div class="color_set">
            <div class="color_box3"></div>
            <div class="color_name">피드백</div>
        </div>
        <div  class="color_set">
            <div class="color_box4"></div>
            <div class="color_name">완료</div>
        </div>
    </div>

    {{-- <span class="app-card-title">
     업무상태
    </span>
    <div class="app-card__subtext"></div>
    <div class="app-card-buttons"></div> --}}
   </div>

   {{-- 2 공지 --}}
   <div class="app-card2"> 
    <span class="app-card-title">
     공지
    </span>
    {{-- <div class="carousel-container">
      <button class="prev d-notice-button" onclick="changeSlide(-1)">&#10094;</button>
      <div class="slides">

        <div class="app-card__subtext">
          @forelse ($dashboardNotice as $item)
          <div class="slide">
             <p class="notice-title">{{$item->title}}</p>
          </div>
          @empty
              
          @endforelse
          
        </div>
      </div>
      <button class="next d-notice-button" onclick="changeSlide(1)">&#10095;</button>
    </div>
    <div class="page-indicator"></div> --}}
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