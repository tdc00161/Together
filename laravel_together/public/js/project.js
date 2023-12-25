// 원형 그래프

window.onload = function() {
   // 경로만 가져오기
   var pathname = window.location.pathname;
   console.log(pathname);
   // debug("***** project_graph_data End *****");
   $.ajax({
      url: '/chart-data/'+parseInt(pathname.match(/\d+/)[0]),
      type: 'GET',
      success: function (response) {
         console.log('***** Ajax Success *****');
         console.log(response);


         // var responseObject = JSON.parse(response);
         // console.log(responseObject);
         var dataArray = response.data;
         console.log(dataArray);

         // 차트 생성
         var canvas = document.getElementById("chartcanvas");
         var context = canvas.getContext("2d");
         var sw = canvas.width;
         var sh = canvas.height;
         var PADDING = 100;

         // 데이터 입력(기본값 0이 될 수 있도록 데이터 설정해줘야함)
         var data = [response.before[0],response.ing[0],response.feedback[0],response.complete[0]];
         console.log(data);

         //데이터별 색상
         var colors = ["#B1B1B1", "#04A5FF", "#F34747", "#64C139"];

         var center_X = sw / 2;  //원의 중심 x 좌표
         var center_Y = sh / 2;  //원의 중심 y 좌표
         // 두 계산값 중 작은 값은 값을 원의 반지름으로 설정
         var radius = Math.min(sw - (PADDING * 2), sh - (PADDING * 2)) / 2;
         var angle = 0;
         var total = 0;
         for (var i in data) { total += data[i].cnt; } //데이터(data)의 총합 계산

         for (var i = 0; i < data.length; i++) {
            context.fillStyle = colors[i];  //생성되는 부분의 채울 색 설정
            context.beginPath();
            context.moveTo(center_X, center_Y); //원의 중심으로 이동
            context.arc(center_X, center_Y, radius, angle, angle + (Math.PI * 2 * (data[i].cnt / total)));
            context.lineTo(center_X, center_Y);
            context.fill();
            angle += Math.PI * 2 * (data[i].cnt / total);
         }
      },
      error: function (request, status, error) {
         console.log('***** Ajax Error *****');
         // 결과 에러 콜백함수
         console.log(error)
      }
   })
}

// 카테고리 색상
var categoryColor = document.getElementById('color');
// while(categoryColor = true){
//       if(category_name = '공지'){
//          categoryColor.style.color = 'red';
//       } else if(category_name = '업무'){
//          categoryColor.style.color = 'blue';
//       }
// }


// 프로젝트 d-day 계산
let dday = document.getElementById("dday");
function total() {
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
   dday.innerHTML = 'D-' + result;
}


// 프로젝트 날짜 업데이트
function updateDate() {
   const StartD = document.getElementById("start_date").value;
   const EndD = document.getElementById("end_date").value;

   const updateSD = StartD.toISOString().split('T')[0];
   
}


// console.log(dday);

//삭제 모달창 open
function openDeleteModal() {
   document.getElementById('deleteModal').style.display = 'block';
}

//삭제 모달창 close
function closeDeleteModal() {
   document.getElementById('deleteModal').style.display = 'none';
}

//삭제버튼시 삭제
const csrfToken_project = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
function deleteProject(project_pk) {
   // 전달할 데이터 정보(메모 정보)
   //    let Id = {
   //       user_pk : user_pk
   //   }
   // console.log(document.querySelector('.csrf_token'));
   // 삭제 ajax
   fetch('/delete/' + project_pk, {
      method: 'DELETE',
      // body : JSON.stringify(Id),
      headers: {
         "Content-Type": "application/json",
         'X-CSRF-TOKEN': csrfToken_project
      },
   }).then((response) => 
      console.log(response)) // response.json()
      .then(() => {
         window.location.href = '/dashboard'; // 메인화면으로 이동
      });
}


// 프로젝트 명, 컨텐츠 업데이트
const csrfToken_updateproject = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
function titleupdate(project_pk) {
   
   const UpdateValue = document.getElementById('project_title').value;
   console.log(UpdateValue)

   // 서버로 보낼 데이터
   // const PutData = {
   //    UpdateValue: UpdateValue
   // };

    // Fetch를 사용하여 서버에 put 요청 보내기
    fetch('/update/' + project_pk, {
         method: 'POST',
         headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken_project,
            // 필요에 따라 다른 헤더들 추가 가능
         },
         body: JSON.stringify({UpdateValue: UpdateValue})
   })
   .then(response => {
      if(!response.ok) {
         throw new Error('서버 응답이 성공적이지 않습니다.');
      } else {
         return response.json();
      }
   })
   .then(data => {
         document.getElementsByClassId('project_title').value = data.UpdateValue;
   })
   .catch(error => {
         // 오류 처리
         console.error('error', error);
   });

}



// tab 기능

// function openTab(evt, tabName) {
//    var i, tabcontent, tabmenu;
//    tabcontent = document.getElementsByClassName("tabcontent");
//    for (i = 0; i < tabcontent.length; i++) {
//       tabcontent[i].style.display = "none";
//    }
//    console.log(tabcontent);
//    tabmenu = document.getElementsByClassName("tabmenu");
//    for (i = 0; i < tabmenu.length; i++) {
//       tabmenu[i].className = tabmenu[i].className.replace(" active", "");
//    }
//    console.log(tabmenu);
//    document.getElementById(tabName).style.display = "block";
//    evt.currentTarget.className += " active";
// }