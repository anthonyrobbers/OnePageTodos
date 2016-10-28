@if($options['fast'])
    <form  name="ClearComplete" novalidate="" method="POST" action="{{action('TodoItemController@removeAllCompleted',['group'=>$options['group']])}}">
        {{ method_field('DELETE') }}
        <button id="clear-completed" name="ClearComplete" type="submit" class="btn btn-success btn-sm">Clear Completed</button>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
    </form>
@else
    <a  id="clear-completed" href="{{action('TodoItemController@toRemoveAllCompleted',['group'=>$options['group']])}}" class="btn btn-success btn-sm">Clear Completed</a>
@endif
  
  
