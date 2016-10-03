<?php
namespace App\Http\Controllers;

use DB;
use App\infosection;

use Illuminate\Http\Request;

use App\Http\Requests;

class PagesController extends Controller
{
    public function home() {
        
        $todos = laravelTodos::all();
    
        return view('pages.list',compact('todos'));
    }
    
    public function about() {
        return view('welcome');
    }

}
