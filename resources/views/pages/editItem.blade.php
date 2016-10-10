<div class="listContainer">
<form name="updateTask" id="updateTask" novalidate="" method="POST">
        <div class="row">
            <div class="listText col-sm-4 todos-item">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input id="new-todo" name="new-todo" value="{{$todo['task']}}" autofocus="" class="">
                <input id="priority" name="priority" type="number" value="{{$todo['priority']}}">
            </div>
            <div class="listButton col-sm-4 todos-item">
                <button type="submit" class="btn btn-success btn-sm">Change</button>   
            </div> 
        </div> 
        <div class="row">
            <div class="listText col-sm-4 todos-item">
                Old Version:
            </div>
            <div class="listButton col-sm-4 todos-item">
                DELETE
            </div>
        </div>
        <div class="row">
            <div class="listText col-sm-4 todos-item">
                {{$todo['task']}}
            </div>
            <div class="listButton col-sm-4 todos-item">
                <button name="del-todo" value="{{$todo['id']}}" type="submit" class="btn btn-success btn-sm">X</button>    
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </div>
        </div>
        
       
        </form>
</div>
    
