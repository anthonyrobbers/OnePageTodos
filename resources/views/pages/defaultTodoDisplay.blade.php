@unless($todo==NULL)
    <div class="row">
        <div class="listText col-sm-4 todos-item">
            @if($todo['complete'])
            <a href="{{action('TodoItemController@toggleComplete',['id'=>$todo['id']])}}" class="glyphicon glyphicon-ok" aria-hidden="true"></a>
            @else
            <a href="{{action('TodoItemController@toggleComplete',['id'=>$todo['id']])}}" class="glyphicon glyphicon-unchecked" aria-hidden="true"></a>
            @endif
            <a href="{{action('TodoItemController@edit',['id'=>$todo['id']])}}">{{$todo['task']}}
            @if($verbose)
                Priority: {{$todo['priority']}}
            @endif
            </a>
        </div>
        <div class="listButton col-sm-4 todos-item">
            <form name="deleteTask" novalidate="" method="POST" action="{{action('TodoItemController@destroy',['id'=>$todo['id']])}}">
                {{ method_field('DELETE') }}
                <button  name="del-todo" value="{{$todo['id']}}" type="submit" class="btn btn-success btn-sm">
                    @if($verbose)
                    Delete
                    @else
                    X
                    @endif
                </button>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </form>
        </div>
    </div>
@endunless