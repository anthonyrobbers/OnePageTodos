@if ($msg)
        <section id="status" class="success">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>Status</h2>
                        <hr class="star-light">
                    </div>
                </div>

                <div class="listContainer">
                    <div class="row">
                         {{$msg}}
                    </div>
                
                    @include('pages.defaultTodoDisplay',['verbose'=>TRUE,'todo'=>$currentTodo])
                    @unless($oldTodo['task']==NULL)
                    <div class="row">
                         The old version was:
                    </div>
                    @include('pages.undoTodoDisplay',['verbose'=>TRUE,'todo'=>$oldTodo])
                    @endunless
                    
                </div>
            </div>
        </section>
    @endif