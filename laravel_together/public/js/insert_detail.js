const DETAIL_MODAL = document.querySelector('.detail_task_modal')
const INSERT_MODAL = document.querySelector('.insert_task_modal')
const MORE_MODAL = document.querySelector('.more_modal')
const BOARD_TYPE = document.querySelectorAll('.type_task')
const INS_STATUS_VALUE = document.getElementsByClassName('ins_status_val')
const DET_STATUS_VALUE = document.getElementsByClassName('det_status_val')
const RESPONSIBLE_PERSON = document.querySelector('.respon_one')
const MORE = document.querySelector('.more')
const specificArea = document.querySelector('.more');
const specificArea2 = document.querySelector('.more_modal');
const REMOVE_RES = document.getElementById('remove_responsible');
const REMOVE_PRI = document.getElementById('remove_priority');
var insStatusValue = 0
var detStatusValue = 0
var cloneRespon = RESPONSIBLE_PERSON.cloneNode()

// console.log(STATUS_VALUE)
// DETAIL_MODAL.style = 'display: none;'
// INSERT_MODAL.style = 'display: none;'
MORE_MODAL.style = 'display: none;'
INS_STATUS_VALUE[insStatusValue].style='background-color: #1AE316';
DET_STATUS_VALUE[detStatusValue].style='background-color: #1AE316';

// 모달 여닫기 insert/detail 개별
function openDetailModal() {
	DETAIL_MODAL.style = 'display: block;'
}

function closeDetailModal() {
	DETAIL_MODAL.style = 'display: none;'
}

function openInsertModal() {
	INSERT_MODAL.style = 'display: block;'
}

function closeInsertModal() {
	INSERT_MODAL.style = 'display: none;'
}

// 더보기 모달 여닫기
function openMoreModal() {
	MORE_MODAL.style = 'display: flex;'
	// 클릭 이벤트 리스너 추가
	document.addEventListener('click', function(event) {
		// 클릭된 엘리먼트가 특정 영역 내에 속하는지 확인
		if (!specificArea.contains(event.target)) {
			// 특정 영역 외 클릭 시 수행할 동작
			// 예: 모달을 닫거나 다른 행동 수행
			if (!specificArea2.contains(event.target)) {
				// 특정 영역 외 클릭 시 수행할 동작
				// 예: 모달을 닫거나 다른 행동 수행
				closeMoreModal();
			}
		}
	});
}

function closeMoreModal() {
	MORE_MODAL.style = 'display: none;'
}

// 글/업무 스위치
function changTaskNotice() {
	BOARD_TYPE[0].classList.toggle('d-none');
	BOARD_TYPE[1].classList.toggle('d-none');
}

// 업무상태 detail/insert 개별 동작
function changeInsertStatus(i) {
	INS_STATUS_VALUE[insStatusValue].style='background-color: #C7C7C7';
	insStatusValue = i;
	INS_STATUS_VALUE[insStatusValue].style='background-color: #1AE316';
}
function changeDetailStatus(i) {
	DET_STATUS_VALUE[detStatusValue].style='background-color: #C7C7C7';
	detStatusValue = i;
	DET_STATUS_VALUE[detStatusValue].style='background-color: #1AE316';
}