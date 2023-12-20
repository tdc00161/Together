@extends('layout.layout')

<head>
    <link rel="stylesheet" href="/css/insert_detail.css">
	<script defer src="/js/insert_detail.js"></script>
</head>

<body>
    @section('main')
    <input class="now_user_name" type="hidden" value="{{$user->name}}">
    <button onclick="openTaskModal(0,1)">공지작성</button>
    <button onclick="openTaskModal(0,0)">업무추가</button>
    <button onclick="openTaskModal(1,1,312)">공지열람</button>
        @forelse ($data as $item)
            <p>
                프로젝트 명 : <span class="project_detail">{{$item->project_title}}</span>
            </p>
            @if (isset($item->depth_0))
            @forelse ($item->depth_0 as $task_0)
                <p>
                    ㄴ하위업무 이름 : <span class="task_detail" onclick="openTaskModal(1,0,{{$task_0->id}})">{{$task_0->title}}</span>
                </p>
                @if (isset($task_0->depth_1))
                @forelse ($task_0->depth_1 as $task_1)
                    <p>
                        ㄴㅡ하위업무 이름 : <span class="task_detail" onclick="openTaskModal(1,0,{{$task_1->id}})">{{$task_1->title}}</span>
                    </p>
                @empty
                @endforelse
                @endif                
            @empty
            @endforelse
            @endif
        @empty            
        @endforelse
    @include('modal.insert') {{-- include 순서 중요: 작성/상세 --}}
    @include('modal.detail')
    @endsection      
</body>