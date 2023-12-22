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

// ************* 상태값 드롭다운 선택
// JavaScript로 해당 드롭다운을 감지하고 변경을 처리하는 코드
// JavaScript로 클릭 시 드롭다운 보이게 처리하는 코드
function statusSelectDropdown() {
  const statusDropdown = document.querySelector('.statusDropdown');

  if (statusDropdown.style.display === 'none' || statusDropdown.style.display === '') {
      statusDropdown.style.display = 'block'; // 클릭 시 드롭다운 보이기
  } else {
      statusDropdown.style.display = 'none'; // 다시 클릭 시 드롭다운 숨기기
  }

  statusDropdown.addEventListener('change', function() {
      const selectedValue = statusDropdown.value;
      console.log('선택된 값:', selectedValue);
      // 선택한 값을 처리하기 위한 추가 작업 수행
  });
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
  addTaskName.classList.add('taskName', 'editable-title', 'updateable');
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
  addUserName.classList.add('responName', 'gantt-dropdown', 'updateable');
  addUserName.textContent = '담당자';

  //  <div>
  //    <div class="gantt-status-color" data-status="{{$item->task_status_name}}">{{$item->task_status_name}}</div>
  //  </div> 여기서 부모 div 생성
  const addStatusColorDiv = document.createElement('div');

  //  <div class="gantt-status-color" data-status="{{$item->task_status_name}}">{{$item->task_status_name}}</div>
  const addStatusColor = document.createElement('div');
  addStatusColor.classList.add('statusName', 'gantt-status-color', 'updateable');
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
  // addTaskStartDate.value = '2023-12-01';

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
  // addTaskEndDate.value = '2023-12-05';


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
  // console.log('***** test() Start *****');
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
    
  // console.log(existingBkRowList);
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

// ajax get
// const axios = require('axios').default;
// axios.get('/api/gantt', {
//   headers: {
//     'Content-Type': 'application/json',
//   }
// })
//     .then(res => {
//       console.log(res);
//     })
//     .catch(err => {
//       console.log(err);
//       throw new Error(err);
//     })

// ************* ajax 수정

// const taskNameUp = document.querySelector('.taskName');
// const responNameUp = document.querySelector('.responName');
// const statusNameUp = document.querySelector('.statusName');
// const startDateUp = document.querySelector('.start-date');
// const endDateUp = document.querySelector('.end-date');

// function handleBlur() {
//   alert('수정이 완료되었습니다.');
//   let data = {
//     'title': taskNameUp.textContent,
//     'task_responsible_id': responNameUp.textContent,
//     'task_status_id': statusNameUp.textContent,
//     'start_date': startDateUp.value,
//     'end_date': endDateUp.value
//   };
  
//   fetch('/ganttchartRequest', {
//     method: 'PUT',
//     headers: {
//       'Content-Type': 'application/json'
//     },
//     body: JSON.stringify(data)
//   })
//   .then(res => {
//     if(res.ok) {
//       console.log('테이터가 성공적으로 전송');
//     } else {
//       console.error('데이터 전송에 실패');
//     }
//   })
//   .catch(error => {
//     console.log('오류 발생:', error)
//   })
// }

// taskNameUp.addEventListener('blur', handleBlur);
// responNameUp.addEventListener('blur', handleBlur);
// statusNameUp.addEventListener('blur', handleBlur);
// startDateUp.addEventListener('blur', handleBlur);
// endDateUp.addEventListener('blur', handleBlur);

// 예시: 수정 요청을 보내는 함수
function sendUpdateRequest(id, updatedValue , numbersOnly) {
  // Axios를 사용하여 수정 요청을 보내는 로직
  // 여기에 실제 서버 엔드포인트 및 요청 설정을 작성해야 합니다.
  // 아래는 가상의 코드입니다.
  let url = '/api/ganttchartRequest/' + numbersOnly
console.log(url);
  axios.put(url, { 'value': updatedValue})
      .then(res => {
          // 성공적으로 요청을 보낸 후에 할 작업
          console.log('수정 요청 성공:', res.data);
      })
      .catch(err => {
          // 요청 실패 시 에러 처리
          console.log('수정 요청 실패:', err);
      });
}

// 수정 완료 팝업 창 보이기
// function showPopupMessage(message) {
//   const popupModal = document.getElementById('ganttPopupModal');
//   const popupMessage = document.getElementById('ganttPopupMessage');
  
//   popupMessage.textContent = message;
//   popupModal.style.display = 'block';

//   // 일정 시간(여기서는 3초) 후 팝업 창 닫기
//   setTimeout(() => {
//     popupModal.style.display = 'none';
//   }, 2000);
// }

// 각 요소에 대해 blur 이벤트를 추가하여 수정 시점을 감지하고 서버에 수정 요청을 보내는 예시
document.querySelectorAll('.taskName, .responName, .statusName, .start-date, .end-date').forEach(element => {
    element.addEventListener('blur', function(event) {
      event.target.parentNode.parentNode.getAttribute('id') //var result4 = str.slice(-4);
      // 간트 수정 시 타겟 추정 및 아이디 반환
      let originalString = 0;
      console.log('변경값 확인용1: '+event.target.parentNode.getAttribute('id')); // responName
      console.log('변경값 확인용1: '+event.target.parentNode.parentNode.getAttribute('id')); // title
      console.log('변경값 확인용1: '+event.target.parentNode.parentNode.parentNode.getAttribute('id')); // status
      console.log('변경값 확인용1: '+event.target.getAttribute('id')); // start, end
        if(event.target.parentNode.getAttribute('id')){
          originalString = event.target.parentNode.getAttribute('id')
        } else if(event.target.parentNode.parentNode.getAttribute('id')){
          originalString = event.target.parentNode.parentNode.getAttribute('id')
        } else if(event.target.parentNode.parentNode.parentNode.getAttribute('id')){
          originalString = event.target.parentNode.parentNode.parentNode.getAttribute('id')
        } else if(event.target.getAttribute('id')){
          originalString = event.target.getAttribute('id')
        }
      const parts = originalString.split('-');
      const numbersOnly = parts[parts.length - 1];
      console.log('id: '+numbersOnly); // 출력 결과: 1243
        const id = this.dataset.id; // 데이터 속성을 이용하여 ID 가져오기
        let updatedValue = {
          'responName': '',
          'status': '',
          'start_date': '',
          'end_date': '',
          'title': ''
        };

        // contenteditable 속성이 있는 div의 경우
        console.log('this: '+ this.textContent);
        console.log('this: '+ this.value);
        if (this.classList.contains('gantt-dropdow')) {
            if(this.classList.contains('gantt-status-color')){
              updatedValue.status = this.textContent;
            } else {
              updatedValue.responName = this.textContent;
            }
        } else if ( this.tagName === 'INPUT') {
            // input
            // updatedValue = this.textContent 
            if(this.getAttribute('id').includes('start')){
              updatedValue.start_date = this.textContent;   
            } else {
              updatedValue.end_date = this.textContent;           
            }
        } else if( this.tagName === 'SPAN'){
            updatedValue.title = this.textContent;
        }

        // 수정 요청 보내기 (이 부분은 서버에 요청을 보내는 로직으로 수정하셔야 합니다)
        sendUpdateRequest(id, updatedValue, numbersOnly);

        // 수정 완료 팝업 메시지 표시
        // showPopupMessage('수정 완료!');
    });
});



// // 각 요소에 대해 blur 이벤트를 추가하여 수정 시점을 감지하고 서버에 수정 요청을 보내는 예시
// document.querySelectorAll('.taskName, .responName, .statusName, .start-date, .end-date').forEach(element => {
//   element.addEventListener('blur', function(event) {
//       const id = this.dataset.id; // 데이터 속성을 이용하여 ID 가져오기
//       let updatedValue = '';

//       // contenteditable 속성이 있는 div의 경우
//       if (this.hasAttribute('contenteditable')) {
//           updatedValue = this.innerText;
//       } else if (this.tagName === 'INPUT' || this.tagName === 'SPAN') {
//           // input 또는 span의 경우
//           updatedValue = this.textContent || this.value;
//       }

//       // 수정 요청 보내기
//       sendUpdateRequest(id, updatedValue);
//   });
// });






// const axios = require('axios').default;

// const taskNameUp = document.querySelector('.taskName');
// const responNameUp = document.querySelector('.responName');
// const statusNameUp = document.querySelector('.statusName');
// const startDateUp = document.querySelector('.start-date');
// const endDateUp = document.querySelector('.end-date');

// const data = {
//   'title': taskNameUp.textContent,
//   'name': responNameUp.textContent,
//   'task_status_name': statusNameUp.textContent,
//   'start_date': startDateUp.value,
//   'end_date': endDateUp.value,
// }
// const headers = {
//   'Content-Type': 'application/json', // Content-Type 헤더 추가
// };

// axios.put('/api/gantt', data, { headers })
//   .then(res => {
//     console.log(res);
//     console.log(res.data)
//     // PUT 요청 성공 시 수행할 작업을 이곳에 추가합니다.
//   })
//   .catch(err => {
//     console.error(err);
//     throw new Error(err);
//   });



// sendDataToServer 함수 수정하여 매개변수로 필드와 값을 받도록 변경
// function sendDataToServer(Id, updatedFields) {
//   let data = {
//     'Id': Id,
//     'updatedFields': updatedFields // 여러 필드와 값을 포함하는 객체
//   };

//   axios.put('/api/gantt', data, {
//     headers: {
//       'Content-Type': 'application/json',
//     }
//   })
//   .then(res => {
//     console.log('데이터가 성공적으로 업데이트되었습니다.');
//     console.log(res.data);
//     // 필요한 경우 추가 작업 수행
//   })
//   .catch(err => {
//     console.log(err);
//     throw new Error(err);
//     // 오류 처리
//   });
// }

// // 이벤트 리스너 수정하여 여러 필드 업데이트 처리
// document.querySelectorAll('.editable-title').forEach(element => {
//   element.addEventListener('blur', function() {
//     const taskId = this.parentNode.parentNode.id.split('-')[2]; // 부모 div의 ID에서 작업 ID 추출

//     // 수정된 데이터를 저장할 객체 생성
//     let updatedFields = {};

//     // 예시: 여러 필드 업데이트를 위해 필드 이름과 값을 객체에 추가
//     updatedFields['title'] = document.querySelector('.taskName').textContent; // 'title' 필드 업데이트
//     updatedFields['task_responsible_id'] = document.querySelector('.responName').textContent;
//     updatedFields['task_status_id'] = document.querySelector('.gantt-status-color').textContent;
//     updatedFields['start_date'] = document.querySelector('.start-date').value;
//     updatedFields['end_date'] = document.querySelector('.end-date').value;

//     // 새 데이터로 서버 업데이트
//     sendDataToServer(taskId, updatedFields);
//   });
// });

  // Axios 요청 보내기
// Ajax를 사용하여 수정된 데이터를 서버로 전송하는 함수
// 수정 가능한 필드를 변경했을 때 발생하는 이벤트


// function sendDataToServer(taskNameUp, responNameUp, statusNameUp, startDateUp, endDateUp) {
//   let data = {
//     'title': taskNameUp,
//     'task_responsible_id': responNameUp,
//     'task_status_id': statusNameUp,
//     'start_date': startDateUp,
//     'end_date': endDateUp
//   }
//   let headers = {
//       headers: { 'Content-Type': 'application/json' } 
//   }
//   // Ajax를 사용하여 서버로 데이터 전송
//   axios.put('/api/gantt/', data, headers)
//       .then(res => {
//           console.log('데이터가 성공적으로 업데이트되었습니다.');
//           console.log(res.data);
//           // 필요한 경우 추가 작업 수행
//       })
//       .catch(error => {
//           console.log(error);
//           throw new Error(error);
//           // 오류 처리
//       });
// }

// document.querySelectorAll('.editable-title').forEach(element => {
//   element.addEventListener('blur', function() {
//     const taskNameUp = document.querySelector('.taskName').textContent;
//     const responNameUp = document.querySelector('.responName').textContent;
//     const statusNameUp = document.querySelector('.statusName').textContent;
//     const startDateUp = document.querySelector('.start-date').value;
//     const endDateUp = document.querySelector('.end-date').value;

//       // 수정된 데이터를 서버로 전송
//       sendDataToServer(taskNameUp, responNameUp, statusNameUp, startDateUp, endDateUp);
//   });
// });




//   function sendDataToServer(itemId) {
//     var title = document.querySelector('.taskName' + itemId).innerText; // 수정된 title 가져오기
//     var name = document.querySelector('.responName' + itemId).innerText; // 수정된 name 가져오기
//     var status = document.querySelector('.gantt-status-color').getAttribute('data-status'); // 수정된 task_status_name 가져오기
//     var startDate = document.getElementById('start-row' + itemId).value; // 수정된 start_date 가져오기
//     var endDate = document.getElementById('end-row' + itemId).value; // 수정된 end_date 가져오기


//     var data = {
//         id: itemId,
//         title: title,
//         name: name,
//         status: status,
//         start_date: startDate,
//         end_date: endDate
//     };

//     fetch('/ganttchart', {
//         method: 'PUT',
//         headers: {
//             'Content-Type': 'application/json',
//         },
//         body: JSON.stringify(data),
//     })
//     .then(response => {
//         if (!response.ok) {
//             throw new Error('Network response was not ok');
//         }
//         return response.json();
//     })
//     .then(data => {
//         // 서버 응답 처리
//         console.log('데이터가 성공적으로 전송되었습니다.', data);
//     })
//     .catch(error => {
//         // 오류 처리
//         console.error('데이터 전송 중 오류가 발생했습니다:', error);
//     });
// }

// ********* 수정했을 때 팝업창 뜨게
// function showPopup() {
//   // 여기에 팝업을 표시하는 코드를 작성하세요
//   alert('내용이 변경되었습니다!');
// }

// const targetNode = document.querySelectorAll('.editable-title'); // 감지할 대상 요소 선택

// // Observer 인스턴스 생성
// const observer = new MutationObserver(function(mutationsList) {
//   for (let mutation of mutationsList) {
//     if (mutation.type === 'childList' || mutation.type === 'characterData') {
//       // 내용이 변경되면 팝업을 표시하는 함수 호출
//       showPopup();
//     }
//   }
// });

// // Observer 구성
// const config = { attributes: true, childList: true, subtree: true, characterData: true };

// // 설정된 변화를 관찰하기 시작
// observer.observe(targetNode, config);


    






