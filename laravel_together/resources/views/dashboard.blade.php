@extends('layout.layout')
@section('title', '대시보드')
@section('main')
  {{-- 컨텐츠 헤더 --}}
  <div class="content-wrapper-header">
    {{-- 유저 이름 --}}
    <span>양주은님</span>
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

   <div class="app-card2"> 
    <span class="app-card-title">
     공지
    </span>
    <div class="app-card__subtext"></div>
    <div class="app-card-buttons"></div>
   </div>

  <div class="content-wrapper-context">
    <div class="content-text">Grab yourself 10 free images from Adobe Stock in a 30-day free trial plan and find perfect image, that will help you with your new project.</div>
   </div>

  {{-- <div class="content-section-title"></div> --}}
 
    {{-- 상태 --}}
    {{-- <span class="status">
     <span class="status-circle"></span>
     Update Available</span>
      --}}
      {{-- -------------------------------- --}}
    {{-- <div class="button-wrapper"> --}}
      {{-- 버튼 --}}
     {{-- <button class="content-button status-button">Update this app</button> --}}
     {{-- 버튼 - 팝업 --}}
     {{-- <div class="pop-up">
      <div class="pop-up__title">Update This App
       <svg class="close" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
        <circle cx="12" cy="12" r="10" />
        <path d="M15 9l-6 6M9 9l6 6" />
       </svg>
      </div>
      <div class="pop-up__subtitle">Adjust your selections for advanced options as desired before continuing. <a href="#">Learn more</a></div>
      <div class="checkbox-wrapper">
       <input type="checkbox" id="check1" class="checkbox">
       <label for="check1">Import previous settings and preferences</label>
      </div>
      <div class="checkbox-wrapper">
       <input type="checkbox" id="check2" class="checkbox">
       <label for="check2">Remove old versions</label>
      </div>
      <div class="content-button-wrapper">
       <button class="content-button status-button open close">Cancel</button>
       <button class="content-button status-button">Continue</button>
      </div>
     </div> --}}
    {{-- </div> --}}
    {{-- -------------------------------- --}}
 </div>

 <div class="content-section">
  {{-- <div class="content-section-title">업무상태</div> --}}

  <div class="apps-card">


   <div class="app-card">
    <span>
     <svg viewBox="0 0 52 52" style="border: 1px solid #c1316d">
      <g xmlns="http://www.w3.org/2000/svg">
       <path d="M40.824 52H11.176C5.003 52 0 46.997 0 40.824V11.176C0 5.003 5.003 0 11.176 0h29.649C46.997 0 52 5.003 52 11.176v29.649C52 46.997 46.997 52 40.824 52z" fill="#2f0015" data-original="#6f2b41" />
       <path d="M18.08 39H15.2V13.72l-2.64-.08V11h5.52v28zM27.68 19.4c1.173-.507 2.593-.761 4.26-.761s3.073.374 4.22 1.12V11h2.88v28c-2.293.32-4.414.48-6.36.48-1.947 0-3.707-.4-5.28-1.2-2.08-1.066-3.12-2.92-3.12-5.561v-7.56c0-2.799 1.133-4.719 3.4-5.759zm8.48 3.12c-1.387-.746-2.907-1.119-4.56-1.119-1.574 0-2.714.406-3.42 1.22-.707.813-1.06 1.847-1.06 3.1v7.12c0 1.227.44 2.188 1.32 2.88.96.719 2.146 1.079 3.56 1.079 1.413 0 2.8-.106 4.16-.319V22.52z" fill="#e1c1cf" data-original="#ff70bd" />
      </g>
     </svg>
     InDesign
    </span>
    <div class="app-card__subtext">Design and publish great projects & mockups</div>
    <div class="app-card-buttons">
     <button class="content-button status-button">Update</button>
     <div class="menu"></div>
    </div>
   </div>
   <div class="app-card">
    <span>
     <svg viewBox="0 0 52 52" style="border: 1px solid #C75DEB">
      <g xmlns="http://www.w3.org/2000/svg">
       <path d="M40.824 52H11.176C5.003 52 0 46.997 0 40.824V11.176C0 5.003 5.003 0 11.176 0h29.649C46.997 0 52 5.003 52 11.176v29.649C52 46.997 46.997 52 40.824 52z" fill="#3a3375" data-original="#3a3375" />
       <path d="M27.44 39H24.2l-2.76-9.04h-8.32L10.48 39H7.36l8.24-28h3.32l8.52 28zm-6.72-12l-3.48-11.36L13.88 27h6.84zM31.48 33.48c0 2.267 1.333 3.399 4 3.399 1.653 0 3.466-.546 5.44-1.64L42 37.6c-2.054 1.254-4.2 1.881-6.44 1.881-4.64 0-6.96-1.946-6.96-5.841v-8.2c0-2.16.673-3.841 2.02-5.04 1.346-1.2 3.126-1.801 5.34-1.801s3.94.594 5.18 1.78c1.24 1.187 1.86 2.834 1.86 4.94V30.8l-11.52.6v2.08zm8.6-5.24v-3.08c0-1.413-.44-2.42-1.32-3.021-.88-.6-1.907-.899-3.08-.899-1.174 0-2.167.359-2.98 1.08-.814.72-1.22 1.773-1.22 3.16v3.199l8.6-.439z" fill="#e4d1eb" data-original="#e7adfb" />
      </g>
     </svg>
     After Effects
    </span>
    <div class="app-card__subtext">Industry Standart motion graphics & visual effects</div>
    <div class="app-card-buttons">
     <button class="content-button status-button">Update</button>
     <div class="menu"></div>
    </div>
   </div>
  </div>
 </div>
</div>
</div>
</div>
@endsection