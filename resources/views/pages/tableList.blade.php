<div class="listContainer">
    @include('pages/TodoForm')

    @foreach ($todos as $todo)
        @include('pages.defaultTodoDisplay')
    @endforeach
        
</div>
    
