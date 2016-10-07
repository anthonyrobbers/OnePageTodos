<div class="listContainer">
{!! view('pages/TodoForm') !!}
        <form name="updateTask" id="updateTask" novalidate="" method="POST" {{ method_field('DELETE') }}
        @foreach ($todos as $todo)
        
            <div class="row">
                <div class="listText col-sm-4 todos-item">
                    {{$todo['task']}}
                </div>
                <div class="listButton col-sm-4 todos-item">
                    <button name="del-todo" value="{{$todo['id']}}" type="submit" class="btn btn-success btn-sm">X</button>    
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                </div>
            </div>
        
        @endforeach
        </form>
</div>
    
