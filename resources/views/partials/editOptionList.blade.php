<div class="listContainer">
    <form name="UpdateOptionList" id="UpdateOptionList" novalidate="" method="POST" action="{{action('optionListController@update',$list['id'])}}">{{ method_field('PUT') }}
        <div class="row">
            <div class="listText col-sm-4 todos-item">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input id="new-group" name="new-group" value="{{$list['group']}}" autofocus="" class="">
                filter (2=all 1=complete 0=incomplete): 
                <input id="filter" name="filter" type="number" value="{{$list['filter']}}" max="2" min="0">

            </div>
            <div class="listButton col-sm-4 todos-item">

            </div>
        </div>
        <div class="row">
            <div class="listText col-sm-4 todos-item">
                <input id="new-style" name="new-style" value="{{$list['style']}}" autofocus="" class="">
                verbosity (1=shows status 0=hides status): 
                <input id="verbosity" name="verbosity" type="number" value="{{$list['verbosity']}}" max="1" min="0">

            </div>
            <div class="listButton col-sm-4 todos-item">
                <button type="submit" class="btn btn-success btn-sm">Change</button>    
            </div>
        </div>

    </form>
    <div class="row">
        <div class="listText col-sm-4 todos-item">
            Old Version:
        </div>
        <div class="listButton col-sm-4 todos-item">

        </div>
    </div>
    <div class="row">
        @include('partials/defaultOptionListDisplay',['verbose'=>TRUE])
    </div>
</div>

    
