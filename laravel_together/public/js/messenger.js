 // 초기 탭 설정
 document.getElementById('tab1').style.display = 'block';

 // 탭 열기 함수
 function openTab(tabId) {
     // 모든 탭 숨기기
     var tabs = document.getElementsByClassName('tab-content');
     for (var i = 0; i < tabs.length; i++) {
         tabs[i].style.display = 'none';
     }

     // 선택한 탭 보이기
     document.getElementById(tabId).style.display = 'block';

     // 활성화된 탭 스타일 적용
     var activeTabs = document.getElementsByClassName('tab');
     for (var i = 0; i < activeTabs.length; i++) {
         activeTabs[i].classList.remove('active');
     }
     event.currentTarget.classList.add('active');
 }

  // 모달 열기/닫기 함수
  function toggleModal() {
    var modal = document.getElementById('m-myModal');
    if (modal.style.display === 'none' || modal.style.display === '') {
        modal.style.display = 'block';
    } else {
        modal.style.display = 'none';
    }
}

// 모달 외부 클릭 시 닫기
window.onclick = function (event) {
    var modal = document.getElementById('m-myModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

   // 모달 열기 함수
   function openModal() {
    document.getElementById('myModal').style.display = 'block';
}

// 모달 닫기 함수
function closeModal() {
    document.getElementById('m-myModal').style.display = 'none';
}