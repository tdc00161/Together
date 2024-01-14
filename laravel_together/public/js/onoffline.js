const onOfflineCsrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// 온/오프라인 표시 js --------------------------------------------------------
// 온라인 표시 받기
window.Echo.private('chats')
    .listen('OnOffline', e => {
        // console.log(e);
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
            console.log(data);
        })
        .catch(error => {
            console.log(error.stack);
        });
    })
// -------------------------------------------------------- 온/오프라인 표시 js