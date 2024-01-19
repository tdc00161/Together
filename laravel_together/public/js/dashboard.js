function dashGraph(dashData) {

    // console.log(dashData);
    let doughnut1 = document.querySelector('#Doughnut1');

    new Chart(doughnut1, {
        type: 'doughnut',
        data: {
            labels: ['시작전', '진행중', '피드백', '완료'],
            datasets: [{
                data: [dashData.before[0].cnt,dashData.ing[0].cnt,dashData.feedback[0].cnt,dashData.complete[0].cnt],
                backgroundColor: ["#B1B1B1", "#04A5FF", "#F34747", "#64C139"],
                hoverOffset: 4
            }]
        },
        options:{
            plugins:{
                legend: {
                    display: false
                },
            }
        }
    });
}
let a = document.querySelector('#Doughnut1');

a.style.display = 'none';

fetch('/dashboard-chart', {
    method: 'GET',
    headers: {
        "Content-Type": "application/json"
    },
}).then(response => {
        // console.log(response)
        return response.json()

}).then(dashData => {
        // console.log(dashData)
        dashGraph(dashData);
        a.style.display = 'block';
}).catch(error => console.log(error));



// 대시보드 그래프

// window.onload = function() {
//     // 경로만 가져오기
//     var pathname = window.location.pathname;
    
//     // debug("***** project_graph_data End *****");
//     $.ajax({
//        url: '/dashboard-chart/',
//        type: 'GET',
//        success: function (response) {
          
//           // var responseObject = JSON.parse(response);
//           // console.log(responseObject);
//           var dataArray = response.data;
      
 
//           // 차트 생성
//           var canvas = document.getElementById("chartcanvas2");
//           var context = canvas.getContext("2d");
//           var sw = canvas.width;
//           var sh = canvas.height;
//           var PADDING = 100;
 
//           // 데이터 입력(기본값 0이 될 수 있도록 데이터 설정해줘야함)
//           var data = [response.before[0],response.ing[0],response.feedback[0],response.complete[0]];
 
//           //데이터별 색상
//           var colors = ["#B1B1B1", "#04A5FF", "#F34747", "#64C139"];
 
//           var center_X = sw / 2;  //원의 중심 x 좌표
//           var center_Y = sh / 2;  //원의 중심 y 좌표
//           // 두 계산값 중 작은 값은 값을 원의 반지름으로 설정
//           var radius = Math.min(sw - (PADDING * 2), sh - (PADDING * 2)) / 2;
//           var angle = 0;
//           var total = 0;
//           for (var i in data) { total += data[i].cnt; } //데이터(data)의 총합 계산
 
//           for (var i = 0; i < data.length; i++) {
//              context.fillStyle = colors[i];  //생성되는 부분의 채울 색 설정
//              context.beginPath();
//              context.moveTo(center_X, center_Y); //원의 중심으로 이동
//              context.arc(center_X, center_Y, radius, angle, angle + (Math.PI * 2 * (data[i].cnt / total)));
//              context.lineTo(center_X, center_Y);
//              context.fill();
//              angle += Math.PI * 2 * (data[i].cnt / total);
//           }
//        },
//        error: function (request, status, error) {
//           // 결과 에러 콜백함수
//           console.log(error)
//        }
//     })
//  }