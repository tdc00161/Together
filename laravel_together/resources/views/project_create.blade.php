<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="/css/common.css">
  <link rel="stylesheet" href="/css/project_create.css">
  <title>project-create</title>
</head>
<body>
    <div class="container">
      <div class="flg_group">
          <div class="flg_div">
              <div>개인</div>
              <div class="hr"></div>
              <div>Personal</div>
          </div>
          <div class="flg_div">
              <div>팀</div>
              <div class="hr"></div>
              <div>Team</div>
          </div>
      </div>
      <div class="project_create">
        <h1>새 프로젝트</h1>
        <br>
        <div>프로젝트를 어떻게 만들지 선택해보세요</div>
        <br>
        <form action="/project_create" method="POST">
            @csrf
            <input type="text" name="title" placeholder="프로젝트명을 입력하세요">
            <br><br>
            <textarea name="content" id="" cols="30" rows="10" placeholder="프로젝트에 관한 설명 입력(선택)"></textarea>
            <br><br>
            <div>
                <div class="div_date">
                    <div class="div_font">시작일</div>
                    <input class="input_date" type="date">
                </div>
                <div class="div_date">
                    <div class="div_font">마감일</div>
                    <input class="input_date" type="date">
                </div>
            </div>
            <br>
            <button class="project_button">프로젝트 생성</button>
        </form>
        </div>
    </div>
     <!-- {{-- 다크모드 --}} -->
    <div class="dark-light">
            <button type="button" style="background:transparent; border:none; cursor:pointer"><img src="/img/free-icon-moon-7682051.png" style="width: 30px; height: auto;" alt="이미지 설명"></button>
    </div>

  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cpwebassets.codepen.io/assets/common/browser_support-2c1a3d31dbc6b5746fb7dacdbc81dd613906db219f13147c66864a6c3448246c.js"></script>
    <script src="/js/common.js"></script>
</body>
</html>