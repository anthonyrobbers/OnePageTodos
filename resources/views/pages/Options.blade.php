@extends('layout')

@section('Title')
ToDo List Options - Show List {{$list['id']}}
@stop

@section('content')
    <section id="todos" class="{{$class}}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>Option List</h2>
                        <hr class="star-<?php if ($class=='success'){echo'light';}else{echo'primary';}?>">
                    </div>
                </div>

                <div class="row">
                    <div class="listContainer">
                        @foreach($Lists as $list)
                            @include('partials.defaultOptionListDisplay',['verbose'=>TRUE])
                        @endforeach
                    </div>
                </div>
            </div>
    </section>
@stop
    
