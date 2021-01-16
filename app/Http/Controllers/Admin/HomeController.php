<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
		
    }
	public function index()
    {
		
        return view('admin/theme/home');
        //return view('/admin/theme/home');
    }
	/*public function testmodalcall(){
		//First Way	
		 $post = User::all()->toArray();
         dd($post);
		 
		 //Second Way
		  $data = User::get(array('name'))->toArray(); // Or Main::all(['title']);
		  dd($data);
	}*/
}
