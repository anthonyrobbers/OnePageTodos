<?php

namespace App\Http\Controllers;
// use DB;
use App\optionList;

use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Requests;

class optionListController extends Controller
{
    //
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // GET at /optionList 
        Log::info('Hit index function of the OptionList controller');
        $options=optionList::find(1);
        $lists = optionList::all;          
        $cssClass = NULL;
        if($options['verbosity']){
            Log::debug('status msg enabled by verbosity option');
            $msg = session('msg',NULL);
            $currentTodo =session('currentTodo',NULL);
            $oldTodo =session('oldTodo',NULL);
        }
        else {
            Log::debug('status msg disabled by verbosity option');
            $msg = NULL;
            $currentTodo = NULL;
            $oldTodo = NULL;
        }
        //$filter=$options['filter']; // filter 2 is all 0 and 1 only display matching completion.
        
        return view('pages.Options', 
            ['lists' => $lists, 'class' => $cssClass, 'msg'=>$msg, 'currentTodo'=>$currentTodo, 
                'oldTodo'=>$oldTodo, 'options'=>$options]);
    }
    
    public function create()
    {
        // GET  at /optionList/create  
        Log::info('Hit create function of the optionList controller');
        
        $cssClass = NULL;
        return view('pages.newOption', ['class' => $cssClass]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        // POST to /optionList
        Log::info('Hit store function of the optionList controller');
        
        try {
            if(null!==($request->input("new-group"))){
                $inputGroup = $request->input("new-group");
            }
            else {
                $inputGroup = 'INDEX';
            }
            if(null!==($request->input("filter"))){
                $inputFilter = $request->input("filter");
            }
            else {
                $inputFilter =2;
            }
            if(null!==($request->input("new-style"))){
                $inputStyle = $request->input("new-style");
            }
            else {
                $inputStyle = 'todos';
            }
            if(null!==($request->input("verbosity"))){
                $inputVerbosity = $request->input("verbosity");
            }
            else {
                $inputVerbosity = 1;
            }
            // TODO: validate input data here
            
            $newOptionList = new optionList(['group'=>$inputGroup, 'filter'=>$inputFilter, 
                'style'=>$inputStyle, 'verbosity'=>$inputVerbosity]);
            // TODO: add newTodoItem to the repository of todos (i.e., store in the database)   
            $newOptionList->Save();
            $cssClass = "success";
            $msg = 'new option list added';
        }

        catch (Illuminate\Database\QueryException $ex){
            Log::debug('an exception has been caught'.$ex);

            $cssClass = NULL;
            $msg= 'new option list failed to be created'.$ex;
            $newTodoItem=NULL;
        }                

        return redirect('/')
            ->with(['msg'=> $msg,'oldTodo' => NULL, 'currentTodo'=>NULL,'class' => $cssClass]);
        
    }        
        
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //GET /optionlist/{id}
        //needs to be modified to only show one
        Log::info('Hit show ('.$id.') function of the optionList controller');
        $optionList = optionList::find($id);
        $cssClass = 'todos';
        return view('pages.showOptionList', ['list'=>$optionList, 'class' => $cssClass]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // GET  /optionlist/{id}/edit
        Log::info('Hit edit ('.$id.') function of the optionList controller');
        
        $list = optionList::find($id);
        
        return view('pages.editOptions', ['list'=>$list, 'class'=>'success']);
        
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
        // PUT/PATCH /optionlist/{id}
        Log::info('Hit update ('.$id.') function of the optionList controller');
        $active=optionList::find($id);
        
        // check for filled form entries
        
        // fill variables 
        if(null!==($request->input("new-group"))){
            $active->group = $request->input("new-group");
        }
        if(null!==($request->input("filter"))){
            $active->filter = $request->input("filter");
        }
        if(null!==($request->input("style"))){
            $active->style = $request->input("new-style");
        }
        if(null!==($request->input("verbosity"))){
            $active->verbosity = $request->input("verbosity");
        }
        $active->save();
        
        
        return redirect('/') 
            ->with(['msg'=>'An option list has been changed. ', 
                'currentTodo'=>NULL, 'oldTodo'=>NULL]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //DELETE /optionlist/{id}
        Log::info('Hit destroy ('.$id.') function of the optionList controller');
        if($id!==1){
            Log::debug('active id 1 not detected');
            $active=  optionList::find($id);

            $active->delete();
            $msg='A list of options has been deleted.';
        }
        else {
            Log::debug('active id 1 detected');
            $msg='Deleting ID 1 is not allowed.  Edit it instead.';
        }
        return redirect('/') 
            ->with(['msg'=>$msg, 'oldTodo'=>NULL,'currentTodo'=>NULL]);
    }
    
    
    
 }

