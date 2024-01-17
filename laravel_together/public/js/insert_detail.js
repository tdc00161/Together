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
let cloneResponsibleModal = ADD_RESPONSIBLE_MODAL_ONE ? ADD_RESPONSIBLE_MODAL_ONE.cloneNode(true) : ''
// 담당자 초기화용 클론
let cloneResponsibleReset = RESPONSIBLE[0] ? RESPONSIBLE[0].cloneNode(true) : ''
// 담당자 추가용 클론
let cloneResponsible = RESPONSIBLE_PERSON[0] ? RESPONSIBLE_PERSON[0].cloneNode(true) : ''
// 댓글 초기화용 클론
let cloneResetComments = COMMENT_PARENT ? COMMENT_PARENT.cloneNode(true) : ''
// 좌측 간트 초기화용 클론
let cloneLeftGanttChart = GANTT_LEFT[0] ? GANTT_LEFT[0].cloneNode(true) : ''
// 우측 간트 초기화용 클론
let cloneRightGanttChart = GANTT_RIGHT[0] ? GANTT_RIGHT[0].cloneNode(true) : ''
// 공지 초기 클론
let firstCloneNotice = document.querySelector('.project_task_notice_list') ? document.querySelector('.project_task_notice_list') : ''
let firstCloneUpdate = document.querySelector('.project_task_update_list') ? document.querySelector('.project_task_update_list') : ''
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

	// 작성/수정 플래그별 등록버튼 기능
	if (createUpdate === 1) {
		SUBMIT[0].setAttribute('onclick', 'updateTask()')
	} else {
		SUBMIT[0].setAttribute('onclick', 'createTask()')
	}

	// 작성 모달 띄우기
	if (a === 0) {
		createUpdate = 0
		// 작성 전 초기화
		document.querySelector('.insert_title').value = ''
		document.querySelector('.insert_content').value = ''
		document.querySelectorAll('.status_val')[0].id = 'checked'
		// 담당자가 있으면 지우기
		if (document.querySelectorAll('.insert_responsible_one').length > 0) { // ? !document.querySelectorAll('.insert_responsible_one')[0].classList.contains('d-none') : false
			RESPONSIBLE[0].removeChild(document.querySelectorAll('.insert_responsible_one')[0])
		} // 작성되어있는 첫번째 담당자 삭제
		START_DATE[0].value = ''
		START_DATE[0].placeholder = '시작일'
		END_DATE[0].value = ''
		END_DATE[0].placeholder = '마감일'
		DEAD_LINE[0].classList.remove('d-none')


		// 프로젝트 색 가져오기
		fetch('/project/' + thisProjectId, {
			method: 'GET',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': csrfToken_insert_detail,
			},
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

	// 상세 모달 띄우기
	if (a === 1) {
		if (document.querySelector('.insert_modal').style.display != 'none') {
			if (confirm("변경사항이 저장되지 않을 수 있습니다.") == true) {    //확인
				// alert('확인')
				closeTaskModal(0)
			} else {   //취소
				// alert('취소')
				return false
			}
		}

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
				// console.log(data);
				// 값을 모달에 삽입
				insertModalValue(data, a);

				// 업무상태 값과 색상 주기
				statusColor(data);

				// 담당자 값체크, 삽입
				responsibleName(data, a);

				// 마감일자 값체크, 삽입
				deadLineValue(data, a);

				// // 우선순위 값체크, 삽입
				// priorityValue(data, a);

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

		//모달창 권한에 따른 삭제 표시여부
		fetch('/modal-auth/' + c, {
			method: 'GET',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': csrfToken_insert_detail,
			},
		})
			.then(response => response.json())
			.then(data => {
				// console.log(data);
				if (data.authority_id === "1" || data.task_writer_id != data.user) {
					document.querySelector('#modaldelete').style.display = 'none';
				}
			})
			.catch(err => {
				console.log(err.message);
			})

		// 모달 띄우기
		openInsertDetailModal(a);


	}
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

// 간트 좌측 추가
function addGanttLeft(data) {
	// 새로운 div 요소 생성
	var newDiv = document.createElement('div');
	newDiv.className = 'gantt-task';
	newDiv.id = 'gantt-task-' + data.data.id;

	// gantt-editable-div 생성
	var editableDiv = document.createElement('div');
	editableDiv.className = 'gantt-editable-div editable';

	// task-top-icon 생성
	var topIconDiv = document.createElement('div');
	topIconDiv.className = 'task-top-icon';

	var toggleButton = document.createElement('button');
	toggleButton.onclick = function () {
		toggleChildTask(data.data.id); // 함수 호출을 적절한 형태로 수정
	};
	toggleButton.id = 'toptaskbtn' + data.data.id;

	var iconImage = document.createElement('img');
	iconImage.className = 'task-top-icon-img';
	iconImage.src = ''; // 이미지 경로를 설정해야 합니다.

	toggleButton.appendChild(iconImage);
	topIconDiv.appendChild(toggleButton);

	// taskKey, taskChildPosition, taskName 생성
	var taskKeyDiv = document.createElement('div');
	taskKeyDiv.className = 'taskKey';
	taskKeyDiv.textContent = data.data.task_number;

	var taskChildPositionDiv = document.createElement('div');
	taskChildPositionDiv.className = 'taskChildPosition';
	taskChildPositionDiv.style.display = 'none';
	taskChildPositionDiv.textContent = data.data.task_number;

	var taskNameDiv = document.createElement('div');
	taskNameDiv.className = 'taskName editable-title';
	taskNameDiv.setAttribute('spellcheck', 'false');
	taskNameDiv.setAttribute('contenteditable', 'true');
	taskNameDiv.textContent = data.data.title;
	taskNameDiv.addEventListener('blur', () => {
		updatedValue = {
			'title': '',
		}
		updatedValue.title = taskNameDiv.textContent;
		numbersOnly = data.data.id
		// 수정 요청 보내기
		console.log('수정 신청');
		sendUpdateRequest(updatedValue, numbersOnly);

		// 수정 완료 팝업 메시지 표시
		// showPopupMessage('수정 완료!');
	});

	// editableDiv에 위에서 생성한 요소들 추가
	editableDiv.appendChild(topIconDiv);
	editableDiv.appendChild(taskKeyDiv);
	editableDiv.appendChild(taskChildPositionDiv);
	editableDiv.appendChild(taskNameDiv);

	// task-flex 생성
	var taskFlexDiv = document.createElement('div');
	taskFlexDiv.className = 'task-flex';

	// responName 생성
	var responNameDiv = document.createElement('div');
	responNameDiv.className = 'responName';
	responNameDiv.classList.add('test');

	var responNameSpan = document.createElement('span');
	responNameSpan.className = 'respon-name-span';
	responNameSpan.id = 'responNameSpan';
	responNameSpan.textContent = data.names.task_responsible_name;

	var addResponsibleGanttDiv = document.createElement('div');
	addResponsibleGanttDiv.className = 'add_responsible_gantt d-none';

	responNameDiv.appendChild(responNameSpan);
	responNameDiv.appendChild(addResponsibleGanttDiv);

	// 담당자 모달 껐다켰다
	// console.log('담당자 모달 키기');
	responNameDiv.addEventListener('click', () => {
		// console.log(1);

		// 한 번 클릭 후 다시 클릭 시 창 닫기
		if (addResponsibleGanttDiv.classList.contains('d-none')) {
			addResponsibleGanttDiv.classList.remove('d-none');
		} else {
			addResponsibleGanttDiv.classList.add('d-none');
		}
		console.log(addResponsibleGanttDiv.classList);

		// 다른 담당자 눌렀을 때 하나만 창 뜨게하기		
		let responName = document.querySelectorAll('.responName')
		responName.forEach((RNone, RNi) => {
			let addResponsibleGantt = document.querySelectorAll('.add_responsible_gantt')
			// 내가 뜰 때 다른 담당자 끄기 -> 내가 아닌 add_responsible_gantt일 때
			addResponsibleGantt[RNi] !== addResponsibleGanttDiv ? addResponsibleGantt[RNi].classList.add('d-none') : '';
			RNone.addEventListener('click', () => {
				addResponsibleGanttDiv.classList.add('d-none');
			})
		})

		// // 담당자 칸 이외 영역 클릭 시 창 닫기
		document.addEventListener('click', function (event) {
			if (!event.target.closest('.gantt-task')) {
				addResponsibleGanttDiv.classList.add('d-none');
			}
		});

		// 담당자 초기화
		while (addResponsibleGanttDiv.hasChildNodes()) {
			addResponsibleGanttDiv.removeChild(addResponsibleGanttDiv.firstChild);
		}
		addResponsibleGanttDiv.append(ganttCloneResponsibleModal)

		// 담당자 리스트 확인용 통신
		fetch('/project/user/' + ganttThisProjectId, {
			method: 'GET',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': csrfToken_gantt,
			},
		})
			.then(response => response.json())
			.then(memData => {
				// console.log(data.data);
				let ganttTask = document.querySelectorAll('.gantt-task')
				// console.log(ganttTask.id.match(/\d+/)[0]);
				for (let index2 = 0; index2 < memData.data.length; index2++) {

					// div 엘리먼트 생성
					let newDiv = document.createElement('div');
					newDiv.className = 'add_responsible_gantt_one';
					let taskNum = data.data.task_number;
					newDiv.classList.add('responsible-one-' + taskNum);

					// // 아이콘 엘리먼트 생성
					// let iconDiv = document.createElement("div");
					// iconDiv.className = "add_responsible_gantt_one_icon";

					// 이름 엘리먼트 생성
					let nameDiv = document.createElement('div');
					nameDiv.className = 'add_responsible_gantt_one_name';
					nameDiv.textContent = memData.data[index2].member_name; // 데이터에서 가져온 이름 속성 사용

					// 이름 엘리먼트를 div에 추가
					// newDiv.appendChild(iconDiv);
					newDiv.appendChild(nameDiv);

					// 담당자 리스트 클릭하면 적용
					newDiv.addEventListener('click', function (e) {
						let resOne = e.target.textContent;
						updatedValue = {
							'task_responsible_id': '',
						}
						updatedValue.task_responsible_id = resOne;
						console.log(resOne);
						numbersOnly = data.data.id
						// 수정 요청 보내기
						console.log('수정 신청');
						sendUpdateRequest(updatedValue, numbersOnly);

						// 수정 완료 팝업 메시지 표시
						// showPopupMessage('수정 완료!');
					});

					addResponsibleGanttDiv.appendChild(newDiv);
					// addResponsibleGanttDiv.classList.remove('d-none');

					newDiv.addEventListener('click', () => {
						// console.log('원래자리', responNameSpan.textContent);
						// console.log('바꿀값:', memData.data[index2].member_name);
						responNameSpan.textContent = memData.data[index2].member_name;

						// 드롭박스 안 담당자 클릭 시 창 닫기
						addResponsibleGanttDiv.classList.add('d-none');
					})
				}
			})
			.catch(err => {
				console.log(err.stack);
			})
	});

	// gantt-status-name 생성
	var ganttStatusNameDiv = document.createElement('div');
	ganttStatusNameDiv.className = 'gantt-status-name';

	var statusNameDiv = document.createElement('div');
	statusNameDiv.className = 'statusName gantt-status-color';
	statusNameDiv.dataset.status = data.names.task_status_name;
	statusColorAutoPainting(data.names.task_status_name, statusNameDiv)

	var statusNameSpan = document.createElement('span');
	statusNameSpan.className = 'status-name-span';
	statusNameSpan.id = 'statusNameSpan';
	statusNameSpan.textContent = data.names.task_status_name;

	var addStatusGanttDiv = document.createElement('div');
	addStatusGanttDiv.className = 'add_status_gantt d-none';

	statusNameDiv.appendChild(statusNameSpan);
	ganttStatusNameDiv.appendChild(statusNameDiv);
	ganttStatusNameDiv.appendChild(addStatusGanttDiv);

	// 상태 모달 껐다 켰다
	ganttStatusNameDiv.addEventListener('click', (e) => {
		// 한 번 클릭 후 다시 클릭 시 창 닫기
		if (addStatusGanttDiv.classList.contains('d-none')) {
			addStatusGanttDiv.classList.remove('d-none');
		} else {
			addStatusGanttDiv.classList.add('d-none');
		}

		// 다른 담당자 눌렀을 때 하나만 창 뜨게하기		
		let statusName = document.querySelectorAll('.statusName');
		statusName.forEach((SNone, SNi) => {
			let addStatusGantt = document.querySelectorAll('.add_status_gantt')
			// 내가 뜰 때 다른 담당자 끄기 -> 내가 아닌 add_responsible_gantt일 때
			addStatusGantt[SNi] !== addStatusGanttDiv ? addStatusGantt[SNi].classList.add('d-none') : '';
			SNone.addEventListener('click', () => {
				addStatusGanttDiv.classList.add('d-none');
			})
		})

		// 담당자 칸 이외 영역 클릭 시 창 닫기
		document.addEventListener('click', function (event) {
			if (!event.target.closest('.gantt-task')) {
				addStatusGanttDiv.classList.add('d-none');
			}
		});

		// 상태값 초기화
		while (addStatusGanttDiv.hasChildNodes()) {
			addStatusGanttDiv.removeChild(addStatusGanttDiv.firstChild);
		}
		addStatusGanttDiv.append(ganttCloneStatusModal)

		// 업무상태 리스트 확인용 통신
		fetch('/basedata/' + 0, {
			method: 'GET',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': csrfToken_gantt,
			},

		})
			.then(response => response.json())
			.then(staData => {
				// console.log(data.data);

				let ganttTask = document.querySelectorAll('.gantt-task');
				let statusBackColor = ['#B1B1B1', '#04A5FF', '#F34747', '#64C139'];
				// console.log(ganttTask[index].id.match(/\d+/)[0]);
				for (let index2 = 0; index2 < staData.data.length; index2++) {
					// div 엘리먼트 생성
					let taskNum = data.data.id;

					let newDiv = document.createElement('div');
					newDiv.classList.add('add_status_gantt_one');
					newDiv.classList.add('status-one-' + taskNum);

					// 배경색 적용
					newDiv.style.backgroundColor = statusBackColor[index2];
					newDiv.style.borderRadius = '15px';
					// console.log(newDiv);
					let nameDiv = document.createElement('div');
					nameDiv.className = 'add_status_gantt_one_name';
					nameDiv.textContent = staData.data[index2].data_content_name;

					newDiv.appendChild(nameDiv);

					// 모달 안 내역 클릭
					newDiv.addEventListener('click', (e) => {
						let staOne = e.target.textContent;
						console.log(e.target.textContent);
						updatedValue = {
							'task_status_id': '',
						}
						updatedValue.task_status_id = staOne;
						numbersOnly = data.data.id;
						// 수정 요청 보내기
						console.log('수정 신청');
						sendUpdateRequest(updatedValue, numbersOnly);

						// 수정 완료 팝업 메시지 표시
						// showPopupMessage('수정 완료!');
					})

					addStatusGanttDiv.appendChild(newDiv);

					newDiv.addEventListener('click', () => {

						// 상태값 클릭 시 배경 바꾸기
						statusNameDiv.style.backgroundColor = statusBackColor[index2];
						// 상태값 클릭 시 글자 바꾸기
						statusNameSpan.textContent = staData.data[index2].data_content_name;

						// 드롭박스 안 상태값 클릭 시 창 닫기
						addStatusGanttDiv.classList.add('d-none');
					})
				}
			})
	});

	// gantt-task-4, gantt-task-5 생성
	var ganttTask4Div = document.createElement('div');
	ganttTask4Div.className = 'gantt-task-4';

	var startDateInput = document.createElement('input');
	startDateInput.type = 'date';
	startDateInput.className = 'start-date';
	startDateInput.name = 'start';
	startDateInput.id = 'start-row' + data.data.id;
	startDateInput.onchange = function () {
		test(data.data.id); // 함수 호출을 적절한 형태로 수정
	};
	startDateInput.value = data.data.start_date;

	ganttTask4Div.appendChild(startDateInput);

	var ganttTask5Div = document.createElement('div');
	ganttTask5Div.className = 'gantt-task-5';

	var endDateInput = document.createElement('input');
	endDateInput.type = 'date';
	endDateInput.className = 'end-date';
	endDateInput.name = 'end';
	endDateInput.id = 'end-row' + data.data.id;
	endDateInput.onchange = function () {
		test(data.data.id); // 함수 호출을 적절한 형태로 수정
	};
	endDateInput.value = data.data.end_date;

	ganttTask5Div.appendChild(endDateInput);

	// gantt-more-btn 생성
	var ganttMoreBtnDiv = document.createElement('div');
	ganttMoreBtnDiv.className = 'gantt-more-btn';

	var ganttTaskDetailClickBtn = document.createElement('button');
	ganttTaskDetailClickBtn.className = 'gantt-task-detail-click';

	var ganttTaskDetailClickSpan = document.createElement('span');
	ganttTaskDetailClickSpan.className = 'gantt-task-detail-click-span';
	ganttTaskDetailClickSpan.textContent = '…';

	ganttTaskDetailClickBtn.appendChild(ganttTaskDetailClickSpan);

	var ganttDetailDiv = document.createElement('div');
	ganttDetailDiv.className = 'gantt-detail';
	ganttDetailDiv.style.display = 'none';

	var ganttDetailBtn1 = document.createElement('button');
	ganttDetailBtn1.className = 'gantt-detail-btn';
	ganttDetailBtn1.onclick = function () {
		openTaskModal(1, 0, data.data.id); // 함수 호출을 적절한 형태로 수정
	};
	ganttDetailBtn1.textContent = '자세히보기';

	var ganttDetailBtn2 = document.createElement('button');
	ganttDetailBtn2.className = 'gantt-detail-btn';
	ganttDetailBtn2.onclick = function (event) {
		addSubTask(event, data.data.id); // 함수 호출을 적절한 형태로 수정
	};
	ganttDetailBtn2.textContent = '하위업무 추가';

	ganttDetailDiv.appendChild(ganttDetailBtn1);
	ganttDetailDiv.appendChild(document.createElement('br'));
	ganttDetailDiv.appendChild(ganttDetailBtn2);

	ganttMoreBtnDiv.appendChild(ganttTaskDetailClickBtn);
	ganttMoreBtnDiv.appendChild(ganttDetailDiv);

	// 여러 개 클릭했을 때 하나만 뜨게 하기
	ganttMoreBtnDiv.addEventListener('click', function (event) {
		// 한 번 클릭 후 다시 클릭 시 창 닫기
		if (ganttDetailDiv.style.display === 'none') {
			ganttDetailDiv.style.display = 'block';
		} else {
			ganttDetailDiv.style.display = 'none';
		}

		// 내가 켜질 때 다른 애들 다 끄기
		let ganttDetail = document.querySelectorAll('.gantt-detail');
		let ganttMoreBtn = document.querySelectorAll('.gantt-more-btn');
		ganttDetail.forEach((GDone, GDi) => {
			ganttMoreBtnDiv !== ganttMoreBtn[GDi] ? GDone.style.display = 'none' : '';
		});

		// 바깥 영역 클릭했을 때 창 닫기
		document.addEventListener('click', function (event) {
			if (!ganttMoreBtnDiv.contains(event.target)) {
				ganttDetailDiv.style.display = 'none';
			}
		});
	});

	// taskFlexDiv에 위에서 생성한 나머지 요소들 추가
	taskFlexDiv.appendChild(responNameDiv);
	taskFlexDiv.appendChild(ganttStatusNameDiv);
	taskFlexDiv.appendChild(ganttTask4Div);
	taskFlexDiv.appendChild(ganttTask5Div);
	taskFlexDiv.appendChild(ganttMoreBtnDiv);

	// newDiv에 editableDiv 및 taskFlexDiv 추가
	newDiv.appendChild(editableDiv);
	newDiv.appendChild(taskFlexDiv);

	return newDiv;
}

// 우 간트 함수
function createGanttChart(data) {
	// Get the container element
	var container = document.createElement('div');
	container.className = 'gantt-chart';
	container.id = 'gantt-chart-' + data.data.id;

	// Loop through the date rows and create elements
	let ganttHeaderScroll = document.querySelector('.gantt-header-scroll');
	let dates = Array.from(ganttHeaderScroll.children)
	dates.forEach((GHSone, GHSi) => {
		var rowId = 'row' + data.data.id + '-' + GHSone.textContent;

		// Create a div element
		var divElement = document.createElement('div');
		divElement.id = rowId;

		let currentDate = new Date('2024/' + GHSone.textContent);
		let start = new Date(data.data.start_date);
		let end = new Date(data.data.end_date);

		var rowId = 'row' + data.data.id + '-' + '2024' + GHSone.textContent.replace('/', '');
		var divElement = document.createElement('div');
		divElement.id = rowId;

		if (currentDate >= start && currentDate <= end) {
			divElement.innerHTML = '<div class="bk-row" data-row-num="' + data.data.id + '"></div>';
			if (currentDate === start) {
				divElement.innerHTML = '<div class="bk-row" data-row-num="' + data.data.id + '"><span class="dates start">' + currentDate + '</span></div>';
			}
			if (currentDate === end) {
				divElement.innerHTML = '<div class="bk-row" data-row-num="' + data.data.id + '"><span class="dates end">' + currentDate + '</span></div>';
			}
		}

		// Append the created div element to the container
		container.appendChild(divElement);
	})

	return container;
}

// 간트부분수정 모듈
function sendUpdateRequest(updatedValue, numbersOnly) {
	// Axios를 사용하여 수정 요청을 보내는 로직
	// 여기에 실제 서버 엔드포인트 및 요청 설정을 작성해야 합니다.
	// 아래는 가상의 코드입니다.
	let url = '/ganttchartRequest/' + numbersOnly
	// console.log(url);
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

// 모달 작성/수정 제목 칸 클릭 시 스타일 주기
document.addEventListener('click', (event) => {
	let insertTitle = document.querySelector('.insert_title')
	let clickInsertTitle = event.target;

	if (clickInsertTitle.classList.contains('insert_title')) {
		insertTitle.style.border = '2px solid #ffffff2f';
		insertTitle.style.borderRadius = '5px';
	} else {
		insertTitle.style.border = '';
		insertTitle.style.borderRadius = '';
	}
})


// 모달 작성
function createTask() {

	let modalCloseBtn = document.querySelector('.cross_icon_w');
	let insertErrorMsg = document.querySelector('.insert_error_msg');
	let insertTitle = document.querySelector('.insert_title').value;
	let insertContent = document.querySelector('.insert_content').value;
	let insertTitleMax = 100;
	let insertContentMax = 500;

	if (insertTitle === '') {
		showError('제목을 입력해 주세요.');
	} else if (insertTitle.length > insertTitleMax && insertContent.length > insertContentMax) {
		showError('제목과 내용 글자 수를 모두 초과했습니다.');
	} else if (insertTitle.length > insertTitleMax) {
		showError('제목 글자 수를 초과했습니다.');
	} else if (insertContent.length > insertContentMax) {
		showError('내용 글자 수를 초과했습니다.');
	} else {
		hideError();
	}
	
	// 닫기 버튼 누르면 에러메세지 제거
	modalCloseBtn.addEventListener('click', () => {
		hideError();
	});

	function showError(message) {
		insertErrorMsg.classList.remove('d-none');
		insertErrorMsg.textContent = message;
	}

	function hideError() {
		insertErrorMsg.classList.add('d-none');
	}

	let postData = {
		"title": INSERT_TITLE.value,
		"content": INSERT_CONTENT.value,
		"project_id": thisProjectId,
		"category_id": document.querySelectorAll('.property')[0].classList.contains('d-none') ? 1 : 0
	}
	// console.log(postData);
	if (TaskNoticeFlg === 0) {
		postData.task_status_id = document.querySelectorAll('#checked')[0].textContent
		postData.task_status_name = ''
		postData.task_responsible_id = document.querySelectorAll('.responsible_user')[0].textContent
		postData.task_responsible_name = ''
		postData.start_date = document.querySelectorAll('.start_date')[0].value
		postData.end_date = document.querySelectorAll('.end_date')[0].value
	}
	// console.log(postData);
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
			// console.log(data);
			let ganttSearch = document.querySelectorAll('.gantt-search')
			if (ganttSearch.length !== 0) {
				let ganttTaskBody = document.querySelector('.gantt-task-body');
				let ganttChartBody = document.querySelector('.gantt-chart-body');

				// 좌간트 부착
				let newLeftDiv = addGanttLeft(data);
				ganttTaskBody.append(newLeftDiv);

				// 우간트 적용
				let newRighttDiv = createGanttChart(data);
				ganttChartBody.append(newRighttDiv);

				closeTaskModal(0)
				document.querySelector('.gantt-all-task').scrollIntoView(false)
			} else {
				let Notice = document.querySelector('.project_task_notice_list') ? document.querySelector('.project_task_notice_list') : firstCloneNotice
				let Update = document.querySelector('.project_task_update_list') ? document.querySelector('.project_task_update_list') : firstCloneUpdate

				let cloneNotice = document.querySelector('.project_task_notice_list') ? document.querySelector('.project_task_notice_list').cloneNode(true) : firstCloneNotice.cloneNode(true)
				let cloneUpdate = document.querySelector('.project_task_update_list') ? document.querySelector('.project_task_update_list').cloneNode(true) : firstCloneUpdate.cloneNode(true)
				cloneNotice.firstElementChild.textContent = data.data.title
				cloneNotice.firstElementChild.setAttribute('onclick', 'openTaskModal(1,1,' + data.data.id + ')')
				cloneNotice.firstElementChild.classList.add('notice-' + data.data.id)
				cloneNotice.classList.add('notice-layout-' + data.data.id)
				cloneUpdate.firstElementChild.firstElementChild.textContent = '공지'
				cloneUpdate.firstElementChild.firstElementChild.style = "color:rgb(255, 196, 0);"
				cloneUpdate.firstElementChild.nextElementSibling.textContent = data.data.title
				cloneUpdate.firstElementChild.nextElementSibling.setAttribute('onclick', 'openTaskModal(1,1,' + data.data.id + ')')
				cloneUpdate.firstElementChild.classList.add('update-' + data.data.id)
				cloneUpdate.classList.add('update-layout-' + data.data.id)

				let NoticeParent = document.querySelector('.project_task_notice_list_parent')
				let UpdateParent = document.querySelector('.project_task_update_list_parent')

				NoticeParent.firstChild.before(cloneNotice)
				UpdateParent.firstChild.before(cloneUpdate)

				closeTaskModal(0)
			}
		})
		.catch(err => {
			console.log(err.stack)
		});
}

// 등록 버튼으로 작성/수정
function updateTask() {

	let modalCloseBtn = document.querySelector('.cross_icon_w');
	let insertErrorMsg = document.querySelector('.insert_error_msg');
	let insertTitle = document.querySelector('.insert_title').value;
	let insertContent = document.querySelector('.insert_content').value;
	let insertTitleMax = 100;
	let insertContentMax = 500;

	if (insertTitle === '') {
		showError('제목을 입력해 주세요.');
	} else if (insertTitle.length > insertTitleMax && insertContent.length > insertContentMax) {
		showError('제목과 내용 글자 수를 모두 초과했습니다.');
	} else if (insertTitle.length > insertTitleMax) {
		showError('제목 글자 수를 초과했습니다.');
	} else if (insertContent.length > insertContentMax) {
		showError('내용 글자 수를 초과했습니다.');
	} else {
		hideError();
	}
	
	// 닫기 버튼 누르면 에러메세지 제거
	modalCloseBtn.addEventListener('click', () => {
		hideError();
	});

	function showError(message) {
		insertErrorMsg.classList.remove('d-none');
		insertErrorMsg.textContent = message;
	}

	function hideError() {
		insertErrorMsg.classList.add('d-none');
	}


	let updateData = {
		'title': document.querySelector('.insert_title') ? document.querySelector('.insert_title').value : null,
		'content': document.querySelector('.insert_content') ? document.querySelector('.insert_content').value : null,
		'task_status_id': document.querySelectorAll('#checked') ? document.querySelectorAll('#checked')[0].textContent : null,
		'task_responsible_id': document.querySelector('.insert_responsible_one') ? document.querySelector('.insert_responsible_one').textContent : null,
		'start_date': document.querySelectorAll('.start_date') ? document.querySelectorAll('.start_date')[0].value : null,
		'end_date': document.querySelectorAll('.end_date') ? document.querySelectorAll('.end_date')[0].value : null,
	}
	// console.log(updateData);
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
			closeTaskModal(0)
			if (document.querySelectorAll('.gantt-search').length === 1) {
				// 해당 간트 row
				// console.log(document.querySelector('#gantt-task-' + now_task_id));
				let refreshTarget = document.querySelector('#gantt-task-' + now_task_id)
				// console.log(refreshTarget);
				// 해당 간트 상태
				let refreshStatus = refreshTarget.firstElementChild.nextElementSibling.firstElementChild.nextElementSibling.firstElementChild
				refreshStatus.setAttribute('data-status', data.data.names.task_status_name)
				refreshStatus.firstElementChild.textContent = data.data.names.task_status_name;
				statusColorAutoPainting(data.data.names.task_status_name, refreshStatus)
				// 해당 간트 담당자
				let refreshResponsible = refreshTarget.firstElementChild.nextElementSibling.firstElementChild.firstElementChild
				refreshResponsible.textContent = data.data.names.task_responsible_name
				// 해당 간트 제목
				let refreshTitle = refreshTarget.firstElementChild.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling
				refreshTitle.textContent = data.data.task.title
				// 해당 간트 시작일				
				let refreshStart = refreshTarget.firstElementChild.nextElementSibling.firstElementChild.nextElementSibling.nextElementSibling.firstElementChild
				refreshStart.value = data.data.task.start_date
				// 해당 간트 마감일
				let refreshEnd = refreshTarget.firstElementChild.nextElementSibling.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling.firstElementChild
				refreshEnd.value = data.data.task.end_date

				// 작성에서 우간트 작업 복사

				let refreshRightGanttChart = document.querySelector('#gantt-chart-' + now_task_id)
				let chartDateList = Array.from(refreshRightGanttChart.children)
				refreshRightGanttChart.innerHTML = '';
				// console.log(chartDateList);

				if (data.data.task.start_date !== null && data.data.task.end_date !== null) {
					chartDateList.forEach((CDone, CDi) => {
						// 현재 날짜[CDi번째]와 시작일/마감일을 비교하고 출력
						// console.log(CDone);
						// console.log(CDone.id);
						let regex8 = CDone.id.match(/(\d{8})/)[0];
						const year = regex8.substring(0, 4);
						const month = regex8.substring(4, 6);
						const day = regex8.substring(6, 8);
						const formattedDate = `${year}-${month}-${day}`;

						let currentDate = new Date(formattedDate);
						let start = new Date(data.data.task.start_date);
						let end = new Date(data.data.task.end_date);

						// rowID-date 하나 생성
						var rowId = 'row' + data.data.id + '-' + currentDate;
						var divElement = document.createElement('div');
						divElement.id = rowId;

						if (currentDate >= start && currentDate <= end) {
							divElement.innerHTML = '<div class="bk-row" data-row-num="' + data.data.id + '"></div>';
							if (currentDate === start) {
								divElement.innerHTML = '<div class="bk-row" data-row-num="' + data.data.id + '"><span class="dates start">' + currentDate + '</span></div>';
							}
							if (currentDate === end) {
								divElement.innerHTML = '<div class="bk-row" data-row-num="' + data.data.id + '"><span class="dates end">' + currentDate + '</span></div>';
							}
						}

						// 만든 애 하나 달기
						refreshRightGanttChart.appendChild(divElement);
					})
				}
			}
			openTaskModal(1, TaskNoticeFlg, now_task_id)
		})
		.catch(err => {
			console.log(err.stack)
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

		// fetch('/modal-auth/'+now_task_id, {
		// 	method: 'GET',
		// 	headers: {
		// 		'Content-Type': 'application/json',
		// 		'X-CSRF-TOKEN': csrfToken_insert_detail,
		// 	},
		// })
		// .then(response => response.json())
		// .then(data => {
		// 	console.log(data);
		// 	if(data.authority_id === "1"){
		// 		document.querySelector('#modaldelete').style.display ='none';
		// 	}
		// })
		// .catch(err => {
		// 	console.log(err.message);
		// })

	});
}
// 더보기 닫기
function closeMoreModal() {
	MORE_MODAL.style = 'display: none;'
}

// 업무상태 색삽입 모듈
function statusColorAutoPainting(switching, paintTo) {
	// console.log(switching);
	switch (switching) {
		case '시작전':
			paintTo.style.backgroundColor = '#B1B1B1';
			break;
		case '진행중':
			paintTo.style.backgroundColor = '#04A5FF';
			break;
		case '피드백':
			paintTo.style.backgroundColor = '#F34747';
			break;
		case '완료':
			paintTo.style.backgroundColor = '#64C139';
			break;
		default:
			paintTo.style.backgroundColor = 'var(--m-btn)';
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
}

// 담당자 추가
function addResponsible(a) {
	// 담당자 초기화
	while (ADD_RESPONSIBLE_MODAL.hasChildNodes()) {
		ADD_RESPONSIBLE_MODAL.removeChild(ADD_RESPONSIBLE_MODAL.firstChild);
	}
	ADD_RESPONSIBLE_MODAL.append(cloneResponsibleModal)

	// 담당자 리스트 확인용 통신
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

				// 현재 추가된/추가안된 담당자 모달에 수정된 클론을 추가
				let nowResponsibleModal = document.querySelector('.add_responsible_modal')
				nowResponsibleModal.insertBefore(responsibleModalClone, nowResponsibleModal.firstElementChild);
				// console.log(element.member_name);
			}
		})
		.catch(err => {
			console.log(err.message);
		})

	ADD_RESPONSIBLE_MODAL.classList.remove('d-none')
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

// 댓글 수정
function updateComment(event, a) {
	// 기준 바뀌어도 index는 같음
	let updateComment = document.querySelectorAll('.update_comment');
	updateComment.forEach((UCone, UCi) => {
		// 엘리먼트 비교 .isSameElement / .isEqualElemet 같은 메소드도 있음
		// 내가 누른 애랑 반복도는 애 번째가 같으면 실행
		if (event.currentTarget === UCone) {
			let comment_input = document.querySelectorAll('.comment_line');
			let deleteComment = document.querySelectorAll('.delete_comment');
			let saveComment = document.querySelectorAll('.save_comment');
			let cancelComment = document.querySelectorAll('.cancel_comment');

			// 내용과 id 값 배치
			thisCommentId = event.target.parentElement.nextElementSibling.nextElementSibling.value
			thisCommentContent = event.target.parentElement.nextElementSibling
			console.log(thisCommentContent);

			// 저장버튼에 저장기능 적용
			document.querySelectorAll('.save_comment')[UCi].setAttribute('onclick', 'commitUpdateComment(event)');

			// 버튼 보이고 안보이기
			updateComment[UCi].classList.add('d-none');
			deleteComment[UCi].classList.add('d-none');

			saveComment[UCi].classList.remove('d-none');
			cancelComment[UCi].classList.remove('d-none');

			// 수정가능하게 속성추가 및 판별용 css
			thisCommentContent.setAttribute('contenteditable', 'true');
			thisCommentContent.style.backgroundColor = '#ffffff2f';

			// 취소 눌렀을 때
			cancelComment[UCi].addEventListener('click', () => {
				updateComment[UCi].classList.remove('d-none');
				deleteComment[UCi].classList.remove('d-none');
				saveComment[UCi].classList.add('d-none');
				cancelComment[UCi].classList.add('d-none');
				comment_input[UCi].removeAttribute('contenteditable', 'true');
				comment_input[UCi].style.backgroundColor = '';
			})
		}
	})
}







// 댓글 수정 적용 버튼
function commitUpdateComment(event) {
	let comment_input = document.querySelector('.comment_line');
	// console.log(event.target.parentElement.nextElementSibling.textContent);

	// 댓글 여러개 있을 때 각각 수정 가능하게
	let saveNewComment = event.target.parentElement.nextElementSibling.textContent;
	let putData = {
		"content": saveNewComment,
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
			// console.log(data);
			openTaskModal(1, TaskNoticeFlg, now_task_id)

		})
		.catch(err => {
			console.log(err.message);
		})
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
		"content": INPUT_COMMENT_CONTENT.value.trim()
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
			console.log(err.stack);
		})
	// 입력창 초기화
	INPUT_COMMENT_CONTENT.value = ''
}

// 댓글 엔터로 달기
// 입력창
let comment_input = document.querySelector('#comment_input');
// 엔터로 채팅보내기
comment_input.addEventListener('keypress', (event) => {
	if (comment_input.value.trim() !== '' && event.key === 'Enter') {
		addComment();
	}
});

// 오픈모달 모듈------------------------------------------------------

// 값을 모달에 삽입
function insertModalValue(data, a) {
	// console.log(data);
	if (a === 1) { // 상세
		// 수리 // WRITER_NAME.textContent = data.task[0].wri_name;
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
		// console.log(data);
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

			let updateComment = refresh_clone_comment.firstElementChild.nextElementSibling.firstElementChild.firstElementChild.nextElementSibling
			let deleteComment = refresh_clone_comment.firstElementChild.nextElementSibling.firstElementChild.firstElementChild.nextElementSibling.nextElementSibling.nextElementSibling
			// 댓글 편집/삭제 권한
			if (data.comment[i].user_id === data.nowAuthority.id || data.comment[i].user_id === data.nowAuthority.id && data.nowAuthority.flg === "0") {
				//
			} else if (data.nowAuthority.flg === "1" && data.nowAuthority.authority_id === "0") {
				updateComment.style.display = 'none';
			} else if (data.nowAuthority.authority_id !== "0" && data.comment[i].user_id != data.nowAuthority.id) {
				updateComment.style.display = 'none';
				deleteComment.style.display = 'none';
			}

			// 댓글 달기
			refresh_comment_parent.append(refresh_clone_comment)

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

	// 상위업무 있는지 체크
	if (Object.keys(data).includes('parents')) {
		// 상위업무 달아주기
		OVERHEADER[a].style = 'display: block;'
		// 상위업무 개수 체크
		if (data.parents.length !== 0) {
			// 상위업무 달아주기
			OVERHEADER_PARENT[a].textContent = ' > ' + data.parents[0].title
			OVERHEADER_PARENT[a].style = 'display: inline-block;'
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
	} else {
		BEHIND_MODAL.style = 'display: none;'
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
			DEAD_LINE[0].classList.remove('d-none')

			// 상세업무 내용 값체크, 삽입
			modalContentValue(data, 0);

			// 상위업무 컨트롤
			parentTaskControl(data, 0);

			// 수정 이후 처리
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
	fetch('/task/' + now_task_id, {
		method: 'DELETE',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': csrfToken_insert_detail,
		},
	})
		.then(response => response.json())
		.then(data => {
			// console.log(data);
			console.log(document.querySelectorAll('.gantt-child-task'));

			if (GANTT_LEFT[0]) {
				document.querySelector('#gantt-task-' + data.data) ? document.querySelector('#gantt-task-' + data.data).remove() : ''
				document.querySelector('#gantt-chart-' + data.data) ? document.querySelector('#gantt-chart-' + data.data).remove() : ''

				if (document.querySelectorAll('.gantt-child-task')[0]) {
					let childIndependence = document.querySelectorAll('.gantt-child-task')

					for (let child of childIndependence) {
						console.log(child);
						console.log(child.getAttribute('parent'));
						console.log(child.getAttribute('id'));
						if (!document.querySelector('#gantt-task-' + child.getAttribute('parent'))) {
							console.log('independence child');
							document.querySelector('#gantt-chart-' + child.getAttribute('id').match(/\d+/)[0]).remove()
							child.remove()
						}
					}
				}

				let isAnnyoneInTheField = document.querySelectorAll('.gantt-task')[0] ? document.querySelectorAll('.gantt-task')[0].classList.contains('d-none') ? document.querySelectorAll('.gantt-task').length - 1 : document.querySelectorAll('.gantt-task').length : 0

				// console.log(a);
				if (isAnnyoneInTheField === 0) {
					document.querySelector('.new-task-add-please').style.display = 'block'
					document.querySelector('.gantt-chart') ? document.querySelector('.gantt-chart').classList.remove('d-none') : ''
				}

			} else {
				document.querySelector('.update-' + data.data) ? document.querySelector('.update-layout-' + data.data).remove() : ''
				document.querySelector('.notice-' + data.data) ? document.querySelector('.notice-layout-' + data.data).remove() : ''
			}

			closeTaskModal(1)
		})
		.catch(err => {
			console.log(err.message)
			console.log(err.stack)
		});
}

// 업데이트용 컬러적용
function updateStatusColor(data) {
	document.querySelectorAll('.status_val') ? document.querySelectorAll('.status_val')[0].setAttribute('id', '') : ''
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
}

function updateResponsibleName(data, a) {
	// console.log(data);
	// 기존에 클론한 엘리먼트에 값을 넣기
	if (data.task[0].res_name) {
		cloneResponsible.firstChild.nextElementSibling.nextElementSibling.textContent = data.task[0].res_name

		// 삽입할 태그 선택
		let nowFrontOfResponsible = document.querySelectorAll('.responsible_icon')[0]
		// console.log(nowFrontOfResponsible);

		// d-none 삭제
		cloneResponsible.classList.remove('d-none')

		// 투명화 되어있는 기본 담당자 삭제
		RESPONSIBLE_PERSON[0].remove()

		// 태그에 넣기
		nowFrontOfResponsible.after(cloneResponsible)
	} else {
		RESPONSIBLE_PERSON[0].remove()
	}
}


//삭제 모달창 open
function openDeleteModal() {
	document.getElementById('deleteModal').style.display = 'block';
}

//삭제 모달창 close
function closeDeleteModal() {
	document.getElementById('deleteModal').style.display = 'none';
}

//삭제버튼시 삭제
//  const csrfToken_insert_detail = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
function deleteProject(project_pk) {

	fetch('/projectDelete/' + project_pk, {
		method: 'DELETE',
		// body : JSON.stringify(Id),
		headers: {
			"Content-Type": "application/json",
			'X-CSRF-TOKEN': csrfToken_insert_detail
		},
	}).then((response) =>
		console.log(response))
		// response.json()
		.then(() => {
			window.location.href = '/dashboard'; // 메인화면으로 이동
		}).catch(error => console.log(error));
}

//나가기 모달창 open
function openExitModal() {
	document.getElementById('exitModal').style.display = 'block';
}

//나가기 모달창 close
function closeExitModal() {
	document.getElementById('exitModal').style.display = 'none';
}

//나가기 버튼시 삭제
//  const csrfToken_insert_detail = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
function exitProject(project_pk) {

	fetch('/projectExit/' + project_pk, {
		method: 'DELETE',
		// body : JSON.stringify(Id),
		headers: {
			"Content-Type": "application/json",
			'X-CSRF-TOKEN': csrfToken_insert_detail
		},
	}).then((response) =>
		console.log(response))
		// response.json()
		.then(() => {
			window.location.href = '/dashboard'; // 메인화면으로 이동
		}).catch(error => console.log(error));
}