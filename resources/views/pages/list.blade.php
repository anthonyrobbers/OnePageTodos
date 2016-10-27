@extends('layout')

@section('Title')
ToDo List
@stop

@section('content')
    @include('partials/status')
    
    <section id="todos" class="{{$class}}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>todos</h2>
                        <hr class="star-<?php if ($class=='success'){echo'light';}else{echo'primary';}?>">
                    </div>
                </div>

                <div class="row">
                     <div id="todo-list" class="listContainer">
                        @include('pages/TodoForm')
                        <?php $activeCount=0;?>
                        @foreach ($todos as $todo)
                            @if($options['filter']==2 or $todo['complete']==$options['filter'])
                                @include('pages.defaultTodoDisplay',['verbose'=>FALSE])
                            @endif
                            <?php $activeCount+=1-$todo['complete']; ?>
                        @endforeach
                        @include('partials/filterButtons')
                        @include('partials/batchButtons')
                    </div>
                </div>
            </div>
    </section>
    
    
@stop

@section('scripts')
    @include('partials/scripts/todosApp')
@stop
