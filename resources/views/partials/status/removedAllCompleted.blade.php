

<div class="listContainer">
    <div class="row">
        <div class="listText col-sm-4 todos-item">
        {{$msg}}
        
        </div>
        <div class="listButton col-sm-4 todos-item">
            <form name="updateTask" id="RestoreRemovedTodos" novalidate="" method="POST" action="<?php
                echo(action('TodoItemController@store',['id'=>$todo['id']]).'"> '. method_field('POST')); 
                $newTodoList=[];
                ?>
                @foreach($removedTodos as $removedTodo)
                    <?php array_push($newTodoList, $removedTodo['id']); ?>
                    <input type="hidden" name="new-todo{{$removedTodo['id']}}" value="{{$removedTodo['task']}}" >
                    <input type="hidden" name="priority{{$removedTodo['id']}}" value="{{$removedTodo['priority']}}">
                    <input type="hidden" name="complete{{$removedTodo['id']}}" value="{{$removedTodo['complete']}}" >
                    <input type="hidden" name="group{{$removedTodo['id']}}" value="{{$removedTodo['group']}}" >
                @endforeach
                    <button name="new-todo-list" type="submit" class="btn btn-success btn-sm" value="{{$newTodoList}}">Restore</button>  
                    <input type="hidden" name="_token" value="{{csrf_token()}}">

            </form>
        </div>

    </div>
    

</div>

