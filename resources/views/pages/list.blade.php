@extends('layout')

@section('Title')
ToDo List
@stop

@section('content')
    {!! view('pages.SectionOpen',['id'=>'view','class'=>NULL]) !!}
    
    
    
    {!! view('pages.SectionClose') !!}

    
    @stop
    
