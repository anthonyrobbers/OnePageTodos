<?php

namespace App\Http\Controllers;
use DB;
use App\laraveltodos;

use Illuminate\Http\Request;

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
        return view('pages.list', compact('todos'));
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
        return view('pages.list', compact('todos'));
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
        $todos = laraveltodos::all();
        return view('pages.list', compact('todos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //GET /todos/{id}
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
        // GET  /todos/{id}/edit
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
        // PUT/PATCH /todos/{id}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //DELETE /todos/{id}
    }
    
 }

