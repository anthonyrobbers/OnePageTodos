@unless($list==NULL)
    <div class="row">
        <div class="listText col-sm-4 todos-item">
            
            <a href="{{action('optionListController@edit',['id'=>$list['id']])}}">{{$list['group']}}
            Filter: {{$list['filter']}} Verbosity: {{$list['verbosity']}} Style: {{$list['style']}}</a>
        </div>
        <div class="listButton col-sm-4 todos-item">
            <form name="deleteTask" novalidate="" method="POST" action="{{action('optionListController@destroy',['id'=>$list['id']])}}">
                {{ method_field('DELETE') }}
                <button  name="del-list" value="{{$list['id']}}" type="submit" class="btn btn-success btn-sm">
                    @if($verbose)
                    Delete
                    @else
                    X
                    @endif
                </button>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
            </form>
        </div>
    </div>
@endunless
