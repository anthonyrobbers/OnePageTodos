<?php

namespace App\Http\Controllers;
// use DB;
use App\TodoItem;


use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Requests;

class TodoItemController extends Controller
{
    //
    public function about() {
        return view('welcome');
    }
    
    public function index()
    {
        // GET at / 
        $todos = TodoItem::where('group','INDEX')->orderBy('priority','asc')->get();          
        $cssClass = NULL;
        $msg = session('msg',NULL);
        $currentTodo =session('currentTodo',NULL);
        $oldtodo =session('oldtodo',NULL);
        
        return view('pages.list', 
            ['todos' => $todos, 'class' => $cssClass, 'msg'=>$msg, 'currentTodo'=>$currentTodo, 'oldtodo'=>$oldtodo]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // GET  at /TodoItem/create  
        
        $cssClass = NULL;
        return view('pages.newItem', ['class' => $cssClass]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        // POST to /
        if(null!==($request->input("new-todo"))){
            try {
                $inputTodo = $request->input("new-todo");
                $inputPriority = $request->input("priority");
                // TODO: validate input data here
                $group = 'INDEX';
                $newTodoItem = new TodoItem(['task'=>$inputTodo, 'priority'=>$inputPriority, 'group'=>$group, 'complete'=>0]);
                // TODO: add newTodoItem to the repository of todos (i.e., store in the database)   
                $newTodoItem->Save();
                $cssClass = "success";
                $msg = 'new task added';
            }

            catch (Illuminate\Database\QueryException $ex){

                $cssClass = NULL;
                $msg= 'new task failed to be created'.$ex;
                $newTodoItem=NULL;
            }                
            
            return redirect('/'); 
                //->with(['msg'=> $msg,'oldtodo' => $newTodoItem, 'currentTodo'=>$newTodoItem,'class' => $cssClass]);
        }elseif(null!==($request->input("del-todo"))){
            
            
        }
    }        
        
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //GET /TodoItem/{id}
        //needs to be modified to only show one
        $todo = TodoItem::find($id);
        $cssClass = 'todos';
        return view('pages.showOne', ['todo'=>$todo, 'class' => $cssClass]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // GET  /TodoItem/{id}/edit
        
        $todos = TodoItem::find($id);
        if($todos['group']==='INDEX'){
        return view('pages.edit', ['todo'=>$todos, 'class'=>'success']);
        }
        else {
            return 'Task not found.';            
        }
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
        // PUT/PATCH /TodoItem/{id}
        $active=TodoItem::find($id);
        // check for filled form entries
        //make a backup so it can be sent forward for later reversion
        $backup=['task'=>$active['task'],'priority'=>$active['priority'],'id'=>$active['id']];
        // fill variables 
        $active->task=$request['new-todo'];
        $active->priority=$request['priority'];
        $active->save();
        
        return redirect('/') 
            ->with(['msg'=>'An item has been changed. Item updated to: ', 'currentTodo'=>$active, 'oldtodo'=>$backup]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //DELETE /TodoItem/{id}
        $active=TodoItem::find($id);
        $backup=['task'=>$active['task'],'priority'=>$active['priority'],'id'=>$active['id']];
        $active->delete();
        return redirect('/') 
            ->with(['msg'=>'you hit the destroy function task deleted.', 'oldtask'=>$backup,'currentTodo'=>$active]);
    }
    
    public function viewMvc() {
        // GET at /mvc/
        return view('pages.Mvc');
    }
    
    
 }

