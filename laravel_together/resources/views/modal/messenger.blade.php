<head>
    <link rel="stylesheet" href="/css/messenger.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="m-myModal" class="m-modal">
    <div class="m-modal-content">
        <span class="m-modal-close" onclick="mcloseModal()"></span>
       <!-- 탭 목록 -->
<ul class="tabs">
    <li class="tab tab-active" onclick="openTab('tab1')">
    <svg class="tab-icon" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M38.0001 19C38.0001 29.4934 29.5176 38 19.0538 38C15.6649 38 12.4839 37.1077 9.73146 35.5447C9.56925 35.6649 9.36656 35.7382 9.13798 35.7382H1.00158C0.218787 35.7382 -0.260486 34.8794 0.150477 34.2132L3.15634 29.3402C1.22783 26.3645 0.107557 22.8134 0.107557 19C0.107557 8.50659 8.59009 0 19.0538 0C29.5176 0 38.0001 8.50659 38.0001 19ZM11.2028 20.8095C12.4485 20.8095 13.4583 19.7968 13.4583 18.5476C13.4583 17.2984 12.4485 16.2857 11.2028 16.2857C9.95712 16.2857 8.9473 17.2984 8.9473 18.5476C8.9473 19.7968 9.95712 20.8095 11.2028 20.8095ZM21.5782 18.5476C21.5782 19.7968 20.5684 20.8095 19.3227 20.8095C18.0771 20.8095 17.0672 19.7968 17.0672 18.5476C17.0672 17.2984 18.0771 16.2857 19.3227 16.2857C20.5684 16.2857 21.5782 17.2984 21.5782 18.5476ZM27.4427 20.8095C28.6884 20.8095 29.6982 19.7968 29.6982 18.5476C29.6982 17.2984 28.6884 16.2857 27.4427 16.2857C26.197 16.2857 25.1872 17.2984 25.1872 18.5476C25.1872 19.7968 26.197 20.8095 27.4427 20.8095Z" fill="white"/>
    </svg>
    </li>
    <li class="tab" onclick="openTab('tab2')">
    <svg class="tab-icon2" viewBox="0 0 39 34" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M20 7.5C20 11.6421 16.6421 15 12.5 15C8.35785 15 4.99999 11.6421 4.99999 7.5C4.99999 3.35786 8.35785 0 12.5 0C16.6421 0 20 3.35786 20 7.5ZM6.63211 15C4.80565 15.8559 1.98147 19.4247 1.02054 23C0 26.7971 0 28.144 0 28.9999V29C0 31 1.02063 33.5 4.59119 33.5H12.2437H12.7538H20.4079C23.9792 33.5 25 31 25 29V28.9999C25 28.144 25 26.7971 23.9793 23C23.0181 19.4247 20.1934 15.8559 18.3666 15C16.8382 16.9692 14.4886 17.4604 12.4988 17.4976C10.5093 17.4604 8.16027 16.9692 6.63211 15ZM23 7.5C23 9.46908 22.2412 11.2609 21 12.5991C22.3697 14.0758 24.3269 15 26.5 15C30.6421 15 34 11.6421 34 7.5C34 3.35786 30.6421 0 26.5 0C24.3269 0 22.3697 0.924178 21 2.40093C22.2412 3.73907 23 5.53092 23 7.5ZM26.2437 33.5H23.4079C26.9792 33.5 28 30.9999 28 28.9999C28 28.144 28 26.7971 26.9793 23C26.3974 20.8355 25.1326 18.6735 23.8196 17.1143C24.7165 17.3812 25.6411 17.4816 26.4988 17.4976C28.4887 17.4604 30.8382 16.9692 32.3666 15C34.1935 15.8559 37.0182 19.4247 37.9793 23C39 26.7971 39 28.1441 39 29C39 31 37.9792 33.5 34.4079 33.5H26.7538H26.2437Z" fill="white"/>
    </svg>
    </li>
    {{-- <li class="tab" onclick="openTab('tab3')">탭 3</li>
    <li class="tab" onclick="openTab('tab4')">탭 4</li> --}}
</ul>

<!-- 탭 내용 -->
<div id="tab1" class="tab-content">
    <div id="errordiv" class="empty-msg-css"> 3차 개발 예정 </div>
</div>
<div id="tab2" class="tab-content">
    

    {{-- 친구 검색 bar --}}
    <div class="friend-searchbar-div">
    <div class="friend-searchbar">
        <input type="search" class="f-search" placeholder="친구 검색"> 
    <button class="search-icon"><img src="/img/icon-search.png" alt=""></button>
    </div>
    {{-- 친구 추가 버튼 --}}
    <button class="add-button" type="button" onclick="openModal()">+</button>
    
  </div>

  <div class="accordion" id="accordionPanelsStayOpenExample">

    <div class="accordion-item bg-op100">
      <h2 class="accordion-header bg-op100" id="panelsStayOpen-headingOne">
        <button class="accordion-button bg-op100 padding-0 m-side-title-div " type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
            {{-- side title : 친구요청 --}}
            <p class="m-side-title">친구 요청</p><div id="noticecount" class="notice-count"></div>
        </button>
      </h2>
      <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
        <div class="accordion-body padding-0">
            <div id="emptydiv"></div> <!-- 친구요청 없을때 msg -->
            <div id="friend-request-div"> </div> <!-- 친구 요청 받은 목록 -->
        </div>
      </div>
    </div>

    <div class="accordion-item bg-op100">
      <h2 class="accordion-header bg-op100" id="panelsStayOpen-headingTwo">
        <button class="accordion-button bg-op100 padding-0 m-side-title-div" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
            <p class="m-side-title">내가 보낸 요청</p>
        </button>
      </h2>
      <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
        <div class="accordion-body padding-0">
            <div id="friend-send-div">
        </div>
      </div>
    </div>

    <div class="accordion-item bg-op100">
      <h2 class="accordion-header bg-op100" id="panelsStayOpen-headingThree">
        <button class="accordion-button bg-op100 padding-0 m-side-title-div" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
            {{-- side title : 현재활동중 --}}
            <p class="m-side-title">친구 목록</p>
        </button>
      </h2>
      <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingThree">
        <div class="accordion-body padding-0">
            <div id="friend-list-div"> </div> <!-- 친구 목록 -->
        </div>
      </div>
    </div>
  </div>

</div>
    </div>
</div>

{{-- 친구추가 모달 --}}
<div id="friend-Modal">
    <form id="friendRequestForm" action="{{ route('friend.sendFriendRequest') }}" method="post">
    @csrf
    <div class="friend-Modal-content">
        <div class="friend-Modal-header"><span class="f-r-modal-title">유저 이메일로 추가</span><button type="button" class="fclose-btn" onclick="fcloseModal()">&times;</button></div>
        <div class="friend-request-input-div">
            <input id="receiver_email" class="friend-request-input" type="email" name="receiver_email" autocomplete="off" placeholder="email로 추가">
            <button id="submitBtn" type="button" class="add-button">+</button>
    </div>
    <p class="request-message"></p>
    </div>
</form>
</div>

<script src="/js/messenger.js"></script>
</body>
