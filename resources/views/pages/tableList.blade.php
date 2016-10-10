<div class="listContainer">
{!! view('pages/TodoForm') !!}
<form name="updateTask" id="updateTask" novalidate="" method="POST">
        @foreach ($todos as $todo)
        
            <div class="row">
                <div class="listText col-sm-4 todos-item">
                    {{$todo['task']}}
                </div>
                <div class="listButton col-sm-4 todos-item">
                    <a href="{{action('ListController@edit',['laraveltodo'=>$todo['id']])}}" class="btn btn-success btn-sm">X</a>
                    
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                </div>
            </div>
        
        @endforeach
        </form>
</div>
    
