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


// ************* 스크롤 한번에


 


// ************* 하위 업무 추가
// id 값은 임의로 넣은것
function addSubTask(mainId) {
  const doMGanttTask = document.getElementById('gantt-task-283'); // 원래 자리접근
  // 새로운 gantt-task 요소 생성
  // <div class="gantt-task" id="gantt-task-{{$item->id}}"></div>
  const newTask = document.createElement('div');
  newTask.classList.add('gantt-task');
  newTask.id = 'gantt-task-800';
  
  // gantt-task 안에 5개 div 생성
  // <div class="gantt-editable-div editable"></div>
  const addGanttEditableDiv = document.createElement('div');
  addGanttEditableDiv.classList.add('gantt-editable-div', 'editable');
  addGanttEditableDiv.setAttribute('onmouseover', 'showDropdown(this)');
  addGanttEditableDiv.setAttribute('onmouseout', 'hideDropdown(this)');

  // <span class="taskKey">{{$item->id}}</span>
  const addTaskKey = document.createElement('span');
  addTaskKey.classList.add('taskKey');
  addTaskKey.textContent = '800'; 

  // <span class="taskName editable-title">{{$item->title}}</span>
  const addTaskName = document.createElement('span');
  addTaskName.classList.add('taskName', 'editable-title');
  addTaskName.textContent = '업무명'; 

  // <div class="gantt-detail"></div>
  const addGanttDetail = document.createElement('div');
  addGanttDetail.classList.add('gantt-detail');

  // <button class="gantt-detail-btn" onclick="openTaskModal(1)">자세히보기</button>
  const addDetailButton = document.createElement('button');
  addDetailButton.classList.add('gantt-detail-btn');
  addDetailButton.textContent = '자세히보기';
  addDetailButton.setAttribute('onclick', 'openTaskModal(1)');
  

  // <div class="gantt-dropdown">{{$item->name}}</div>
  const addUserName = document.createElement('div');
  addUserName.classList.add('gantt-dropdown');
  addUserName.textContent = '담당자';

  //  <div>
  //    <div class="gantt-status-color" data-status="{{$item->task_status_name}}">{{$item->task_status_name}}</div>
  //  </div> 여기서 부모 div 생성
  const addStatusColorDiv = document.createElement('div');

  //  <div class="gantt-status-color" data-status="{{$item->task_status_name}}">{{$item->task_status_name}}</div>
  const addStatusColor = document.createElement('div');
  addStatusColor.classList.add('gantt-status-color');
  addStatusColor.setAttribute('data-status', '시작전');
  // addStatusColor.dataset.status = '시작전';
  addStatusColor.textContent = '시작전';

  // <div>
  //    <input type="date" name="start" id="start-row{{$item->id}}" onchange="test('{{$item->id}}');" value="{{$item->start_date}}">
  // </div> 여기서 부모 div 생성
  const addTaskStartDateDiv = document.createElement('div');
  
  // <input type="date" name="start" id="start-row{{$item->id}}" onchange="test('{{$item->id}}');" value="{{$item->start_date}}">
  const addTaskStartDate = document.createElement('input');
  addTaskStartDate.type = 'date';  
  addTaskStartDate.name = 'start';  
  addTaskStartDate.id = 'start-row800';
  // addTaskStartDate.setAttribute('onchange', 'test(800)'); 날짜 수정했을 때 차트 수정이 안됨 - 맨밑에 addEventListener로 수정
  addTaskStartDate.value = '20231201';

  // <div>
  //    <input type="date" name="end" id="end-row{{$item->id}}" onchange="test('{{$item->id}}');" value="{{$item->end}}">
  // </div> 여기서 부모 div 생성 
  const addTaskEndDateDiv = document.createElement('div');

  // <input type="date" name="end" id="end-row{{$item->id}}" onchange="test('{{$item->id}}');" value="{{$item->end_date}}">
  const addTaskEndDate = document.createElement('input');
  addTaskEndDate.type = 'date';  
  addTaskEndDate.name = 'end';  
  addTaskEndDate.id = 'end-row800';
  // addTaskEndDate.setAttribute('onchange', 'test(800)'); 날짜 수정했을 때 차트 수정이 안됨 - 맨밑에 addEventListener로 수정
  addTaskEndDate.value = '20231205';


  // gantt-task 안에 edit
  newTask.appendChild(addGanttEditableDiv);
  // edit안에 taskkey, taskname, detail(detail-btn)
  addGanttEditableDiv.appendChild(addTaskKey);
  addGanttEditableDiv.appendChild(addTaskName);
  addGanttEditableDiv.appendChild(addGanttDetail);
  // 자세히보기 버튼을 gantt-detail에 추가
  addGanttDetail.appendChild(addDetailButton);

  // gantt-task 안에 name
  newTask.appendChild(addUserName);
  // gantt-task 안에 statusdiv
  newTask.appendChild(addStatusColorDiv);
  // statusdiv 안에 statuscolor
  addStatusColorDiv.appendChild(addStatusColor);

  // gantt-task 안에 startdatediv
  newTask.appendChild(addTaskStartDateDiv);
  // startdiv 안에 startdate
  addTaskStartDateDiv.appendChild(addTaskStartDate);

  // gantt-task 안에 enddatediv
  newTask.appendChild(addTaskEndDateDiv);
  // startdiv 안에 enddate
  addTaskEndDateDiv.appendChild(addTaskEndDate);

  // 원래 자리 다음에 생성
  doMGanttTask.after(newTask);
  // --- 업무부분 생성 완

  // 차트 부분
  const doMGanttChart = document.getElementById('gantt-chart-283'); // 원래 자리접근
  
  const newChart = document.createElement('div');
  newChart.classList.add('gantt-chart');
  newChart.id = 'gantt-chart-800';

  // 원래있던 282 다음에 800 생성
  doMGanttChart.after(newChart);

  // 시작일 종료일 날짜 설정
  const chartStartDate = new Date('2023-12-01');
  const chartEndDate = new Date('2023-12-31');

  // chartStartDate를 클론하여 chartNewStartDate에 할당
  const chartNewStartDate = new Date(chartStartDate);

  // 요소 생성 배치
  // end가 start보다 이전인지 확인
  while (chartNewStartDate <= chartEndDate) {
    // 날짜 yyyymmdd 변경
    const chartFormatDate = chartNewStartDate.toISOString().slice(0,10).replace(/-/g,"");

    // gantt-chart안에 들어갈 새로운 div
    const ganttChartRow = document.createElement('div');
    ganttChartRow.id = 'row800'+ '-' + chartFormatDate;

    // 다음 날짜 이동
    chartNewStartDate.setDate(chartNewStartDate.getDate() + 1);

    // <div class="gantt-chart" id="ganbtt-chart-800">
    //    <div id="row800-(231201~231231)"></div>
    // </div> 생성
    newChart.appendChild(ganttChartRow);
  }

  // addEventListener 로 하는 방법
  //
  const eventSubStartDate = document.getElementById(addTaskStartDate.id);
  const eventSubEndDate = document.getElementById(addTaskEndDate.id);
  eventSubStartDate.addEventListener('change', e => test(800));
  eventSubEndDate.addEventListener('change', e => test(800));

  
  // --- 차트 부분 생성 완
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
  console.log('***** test() Start *****');
  // 해당 시작일, 종료일 요소 습득
  const start = document.getElementById('start-row' + rowNum).value;
  const end = document.getElementById('end-row' + rowNum).value;

  // console.log(start);
  // console.log(end);

  if (start && end) {
    // 추가 할 bk-row div의 데이트 포멧 변경 : yyyy-mm-dd >> yyyymmdd
    let startAt = parseInt(start.replace(/-/g, ''), 10); // - 제거
    let endAt = parseInt(end.replace(/-/g, ''), 10);

    // 기존 bk-row div 삭제
    const existingBkRowList = document.querySelectorAll('.bk-row[data-row-num="' + rowNum + '"]');
    
  console.log(existingBkRowList);
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

/*******************
   * 1. ajax로 백앤에 request
   * 2. id를 이용해서 해당 프로젝트의 하위업무 갯수 획득
   * 3. [2]에서 획득한 갯수+1해서 하위업무 생성
   * 4. [3]에서 생성한 데이터 json으로 respone
   * 5. [4]에서 받은 데이터를 기반으로 프론트 테이블 로우 요소 생성
   * 6. 
   */

// ************* ajax 수정
const taskNameUp = document.querySelectorAll('.taskName')
const responNameUp = document.querySelectorAll('.responName')
const statusNameUp = document.querySelectorAll('.gantt-status-color')
const startDateUp = document.querySelectorAll('.start-date')
const endDateUp = document.querySelectorAll('.end-date')

// 수정할 데이터
const ganttChartUpdate = {
  'title': taskNameUp.textContent,
  'task_responsible_id': responNameUp[0].textContent,
  'task_status_id': statusNameUp[0].textContent,
  'start_date': startDateUp[0].placeholder,
  'end_date': endDateUp[0].placeholder,
}

// Ajax 요청 보내기
fetch('/ganttchart', {
  method: "PATCH",
  headers: {
    'Content-Type': 'application/json', // 요청의 Content-Type을 JSON 으로 설정
    
  },
  body: JSON.stringify(ganttChartUpdate) // 수정할 데이터를 JSON 문자열로 변환하여 전송
})
  .then(response => {
    if (response.ok) {
      return response.json(); // 성공적인 응답일 경우 JSON 데이터 반환
    }
    throw new Error('수정 실패'); // 응답이 오류인 경우 오류 처리
  })
  .then(data => {
    // 성공 응답 받았을 때 작업 수행
    console.log('수정된 데이터:', data);

    
  })
  .catch(error => {
    // 오류 발생 시 오류 메세지 출력, 처리
    console.error('수정 오류:', error);
  });
    






