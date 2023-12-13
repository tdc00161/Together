// 드롭박스 생성
let checkLists = document.getElementsByClassName('gantt-dropdown-check-list');

for(let i = 0; i < checkLists.length; i++) {
    let checkList = checkLists[i];
  
    checkList.getElementsByClassName('gantt-span')[0].onclick = function(evt) {
      if (checkList.classList.contains('visible'))
        checkList.classList.remove('visible');
      else
        checkList.classList.add('visible');
    }
  }

