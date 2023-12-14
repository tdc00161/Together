// ***** 드롭박스 생성
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

// ****** 하위 업무 추가
// 새로운 gantt-task를 추가하는 함수



// ***** 업무명 클릭하여 바로 수정
// 요소를 클릭하여 편집 가능하게 만드는 함수
function makeEditable(element) {
  element.contentEditable = true;
  element.focus();
}
// 요소를 클릭하여 편집 상태로 전환
document.getElementById('gantt-editable-div').addEventListener('click', function(event) {
  const targetElement = event.target;
  makeEditable(targetElement);
});

// 드롭박스 클릭 후 선택 수정
function toggleDropdown() {
  var dropdown = document.getElementById('gantt-teamOptions');
  if (dropdown.style.display === 'none' || dropdown.style.display === '') {
      dropdown.style.display = 'block';
  } else {
      dropdown.style.display = 'none';
  }
}

function changeName(newName) {
  document.getElementById('gantt-currentTeam').innerText = newName;
  document.getElementById('gantt-teamOptions').style.display = 'none'; // 선택 후 드롭다운 숨김
}

// Document 클릭 시 드롭다운 닫기
document.addEventListener('click', function(event) {
  var dropdown = document.getElementById('gantt-teamOptions');
  var teamDropdown = document.getElementById('gantt-teamDropdown');
  var currentTeam = document.getElementById('gantt-currentTeam');

  if (event.target !== teamDropdown && event.target !== currentTeam) {
      dropdown.style.display = 'none';
  }
});



// ***** 차트영역 헤더에 날짜 추가
const headerScroll = document.querySelector('.gantt-header-scroll');

// 예시 데이터 - 날짜
const startDate = new Date('2023-12-01');
const endDate = new Date('2023-12-31');

// 날짜를 헤더에 추가하는 함수
function addDatesToHeader() {
  const currentDate = new Date(startDate);

  while (currentDate <= endDate) {
    const dateElement = document.createElement('div');
    dateElement.classList.add('date');
    dateElement.textContent = currentDate.toLocaleDateString('ko-KR', { day: 'numeric', month: 'short' });
    headerScroll.appendChild(dateElement);

    currentDate.setDate(currentDate.getDate() + 1);
  }
}

addDatesToHeader();

// 챗 차트생성


// **** 차트생성
// 파라미터 : rowNum   테이블에서의 해당 row 번호
function test(rowNum) {
  // 해당 시작일, 종료일 요소 습득
  const sat = document.getElementById('sat-row' + rowNum).value;
  const eat = document.getElementById('eat-row' + rowNum).value;

  if (sat && eat) {
    // 추가 할 bk-row div의 데이트 포멧 변경 : yyyy-mm-dd >> yyyymmdd
    let startAt = parseInt(sat.replace(/-/g, ''), 10); // - 제거
    let endAt = parseInt(eat.replace(/-/g, ''), 10);

    // 기존 bk-row div 삭제
    const existingBkRowList = document.querySelectorAll('.bk-row[data-row-num="' + rowNum + '"]');
    existingBkRowList.forEach(function (item) {
      item.parentNode.removeChild(item);
    });

    // bk-row div 추가
    for (let currentDate = startAt; currentDate <= endAt; currentDate++) {
      const dateString = currentDate.toString();
      const year = dateString.substring(0, 4);
      const month = dateString.substring(4, 6);
      const day = dateString.substring(6, 8);
      const formattedDate = year + '-' + month + '-' + day;

      const target = document.getElementById('row' + rowNum + '-' + dateString); // ex) row1-231201

      // bk-row div 요소 생성
      const div = document.createElement('div');
      div.classList = 'bk-row';
      div.dataset.rowNum = rowNum; // 해당 rowNum을 데이터로 저장

      // 타겟에 bk-row div 추가
      target.appendChild(div);
    }
  }
}








// // **** 차트생성
// // 파라미터 : rowNum   테이블에서의 해당 row 번호
// function test(rowNum) {
//   // 해당 시작일, 종료일 요소 습득
//       const sat = document.getElementById('sat-row'+rowNum).value;
//       const eat = document.getElementById('eat-row'+rowNum).value;

//       if(sat && eat) {
//         // 기존 bk-row div 삭제
//         const bkRowList = document.querySelectorAll('.bk-row');
//         if(bkRowList) {
//           bkRowList.forEach( function(item) {
//             item.remove();
//           });
//         }

//         // 추가 할 bk-row div의 데이트 포멧 변경 : yyyy-mm-dd >> yyyymmdd
//         let startAt = sat.replace(/-/g, ''); // - 제거
//         let endAt = eat.replace(/-/g, '');

//         // bk-row div 추가
//         for(startAt; startAt <= endAt; startAt++) {
//           // 타겟 일자 요소 습득
//           const target = document.getElementById('row' + rowNum + '-' + startAt); // ex) row1-231201

//           // bk-row div 요소 생성
//           const div = document.createElement('div');
//           div.classList = 'bk-row';

//           // 타겟에 bk-row div 추가
//           target.appendChild(div);
//         }
//       }
//     }


