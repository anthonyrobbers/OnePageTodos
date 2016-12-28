<?php

namespace App\Http\Controllers;
// use DB;
use App\TodoItem;
use App\optionList;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
//use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

use App\Http\Requests;

class TodoItemController extends Controller
{
    //
    public function about() 
    {
        return view('welcome');
    }
    
    public function index()
    {
        // GET at /         or GET at /TodoItem
        Log::info('Hit index function of the TodoItem controller');
        $msg='';
        try{
            $options=optionList::find(1);
            if(null==$options) {
                $options= new optionList();
            }
            if(null==$options['group']) {
                $options['group']='INDEX';
            }
            if(null==$options['verbosity']) {
                $options['verbosity']=true;
            }
            if(null==$options['filter']) {
                $options['filter']=2;
            }
            if(null==$options['fast']) {
                $options['fast']=false;
            }
            if(null==$options['style']) {
                $options['style']='todos';
            }
            $options->Save();
            
           
            
            
            $groups=TodoItem::select('group')->distinct()->get();
             
        }
        catch(Illuminate\Database\QueryException $ex){
            $options=['group'=>'INDEX','verbosity'=>true,'filter'=>2,'fast'=>0];
            $groups=['INDEX'];
            $msg='database error.';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        try{
            $todos = TodoItem::where('group', $options['group'])->orderBy('priority', 'asc')->get();    
        }
        catch(Illuminate\Database\QueryException $ex){
            $msg='database error. failed to load list';
            $todos=[];
            Log::debug('failed to load list.'.$ex);
        }
        $cssClass = null;
        if($options['verbosity']) {
            Log::debug('status msg enabled by verbosity option');
            $statusPartial = session('statusPartial', 'defaultStatus');
            $statusArgs = session(
                'statusArgs', ['msg'=>$msg.session('msg', null),
                'currentTodo'=>session('currentTodo', null),'oldTodo'=>session('oldTodo', null)]
            );
            
            
            
        }
        else {
            Log::debug('status msg disabled by verbosity option');
            $statusPartial = null;
            $statusArgs = null;
        }
        //$filter=$options['filter']; filter 2 is all 0 and 1 only display matching completion.
        
        return view(
            'pages.list', 
            ['todos' => $todos, 'class' => $cssClass, 'statusArgs'=>$statusArgs, 
            'statusPartial'=>$statusPartial, 'options'=>$options]
        );
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
        
        $cssClass = null;
        return view(
            'pages.newItem', ['class' => $cssClass, 'msg'=>null, 'statusArgs'=>null, 
            'statusPartial'=>'defaultStatus']
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // POST to /        or POST to /TodoItem
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
            $options=['group'=>'INDEX','verbosity'=>true,'filter'=>2,'fast'=>0];
            $emergencyMsg='database error. loading default options instead of saved options';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        if(null!==($request->input("new-todo"))) {
            Log::debug('new todo detected');
            $inputTodos = [''];
            $statusPartial = null;  //should change to created later
        }
        if(null!==($request->input("new-todo-list"))) {
            Log::debug('new-todo-list detected:'.$request->input("new-todo-list").' or ');
            $inputTodos = explode(',',$request->input("new-todo-list"));
            Log::debug(':'.implode(' ',$inputTodos));
            $statusPartial = null; // should eventually be createdMany later
        }
        foreach($inputTodos as $inputTodo)    {
            try {
                Log::debug("new-todo".$inputTodo);
                $inputTask = $request->input("new-todo".$inputTodo);
                $inputPriority = 5;
                
                if(null!==($request->input("priority".$inputTodo))) {
                    $inputPriority = $request->input("priority".$inputTodo);
                }
                
                // TODO: validate input data here
                $group = $options['group'];
                if(null!==($request->input("group".$inputTodo))) {
                    $group =$request->input("group".$inputTodo);
                }
                $complete = 0;
                if(null!==($request->input("complete".$inputTodo))) {
                    $complete =$request->input("complete".$inputTodo);
                }
                Log::debug(implode(',', ['task'=>$inputTask, 'priority'=>$inputPriority, 'group'=>$group, 'complete'=>$complete]));
                $newTodoItem = new TodoItem(['task'=>$inputTask, 'priority'=>$inputPriority, 'group'=>$group, 'complete'=>$complete]);
                // TODO: add newTodoItem to the repository of todos (i.e., store in the database)   
                $newTodoItem->Save();
                $cssClass = "success";
                $msg = 'new task added';
            }

            catch (Illuminate\Database\QueryException $ex){

                $cssClass = null;
                $msg= 'new task failed to be created'.$ex;
                $newTodoItem=null;
                Log::debug('failed to create new task.  '.$ex);
            }  
        }
        if($request['ajax']) {
            Log::debug('ajax detected');
            if($newTodoItem!=null) {
                //{"id":2,"task":"test","priority":1,"group":"testing","complete":0},
                return response()->json(
                    ['id'=>$newTodoItem['id'],'task'=>$newTodoItem['task'],
                    'priority'=>$newTodoItem['priority'],'group'=>$newTodoItem['group'],
                    'complete'=>$newTodoItem['complete']]
                );
            }
            else {return;
            }
        }

        return redirect('/')
        ->with(
            ['msg'=> $msg,'oldTodo' => null, 'currentTodo'=>$newTodoItem,'class' => $cssClass,
            'statusPartial'=>$statusPartial]
        );
    }        
        
    

    /**
     * Display the specified resource.
     *
     * @param  int $id
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
            $options=['group'=>'INDEX','verbosity'=>true,'filter'=>2,'fast'=>0];
            $emergencyMsg='database error. loading default options instead of saved options';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        //needs to be modified to only show one
        $todo = TodoItem::find($id);
        $cssClass = 'todos';
        return view(
            'pages.showOne', ['todo'=>$todo, 'class' => $cssClass, 'msg'=>null, 'statusArgs'=>null, 
            'statusPartial'=>'defaultStatus', 'options'=>$options]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
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
            $options=['group'=>'INDEX','verbosity'=>true,'filter'=>2,'fast'=>0];
            $emergencyMsg='database error.  Failed to load saved options.  Loading defaults instead.';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        $todos = TodoItem::find($id);
        if($todos['group']===$options['group']) {
            Log::debug('active group detected');
            return view(
                'pages.edit', ['todo'=>$todos, 'class'=>'todos',
                'options'=>$options, 'msg'=>null, 'statusArgs'=>null, 
                'statusPartial'=>'defaultStatus']
            );
        }
        else {
            Log::debug('active group not detected');
            
            return redirect('/') 
            ->with(
                ['msg'=>'Task not found.', 
                'currentTodo'=>null, 'oldTodo'=>null]
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // PUT/PATCH /TodoItem/{id}
        Log::info('Hit update ('.$id.') function of the TodoItem controller');
        $active=TodoItem::find($id);
        try{
            $options=optionList::find(1);
            $emergencyMsg='';
        }
        catch(Illuminate\Database\QueryException $ex){
            $options=['group'=>'INDEX','verbosity'=>true,'filter'=>2,'fast'=>0];
            $emergencyMsg='options database error.';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        
        
        if($active['group']===$options['group']) {
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
        elseif ($active['task']==null) {
            Log::debug('active group not detected, active task is NULL');
            try {
                $inputTodo = $request->input("new-todo");
                $inputPriority = $request->input("priority");
                $group = $options['group'];
                $newTodoItem = new TodoItem(['task'=>$inputTodo, 'priority'=>$inputPriority, 'group'=>$group, 'complete'=>0]);
                $newTodoItem->Save();
                $cssClass = "success";
                $backup=null;
                $active=$newTodoItem;
            }

            catch (Illuminate\Database\QueryException $ex){
                Log::debug('catch statement'.$ex);
                $cssClass = null;
                $msg= 'new task failed to be created';
                $active=null;
                Log::debug($msg.$ex);
                $backup=['task'=>$request->input("new-todo"),'priority'=>$request->input("priority"),'id'=>$id,'complete'=>0];
            } 
            
        } 
        else {
            Log::debug('active group not detected, active task is not NULL.  Nothing should reach here.');
            if($request['ajax']) {
                Log::debug('ajax detected');
                return;
            }
            return redirect('/')
                ->with(
                    ['msg'=>'something went wrong updating an entry.','currentTodo'=>null, 
                    'oldTodo'=>null]
                );
        }
        if($request['ajax']) {
            Log::debug('ajax detected');
            return;
        }
        return redirect('/') 
            ->with(
                ['msg'=>'An item has been changed. Item updated to: ', 
                'currentTodo'=>$active, 'oldTodo'=>$backup]
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //DELETE /TodoItem/{id}
        Log::info('Hit destroy ('.$id.') function of the TodoItem controller');
        Log::debug($request);
        $active=TodoItem::find($id);
        
        $active->delete();
        if($request['ajax']) {
            Log::debug('ajax detected');
            return;
        }
        return redirect('/') 
            ->with(['msg'=>'A task has been deleted.', 'oldTodo'=>$active,'currentTodo'=>null]);
    }
    
    public function viewMvc() 
    {
        // GET at /mvc/
        Log::info('Hit viewMvc function of the TodoItem controller');
        return view('pages.Mvc');
    }
    
    public function markAllComplete(Request $request) 
    {
        //GET at /complete
        Log::info('Hit markAllComplete function of the TodoItem controller');
        try{
            $options=optionList::find(1);
            $emergencyMsg='';
            $todos = TodoItem::where('group', $options['group'])->orderBy('priority', 'asc')->get(); 
        }
        catch(Illuminate\Database\QueryException $ex){
            $options=['group'=>'INDEX','verbosity'=>true,'filter'=>2,'fast'=>0];
            $emergencyMsg='database error.'.$ex;
            $todos=[];
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        foreach($todos as $active){
            $active->complete=true;
            $active->save();
        }
        if($request['ajax']) {
            Log::debug('ajax detected');
            return;
        }
        return redirect('/') 
            ->with(['msg'=>'All tasks marked complete.', 'oldTodo'=>null,'currentTodo'=>null]);
    }
    
    public function toggleComplete($id, Request $request) 
    {
        //GET at /TodoItem/{id}/complete
        Log::info('Hit toggleComplete ('.$id.') function of the TodoItem controller');
        try{
            $active=TodoItem::findOrFail($id);
            if($active['complete']) {
                Log::debug('active complete detected');
                $active->complete=false;
                $msg='A task was marked as incomplete';
            }
            else{
                Log::debug('active complete not detected');
                $active->complete=true;
                $msg='A task was marked complete';
            }
            $active->save();

            if($request['ajax']) {
                Log::debug('ajax detected');
                return;
            }
            return redirect('/') 
                ->with(['msg'=>$msg, 'oldTodo'=>null,'currentTodo'=>null]);
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
            ->with(['msg'=>$msg, 'oldTodo'=>null,'currentTodo'=>null]);
        
        
    }
    
    public function undo(Request $request, $id) 
    {
        //PATCH at /TodoItem/{id}/undo
        Log::info('Hit undo ('.$id.') function of the TodoItem controller');
        $active=TodoItem::find($id);
        
        if ($active['task']==null) {
            Log::debug('active task not detected');
            return redirect()->action('TodoItemController@store', ['request'=>$request]);
        }
        else {
            Log::debug('active task detected');
            return redirect()->action('TodoItemController@update', ['id'=>$id,'request'=>$request]);
        }
        
        //final return to catch if the others do not redirect to the right controller
        return redirect('/') 
            ->with(['msg'=>'A task failed to be restored.', 'oldTodo'=>null,'currentTodo'=>null]);
        
    }
    
    public function toDelete($id)
    {
        
        // GET  /TodoItem/{id}/delete
        Log::info('Hit toDelete ('.$id.') function of the TodoItem controller');
        
        try{
            $options=optionList::find(1);
            $emergencyMsg=null;
        }
        catch(Illuminate\Database\QueryException $ex){
            $options=['group'=>'INDEX','verbosity'=>true,'filter'=>2,'fast'=>0];
            $emergencyMsg='database error.';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        $todos = TodoItem::find($id);
        if($todos['group']===$options['group']) {
            Log::debug('active group detected');
            $options['fast']=true;
            return view(
                'pages.preDelete', ['todo'=>$todos, 'class'=>'todos','options'=>$options, 'msg'=>$emergencyMsg, 'statusArgs'=>null, 
                'statusPartial'=>'defaultStatus']
            );
        }
        else {
            Log::debug('active group not detected');
            return redirect('/') 
            ->with(
                ['msg'=>'Task not found.'.$emergencyMsg, 
                'currentTodo'=>null, 'oldTodo'=>null]
            );          
        }
        
    }
    
    public function removeAllCompleted(string $group, Request $request)
    {
        // DELETE  /TodoItem/{group}/scour
        try{
            
            $todos = TodoItem::where([['group','=',$group],['complete','=',1]])->orderBy('priority', 'asc')->get();    
            
            foreach($todos as $active){
                $active->delete();
            }
            $msg='All complete tasks in '.$group.' deleted. ';
        }
        catch(Illuminate\Database\QueryException $ex){
            
            $msg='database error.';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        if($request['ajax']) {
                Log::debug('ajax detected');
                return;
        }
        return redirect('/') 
            ->with(['statusPartial'=>'removedAllCompleted', 'statusArgs'=>['msg'=>$msg,'removedTodos'=>$todos]]);
    }
    
    public function toRemoveAllCompleted(string $group)
    {
        // GET  /TodoItem/{group}/scour
        
        Log::info('Hit toRemoveAllCompleted '.$group.' function of the TodoItem controller');
        $msg='';
        try{
            $options=optionList::find(1);
            $groups=TodoItem::select('group')->distinct()->get();
            $todos = TodoItem::where([['group','=',$group],['complete','=',1]])->orderBy('priority', 'asc')->get();    
            
        }
        catch(Illuminate\Database\QueryException $ex){
            $options=['group'=>'INDEX','verbosity'=>true,'filter'=>2,'fast'=>0];
            $groups=['INDEX'];
            $todos=[];
            $msg='database error.';
            Log::debug('failed to load options.  loading defaults.'.$ex);
        }
        $cssClass = null;
        if($options['verbosity']) {
            Log::debug('status msg enabled by verbosity option');
            $statusPartial = session('statusPartial', 'partials/status/defaultStatus');
            $statusArgs = session(
                'statusArgs', ['msg'=>$msg.session('msg', null),
                'currentTodo'=>session('currentTodo', null),'oldTodo'=>session('oldTodo', null)]
            );
        }
        else {
            Log::debug('status msg disabled by verbosity option');
            $statusPartial = null;
            $statusArgs = null;
        }
        //$filter=$options['filter']; filter 2 is all 0 and 1 only display matching completion.
        
        
        return view(
            'pages/clearComplete', ['todos'=>$todos, 'options'=>$options, 'groups'=>$groups, 
            'statusPartial'=>$statusPartial, 'statusArgs'=>$statusArgs]
        );
    }
    
    
    public function ajaxSession(Request $request)
    {
        Log::info('Hit ajaxSession function of the TodoItem controller');
        Log::debug('the request is: '.$request);
        return response()->json(['token'=>csrf_token()]);
    }
}

