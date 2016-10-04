    <ul><li>{!! view('pages/TodoForm') !!}</li>
        @foreach ($todos as $todo)
        <li>{{$todo}}</li>
        @endforeach
    </ul>  