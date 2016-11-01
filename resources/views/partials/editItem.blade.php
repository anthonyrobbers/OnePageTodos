<div class="listContainer">

    <div class="row">
        <form name="updateTask" id="updateTask" novalidate="" method="POST" action="{{action('TodoItemController@update',['id'=>$todo['id']])}}" >{{ method_field('PUT') }}
            <div class="listText col-sm-4 todos-item">            
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input id="new-todo" name="new-todo" value="{{$todo['task']}}" autofocus="" class="">
                <input id="priority" class="priority" name="priority" type="number" value="{{$todo['priority']}}">
            
            </div>
            <div class="listButton col-sm-4 todos-item">
                <button type="submit" class="btn btn-success btn-sm">Change</button>   
            </div> 
        </form>
    </div> 
    <div class="row">
        <div class="listText col-sm-4 todos-item">
            Old Version:
        </div>
        <div class="listButton col-sm-4 todos-item">

        </div>
    </div>
    @include('pages.defaultTodoDisplay',['verbose'=>TRUE])
</div>
    
