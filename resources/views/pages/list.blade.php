@extends('layout')

@section('Title')
ToDo List
@stop

@section('content')

    {!! view('pages.Section',['id'=>'todos','class'=>NULL,'content'=>view('pages.tableList', compact('todos'))]) !!}
@stop
    
