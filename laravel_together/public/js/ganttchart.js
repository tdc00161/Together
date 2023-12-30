// ************* 개인 피드로 이동

// 간트 csrf
const csrfToken_gantt = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ************* 드롭박스 생성
let checkLists = document.getElementsByClassName('gantt-dropdown-check-list');

for (let i = 0; i < checkLists.length; i++) {
  let checkList = checkLists[i];

  checkList.getElementsByClassName('gantt-span')[0].onclick = function (evt) {
    if (checkList.classList.contains('visible'))
      checkList.classList.remove('visible');
    else
      checkList.classList.add('visible');
  }
}


// ************* 검색 기능
// 검색창에서 업무명, 업무번호 검색 시 바로 보이기
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
// 업무명 기준
document.addEventListener('DOMContentLoaded', function () {
  let sortingOrder_title = 0; 

  document.querySelector('.gantt-task-header-div:nth-child(1) button').addEventListener('click', function () {
    const tasks_title = document.querySelectorAll('.gantt-task');
    const icon_title = this.querySelector('img');

    const sortedTasks_title = Array.from(tasks_title).sort(function (a, b) {
      const taskNameA_title = a.querySelector('.taskName').textContent.toUpperCase();
      const taskNameB_title = b.querySelector('.taskName').textContent.toUpperCase();

      if (sortingOrder_title === 0) {
        return (taskNameA_title < taskNameB_title) ? -1 : (taskNameA_title > taskNameB_title) ? 1 : 0;
      } else if (sortingOrder_title === 1) {
        return (taskNameA_title > taskNameB_title) ? -1 : (taskNameA_title < taskNameB_title) ? 1 : 0;
      } else if (sortingOrder_title === 2) { // 세 번째 클릭 시 'taskKey'를 기준으로 오름차순 정렬
        const taskIdA_title = parseInt(a.querySelector('.taskKey').textContent);
        const taskIdB_title = parseInt(b.querySelector('.taskKey').textContent);
        return taskIdA_title - taskIdB_title;
      }
    });

    const ganttTaskBody_title = document.querySelector('.gantt-task-body');
    sortedTasks_title.forEach(tasks_title => ganttTaskBody_title.appendChild(tasks_title));
    sortingOrder_title = (sortingOrder_title + 1) % 3; // 클릭 수에 따라 순서 변경

    // 이미지 변경
    if (sortingOrder_title === 0) {
      icon_title.src = '/img/table4.png';
    } else if (sortingOrder_title === 1) {
      icon_title.src = '/img/table2.png';
    } else{
      icon_title.src = '/img/table.png';
    }
    // 자식 정렬
    const tasks_title_child = document.querySelectorAll('.gantt-child-task');

    const sortedTasks_title_child = Array.from(tasks_title_child).sort(function (a, b) {
      const taskNameA_title = a.querySelector('.taskName').textContent.toUpperCase();
      const taskNameB_title = b.querySelector('.taskName').textContent.toUpperCase();

      if (sortingOrder_title === 0) {
        return (taskNameA_title < taskNameB_title) ? -1 : (taskNameA_title > taskNameB_title) ? 1 : 0;
      } else if (sortingOrder_title === 1) {
        return (taskNameA_title > taskNameB_title) ? -1 : (taskNameA_title < taskNameB_title) ? 1 : 0;
      } else if (sortingOrder_title === 2) { // 세 번째 클릭 시 'taskKey'를 기준으로 오름차순 정렬
        const taskIdA_title = parseInt(a.querySelector('.taskKey').textContent);
        const taskIdB_title = parseInt(b.querySelector('.taskKey').textContent);
        return taskIdA_title - taskIdB_title;
      }
    })

    // 배치
    for (let index = tasks_title_child.length; index > 0; index--) {
      const element = tasks_title_child[index - 1];
      let ganttParentValue = element.getAttribute('parent')
      const ganttParentElement = document.querySelector('#gantt-task-' + ganttParentValue)
      ganttParentElement.after(element)
    }

    
    // 해당 업무들을 표시하는 차트 부분도 같은 순서로 재배치합니다.
    const ganttChartContainer_title = document.querySelector('.gantt-chart-container');
    sortedTasks_title_child.forEach(tasks_title => {
      const taskId_title = tasks_title.getAttribute('id').split('-')[2];
      const ganttChartItem_title = document.getElementById(`gantt-chart-${taskId_title}`);
      ganttChartContainer_title.appendChild(ganttChartItem_title);
    });


  });
});


// 담당자 기준
document.addEventListener('DOMContentLoaded', function () {
  let sortingOrder_respon = 0; // 변수를 추가하여 세 번째 클릭 시 'table3' 이미지로 바뀌도록 합니다.

  document.querySelector('.gantt-task-header-div:nth-child(2) button').addEventListener('click', function () {
    const tasks_respon = document.querySelectorAll('.gantt-task-body > .gantt-task');
    const icon_respon = this.querySelector('img');

    const sortedTasks_respon = Array.from(tasks_respon).sort(function (a, b) {
      const taskNameA_respon = a.querySelector('.responName').textContent.toUpperCase();
      const taskNameB_respon = b.querySelector('.responName').textContent.toUpperCase();

      if (sortingOrder_respon === 0) {
        return (taskNameA_respon < taskNameB_respon) ? -1 : (taskNameA_respon > taskNameB_respon) ? 1 : 0;
      } else if (sortingOrder_respon === 1) {
        return (taskNameA_respon > taskNameB_respon) ? -1 : (taskNameA_respon < taskNameB_respon) ? 1 : 0;
      } else if (sortingOrder_respon === 2) { // 세 번째 클릭 시 'taskKey'를 기준으로 오름차순 정렬
        const taskIdA_respon = parseInt(a.querySelector('.taskKey').textContent);
        const taskIdB_respon = parseInt(b.querySelector('.taskKey').textContent);
        return taskIdA_respon - taskIdB_respon;
      }
    });

    const ganttTaskBody_respon = document.querySelector('.gantt-task-body');
    sortedTasks_respon.forEach(task_respon => ganttTaskBody_respon.appendChild(task_respon));
    sortingOrder_respon = (sortingOrder_respon + 1) % 3; // 클릭 수에 따라 순서 변경

     // 이미지 변경
     if (sortingOrder_respon === 0) {
      icon_respon.src = '/img/table4.png';
    } else if (sortingOrder_respon === 1) {
      icon_respon.src = '/img/table2.png';
    } else{
      icon_respon.src = '/img/table.png';
    }

    // 자식 정렬
    const tasks_respon_child = document.querySelectorAll('.gantt-child-task');

    const sortedTasks_respon_child = Array.from(tasks_respon_child).sort(function (a, b) {
      const taskNameA_respon = a.querySelector('.responName').textContent.toUpperCase();
      const taskNameB_respon = b.querySelector('.responName').textContent.toUpperCase();

      if (sortingOrder_respon === 0) {
        return (taskNameA_respon < taskNameB_respon) ? -1 : (taskNameA_respon > taskNameB_respon) ? 1 : 0;
      } else if (sortingOrder_respon === 1) {
        return (taskNameA_respon > taskNameB_respon) ? -1 : (taskNameA_respon < taskNameB_respon) ? 1 : 0;
      } else if (sortingOrder_respon === 2) { // 세 번째 클릭 시 'taskKey'를 기준으로 오름차순 정렬
        const taskIdA_respon = parseInt(a.querySelector('.taskKey').textContent);
        const taskIdB_respon = parseInt(b.querySelector('.taskKey').textContent);
        return taskIdA_respon - taskIdB_respon;
      }
    });

    // 배치
    for (let index = tasks_respon_child.length; index > 0; index--) {
      const element = tasks_respon_child[index - 1];
      let ganttParentValue = element.getAttribute('parent')
      const ganttParentElement = document.querySelector('#gantt-task-' + ganttParentValue)
      ganttParentElement.after(element)
    }

    // 해당 업무들을 표시하는 차트 부분도 같은 순서로 재배치합니다.
    const ganttChartContainer_respon = document.querySelector('.gantt-chart-container');
    sortedTasks_respon_child.forEach(task_respon => {
      const taskId_respon = task_respon.getAttribute('id').split('-')[2];
      const ganttChartItem_respon = document.getElementById(`gantt-chart-${taskId_respon}`);
      ganttChartContainer_respon.appendChild(ganttChartItem_respon);
    });
  });
});

// 상태 기준
document.addEventListener('DOMContentLoaded', function () {
  let sortingOrder_status = 0; // 변수를 추가하여 세 번째 클릭 시 'table3' 이미지로 바뀌도록 합니다.

  document.querySelector('.gantt-task-header-div:nth-child(3) button').addEventListener('click', function () {
    const tasks_status = document.querySelectorAll('.gantt-task-body > .gantt-task');
    const icon_status = this.querySelector('img');

    const sortedTasks_status = Array.from(tasks_status).sort(function (a, b) {
      const taskNameA_status = a.querySelector('.statusName').textContent.toUpperCase();
      const taskNameB_status = b.querySelector('.statusName').textContent.toUpperCase();

      if (sortingOrder_status === 0) {
        return (taskNameA_status < taskNameB_status) ? -1 : (taskNameA_status > taskNameB_status) ? 1 : 0;
      } else if (sortingOrder_status === 1) {
        return (taskNameA_status > taskNameB_status) ? -1 : (taskNameA_status < taskNameB_status) ? 1 : 0;
      } else if (sortingOrder_status === 2) { // 세 번째 클릭 시 'taskKey'를 기준으로 오름차순 정렬
        const taskIdA_status = parseInt(a.querySelector('.taskKey').textContent);
        const taskIdB_status = parseInt(b.querySelector('.taskKey').textContent);
        return taskIdA_status - taskIdB_status;
      }
    });

    const ganttTaskBody_status = document.querySelector('.gantt-task-body');
    sortedTasks_status.forEach(task_status => ganttTaskBody_status.appendChild(task_status));
    sortingOrder_status = (sortingOrder_status + 1) % 3; // 클릭 수에 따라 순서 변경

     // 이미지 변경
     if (sortingOrder_status === 0) {
      icon_status.src = '/img/table4.png';
    } else if (sortingOrder_status === 1) {
      icon_status.src = '/img/table2.png';
    } else{
      icon_status.src = '/img/table.png';
    }

    // 자식 정렬
    const tasks_status_child = document.querySelectorAll('.gantt-child-task');

    const sortedTasks_status_child = Array.from(tasks_status_child).sort(function (a, b) {
      const taskNameA_status = a.querySelector('.statusName').textContent.toUpperCase();
      const taskNameB_status = b.querySelector('.statusName').textContent.toUpperCase();

      if (sortingOrder_status === 0) {
        return (taskNameA_status < taskNameB_status) ? -1 : (taskNameA_status > taskNameB_status) ? 1 : 0;
      } else if (sortingOrder_status === 1) {
        return (taskNameA_status > taskNameB_status) ? -1 : (taskNameA_status < taskNameB_status) ? 1 : 0;
      } else if (sortingOrder_status === 2) { // 세 번째 클릭 시 'taskKey'를 기준으로 오름차순 정렬
        const taskIdA_status = parseInt(a.querySelector('.taskKey').textContent);
        const taskIdB_status = parseInt(b.querySelector('.taskKey').textContent);
        return taskIdA_status - taskIdB_status;
      }
    });

    // 배치
    for (let index = tasks_status_child.length; index > 0; index--) {
      const element = tasks_status_child[index - 1];
      let ganttParentValue = element.getAttribute('parent')
      const ganttParentElement = document.querySelector('#gantt-task-' + ganttParentValue)
      ganttParentElement.after(element)
    }

    // 해당 업무들을 표시하는 차트 부분도 같은 순서로 재배치합니다.
    const ganttChartContainer_status = document.querySelector('.gantt-chart-container');
    sortedTasks_status_child.forEach(task_status => {
      const taskId_status = task_status.getAttribute('id').split('-')[2];
      const ganttChartItem_status = document.getElementById(`gantt-chart-${taskId_status}`);
      ganttChartContainer_status.appendChild(ganttChartItem_status);
    });
  });
});

// 시작일 기준
document.addEventListener('DOMContentLoaded', function () {
  let sortingOrder_start = 0;

  document.querySelector('.gantt-task-header-div:nth-child(4) button').addEventListener('click', function () {
    const tasks_start = document.querySelectorAll('.gantt-task-body > .gantt-task');
    const icon_start = this.querySelector('img');

    const sortedTasks_start = Array.from(tasks_start).sort(function (a, b) {
      // const taskNameA_start = a.querySelector(`#start-row${a.querySelector('.taskKey').textContent}`).value;
      const taskNameA_start = a.querySelector('.start-date').value;
      // const taskNameB_start = b.querySelector(`#start-row${b.querySelector('.taskKey').textContent}`).value;
      const taskNameB_start = b.querySelector('.start-date').value;

      if (sortingOrder_start === 0) {
        return (taskNameA_start < taskNameB_start) ? -1 : (taskNameA_start > taskNameB_start) ? 1 : 0;
      } else if (sortingOrder_start === 1) {
        return (taskNameA_start > taskNameB_start) ? -1 : (taskNameA_start < taskNameB_start) ? 1 : 0;
      } else if (sortingOrder_start === 2) {
        const taskIdA_start = parseInt(a.querySelector('.taskKey').textContent);
        const taskIdB_start = parseInt(b.querySelector('.taskKey').textContent);
        return taskIdA_start - taskIdB_start;
      }
    });

    const ganttTaskBody_start = document.querySelector('.gantt-task-body');
    sortedTasks_start.forEach(task_start => ganttTaskBody_start.appendChild(task_start));
    sortingOrder_start = (sortingOrder_start + 1) % 3;

     // 이미지 변경
     if (sortingOrder_start === 0) {
      icon_start.src = '/img/table4.png';
    } else if (sortingOrder_start === 1) {
      icon_start.src = '/img/table2.png';
    } else{
      icon_start.src = '/img/table.png';
    }

    // 자식 정렬
    const tasks_start_child = document.querySelectorAll('.gantt-child-task');

    const sortedTasks_start_child = Array.from(tasks_start_child).sort(function (a, b) {
      const taskNameA_start = a.querySelector('.start-date').value;
      const taskNameB_start = b.querySelector('.start-date').value;

      if (sortingOrder_start === 0) {
        return (taskNameA_start < taskNameB_start) ? -1 : (taskNameA_start > taskNameB_start) ? 1 : 0;
      } else if (sortingOrder_start === 1) {
        return (taskNameA_start > taskNameB_start) ? -1 : (taskNameA_start < taskNameB_start) ? 1 : 0;
      } else if (sortingOrder_start === 2) {
        const taskIdA_start = parseInt(a.querySelector('.taskKey').textContent);
        const taskIdB_start = parseInt(b.querySelector('.taskKey').textContent);
        return taskIdA_start - taskIdB_start;
      }
    });

    // 배치
    for (let index = tasks_start_child.length; index > 0; index--) {
      const element = tasks_start_child[index - 1];
      let ganttParentValue = element.getAttribute('parent')
      const ganttParentElement = document.querySelector('#gantt-task-' + ganttParentValue)
      ganttParentElement.after(element)
    }

    // 해당 업무들을 표시하는 차트 부분도 같은 순서로 재배치합니다.
    const ganttChartContainer_start = document.querySelector('.gantt-chart-container');
    sortedTasks_start_child.forEach(task_start => {
      const taskId_start = task_start.getAttribute('id').split('-')[2];
      const ganttChartItem_start = document.getElementById(`gantt-chart-${taskId_start}`);
      ganttChartContainer_start.appendChild(ganttChartItem_start);
    });
  });
});

// 마감일 기준
document.addEventListener('DOMContentLoaded', function () {
  let sortingOrder_end = 0;

  document.querySelector('.gantt-task-header-div:nth-child(5) button').addEventListener('click', function () {
    const tasks_end = document.querySelectorAll('.gantt-task-body > .gantt-task');
    const icon_end = this.querySelector('img');

    const sortedTasks_end = Array.from(tasks_end).sort(function (a, b) {
      // const taskNameA_end = a.querySelector(`#end-row${a.querySelector('.taskKey').textContent}`).value;
      const taskNameA_end = a.querySelector('.end-date').value;
      // const taskNameB_end = b.querySelector(`#end-row${b.querySelector('.taskKey').textContent}`).value;
      const taskNameB_end = b.querySelector('.end-date').value;

      if (sortingOrder_end === 0) {
        return (taskNameA_end < taskNameB_end) ? -1 : (taskNameA_end > taskNameB_end) ? 1 : 0;
      } else if (sortingOrder_end === 1) {
        return (taskNameA_end > taskNameB_end) ? -1 : (taskNameA_end < taskNameB_end) ? 1 : 0;
      } else if (sortingOrder_end === 2) {
        const taskIdA_end = parseInt(a.querySelector('.taskKey').textContent);
        const taskIdB_end = parseInt(b.querySelector('.taskKey').textContent);
        return taskIdA_end - taskIdB_end;
      }
    });

    const ganttTaskBody_end = document.querySelector('.gantt-task-body');
    sortedTasks_end.forEach(task_end => ganttTaskBody_end.appendChild(task_end));
    sortingOrder_end = (sortingOrder_end + 1) % 3;

    // 이미지 변경
    if (sortingOrder_end === 0) {
      icon_end.src = '/img/table4.png';
    } else if (sortingOrder_end === 1) {
      icon_end.src = '/img/table2.png';
    } else{
      icon_end.src = '/img/table.png';
    }

    // 자식 정렬
    const tasks_end_child = document.querySelectorAll('.gantt-child-task');

    const sortedTasks_end_child = Array.from(tasks_end_child).sort(function (a, b) {
      const taskNameA_end = a.querySelector('.end-date').value;
      const taskNameB_end = b.querySelector('.end-date').value;

      if (sortingOrder_end === 0) {
        return (taskNameA_end < taskNameB_end) ? -1 : (taskNameA_end > taskNameB_end) ? 1 : 0;
      } else if (sortingOrder_end === 1) {
        return (taskNameA_end > taskNameB_end) ? -1 : (taskNameA_end < taskNameB_end) ? 1 : 0;
      } else if (sortingOrder_end === 2) {
        const taskIdA_end = parseInt(a.querySelector('.taskKey').textContent);
        const taskIdB_end = parseInt(b.querySelector('.taskKey').textContent);
        return taskIdA_end - taskIdB_end;
      }
    });

    // 배치
    for (let index = tasks_end_child.length; index > 0; index--) {
      const element = tasks_end_child[index - 1];
      let ganttParentValue = element.getAttribute('parent')
      // console.log(element.getAttribute('parent'));
      const ganttParentElement = document.querySelector('#gantt-task-' + ganttParentValue)
      ganttParentElement.after(element)
    }

    // 해당 업무들을 표시하는 차트 부분도 같은 순서로 재배치합니다.
    const ganttChartContainer_end = document.querySelector('.gantt-chart-container');
    sortedTasks_end_child.forEach(task_end => {
      const taskId_end = task_end.getAttribute('id').split('-')[2];
      const ganttChartItem_end = document.getElementById(`gantt-chart-${taskId_end}`);
      ganttChartContainer_end.appendChild(ganttChartItem_end);
    });
  });
});








// ************* 상태값 드롭다운 선택
// 드롭박스 클릭 후 선택 수정


// 드롭박스 클릭 후 선택 수정



// ************* 체크박스 필터링


// ************* 스크롤 한번에




// ************* 하위 업무 추가
// id 값은 임의로 넣은것
function addSubTask(event, mainId) {
  console.log(event.target.parentNode.parentNode.parentNode);
  // const doMGanttTask = document.getElementById('gantt-task-314'); // 원래 자리접근
  // $item->id : ${ganttModalId}
  // $item2->id :   
  const doMGanttTask = event.target.parentNode.parentNode.parentNode; // 원래 자리접근
  let gantt_modal_id = doMGanttTask.id.match(/\d+/);
  // const ganttModalId = gantt_modal_id[0];
  console.log(gantt_modal_id[0]);
  // 차트 부분
  const doMGanttChart = document.getElementById('gantt-chart-' + gantt_modal_id[0]); // 원래 자리접근

  // 새로운 gantt-task 요소 생성(최상위)
  // <div class="gantt-task" id="gantt-task-{{$item->id}}"></div>
  const newTask = document.createElement('div');
  newTask.classList.add('gantt-task', 'gantt-child-task');
  // newTask.id = 'gantt-task-'; // 밑에서
  newTask.setAttribute('parent', gantt_modal_id[0])

  // gantt-task 안에 5개 div 생성

  // gantt-task 안 첫번째 div
  // <div class="gantt-editable-div editable"></div>
  const addGanttEditableDiv = document.createElement('div');
  addGanttEditableDiv.classList.add('gantt-editable-div', 'editable');
  // addGanttEditableDiv

  // gantt-task 안 첫번째 div 안 첫번째 btn 
  // <button class="gantt-task-detail-click"></button>
  const addGanttDetailClick = document.createElement('button');
  addGanttDetailClick.classList.add('gantt-task-detail-click');

  // gantt-task 안 첫번째 div 안 첫번째 btn 안 span
  const addGanttDetailClickSpan = document.createElement('span');
  addGanttDetailClickSpan.classList.add('gantt-task-detail-click-span');
  addGanttDetailClickSpan.textContent = '…';

  // gantt-task 안 첫번째 div 안 두번째 div 
  // <div class="gantt-detail" style="display: none">
  const addGanttDetail = document.createElement('div');
  addGanttDetail.classList.add('gantt-detail');
  addGanttDetail.style.display = 'none';

  // gantt-task 안 첫번째 div 안 두번째 div 안 btn
  // <button class="gantt-detail-btn" onclick="openTaskModal(1,0,{{$item->id}})">자세히보기</button>
  const addDetailButton = document.createElement('button');
  addDetailButton.classList.add('gantt-detail-btn');
  addDetailButton.textContent = '자세히보기';
  // addDetailButton.setAttribute('onclick', `openTaskModal(1,0, ${ganttModalId})`); // 밑에서 처리

  // gantt-task 안 첫번째 div 안 세번째 div 
  // <div class="taskKey">{{$item->task_number}}</div>
  const addTaskKey = document.createElement('div');
  addTaskKey.classList.add('taskKey');
  addTaskKey.style.display = 'none';
  // addTaskKey.textContent = '800'; // 밑에서 처리

  // gantt-task 안 첫번째 div 안 네번째 div
  // <div class="taskName editable-title" spellcheck="false" contenteditable="true">{{$item->title}}</div>
  const addTaskName = document.createElement('div');
  addTaskName.classList.add('taskName', 'editable-title');
  addTaskName.setAttribute("spellcheck", "false");
  addTaskName.setAttribute("contenteditable", "true");
  addTaskName.textContent = '하위업무명';
  let thisProjectId = window.location.pathname.match(/\d+/)[0];
  console.log();
  console.log('addChildTask');
  addTaskName.addEventListener('blur', addChildTask)

  
  // 하위업무 추가 과정
  function addChildTask() {
    console.log('blur 시작');
    let postData = {
      "title": addTaskName.textContent,
      "content": null,
      "project_id": thisProjectId,
      "task_parent": gantt_modal_id[0],
      "task_depth": '1'
    }
    console.log('blur 중');
    if (true) {
      // postData.task_status_id = document.querySelectorAll('#checked')[0].textContent
      postData.task_status_name = ''
      postData.task_number = ''
      // postData.task_responsible_id = document.querySelectorAll('.responsible_user')[0].textContent
      postData.task_responsible_name = ''
      postData.start_date = document.querySelector('#start-row000').value
      postData.end_date = document.querySelector('#end-row000').value
      // postData.priority_id = document.querySelectorAll('.priority_val')[0].textContent
      postData.priority_name = ''
      postData.category_id = 0
    }
    console.log('blur 중');
    
    fetch('/task', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken_gantt,
      },
      body: JSON.stringify(postData),
    })
      .then(response => response.json()) // response.json()
      .then(data => {
        addTaskName.removeEventListener('blur', addChildTask);
        addTaskKey.textContent = data.data.task_number;
        // console.log(data);

        // const ganttChildId = data.data.id;
        // console.log(ganttChildId);
        addDetailButton.setAttribute('onclick', 'openTaskModal(1,0, '+data.data.id+')');

        addTaskStartDate.id = 'start-row' + data.data.id;
        // addTaskStartDate.id = 'start-row000';

        console.log(addTaskStartDate);
        addTaskEndDate.id = 'end-row' + data.data.id;
        // addTaskEndDate.id = 'end-row000';

        console.log(addTaskEndDate);
        newChart.id = 'gantt-chart-' + data.data.id;
        console.log(newChart);
        
        // 시작일 종료일 날짜 설정
        const chartStartDate = new Date('2023-12-01');
        const chartEndDate = new Date('2023-12-31');

        // chartStartDate를 클론하여 chartNewStartDate에 할당
        const chartNewStartDate = new Date(chartStartDate);

        // 요소 생성 배치
        // end가 start보다 이전인지 확인
        while (chartNewStartDate <= chartEndDate) {
          // 날짜 yyyymmdd 변경
          const chartFormatDate = chartNewStartDate.toISOString().slice(0, 10).replace(/-/g, "");

          // gantt-chart안에 들어갈 새로운 div
          const ganttChartRow = document.createElement('div');
          ganttChartRow.id = 'row' + data.data.id + '-' + chartFormatDate;

          // 다음 날짜 이동
          chartNewStartDate.setDate(chartNewStartDate.getDate() + 1);

          // <div class="gantt-chart" id="ganbtt-chart-800">
          //    <div id="row800-(231201~231231)"></div>
          // </div> 생성
          newChart.appendChild(ganttChartRow);
        }

        // test
        addTaskStartDate.setAttribute('onchange', 'test('+data.data.id+')');
        addTaskEndDate.setAttribute('onchange', 'test('+data.data.id+')');

        // addEventListener 로 하는 방법
        //
        // const eventSubStartDate = document.getElementById(addTaskStartDate.id);
        // const eventSubEndDate = document.getElementById(addTaskEndDate.id);
        // console.log('start test에 id');
        // eventSubStartDate.addEventListener('change', e => test(`${ganttChildId}`));
        // console.log(eventSubStartDate.getAttribute('change'));
        // console.log('end test에 id');
        // eventSubEndDate.addEventListener('change', e => test(`${ganttChildId}`));
        // console.log(eventSubEndDate.getAttribute('change'));
        

        addChildTaskAfter(data);
      }
        )
      .catch(err=>console.log(err.message))
  
  }

  function addChildTaskAfter (data) {
    console.log('addChildTaskAfter');
    creating_delete = 1;
    console.log(data);
    // 이 곳에 after 간트차트(+날짜 계산해서 바로 출력)
    newTask.id = 'gantt-task-' + data.data.id;
    // 작성 기능 -> 수정 기능으로 바꾸기
    document.querySelectorAll('.taskName, .responName, .statusName, .start-date, .end-date').forEach(element => {
      element.addEventListener('blur', function (event) {
        event.target.parentNode.parentNode.getAttribute('id') //var result4 = str.slice(-4);
        // 간트 수정 시 타겟 추정 및 아이디 반환
        let originalString = 0;
        console.log('변경값 확인용1: ' + event.target.parentNode.getAttribute('id')); // responName
        console.log('변경값 확인용1: ' + event.target.parentNode.parentNode.getAttribute('id')); // title
        console.log('변경값 확인용1: ' + event.target.parentNode.parentNode.parentNode.getAttribute('id')); // status
        console.log('변경값 확인용1: ' + event.target.getAttribute('id')); // start, end
        if (event.target.parentNode.getAttribute('id')) {
          originalString = event.target.parentNode.getAttribute('id')
        } else if (event.target.parentNode.parentNode.getAttribute('id')) {
          originalString = event.target.parentNode.parentNode.getAttribute('id')
        } else if (event.target.parentNode.parentNode.parentNode.getAttribute('id')) {
          originalString = event.target.parentNode.parentNode.parentNode.getAttribute('id')
        } else if (event.target.getAttribute('id')) {
          originalString = event.target.getAttribute('id')
        }
        const parts = originalString.split('-');
        const numbersOnly = parts[parts.length - 1];
        console.log('id: ' + numbersOnly); // 출력 결과: 1243
        const id = this.dataset.id; // 데이터 속성을 이용하여 ID 가져오기
        let updatedValue = {
          'responName': '',
          'status': '',
          'start_date': '',
          'end_date': '',
          'title': ''
        };
    
        console.log('this: ' + this.textContent);
        console.log('this: ' + this.value);
    
        // 내용 가져오기
        if (this.tagName === 'DIV') {
          updatedValue.title = this.textContent;
        } else if (this.tagName === 'SPAN') {
          if (this.getAttribute('id').includes('responNameSpan')) {
            updatedValue.responName = this.textContent;
          } else {
            updatedValue.status = this.textContent;
          }
        } else if (this.tagName === 'INPUT') {
          if (this.getAttribute('id').includes('start')) {
            updatedValue.start_date = this.value;
          } else {
            updatedValue.end_date = this.value;
          }
    
        }
    
    
        // 수정 요청 보내기
        console.log('수정 신청');
        sendUpdateRequest(id, updatedValue, numbersOnly);
    
        // 수정 완료 팝업 메시지 표시
        showPopupMessage('수정 완료!');
      });
    });
  }
  // gantt-task 안 두번째 div
  // <div class="responName gantt-update-dropdown"></div>
  const addUserName = document.createElement('div');
  addUserName.classList.add('responName', 'gantt-update-dropdown');

  // gantt-task 안 두번째 div 안 span
  // <span id="responNameSpan">{{$item->name}}</span>
  const addUserNamespan = document.createElement('span');
  addUserNamespan.id = 'responNameSpan';
  addUserNamespan.textContent = '담당자';

  // gantt-task 안 세번째 div
  // <div class="gantt-status-name"></div>
  const addStatusColorDiv = document.createElement('div');
  addStatusColorDiv.classList.add('gantt-status-name');

  // gantt-task 안 세번째 div 안 div
  // <div class="statusName gantt-status-color gantt-update-dropdown" data-status="{{$item->task_status_name}}"></div>
  const addStatusColor = document.createElement('div');
  addStatusColor.classList.add('statusName', 'gantt-status-color', 'gantt-update-dropdown');
  addStatusColor.setAttribute('data-status', '시작전');
  // addStatusColor.dataset.status = '시작전';

  // gantt-task 안 세번째 div 안 div 안 span
  // <span>{{$item->task_status_name}}</span>
  const addStatusColorSpan = document.createElement('span');
  addStatusColorSpan.id = 'statusNameSpan';
  addStatusColorSpan.textContent = '시작전';


  // gantt-task 안 네번째 div
  // <div class="gantt-task-4"></div>
  const addTaskStartDateDiv = document.createElement('div');
  addTaskStartDateDiv.classList.add('gantt-task-4');

  // gantt-task 안 네번째 div 안 input
  //  <input type="date" name="start" id="start-row{{$item->id}}" onchange="test({{$item->id}});" value="{{$item->start_date}}">
  const addTaskStartDate = document.createElement('input');
  addTaskStartDate.type = 'date';
  addTaskStartDate.name = 'start';
  addTaskStartDate.classList.add('start-date');
  // console.log(ganttUnderTaskId);
  addTaskStartDate.id = 'start-row000'; //위에서
  addTaskStartDate.setAttribute('onchange', 'test(000);'); // 날짜 수정했을 때 차트 수정이 안됨 - 맨밑에 addEventListener로 수정
  // addTaskEndDate.value = '2023-12-01';

  // gantt-task 안 다섯번째 div
  // <div class="gantt-task-5"></div>
  const addTaskEndDateDiv = document.createElement('div');
  addTaskEndDateDiv.classList.add('gantt-task-5');

  // gantt-task 안 다섯번째 div 안 input
  // <input type="date" name="end" id="end-row{{$item->id}}" onchange="test({{$item->id}});" value="{{$item->end_date}}">
  const addTaskEndDate = document.createElement('input');
  addTaskEndDate.type = 'date';
  addTaskEndDate.name = 'end';
  addTaskEndDate.classList.add('end-date');
  addTaskEndDate.id = 'end-row000'  //위에서
  addTaskEndDate.setAttribute('onchange', 'test(000);'); // 날짜 수정했을 때 차트 수정이 안됨 - 맨밑에 addEventListener로 수정
  // addTaskEndDate.value = '2023-12-05';


  // gantt-task 안에 첫번째
  newTask.appendChild(addGanttEditableDiv);
  addGanttEditableDiv.appendChild(addGanttDetailClick);
  addGanttDetailClick.appendChild(addGanttDetailClickSpan);
  addGanttEditableDiv.appendChild(addGanttDetail);
  addGanttDetail.appendChild(addDetailButton);
  addGanttEditableDiv.appendChild(addTaskKey);
  addGanttEditableDiv.appendChild(addTaskName);

  // gantt-task 안에 두번째
  newTask.appendChild(addUserName);
  addUserName.appendChild(addUserNamespan)

  // gantt-task 안에 세번째
  newTask.appendChild(addStatusColorDiv);
  addStatusColorDiv.appendChild(addStatusColor);
  addStatusColor.appendChild(addStatusColorSpan);

  // gantt-task 안에 네번째
  newTask.appendChild(addTaskStartDateDiv);
  addTaskStartDateDiv.appendChild(addTaskStartDate);

  // gantt-task 안에 다섯번째
  newTask.appendChild(addTaskEndDateDiv);
  addTaskEndDateDiv.appendChild(addTaskEndDate);

  // 원래 자리 다음에 생성
  doMGanttTask.after(newTask);

  // ------------- 왼쪽 업무부분 생성 완

  const newChart = document.createElement('div');
  newChart.classList.add('gantt-chart', 'gantt-child-chart');
  newChart.id = 'gantt-chart-000'; //위에서
  newChart.setAttribute('parent', gantt_modal_id[0])

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
    const chartFormatDate = chartNewStartDate.toISOString().slice(0, 10).replace(/-/g, "");

    // gantt-chart안에 들어갈 새로운 div
    const ganttChartRow = document.createElement('div');
    ganttChartRow.id = 'row000' + '-' + chartFormatDate; // 위에서

    // 다음 날짜 이동
    chartNewStartDate.setDate(chartNewStartDate.getDate() + 1);

    // <div class="gantt-chart" id="ganbtt-chart-800">
    //    <div id="row800-(231201~231231)"></div>
    // </div> 생성
    newChart.appendChild(ganttChartRow);
  }

  // addEventListener 로 하는 방법
  //
  // const eventSubStartDate = document.getElementById(addTaskStartDate.id);
  // const eventSubEndDate = document.getElementById(addTaskEndDate.id);
  // eventSubStartDate.addEventListener('change', e => test('000'));
  // console.log(eventSubStartDate.getAttribute('onchange'));
  // eventSubEndDate.addEventListener('change', e => test('000'));
  // console.log(eventSubEndDate.getAttribute('onchange'));


  // --- 차트 부분 생성 완



}



// ************* 업무상태 색상
document.addEventListener('DOMContentLoaded', function () {
  var elements = document.querySelectorAll('.gantt-status-color');

  elements.forEach(function (element) {
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


// ************* 버튼에 클릭 시 gantt-detail 요소 드롭다운 보이기
// 모든 gantt-task-detail-click 버튼을 선택합니다.
const taskDetailClickBtns = document.querySelectorAll('.gantt-task-detail-click');

// 각 버튼에 대해 반복하여 이벤트 리스너를 추가
taskDetailClickBtns.forEach(function (button) {
  button.addEventListener('click', function () {
    // 클릭된 버튼의 부모 요소인 gantt-editable-div를 찾습니다.
    const parentEditableDiv = button.closest('.gantt-editable-div');

    // 해당 버튼 아래에 있는 gantt-detail 요소를 찾습니다.
    const ganttDetail = parentEditableDiv.querySelector('.gantt-detail');

    // gantt-detail 요소의 표시 여부를 토글합니다.
    if (ganttDetail.style.display === 'none' || ganttDetail.style.display === '') {
      ganttDetail.style.display = 'block';
      // gantt-detail 요소가 보일 때 버튼 색상을 변경합니다.
      button.style.color = 'rgb(151, 87, 255)';
    } else {
      ganttDetail.style.display = 'none';
      // gantt-detail 요소가 숨겨질 때 버튼 색상을 초기화
      button.style.color = ''; // 초기 색상으로 변경하거나 ''로 설정
    }
    // 문서에 전체 이벤트 리스너 추가
    document.addEventListener('click', function closeGanttDetail(e) {
      // 클릭된 요소가 gantt-detail 또는 그 부모 요소가 아니면 gantt-detail을 숨깁니다.
      if (!e.target.closest('.gantt-detail') && !e.target.closest('.gantt-task-detail-click')) {
        ganttDetail.style.display = 'none';
        button.style.color = ''; // 버튼 색상 초기화
        document.removeEventListener('click', closeGanttDetail); // 이벤트 리스너 제거
      }
    });
  });
});




// ************* 차트영역 헤더에 날짜 추가
const headerScroll = document.querySelector('.gantt-header-scroll');

// 예시 데이터 - 날짜
const startDate = new Date('2023-12-01');
const endDate = new Date('2024-03-31');

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
// 페이지 로드 후 실행되는 부분
window.onload = function () {
  // 모든 시작일(start)과 종료일(end) 입력 요소 선택
  const dataElements = document.querySelectorAll('[id^=start-row], [id^=end-row]');

  dataElements.forEach(function (element) {
    const rowNum = element.id.split('row')[1]; // ID에서 행 번호 추출

    // 해당 rowNum에 대한 시작일(start)과 종료일(end) 값 획득
    const start = document.getElementById('start-row' + rowNum).value;
    const end = document.getElementById('end-row' + rowNum).value;

    // test 함수 초기 호출
    test(rowNum);

    // 'change' 이벤트에 대한 리스너 추가하여 값 변경 시 test 함수 호출
    element.addEventListener('change', function () {
      test(rowNum);
    });
  });
};

// 파라미터 : rowNum   테이블에서의 해당 row 번호

function test(rowNum) {
  // console.log('***** test() Start *****');

  const start = document.getElementById('start-row' + rowNum).value;
  const end = document.getElementById('end-row' + rowNum).value;

  // console.log(start);
  // console.log(end);

  if (start && end) {
    let startDate = new Date(start);
    let endDate = new Date(end);

    const existingBkRowList = document.querySelectorAll('.bk-row[data-row-num="' + rowNum + '"]');
    existingBkRowList.forEach(function (item) {
      item.parentNode.removeChild(item);
    });

    while (startDate <= endDate) {
      const formattedDate = startDate.toISOString().slice(0, 10).replace(/-/g, '');

      const target = document.getElementById('row' + rowNum + '-' + formattedDate);

      const div = document.createElement('div');
      div.classList = 'bk-row';
      div.dataset.rowNum = rowNum;
      div.textContent = '';

      target.appendChild(div);

      if (startDate.getTime() === new Date(start).getTime()) {
        div.textContent = '시작일: ' + formattedDate;
      }

      if (startDate.getTime() === new Date(end).getTime()) {
        div.textContent = '마감일: ' + formattedDate;
      }

      // 다음 날짜로 이동
      startDate.setDate(startDate.getDate() + 1);
    }
  }
}

// 기존 것인데 다음달이 넘어가면 차트바가 표시안됨
// function test(rowNum) {
//   console.log('***** test() Start *****');
//   // 해당 시작일, 종료일 요소 습득
//   const start = document.getElementById('start-row' + rowNum).value;
//   const end = document.getElementById('end-row' + rowNum).value;


//   console.log(start);
//   console.log(end);

//   if (start && end) {
//     // 추가 할 bk-row div의 데이트 포멧 변경 : yyyy-mm-dd >> yyyymmdd
//     let startAt = parseInt(start.replace(/-/g, ''), 10); // - 제거
//     let endAt = parseInt(end.replace(/-/g, ''), 10);
//     // console.log(endAt);

//     // 기존 bk-row div 삭제
//     const existingBkRowList = document.querySelectorAll('.bk-row[data-row-num="' + rowNum + '"]');

//     // console.log(existingBkRowList);
//     existingBkRowList.forEach(function (item) {
//       item.parentNode.removeChild(item);
//     });

//     // bk-row div 추가
//     for (let currentDate = startAt; currentDate <= endAt; currentDate++) {
//       const dateString = currentDate.toString();
//       const year = dateString.substring(0, 4);
//       const month = dateString.substring(4, 6);
//       const day = dateString.substring(6, 8);
//       const formattedDate = year + month + day;
//       // console.log(endAt);

//       const target = document.getElementById('row' + rowNum + '-' + formattedDate); // ex) row1-231201
//       // console.log(target);


//       // bk-row div 요소 생성
//       const div = document.createElement('div');
//       div.classList = 'bk-row';
//       div.dataset.rowNum = rowNum; // 해당 rowNum을 데이터로 저장
//       div.textContent = '';

//       // 타겟에 bk-row div 추가
//       target.appendChild(div);

//       // 첫 번째와 마지막 bk-row에 시작일과 종료일 추가

//       if (currentDate === startAt) {
//         div.textContent = '시작일: ' + formattedDate;
//       }


//       if (currentDate === endAt) {
//         div.textContent = '마감일: ' + formattedDate;
//       }
//     }
//   }
// }

// ************* 업무추가 버튼클릭 시 상위업무 추가

/*******************
   * 1. ajax로 백앤에 request
   * 2. id를 이용해서 해당 프로젝트의 하위업무 갯수 획득
   * 3. [2]에서 획득한 갯수+1해서 하위업무 생성
   * 4. [3]에서 생성한 데이터 json으로 respone
   * 5. [4]에서 받은 데이터를 기반으로 프론트 테이블 로우 요소 생성
   * 6. 
   */

// 예시: 수정 요청을 보내는 함수
function sendUpdateRequest(id, updatedValue, numbersOnly) {
  // Axios를 사용하여 수정 요청을 보내는 로직
  // 여기에 실제 서버 엔드포인트 및 요청 설정을 작성해야 합니다.
  // 아래는 가상의 코드입니다.
  let url = '/ganttchartRequest/' + numbersOnly
  console.log(url);
  axios.put(url, { 'value': updatedValue })
    .then(res => {
      // 성공적으로 요청을 보낸 후에 할 작업
      console.log('수정 요청 성공:', res.data);
      // addChildTaskAfter(res.data);
    })
    .catch(err => {
      // 요청 실패 시 에러 처리
      console.log('수정 요청 실패:', err);
    });
}

// 수정 완료 팝업 창 보이기
function showPopupMessage(message) {
  const popupModal = document.getElementById('ganttPopupModal');
  const popupMessage = document.getElementById('ganttPopupMessage');

  popupMessage.textContent = message;
  popupModal.style.display = 'block';

  // 일정 시간(여기서는 3초) 후 팝업 창 닫기
  setTimeout(() => {
    popupModal.style.display = 'none';
  }, 1000);
}

// 각 요소에 대해 blur 이벤트를 추가하여 수정 시점을 감지하고 서버에 수정 요청을 보내는 예시
document.querySelectorAll('.taskName, .responName, .statusName, .start-date, .end-date').forEach(element => {
  element.addEventListener('blur', function (event) {
    event.target.parentNode.parentNode.getAttribute('id') //var result4 = str.slice(-4);
    // 간트 수정 시 타겟 추정 및 아이디 반환
    let originalString = 0;
    console.log('변경값 확인용1: ' + event.target.parentNode.getAttribute('id')); // responName
    console.log('변경값 확인용1: ' + event.target.parentNode.parentNode.getAttribute('id')); // title
    console.log('변경값 확인용1: ' + event.target.parentNode.parentNode.parentNode.getAttribute('id')); // status
    console.log('변경값 확인용1: ' + event.target.getAttribute('id')); // start, end
    if (event.target.parentNode.getAttribute('id')) {
      originalString = event.target.parentNode.getAttribute('id')
    } else if (event.target.parentNode.parentNode.getAttribute('id')) {
      originalString = event.target.parentNode.parentNode.getAttribute('id')
    } else if (event.target.parentNode.parentNode.parentNode.getAttribute('id')) {
      originalString = event.target.parentNode.parentNode.parentNode.getAttribute('id')
    } else if (event.target.getAttribute('id')) {
      originalString = event.target.getAttribute('id')
    }
    const parts = originalString.split('-');
    const numbersOnly = parts[parts.length - 1];
    console.log('id: ' + numbersOnly); // 출력 결과: 1243
    const id = this.dataset.id; // 데이터 속성을 이용하여 ID 가져오기
    let updatedValue = {
      'responName': '',
      'status': '',
      'start_date': '',
      'end_date': '',
      'title': ''
    };

    console.log('this: ' + this.textContent);
    console.log('this: ' + this.value);

    // 내용 가져오기
    if (this.tagName === 'DIV') {
      updatedValue.title = this.textContent;
    } else if (this.tagName === 'SPAN') {
      if (this.getAttribute('id').includes('responNameSpan')) {
        updatedValue.responName = this.textContent;
      } else {
        updatedValue.status = this.textContent;
      }
    } else if (this.tagName === 'INPUT') {
      if (this.getAttribute('id').includes('start')) {
        updatedValue.start_date = this.value;
      } else {
        updatedValue.end_date = this.value;
      }

    }


    // 수정 요청 보내기
    console.log('수정 신청');
    sendUpdateRequest(id, updatedValue, numbersOnly);

    // 수정 완료 팝업 메시지 표시
    showPopupMessage('수정 완료!');
  });
});


