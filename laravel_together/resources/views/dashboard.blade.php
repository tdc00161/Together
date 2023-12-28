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
    <div class="color_div1">
        <div class="color_set1">
            <div class="color_box1"></div>
            <div class="color_name">시작전:{{$statuslist['before'][0]->cnt}}</div>
        </div>
        <div  class="color_set1">
            <div class="color_box2"></div>
            <div class="color_name">진행중:{{$statuslist['ing'][0]->cnt}}</div>
        </div>
    </div>
    <div class="color_div1">
        <div class="color_set1">
            <div class="color_box3"></div>
            <div class="color_name">피드백:{{$statuslist['feedback'][0]->cnt}}</div>
        </div>
        <div  class="color_set1">
            <div class="color_box4"></div>
            <div class="color_name">완료:{{$statuslist['complete'][0]->cnt}}</div>
        </div>
    </div>
  </div>

   {{-- 2 공지 --}}
   <div class="app-card2">
    {{-- <span class="app-card-title">
        공지
    </span> --}}

    <div class="app-card__subtext">
        <!-- 여기에 캐러셀 추가 -->
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
             <p class="dashboard-title-notice">공지</p>
              @if($dashboardNotice->isEmpty())
              <!-- 데이터가 없을 때의 처리 -->
              공지 없음
              @else
              {{-- 첫 캐러샐 --}}
              <div class="carousel-item active">
              {{-- 첫 캐러샐 - 프로젝트명 --}}
                <p class="dashboard-project-name">{{$dashboardNotice->first()->project_title}}</p>
              {{-- 첫 캐러샐 - 프로젝트 컬러 --}}
                <div class="dashboard-project-color-box" style="background-color:{{$dashboardNotice->first()->data_content_name}};"></div>
              {{-- 첫 캐러샐 - 공지 제목 --}}
              <br><p class="dashboard-project-notice">{{$dashboardNotice->first()->title}}</p>
              </div>

              {{-- 다음 캐러샐 --}}
              @foreach($dashboardNotice as $notice)
                <div class="carousel-item">
                  {{-- 프로젝트명 --}}
                  <p class="dashboard-project-name">{{ $notice->project_title }}</p>
                  {{-- 프로젝트 컬러 --}}
                  <div class="dashboard-project-color-box" style="background-color:{{$notice->data_content_name}};"></div>
                  {{-- 공지 제목 --}}
                  <br><p class="dashboard-project-notice">{{ $notice->title }}</p>
                </div>

              @endforeach
              @endif
            </div>

            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only"></span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only"></span>
            </a>
        </div>
          {{-- <!-- 인디케이터 추가 -->
          <ol class="carousel-indicators">
            @foreach($dashboardNotice as $key => $notice)
                <li data-target="#myCarousel" data-slide-to="{{ $key }}" @if($key === 0) class="active" @endif></li>
            @endforeach
        </ol> --}}
    </div>
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
      {{-- 개인 프로젝트 프로그레스 바 --}}
      @foreach ($IndividualcompletionPercentages as $projectId => $IndividualcompletionPercentage)
      {{-- <h2>Project ID: {{ $projectId }}</h2> --}}
      @foreach ($IndividualcompletionPercentage as $result)
      <div class="project-progress">
        <div class="project-progress-project-title-div"><div style="background-color: {{ $result->data_content_name }};" class="project-box"></div><p class="dashboard-progress-project-title">{{$result->project_title}}</p><p class="dashboard-progress-project-dday"></p></div>
        <div class="progress">
          <div class="progress-bar" role="progressbar" aria-label="Animated striped example" aria-valuenow="{{ $result->completion_percentage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $result->completion_percentage }}%">{{ $result->completion_percentage }}%</div>
        </div>
      </div>
      @endforeach
      @endforeach
      </div>

      {{-- 3-2 --}}
      <div class="app-card3-2"> 
        <span class="app-card-title">
      팀 프로젝트 진척률
        </span>
        <div class="app-card__subtext">
          {{-- 팀 프로젝트 프로그레스 바 --}}
          @foreach ($TeamcompletionPercentages as $projectId => $TeamcompletionPercentage)
          {{-- <h2>Project ID: {{ $projectId }}</h2> --}}
          @foreach ($TeamcompletionPercentage as $result)
          <div class="project-progress">
            <div class="project-progress-project-title-div"><div style="background-color: {{ $result->data_content_name }};" class="project-box"></div><p class="dashboard-progress-project-title">{{$result->project_title}}</p><p class="dashboard-progress-project-dday"></p></div>
            <div class="progress">
              <div class="progress-bar" role="progressbar" aria-label="Animated striped example" aria-valuenow="{{ $result->completion_percentage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $result->completion_percentage }}%">{{ $result->completion_percentage }}%</div>
            </div>
          </div>
          @endforeach
          @endforeach
        </div>
      </div>
      </div>
  
    {{-- 3  --}}
    <div class="app-card4"> 
      <span class="app-card-title">
      마감
      </span>
      @foreach ($group_dday as $dday => $item)
        <div class="dash_dday">
          @if ($dday <= 1 && $dday >= -1)
            <div style="color:rgb(212, 14, 0); font-weight:bold;">D{{$dday < 0 ? $dday : '+'.$dday}}</div>
          @elseif ($dday <= -2 && $dday >= 4)
            <div style="color:rgb(235, 157, 12); font-weight:bold;">D{{$dday < 0 ? $dday : '+'.$dday}}</div>
          @elseif ($dday <= -5 && $dday >= 7)
            <div style="color:rgb(246, 250, 32); font-weight:bold;">D{{$dday < 0 ? $dday : '+'.$dday}}</div>
          @else
            @continue
          @endif
            @foreach ($item as $ddayitem)
              <div class="dash_dday_grid">
                <div class="project_color" style="background-color:{{$ddayitem->data_content_name}}"></div>
                <div class="dash_ddaytitle" style="">{{Str::limit($ddayitem->title,10,'...')}}</div>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
     </div>
  
    </div>

 </div>

@endsection