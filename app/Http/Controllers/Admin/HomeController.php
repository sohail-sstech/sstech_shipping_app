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
		//$total_store_count = User::select('count(users.id ) as storename','users')->where('role_id',3)->orderBy('id', 'desc')->get()->toArray();
		
		$User_Counts = User::select(array(
            User::raw('COUNT(*) as `count`'),
            User::raw(
            "COUNT(IF(role_id='1',1,null)
               
                ) AS 'SuperAdmin'"),
			User::raw(
            "COUNT(IF(role_id='2',1,null)
               
                ) AS 'CustomerService'"),
			User::raw(
            "COUNT(IF(role_id='3',1,null)) AS 'ShopifyAppUser'")				
				
         ))->get()->toArray();
		// print_r($User_Counts);exit;
        return view('admin/theme/home',array('User_Counts'=>$User_Counts[0]));
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
