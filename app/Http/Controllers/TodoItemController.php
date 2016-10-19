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
        $oldTodo =session('oldTodo',NULL);
        
        return view('pages.list', 
            ['todos' => $todos, 'class' => $cssClass, 'msg'=>$msg, 'currentTodo'=>$currentTodo, 'oldTodo'=>$oldTodo]);
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
            
            return redirect('/')
                ->with(['msg'=> $msg,'oldTodo' => NULL, 'currentTodo'=>$newTodoItem,'class' => $cssClass]);
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
        
        if($active['group']==='INDEX'){
            // check for filled form entries
            //make a backup so it can be sent forward for later reversion
            $backup=['task'=>$active['task'],'priority'=>$active['priority'],'id'=>$active['id'],
                'complete'=>$active['complete']];
            // fill variables 
            $active->task=$request['new-todo'];
            $active->priority=$request['priority'];
            $active->save();
        }
        elseif ($active['task']==NULL) {
            try {
                $inputTodo = $request->input("new-todo");
                $inputPriority = $request->input("priority");
                $group = 'INDEX';
                $newTodoItem = new TodoItem(['task'=>$inputTodo, 'priority'=>$inputPriority, 'group'=>$group, 'complete'=>0]);
                $newTodoItem->Save();
                $cssClass = "success";
                $backup=NULL;
                $active=$newTodoItem;
            }

            catch (Illuminate\Database\QueryException $ex){
                $cssClass = NULL;
                $msg= 'new task failed to be created'.$ex;
                $active=NULL;
                $backup=['task'=>$request->input("new-todo"),'priority'=>$request->input("priority"),'id'=>$id,'complete'=>0];
            } 
            
        } 
        else {
            return redirect('/')
                ->with(['msg'=>'something went wrong updating an entry.','currentTodo'=>NULL, 'oldTodo'=>NULL]);
        }
        
        return redirect('/') 
            ->with(['msg'=>'An item has been changed. Item updated to: ', 'currentTodo'=>$active, 'oldTodo'=>$backup]);
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
        
        $active->delete();
        return redirect('/') 
            ->with(['msg'=>'A task has been deleted.', 'oldTodo'=>$active,'currentTodo'=>NULL]);
    }
    
    public function viewMvc() {
        // GET at /mvc/
        return view('pages.Mvc');
    }
    
    public function markAllComplete() {
        //PATCH at /complete
        
        return redirect('/') 
            ->with(['msg'=>'All tasks marked complete.', 'oldTodo'=>NULL,'currentTodo'=>NULL]);
    }
    
    public function toggleComplete($id) {
        //GET at /TodoItem/{id}/complete
        $active=TodoItem::find($id);
        if($active['complete']){
            $active->complete=FALSE;
        }
        else{
            $active->complete=TRUE;
        }
        $active->save();
        
        return redirect('/') 
            ->with(['msg'=>'A task was marked complete.', 'oldTodo'=>NULL,'currentTodo'=>NULL]);
        
    }
    
    public function undo(Request $request, $id) {
        //PATCH at /TodoItem/{id}/undo
        $active=TodoItem::find($id);
        
        if ($active['task']==NULL) {
            return redirect()->action('TodoItemController@store',['request'=>$request]);
        }
        else {
            return redirect()->action('TodoItemController@update',['id'=>$id,'request'=>$request]);
        }
        
        //final return to catch if the others do not redirect to the right controller
        return redirect('/') 
            ->with(['msg'=>'A task failed to be restored.', 'oldTodo'=>NULL,'currentTodo'=>NULL]);
        
    }
    
 }

