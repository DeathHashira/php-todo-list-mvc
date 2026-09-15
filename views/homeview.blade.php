<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>
        Home Page
    </title>
</head>

<body>
    <div>
        <form method="get" action="/todos/logout">
            <button type="submit" >Log Out</button>
        </form>
        <br>
        <form method="get" action="/todos/update">
            <input type="text" name="newtask">
            <button type="submit" >Update list</button>
        </form>
    </div>
    <br><br>

    @foreach ($todos as $todo)
        @if ($todo["status"])
            <span># {{ $todo["title"]}} - done </span>
            <form method="GET" action="/todos/delete">
                <input type="hidden" name="task_id" value={{$todo["id"]}}>
                <button type="submit">Delete</button>
            </form>
            <br><br>
        @else
            <span># {{ $todo["title"]}} - on progress </span>
            <form method="GET" action="/todos/delete">
                <input type="hidden" name="task_id" value={{$todo["id"]}}>
                <button type="submit">Delete</button>
            </form>
            <form method="GET" action="/todos/updatestatus">
                <input type="hidden" name="task_id" value={{$todo["id"]}}>
                <button type="submit">Update</button>
            </form>
            <br><br>
        @endif
    @endforeach
    
</body>
