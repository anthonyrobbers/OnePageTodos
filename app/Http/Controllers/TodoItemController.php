<?php

namespace App\Http\Controllers;
// use DB;
use App\TodoItem;
use App\optionList;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

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
        Log::info('Hit index function of the TodoItem controller');
        $msg='';
        try{
            $options=optionList::find(1);
            $groups=TodoItem::select('group')->distinct()->get();
            $todos = TodoItem::where('group',$options['group'])->orderBy('priority','asc')->get();    
        }
        catch(Illuminate\Database\QueryException $ex){
            $options=['group'=>'INDEX','verbosity'=>TRUE,'filter'=>2,'fast'=>0];
            $groups=['INDEX'];
            $msg='database error.';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        try{
            $todos = TodoItem::where('group',$options['group'])->orderBy('priority','asc')->get();    
        }
        catch(Illuminate\Database\QueryException $ex){
            $msg='database error. failed to load list';
            $todos=[];
            Log::debug('failed to load list.'.$ex);
        }
        $cssClass = NULL;
        if($options['verbosity']){
            Log::debug('status msg enabled by verbosity option');
            $statusPartial = session('statusPartial','defaultStatus');
            $statusArgs = session('statusArgs',['msg'=>$msg.session('msg',NULL),
                'currentTodo'=>session('currentTodo',NULL),'oldTodo'=>session('oldTodo',NULL)]);
            
            
            
        }
        else {
            Log::debug('status msg disabled by verbosity option');
            $statusPartial = NULL;
            $statusArgs = NULL;
        }
        //$filter=$options['filter']; filter 2 is all 0 and 1 only display matching completion.
        
        return view('pages.list', 
            ['todos' => $todos, 'class' => $cssClass, 'statusArgs'=>$statusArgs, 
                'statusPartial'=>$statusPartial, 'options'=>$options]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // GET  at /TodoItem/create  
        Log::info('Hit create function of the TodoItem controller');
        
        $cssClass = NULL;
        return view('pages.newItem', ['class' => $cssClass, 'msg'=>NULL, 'statusArgs'=>NULL, 
                'statusPartial'=>'defaultStatus']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        // POST to /
        Log::info('Hit store function of the TodoItem controller');
        ob_start();
                var_dump($request->all());
                $content = ob_get_contents();
                ob_end_clean();
                Log::debug('The request: '.$content);
        try{
            $options=optionList::find(1);
            $emergencyMsg='';
        }
        catch(Illuminate\Database\QueryException $ex){
            $options=['group'=>'INDEX','verbosity'=>TRUE,'filter'=>2,'fast'=>0];
            $emergencyMsg='database error. loading default options instead of saved options';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        if(null!==($request->input("new-todo"))){
            Log::debug('new todo detected');
            $inputTodos = [''];
            $statusPartial = NULL;  //should change to created later
        }
        if(null!==($request->input("new-todo-list"))){
            Log::debug('new-todo-list detected');
            $inputTodos = $request->input("new-todo-list");
            Log::debug(':'.$inputTodos.' or ');
            $inputTodos = explode(',',$inputTodos);
            Log::debug(':'.implode(' ',$inputTodos));
            $statusPartial = NULL; // should eventually be createdMany later
        }
        foreach($inputTodos as $inputTodo)    {
            try {
                Log::debug("new-todo".$inputTodo);
                $inputTask = $request->input("new-todo".$inputTodo);
                $inputPriority = 5;
                
                if(null!==($request->input("priority".$inputTodo))){
                    $inputPriority = $request->input("priority".$inputTodo);
                }
                
                // TODO: validate input data here
                $group = $options['group'];
                if(null!==($request->input("group".$inputTodo))){
                    $group =$request->input("group".$inputTodo);
                }
                $complete = 0;
                if(null!==($request->input("complete".$inputTodo))){
                    $complete =$request->input("complete".$inputTodo);
                }
                Log::debug(implode(',',['task'=>$inputTask, 'priority'=>$inputPriority, 'group'=>$group, 'complete'=>$complete]));
                $newTodoItem = new TodoItem(['task'=>$inputTask, 'priority'=>$inputPriority, 'group'=>$group, 'complete'=>$complete]);
                // TODO: add newTodoItem to the repository of todos (i.e., store in the database)   
                $newTodoItem->Save();
                $cssClass = "success";
                $msg = 'new task added';
            }

            catch (Illuminate\Database\QueryException $ex){

                $cssClass = NULL;
                $msg= 'new task failed to be created'.$ex;
                $newTodoItem=NULL;
                Log::debug('failed to create new task.  '.$ex);
            }  
        }

        return redirect('/')
        ->with(['msg'=> $msg,'oldTodo' => NULL, 'currentTodo'=>$newTodoItem,'class' => $cssClass,
            'statusPartial'=>$statusPartial]);
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
        Log::info('Hit show ('.$id.') function of the TodoItem controller');
        try{
            $options=optionList::find(1);
            $emergencyMsg='';
        }
        catch(Illuminate\Database\QueryException $ex){
            $options=['group'=>'INDEX','verbosity'=>TRUE,'filter'=>2,'fast'=>0];
            $emergencyMsg='database error. loading default options instead of saved options';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        //needs to be modified to only show one
        $todo = TodoItem::find($id);
        $cssClass = 'todos';
        return view('pages.showOne', ['todo'=>$todo, 'class' => $cssClass, 'msg'=>NULL, 'statusArgs'=>NULL, 
                'statusPartial'=>'defaultStatus', 'options'=>$options]);
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
        Log::info('Hit edit ('.$id.') function of the TodoItem controller');
        try{
            $options=optionList::find(1);
            $emergencyMsg='';
        }
        catch(Illuminate\Database\QueryException $ex){
            $options=['group'=>'INDEX','verbosity'=>TRUE,'filter'=>2,'fast'=>0];
            $emergencyMsg='database error.  Failed to load saved options.  Loading defaults instead.';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        $todos = TodoItem::find($id);
        if($todos['group']===$options['group']){
            Log::debug('active group detected');
            return view('pages.edit', ['todo'=>$todos, 'class'=>'todos',
                'options'=>$options, 'msg'=>NULL, 'statusArgs'=>NULL, 
                'statusPartial'=>'defaultStatus']);
        }
        else {
            Log::debug('active group not detected');
            
            return redirect('/') 
            ->with(['msg'=>'Task not found.', 
                'currentTodo'=>NULL, 'oldTodo'=>NULL]);
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
        Log::info('Hit update ('.$id.') function of the TodoItem controller');
        $active=TodoItem::find($id);
        try{
            $active=TodoItem::find($id);
            $options=optionList::find(1);
            $emergencyMsg='';
        }
        catch(Illuminate\Database\QueryException $ex){
            $options=['group'=>'INDEX','verbosity'=>TRUE,'filter'=>2,'fast'=>0];
            $emergencyMsg='options database error.';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        
        
        if($active['group']===$options['group']){
            Log::debug('active group detected');
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
            Log::debug('active group not detected, active task is NULL');
            try {
                $inputTodo = $request->input("new-todo");
                $inputPriority = $request->input("priority");
                $group = $options['group'];
                $newTodoItem = new TodoItem(['task'=>$inputTodo, 'priority'=>$inputPriority, 'group'=>$group, 'complete'=>0]);
                $newTodoItem->Save();
                $cssClass = "success";
                $backup=NULL;
                $active=$newTodoItem;
            }

            catch (Illuminate\Database\QueryException $ex){
                Log::debug('catch statement'.$ex);
                $cssClass = NULL;
                $msg= 'new task failed to be created';
                $active=NULL;
                Log::debug('new task failed to be created'.$ex);
                $backup=['task'=>$request->input("new-todo"),'priority'=>$request->input("priority"),'id'=>$id,'complete'=>0];
            } 
            
        } 
        else {
            Log::debug('active group not detected, active task is not NULL.  Nothing should reach here.');
            return redirect('/')
                ->with(['msg'=>'something went wrong updating an entry.','currentTodo'=>NULL, 
                    'oldTodo'=>NULL]);
        }
        
        return redirect('/') 
            ->with(['msg'=>'An item has been changed. Item updated to: ', 
                'currentTodo'=>$active, 'oldTodo'=>$backup]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //DELETE /TodoItem/{id}
        Log::info('Hit destroy ('.$id.') function of the TodoItem controller');
        Log::debug($request);
        $active=TodoItem::find($id);
        
        $active->delete();
        if($request['ajax']){
            Log::debug('ajax detected');
            return;
        }
        return redirect('/') 
            ->with(['msg'=>'A task has been deleted.', 'oldTodo'=>$active,'currentTodo'=>NULL]);
    }
    
    public function viewMvc() {
        // GET at /mvc/
        Log::info('Hit viewMvc function of the TodoItem controller');
        return view('pages.Mvc');
    }
    
    public function markAllComplete() {
        //GET at /complete
        Log::info('Hit markAllComplete function of the TodoItem controller');
        try{
            $options=optionList::find(1);
            $emergencyMsg='';
            $todos = TodoItem::where('group',$options['group'])->orderBy('priority','asc')->get(); 
        }
        catch(Illuminate\Database\QueryException $ex){
            $options=['group'=>'INDEX','verbosity'=>TRUE,'filter'=>2,'fast'=>0];
            $emergencyMsg='database error.'.$ex;
            $todos=[];
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        
        foreach($todos as $active){
            $active->complete=TRUE;
            $active->save();
        }
        
        return redirect('/') 
            ->with(['msg'=>'All tasks marked complete.', 'oldTodo'=>NULL,'currentTodo'=>NULL]);
    }
    
    public function toggleComplete($id, Request $request) {
        //GET at /TodoItem/{id}/complete
        Log::info('Hit toggleComplete ('.$id.') function of the TodoItem controller');
        try{
            $active=TodoItem::findOrFail($id);
            if($active['complete']){
                Log::debug('active complete detected');
                $active->complete=FALSE;
                $msg='A task was marked as incomplete';
            }
            else{
                Log::debug('active complete not detected');
                $active->complete=TRUE;
                $msg='A task was marked complete';
            }
            $active->save();

            if($request['ajax']){
            Log::debug('ajax detected');
            return;
        }
            return redirect('/') 
                ->with(['msg'=>$msg, 'oldTodo'=>NULL,'currentTodo'=>NULL]);
        }
        catch(ModelNotFoundException $ex){
            $msg='database error.  Id '.$id.' not found.';
            Log::debug('not found TodoItem'.$id.$ex);
        }
        catch(Illuminate\Database\QueryException $ex){
            $msg='database error.';
            Log::debug('database error.'.$ex);
        }
        
        return redirect('/') 
            ->with(['msg'=>$msg, 'oldTodo'=>NULL,'currentTodo'=>NULL]);
        
        
    }
    
    public function undo(Request $request, $id) {
        //PATCH at /TodoItem/{id}/undo
        Log::info('Hit undo ('.$id.') function of the TodoItem controller');
        $active=TodoItem::find($id);
        
        if ($active['task']==NULL) {
            Log::debug('active task not detected');
            return redirect()->action('TodoItemController@store',['request'=>$request]);
        }
        else {
            Log::debug('active task detected');
            return redirect()->action('TodoItemController@update',['id'=>$id,'request'=>$request]);
        }
        
        //final return to catch if the others do not redirect to the right controller
        return redirect('/') 
            ->with(['msg'=>'A task failed to be restored.', 'oldTodo'=>NULL,'currentTodo'=>NULL]);
        
    }
    
    public function toDelete($id){
        
        // GET  /TodoItem/{id}/delete
        Log::info('Hit toDelete ('.$id.') function of the TodoItem controller');
        
        try{
            $options=optionList::find(1);
            $emergencyMsg=NULL;
        }
        catch(Illuminate\Database\QueryException $ex){
            $options=['group'=>'INDEX','verbosity'=>TRUE,'filter'=>2,'fast'=>0];
            $emergencyMsg='database error.';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        $todos = TodoItem::find($id);
        if($todos['group']===$options['group']){
            Log::debug('active group detected');
            $options['fast']=TRUE;
            return view('pages.preDelete', ['todo'=>$todos, 'class'=>'todos','options'=>$options, 'msg'=>$emergencyMsg, 'statusArgs'=>NULL, 
                'statusPartial'=>'defaultStatus']);
        }
        else {
            Log::debug('active group not detected');
            return redirect('/') 
            ->with(['msg'=>'Task not found.'.$emergencyMsg, 
                'currentTodo'=>NULL, 'oldTodo'=>NULL]);          
        }
        
    }
    
    public function removeAllCompleted(string $group){
        // DELETE  /TodoItem/{group}/scour
        try{
            
            $todos = TodoItem::where([['group','=',$group],['complete','=',1]])->orderBy('priority','asc')->get();    
            
            foreach($todos as $active){
                $active->delete();
            }
            $msg='All complete tasks in '.$group.' deleted. ';
        }
        catch(Illuminate\Database\QueryException $ex){
            
            $msg='database error.';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        
        return redirect('/') 
            ->with(['statusPartial'=>'removedAllCompleted', 'statusArgs'=>['msg'=>$msg,'removedTodos'=>$todos]]);
    }
    
    public function toRemoveAllCompleted(string $group){
        // GET  /TodoItem/{group}/scour
        
        Log::info('Hit toRemoveAllCompleted '.$group.' function of the TodoItem controller');
        $msg='';
        try{
            $options=optionList::find(1);
            $groups=TodoItem::select('group')->distinct()->get();
            $todos = TodoItem::where([['group','=',$group],['complete','=',1]])->orderBy('priority','asc')->get();    
            
        }
        catch(Illuminate\Database\QueryException $ex){
            $options=['group'=>'INDEX','verbosity'=>TRUE,'filter'=>2,'fast'=>0];
            $groups=['INDEX'];
            $todos=[];
            $msg='database error.';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        $cssClass = NULL;
        if($options['verbosity']){
            Log::debug('status msg enabled by verbosity option');
            $statusPartial = session('statusPartial','partials/status/defaultStatus');
            $statusArgs = session('statusArgs',['msg'=>$msg.session('msg',NULL),
                'currentTodo'=>session('currentTodo',NULL),'oldTodo'=>session('oldTodo',NULL)]);
        }
        else {
            Log::debug('status msg disabled by verbosity option');
            $statusPartial = NULL;
            $statusArgs = NULL;
        }
        //$filter=$options['filter']; filter 2 is all 0 and 1 only display matching completion.
        
        
        return view('pages/clearComplete',['todos'=>$todos, 'options'=>$options, 'groups'=>$groups, 
            'statusPartial'=>$statusPartial, 'statusArgs'=>$statusArgs]);
    }
    
 }

