<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="/css/common.css">
  @yield('link','') {{-- 12/12 11:02 kkh: css 개별 링크용 --}}
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
      <div class="content-wrapper">
        @yield('main')
      
    <div class="overlay-app"></div>
   </div>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
   <script src="https://cpwebassets.codepen.io/assets/common/browser_support-2c1a3d31dbc6b5746fb7dacdbc81dd613906db219f13147c66864a6c3448246c.js"></script>
   <script src="/js/common.js"></script>
</body>
</html>