console.log('프로젝트 페이지가 insert_detail.js를 읽어들이지 않는다.');
// 변수 선언 ---------------------------------
// body 전체
const BODY = document.querySelector('body')
// 간트 업무 좌측 영역
const GANTT_LEFT = document.querySelectorAll('.gantt-task') ? document.querySelectorAll('.gantt-task') : ''
// 간트 업무 우측 영역
const GANTT_RIGHT = document.querySelectorAll('.gantt-chart') ? document.querySelectorAll('.gantt-chart') : ''
// 모달 전체
const TASK_MODAL = document.querySelectorAll('.task_modal')
// 작성 모달
const INSERT_MODAL = document.querySelector('.insert_modal')
// 더보기모달 (디테일)
const MORE_MODAL = document.querySelector('.more_modal')
// 프로젝트 색상
const PROJECT_COLOR = document.querySelectorAll('.task_project_color')
// 프로젝트명 (공통)
const PROJECT_NAME = document.querySelectorAll('.project_name')
// 상위 업무 틀
const OVERHEADER = document.querySelectorAll('.overheader')
// 상위 업무 parent
const OVERHEADER_PARENT = document.querySelectorAll('.parent')
// 상위 업무 grand_parent
const OVERHEADER_GRAND_PARENT = document.querySelectorAll('.grand_parent')
// 작성자
const WRITER_NAME = document.querySelector('.wri_name')
// 업무 작성일
const TASK_CREATED_AT = document.querySelector('.task_created_at')
// 업무 제목
const TASK_TITLE = document.querySelector('.title')
// 업무 제목 입력
const INSERT_TASK_TITLE = document.querySelector('.insert_title')
// 업무상태 (공통)
const STATUS_VALUE = document.getElementsByClassName('status_val')
// 상세 업무 상태
const DET_STATUS_VAL = document.querySelector('.det_status_val')
// 담당자 틀 (공통)
const RESPONSIBLE = document.querySelectorAll('.responsible')
// 담당자 (공통)
const RESPONSIBLE_PERSON = document.querySelectorAll('.responsible_one')
// 상세 업무 담당자
const RESPONSIBLE_USER = document.querySelectorAll('.responsible_user')
// 담당자 아이콘
const RESPONSIBLE_ICON = document.querySelectorAll('.responsible_icon')
// 담당자 추가/변경 버튼
const RESPONSIBLE_ADD_BTN = document.querySelectorAll('.add_responsible')
// 담당자 모달
const ADD_RESPONSIBLE_MODAL = document.querySelector('.add_responsible_modal')
// 담당자 모달 하나
const ADD_RESPONSIBLE_MODAL_ONE = document.querySelector('.add_responsible_modal_one')
// 상세 시작일
const START_DATE = document.querySelectorAll('.start_date')
// 상세 마감일
const END_DATE = document.querySelectorAll('.end_date')
// 상세 마감일정 div
const DEAD_LINE = document.querySelectorAll('.dead_line')
// 우선순위 틀(공통)
const PRIORITY = document.querySelectorAll('.priority')
// 우선순위 (공통)
const PRIORITY_ONE = document.querySelectorAll('.priority_one')
// 상세 업무 우선순위
const PRIORITY_VAL = document.querySelectorAll('.priority_val')
// 우선순위 옆 아이콘
// css img 입힐 때 중복이라서 flag_icon이라 적음. 담당자와 달라서 헷갈림 주의
const PRIORITY_ICON = document.querySelectorAll('.flag_icon')
// 우선순위 별 아이콘
const PRIORITY_ICON_VALUE = document.querySelectorAll('.priority_icon')
// 우선순위 추가/변경 버튼
const PRIORITY_ADD_BTN = document.querySelectorAll('.add_priority')
// 우선순위 모달
const ADD_PRIORITY_MODAL = document.querySelector('.add_priority_modal')
// 우선순위 모달 하나
const ADD_PRIORITY_MODAL_ONE = document.querySelector('.add_priority_modal_one')
// 상세 업무/글 내용
const DETAIL_CONTENT = document.querySelector('.detail_content')
// 작성 업무/글 내용
const INSERT_CONTENT = document.querySelector('.insert_content')
// 업무/글 플래그?
const BOARD_TYPE = document.querySelectorAll('.type_task')
// 더보기
const MORE = document.querySelector('.more')
// 댓글 부모
const COMMENT_PARENT = document.querySelector('.comment')
// 댓글 하나
const COMMENT_ONE = document.querySelectorAll('.comment_one')
// 입력한 댓글 내용
const INPUT_COMMENT_CONTENT = document.querySelector('#comment_input')
// 모달 배경 블러처리
const BEHIND_MODAL = document.querySelector('.behind_insert_modal');

// 입력용
let INSERT_TITLE = document.querySelector('.insert_title')
let CHECKED_STATUS = document.querySelectorAll('#checked')[0]
// 입력 버튼
let SUBMIT = document.querySelectorAll('.submit')


// 담당자 모달 초기화용 클론
let cloneResponsibleModal = ADD_RESPONSIBLE_MODAL_ONE.cloneNode(true) ? ADD_RESPONSIBLE_MODAL_ONE.cloneNode(true) : ''
// 담당자 초기화용 클론
let cloneResponsibleReset = RESPONSIBLE[0].cloneNode(true) ? RESPONSIBLE[0].cloneNode(true) : ''
// 담당자 추가용 클론
let cloneResponsible = RESPONSIBLE_PERSON[0].cloneNode(true) ? RESPONSIBLE_PERSON[0].cloneNode(true) : ''
// 우선순위 모달 초기화용 클론
let clonePriorityModal = ADD_PRIORITY_MODAL_ONE.cloneNode(true) ? ADD_PRIORITY_MODAL_ONE.cloneNode(true) : ''
// 우선순위 추가용 클론
let clonePriority = PRIORITY_ONE[0].cloneNode(true) ? PRIORITY_ONE[0].cloneNode(true) : ''
// 댓글 초기화용 클론
let cloneResetComments = COMMENT_PARENT.cloneNode(true) ? COMMENT_PARENT.cloneNode(true) : ''
// 좌측 간트 초기화용 클론
let cloneLeftGanttChart = GANTT_LEFT[0] ? GANTT_LEFT[0].cloneNode(true) : ''
// 우측 간트 초기화용 클론
let cloneRightGanttChart = GANTT_RIGHT[0] ? GANTT_RIGHT[0].cloneNode(true) : ''
// 모달 내용 저장소
let detail_data = {};
// 띄운 상세 업무 id (더보기용)
let detail_id = 0;
// 작성/수정 플래그
let createUpdate = 0;
// 업무/공지 플래그
let TaskNoticeFlg = 0;
// 현재 프로젝트 확인
let thisProjectId = window.location.pathname.match(/\d+/)[0] ? window.location.pathname.match(/\d+/)[0] : 1;
// thisProjectId = window.location.pathname.match(/\d+/)[0]; // 임시
// 현재 업무번호 확인
let now_task_id = 0;
// 현재 댓글id 확인
let thisCommentId = 0;

// csrf
const csrfToken_insert_detail = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// 업무상태 기본값 설정
STATUS_VALUE[0].style = 'background-color: #B1B1B1;'

// 바깥영역 클릭시 인서트모달 닫기
BEHIND_MODAL.addEventListener('click', function (event) {
	if (BEHIND_MODAL.contains(event.target)) {
		if (!TASK_MODAL[0].contains(event.target)) {
			closeTaskModal(0);
		}
	}
})

// 함수-------------------------------
// 모달 여닫기 (중복 열기 불가)
function openTaskModal(a, b = 0, c = null) { // (작성/상세, 업무/공지, task_id)
	// 업무/공지 플래그
	TaskNoticeFlg = b

	// 더보기 모달 닫기
	closeMoreModal()

	// 창 틀 우선 띄우기
	// TASK_MODAL[a].classList.remove('d-none')

	// 작성 모달 띄우기
	if (a === 0) {
		// 작성 전 초기화
		document.querySelector('.insert_title').value = ''
		document.querySelectorAll('.status_val')[0].id = 'checked'
		if (!document.querySelectorAll('.insert_responsible_one')[0].classList.contains('d-none')) {
			RESPONSIBLE[0].removeChild(document.querySelectorAll('.insert_responsible_one')[0])
		}
		DEAD_LINE[0].classList.remove('d-none')
		if (!document.querySelectorAll('.insert_priority_one')[0].classList.contains('d-none')) {
			PRIORITY[0].removeChild(document.querySelectorAll('.insert_priority_one')[0])
		}


		// 프로젝트 색 가져오기
		fetch('/project/' + thisProjectId, {
			method: 'GET',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': csrfToken_insert_detail,
			},
			// body: JSON.stringify({
			// 	receiver_email: receiverEmail,
			// }),
		})
			.then(response => response.json())
			.then(data => {
				// console.log(data);
				// 프로젝트 색 띄우기
				PROJECT_COLOR[a].style = 'background-color: ' + data.data[0].data_content_name + ';'
				PROJECT_NAME[a].textContent = data.data[0].project_title
			})
			.catch(error => {
				console.error('Error:', error);
			});

		// 작성모달 모서리 둥글게
		TASK_MODAL[0].style = 'border-radius: 14px;'

		// 프로젝트 명 뒤의 task 타입
		if (b === 1) {
			const INSERT_TYPE = document.querySelector('.insert_type')
			INSERT_TYPE.textContent = '공지'
		}

		// 입력창 플래그별로 길이조정
		if (b === 0) {
			INSERT_CONTENT.value = ''
		}
	}

	// 업무/공지 플래그 넣기 (나중에 변수로 통합가능)
	TaskNoticeFlg = b

	// 작성/수정 플래그별 등록버튼 기능
	if (createUpdate === 1) {
		SUBMIT[0].setAttribute('onclick', 'updateTask()')
	} else {
		SUBMIT[0].setAttribute('onclick', 'createTask()')
	}

	// 상세 모달 띄우기
	if (a === 1) {
		// 작성모달 모서리 둥글게
		TASK_MODAL[1].style = 'border-radius: 14px 0 0 14px;'

		// 상세 정보 가져오기
		fetch('/task/' + c, {
			method: 'GET',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': csrfToken_insert_detail,
			},
		})
			.then(response => response.json())
			.then(data => {
				// 값을 모달에 삽입
				insertModalValue(data, a);
				
				// 업무상태 값과 색상 주기
				statusColor(data);
				
				// 담당자 값체크, 삽입
				responsibleName(data, a);
				
				// 마감일자 값체크, 삽입
				deadLineValue(data, a);
				
				// 우선순위 값체크, 삽입
				priorityValue(data, a);
				
				// 상세업무 내용 값체크, 삽입
				modalContentValue(data, a);
				
				// 댓글 컨트롤
				commentControl(data);

				// 상위업무 컨트롤
				parentTaskControl(data, a);

				// 현재 업무 id 저장
				now_task_id = data.task[0].id

				TASK_MODAL[a].classList.remove('d-none')
			})
			.catch(error => {
				console.error('Error:', error);
			});
	}
	// 모달 띄우기
	openInsertDetailModal(a);
	// 글/업무 플래그
	TaskFlg(a, b);
}
// 모달 닫기
function closeTaskModal(a) {
	TASK_MODAL[a].style = 'display: none;'
	if (a === 0) {
		BEHIND_MODAL.style = 'display: none;'
		// 업무상태 기본값 설정
		for (let index = 0; index < STATUS_VALUE.length; index++) {
			STATUS_VALUE[index].removeAttribute('id');
			STATUS_VALUE[index].style = 'background-color: var(--m-btn);';
		}
		STATUS_VALUE[0].style = 'background-color: #B1B1B1;'
	}
}

// 모달 작성
function createTask() {
	let postData = {
		"title": INSERT_TITLE.value,
		"content": INSERT_CONTENT.value,
		"project_id": thisProjectId,
		"category_id": document.querySelectorAll('.property')[0].classList.contains('d-none') ? 1 : 0 // TODO
	}
	if (TaskNoticeFlg === 0) {
		postData.task_status_id = document.querySelectorAll('#checked')[0].textContent
		postData.task_status_name = ''
		postData.task_responsible_id = document.querySelectorAll('.responsible_user')[0].textContent
		postData.task_responsible_name = ''
		postData.start_date = document.querySelectorAll('.start_date')[0].value
		postData.end_date = document.querySelectorAll('.end_date')[0].value
		postData.priority_id = document.querySelectorAll('.priority_val')[0].textContent
		postData.priority_name = ''
	}
	fetch('/task', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': csrfToken_insert_detail,
		},
		body: JSON.stringify(postData),
	})
		.then(response => response.json())
		.then(data => {
			console.log(data);
			if(GANTT_LEFT[0]){

				let refreshCloneLeftGanttChart = GANTT_LEFT[0].cloneNode(true)
				let refreshCloneRightGanttChart = GANTT_RIGHT[0].cloneNode(true)
				
				let gantt_task_element = refreshCloneLeftGanttChart
				let start_element = refreshCloneLeftGanttChart.firstChild.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.firstElementChild
				let end_element = refreshCloneLeftGanttChart.firstChild.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling.firstElementChild
				let taskKey_element = refreshCloneLeftGanttChart.firstElementChild.firstElementChild.nextElementSibling.nextElementSibling
				let taskName_element = refreshCloneLeftGanttChart.firstChild.nextElementSibling.firstChild.nextElementSibling.nextElementSibling.nextElementSibling.nextElementSibling
				let responsibleName_element = refreshCloneLeftGanttChart.firstChild.nextElementSibling.nextElementSibling
				let statusName_element = refreshCloneLeftGanttChart.firstChild.nextElementSibling.nextElementSibling.nextElementSibling.firstChild.nextElementSibling
				let statusName_element_textContent = refreshCloneLeftGanttChart.firstChild.nextElementSibling.nextElementSibling.nextElementSibling.firstChild.nextElementSibling.firstElementChild
				gantt_task_element.id = 'gantt-task-' + data.data.id
				start_element.value = data.data.start_date
				start_element.setAttribute('id','start-row' + data.data.id)
				start_element.setAttribute('onclick', 'test('+data.data.id+');')
				end_element.value = data.data.end_date
				end_element.setAttribute('id','end-row' + data.data.id)
				end_element.setAttribute('onclick', 'test('+data.data.id+');')
				taskKey_element.textContent = data.data.task_number
				taskName_element.textContent = data.data.title
				responsibleName_element.textContent = data.names.task_responsible_name
				statusName_element.textContent = data.names.task_status_name
				statusColorAutoPainting(statusName_element_textContent.textContent,statusName_element)
				document.querySelector('.gantt-task-body').append(refreshCloneLeftGanttChart)
				document.querySelector('.gantt-chart-body').append(refreshCloneRightGanttChart)
				closeTaskModal(0)
				document.querySelector('.gantt-all-task').scrollIntoView(false)
			} else {
				let Notice = document.querySelector('.project_task_notice_list')
				let Update = document.querySelector('.project_task_update_list')

				let cloneNotice = document.querySelector('.project_task_notice_list').cloneNode(true)
				let cloneUpdate = document.querySelector('.project_task_update_list').cloneNode(true)
				cloneNotice.firstElementChild.textContent = data.data.content
				cloneUpdate.firstElementChild.firstElementChild.textContent = '공지'
				cloneUpdate.firstElementChild.nextElementSibling.textContent = data.data.content

				let NoticeParent = Notice.parentElement
				let UpdateParent = Update.parentElement

				NoticeParent.firstChild.before(cloneNotice)
				UpdateParent.firstChild.before(cloneUpdate)

				closeTaskModal(0)
			}
		})
		.catch(err => {
			console.log(err.message)
		});

		function gantt_task_modal() {
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
		}
}

// 등록 버튼으로 작성/수정
function updateTask() {
	let updateData = {
		'title': document.querySelector('.insert_title').value,
		'content': document.querySelector('.insert_content').value,
		'task_status_id': document.querySelectorAll('#checked')[0].textContent,
		'task_responsible_id': document.querySelectorAll('.responsible_user')[0].textContent,
		'start_date': document.querySelectorAll('.start_date')[0].value,
		'end_date': document.querySelectorAll('.end_date')[0].value,
		'priority_id': document.querySelector('.insert_priority_val').textContent
	}
	fetch('/task/' + now_task_id, {
		method: 'PUT',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': csrfToken_insert_detail,
		},
		body: JSON.stringify(updateData),
	})
		.then(response => response.json())
		.then(data => {
			// console.log(data.data);
			closeTaskModal(0)
		})
		.catch(err => {
			console.log(err.message)
		});
}

// 더보기 모달 여닫기
function openMoreModal() {
	MORE_MODAL.style = 'display: flex;'
	document.addEventListener('click', function (event) {
		if (!MORE.contains(event.target)) {
			// 더보기 버튼 외 클릭 시
			if (!MORE_MODAL.contains(event.target)) {
				// 더보기 버튼 && 더보기 모달 외 클릭 시
				closeMoreModal();
			}
		}
	});
}
// 더보기 닫기
function closeMoreModal() {
	MORE_MODAL.style = 'display: none;'
}

// 업무상태 색삽입 모듈
function statusColorAutoPainting(switching, paintTo) {
	switch (switching) {
		case '시작전':
			paintTo.style = 'background-color: #B1B1B1;';
			break;
		case '진행중':
			paintTo.style = 'background-color: #04A5FF;';
			break;
		case '피드백':
			paintTo.style = 'background-color: #F34747;';
			break;
		case '완료':
			paintTo.style = 'background-color: #64C139;';
			break;
		default:
			paintTo.style = 'background-color: var(--m-btn);';
			break;
	}
}

// 업무상태 선택
function changeStatus(event) {
	// 체크인 애들 다 없애기
	for (let index = 0; index < STATUS_VALUE.length; index++) {
		STATUS_VALUE[index].removeAttribute('id');
		STATUS_VALUE[index].style = 'background-color: var(--m-btn);';
	}
	// 이벤트 발생지 선택 후 id추가
	var chk = event.target;
	chk.setAttribute('id', "checked")
	// 체크된 상태 갱신하여 받아오기
	const NOW_CHECKED = document.querySelector('#checked')
	// 색 삽입
	statusColorAutoPainting(NOW_CHECKED.textContent, NOW_CHECKED)
	// switch (NOW_CHECKED.textContent) {
	// 	case '시작전':
	// 		NOW_CHECKED.style = 'background-color: #B1B1B1;';
	// 		break;
	// 	case '진행중':
	// 		NOW_CHECKED.style = 'background-color: #04A5FF;';
	// 		break;
	// 	case '피드백':
	// 		NOW_CHECKED.style = 'background-color: #F34747;';
	// 		break;
	// 	case '완료':
	// 		NOW_CHECKED.style = 'background-color: #64C139;';
	// 		break;
	// 	default:
	// 		NOW_CHECKED.style = 'background-color: var(--m-btn);';
	// 		break;
	// }
}

// 담당자 추가
function addResponsible(a) {
	// 담당자 초기화
	while (ADD_RESPONSIBLE_MODAL.hasChildNodes()) {
		ADD_RESPONSIBLE_MODAL.removeChild(ADD_RESPONSIBLE_MODAL.firstChild);
	}
	ADD_RESPONSIBLE_MODAL.append(cloneResponsibleModal)

	fetch('/project/user/' + thisProjectId, {
		method: 'GET',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': csrfToken_insert_detail,
		},
	})
		.then(response => response.json())
		.then(data => {
			for (let index = 0; index < data.data.length; index++) {
				// 담당자 모달용 클론 (갱신)
				let responsibleModalClone = ADD_RESPONSIBLE_MODAL_ONE.cloneNode(true)
				// 클론->이름
				let defalutMemberName = responsibleModalClone.firstChild.nextSibling.nextElementSibling
				// respose받은 담당자 리스트 중 하나
				const element = data.data[index];
				// 담당자 이름 바꾸기
				defalutMemberName.textContent = element.member_name
				// d-none 해제
				responsibleModalClone.classList.remove('d-none')

				// console.log(defalutMemberName.textContent);

				// 현재 추가된/추가안된 담당자 모달에 수정된 클론을 추가
				let nowResponsibleModal = document.querySelector('.add_responsible_modal')
				nowResponsibleModal.append(responsibleModalClone)
				// console.log(element.member_name);
			}
		})
		.catch(err => {
			console.log(err.message);
		})

	ADD_RESPONSIBLE_MODAL.classList.remove('d-none')
	// RESPONSIBLE_ICON[a].after(cloneResponsible)
	// 담당자 모달, 담당자추가버튼 외 영역으로 끄기
	INSERT_MODAL.addEventListener('click', function (event) {
		if (!ADD_RESPONSIBLE_MODAL.contains(event.target) && !RESPONSIBLE_ADD_BTN[a].contains(event.target)) {
			ADD_RESPONSIBLE_MODAL.classList.add('d-none')
		}
	});
}

// 담당자 선택
function selectResponsible(event) {
	// 클릭한 엘리먼트의 값 가져오기
	let selectResponsibleValue = ''
	if (event.target.textContent) {
		selectResponsibleValue = event.target.textContent.trim()
	} else if (event.target.nextElementSibling.textContent) {
		selectResponsibleValue = event.target.nextElementSibling.textContent.trim()
	} else if (event.target.firstChild.nextElementSibling.textContent) {
		selectResponsibleValue = event.target.firstChild.nextElementSibling.textContent.trim()
	} else {
		console.log('cant select');
	}

	// 기존에 클론한 엘리먼트에 값을 넣기
	cloneResponsible.firstChild.nextElementSibling.nextElementSibling.textContent = selectResponsibleValue

	// 삽입할 태그 선택
	let nowFrontOfResponsible = document.querySelectorAll('.responsible_icon')[0]
	// console.log(nowFrontOfResponsible);

	// d-none 삭제
	cloneResponsible.classList.remove('d-none')

	// 태그에 넣기
	nowFrontOfResponsible.after(cloneResponsible)

	// 담당자 모달 닫기
	ADD_RESPONSIBLE_MODAL.classList.add('d-none')
}

// 담당자 삭제
function removeResponsible(a) {
	RESPONSIBLE_ICON[a].nextSibling.remove()
}

// 우선순위 추가/삭제
function addPriority(a) {
	// 우선순위 초기화
	while (ADD_PRIORITY_MODAL.hasChildNodes()) {
		ADD_PRIORITY_MODAL.removeChild(ADD_PRIORITY_MODAL.firstChild);
	}
	ADD_PRIORITY_MODAL.append(clonePriorityModal)
	// responsibleModalClone.remove()
	fetch('/basedata/' + 1, {
		method: 'GET',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': csrfToken_insert_detail,
		},
	})
		.then(response => response.json())
		.then(data => {
			for (let index = 0; index < data.data.length; index++) {
				// console.log(data.data[index].data_content_name);
				// 우선순위 모달용 클론 (갱신)
				let priorityModalClone = ADD_PRIORITY_MODAL_ONE.cloneNode(true)
				// 클론->아이콘
				let defalutPriorityIcon = priorityModalClone.firstChild.nextSibling
				// 클론->이름
				let defalutPriorityName = priorityModalClone.firstChild.nextSibling.nextSibling.nextSibling
				// // respose받은 우선순위 리스트 중 하나
				const element = data.data[index];

				// // 우선순위 이름 바꾸기
				defalutPriorityName.textContent = element.data_content_name

				// 우선순위 값별로 이미지 삽입
				switch (defalutPriorityName.textContent) {
					case '긴급':
						defalutPriorityIcon.style = 'background-image: url(/img/gantt-bisang.png);'
						break;
					case '높음':
						defalutPriorityIcon.style = 'background-image: url(/img/gantt-up.png);'
						break;
					case '보통':
						defalutPriorityIcon.style = 'background-image: url(/img/free-icon-long-horizontal-25426-nomal.png);'
						break;
					case '낮음':
						defalutPriorityIcon.style = 'background-image: url(/img/gantt-down.png);'
						break;
					default:
						defalutPriorityIcon.style = 'display: none;'
						break;
				}

				// d-none 해제
				priorityModalClone.classList.remove('d-none')

				// 현재 추가된/추가안된 우선순위 모달에 수정된 클론을 추가
				let nowPriorityModal = document.querySelector('.add_priority_modal')
				nowPriorityModal.prepend(priorityModalClone)
			}
		})
		.catch(err => {
			console.log(err.message);
		})

	ADD_PRIORITY_MODAL.classList.remove('d-none')
	// PRIORITY_ICON[a].after(clonePriority)
	// 우선순위 모달, 우선순위추가버튼 외 영역으로 끄기
	INSERT_MODAL.addEventListener('click', function (event) {
		if (!ADD_PRIORITY_MODAL.contains(event.target) && !PRIORITY_ADD_BTN[a].contains(event.target)) {
			ADD_PRIORITY_MODAL.classList.add('d-none')
		}
	});
}

// 우선순위 선택
function selectPriority(event) {
	// 클릭한 엘리먼트의 값 가져오기
	let selectPriorityValue = ''
	if (event.target.textContent) {
		selectPriorityValue = event.target.textContent.trim()
	} else if (event.target.nextElementSibling.textContent) {
		selectPriorityValue = event.target.nextElementSibling.textContent.trim()
	} else if (event.target.firstChild.nextElementSibling.textContent) {
		selectPriorityValue = event.target.firstChild.nextElementSibling.textContent.trim()
	} else {
		console.log('cant select');
	}

	// 기존에 클론한 엘리먼트에 값을 넣기
	clonePriority.firstChild.nextElementSibling.nextElementSibling.textContent = selectPriorityValue
	switch (selectPriorityValue) {
		case '긴급':
			clonePriority.firstChild.nextElementSibling.style = 'background-image: url(/img/gantt-bisang.png);'
			break;
		case '높음':
			clonePriority.firstChild.nextElementSibling.style = 'background-image: url(/img/gantt-up.png);'
			break;
		case '보통':
			clonePriority.firstChild.nextElementSibling.style = 'background-image: url(/img/free-icon-long-horizontal-25426-nomal.png);'
			break;
		case '낮음':
			clonePriority.firstChild.nextElementSibling.style = 'background-image: url(/img/gantt-down.png);'
			break;
		default:
			clonePriority.firstChild.nextElementSibling.style = 'display: none;'
			break;
	}

	// 삽입할 태그 선택
	let nowFrontOfPriority = document.querySelectorAll('.flag_icon')[0]
	// console.log(nowFrontOfPriority);

	// d-none 삭제
	clonePriority.classList.remove('d-none')

	// 태그에 넣기
	nowFrontOfPriority.after(clonePriority)

	// 담당자 모달 닫기
	ADD_PRIORITY_MODAL.classList.add('d-none')
}

// 우선순위 삭제
function removePriority(a) {
	PRIORITY_ICON[a].nextSibling.remove()
}

// 댓글 수정
function updateComment(event, a) {
	document.querySelectorAll('.submit')[1].setAttribute('onclick', 'commitUpdateComment()')
	let comment_input = document.querySelector('#comment_input')
	thisCommentId = event.target.parentElement.nextElementSibling.nextElementSibling.value
	thisCommentContent = event.target.parentElement.nextElementSibling
	comment_input.value = thisCommentContent.textContent
}

// 댓글 수정 적용 버튼
function commitUpdateComment() {
	let comment_input = document.querySelector('#comment_input')
	let putData = {
		"content": comment_input.value,
		"task_id": now_task_id
	}
	fetch('/comment/' + thisCommentId, {
		method: 'PUT',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': csrfToken_insert_detail,
		},
		body: JSON.stringify(putData),
	})
		.then(response => response.json())
		.then(data => {
			console.log(data);
			openTaskModal(1, TaskNoticeFlg, now_task_id)
		})
		.catch(err => {
			console.log(err.message);
		})
	SUBMIT[1].setAttribute('onclick', 'addComment()')
	INPUT_COMMENT_CONTENT.value = ''
}

// 댓글 삭제
function removeComment(event, a) {
	thisCommentId = event.target.parentElement.nextElementSibling.nextElementSibling
	fetch('/comment/' + thisCommentId.value, {
		method: 'DELETE',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': csrfToken_insert_detail,
		},
	})
		.then(response => response.json())
		.then(data => {
			// console.log(data);
			openTaskModal(1, TaskNoticeFlg, now_task_id)
		})
		.catch(err => {
			console.log(err.message);
		})
	// COMMENT_ONE[a].remove()
}

// 댓글 작성
function addComment() {
	// 댓글 추가용 클론 (갱신)
	let refresh_clone_comment = COMMENT_ONE[0].cloneNode(true)
	// 댓글 부모 (갱신)
	let refresh_comment_parent = document.querySelector('.comment')
	// 클론한 댓글 내용 선택
	const DEFAULT_COMMENT_CONTENT = refresh_clone_comment.firstElementChild.nextElementSibling.firstElementChild.nextElementSibling
	// 클론한 댓글 투명화 지우기
	refresh_clone_comment.removeAttribute('style')

	// 댓글 내용을 ajax로 송신
	let postData = {
		"task_id": now_task_id,
		"content": INPUT_COMMENT_CONTENT.value
	}
	fetch('/comment/' + now_task_id, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': csrfToken_insert_detail,
		},
		body: JSON.stringify(postData),
	})
		.then(response => response.json())
		.then(data => {
			// console.log(data);
			return openTaskModal(1, TaskNoticeFlg, now_task_id)
		})
		.then(() => {
			let comment_box = document.querySelector('.comment')
			comment_box.scrollIntoView(false)
		})
		.catch(err => {
			console.log(err.message);
		})

	// // 입력한 댓글 씌우기
	// DEFAULT_COMMENT_CONTENT.textContent = INPUT_COMMENT_CONTENT.value

	// // 댓글 달기
	// refresh_comment_parent.append(refresh_clone_comment)

	// // 삭제버튼 값 넣기
	// const RE_COMMENT_ONE = document.querySelectorAll('.comment_one')
	// const LAST_REMOVE_BTN = RE_COMMENT_ONE[RE_COMMENT_ONE.length - 1].firstElementChild.nextElementSibling.firstElementChild.firstElementChild.nextElementSibling
	// LAST_REMOVE_BTN.addEventListener('click', () => {
	// 	return RE_COMMENT_ONE[RE_COMMENT_ONE.length - 1].remove();
	// })
	// 입력창 초기화
	INPUT_COMMENT_CONTENT.value = ''
}

// 오픈모달 모듈------------------------------------------------------

// 값을 모달에 삽입
function insertModalValue(data, a) {
	// console.log(data);
	if (a === 1) { // 상세
		WRITER_NAME.textContent = data.task[0].wri_name;
		TASK_CREATED_AT.textContent = data.task[0].created_at;
		TASK_TITLE.textContent = data.task[0].title;
	} else { // 작성
		INSERT_TASK_TITLE.value = data.task[0].title;
	}
	PROJECT_NAME[a].textContent = data.task[0].project_title;
	// 프로젝트 색 띄우기
	PROJECT_COLOR[a].style = 'background-color: ' + data.task[0].project_color + ';'
	// 더보기에 쓸 id값 숨겨두기
	now_task_id = data.task[0].id
}

// 업무상태 값과 색상 주기
function statusColor(data) {
	DET_STATUS_VAL.textContent = data.task[0].status_name;
	statusColorAutoPainting(DET_STATUS_VAL.textContent, DET_STATUS_VAL)
	// switch (DET_STATUS_VAL.textContent) {
	// 	case '시작전':
	// 		DET_STATUS_VAL.style = 'background-color: #B1B1B1;';
	// 		break;
	// 	case '진행중':
	// 		DET_STATUS_VAL.style = 'background-color: #04A5FF;';
	// 		break;
	// 	case '피드백':
	// 		DET_STATUS_VAL.style = 'background-color: #F34747;';
	// 		break;
	// 	case '완료':
	// 		DET_STATUS_VAL.style = 'background-color: #64C139;';
	// 		break;
	// 	default:
	// 		DET_STATUS_VAL.style = 'background-color: var(--m-btn);';
	// 		break;
	// }
}

// 담당자 값체크, 삽입
function responsibleName(data, a) {
	if (data.task[0].res_name !== null) {
		RESPONSIBLE_USER[a].textContent = data.task[0].res_name;
		RESPONSIBLE[a].style = 'display: flex;'
		if (RESPONSIBLE_PERSON[a].classList.contains('d-none')) {
			RESPONSIBLE_PERSON[a].classList.remove('d-none')
		}
	} else {
		RESPONSIBLE[a].style = 'display: none;'
	}
}

// 마감일자 값체크, 삽입
function deadLineValue(data, a) {
	// console.log(data);
	//초기화
	START_DATE[a].placeholder = '시작일';
	END_DATE[a].placeholder = '마감일';
	START_DATE[a].value = null
	END_DATE[a].value = null
	//삽입
	if (data.task[0].start_date === null || data.task[0].end_date === null) {
		DEAD_LINE[a].classList.add('d-none')
	} else {
		START_DATE[a].placeholder = data.task[0].start_date;
		END_DATE[a].placeholder = data.task[0].end_date;
		START_DATE[a].value = data.task[0].start_date;
		END_DATE[a].value = data.task[0].end_date;
		DEAD_LINE[a].classList.add('d-none')
		if (DEAD_LINE[a].classList.contains('d-none')) {
			DEAD_LINE[a].classList.remove('d-none')
		}
	}
}

// 우선순위 값체크, 삽입
function priorityValue(data, a) {
	if (data.task[0].priority_name !== null) {
		PRIORITY_VAL[a].textContent = data.task[0].priority_name;
		PRIORITY[a].style = 'display: flex;'
		if (PRIORITY_ONE[a].classList.contains('d-none')) {
			PRIORITY_ONE[a].classList.remove('d-none')
		}
		// 우선순위 값별로 이미지 삽입
		switch (PRIORITY_VAL[a].textContent) {
			case '긴급':
				PRIORITY_ICON_VALUE[a].style = 'background-image: url(/img/gantt-bisang.png);'
				break;
			case '높음':
				PRIORITY_ICON_VALUE[a].style = 'background-image: url(/img/gantt-up.png);'
				break;
			case '보통':
				PRIORITY_ICON_VALUE[a].style = 'background-image: url(/img/free-icon-long-horizontal-25426-nomal.png);'
				break;
			case '낮음':
				PRIORITY_ICON_VALUE[a].style = 'background-image: url(/img/gantt-down.png);'
				break;
			default:
				PRIORITY_ICON_VALUE[a].style = 'display: none;'
				break;
		}
	} else {
		PRIORITY[a].style = 'display: none;'
	}
}

// 상세업무 내용 값체크, 삽입
function modalContentValue(data, a) {
	// console.log(data);
	if (a === 1) {
		if (data.task[0].content === null) {
			DETAIL_CONTENT.textContent = '';
		} else {
			DETAIL_CONTENT.textContent = data.task[0].content;
		}
	} else {
		INSERT_CONTENT.value = data.task[0].content;
	}
}

// 댓글 컨트롤
function commentControl(data) {
	// 댓글창 없을 때 사라질 값 갱신선언
	COMMENT_PARENT.style = 'padding: 20;'

	// 댓글창 갱신
	COMMENT_PARENT.removeChildren
	while (COMMENT_PARENT.hasChildNodes()) {
		COMMENT_PARENT.removeChild(COMMENT_PARENT.firstChild);
	} // 다 지우고 달아도 처음에 기본 댓글을 들고있기 때문에 추가하는데 상관 없나보다

	// 댓글 달아주기
	if (data.comment.length) {
		for (let i = 0; i < data.comment.length; i++) {
			// 댓글 추가용 클론 (갱신)
			let refresh_clone_comment = COMMENT_ONE[0].cloneNode(true)
			// 댓글 부모 (갱신)
			let refresh_comment_parent = document.querySelector('.comment')
			// 클론한 댓글 내용 선택
			const DEFAULT_COMMENT_CONTENT = refresh_clone_comment.firstElementChild.nextElementSibling.firstElementChild.nextElementSibling
			// 클론한 댓글 이름 선택
			const DEFAULT_COMMENT_NAME = refresh_clone_comment.firstElementChild.nextElementSibling.firstElementChild.firstElementChild.firstElementChild
			// 클론한 댓글 id값 선택
			const DEFAULT_COMMENT_ID = refresh_clone_comment.firstElementChild.nextElementSibling.firstElementChild.nextElementSibling.nextElementSibling
			// 클론한 댓글 투명화 지우기
			refresh_clone_comment.removeAttribute('style')
			// 댓글에 값 씌우기
			DEFAULT_COMMENT_CONTENT.textContent = data.comment[i].content
			DEFAULT_COMMENT_NAME.textContent = data.comment[i].user_name
			DEFAULT_COMMENT_ID.value = data.comment[i].id

			// 댓글 달기
			refresh_comment_parent.append(refresh_clone_comment)

			// // 삭제버튼 값 넣기
			// const RE_COMMENT_ONE = document.querySelectorAll('.comment_one') // 변경한 댓글들을 재확인
			// const LAST_REMOVE_BTN = RE_COMMENT_ONE[RE_COMMENT_ONE.length - 1].firstElementChild.nextElementSibling.firstElementChild.firstElementChild.nextElementSibling
			// LAST_REMOVE_BTN.addEventListener('click', () => {
			// 	return RE_COMMENT_ONE[RE_COMMENT_ONE.length - 1].remove();
			// })
		}
	}

	// 댓글 없으면 댓글창 없애기
	if (!COMMENT_PARENT.hasChildNodes()) {
		COMMENT_PARENT.style = 'padding: 0;'
	}
}

// 상위업무 컨트롤
function parentTaskControl(data, a) {
	// console.log(data);
	// 상위업무 초기화
	OVERHEADER[a].style = 'display: none;'
	OVERHEADER_PARENT[a].style = 'display: none;'
	// OVERHEADER_GRAND_PARENT[a].style = 'display: none;'

	// 상위업무 있는지 체크
	if (Object.keys(data).includes('parents')) {
		// 상위업무 달아주기
		OVERHEADER[a].style = 'display: block;'
		// 상위업무 개수 체크
		if (data.parents.length !== 0) {
			// 상위업무 달아주기
			OVERHEADER_PARENT[a].textContent = ' > ' + data.parents[0].title
			OVERHEADER_PARENT[a].style = 'display: inline-block;'
			// if (data.parents.length !== 1) {
			// 	// 상위업무 달아주기
			// 	OVERHEADER_PARENT[a].textContent += ' > ' + data.parents[1].title
			// 	// OVERHEADER_GRAND_PARENT[a].style = 'display: inline-block;'
			// }
		}
	}
}

// 오픈모달 모듈 이후 코드-----------------------------------------

// 모달 띄우기
function openInsertDetailModal(a) {
	if (createUpdate === 1) {
		SUBMIT[0].setAttribute('onclick', 'updateTask()')
	} else {
		SUBMIT[0].setAttribute('onclick', 'createTask()')
	}

	TASK_MODAL[a].style = 'display: block;'
	if (a === 0) {
		BEHIND_MODAL.style = 'display: block;'
		TASK_MODAL[1].style = 'display: none;'
	} else {
		BEHIND_MODAL.style = 'display: none;'
		TASK_MODAL[0].style = 'display: none;'
	}
}
// 공지/업무 플래그 : 공지면 업무속성 미출력
function TaskFlg(a, b) {
	if (b === 1) {
		BOARD_TYPE[a * 2].classList.add('d-none');
		BOARD_TYPE[(a * 2) + 1].classList.add('d-none');
	} else {
		BOARD_TYPE[a * 2].classList.remove('d-none');
		BOARD_TYPE[(a * 2) + 1].classList.remove('d-none');
	}
}
// 수정 모달 값 넣기
function updateModalOpen() {
	createUpdate = 1
	fetch('/task/' + now_task_id, { // // insertModalValue() 모달창 띄울때 담았던 변수
		method: 'GET',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': csrfToken_insert_detail,
		},
	})
		.then(response => response.json())
		.then(data => {
			// console.log(data);
			// 값을 모달에 삽입
			insertModalValue(data, 0);

			// 업무상태 값과 색상 주기
			updateStatusColor(data);

			// 담당자 값체크, 삽입
			updateResponsibleName(data, 0);

			// 마감일자 값체크, 삽입
			deadLineValue(data, 0);

			// 우선순위 값체크, 삽입
			updatePriorityValue(data, 0);

			// 상세업무 내용 값체크, 삽입
			modalContentValue(data, 0);

			// // 댓글창 없을 때 사라질 값 갱신선언
			// COMMENT_PARENT.style = 'padding: 20;'

			// // 댓글 컨트롤
			// commentControl(data);

			// 상위업무 컨트롤
			parentTaskControl(data, 0);
		})
		.catch(err => {
			console.log(err.message);
		})

	PROPERTY_VAL = document.querySelectorAll('.property')[1].classList
	if (PROPERTY_VAL.contains('d-none')) {
		// 모달 띄우기
		openInsertDetailModal(0);

		// 글/업무 플래그
		TaskFlg(0, 1);
	} else {
		// 모달 띄우기
		openInsertDetailModal(0);

		// 글/업무 플래그
		TaskFlg(0, 0);
	}
}

// 모달 삭제
function deleteTask() {
	axios.delete('/task/' + now_task_id)
		.then(res => {
			console.log(res);
			
			// console.log(res.data.data);
			document.querySelector('#gantt-task-'+res.data.data).remove()
			document.querySelector('#gantt-chart-'+res.data.data).remove()

			closeTaskModal(1)
		})
		.catch(err => {
			console.log(err.message);
		})
}

function updateStatusColor(data) {
	// console.log(data);
	let status_val = document.querySelectorAll('.status_val')
	let element_for_painting = null;
	for (let index = 0; index < status_val.length; index++) {
		const element = status_val[index];
		element.style = 'background-color: var(--m-btn);'
		if (element.textContent == data.task[0].status_name) {
			element_for_painting = status_val[index]
			element_for_painting.id = 'checked'
		}
	}
	statusColorAutoPainting(data.task[0].status_name, element_for_painting)
	// switch (data.task[0].status_name) {
	// 	case '시작전':
	// 		element_for_painting.style = 'background-color: #B1B1B1;';
	// 		break;
	// 	case '진행중':
	// 		element_for_painting.style = 'background-color: #04A5FF;';
	// 		break;
	// 	case '피드백':
	// 		element_for_painting.style = 'background-color: #F34747;';
	// 		break;
	// 	case '완료':
	// 		element_for_painting.style = 'background-color: #64C139;';
	// 		break;
	// 	default:
	// 		element_for_painting.style = 'background-color: var(--m-btn);';
	// 		break;
	// }
}

function updateResponsibleName(data, a) {
	// console.log(data);
	// 기존에 클론한 엘리먼트에 값을 넣기
	if (data.task[0].res_name) {
		cloneResponsible.firstChild.nextElementSibling.nextElementSibling.textContent = data.task[0].res_name
	}

	// 삽입할 태그 선택
	let nowFrontOfResponsible = document.querySelectorAll('.responsible_icon')[0]
	// console.log(nowFrontOfResponsible);

	// d-none 삭제
	cloneResponsible.classList.remove('d-none')

	// 투명화 되어있는 기본 담당자 삭제
	RESPONSIBLE_PERSON[0].remove()

	// 태그에 넣기
	nowFrontOfResponsible.after(cloneResponsible)
}

function updatePriorityValue(data, a) {
	// console.log(data);
	// 기존에 클론한 엘리먼트에 값을 넣기
	if (data.task[0].priority_name) {
		clonePriority.firstChild.nextElementSibling.nextElementSibling.textContent = data.task[0].priority_name
	}

	// 삽입할 태그 선택
	let nowFrontOfPriority = document.querySelectorAll('.flag_icon')[0]
	// console.log(nowFrontOfResponsible);

	// 태그에 넣기
	nowFrontOfPriority.after(clonePriority)

	// 우선순위 값별로 이미지 삽입
	// 갱신된 우선순위 가져오기
	let insert_priority_val = document.querySelectorAll('.insert_priority_val')
	let insert_priority_icon = document.querySelectorAll('.insert_priority_icon')
	for (let index = 0; index < insert_priority_val.length; index++) {
		const element = insert_priority_val[index];
		// console.log(element.textContent !== null);
		// console.log(data.task[0].priority_name);
		if (element.textContent !== null) {
			switch (data.task[0].priority_name) {
				case '긴급':
					insert_priority_icon[index].style = 'background-image: url(/img/gantt-bisang.png);'
					break;
				case '높음':
					insert_priority_icon[index].style = 'background-image: url(/img/gantt-up.png);'
					break;
				case '보통':
					insert_priority_icon[index].style = 'background-image: url(/img/free-icon-long-horizontal-25426-nomal.png);'
					break;
				case '낮음':
					insert_priority_icon[index].style = 'background-image: url(/img/gantt-down.png);'
					break;
				default:
					insert_priority_icon[index].style = 'display: none;'
					break;
			}
		}
	}

	// 투명화 되어있는 기본 우선순위 삭제
	PRIORITY_ONE[0].remove()

	// d-none 삭제
	clonePriority.classList.remove('d-none')
}