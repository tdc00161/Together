//  0일때 msg 표시
var emptydiv = document.getElementById('emptydiv');
var emptyRequestMsg = document.createElement('p');

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

// <Messenger> 모달 토글
function toggleModal() {
    
    var modal = document.getElementById('m-myModal');
    
    if (modal.style.display === 'block') {
        document.removeEventListener('click', closeModalOutside);
    } else {
        document.addEventListener('click', closeModalOutside);
    }
    
    modal.style.display = modal.style.display === 'block' ? 'none' : 'block';

    const lastActiveElementId = sessionStorage.getItem('lastActiveElementId');
    if (lastActiveElementId) {
        const lastActiveElement = document.getElementById(lastActiveElementId);
        if (lastActiveElement) {
            lastActiveElement.classList.add('tab-active');
        }
    }
    
    friendRequestList();
    friendSendList();
    friendList();
}

function closeModalOutside(event) {
    var modal = document.getElementById('m-myModal');
    let alarmModal = document.querySelector('.alarm-modal');
    var activeElements = document.querySelectorAll('.activee');

    for (var i = 0; i < activeElements.length; i++) {
        if (activeElements[i].contains(event.target) || modal.contains(event.target)) {
            return;
        }
    }

    for (var i = 0; i < activeElements.length; i++) {
        activeElements[i].classList.remove('activee');
    }

    alarmModal.classList.add('d-none');
    modal.style.display = 'none';
    document.removeEventListener('click', closeModalOutside);
}

window.onclick = function (event) {
    var modal = document.getElementById('m-myModal');
    if (event.target == modal) {
        closeModalOutside(event);
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
    friendList();
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
    event.preventDefault(); // submit 버튼 기본 동작 방지
    friendSendList()
    const receiverEmail = document.getElementById('receiver_email').value;

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
                messageContainer.innerHTML = data.message;
            } else {
                messageContainer.innerHTML = data.message;
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
// 엔터 키 입력 방지
inputdiv.addEventListener('keydown', function (event) {
    if (event.key === 'Enter' || event.keyCode === 13) {
        event.preventDefault();
    }
});
// -------------------------- 친구 요청 ----------------------------

// ------------------------ 친구 요청 목록 -------------------------

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
                emptyRequestMsg.classList.add('empty-msg-css');
                emptyRequestMsg.innerHTML = '요청 없음';
                emptydiv.appendChild(emptyRequestMsg);

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
                    emptyRequestMsg.classList.add('empty-msg-css');
                    emptyRequestMsg.innerHTML = '요청 없음';
                    emptydiv.appendChild(emptyRequestMsg);
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
                        // 성공 응답 받았을 때 처리
                        console.log('Success: Friend request rejected.', data);

                        var clickDivId = 'user_pk' + requestId; // 예시: div_123
                        var clickDiv = document.getElementById(clickDivId);

                        if (clickDiv) {
                            clickDiv.style.display = 'none';
                            clickDiv.classList.remove = 'messenger-user-div';
                            clickDiv.removeAttribute('id');
                        }
                    })
                    .catch(error => {
                        // 실패 응답 또는 네트워크 오류 발생 시 처리
                        console.error('Error:', error.message);
                    });
            });

            userDiv.appendChild(refusebtn);

            // 5. 수락 버튼 추가
            var acceptbtn = document.createElement('button');
            acceptbtn.classList.add('accept-btn');
            acceptbtn.setAttribute('value', friendRequestId);
            acceptbtn.textContent = '수락'

            acceptbtn.addEventListener('click', function () {
                friendList();
                var requestId = this.value;
                noticecount.innerHTML = noticecount.innerHTML - 1;

                if(noticecount.innerHTML==='0'){
                    emptydiv.style.display = 'block';
                    emptyRequestMsg.classList.add('empty-msg-css');
                    emptyRequestMsg.innerHTML = '요청 없음';
                    emptydiv.appendChild(emptyRequestMsg);
                }

                for (var i = 0; i < friendRequests.length; i++) {
                    var friendRequest = friendRequests[i];

                    // 친구 목록에 '추가된 유저' 표시
                    if(friendRequest.id == requestId) {
                        friendList();
                        var friendlistdiv = document.getElementById('friend-list-div');
                        var emptyfrienddiv = document.getElementById('emptyfrienddiv');
                    emptyfrienddiv.style.display = 'none';
                    var addfriendlistdiv = document.createElement('div');
                    friendlistdiv.appendChild(addfriendlistdiv);
                    addfriendlistdiv.classList.add('messenger-user-div');
                    addfriendlistdiv.id = 'user_pk'+ requestId;
    
                    // 0. div 생성
                    var adduserprofilediv = document.createElement('div');
                    adduserprofilediv.classList.add('user-profile');
    
                    addfriendlistdiv.appendChild(adduserprofilediv);
                    // 1. 이미지 추가
                    var adduserprofileImg = document.createElement('img');
                    adduserprofileImg.src = '/img/profile-img.png';
                    adduserprofileImg.classList.add('m-div-userprofile-icon');
    
                    adduserprofilediv.appendChild(adduserprofileImg);
    
                    // 2. 이름 추가
                    var addusername = document.createElement('p');
                    addusername.classList.add('user-name');
                    addusername.textContent = friendRequest.name;
        
                    addfriendlistdiv.appendChild(addusername);

                    // 3. 이메일 추가
                    var adduseremail = document.createElement('p');
                    adduseremail.classList.add('user-email-friend');
                    adduseremail.textContent = friendRequest.email;

                    addfriendlistdiv.appendChild(adduseremail);

                    // 4. 삭제 버튼 추가
                    var addfdeletebtn = document.createElement('button');
                    addfdeletebtn.classList.add('fdeletebtn');
                    addfdeletebtn.innerHTML = '삭제';
                    addfdeletebtn.value = requestId;
                    addfriendlistdiv.appendChild(addfdeletebtn);

                    addfriendlistdiv.addEventListener('click', function() {
                        toggleDeletePanel(this);
                    });
                
                    // 추가된 삭제버튼 클릭 시
                    addfdeletebtn.addEventListener('click', function() {
                        friendList();
                        friendList.length = friendList.length-1;
                        var deletefriendId = this.value;
                        var clickDivId = 'user_pk' + deletefriendId; 
                        var clickDiv = document.getElementById(clickDivId);

                        // AJAX 요청 수행
                        fetch('/friendDelete', {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                            body: JSON.stringify({ deletefriendId: deletefriendId }),
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Unable to delete friend.');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // 성공 응답 받았을 때 처리
                            if (clickDiv) {
                                clickDiv.style.left = '500px';
                                setTimeout(function() {
                                    clickDiv.style.opacity = '0';
                                    clickDiv.remove();
                                }, 500);
                                clickDiv.addEventListener('transitionend', function() {
                                    if (clickDiv.style.opacity !== '1') {
                                        clickDiv.style.display = 'none';
                                        clickDiv.classList.remove('messenger-user-div');
                                    }
                                }, { once: true });
                            }
                            console.log('Success: Friend delete.', data);
                        })
                        .catch(error => {
                            // 실패 응답 또는 네트워크 오류 발생 시 처리
                            console.error('Error:', error.message);
                        })
                    }); // 추가된 삭제 버튼 끝
                    }
                    else {
                            console.log('error')
                    }
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
                            specificDiv.classList.remove('messenger-user-div');
                            specificDiv.removeAttribute('id');
                        }
                    })
                    .catch(error => {
                        // 실패 응답 또는 네트워크 오류 발생 시 처리
                        console.error('Error:', error.message);
                    });
            });
            userDiv.appendChild(acceptbtn);
            // friendList();
        }
    } else {
        console.error('Element with id "friend-request-div" not found.');
    }
}
// ------------------------ 친구 요청 목록 끝 -----------------------

// ---------------------- 친구 요청 보낸 목록 -----------------------
var emptysenddiv = document.getElementById('emptysenddiv');
var emptysendMsg = document.createElement('p');
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
            if (friendSendlist.length === 0) {
                emptysendMsg.classList.add('empty-msg-css');
                emptysendMsg.innerHTML = '요청 없음';
                emptysenddiv.appendChild(emptysendMsg);
            // !0 :
            } else {
                // 친구 요청 보낸 목록 함수 실행
                // 메세지 출력 none
                emptysenddiv.style.display = 'none'; 
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
            var emptysenddiv = document.getElementById('emptysenddiv');
            
            requestcanclebtn.setAttribute('value', friendSendId);
            requestcanclebtn.textContent = '요청 취소'

            requestcanclebtn.addEventListener('click', function () {
            
            friendSendlist.length = friendSendlist.length-1
            var sendId = this.value;

            if(friendSendlist.length===0){
            emptysenddiv.style.display = 'block';
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
                            clickDiv.removeAttribute('id');
                        }
                    })
                    .catch(error => {
                        // 실패 응답 또는 네트워크 오류 발생 시 처리
                        console.error('Error:', error.message);
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
var emptyfrienddiv = document.getElementById('emptyfrienddiv');
var emptyfriendMsg = document.createElement('p');
// 모달이 열릴때 실행 되는 함수
function friendList() {

    // AJAX를 통해 친구 목록 가져오기
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
            var useUserId = data.useUserId;
            // 0 :
            if (friendList.length === 0) {
                // emptyfrienddiv.style.display = 'block';
                emptyfrienddiv.appendChild(emptyfriendMsg);
                emptyfriendMsg.innerHTML = '친구 목록 없음';
                emptyfriendMsg.classList.add('empty-msg-css');
                emptyfriendMsg.style.marginTop = '50px';

            // !0 :
            } else {
                // 친구 목록 표시 함수 실행
                displayFriendlist(friendList,useUserId);
                emptyfrienddiv.style.display = 'none';
            }
        })
        .catch(error => {
            // 오류 처리
            console.error('Fetch error:', error);
        });
}
const searchInput = document.getElementById('friendSearchInput');
const searchResults = document.getElementById('friend-list-div');

// 검색 결과를 출력하는 함수
function displayResults(results) {
    // 이전 결과 삭제
    searchResults.innerHTML = '';

    // 새로운 결과 출력
    results.forEach(result => {
        const listItem = document.createElement('div');
        listItem.classList.add('messenger-user-div');
        listItem.textContent = result.name;
        searchResults.appendChild(listItem);
    });
}
// 친구 목록 출력
function displayFriendlist(friendList, useUserId) {

    var friendlistdiv = document.getElementById('friend-list-div');
    var emptyfrienddiv = document.getElementById('emptyfrienddiv');
    var emptyfriendMsg = document.createElement('p');
    // 기존 내용 초기화
    friendlistdiv.innerHTML = '';
    
    // 친구 목록
    if (friendlistdiv) {
        for (var i = 0; i < friendList.length; i++) {
            var friendlistdata = friendList[i];

            var userDiv = document.createElement('div');

            // 동적으로 friendlistId를 설정
            var friendlistId = useUserId ? friendlistdata.user_id : friendlistdata.friend_id;

            userDiv.classList.add('messenger-user-div');
            userDiv.setAttribute('id', 'user_pk' + friendlistId);

            friendlistdiv.appendChild(userDiv);

            var userprofilediv = document.createElement('div');
            userprofilediv.classList.add('user-profile');
            userDiv.appendChild(userprofilediv);

            var userprofileImg = document.createElement('img');
            userprofileImg.src = '/img/profile-img.png';
            userprofileImg.classList.add('m-div-userprofile-icon');
            userprofilediv.appendChild(userprofileImg);

            var username = document.createElement('p');
            username.classList.add('user-name');
            username.textContent = friendlistdata.name;
            userDiv.appendChild(username);

            var useremail = document.createElement('p');
            useremail.classList.add('user-email-friend');
            useremail.textContent = friendlistdata.email;
            userDiv.appendChild(useremail);

            // 삭제 버튼 추가
            var fdeletebtn = document.createElement('button');
            fdeletebtn.classList.add('fdeletebtn');
            fdeletebtn.innerHTML = '삭제';
            fdeletebtn.value = useUserId ? friendlistdata.user_id : friendlistdata.friend_id;
            userDiv.appendChild(fdeletebtn);

            // 삭제 버튼 클릭시
            fdeletebtn.addEventListener('click', function () {

                friendList.length = friendList.length-1;
                var deletefriendId = this.value;

                if(friendList.length === 0) {
                    var friendlistdiv = document.getElementById('friend-list-div');
                    var emptyfrienddiv = document.getElementById('emptyfrienddiv');
                    var emptyfriendMsg = document.createElement('p');
                    emptyfrienddiv.style.display='block';
                    emptyfrienddiv.appendChild(emptyfriendMsg);
                    // emptyfriendMsg.classList.add('empty-msg-css');
                    // emptyfriendMsg.innerHTML = '친구 목록 없음';
                    // emptyfriendMsg.style.marginTop = '50px';
                }
                // AJAX 요청 수행
                fetch('/friendDelete', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ deletefriendId: deletefriendId }),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Unable to delete friend.');
                    }
                    return response.json();
                })
                .then(data => {
                    // 성공 응답 받았을 때 처리

                    var clickDivId = 'user_pk' + deletefriendId; 
                    var clickDiv = document.getElementById(clickDivId);

                    if (clickDiv) {
                        clickDiv.style.left = '500px';
                        setTimeout(function() {
                            clickDiv.style.opacity = '0';
                            clickDiv.remove();
                        }, 500);

                        clickDiv.addEventListener('transitionend', function() {
                            if (clickDiv.style.opacity !== '1') {
                                clickDiv.style.display = 'none';
                                clickDiv.classList.remove('messenger-user-div');
                            }
                        }, { once: true });
                    }
                    console.log('Success: Friend delete.', data);
                })
                .catch(error => {
                    // 실패 응답 또는 네트워크 오류 발생 시 처리
                    console.error('Error:', error.message);
                });
            })

            // 삭제 버튼 토글
            userDiv.addEventListener('click', function() {
                toggleDeletePanel(this);
            });
        }
    } else {
        console.error('Element with id "friend-request-div" not found.');
    }
    // 검색어 입력에 반응하는 이벤트 리스너
    searchInput.addEventListener('input', function() {

        // 현재 입력된 검색어 가져오기
        const searchTerm = searchInput.value.toLowerCase();
        console.log(searchTerm);
        // 모든 친구 엘리먼트를 숨김
        for (var i = 0; i < friendList.length; i++) {
            var friendlistId = useUserId ? friendList[i].user_id : friendList[i].friend_id;
            var userDiv = document.getElementById('user_pk' + friendlistId);
            if (userDiv) {
                userDiv.style.display = 'none';
            }
        }

        // 검색 결과에 해당하는 친구만 출력
        const filteredData = friendList.filter(item =>
            item.name.toLowerCase().includes(searchTerm) || 
            item.email.toLowerCase().includes(searchTerm)
        );
        for (var i = 0; i < filteredData.length; i++) {
            var friendlistId = useUserId ? filteredData[i].user_id : filteredData[i].friend_id;
            var userDiv = document.getElementById('user_pk' + friendlistId);
    
            // 요소가 존재하는 경우에만 스타일 조작
            if (userDiv) {
                userDiv.style.display = 'inline-block';
            }
        }
    });
}

// 삭제 토글 로직을 수행하는 함수
function toggleDeletePanel(userDiv) {
    var deleteBtn = userDiv.querySelector('.fdeletebtn');

    // 클래스를 토글
    deleteBtn.classList.toggle('visible');
    userDiv.classList.toggle('messenger-user-div-click');

    // 초기에는 숨겨둔 상태면 보이도록 처리
    if (deleteBtn.classList.contains('visible')) {
        deleteBtn.style.display = 'block';
    }
}
// ---------------------------- 친구 목록 끝----------------------------

// ----------------------- 240107 김관호 채팅 js 시작 -----------------------

// 현재 소켓의 ID를 가져옴 (dontBroadcastToCurrentUser / toOther 용)
// const socketId = Echo.socketId();

// 현 유저 id
let msg_now_user_id = null;

// 다 하고 맨 아래로 스크롤 함수
function chatUpdateScroll() {
    let ChatList = document.querySelectorAll('.chat-msg-box');
    if(ChatList.length !== 0){
        let lastChat = ChatList[ChatList.length-1];
        lastChat.scrollIntoView(false);
    }
}

// 채팅방에 리스트가 들어가면 이벤트 적용 with MutationObserver
function chatListCheck() {
    // 1. 주기적으로 감지할 대상 요소 선정
    const target = document.querySelector('.chat-layout');
    
    // 2. 옵저버 콜백 생성
    const callback = (mutationList, observer) => {
        // console.log(mutationList);
        // console.log(mutationList[0].addedNodes[0]);
        // mutationList[0].addedNodes[0].addEventListener('click', (event) => event.target.parentNode.style.display = 'none')
        mutationList.forEach((mutation, index) => {
            // if(mutation.type === 'childList') {
            if(mutation.addedNodes.length !== 0) {
                mutation.addedNodes.forEach((addedNode, index) => {
                    // console.log(addedNode);
                    addedNode.addEventListener('click', (event) => {
                        // console.log(addedNode.getAttribute('chat-room-id'));
                        let now_chat_id = addedNode.getAttribute('chat-room-id')
                        
                        // 클릭하면 채팅창이 켜지고 해당 채팅방의 id로 fetch
                        document.querySelector('.chat-layout').style.display = 'none';
                        document.querySelector('.chat-window').style.display = 'block';
                        // console.log(addedNode);
                        document.querySelector('.chat-window').setAttribute('chat-room-id',now_chat_id);

                        // 들어갈 때 input 초기화
                        let input = document.querySelector('#chatting-input');
                        input.value = '';
                        
                        // 채팅방 id를 불러서 최신내용 호출
                        fetch('/chat/'+ now_chat_id, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                // 'X-Socket-ID': socketId,
                            },
                            // body: JSON.stringify({ deletefriendId: deletefriendId }),
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('error with print chatting list.');
                            }
                            return response.json();
                        })
                        .then(data => {                            
                            // 성공 응답 받았을 때 처리
                            // console.log(data);   
                            msg_now_user_id = data.userId;

                            // 채팅 필드
                            let messageField = document.querySelector('.messages-field')

                            // 수신 받은 채팅내역을 필드에 출력
                            data['chatRecords'].forEach(msg => {
                                // console.log(msg);

                                // 채팅 박스
                                let chatMsgBox = document.createElement('div');
                                    chatMsgBox.className = 'chat-msg-box';
                                    chatMsgBox.setAttribute('chat-id',msg.id);

                                if(data['userId'] === msg.sender_id) {
                                    // 내가 쓴 채팅
                                    let chatContent = document.createElement('div');
                                    chatContent.className = 'chat-content';
                                    chatContent.classList.add('my-chat-content');
                                    chatContent.textContent = msg.content;
                                    // 채팅내역만 담기
                                    chatMsgBox.append(chatContent);
                                    messageField.append(chatMsgBox);
                                } else {
                                    // 송신 유저 아이콘
                                    let chatUserIcon = document.createElement('div');
                                    chatUserIcon.className = 'chat-user-icon';
                                    // 우측 묶음
                                    let chatUserIconAfter = document.createElement('div');
                                    chatUserIconAfter.className = 'chat-user-icon-after';
                                    // 송신 유저 이름
                                    let chatUserName = document.createElement('div');
                                    chatUserName.className = 'chat-user-name';
                                    chatUserName.textContent = msg.name;
                                    // 채팅 컨텐츠
                                    let chatContent = document.createElement('div');
                                    chatContent.className = 'chat-content';
                                    chatContent.textContent = msg.content;
                                    // 구조대로 담기
                                    chatUserIconAfter.append(chatUserName);
                                    chatUserIconAfter.append(chatContent);
                                    chatMsgBox.append(chatUserIcon);
                                    chatMsgBox.append(chatUserIconAfter);
                                    messageField.append(chatMsgBox);
                                }
                            })
                            // 다 하고 맨 아래로 스크롤
                            chatUpdateScroll();

                            // 채팅 읽음 처리 보내기
                            let postData = {
                                "now_chat_id": now_chat_id,
                            }
                            fetch('/chat-alarm', {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    // 'X-Socket-ID': socketId,
                                },
                                body: JSON.stringify(postData),
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('error with print chatting list.');
                                }
                                return response.json();
                            })
                            .then(data => {
                                // console.log(data);

                                // 채팅방 옆 숫자 지우기
                                let chatRoomList = document.querySelectorAll('.chat-room')
                                let chatNameList = document.querySelectorAll('.chat-name')
                                let totalAlarm = 0;
                                chatRoomList.forEach((chatRoom,index)=>{
                                    if(Number(chatRoom.getAttribute('chat-room-id')) === data.chat_room_id){
                                        chatNameList[index].removeAttribute('alarm-count')
                                    }
                                    // 채팅방 옆 숫자가 아무곳도 없으면 헤더/탭 아이콘 변경
                                    totalAlarm += Number(chatNameList[index].getAttribute('alarm-count'))
                                })
                                if(totalAlarm === 0) {
                                    let MsgIcons = document.querySelectorAll('.alarm-messenger');
                                    MsgIcons[0].classList.remove('has-new-chat');
                                    MsgIcons[1].classList.remove('has-new-chat');
                                }
                            })
                            .catch(error => {
                                console.log(error.stack);
                            });
                        })
                        .catch(error => {
                            console.log(error.stack);
                        });
                    })
                })
            }
            // console.log(mutation.type);
            // console.log(mutation.addNode);
        })
    };
    
    // 3. 옵저버 인스턴스 생성
    const observer = new MutationObserver(callback); // 타겟에 변화가 일어나면 콜백함수를 실행하게 된다.
    
    // 4. DOM의 어떤 부분을 감시할지를 옵션 설정
    const config = { 
        // attributes: true, // 속성 변화 할때 감지
        childList: true, // 자식노드 추가/제거 감지
        characterData: true // 데이터 변경전 내용 기록
    };
    
    // 5. 감지 시작
    observer.observe(target, config);
}

// 옵저버 실행
chatListCheck();

// 채팅 받기
window.Echo.private('chats')
    .listen('MessageSent', e => {
        // console.log(e);

        // 리슨한 메세지 출력
        // 채팅 박스
        let chatMsgBox = document.createElement('div');
        chatMsgBox.className = 'chat-msg-box';
        chatMsgBox.setAttribute('chat-id',e.message.id);

        // 채팅 필드
        let messageField = document.querySelector('.messages-field');
        
        // 같은 채팅방일 때 추가
        let chat_window = document.querySelector('.chat-window');
        let m_myModal = document.querySelector('#m-myModal')
        let tab_content = document.querySelector('.tab-content')
        let thisChatId = chat_window.getAttribute('chat-room-id');
        if(Number(thisChatId) === e.message.receiver_id){
            // 내 채팅 / 상대 채팅 분기
            if(e.message.sender_id === msg_now_user_id) {
            //     // 내가 쓴 채팅
            //     // let chatContent = document.createElement('div');
            //     // chatContent.className = 'chat-content';
            //     // chatContent.classList.add('my-chat-content');
            //     // chatContent.textContent = e.message.content;
            //     // // 채팅내역만 담기
            //     // chatMsgBox.append(chatContent);
            //     // messageField.append(chatMsgBox); // 자신이 보낸 채팅은 올리지 말기 (dontBroadcastToCurrentUser 대신용)
            } else {
                // 송신 유저 아이콘
                let chatUserIcon = document.createElement('div');
                chatUserIcon.className = 'chat-user-icon';
                // 우측 묶음
                let chatUserIconAfter = document.createElement('div');
                chatUserIconAfter.className = 'chat-user-icon-after';
                // 송신 유저 이름
                let chatUserName = document.createElement('div');
                chatUserName.className = 'chat-user-name';
                chatUserName.textContent = e.senderName;
                // 채팅 컨텐츠
                let chatContent = document.createElement('div');
                chatContent.className = 'chat-content';
                chatContent.textContent = e.message.content;
                // 구조대로 담기
                chatUserIconAfter.append(chatUserName);
                chatUserIconAfter.append(chatContent);
                chatMsgBox.append(chatUserIcon);
                chatMsgBox.append(chatUserIconAfter);
                messageField.append(chatMsgBox);

                // 연 상태로 받으면 바로 읽기 처리
                let now_chat_id = document.querySelector('.chat-window').getAttribute('chat-room-id')
                
                let postData = {
                    "now_chat_id": now_chat_id,
                }
                fetch('/chat-alarm', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        // 'X-Socket-ID': socketId,
                    },
                    body: JSON.stringify(postData),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('error with print chatting list.');
                    }
                    return response.json();
                })
                .then(data => {
                    // console.log(data);
                })
                .catch(error => {
                    console.log(error.stack);
                });
            }

        }
        // 이벤트 발생한 해당 채팅방이 띄워지지 않았을 때 알람발생
        if(
            m_myModal.style.display !== 'block' 
        || chat_window.style.display !== 'block' 
        || tab_content.style.display !== 'block'
        ){
            // console.log('채팅창이 안떠져 있다');
            // 어디채팅방에서 온 메세지인지 안에서 분기할까 결정
            fetch('/chat-alarm', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    // 'X-Socket-ID': socketId,
                },
                body: JSON.stringify(e),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('error with print chatting list.');
                }
                return response.json();
            })
            .then(data => {
                // console.log(data);
                // 채팅 올 때 알림 표시하기
                // console.log(data.message.receiver_id);
                let chatRooms = document.querySelectorAll('.chat-room')
                let chatNames = document.querySelectorAll('.chat-name')
                chatRooms.forEach((chatRoom,index) => {           
                    // console.log(chatRoom.getAttribute('chat-room-id'));
                    if(Number(chatRoom.getAttribute('chat-room-id')) === data.message.receiver_id){
                        let alarmCount = chatNames[index].getAttribute('alarm-count');
                        chatNames[index].setAttribute('alarm-count',Number(alarmCount === '' ? alarmCount = 0 : alarmCount)+1);
                    }
                })

                // 헤더/탭에도 알림표시
                let MsgIcons = document.querySelectorAll('.alarm-messenger');
                MsgIcons[0].classList.add('has-new-chat');
                MsgIcons[1].classList.add('has-new-chat');
            })
            .catch(error => {
                console.log(error.stack);
            });
        }

        // 채팅리스트 최신내역 갱신
        lastChatRefresh(e.message.receiver_id, e.message.content, e.message.created_at);

        // 다 하고 맨 아래로 스크롤
        chat_window.style.display === 'block' ? chatUpdateScroll() : '';
    })

// 채팅 알람 받기
window.Echo.private('chats')
    .listen('MessageCame', e => {
        // console.log(e);
        // .chat-name::after{
        //     content: attr(alarm-count); 여기에 이벤트 반환 값 넣기
    })

// 채팅방 입력창 버튼 이벤트
// 전송버튼
let send_chat = document.querySelector('.send-chat');
// 입력창
let input = document.querySelector('#chatting-input');

send_chat.addEventListener('click', () => {
    if(input.value.trim() !== ''){
        sendChat();
    }
});

// 엔터로 채팅보내기
input.addEventListener('keypress', (event) => {
    if (input.value.trim() !== '' && event.key === 'Enter') {
        sendChat();
    }
});

// 채팅보내기 모듈
function sendChat() {
    let chat_window = document.querySelector('.chat-window');

    // api 작성 통신
    let postData = {
        "content": input.value,
        "receiver_id": chat_window.getAttribute('chat-room-id'),
    }
    fetch('/chat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            // 'X-Socket-ID': socketId,
        },
        body: JSON.stringify(postData),
    })
        .then(response => {
            // 응답이 성공적인지 확인
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            // JSON 형식으로 변환하여 반환
            return response.json();
        })
        .then(data => {
            // console.log(data);

            let messageField = document.querySelector('.messages-field')
            // 채팅 박스
            let chatMsgBox = document.createElement('div');
            chatMsgBox.className = 'chat-msg-box';
            chatMsgBox.setAttribute('chat-id',data.sender_id);
            // 내가 쓴 채팅
            let chatContent = document.createElement('div');
            chatContent.className = 'chat-content';
            chatContent.classList.add('my-chat-content');
            chatContent.textContent = data.content;
            // 채팅내역만 담기
            chatMsgBox.append(chatContent);
            messageField.append(chatMsgBox);

            // 채팅창 초기화
            input.value = '';

            // 채팅리스트 최신내역 갱신
            lastChatRefresh(chat_window.getAttribute('chat-room-id'), data.content,data.last_chat_created_at);

            // 다 하고 맨 아래로 스크롤
            chatUpdateScroll();

            // 보내고 읽기 처리
            let now_chat_id = document.querySelector('.chat-window').getAttribute('chat-room-id')
                
            let postData = {
                "now_chat_id": now_chat_id,
            }
            fetch('/chat-alarm', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    // 'X-Socket-ID': socketId,
                },
                body: JSON.stringify(postData),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('error with print chatting list.');
                }
                return response.json();
            })
            .then(data => {
                // console.log(data);
            })
            .catch(error => {
                console.log(error.stack);
            });
        })
        .catch(error => {
            console.log(error.stack);
        });
}

// 채팅리스트 최신내역 갱신 함수
function lastChatRefresh(receiver, content, last_chat_time) {
    let chat_rooms = document.querySelectorAll('.chat-room');
    chat_rooms.forEach((chat_room,index) => {
        if(Number(chat_room.getAttribute('chat-room-id')) === receiver){ // chat_room.getAttribute('chat-room-id') typeof 하고 넣어야 할 때가 올 수 있다.
            document.querySelectorAll('.last-chat')[index].textContent = content;
            let GoodDateTime = formatDate(last_chat_time)
            document.querySelectorAll('.chat-time')[index].textContent = GoodDateTime;
        }
    })
}

// // 채팅방이 꺼지면 채팅내역 삭제
// function msgFieldCheck() {
//     // 1. 주기적으로 감지할 대상 요소 선정
//     const target = document.querySelector('.messages-field');
    
//     // 2. 옵저버 콜백 생성
//     const callback = (mutationList, observer) => {        
//         mutationList.forEach((mutation, index) => {
//             console.log(mutation);
//         })
//     };
    
//     // 3. 옵저버 인스턴스 생성
//     const observer = new MutationObserver(callback); // 타겟에 변화가 일어나면 콜백함수를 실행하게 된다.
    
//     // 4. DOM의 어떤 부분을 감시할지를 옵션 설정
//     const config = { 
//         attributes: true, // 속성 변화 할때 감지
//         // childList: true, // 자식노드 추가/제거 감지
//         characterData: true // 데이터 변경전 내용 기록
//     };
    
//     // 5. 감지 시작
//     observer.observe(target, config);
// }

// // 옵저버 실행
// msgFieldCheck();

// 뒤로가기 버튼 적용
document.querySelector('.chat-back').addEventListener('click',() => {
    // 채팅 필드 초기화
    let messageField = document.querySelector('.messages-field')
    while (messageField.hasChildNodes()) {
        messageField.removeChild(messageField.firstChild);
    } 
    document.querySelector('.chat-window').style.display = 'none';
    document.querySelector('.chat-layout').style.display = 'block';
})

// 화면 열 때 채팅리스트 불러오기
fetch('/chatlist', {
    method: 'GET',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
        // 'X-Socket-ID': socketId,
    },
    // body: JSON.stringify({ deletefriendId: deletefriendId }),
})
.then(response => {
    if (!response.ok) {
        throw new Error('error with print chatting list.');
    }
    return response.json();
})
.then(data => {
    // 성공 응답 받았을 때 처리
    // console.log(data);

    // 새로운 chat-layout 요소 생성
    // let chatLayout = document.createElement('div'); // blade->chatLayout 사용
    let chatLayout = document.querySelector('.chat-layout');
    chatLayout.className = 'chat-layout';
    
    data.myChatRooms.forEach((chatOne, index) => {
        // console.log(chatOne);

        // 새로운 chat-room 요소 생성
        let chatRoom = document.createElement('div');
        chatRoom.className = 'chat-room';
        chatRoom.setAttribute('chat-room-id', chatOne.chat_room_id);
        chatLayout.appendChild(chatRoom);
        
        // chat-icon 요소 생성 및 chat-room에 추가
        let chatIcon = document.createElement('div');
        chatIcon.className = 'chat-icon';
        Number(chatOne.flg) === 1 ? chatIcon.classList.add('group-chat-icon') : chatIcon.classList.add('private-chat-icon');
        chatRoom.appendChild(chatIcon);
        
        // chat-middle 요소 생성 및 chat-room에 추가
        let chatMiddle = document.createElement('div');
        chatMiddle.className = 'chat-middle';
        chatRoom.appendChild(chatMiddle);
        
        // chat-name 요소 생성, 속성 추가, chat-middle에 추가
        let chatName = document.createElement('div');
        chatName.className = 'chat-name';
        // 카운트 가져온 걸 속성에 추가 및 알람메신저아이콘으로 교체
        data.myChatCount.forEach(myCount => {
            if(myCount.chat_room_id === chatOne.chat_room_id){
                chatName.setAttribute('alarm-count', myCount.chat_count); // 속성 추가
                // 헤더 메신저 아이콘
                let MsgIcons = document.querySelectorAll('.alarm-messenger');
                MsgIcons[0].classList.add('has-new-chat');
                MsgIcons[1].classList.add('has-new-chat');
            }
        });
        chatName.textContent = chatOne.chat_room_name ? chatOne.chat_room_name : '';
        chatMiddle.appendChild(chatName);
        
        // last-chat 요소 생성, chat-middle에 추가
        let lastChat = document.createElement('div');
        lastChat.className = 'last-chat';
        lastChat.classList.add('chat-content');
        lastChat.textContent = chatOne.last_chat; // 길이조절
        chatMiddle.appendChild(lastChat);
        
        // chat-time 요소 생성 및 chat-room에 추가
        let chatTime = document.createElement('div');
        chatTime.className = 'chat-time';
        let GoodDateTime = formatDate(chatOne.last_chat_created_at)
        chatTime.textContent = GoodDateTime; // 텍스트 콘텐츠 추가 , 오늘/오늘이 아닌 날짜/시간 표기
        chatRoom.appendChild(chatTime);                
    })
    // document.querySelector('.tab-content').appendChild(chatLayout); // blade->chatLayout 사용
})
.catch(error => {
    console.log(error.stack);
});

// 날짜 출력기
function formatDate(inputDateTime) {
    const inputDate = new Date(inputDateTime);
    const currentDate = new Date();

    const isSameDay = inputDate.getDate() === currentDate.getDate() &&
                        inputDate.getMonth() === currentDate.getMonth() &&
                        inputDate.getFullYear() === currentDate.getFullYear();

    const isSameYear = inputDate.getFullYear() === currentDate.getFullYear();

    if (isSameDay) {
        const formattedTime = formatTime(inputDate.getHours(), inputDate.getMinutes());
        // console.log(`오늘 ${formattedTime}`);
        return formattedTime;
    } else if (isSameYear) {
        const formattedMonthDay = `${inputDate.getMonth() + 1}월 ${inputDate.getDate()}일`;
        // console.log(formattedMonthDay);
        return formattedMonthDay;
    } else {
        const formattedFullDate = `${inputDate.getFullYear()}.${(inputDate.getMonth() + 1).toString().padStart(2, '0')}.${inputDate.getDate().toString().padStart(2, '0')}`;
        // console.log(formattedFullDate);
        return formattedFullDate;
    }
}

function formatTime(hours, minutes) {
    const period = hours >= 12 ? '오후' : '오전';
    const formattedHours = (hours % 12 || 12).toString().padStart(2, '0');
    const formattedMinutes = minutes.toString().padStart(2, '0');
    return `${period} ${formattedHours}:${formattedMinutes}`;
}
  