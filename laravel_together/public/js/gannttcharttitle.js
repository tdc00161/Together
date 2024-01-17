function updateDateFormat(selectedDate) {
    const dateObject = new Date(selectedDate);
    const year = dateObject.getFullYear();
    const month = (dateObject.getMonth() + 1).toString().padStart(2, '0');
    const day = dateObject.getDate().toString().padStart(2, '0');
    
    const formattedDate = `${year}/${month}/${day}`;
    
    // var startDate = document.getElementById('start_date');
    document.getElementById('start_date').value = formattedDate;
  }
 
 
 // let OrginalendValue = document.getElementById('end_date').value;
 // let Orginalend = document.getElementById('end_date');
 
 
 // 프로젝트 명, 컨텐츠 업데이트 // 240101 전체 수정(catch 까지)
 const csrfToken_updateproject = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    function titleupdate(project_pk) {
 
       let Updatetitle = document.getElementById('project_title').value;
       let Updatecontent = document.getElementById('project_content').value;
       let Updatetitlemax = 17;
       let Updatecontentmax = 45;
 
       if(Updatetitle.length > Updatetitlemax){
          alert('텍스트 길이를 초과하였습니다.')
       }
       if(Updatecontent.length > Updatecontentmax){
          alert('텍스트 길이를 초과하였습니다.')
       }
       let Updatestart = document.getElementById('start_date').value;
       let Updateend = document.getElementById('end_date').value;
       let dday = document.getElementById("dday");
       today = new Date();
       start_day = new Date(document.getElementById("start_date").value); // 시작일자 가져오기
       console.log(start_day);
       end_day = new Date(document.getElementById("end_date").value); // 디데이(마감일자)
       // 시작일보다 마감일이 이전일 경우 DB에 저장하지 않고 에러띄우기 및 d-day 설정 지우기
       if(end_day < start_day) {
          dday.innerHTML = ''; // 240101 오타 수정
          alert('마감일자 입력을 다시 해주세요');
          return false;
       }
 
       gap = today - end_day;
       if(gap > 0) {
          dday.innerHTML = '';
          return false;
       }
       else if(gap === 0) {
          dday.innerHTML = D-day;
       }
       
       result = Math.floor(gap / (1000 * 60 * 60 * 24));
 
       dday.innerHTML = 'D' + result;
 
 
       // Fetch를 사용하여 서버에 put 요청 보내기
       fetch('/update/' +project_pk, {
             method: 'POST',
             headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken_project,
                // 필요에 따라 다른 헤더들 추가 가능
             },
             body: JSON.stringify({
                "Updatetitle": Updatetitle,
                "Updatecontent":Updatecontent,
                "Updatestart": Updatestart,
                "Updateend":Updateend,
             })
             // body: JSON.stringify({project_title: project_title})
       })
       .then((response) => {
          console.log(response);
          return response.json();
       })
       .then(data => {
          console.log(data);
             document.getElementsByClassId('project_title').value = data.project_title;
             document.getElementsByClassId('project_content').value = data.project_content;
             document.getElementsByClassId('start_date').value = data.start_date;
             document.getElementsByClassId('end_date').value = data.end_date;
       })
       .catch(error => {
             // 오류 처리
             console.error('error', error);
       });
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
 const csrfToken_project = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
 function deleteProject(project_pk) {
    
    fetch('/projectDelete/' + project_pk, {
       method: 'DELETE',
       // body : JSON.stringify(Id),
       headers: {
          "Content-Type": "application/json",
          'X-CSRF-TOKEN': csrfToken_project
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
 const csrfToken_project2 = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
 function exitProject(project_pk) {
 
    fetch('/projectExit/' + project_pk, {
       method: 'DELETE',
       // body : JSON.stringify(Id),
       headers: {
          "Content-Type": "application/json",
          'X-CSRF-TOKEN': csrfToken_project
       },
    }).then((response) => 
       console.log(response))
       // response.json()
      .then(() => {
          window.location.href = '/dashboard'; // 메인화면으로 이동
    }).catch(error => console.log(error));
 }

 