<div class="listButton col-sm-4 todos-item">
    <form name="updateTask" id="updateTask" novalidate="" method="POST" action="<?php
          
          if($currentTodo==NULL){
            echo(action('TodoItemController@store',['id'=>$todo['id']]).'"> '. method_field('POST')); 
          }
          else {
            echo(action('TodoItemController@update',['id'=>$todo['id']]).'"> '. method_field('PATCH'));
          } ?>
        
        <div class="listButton col-sm-4 todos-item">
            <button name="create-todo" value="{{$todo['id']}}" type="submit" class="btn btn-success btn-sm">Restore</button>    
            <input type="hidden" name="new-todo" value="{{$todo['task']}}" >
            <input type="hidden" name="priority" value="{{$todo['priority']}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        
    </form>
</div>
