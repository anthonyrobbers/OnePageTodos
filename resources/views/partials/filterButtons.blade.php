<div class="btn-group">
    <form name="change-filter" id="change-filter" method="POST" action="{{action('optionListController@update',['id'=>1])}}" >
      {{ method_field('PUT') }}
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <button type="button" class="btn btn-secondary btn-sm">Filters:</button>
      <button type="submit" name="filter" value="2" id="filter-all" class="btn btn-success btn-sm <?php 
        if($options['filter']==2){
            echo('active');
        }
        ?> filter"> All
      </button>
      <button type="submit" name="filter" value="1" id="filter-complete" class="btn btn-success btn-sm <?php 
        if($options['filter']==1){
            echo('active');
        }
        ?> filter"> Complete
      </button>
      <button type="submit" name="filter" value="0" id="filter-active" class="btn btn-success btn-sm <?php 
        if($options['filter']==0){
            echo('active');
        }
        ?> filter"> Active
      </button>
      <button type="button" class="btn btn-secondary btn-sm">{{$activeCount}} Active Tasks</button>
    </form>
  </div>
  
  
