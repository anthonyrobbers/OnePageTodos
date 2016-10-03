<?php

namespace App\Http\Controllers;
use DB;
use App\laraveltodos;

use Illuminate\Http\Request;

use App\Http\Requests;

class ListController extends Controller
{
    //
    public function home() {
        $todos = laraveltodos::all();
        return view('pages.list', compact('todos'));
    }
    
    public function about() {
        return view('welcome');
    }
 }

