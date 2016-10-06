<?php

namespace App\Http\Controllers;
// use DB;
use App\laraveltodos;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Requests;

class ListController extends Controller
{
    //
    public function about() {
        return view('welcome');
    }
    
    public function index()
    {
        // GET at /
        $todos = laraveltodos::all();
        $cssClass = NULL;
        return view('pages.list', ['todos' => $todos, 'class' => $cssClass]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // GET  at /create  
        $todos = laraveltodos::all();
        $cssClass = NULL;
        return view('pages.list', ['todos' => $todos, 'class' => $cssClass]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // POST to /
        try {
            $inputTodo = $request->input("new-todo");
            $inputPriority = $request->input("priority");
            // TODO: validate input data here
            $newTodoItem = new laravelTodo($inputTodo, $inputPriority);
            // TODO: add newTodoItem to the repository of todos (i.e., store in the database)        
            $cssClass = "success";
        }
        
        catch (Illuminate\Database\QueryException $ex){
            
            $cssClass = NULL;
        }                
        $todos = laraveltodos::all();                           
        return view('pages.list', ['todos' => $todos, 'class' => $cssClass]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //GET //{id}
        //needs to be modified to only show one
        $todos = laraveltodos::all();
        return view('pages.list', compact('todos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // GET  /{id}/edit
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // PUT/PATCH /{id}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //DELETE /{id}
    }
    
 }

