<form name="AddOptionList" id="AddTask" novalidate="" method="POST" action="{{action('optionListController@store')}}">
    <div class="row">
        <div class="listText col-sm-4 todos-item">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input id="new-group" name="new-group" placeholder="What group is this for?" autofocus="" class="">
            filter (2=all 1=complete 0=incomplete): 
            <input id="filter" name="filter" type="number" value="2" max="2" min="0">
            
        </div>
        <div class="listButton col-sm-4 todos-item">
              
        </div>
    </div>
    <div class="row">
        <div class="listText col-sm-4 todos-item">
            <input id="new-style" name="new-style" placeholder="What style should be used?" autofocus="" class="">
            verbosity (1=shows status 0=hides status): 
            <input id="verbosity" name="verbosity" type="number" value="1" max="1" min="0">
            
        </div>
        <div class="listButton col-sm-4 todos-item">
            <button type="submit" class="btn btn-success btn-sm">Add</button>    
        </div>
    </div>
    
</form>

