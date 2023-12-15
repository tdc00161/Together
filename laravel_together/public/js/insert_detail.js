// 변수 선언 ---------------------------------
// 모달 전체
const TASK_MODAL = document.querySelectorAll('.task_modal')
// 더보기모달
const MORE_MODAL = document.querySelector('.more_modal')
// 업무/글
const BOARD_TYPE = document.querySelectorAll('.type_task')
// 더보기
const MORE = document.querySelector('.more')
// 업무상태
const STATUS_VALUE = document.getElementsByClassName('status_val')
// 담당자
const RESPONSIBLE_PERSON = document.querySelectorAll('.responsible_one')
// 담당자 아이콘
const RESPONSIBLE_ICON = document.querySelectorAll('.responsible_icon')
// 담당자 추가/변경 버튼
const RESPONSIBLE_ADD_BTN = document.querySelectorAll('.add_responsible')
// 우선순위
const PRIORITY_ONE = document.querySelectorAll('.priority_one')
// 우선순위 아이콘
// css img 입힐 때 중복이라서 flag_icon이라 적음. 담당자와 달라서 헷갈림 주의
const PRIORITY_ICON = document.querySelectorAll('.flag_icon')
// 담당자 추가/변경 버튼
const PRIORITY_ADD_BTN = document.querySelectorAll('.add_priority')
// 댓글 부모
const COMMENT_PARENT = document.querySelector('.comment')
// 댓글 하나
const COMMENT_ONE = document.querySelectorAll('.comment_one')
// 작성 댓글 내역
const INPUT_COMMENT_CONTENT = document.querySelector('#comment_input')
// 모달 배경 블러처리
const BEHIND_MODAL = document.querySelector('.behind_insert_modal');


// 업무상태 값 (색표시용)
var statusValue = 0
// 담당자 추가용 클론
var cloneResponsible = RESPONSIBLE_PERSON[0].cloneNode(true)
// 우선순위 추가용 클론
var clonePriority = PRIORITY_ONE[0].cloneNode(true)


// console.log(STATUS_VALUE)


// 우선처리들 -------------------------
// 미출력
TASK_MODAL[0].style = 'display: none;'
TASK_MODAL[1].style = 'display: none;'
BEHIND_MODAL.style = 'display: none;'
MORE_MODAL.style = 'display: none;'
RESPONSIBLE_PERSON[0].style = 'display: none;'
PRIORITY_ONE[0].style = 'display: none;'
COMMENT_ONE[0].style = 'display: none;'
// 기본 세팅
STATUS_VALUE[statusValue].style = 'background-color: #1AE316';



// 함수-------------------------------
// 모달 여닫기 (중복 열기 불가)
function openTaskModal(a) {
	TASK_MODAL[a].style = 'display: block;'
	if (a === 0) {
		BEHIND_MODAL.style = 'display: block;'
		TASK_MODAL[1].style = 'display: none;'
	} else {
		BEHIND_MODAL.style = 'display: none;'
		TASK_MODAL[0].style = 'display: none;'
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

// 글/업무 스위치
function changTaskType() {
	console.log(BOARD_TYPE);
	BOARD_TYPE[0].classList.toggle('d-none');
	BOARD_TYPE[1].classList.toggle('d-none');
	BOARD_TYPE[2].classList.toggle('d-none');
	BOARD_TYPE[3].classList.toggle('d-none');
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
		return RE_COMMENT_ONE[RE_COMMENT_ONE.length-1].remove();
	})
	// 입력창 초기화
	INPUT_COMMENT_CONTENT.value = ''
}