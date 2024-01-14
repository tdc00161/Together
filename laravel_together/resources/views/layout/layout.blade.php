<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  {{-- 부트스트랩 --}}
  <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/common.css">
  @yield('link','') {{-- 12/12 11:02 kkh: css 개별 링크용 --}}
  <title>@yield('title', 'Laravel Board')</title>

  <style>
    /* 프로그레스바 배경색 변경 */
    .progress {
      background-color: rgba(0, 0, 0, 0.356) 
    }
   /* 프로그레스바 바 내부 색상 변경 */
   .progress-bar {
      background-color: rgba(255, 255, 255, 0.945);
      color: rgb(0, 0, 0);
      font-weight: bold;
      font-size: 12px;
    }
  </style>
</head>
<body>
 
  {{-- 다크모드 --}}
  {{-- <div class="dark-light">
        <button type="button" style="background:transparent; border:none; cursor:pointer"><img src="/img/free-icon-moon-7682051.png" style="width: 30px; height: auto;" alt="이미지 설명"></button>
  </div> --}}
   <div class="app">

    <div class="header">
      <a class="header-title" href="/dashboard">Together</a>
      <div class="alarm-modal d-none">
        <div class="alarm-header">알림</div>
        <div class="alarm-body"></div>
      </div>
     <div class="header-profile">
      <button class="icon-Sub alarm-notice" onclick="toggleActive('icon-notice')"><img class="header-btn icon-notice" src="/img/icon-notice.png" alt=""></button>{{-- <span class="notification-number">3</span> --}}
      <button class="icon-Sub alarm-messenger" onclick="toggleModal(); toggleActive('icon-messenger')"><img class="header-btn icon-messenger" src="/img/icon-messenger.png" alt=""></button>

      <div class="dropdown">
        <button class="dropdown-toggle icon-Sub" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" onclick="toggleActive('myprofilebtn')">
          <img class="header-btn myprofilebtn" src="/img/profile-img.png" alt="">
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
          {{-- <li><a class="dropdown-item bg-op border-radius-top" style="color: #21D9AD; pointer-events : none;">{{$user->email}}</a></li> --}}
          <li><a class="dropdown-item bg-op border-radius-bottom" href="{{route('user.logout.get')}}"> @auth
            로그아웃@endauth</a></li>
        </ul>
      </div>

     </div>
    </div>

    <div class="wrapper">
     <div class="left-side">
      {{-- <button onclick="location.href='create'" class="project-create-btn">새 프로젝트 생성</button> --}}
      <a href="/create" class="project-create-btn">새 프로젝트 생성</a>
      <div class="side-wrapper">
       {{-- <div class="side-title">메뉴</div> --}}
       <div class="side-menu">
        <div class="main-side-menu-div">
        <a href="{{ route('dashboard.show') }}">
          <img src="/img/dashboard_icon.svg" alt="" style="width: 22px; margin-right:7px;">
          <span>대시보드</span>
        </a>
        <a href="{{ route('ganttall.index') }}"> {{-- {{ route('ganttall.index') }} --}}
          <img src="/img/gangchart_icon.svg" alt="" style="width: 22px; margin-right:7px;">
         <span>간트차트</span>
         {{-- <span class="notification-number updates">3</span> --}}
        </a>
        </div>
       </div>
      </div>
      <div class="side-wrapper">
       <div class="side-title">개인 프로젝트</div>
       <div class="side-menu">
        @forelse ($project0title as $item)
        <a class="sidebar-project-name" href="{{route('individual.get',['id' => $item->id])}}"><div style="background-color: {{$item->data_content_name}}" class="project-box"></div>{{$item->project_title}}</a>
        @empty
        <p style="margin-top: 14px;" class="empty-msg">프로젝트 없음</p>
        @endforelse
       </div>
      </div>
      <div class="side-wrapper">
       <div class="side-title">팀 프로젝트</div>
       <div class="side-menu">
        @forelse ($project1title as $item)
        <a class="sidebar-project-name" href="{{route('team.get',['id' => $item->id])}}"><div style="background-color: {{$item->data_content_name}}" class="project-box"></div>{{$item->project_title}}</a>
        @empty
        <p style="margin-top: 14px;" class="empty-msg">프로젝트 없음</p>
        @endforelse
       </div>
      </div>
     </div>
     <div class="main-container">
      <div class="content-wrapper">
        @yield('main')
        @extends('modal.messenger')
    {{-- <div class="overlay-app">
      
    </div> --}}
  </div>
  {{-- 부트스트랩 --}}
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  {{-- 코드펜 --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://cpwebassets.codepen.io/assets/common/browser_support-2c1a3d31dbc6b5746fb7dacdbc81dd613906db219f13147c66864a6c3448246c.js"></script>
  {{-- js --}}
  <script src="/js/common.js"></script>
</body>
</html>