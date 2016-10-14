@extends('layout')

@section('Title')
ToDo List
@stop

@section('content')
    @if ($msg)
        <section id="todos" class="success">
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
                
                    <div class="row">
                        <form name="deleteTask" id="updateTask" novalidate="" method="POST" action="{{action('TodoItemController@destroy',['id'=>$currentTodo['id']])}}"> {{ method_field('DELETE') }}
                        <div class="listText col-sm-4 todos-item">
                            {{$currentTodo['task']}}  Priority: {{$currentTodo['priority']}}
                        </div>
                        <div class="listButton col-sm-4 todos-item">
                            <button name="del-todo" value="{{$currentTodo['id']}}" type="submit" class="btn btn-success btn-sm">Delete</button>    
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                        </div>
                        </form>
                    </div>
                    <div class="row">
                         The old version was:
                    </div>
                    <div class="row">
                        <form name="deleteTask" id="updateTask" novalidate="" method="POST" action="{{action('TodoItemController@update',['id'=>$oldtodo['id']])}}"> {{ method_field('PATCH') }}
                        <div class="listText col-sm-4 todos-item">
                            {{$oldtodo['task']}} Priority: {{$oldtodo['priority']}}
                        </div>
                        <div class="listButton col-sm-4 todos-item">
                            <button name="del-todo" value="{{$oldtodo['id']}}" type="submit" class="btn btn-success btn-sm">Restore</button>    
                            <input type="hidden" name="new-todo" value="{{$oldtodo['task']}}" >
                            <input type="hidden" name="priority" value="{{$oldtodo['priority']}}">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <section id="todos" class="{{$class}}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>todos</h2>
                        <hr class="star-<?php if ($class=='success'){echo'light';}else{echo'primary';}?>">
                    </div>
                </div>

                <div class="row">
                     @include('pages.tableList')
                </div>
            </div>
    </section>
@stop
    
