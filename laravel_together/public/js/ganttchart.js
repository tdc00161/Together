// ************* 개인 피드로 이동


// ************* 드롭박스 생성
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


// ************* 검색 기능
// 검색창에서 엔터치면 searchPost()실행
function enterkeySearch() {
  let search = document.getElementById('keySearch').value.toLowerCase();
  let ganttTask = document.getElementsByClassName('gantt-task');

  for (let i = 0; i < ganttTask.length; i++) {
    taskKey = ganttTask[i].getElementsByClassName('taskKey');
    taskName = ganttTask[i].getElementsByClassName('taskName');
    let ganttChart = document.getElementsByClassName('gantt-chart')[i]; // 해당 인덱스의 차트 가져오기

    if (
      taskKey[0].innerHTML.toLowerCase().includes(search) ||
      taskName[0].innerHTML.toLowerCase().includes(search)
    ) {
      ganttTask[i].style.display = 'flex';
      ganttChart.style.display = 'flex'; // 검색에 맞는 업무가 있다면 해당 차트 보이기
    } else {
      ganttTask[i].style.display = 'none';
      ganttChart.style.display = 'none'; // 검색에 맞지 않는 업무는 해당 차트 숨기기
    }
  }
}

// ************* 오름차순, 내림차순 정렬
// 드롭다운
function orderDropdown(category) {
  var orderDropdownDiv = document.getElementById(category + 'Dropdown');
  if (orderDropdownDiv.style.display === 'block') {
    orderDropdownDiv.style.display = 'none';
  } else {
    orderDropdownDiv.style.display = 'block';
  }
}



// ************* 체크박스 필터링



// ************* 업무상태 색상
document.addEventListener('DOMContentLoaded', function() {
  var elements = document.querySelectorAll('.gantt-status-color');

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
          default:
              backgroundColor = '#FFFFFF'; // 기본값 설정
              break;
      }

      element.style.backgroundColor = backgroundColor;
  });
});





// ************* 스크롤 한번에




// ************* 하위 업무 추가
function addSubTask() {
  var doMGanttTask = document.querySelectorAll('.gantt-task');


  // 새로운 작업 요소를 생성하는 코드
  var newTask = document.createElement('div');
  newTask.className = 'gantt-task';

  // gantt-editable-div 요소 생성
  var addGanttEditableDiv = document.createElement('div');
  addGanttEditableDiv.className = 'gantt-editable-div editable';
  addGanttEditableDiv.setAttribute('onmouseover', 'showDropdown(this)');
  addGanttEditableDiv.setAttribute('onmouseout', 'hideDropdown(this)');

  // 새 작업의 ID를 나타내는 taskKey 생성
  var addTaskKey = document.createElement('span');
  addTaskKey.className = 'taskKey';
  addTaskKey.textContent = ''; 

  // 새 작업의 제목을 표시하는 taskName 생성
  var addTaskName = document.createElement('span');
  addTaskName.className = 'taskName editable-title';
  addTaskName.textContent = ''; 

  // gantt-detail 요소 생성
  var addGanttDetail = document.createElement('div');
  addGanttDetail.className = 'gantt-detail';

  // 자세히보기 버튼 생성
  var addDetailButton = document.createElement('button');
  addDetailButton.className = 'gantt-detail-btn';
  addDetailButton.textContent = '자세히보기';
  addDetailButton.setAttribute('onclick', 'openTaskModal(1)');

  // 자세히보기 버튼을 gantt-detail에 추가
  addGanttDetail.appendChild(addDetailButton);

  // 각 요소들을 순서대로 조립하여 새로운 작업에 추가
  newTask.appendChild(addGanttEditableDiv);
  addGanttEditableDiv.appendChild(addTaskKey);
  addGanttEditableDiv.appendChild(addTaskName);
  addGanttEditableDiv.appendChild(addGanttDetail);

  // gantt-chart 요소 생성 및 추가
  var doMGanttChart = document.querySelectorAll('gantt-chart');

  var addGanttChart = document.createElement('div');
  addGanttChart.className = 'gantt-chart';
  addGanttChart.id = 'ganttChart';

  // 새 작업의 날짜 범위에 해당하는 요소들을 gantt-chart에 추가
  var addStartDate = new Date('2023-12-01');
  var addEndDate = new Date('2023-12-31');

  for (var date = new Date(addStartDate); date <= addEndDate; date.setDate(date.getDate() + 1)) {
      var rowId = 'rowNewTaskID-' + date.getFullYear() + ('0' + (date.getMonth() + 1)).slice(-2) + ('0' + date.getDate()).slice(-2);
      var newRow = document.createElement('div');
      newRow.id = rowId;
      addGanttChart.appendChild(newRow);
    }

  // 새로운 gantt-chart를 새 작업에 추가
  newTask.appendChild(addGanttChart);


}



// function addSubTask(element) {
//   // '하위업무 추가' 버튼이 속한 요소의 부모(.gantt-detail)의 부모(.gantt-editable-div)의 부모(.gantt-task)를 찾습니다.
//   var grandParentGanttTask = element.closest('.gantt-detail').parentNode.parentNode;

//   var newTask = document.createElement('div');
//   newTask.className = 'gantt-task';

//   // 새로운 작업 요소를 생성하는 코드
//   // gantt-editable-div 요소 생성
//   var addGanttEditableDiv = document.createElement('div');
//   addGanttEditableDiv.className = 'gantt-editable-div editable';
//   addGanttEditableDiv.setAttribute('onmouseover', 'showDropdown(this)');
//   addGanttEditableDiv.setAttribute('onmouseout', 'hideDropdown(this)');

//   // 새 작업의 ID를 나타내는 taskKey 생성
//   var addTaskKey = document.createElement('span');
//   addTaskKey.className = 'taskKey';
//   addTaskKey.textContent = 'New Task ID'; // 새로운 작업의 ID를 할당하십시오.

//   // 새 작업의 제목을 표시하는 taskName 생성
//   var addTaskName = document.createElement('span');
//   addTaskName.className = 'taskName editable-title';
//   addTaskName.textContent = 'New Task Title'; // 새로운 작업의 제목을 할당하십시오.

//   // gantt-detail 요소 생성
//   var addGanttDetail = document.createElement('div');
//   addGanttDetail.className = 'gantt-detail';

//   // 자세히보기 버튼 생성
//   var addDetailButton = document.createElement('button');
//   addDetailButton.className = 'gantt-detail-btn';
//   addDetailButton.textContent = '자세히보기';
//   addDetailButton.setAttribute('onclick', 'openTaskModal(1)');

//   // 자세히보기 버튼을 gantt-detail에 추가
//   addGanttDetail.appendChild(addDetailButton);

//   // 각 요소들을 순서대로 조립하여 새로운 작업에 추가
//   newTask.appendChild(addGanttEditableDiv);
//   addGanttEditableDiv.appendChild(addTaskKey);
//   addGanttEditableDiv.appendChild(addTaskName);
//   addGanttEditableDiv.appendChild(addGanttDetail);
  

//   // // gantt-chart 요소 생성 및 추가
//   // var addGanttChart = document.createElement('div');
//   // addGanttChart.className = 'gantt-chart';
//   // addGanttChart.id = 'ganttChart';

//   // // 새 작업의 날짜 범위에 해당하는 요소들을 gantt-chart에 추가
//   // var addStartDate = new Date('2023-12-01');
//   // var addEndDate = new Date('2023-12-31');

//   // for (var date = new Date(addStartDate); date <= addEndDate; date.setDate(date.getDate() + 1)) {
//   //     var rowId = 'rowNewTaskID-' + date.getFullYear() + ('0' + (date.getMonth() + 1)).slice(-2) + ('0' + date.getDate()).slice(-2);
//   //     var newRow = document.createElement('div');
//   //     newRow.id = rowId;
//   //     addGanttChart.appendChild(newRow);
//   // }

//   // // 새로운 gantt-chart를 새 작업에 추가
//   // newTask.appendChild(addGanttChart);

//   // 만약 해당 부모 .gantt-task 요소를 찾았다면,
//   if (grandParentGanttTask) {
//       // 새로운 작업을 해당 부모 .gantt-task 요소의 하위로 추가합니다.
//       grandParentGanttTask.appendChild(newTask);
//   } else {
//       // 만약 해당 부모 .gantt-task 요소를 찾을 수 없다면,
//       // 기본적으로 문서의 body에 새로운 작업을 추가합니다.
//       document.body.appendChild(newTask);
//   }
// }






// ************* 업무명 클릭하여 바로 수정
// 요소를 클릭하여 편집 가능하게 만드는 함수
function makeEditable(element) {
  element.contentEditable = true;
  element.focus();
}
// 요소를 클릭하여 편집 상태로 전환
const editableDivs = document.querySelectorAll('.gantt-editable-div');
editableDivs.forEach(function(element) {
  element.addEventListener('click', function(event) {
    const targetElement = event.target;
    makeEditable(targetElement);
  });
});






// ************* 업무명에 마우스 올렸을 때 자세히 보기 버튼 보이기
function showDropdown(element) {
  var detailDropdown = element.querySelector('.gantt-detail');
  if (detailDropdown) {
    detailDropdown.style.display = 'block';
  }
}

function hideDropdown(element) {
  var detailDropdown = element.querySelector('.gantt-detail');
  if (detailDropdown) {
    detailDropdown.style.display = 'none';
  }
}
// 자세히 보기 편집 이벤트 막기
var detailButtons = document.querySelectorAll('.gantt-detail-btn');
detailButtons.forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.stopPropagation(); // 부모 요소로 이벤트 전파 방지
    });
});



// ************* 차트영역 헤더에 날짜 추가
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



// ************* 차트생성
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

// ************* 업무추가 버튼클릭 시 상위업무 추가

// ************* ajax 수정



