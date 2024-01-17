<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @forelse ($project_info as $item)
    <form action="{{ route('project.updateput', ['id' => $projectid]) }}" method="post">
    @csrf
    @method('PUT')
    <input name="project_title" type="text" value="{{$item->project_title}}">
    <textarea name="project_content" id="" cols="30" rows="10">{{$item->project_content}}</textarea>
    <input name="start_date" type="date" value="{{$item->start_date}}">
    <input name="end_date" type="date" value="{{$item->end_date}}">
    <button type="button" onclick="goBack()">취소</button>
    <button type="submit">확인</button>
    </form>
    @empty
        
    @endforelse
    <script src="/js/projectupdate.js"></script>
</body>
</html>