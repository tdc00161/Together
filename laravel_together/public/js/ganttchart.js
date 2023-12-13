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


  // 간트 차트에 작업 추가하는 함수 
// 예시 데이터 - 날짜와 작업 정보
// const tasks = [
//   { taskName: 'Task 1', startDate: '2023-12-01', endDate: '2023-12-05' },
//   { taskName: 'Task 2', startDate: '2023-12-03', endDate: '2023-12-08' },
//   // 추가 작업 데이터
// ];

// // 간트 차트에 작업 추가하는 함수
// function addTasksToChart() {
//   const chartBody = document.querySelector('.gantt-chart-body');

//   tasks.forEach(task => {
//     const taskElement = document.createElement('div');
//     taskElement.classList.add('task');
//     const startDate = new Date(task.startDate);
//     const endDate = new Date(task.endDate);
//     const duration = (endDate - startDate) / (1000 * 60 * 60 * 24); // 일 단위로 계산

//     taskElement.style.width = `${duration * 20}px`; // 각 작업의 기간에 따라 너비 지정
//     taskElement.innerHTML = task.taskName;

//     chartBody.appendChild(taskElement);
//   });
// }

// addTasksToChart();

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

// **** 차트생성...
// 파라미터 : rowNum   테이블에서의 해당 row 번호
function test(rowNum) {
  // 해당 시작일, 종료일 요소 습득
        const sat = document.getElementById('start-row'+rowNum).value;
        const eat = document.getElementById('end-row'+rowNum).value;

        if(sat && eat) {
    // 기존 bk-row div 삭제
      const bkRowList = document.querySelectorAll('.bk-row');
      if(bkRowList) {
        bkRowList.forEach( function(item) {
          item.remove();
      });
    }

    // 추가 할 bk-row div의 데이트 포멧 변경 : yyyy-mm-dd >> yyyymmdd
    let startAt = sat.replace(/-/g, ''); // - 제거
    let endAt = eat.replace(/-/g, '');

    // bk-row div 추가
    for(startAt; startAt <= endAt; startAt++) {
      // 타겟 일자 요소 습득
      const target = document.getElementById('row' + rowNum + '-' + startAt); // ex) row1-231201

      // bk-row div 요소 생성
      const div = document.createElement('div');
      div.classList = 'bk-row';

      // 타겟에 bk-row div 추가
      target.appendChild(div);
    }
        }
    }
