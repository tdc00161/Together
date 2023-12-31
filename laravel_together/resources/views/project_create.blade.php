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
    <form action="{{route('create.post')}}" method="POST">
        @csrf
        <div class="container">
        <input type="hidden" name="user_pk">
        <input type="hidden" name="color_code">
        <div class="flg_group">
            <div class="flg_div">
                <input type="radio" id="radio-1" name="flg" value="0" checked="checked">
                <label for="radio-1">
                    <div>개인</div>
                    <div class="hr"></div>
                    <div>Personal</div>
                </label>
            </div>
            <div class="flg_div">
                <input type="radio"  id="radio-2" name="flg" value="1">
                <label for="radio-2">
                    <div>팀</div>
                    <div class="hr"></div>
                    <div>Team</div>
                </label>
            </div>
        </div>
        <div class="project_create">
            <h1>새 프로젝트</h1>
            <br>
            <div>프로젝트를 어떻게 만들지 선택해보세요</div>
            <br>
                <input class="fontcolor" type="text" name="project_title" placeholder="프로젝트명을 16자이내로 입력하세요" maxlength="16" required>
                <br><br>
                <textarea name="project_content" cols="30" rows="10" placeholder="프로젝트에 관한 설명을 44자이내로 입력하세요(선택)" maxlength="44"></textarea>
                <br><br>
                <div>
                    <div class="div_date">
                        <div class="div_font">시작일</div>
                        <input class="input_date" name="start_date" id="start_date" type="date" min="{{minstart}}" required>
                    </div>
                    <div class="div_date">
                        <div class="div_font">마감일</div>
                        <input class="input_date" name="end_date" type="date" id="end_date" min="{{minend}}" required>
                    </div>
                </div>
                <br>
                <button type="submit" class="project_button">프로젝트 생성</button>
                </div>
        </div>
        <!-- {{-- 다크모드 --}} -->
        {{-- <div class="dark-light">
                <button type="button" style="background:transparent; border:none; cursor:pointer"><img src="/img/free-icon-moon-7682051.png" style="width: 30px; height: auto;" alt="이미지 설명"></button>
        </div> --}}
    </form>

  

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cpwebassets.codepen.io/assets/common/browser_support-2c1a3d31dbc6b5746fb7dacdbc81dd613906db219f13147c66864a6c3448246c.js"></script>
    <script src="/js/common.js"></script>
</body>
</html>