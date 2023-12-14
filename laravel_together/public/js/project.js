// 원형 그래프

window.onload = function() {
    var canvas = document.getElementById("chartcanvas");
    var context = canvas.getContext("2d");
    var sw = canvas.width;
    var sh = canvas.height;
    var PADDING=100;
   
    //데이터 입력
    var data = [30.3, 24.6,19.3,16.3];

    //데이터별 색상
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

// 상단바 d-day 계산

let dday = document.getElementById("dday");
function total(){
   start_day = new Date(document.getElementById("start_date").value) // 시작일자 가져오기
   console.log(start_day);
   end_day = new Date(document.getElementById("end_date").value) // 디데이(마감일자)
   console.log(end_day);
   gap = end_day - start_day
   console.log(gap)
   result = Math.floor(gap / (1000 * 60 * 60 * 24))
   // // 시작일 or 마감일 1개만 수정되었을 때도 변경ㅇ 설정?
   // if(start_day!=null || end_day!=null) {
   //    dday.innerHTML = result;
   // }
   dday.innerHTML = result;
}

// console.log(dday);

// tab 기능

function openTab(evt, tabName) {
   var i, tabcontent, tabmenu;
   tabcontent = document.getElementsByClassName("tabcontent");
   for (i = 0; i < tabcontent.length; i++) {
     tabcontent[i].style.display = "none";
   }
   console.log(tabcontent);
   tabmenu = document.getElementsByClassName("tabmenu");
   for (i = 0; i < tabmenu.length; i++) {
      tabmenu[i].className = tabmenu[i].className.replace(" active", "");
   }
   console.log(tabmenu);
   document.getElementById(tabName).style.display = "block";
   evt.currentTarget.className += " active";
}