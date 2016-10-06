@extends('layout')

@section('Title')
ToDo List
@stop

@section('content')
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
    
