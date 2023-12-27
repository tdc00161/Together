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
        if (element.classList.contains('activee')) {
            element.classList.remove('activee');
        } else {
            element.classList.add('activee');
        }
    }
    // 문서의 다른 부분을 클릭했을 때 액티브 상태 해제
    document.addEventListener('click', function (event) {
        var activeElement = document.querySelector('.activee');
        if (activeElement && !activeElement.contains(event.target)) {
            activeElement.classList.remove('activee');
        }
    });


// 대시보드 공지 js
// let currentIndex = 0;

// function showSlide(index) {
//   const slides = document.querySelector('.slides');
//   const totalSlides = document.querySelectorAll('.slide').length;
//   currentIndex = (index + totalSlides) % totalSlides;
//   const translateValue = -currentIndex * 100;
//   slides.style.transform = `translateX(${translateValue}%)`;
// }

// function changeSlide(direction) {
//   showSlide(currentIndex + direction);
//   updatePageIndicator();
// }

// // Initial slide show
// showSlide(currentIndex);

// function updatePageIndicator() {
//     const indicators = document.querySelectorAll('.page-indicator span');
//     indicators.forEach((indicator, index) => {
//       indicator.classList.remove('active');
//       if (index === currentIndex) {
//         indicator.classList.add('active');
//       }
//     });
//   }


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