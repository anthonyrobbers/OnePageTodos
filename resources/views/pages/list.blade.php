@extends('layout')

@section('Title')
ToDo List
@stop

@section('content')
    {!! view('pages.Section',['id'=>'view','class'=>NULL],'content'=>view(pages.tableList, compact($todos))) !!}
@stop
    
