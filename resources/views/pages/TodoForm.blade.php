<form name="AddTask" id="AddTask" novalidate="" method="POST">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input id="new-todo" placeholder="What needs to be done?" autofocus="" class="">
    <input id="priority" type="number" name="priority" value="5">
    <button type="submit" class="btn btn-success btn-sm">Add</button>
    
</form>

