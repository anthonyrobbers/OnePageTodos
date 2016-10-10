<div class="listContainer">

    
        <div class="row">
            <div class="listText col-sm-4 todos-item">
                Current Version:   <a href="{{action('ListController@edit',['id'=>$todo['id']])}}" class="btn btn-success btn-sm">edit</a>
            </div>
            <div class="listButton col-sm-4 todos-item">
                DELETE
            </div>
        </div>
        <div class="row">
            <form name="deleteTask" id="updateTask" novalidate="" method="POST" action="{{action('ListController@destroy',['id'=>$todo['id']])}}"> {{ method_field('DELETE') }}
            <div class="listText col-sm-4 todos-item">
                {{$todo['task']}}
            </div>
            <div class="listButton col-sm-4 todos-item">
                <button name="del-todo" value="{{$todo['id']}}" type="submit" class="btn btn-success btn-sm">X</button>    
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </div>
            </form>
        </div>
</div>
    
