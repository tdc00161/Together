// 초기 탭 설정
document.getElementById('tab1').style.display = 'block';

// 탭 열기 함수
function openTab(tabId) {
    // 모든 탭 숨기기
    var tabs = document.getElementsByClassName('tab-content');
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].style.display = 'none';
    }

    // 선택한 탭 보이기
    document.getElementById(tabId).style.display = 'block';

    // 활성화된 탭 스타일 적용
    var activeTabs = document.getElementsByClassName('tab');
    for (var i = 0; i < activeTabs.length; i++) {
        activeTabs[i].classList.remove('tab-active');
    }
    event.currentTarget.classList.add('tab-active');
}

// 모달 열기/닫기 함수
function toggleModal() {
    var modal = document.getElementById('m-myModal');

    // 저장된 액티브 상태를 가져옴
    const lastActiveElement = sessionStorage.getItem('lastActiveElement');

    if (modal.style.display === 'none' || modal.style.display === '') {

        modal.style.display = 'block';

        // 모달이 열릴 때 기본으로 활성화할 요소에 active 클래스 추가
        if (lastActiveElement) {
            document.getElementById(lastActiveElement).classList.add('tab-active');
        }
        friendRequestList();
        friendSendList();
        friendList()
    } else {
        // 현재 액티브 상태를 저장
        const activeElement = document.querySelector('.tab-active');
        if (activeElement) {
            sessionStorage.setItem('lastActiveElement', activeElement.id); // 세션 스토리지에 저장
        }
        modal.style.display = 'none';
    }
}

// 모달 외부 클릭 시 닫기
window.onclick = function (event) {
    var modal = document.getElementById('m-myModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// 모달 닫기 함수
function mcloseModal() {
    document.getElementById('m-myModal').style.display = 'none';
}
// 친구요청 모달 열기 함수
function openModal() {
    document.getElementById('friend-Modal').style.display = 'block';
}
// 친구요청 모달 닫기 함수
function fcloseModal() {
    document.getElementById('friend-Modal').style.display = 'none';
    resetModal();
    friendRequestList();
    friendSendList();
    friendList()
}

// 모달 메세지 초기화 함수
function resetModal() {
    messageContainer.innerHTML = '';  // 메세지 초기화
    inputdiv.value = '';
}

// -------------------------- 친구 요청 ----------------------------
const submitBtn = document.getElementById('submitBtn');
const messageContainer = document.querySelector('.request-message');
const inputdiv = document.querySelector('#receiver_email');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

submitBtn.addEventListener('click', function (event) {
    event.preventDefault(); // 서브밋 버튼의 기본 동작 방지

    const receiverEmail = document.getElementById('receiver_email').value; // 소문자로 변환;

    if (!receiverEmail.trim()) {
        messageContainer.innerHTML = '이메일을 입력하세요.';
        return;
    }

    // 이메일 형식 검사
    // 이메일 형식 확인을 위한 정규 표현식
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(receiverEmail)) {
        messageContainer.innerHTML = '올바른 이메일 형식이 아닙니다.';
        return;
    }

    fetch('/friendsend', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({
            receiver_email: receiverEmail,
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // 성공 메시지를 출력하고 모달은 열어둡니다.
                messageContainer.innerHTML = data.message;
                // 추가로 필요한 로직 수행...
            } else {
                // 에러 메시지를 출력하고 모달은 열어둡니다.
                messageContainer.innerHTML = data.message;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
// -------------------------- 친구 요청 ----------------------------

// ------------------------ 친구 요청 목록 -------------------------
// 친구요청 0일때 msg 표시 div
var emptydiv = document.getElementById('emptydiv');
var emptyRequesMsg = document.createElement('p');

// friend-request-div
var friendrequestdiv = document.getElementById('friend-request-div');

// 모달이 열릴때 실행 되는 함수
function friendRequestList() {

    // AJAX를 통해 친구 요청 목록 가져오기
    fetch('/friendRequests')
        .then(response => {
            // 응답이 성공적인지 확인
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            // JSON 형식으로 변환하여 반환
            return response.json();
        })
        .then(data => {

            var friendRequests = data.friendRequests;
            var friendRequestCount = data.friendRequestCount;
            var noticecount = document.getElementById('noticecount');

            // 0 :
            if (friendRequestCount === 0) {
                // 0 == '0' / none
                noticecount.innerHTML = '0';
                friendrequestdiv.style.display = 'none';

                // 메세지 출력
                emptyRequesMsg.classList.add('empty-msg-css');
                emptyRequesMsg.innerHTML = '요청 없음';
                emptydiv.appendChild(emptyRequesMsg);

            // !0 :
            } else {
                // div 표시 및 count 출력
                friendrequestdiv.style.display = 'block';
                noticecount.innerHTML = friendRequestCount;

                // 친구 요청 목록 함수 실행
                displayFriendRequests(friendRequests);

                // 메세지 출력 none
                emptydiv.style.display = 'none'; 
            }
        })
        .catch(error => {
            // 오류 처리
            console.error('Fetch error:', error);
        });
}

function displayFriendRequests(friendRequests) {
    
    // 기존 내용 초기화
    friendrequestdiv.innerHTML = '';

    if (friendrequestdiv) {
        // 받아온 친구 요청 목록을 모달 내부에 추가
        for (var i = 0; i < friendRequests.length; i++) {
            var friendRequest = friendRequests[i];


            // friend-request-div > messenger-user-div, m-received-bg
            var userDiv = document.createElement('div');
            var friendRequestId = friendRequest.id;
            userDiv.classList.add('messenger-user-div', 'm-received-bg');
            userDiv.setAttribute('id', 'user_pk' + friendRequestId);

            friendrequestdiv.appendChild(userDiv);

            // friend-request-div > messenger-user-div, m-received-bg > user-profile 
            var userprofilediv = document.createElement('div');
            userprofilediv.classList.add('user-profile');

            userDiv.appendChild(userprofilediv);

            // 1. 이미지 추가
            var userprofileImg = document.createElement('img');
            userprofileImg.src = '/img/profile-img.png';
            userprofileImg.classList.add('m-div-userprofile-icon');

            userprofilediv.appendChild(userprofileImg);

            // 2. 이름 추가
            var username = document.createElement('p');
            username.classList.add('user-name');
            username.textContent = friendRequest.name;

            userDiv.appendChild(username);

            // 3. 이메일 추가
            var useremail = document.createElement('p');
            useremail.classList.add('user-email');
            useremail.textContent = friendRequest.email;

            userDiv.appendChild(useremail);

            // 4. 거절 버튼 추가
            var friendRequestId = friendRequest.id;
            var refusebtn = document.createElement('button');
            refusebtn.classList.add('refuse-btn');
            refusebtn.setAttribute('value', friendRequestId);
            refusebtn.textContent = '거절'

            refusebtn.addEventListener('click', function () {
                
                var requestId = this.value;
                noticecount.innerHTML = noticecount.innerHTML - 1;

                if(noticecount.innerHTML==='0'){
                    emptydiv.style.display = 'block';
                    emptyRequesMsg.classList.add('empty-msg-css');
                    emptyRequesMsg.innerHTML = '요청 없음';
                    emptydiv.appendChild(emptyRequesMsg);
                }

                // AJAX 요청 수행
                fetch('/rejectFriendRequest', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ requestId: requestId }),
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Unable to reject friend request.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // 성공 응답을 받았을 때 처리
                        console.log('Success: Friend request rejected.', data);

                        var clickDivId = 'user_pk' + requestId; // 예시: div_123
                        var clickDiv = document.getElementById(clickDivId);

                        if (clickDiv) {
                            clickDiv.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        // 실패 응답 또는 네트워크 오류 발생 시 처리
                        console.error('Error:', error.message);
                        // 에러 메시지를 사용자에게 표시하거나 다른 실패 처리 수행
                    });
            });

            userDiv.appendChild(refusebtn);

            // 5. 수락 버튼 추가
            var acceptbtn = document.createElement('button');
            acceptbtn.classList.add('accept-btn');
            acceptbtn.setAttribute('value', friendRequestId);
            acceptbtn.textContent = '수락'

            acceptbtn.addEventListener('click', function () {

                var requestId = this.value;
                noticecount.innerHTML = noticecount.innerHTML - 1;

                if(noticecount.innerHTML==='0'){
                    emptydiv.style.display = 'block';
                    emptyRequesMsg.classList.add('empty-msg-css');
                    emptyRequesMsg.innerHTML = '요청 없음';
                    emptydiv.appendChild(emptyRequesMsg);
                }

                // AJAX 요청 수행
                fetch('/acceptFriendRequest', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ requestId: requestId }),
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Unable to reject friend request.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // 성공 응답을 받았을 때 처리
                        console.log('Success: Friend request accepted.', data);

                        var specificDivId = 'user_pk' + requestId; // 예시: div_123
                        var specificDiv = document.getElementById(specificDivId);

                        if (specificDiv) {
                            specificDiv.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        // 실패 응답 또는 네트워크 오류 발생 시 처리
                        console.error('Error:', error.message);
                        // 에러 메시지를 사용자에게 표시하거나 다른 실패 처리 수행
                    });
            });

            userDiv.appendChild(acceptbtn);
        }
    } else {
        console.error('Element with id "friend-request-div" not found.');
    }
}
// ------------------------ 친구 요청 목록 끝 -----------------------

// ---------------------- 친구 요청 보낸 목록 -----------------------
// friend-send-div
var friendsenddiv = document.getElementById('friend-send-div');

// 모달이 열릴때 실행 되는 함수
function friendSendList() {

    // AJAX를 통해 친구 요청 보낸 목록 가져오기
    fetch('/friendSendlist')
        .then(response => {
            // 응답이 성공적인지 확인
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            // JSON 형식으로 변환하여 반환
            return response.json();
        })
        .then(data => {

            var friendSendlist = data.friendSendlist;

            // 0 :
            if (friendSendlist === 0) {
                emptyRequesMsg.classList.add('empty-msg-css');
                emptyRequesMsg.innerHTML = '요청 없음';
                emptydiv.appendChild(emptyRequesMsg);
            // !0 :
            } else {
                // 친구 요청 보낸 목록 함수 실행
                displayFriendsends(friendSendlist);
            }
        })
        .catch(error => {
            // 오류 처리
            console.error('Fetch error:', error);
        });
}

function displayFriendsends(friendSendlist) {
    
    // 기존 내용 초기화
    friendsenddiv.innerHTML = '';

    if (friendsenddiv) {
        // 컨트롤러에서 받아온 친구 요청 보낸 목록을 모달 내부에 추가
        for (var i = 0; i < friendSendlist.length; i++) {
            var friendSends = friendSendlist[i];

            // friend-send-div > messenger-user-div, m-received-bg
            var userDiv = document.createElement('div');
            var friendSendId = friendSends.id;
            userDiv.classList.add('messenger-user-div', 'm-request-bg');
            userDiv.setAttribute('id', 'user_pk' + friendSendId);

            friendsenddiv.appendChild(userDiv);

            // friend-send-div > messenger-user-div, m-received-bg > user-profile 
            var userprofilediv = document.createElement('div');
            userprofilediv.classList.add('user-profile');

            userDiv.appendChild(userprofilediv);

            // 1. 이미지 추가
            var userprofileImg = document.createElement('img');
            userprofileImg.src = '/img/profile-img.png';
            userprofileImg.classList.add('m-div-userprofile-icon');

            userprofilediv.appendChild(userprofileImg);

            // 2. 이름 추가
            var username = document.createElement('p');
            username.classList.add('user-name');
            username.textContent = friendSends.name;

            userDiv.appendChild(username);

            // 3. 이메일 추가
            var useremail = document.createElement('p');
            useremail.classList.add('user-email');
            useremail.textContent = friendSends.email;

            userDiv.appendChild(useremail);

            // 4. 요청 취소 버튼 추가
            var friendSendId = friendSends.id;
            var requestcanclebtn = document.createElement('button');
            requestcanclebtn.classList.add('request-cancle-btn');
            requestcanclebtn.setAttribute('value', friendSendId);
            requestcanclebtn.textContent = '요청 취소'

            requestcanclebtn.addEventListener('click', function () {
                
                var sendId = this.value;

                if(noticecount.innerHTML==='0'){
                    emptydiv.style.display = 'block';
                    emptyRequesMsg.classList.add('empty-msg-css');
                    emptyRequesMsg.innerHTML = '요청 없음';
                    emptydiv.appendChild(emptyRequesMsg);
                }

                // AJAX 요청 수행
                fetch('/cancleFriendRequest', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ sendId: sendId }),
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Unable to reject friend request.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // 성공 응답을 받았을 때 처리
                        console.log('Success: Friend request rejected.', data);

                        var clickDivId = 'user_pk' + sendId; 
                        var clickDiv = document.getElementById(clickDivId);

                        if (clickDiv) {
                            clickDiv.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        // 실패 응답 또는 네트워크 오류 발생 시 처리
                        console.error('Error:', error.message);
                        // 에러 메시지를 사용자에게 표시하거나 다른 실패 처리 수행
                    });
            });

            userDiv.appendChild(requestcanclebtn);
        }
    } else {
        console.error('Element with id "friend-request-div" not found.');
    }
}

// --------------------- 친구 요청 보낸 목록 끝----------------------

// ---------------------------- 친구 목록 ----------------------------

// friend-list-div
var friendlistdiv = document.getElementById('friend-list-div');

// 모달이 열릴때 실행 되는 함수
function friendList() {

    // AJAX를 통해 친구 요청 보낸 목록 가져오기
    fetch('/myfriendlist')
        .then(response => {
            // 응답이 성공적인지 확인
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            // JSON 형식으로 변환하여 반환
            return response.json();
        })
        .then(data => {

            var friendList = data.myfriendList;

            // 0 :
            if (friendList === 0) {
            // !0 :
            } else {
                // 친구 목록 표시 함수 실행
                displayFriendlist(friendList);
            }
        })
        .catch(error => {
            // 오류 처리
            console.error('Fetch error:', error);
        });
}

function displayFriendlist(friendList) {
    
    // 기존 내용 초기화
    friendlistdiv.innerHTML = '';

    if (friendlistdiv) {
        // 컨트롤러에서 받아온 친구 요청 보낸 목록을 모달 내부에 추가
        for (var i = 0; i < friendList.length; i++) {
            var friendlistdata = friendList[i];

            // friend-send-div > messenger-user-div, m-received-bg
            var userDiv = document.createElement('div');
            var friendlistId = friendlistdata.friend_id;
            userDiv.classList.add('messenger-user-div', 'm-request-bg');
            userDiv.setAttribute('id', 'user_pk' + friendlistId);

            friendlistdiv.appendChild(userDiv);

            // friend-send-div > messenger-user-div, m-received-bg > user-profile 
            var userprofilediv = document.createElement('div');
            userprofilediv.classList.add('user-profile');

            userDiv.appendChild(userprofilediv);

            // 1. 이미지 추가
            var userprofileImg = document.createElement('img');
            userprofileImg.src = '/img/profile-img.png';
            userprofileImg.classList.add('m-div-userprofile-icon');

            userprofilediv.appendChild(userprofileImg);

            // 2. 이름 추가
            var username = document.createElement('p');
            username.classList.add('user-name');
            username.textContent = friendlistdata.name;

            userDiv.appendChild(username);

            // 3. 이메일 추가
            var useremail = document.createElement('p');
            useremail.classList.add('user-email');
            useremail.textContent = friendlistdata.email;

            userDiv.appendChild(useremail);

            // 4. 요청 취소 버튼 추가
            var friendId = friendlistdata.friend_id;
            var frienddeletebtn = document.createElement('button');
            var frienddeletebtnImg = document.createElement('img');
            frienddeletebtnImg.src = '/img/icon-more.png';
            frienddeletebtn.classList.add('more-btn');
            frienddeletebtnImg.classList.add('more-btn-img');
            frienddeletebtn.setAttribute('value', friendId);

            userDiv.appendChild(frienddeletebtn);
            frienddeletebtn.appendChild(frienddeletebtnImg);
        }
    } else {
        console.error('Element with id "friend-request-div" not found.');
    }
}

// 친구 목록 끝