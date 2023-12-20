// 변수 선언 ---------------------------------
// body 전체
const BODY = document.querySelector('body')
// 모달 전체
const TASK_MODAL = document.querySelectorAll('.task_modal')
// 작성 모달
const INSERT_MODAL = document.querySelector('.insert_modal')
// 더보기모달 (디테일)
const MORE_MODAL = document.querySelector('.more_modal')
// 프로젝트 색상
const PROJECT_COLOR = document.querySelectorAll('.project_color')
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
const INSERT_TITLE = document.querySelector('.insert_title')
const CHECKED_STATUS = document.querySelectorAll('#checked')[0]


// 담당자 모달용 클론
let cloneResponsibleModal = ADD_RESPONSIBLE_MODAL_ONE.cloneNode(true)
// 담당자 추가용 클론
let cloneResponsible = RESPONSIBLE_PERSON[0].cloneNode(true)
// 우선순위 모달용 클론
let clonePriorityModal = ADD_PRIORITY_MODAL_ONE.cloneNode(true)
// 우선순위 추가용 클론
let clonePriority = PRIORITY_ONE[0].cloneNode(true)
// 댓글 초기화용 클론
let cloneResetComments = COMMENT_PARENT.cloneNode(true)
// 모달 내용 저장소
let detail_data = {};
// 띄운 상세 업무 id (더보기용)
let detail_id = 0;
// 작성/수정 플래그
let createUpdate = 0;
// 업무/공지 플래그
let TaskNoticeFlg = 0;
// 현재 프로젝트 확인
let thisProjectId = 0;
thisProjectId = 1; // 임시
// 현재 업무번호 확인
let thisTaskId = 0;

// 업무상태 기본값 설정
STATUS_VALUE[0].style = 'background-color: #B1B1B1;'

// TODO: 바깥영역 클릭시 인서트모달 닫기
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

	// 작성 모달 띄우기
	if (a === 0) {
		// 프로젝트 색 가져오기
		axios.get('/api/project/' + thisProjectId)
			.then(res => {
				// 프로젝트 색 띄우기
				PROJECT_COLOR[a + 1].style = 'background-color: ' + res.data.data[0].data_content_name + ';'
				PROJECT_NAME[a].textContent = res.data.data[0].project_title
			})
			.catch(err => {
				console.log(err.message);
			})

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
	const SUBMIT = document.querySelector('.submit')
	if (createUpdate === 1) {
		SUBMIT.setAttribute('onclick', 'updateTask()')
	} else {
		SUBMIT.setAttribute('onclick', 'createTask()')
	}

	// 상세 모달 띄우기
	if (a === 1) {
		// 작성모달 모서리 둥글게
		TASK_MODAL[1].style = 'border-radius: 14px 0 0 14px;'
		
		// 상세 정보 가져오기
		axios.get('/api/task/' + c)
			.then(res => {
				// 값을 모달에 삽입
				insertModalValue(res.data, a);

				// 업무상태 값과 색상 주기
				statusColor(res.data);

				// 담당자 값체크, 삽입
				responsibleName(res.data, a);

				// 마감일자 값체크, 삽입
				deadLineValue(res.data, a);

				// 우선순위 값체크, 삽입
				priorityValue(res.data, a);

				// 상세업무 내용 값체크, 삽입
				modalContentValue(res.data, a);

				// 댓글 컨트롤
				commentControl(res.data);

				// 상위업무 컨트롤
				parentTaskControl(res.data, a);

				// 현재 업무 id 저장
				thisTaskId = res.data.task[0].id
			})
			.catch(err => {
				console.log(err.message);
			})
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
		"project_id": thisProjectId
	}
	if (TaskNoticeFlg === 0) {
		postData.task_status_id = CHECKED_STATUS.textContent
		postData.task_responsible_id = RESPONSIBLE_USER[0].textContent
		postData.start_date = START_DATE[0].placeholder
		postData.end_date = END_DATE[0].placeholder
		postData.priority_id = PRIORITY_VAL[0].textContent
	}
	let headers = {
		'headers': { 'Content-Type': 'application/json', }
	}
	axios.post('/api/task', postData, headers)
		.then(res => {
			console.log(res.data);
		})
		.catch(err => {
			console.log(err.message)
		});
}

// 등록 버튼으로 작성/수정
function updateTask() {
	let data = {
		'title': INSERT_TITLE.value,
		'content': INSERT_CONTENT.value,
		'task_status_id': CHECKED_STATUS.textContent,
		'task_responsible_id': RESPONSIBLE_USER[0].textContent,
		'start_date': START_DATE[0].placeholder,
		'end_date': END_DATE[0].placeholder,
		'priority_id': PRIORITY_VAL[0].textContent
	}
	let headers = {
		headers: { 'Content-Type': 'application/json', }
	}
	axios.put('/api/task/' + now_task_id, data, headers)
		.then(res => {
			console.log('수정되었습니다.');
			console.log(res.data);
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
	switch (NOW_CHECKED.textContent) {
		case '시작전':
			NOW_CHECKED.style = 'background-color: #B1B1B1;';
			break;
		case '진행중':
			NOW_CHECKED.style = 'background-color: #04A5FF;';
			break;
		case '피드백':
			NOW_CHECKED.style = 'background-color: #F34747;';
			break;
		case '완료':
			NOW_CHECKED.style = 'background-color: #64C139;';
			break;
	}
}

// 담당자 추가
function addResponsible(a) {
	axios.get('/api/project/' + thisProjectId)
			.then(res => {
				//
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

// 담당자 삭제
function removeResponsible(a) {
	RESPONSIBLE_ICON[a].nextSibling.remove()
}

// 우선순위 추가/삭제
function addPriority(a) {
	ADD_PRIORITY_MODAL.classList.remove('d-none')
	// PRIORITY_ICON[a].after(clonePriority)
	// 우선순위 모달, 우선순위추가버튼 외 영역으로 끄기
	INSERT_MODAL.addEventListener('click', function (event) {
		if (!ADD_PRIORITY_MODAL.contains(event.target) && !PRIORITY_ADD_BTN[a].contains(event.target)) {
			ADD_PRIORITY_MODAL.classList.add('d-none')
		}
	});
}
function removePriority(a) {
	PRIORITY_ICON[a].nextSibling.remove()
}

// 댓글 삭제
function removeComment(event, a) {
	let thisCommentId = event.target.parentElement.nextElementSibling.nextElementSibling
	axios.delete('/api/comment/' + thisCommentId.value)
			.then(res => {
				console.log(res.data);
				return openTaskModal(1, TaskNoticeFlg, thisTaskId)
			})
			.then(()=> {
				let comment_box = document.querySelector('.comment')
				comment_box.scrollIntoView(false)
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
		"task_id": thisTaskId,
		"content": INPUT_COMMENT_CONTENT.value
	}
	let headers = {
		'headers': { 'Content-Type': 'application/json', }
	}
	axios.post('/api/comment/' + thisTaskId, postData, headers)
			.then(res => {
				console.log(res.data);
				return openTaskModal(1, TaskNoticeFlg, thisTaskId)
			})
			.then(()=> {
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
	if (a === 1) { // 상세
		WRITER_NAME.textContent = data.task[0].wri_name;
		TASK_CREATED_AT.textContent = data.task[0].created_at;
		TASK_TITLE.textContent = data.task[0].title;
	} else { // 작성
		INSERT_TASK_TITLE.value = data.task[0].title;
	}
	PROJECT_NAME[a].textContent = data.task[0].project_title;
	// 프로젝트 색 띄우기
	PROJECT_COLOR[a + 1].style = 'background-color: ' + data.task[0].project_color + ';'
	// 더보기에 쓸 id값 숨겨두기
	now_task_id = data.task[0].id
}

// 업무상태 값과 색상 주기
function statusColor(data) {
	DET_STATUS_VAL.textContent = data.task[0].status_name;
	switch (DET_STATUS_VAL.textContent) {
		case '시작전':
			DET_STATUS_VAL.style = 'background-color: #B1B1B1;';
			break;
		case '진행중':
			DET_STATUS_VAL.style = 'background-color: #04A5FF;';
			break;
		case '피드백':
			DET_STATUS_VAL.style = 'background-color: #F34747;';
			break;
		case '완료':
			DET_STATUS_VAL.style = 'background-color: #64C139;';
			break;
		default:
			DET_STATUS_VAL.style = 'background-color: #FFFFFF;';
			break;
	}
}

// 담당자 값체크, 삽입
function responsibleName(data, a) {
	if (data.task[0].res_name !== null) {
		RESPONSIBLE_USER[a].textContent = data.task[0].res_name;
		RESPONSIBLE_PERSON[a].style = 'display: flex;'
	} else {
		RESPONSIBLE_PERSON[a].style = 'display: none;'
	}
}

// 마감일자 값체크, 삽입
function deadLineValue(data, a) {
	if (data.task[0].start_date === null || data.task[0].end_date === null) {
		DEAD_LINE[a].style = 'display: none;'
	} else {
		START_DATE[a].placeholder = data.task[0].start_date;
		END_DATE[a].placeholder = data.task[0].end_date;
		DEAD_LINE[a].style = 'display: flex;'
	}
}

// 우선순위 값체크, 삽입
function priorityValue(data, a) {
	if (data.task[0].priority_name !== null) {
		PRIORITY_VAL[a].textContent = data.task[0].priority_name;
		PRIORITY[a].style = 'display: flex;'
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
		}
	} else {
		PRIORITY[a].style = 'display: none;'
	}
}

// 상세업무 내용 값체크, 삽입
function modalContentValue(data, a) {
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

			// 삭제버튼 값 넣기
			const RE_COMMENT_ONE = document.querySelectorAll('.comment_one') // 변경한 댓글들을 재확인
			const LAST_REMOVE_BTN = RE_COMMENT_ONE[RE_COMMENT_ONE.length - 1].firstElementChild.nextElementSibling.firstElementChild.firstElementChild.nextElementSibling
			LAST_REMOVE_BTN.addEventListener('click', () => {
				return RE_COMMENT_ONE[RE_COMMENT_ONE.length - 1].remove();
			})
		}
	}

	// 댓글 없으면 댓글창 없애기
	if (!COMMENT_PARENT.hasChildNodes()) {
		COMMENT_PARENT.style = 'padding: 0;'
	}
}

// 상위업무 컨트롤
function parentTaskControl(data, a) {
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

// 모달 띄우기
function openInsertDetailModal(a) {
	TASK_MODAL[a].style = 'display: block;'
	if (a === 0) {
		BEHIND_MODAL.style = 'display: block;'
		TASK_MODAL[1].style = 'display: none;'
	} else {
		BEHIND_MODAL.style = 'display: none;'
		TASK_MODAL[0].style = 'display: none;'
	}
}
// 글/업무 플래그
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
	axios.put('/api/task/' + now_task_id) // insertModalValue() 모달창 띄울때 담았던 변수
		.then(res => {
			// 값을 모달에 삽입
			insertModalValue(res.data, 0);

			// 업무상태 값과 색상 주기
			statusColor(res.data);

			// 담당자 값체크, 삽입
			responsibleName(res.data, 0);

			// 마감일자 값체크, 삽입
			deadLineValue(res.data, 0);

			// 우선순위 값체크, 삽입
			priorityValue(res.data, 0);

			// 상세업무 내용 값체크, 삽입
			modalContentValue(res.data, 0);


			// 댓글창 없을 때 사라질 값 갱신선언
			COMMENT_PARENT.style = 'padding: 20;'

			// 댓글 컨트롤
			commentControl(res.data);

			// 상위업무 컨트롤
			parentTaskControl(res.data, 0);
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

	createUpdate = 0
}

// 모달 삭제
function deleteTask() {
	axios.delete('/api/task/' + now_task_id)
		.then(res => {
			console.log(res.data);
			closeTaskModal(1)
		})
		.catch(err => {
			console.log(err.message);
		})
}