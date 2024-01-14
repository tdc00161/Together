const onOfflineCsrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// 온/오프라인 표시 js --------------------------------------------------------
// 온라인 표시 받기
window.Echo.private('chats')
    .listen('OnOffline', e => {
        // console.log(e);
        // console.log(e.user.id);
        // 비교해서 내 친구면 on 아니면 무시
        fetch('/online/'+e.user.id, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': onOfflineCsrfToken,
                // 'X-Socket-ID': socketId,
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('error with print chatting list.');
            }
            return response.json();
        })
        .then(data => {
            // console.log(data);
            if(Number(data) !== 0){
                let messengerUserDiv =  document.querySelectorAll('.messenger-user-div');
                let userProfile =  document.querySelectorAll('.user-profile');
                messengerUserDiv.forEach((mudOne,index) => {
                    // console.log(Number(mudOne.id.match(/\d+/)[0]));
                    // console.log(e.user.id);
                    if(Number(mudOne.id.match(/\d+/)[0]) === e.user.id){
                        userProfile[index].classList.add('online');
                    }
                })
            }
        })
        .catch(error => {
            console.log(error.stack);
        });
    })

// 오프라인 표시로 바꾸기
window.Echo.private('chats')
    .listen('onlyOffline', e => {
        // console.log(e);
        // console.log('offline');
        // 비교해서 내 친구면 on 아니면 무시
        fetch('/online/'+e.user.id, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': onOfflineCsrfToken,
                // 'X-Socket-ID': socketId,
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('error with print chatting list.');
            }
            return response.json();
        })
        .then(data => {
            // console.log(data);
            if(Number(data) !== 0){
                let messengerUserDiv =  document.querySelectorAll('.messenger-user-div');
                let userProfile =  document.querySelectorAll('.user-profile');
                messengerUserDiv.forEach((mudOne,index) => {
                    // console.log(Number(mudOne.id.match(/\d+/)[0]));
                    // console.log(e.user.id);
                    if(Number(mudOne.id.match(/\d+/)[0]) === e.user.id){
                        userProfile[index].classList.remove('online');
                    }
                })
            }
        })
        .catch(error => {
            console.log(error.stack);
        });
    });
// -------------------------------------------------------- 온/오프라인 표시 js