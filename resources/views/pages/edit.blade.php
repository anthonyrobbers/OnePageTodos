@extends('layout')

@section('Title')
ToDo List - Edit {{$todo['id']}}
@stop

@section('content')
    <section id="todos" class="{{$class}}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>todo task edit/delete</h2>
                        <hr class="star-<?php if ($class=='success'){echo'light';}else{echo'primary';}?>">
                    </div>
                </div>

                <div class="row">
                     @include('pages.editItem')
                </div>
            </div>
    </section>
@stop
    
