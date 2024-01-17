$(function () {
    $(".menu-link").click(function () {
     $(".menu-link").removeClass("is-active");
     $(this).addClass("is-active");
    });
   });
   
   $(function () {
    $(".main-header-link").click(function () {
     $(".main-header-link").removeClass("is-active");
     $(this).addClass("is-active");
    });
   });
   
   const dropdowns = document.querySelectorAll(".dropdown");
   dropdowns.forEach((dropdown) => {
    dropdown.addEventListener("click", (e) => {
     e.stopPropagation();
     dropdowns.forEach((c) => c.classList.remove("is-active"));
     dropdown.classList.add("is-active");
    });
   });
   
   $(".search-bar input")
    .focus(function () {
     $(".header").addClass("wide");
    })
    .blur(function () {
     $(".header").removeClass("wide");
    });
   
   $(document).click(function (e) {
    var container = $(".status-button");
    var dd = $(".dropdown");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
     dd.removeClass("is-active");
    }
   });
   
   $(function () {
    $(".dropdown").on("click", function (e) {
     $(".content-wrapper").addClass("overlay");
     e.stopPropagation();
    });
    $(document).on("click", function (e) {
     if ($(e.target).is(".dropdown") === false) {
      $(".content-wrapper").removeClass("overlay");
     }
    });
   });
   
   $(function () {
    $(".status-button:not(.open)").on("click", function (e) {
     $(".overlay-app").addClass("is-active");
    });
    $(".pop-up .close").click(function () {
     $(".overlay-app").removeClass("is-active");
    });
   });
   
   $(".status-button:not(.open)").click(function () {
    $(".pop-up").addClass("visible");
   });
   
   $(".pop-up .close").click(function () {
    $(".pop-up").removeClass("visible");
   });

const CommonCsrfToken = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '';
   
//    const toggleButton = document.querySelector('.dark-light');
   
//    toggleButton.addEventListener('click', () => {
//      document.body.classList.toggle('light-mode');
//    });

   // 상세 열기 함수
   function openModal() {
    document.getElementById('task_modal').style.display = 'block';
}
//    // 상세 모달 열기 함수
//    function openDetailModal() {
//     document.getElementById('myDetailModal').style.display = 'block';
// }
// // 작성 모달 열기 함수
//    function openInsertModal() {
//     document.getElementById('myInsertModal').style.display = 'block';
// }

// 모달 닫기 함수
function closeModal() {
    document.getElementById('myModal').style.display = 'none';
}

// 모달 외부 클릭 시 닫기
window.onclick = function (event) {
    var modal = document.getElementById('myModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

//
    function toggleActive(className) {
        // 해당 클래스의 액티브 상태를 토글
        var element = document.querySelector(`.${className}`);
        let alarmModal = document.querySelector('.alarm-modal');
        if (element.classList.contains('activee')) {
            element.classList.remove('activee');
            className === 'icon-notice' ? alarmModal.classList.add('d-none') : '';
        } else {
            element.classList.add('activee');
            className === 'icon-notice' ? alarmModal.classList.remove('d-none') : '';
        }
    }
    // 문서의 다른 부분을 클릭했을 때 액티브 상태 해제
    document.addEventListener('click', function (event) {
        var activeElement = document.querySelector('.activee');
        let alarmModal = document.querySelector('.alarm-modal');
        if (activeElement && !activeElement.contains(event.target) && !alarmModal.contains(event.target)) {
            activeElement.classList.remove('activee');
            alarmModal.classList.add('d-none');
        }
    });

// 대시보드 그래프

window.onload = function() {
    // 경로만 가져오기
    var pathname = window.location.pathname;
    
    // debug("***** project_graph_data End *****");
    $.ajax({
       url: '/dashboard-chart/',
       type: 'GET',
       success: function (response) {
         
 
 
          // var responseObject = JSON.parse(response);
          // console.log(responseObject);
          var dataArray = response.data;
      
 
          // 차트 생성
          var canvas = document.getElementById("chartcanvas2");
          var context = canvas.getContext("2d");
          var sw = canvas.width;
          var sh = canvas.height;
          var PADDING = 100;
 
          // 데이터 입력(기본값 0이 될 수 있도록 데이터 설정해줘야함)
          var data = [response.before[0],response.ing[0],response.feedback[0],response.complete[0]];
        
 
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
          // 결과 에러 콜백함수
          console.log(error)
       }
    })
 }

 // 알림창 js ----------------------------------------------------------------

// 알림 출력 통신
fetch('/alarms', {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': CommonCsrfToken,
        // 'X-Socket-ID': socketId,
    },
})
.then(response => {
    if (!response.ok) {
        throw new Error('error with print chatting list.');
    }
    return response.json();
})
.then(data => {
    // console.log(data);
    data.data.forEach(d => {
        // console.log(d.id);
        
        // 알람 내용 가공
        // console.log(JSON.parse(d.content));
        let msg = alarmText(JSON.parse(d.content));
        
        // 알림 요소 생성
        var notification = document.createElement('div');
        notification.classList.add('alarm-one');

        // 안읽은 알람 있으면
        let alarmNotice = document.querySelector('.alarm-notice')
        if(Number(d.read) === 0){
            notification.classList.add('not-read');
            alarmNotice.classList.add('has-new-notice');            
        }

            // 알림내용 호버시 읽기기능
            notification.addEventListener('mouseover', e => {                
                notification.style.setProperty('--after-opacity', '0');
                fetch('/alarms/' + d.id, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CommonCsrfToken,
                        // 'X-Socket-ID': socketId,
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('error with print chatting list.');
                    }
                    return response.json();
                })
                .then(data => {
                    // console.log(data);
                    setTimeout(() => {                        
                        notification.classList.remove('not-read');
    
                        // 안읽은 알람 없으면
                        let notReads = document.querySelectorAll('.not-read')
                        if(notReads.length === 0){
                            alarmNotice.classList.remove('has-new-notice');            
                        }
                    }, 500);
                })
                .catch(err => console.log(err.stack))
            });
    
        // 알림 내용 추가
        var contentElement = document.createElement('div');
        contentElement.classList.add('alarm-content');
        contentElement.textContent = msg;
        notification.appendChild(contentElement);
    
        // 알림 시간 추가
        var timeElement = document.createElement('div');
        timeElement.classList.add('alarm-time');
        timeElement.textContent = formatRelativeDate(d.created_at);
        notification.appendChild(timeElement);
    
        // 알림창에 삽입
        let alarmBody = document.querySelector('.alarm-body')
        alarmBody.appendChild(notification);
    })

    // 30일 전 알람까지 가져올 수 있다고 설명

})
.catch(err => console.log(err.stack))

function alarmText(alarms) {
    let msg = '';
    let char = alarms[0]
    let code =  char.match(/([A-Za-z]+)(\d+)/);
    let number = code ? code[2] : false;
    let taskTitle = alarms[2][0] ? alarms[2][0].title : '';
    let taskProjectTitle = alarms[2][0] ? alarms[2][0].project_title : '';
    let projectTitle = alarms[2].project_title ? alarms[2].project_title : '';
    switch (code ? code[1] : char) {
        case 'PS': // 프로젝트 시작
            msg = number ? `'${projectTitle}' 프로젝트 시작까지 '${code[2]}' 일 남았습니다` : `'${projectTitle}' 프로젝트가 시작되었습니다`;     
            break;
        case 'PE': // 프로젝트 마감
            msg = number ? `'${projectTitle}' 프로젝트 마감까지 '${code[2]}' 일 남았습니다` : `'${projectTitle}' 프로젝트가 마감되었습니다`;
            break;
        case 'PI': // 프로젝트 초대
            let inviteProject = alarms[2].project;
            msg = `'${inviteProject}' 프로젝트에서 초대되었습니다`;
            break;
        case 'TS': // 업무 시작
            msg = number ? `'${taskProjectTitle}' - '${taskTitle}' 업무 시작까지 '${code[2]}' 일 남았습니다` : `'${taskTitle}' 업무가 시작되었습니다`;
            break;
        case 'TE': // 업무 마감
            msg = number ? `'${taskProjectTitle}' - '${taskTitle}' 업무 마감까지 '${code[2]}' 일 남았습니다` : `'${taskTitle}' 업무가 마감되었습니다`;
            break;
        case 'FR': // 친구 요청
            let from = alarms[2][0].name;
            msg = `'${from}' 유저로부터 친구요청이 왔습니다`;
            break;
        case 'BF': // 친구 완료
            let to = alarms[2][1].name;
            msg = `'${to}' 유저와 친구가 되었습니다`;
            break;
        case 'CR': // 담당자 변경
            let resProjectTitle = alarms[2].content ? alarms[2].content.project.project_title : '';
            let resTaskTitle = alarms[2].content ? alarms[2].content.where.title : '';
            let oldRes = alarms[2] ? alarms[2].content.oldRes ? alarms[2].content.oldRes.name : '없음' : '';
            let nowRes = alarms[2] ? alarms[2].content.nowRes ? alarms[2].content.nowRes.name : '없음' : '';
            msg = `'${resProjectTitle}' - '${resTaskTitle}' 업무의 담당자가 '${oldRes}' 에서 '${nowRes}' 로/으로 변경되었습니다`;
            break;
        case 'CC': // 댓글 생성
            let commentProject = alarms[2].project.project_title
            let commentTitle = alarms[2].task.title
            let commentUser = alarms[2].user.name
            msg = `'${commentProject}' - '${commentTitle}' 업무에 '${commentUser}' 이/가 댓글을 작성하였습니다`;
            break;
        default:
            break;
    }
    return msg;
}

// 날짜표기 함수
function formatRelativeDate(dateString) {
    const currentDate = new Date();
    const targetDate = new Date(dateString);
  
    const timeDifference = currentDate - targetDate;
    const secondsDifference = Math.floor(timeDifference / 1000);
    const minutesDifference = Math.floor(secondsDifference / 60);
    const hoursDifference = Math.floor(minutesDifference / 60);
    const daysDifference = Math.floor(hoursDifference / 24);
    const monthsDifference = Math.floor(daysDifference / 30);
    const yearsDifference = Math.floor(daysDifference / 365);
  
    if (secondsDifference < 60) {
      return `${secondsDifference}초 전`;
    } else if (minutesDifference < 60) {
      return `${minutesDifference}분 전`;
    } else if (hoursDifference < 24) {
      return `${hoursDifference}시간 전`;
    } else if (daysDifference === 1) {
      return '어제';
    } else if (monthsDifference < 1 && currentDate.getFullYear() === targetDate.getFullYear()) {
      return `${targetDate.getMonth() + 1}월 ${targetDate.getDate()}일`;
    } else {
      const year = targetDate.getFullYear();
      const month = String(targetDate.getMonth() + 1).padStart(2, '0');
      const day = String(targetDate.getDate()).padStart(2, '0');
      return `${year}.${month}.${day}`;
    }
  }
//  ---------------------------------------------------------------- 알림창 js

// 프로젝트 설명 js 팝오버
 const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
// 
