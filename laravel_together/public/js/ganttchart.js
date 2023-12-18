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



// function subTaskAdd() {
//   // 새로운 하위 작업을 추가할 데이터를 정의합니다.
//   const newItem = {
//       id: generateUniqueId(), // 새로운 작업의 ID 생성 (예시 함수)
//       title: "새 하위 업무",
//       name: null,
//       task_status_name: null,
//       start_date: null,
//       end_date: null,
//    // 다른 필요한 데이터 추가
//   };
//   data.push(newItem);

//   console.log("새로운 작업이 추가되었습니다:", newItem);

//   // gantt-tasks에 새로운 작업을 추가합니다.
//   const tasksContainer = document.querySelector('.gantt-task-body');
//   const newTask = document.createElement('div');
//   newTask.classList.add('gantt-task');
//   newTask.id = `ganttTask${newItem.id}`;
//   newTask.innerHTML = `
//       <!-- 여기에 newItem에 관련된 HTML 추가 -->
//   `;
//   tasksContainer.appendChild(newTask);

//   // gantt-chart에 새로운 작업 행을 추가합니다.
//   const chartContainer = document.querySelector('.gantt-chart-body');
//   const newRow = document.createElement('div');
//   newRow.classList.add('gantt-chart');
//   newRow.id = `ganttRow${newItem.id}`;
//   // 새로운 작업에 대한 날짜 행 생성 등의 작업을 수행합니다.
//   chartContainer.appendChild(newRow);

//   // 새로운 작업을 추가한 후 추가적인 로직을 수행할 수 있습니다.
//   // 예를 들어, 새로운 작업에 대한 이벤트 처리기를 추가하거나 다른 데이터를 채우는 등의 작업을 수행할 수 있습니다.
// }

// // 유일한 ID를 생성하는 함수 예시
// function generateUniqueId() {
//   // 여기서는 data 배열이 있다고 가정하고, 해당 배열에 있는 ID 중 가장 큰 ID를 찾습니다.
//   let maxId = 0;
    
//   // data 배열에서 최대 ID 찾기
//   data.forEach(item => {
//       if (item.id > maxId) {
//           maxId = item.id;
//       }
//   });

//   // 가장 큰 ID에서 1을 더한 값을 반환합니다.
//   return (maxId + 1).toString();
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



