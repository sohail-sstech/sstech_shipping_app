<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Label;
use App\Models\Manifest;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('user-role');
    }
	public function index()
    {
		//$total_store_count = User::select('count(users.id ) as store_count','users')->where('role_id',3)->get()->toArray();
		$store_results = User::where('role_id',3)->get();
		$store_count = !empty($store_results) ? $store_results->count() : null;
		
		$return_label_results = Label::where('consignment_no','!=','')->get();
		$return_label_count = !empty($return_label_results) ? $return_label_results->count() : null;
		
		$manifest_results = Manifest::where('manifest_no','!=','')->get();
		$manifest_count = !empty($manifest_results) ? $manifest_results->count() : null;
		
		//echo '<pre>';print_r($label_count);exit;
		/*$User_Counts = User::select(array(
            User::raw('COUNT(*) as `count`'),
            User::raw(
            "COUNT(IF(role_id='1',1,null)
               
                ) AS 'SuperAdmin'"),
			User::raw(
            "COUNT(IF(role_id='2',1,null)
               
                ) AS 'CustomerService'"),
			User::raw(
            "COUNT(IF(role_id='3',1,null)) AS 'ShopifyAppUser'")				
				
         ))->get()->toArray();*/
		 
		// print_r($User_Counts);exit;
        return view('admin/theme/home',array('total_store'=>$store_count,'total_returnlabel'=>$return_label_count,'total_manifest'=>$manifest_count));
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
