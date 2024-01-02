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
    var activeElements = document.querySelectorAll('.activee');

    for (var i = 0; i < activeElements.length; i++) {
        if (activeElements[i].contains(event.target) || modal.contains(event.target)) {
            return;
        }
    }

    for (var i = 0; i < activeElements.length; i++) {
        activeElements[i].classList.remove('activee');
    }

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