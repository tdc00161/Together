<head>
    <link rel="stylesheet" href="/css/messenger.css">
</head>
<body>
    <div id="m-myModal" class="modal">
    <div class="modal-content">
        <span class="modal-close" onclick="closeModal()">&times;</span>
       <!-- 탭 목록 -->
<ul class="tabs">
    <li id="defaulttab" class="tab" onclick="openTab('tab1')"><img class="tab-icon" src="/img/icon-Subtract.png" alt=""></li>
    <li class="tab" onclick="openTab('tab2')"><img class="tab-icon" src="/img/icon-group.png" alt=""></li>
    {{-- <li class="tab" onclick="openTab('tab3')">탭 3</li>
    <li class="tab" onclick="openTab('tab4')">탭 4</li> --}}
</ul>

<!-- 탭 내용 -->
<div id="tab1" class="tab-content">
    <h3>탭 1 내용</h3>
    <p>이곳에 탭 1의 내용이 들어갑니다.</p>
</div>

<div id="tab2" class="tab-content">
    <h3>탭 2 내용</h3>
    <p>이곳에 탭 2의 내용이 들어갑니다.</p>
</div>

<div id="tab3" class="tab-content">
    <h3>탭 3 내용</h3>
    <p>이곳에 탭 3의 내용이 들어갑니다.</p>
</div>

<div id="tab4" class="tab-content">
    <h3>탭 4 내용</h3>
    <p>이곳에 탭 4의 내용이 들어갑니다.</p>
</div>
    </div>
</div>
<script src="/js/messenger.js"></script>
</body>