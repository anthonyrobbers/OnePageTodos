<form name="AddTask" id="AddTask" novalidate="" method="POST">
    <div class="row">
        <div class="listText col-sm-4 todos-item">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input id="new-todo" name="new-todo" placeholder="What needs to be done?" autofocus="" class="">
            <input id="priority" name="priority" type="number" value="5">
        </div>
        <div class="listButton col-sm-4 todos-item">
            <button type="submit" class="btn btn-success btn-sm">Add</button>    
        </div>
    </div>
</form>

