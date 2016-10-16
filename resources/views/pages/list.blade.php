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
                
                    @include('pages.defaultTodoDisplay',['verbose'=>TRUE,'todo'=>$currentTodo])
                    <div class="row">
                         The old version was:
                    </div>
                    @include('pages.undoTodoDisplay',['verbose'=>TRUE,'todo'=>$oldTodo])
                    
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
                     <div class="listContainer">
                        {!! view('pages/TodoForm') !!}

                        @foreach ($todos as $todo)
                            @include('pages.defaultTodoDisplay',['verbose'=>FALSE])
                        @endforeach

                    </div>
                </div>
            </div>
    </section>
@stop
    
