@extends('layout')

@section('Title')
ToDo List Options - New Option Set
@stop

@section('content')
    <section id="todos" class="{{$class}}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>New Option List</h2>
                        <hr class="star-<?php if ($class=='success'){echo'light';}else{echo'primary';}?>">
                    </div>
                </div>

                <div class="row">
                     @include('partials.optionForm')
                </div>
            </div>
    </section>
@stop
    

