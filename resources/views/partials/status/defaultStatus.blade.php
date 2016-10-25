

<div class="listContainer">
    <div class="row">


         @if($options['verbosity']!=2)
         {{$msg}}
    </div>

    @include('pages.defaultTodoDisplay',['verbose'=>TRUE,'todo'=>$currentTodo])
    @unless($oldTodo['task']==NULL)
    <div class="row">
         The old version was:
    </div>
    @include('pages.undoTodoDisplay',['verbose'=>TRUE,'todo'=>$oldTodo])
    @endunless
    @else
      <div class="listText col-sm-4 todos-item">
        {{$msg}}
        @unless($oldTodo['task']==NULL)
            {{$oldTodo['task']}} 
        @endunless
            </div>
            @include('partials/undoShort',['todo'=>$oldTodo])

    </div>
    @endif

</div>

