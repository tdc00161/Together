window.onload = function() {
    var canvas = document.getElementById("chartcanvas");
    var context = canvas.getContext("2d");
    var sw = canvas.width;
    var sh = canvas.height;
    var PADDING=100;
   
    //Browser별 데이터 입력 chrome, IE, Firefox, Safari, Opera, etc 순
    var data = [30.3, 24.6,19.3,16.3];

    //Browser별 색상 lawngreen, blue, deeppink, aquamarine3, magenta, gold
    var colors = ["#7cfc00", "#0000ff", "#ff1493", "#66CDAA"];
   
    var center_X=sw/2;  //원의 중심 x 좌표
    var center_Y=sh/2;  //원의 중심 y 좌표
    // 두 계산값 중 작은 값은 값을 원의 반지름으로 설정
    var radius = Math.min(sw-(PADDING*2), sh-(PADDING*2)) / 2;
    var angle = 0;
    var total = 0;
    for(var i in data) { total += data[i]; } //데이터(data)의 총합 계산

    for (var i = 0; i < data.length; i++) {
      context.fillStyle = colors[i];  //생성되는 부분의 채울 색 설정
      context.beginPath();
         context.moveTo(center_X, center_Y); //원의 중심으로 이동
         context.arc(center_X, center_Y, radius, angle, angle +(Math.PI*2*(data[i]/total)));
      context.lineTo(center_X,center_Y);
         context.fill();
         angle += Math.PI*2*(data[i]/total);
    }
  }