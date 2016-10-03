@extends('layout')

@section('Title')
ToDo List
@stop

@section('content')
    {!! view('pages.SectionOpen',['id'=>'view','class'=>NULL]) !!}
    <ul><li>{!! view('pages/TodoForm') !!}</li>
        @foreach ($todos as $todo)
        <li>{{$todo}}</li>
        @endforeach
    </ul>
    
    
    {!! view('pages.SectionClose') !!}

    
    @stop
    
