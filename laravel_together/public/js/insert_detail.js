// 변수 선언 ---------------------------------
// body 전체
const BODY = document.querySelector('body')
// 모달 전체
const TASK_MODAL = document.querySelectorAll('.task_modal')
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
// 업무상태 (공통)
const STATUS_VALUE = document.getElementsByClassName('status_val')
// 상세 업무 상태
const DET_STATUS_VAL = document.querySelector('.det_status_val')
// 담당자 틀 (공통)
const RESPONSIBLE = document.querySelectorAll('.responsible')
// 담당자 (공통)
const RESPONSIBLE_PERSON = document.querySelectorAll('.responsible_one')
// 상세 업무 담당자
const RESPONSIBLE_USER = document.querySelector('.responsible_user')
// 담당자 아이콘
const RESPONSIBLE_ICON = document.querySelectorAll('.responsible_icon')
// 담당자 추가/변경 버튼
const RESPONSIBLE_ADD_BTN = document.querySelectorAll('.add_responsible')
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
const PRIORITY_VAL = document.querySelector('.priority_val')
// 우선순위 옆 아이콘
// css img 입힐 때 중복이라서 flag_icon이라 적음. 담당자와 달라서 헷갈림 주의
const PRIORITY_ICON = document.querySelectorAll('.flag_icon')
// 우선순위 별 아이콘
const PRIORITY_ICON_VALUE = document.querySelectorAll('.priority_icon')
// 우선순위 추가/변경 버튼
const PRIORITY_ADD_BTN = document.querySelectorAll('.add_priority')
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


// 업무상태 값 (색표시용)
let statusValue = 0
// 담당자 추가용 클론
let cloneResponsible = RESPONSIBLE_PERSON[0].cloneNode(true)
// 우선순위 추가용 클론
let clonePriority = PRIORITY_ONE[0].cloneNode(true)
// 댓글 초기화용 클론
let cloneResetComments = COMMENT_PARENT.cloneNode(true)
// 모달 내용 저장소
let detail_data = {};

// console.log(STATUS_VALUE)


// 우선처리들 -------------------------
// 미출력
// TASK_MODAL[0].style = 'display: none;'
// TASK_MODAL[1].style = 'display: none;'
// BEHIND_MODAL.style = 'display: none;'
// MORE_MODAL.style = 'display: none;'
// RESPONSIBLE_PERSON[0].style = 'display: none;'
// PRIORITY_ONE[0].style = 'display: none;'
// COMMENT_ONE[0].style = 'display: none;'

// 기본 세팅
STATUS_VALUE[statusValue].style = 'background-color: #1AE316'; // 전체 status 컨트롤

// TODO: 바깥영역 클릭시 인서트모달 닫기
document.addEventListener('click', function (event) {
	if (BEHIND_MODAL.contains(event.target)) {
		if (!TASK_MODAL[1].contains(event.target)) {
			closeTaskModal(1);
		}
	}
})

// 함수-------------------------------
// 모달 여닫기 (중복 열기 불가)
function openTaskModal(a, b = 0, c = null) { // (작성/상세, 업무/공지, 출력데이터)
	// 작성 모달 띄우기
	if(a === 0){
		// 입력창 플래그별로 길이조정
		if(b === 0) {
			INSERT_CONTENT.style = ''
		}
	}

	// 상세 모달 띄우기
	if(a === 1){
		axios.get('/api/task/' + c)
			.then(res => {
				detail_data = res.data;
				// 값을 모달에 삽입
				PROJECT_NAME[a].textContent = detail_data.task[0].project_title;
				WRITER_NAME.textContent = detail_data.task[0].wri_name;
				TASK_CREATED_AT.textContent = detail_data.task[0].created_at;
				TASK_TITLE.textContent = detail_data.task[0].title;
				
				// 프로젝트 색 띄우기
				PROJECT_COLOR[a].style = 'background-color: ' + detail_data.task[0].project_color + ';'

				// 업무상태 값과 색상 주기
				DET_STATUS_VAL.textContent = detail_data.task[0].status_name;
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

				// 담당자 값체크, 삽입
				if (detail_data.task[0].res_name === null) {
					RESPONSIBLE[a].style = 'display: none;' 
				} else {
					RESPONSIBLE_USER.textContent = detail_data.task[0].res_name;
					RESPONSIBLE[a].style = 'display: flex;'
				}
				
				// 마감일자 값체크, 삽입
				if (detail_data.task[0].start_date === null || detail_data.task[0].end_date === null) {
					DEAD_LINE[a].style = 'display: none;' // TODO: 널가능 애들 처리 동일하게 하기 (+ 우선순위)
				} else {
					START_DATE[a].placeholder = detail_data.task[0].start_date;
					END_DATE[a].placeholder = detail_data.task[0].end_date;
					DEAD_LINE[a].style = 'display: flex;'
				}

				// 우선순위 값체크, 삽입
				if (detail_data.task[0].priority_name === null) {
					PRIORITY[a].style = 'display: none;' 
				} else {
					RESPONSIBLE_USER.textContent = detail_data.task[0].priority_name;
					PRIORITY[a].style = 'display: flex;'
					// 우선순위 값별로 이미지 삽입
					switch (PRIORITY_VAL.textContent) {
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
							PRIORITY[a].style = 'display: none;'
							break;
					}
				}

				// 상세업무 내용 값체크, 삽입
				if (detail_data.task[0].content === null) {
					DETAIL_CONTENT.textContent = '';
				} else {					
					DETAIL_CONTENT.textContent = detail_data.task[0].content;
				}

				// 댓글창 없을 때 사라질 값 갱신선언
				COMMENT_PARENT.style = 'padding: 20;' 

				// 댓글창 갱신
				COMMENT_PARENT.removeChildren
				while (COMMENT_PARENT.hasChildNodes()) {
					COMMENT_PARENT.removeChild(COMMENT_PARENT.firstChild);
				} // 다 지우고 달아도 처음에 기본 댓글을 들고있기 때문에 추가하는데 상관 없나보다

				// 댓글 달아주기
				if (detail_data.comment.length) {
					for (let i = 0; i < detail_data.comment.length; i++) {
						// 댓글 추가용 클론 (갱신)
						let refresh_clone_comment = COMMENT_ONE[0].cloneNode(true)
						// 댓글 부모 (갱신)
						let refresh_comment_parent = document.querySelector('.comment')
						// 클론한 댓글 내용 선택
						const DEFAULT_COMMENT_CONTENT = refresh_clone_comment.firstElementChild.nextElementSibling.firstElementChild.nextElementSibling
						// 클론한 댓글 이름 선택
						const DEFAULT_COMMENT_NAME = refresh_clone_comment.firstElementChild.nextElementSibling.firstElementChild.firstElementChild.firstElementChild
						// 클론한 댓글 투명화 지우기
						refresh_clone_comment.removeAttribute('style')
						// 댓글에 값 씌우기
						DEFAULT_COMMENT_CONTENT.textContent = detail_data.comment[i].content
						DEFAULT_COMMENT_NAME.textContent = detail_data.comment[i].user_name

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

				// 상위업무 초기화
				OVERHEADER[a].style = 'display: none;'
				OVERHEADER_PARENT[a].style = 'display: none;'
				// OVERHEADER_GRAND_PARENT[a].style = 'display: none;'

				// 상위업무 있는지 체크
				if (Object.keys(detail_data).includes('parents')) {
					// 상위업무 달아주기
					OVERHEADER[a].style = 'display: block;'
					// 상위업무 개수 체크
					if (detail_data.parents.length !== 0) {
						// 상위업무 달아주기
						OVERHEADER_PARENT[a].textContent = ' > ' + detail_data.parents[0].title
						OVERHEADER_PARENT[a].style = 'display: inline-block;'
						// if (detail_data.parents.length !== 1) {
						// 	// 상위업무 달아주기
						// 	OVERHEADER_PARENT[a].textContent += ' > ' + detail_data.parents[1].title
						// 	// OVERHEADER_GRAND_PARENT[a].style = 'display: inline-block;'
						// }
					}
				}
			})
			.catch(res => {
				detail_data = res.response.data
			})
	}
	// 모달 띄우기
	TASK_MODAL[a].style = 'display: block;'
	if (a === 0) {
		BEHIND_MODAL.style = 'display: block;'
		TASK_MODAL[1].style = 'display: none;'
	} else {
		BEHIND_MODAL.style = 'display: none;'
		TASK_MODAL[0].style = 'display: none;'
	}
	// 글/업무 플래그
	if (b === 1) {
		BOARD_TYPE[a * 2].classList.add('d-none');
		BOARD_TYPE[(a * 2) + 1].classList.add('d-none');
	} else {
		BOARD_TYPE[a * 2].classList.remove('d-none');
		BOARD_TYPE[(a * 2) + 1].classList.remove('d-none');
	}
}
	
function closeTaskModal(a) {
	TASK_MODAL[a].style = 'display: none;'
	if (a === 0) {
		BEHIND_MODAL.style = 'display: none;'
	}
}

// 더보기 모달 여닫기
function openMoreModal() {
	MORE_MODAL.style = 'display: flex;'
	document.addEventListener('click', function (event) {
		// 클릭된 엘리먼트가 특정 영역 내에 속하는지 확인
		if (!MORE.contains(event.target)) {
			// 더보기 버튼 외 클릭 시
			if (!MORE_MODAL.contains(event.target)) {
				// 더보기 버튼 && 더보기 모달 외 클릭 시
				closeMoreModal();
			}
		}
	});
}
function closeMoreModal() {
	MORE_MODAL.style = 'display: none;'
}

// 업무상태 선택
function changeStatus(a) {
	STATUS_VALUE[statusValue].style = 'background-color: #C7C7C7';
	statusValue = a;
	STATUS_VALUE[statusValue].style = 'background-color: #1AE316';
}

// 담당자 추가/삭제
function addResponsible(a) {
	RESPONSIBLE_ICON[a].after(cloneResponsible)
	RESPONSIBLE_ADD_BTN[a].innerHTML = '담당자변경'
}
function removeResponsible(a) {
	RESPONSIBLE_ICON[a].nextSibling.remove()
	RESPONSIBLE_ADD_BTN[a].innerHTML = '담당자추가'
}
// 우선순위 추가/삭제
function addPriority(a) {
	PRIORITY_ICON[a].after(clonePriority)
	PRIORITY_ADD_BTN[a].innerHTML = '우선순위변경'
}
function removePriority(a) {
	PRIORITY_ICON[a].nextSibling.remove()
	PRIORITY_ADD_BTN[a].innerHTML = '우선순위추가'
}

// 댓글 삭제
function removeComment(a) {
	COMMENT_ONE[a].remove()
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
	// 입력한 댓글 씌우기
	DEFAULT_COMMENT_CONTENT.textContent = INPUT_COMMENT_CONTENT.value

	// 댓글 달기
	refresh_comment_parent.append(refresh_clone_comment)

	// 삭제버튼 값 넣기
	const RE_COMMENT_ONE = document.querySelectorAll('.comment_one')
	const LAST_REMOVE_BTN = RE_COMMENT_ONE[RE_COMMENT_ONE.length - 1].firstElementChild.nextElementSibling.firstElementChild.firstElementChild.nextElementSibling
	LAST_REMOVE_BTN.addEventListener('click', () => {
		return RE_COMMENT_ONE[RE_COMMENT_ONE.length - 1].remove();
	})
	// 입력창 초기화
	INPUT_COMMENT_CONTENT.value = ''
}