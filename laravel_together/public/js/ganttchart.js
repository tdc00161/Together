// ***** 개인 피드로 이동


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
// const  

// // ****** 하위 업무 추가
// // 새로운 gantt-task를 추가하는 함수
// function addNewTask() {
//   // 새로운 업무를 추가할 div 요소 생성
//   var newTaskDiv = document.createElement('div');
//   newTaskDiv.className = 'gantt-task';
//   newTaskDiv.style.height = '43.5px'; // 높이를 43.5로 설정

//   var newChartDiv = document.createElement('div');
//   newChartDiv.className = 'gantt-chart';
//   newChartDiv.style.height = '43.5px';

//   // 각각의 업무를 구성하는 요소들 생성 (div 안에 input이 들어간 형태)
//   var inputTypes = ['text', 'text', 'text', 'date', 'date']; // 각 input 요소에 적용할 타입 배열

//   for (var i = 0; i < inputTypes.length; i++) {
//     var newDiv = document.createElement('div');
//     var newInput = document.createElement('input');
//     newInput.setAttribute('type', inputTypes[i]); // input 타입 설정


//     // 생성한 input을 새로운 div 안에 추가
//     newDiv.appendChild(newInput);
//     // 새로운 div를 새로운 업무 div에 추가
//     newTaskDiv.appendChild(newDiv);
//   }
//   // 생성한 새로운 업무를 기존의 ganttTask 뒤에 추가
//   var ganttEditableDiv = document.querySelector('.ganttTask');
//   ganttEditableDiv.parentNode.insertBefore(newTaskDiv, ganttEditableDiv.nextSibling);
// }
// // 이미지들을 선택하고 클릭 이벤트를 추가
// var images = document.querySelectorAll('img.gantt-plus-img');
// images.forEach(function(image) {
//   image.addEventListener('click', addNewTask);
// });



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



// **** 드롭박스 클릭 후 선택 수정





// ***** 차트영역 헤더에 날짜 추가
const headerScroll = document.querySelector('.gantt-header-scroll');

// 예시 데이터 - 날짜
const startDate = new Date('2023-12-01');
const endDate = new Date('2023-12-31');

// 날짜를 헤더에 추가하는 함수
function addDatesToHeader() {
  const chartDate = new Date(startDate);

  while (chartDate <= endDate) {
    const dateElement = document.createElement('div');
    dateElement.classList.add('date');
    dateElement.textContent = chartDate.toLocaleDateString('ko-KR', { day: 'numeric', month: 'short' });
    headerScroll.appendChild(dateElement);

    chartDate.setDate(chartDate.getDate() + 1);
  }
}

addDatesToHeader();

// 챗 차트생성


// **** 차트생성
// 파라미터 : rowNum   테이블에서의 해당 row 번호
function test(rowNum) {
  // 해당 시작일, 종료일 요소 습득
  const start = document.getElementById('start-row' + rowNum).value;
  const end = document.getElementById('end-row' + rowNum).value;

  if (start && end) {
    // 추가 할 bk-row div의 데이트 포멧 변경 : yyyy-mm-dd >> yyyymmdd
    let startAt = parseInt(start.replace(/-/g, ''), 10); // - 제거
    let endAt = parseInt(end.replace(/-/g, ''), 10);

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

