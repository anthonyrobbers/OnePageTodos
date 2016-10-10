@extends('layout')

@section('Title')
ToDo List - Show task {{$todo['id']}}
@stop

@section('content')
    <section id="todos" class="{{$class}}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>todo task</h2>
                        <hr class="star-<?php if ($class=='success'){echo'light';}else{echo'primary';}?>">
                    </div>
                </div>

                <div class="row">
                     @include('pages.showItem')
                </div>
            </div>
    </section>
@stop
    
