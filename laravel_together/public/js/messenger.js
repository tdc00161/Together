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