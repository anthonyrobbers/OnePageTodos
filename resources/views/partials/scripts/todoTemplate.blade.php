<script id="todo-template" type="text/x-handlebars-template">
    
        
            <div class="row todo-item" data-id="@{{id}}" data-complete="@{{complete}}" 
                     data-priority="@{{priority}}" >

                    <div class="listText col-sm-4 todos-item">
                        @{{#if complete}}
                        <a href="@{{homeUrl}}/TodoItem/@{{id}}/complete" class="glyphicon glyphicon-ok" aria-hidden="true"></a>
                        @{{else}} 
                        <a href="@{{homeUrl}}/TodoItem/@{{id}}/complete" class="glyphicon glyphicon-unchecked" aria-hidden="true"></a>
                        @{{/if}}  
                        <a href="@{{homeUrl}}/TodoItem/@{{id}}/edit">@{{task}}
                        @if($verbose)
                            Priority: @{{priority}}
                        @endif
                        </a>
                    </div>
                    <div class="listButton col-sm-4 todos-item">
                        @if($options['fast'])
                            <form name="deleteTask" novalidate="" method="POST" action="@{{homeUrl}}/TodoItem/@{{id}}">
                                {{ method_field('DELETE') }}
                                <button  name="del-todo" value="@{{id}}" type="submit" class="btn btn-success btn-sm destroy">
                                    @if($verbose)
                                    Delete
                                    @else
                                    X
                                    @endif
                                </button>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                            </form>
                        @else
                            <a  href="@{{homeUrl}}/TodoItem/@{{id}}/delete'}}" class="btn btn-success btn-sm destroy">
                                    @if($verbose)
                                    Delete
                                    @else
                                    X
                                    @endif
                            </a>
                        @endif
                    </div>
                </div>
            
    
</script>