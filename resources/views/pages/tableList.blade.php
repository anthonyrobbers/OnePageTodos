<div class="listContainer">
    {!! view('pages/TodoForm') !!}

    @foreach ($todos as $todo)
        @include('pages.defaultTodoDisplay')
    @endforeach
        
</div>
    
