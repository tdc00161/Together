
//프로젝트 원형차트 생성
window.onload = function() {
   //출력할 방법 설정(화면 출력시 데이터 띄움)
   var pathname = window.location.pathname;
   console.log(pathname);
   // debug("***** project_graph_data End *****");
   $.ajax({
      url: '/chart-data/'+parseInt(pathname.match(/\d+/)[0]),
      type: 'GET',
      success: function (response) {
         console.log('***** Ajax Success *****');
         console.log(response);

         var dataArray = response.data;
         console.log(dataArray);

         // 차트 생성
         var canvas = document.getElementById("chartcanvas");
         var context = canvas.getContext("2d");
         var sw = canvas.width;
         var sh = canvas.height;
         var PADDING = 100;

         // 프로젝트 상태별 데이터
         var data = [response.before[0],response.ing[0],response.feedback[0],response.complete[0]];
         console.log(data);

         // 프로젝트 상태별 적용 색상
         var colors = ["#B1B1B1", "#04A5FF", "#F34747", "#64C139"];

         var center_X = sw / 2;  //원의 중심 x 좌표
         var center_Y = sh / 2;  //원의 중심 y 좌표
         // 두 계산값 중 작은 값은 값을 원의 반지름으로 설정
         var radius = Math.min(sw - (PADDING * 2), sh - (PADDING * 2)) / 2;
         var angle = 0;
         var total = 0;
         for (var i in data) { total += data[i].cnt; } //데이터(data)의 총합

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


// ************* 업무상태 색상
document.addEventListener('DOMContentLoaded', function() {
   var elements = document.querySelectorAll('.statuscolor');
 
   elements.forEach(function(element) {
       var status = element.getAttribute('data-status');
       var backgroundColor;
 
       switch (status) {
           case '시작전':
               backgroundColor = '#B1B1B1';
               break;
           case '진행중':
               backgroundColor = '#04A5FF';
               break;
           case '피드백':
               backgroundColor = '#F34747';
               break;
           case '완료':
               backgroundColor = '#64C139';
               break;
         //   default:
         //       backgroundColor = '#FFFFFF'; // 기본값 설정
         //       break;
       }
 
       element.style.backgroundColor = backgroundColor;
   });
 });


// 240101 생성페이지 마감일자 기준 설정
function createPage(){
   let start = document.getElementById('creates').value;
   let end = document.getElementById('createe').value;
   if(end<start){
      alert('마감일자를 다시 확인해주세요');
      createbtn.setAttribute('disabled','disabled');
   }else{
      createbtn.removeAttribute('disabled');
   }
}


// 프로젝트 명 클릭시 초기값 삭제
// let UPDATETITLESET = document.getElementById('project_title');
// UPDATETITLESET.addEventListener('click',deleteTitle)

// function deleteTitle () {
//    UPDATETITLESET.removeAttribute('value');
// }

let OrginalendValue = document.getElementById('end_date').value;
let Orginalend = document.getElementById('end_date');


// 프로젝트 명, 컨텐츠 업데이트 // 240101 전체 수정(catch 까지)
const csrfToken_updateproject = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
function titleupdate(project_pk) {

   let Updatetitle = document.getElementById('project_title').value;
   let Updatecontent = document.getElementById('project_content').value;
   let Updatetitlemax = 17;
   let Updatecontentmax = 45;

   if(Updatetitle.length > Updatetitlemax){
      alert('텍스트 길이를 초과하였습니다.')
   }
   if(Updatetitlemax.length > Updatecontentmax){
      alert('텍스트 길이를 초과하였습니다.')
   }
   let Updatestart = document.getElementById('start_date').value;
   let Updateend = document.getElementById('end_date').value;
   
   // console.log(Updatetitle)

   let dday = document.getElementById("dday");
      today = new Date();
      start_day = new Date(document.getElementById("start_date").value); // 시작일자 가져오기
      console.log(start_day);
      end_day = new Date(document.getElementById("end_date").value); // 디데이(마감일자)
      // 시작일보다 마감일이 이전일 경우 DB에 저장하지 않고 에러띄우기 및 d-day 설정 지우기
      if(end_day < start_day) {
         dday.innerHTML = ''; // 240101 오타 수정
         alert('마감일자 입력을 다시 해주세요');
         return false;
      }
      console.log(end_day);
      gap = today - end_day;
      if(gap > 0) {
         dday.innerHTML = '';
         return false;
      }
      else if(gap === 0) {
         dday.innerHTML = D-day;
      }
      
      console.log(gap);
      result = Math.floor(gap / (1000 * 60 * 60 * 24));

      dday.innerHTML = 'D' + result;


    // Fetch를 사용하여 서버에 put 요청 보내기
    fetch('/update/' +project_pk, {
         method: 'POST',
         headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken_project,
            // 필요에 따라 다른 헤더들 추가 가능
         },
         body: JSON.stringify({
            "Updatetitle": Updatetitle,
            "Updatecontent":Updatecontent,
            "Updatestart": Updatestart,
            "Updateend":Updateend,
         })
         // body: JSON.stringify({project_title: project_title})
   })
   .then((response) => {
      console.log(response);
      return response.json();
   })
   .then(data => {
      console.log(data);
         document.getElementsByClassId('project_title').value = data.project_title;
         document.getElementsByClassId('project_content').value = data.project_content;
         document.getElementsByClassId('start_date').value = data.start_date;
         document.getElementsByClassId('end_date').value = data.end_date;
   })
   .catch(error => {
         // 오류 처리
         console.error('error', error);
   });

}


// 프로젝트 설명 클릭시 초기값 삭제
// let UPDATECONTENTSET = document.getElementById('project_content');
// UPDATECONTENTSET.addEventListener('click',deleteContent)

// function deleteContent () {
//    this.value = "";
// }


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
   
   fetch('/delete/' + project_pk, {
      method: 'DELETE',
      // body : JSON.stringify(Id),
      headers: {
         "Content-Type": "application/json",
         'X-CSRF-TOKEN': csrfToken_project
      },
   }).then((response) => 
      console.log(response))
      // response.json()
     .then(() => {
         window.location.href = '/dashboard'; // 메인화면으로 이동
   }).catch(error => console.log(error));
}

//나가기 모달창 open
function openExitModal() {
   document.getElementById('exitModal').style.display = 'block';
}

//나가기 모달창 close
function closeExitModal() {
   document.getElementById('exitModal').style.display = 'none';
}

//나가기버튼시 삭제
const csrfToken_project2 = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
function deleteProject(project_pk) {

   fetch('/delete/' + project_pk, {
      method: 'DELETE',
      // body : JSON.stringify(Id),
      headers: {
         "Content-Type": "application/json",
         'X-CSRF-TOKEN': csrfToken_project
      },
   }).then((response) => 
      console.log(response))
      // response.json()
     .then(() => {
         window.location.href = '/dashboard'; // 메인화면으로 이동
   }).catch(error => console.log(error));
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