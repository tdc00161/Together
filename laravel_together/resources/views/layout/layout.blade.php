<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="/css/common.css">
  <title>@yield('title', 'Laravel Board')</title>
</head>
<body>
  {{-- 다크모드 --}}
  <div class="dark-light">
        <button type="button" style="background:transparent; border:none; cursor:pointer"><img src="/img/free-icon-moon-7682051.png" style="width: 30px; height: auto;" alt="이미지 설명"></button>
  </div>

   <div class="app">
    <div class="header">
     <div class="menu-circle"></div>
     <div class="header-menu">
      <a class="menu-link is-active" href="#">Apps</a>
      <a class="menu-link notify" href="#">Your work</a>
      <a class="menu-link" href="#">Discover</a>
      <a class="menu-link notify" href="#">Market</a>
     </div>
     <div class="search-bar">
      <input type="text" placeholder="Search">
     </div>
     <div class="header-profile">
      <div class="notification">
       <span class="notification-number">3</span>
       <svg viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" />
       </svg>
      </div>
      <svg viewBox="0 0 512 512" fill="currentColor">
       <path d="M448.773 235.551A135.893 135.893 0 00451 211c0-74.443-60.557-135-135-135-47.52 0-91.567 25.313-115.766 65.537-32.666-10.59-66.182-6.049-93.794 12.979-27.612 19.013-44.092 49.116-45.425 82.031C24.716 253.788 0 290.497 0 331c0 7.031 1.703 13.887 3.006 20.537l.015.015C12.719 400.492 56.034 436 106 436h300c57.891 0 106-47.109 106-105 0-40.942-25.053-77.798-63.227-95.449z" />
      </svg>
      <img class="profile-img" src="https://images.unsplash.com/photo-1600353068440-6361ef3a86e8?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="">
     </div>
    </div>
    <div class="wrapper">
     <div class="left-side">
      <button>새 프로젝트 생성</button>
      <div class="side-wrapper">
       <div class="side-title">메뉴</div>
       <div class="side-menu">
        <a href="#">
          <img src="/img/dashboard_icon.svg" alt="">
          <span>대시보드</span>
        </a>
        <a href="#">
          <img src="/img/gangchart_icon.svg" alt="">
         <span>간트차트</span>
         {{-- <span class="notification-number updates">3</span> --}}
        </a>
       </div>
      </div>
      <div class="side-wrapper">
       <div class="side-title">개인 프로젝트</div>
       <div class="side-menu">
        <a href="#">
         <div class="project-color-box"></div>
         <span>프로젝트 명1</span>
        </a>
        <a href="#">
          <div class="project-color-box"></div>
          <span>프로젝트 명2</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>프로젝트 명3</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>프로젝트 명4</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>프로젝트 명5</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>프로젝트 명6</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>프로젝트 명7</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>프로젝트 명8</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>프로젝트 명9</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>프로젝트 명10</span>
         </a>
       </div>
      </div>
      <div class="side-wrapper">
       <div class="side-title">팀 프로젝트</div>
       <div class="side-menu">
        <a href="#">
          <div class="project-color-box"></div>
          <span>팀 프로젝트 명1</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>팀 프로젝트 명2</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>팀 프로젝트 명3</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>팀 프로젝트 명4</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>팀 프로젝트 명5</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>팀 프로젝트 명6</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>팀 프로젝트 명7</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>팀 프로젝트 명8</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>팀 프로젝트 명9</span>
         </a>
         <a href="#">
          <div class="project-color-box"></div>
          <span>팀 프로젝트 명10</span>
         </a>
       </div>
      </div>
     </div>
     <div class="main-container">

      {{-- 헤더 --}}
      {{-- <div class="main-header">
       <a class="menu-link-main" href="#">All Apps</a>
       <div class="header-menu">
        <a class="main-header-link is-active" href="#">Desktop</a>
        <a class="main-header-link" href="#">Mobile</a>
        <a class="main-header-link" href="#">Web</a>
       </div>
      </div> --}}

      <div class="content-wrapper">
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
    <div class="overlay-app"></div>
   </div>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
   <script src="https://cpwebassets.codepen.io/assets/common/browser_support-2c1a3d31dbc6b5746fb7dacdbc81dd613906db219f13147c66864a6c3448246c.js"></script>
   <script src="/js/common.js"></script>
</body>
</html>