@extends('layout')

@section('Title')
ToDo List - Clear Completed Tasks
@stop

@section('content')
    @include('partials/status')
    
    <section id="todos" class="todos">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>todos to be deleted</h2>
                        <hr class="star-primary">
                    </div>
                </div>
                <div class="row">
                     <div class="listContainer">
                        <?php $options['fast']=1; ?>
                        @foreach ($todos as $todo)
                            @include('pages.defaultTodoDisplay',['verbose'=>FALSE])
                        @endforeach
                        <div class="row">
                            @include('partials/clearCompleteButton')
                        </div>
                    </div>
                </div>
            </div>
    </section>
@stop
    
