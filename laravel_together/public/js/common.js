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
        if (element.classList.contains('active')) {
            element.classList.remove('active');
        } else {
            element.classList.add('active');
        }
    }
    // 문서의 다른 부분을 클릭했을 때 액티브 상태 해제
    document.addEventListener('click', function (event) {
        var activeElement = document.querySelector('.active');
        if (activeElement && !activeElement.contains(event.target)) {
            activeElement.classList.remove('active');
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