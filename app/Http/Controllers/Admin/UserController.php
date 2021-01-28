<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\User;
use App\Models\Admin\Role;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function index()
    {
        return view('admin/theme/user_view');
    }	
	public function preload_userlist(Request $request)
	{
		$search_limit = "";
		$username ='';
		if(isset($_POST['user_name']) && !empty($_POST['user_name'])){
			$username = $_POST['user_name'];
		}
		
		$user_list_arr = User::select('users.*')->where('name','like', '%' .$username. '%')->where('is_deleted',0)->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
	
		if($user_list_arr)
		{
			/*Query for to get total record count*/
			$record_total = User::where('name','like', '%' .$username. '%')->where('is_deleted',0)->get()->toArray();
			$total_count = count($record_total);
			
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => $total_count,
					"iTotalDisplayRecords" => $total_count,
					"aaData" => array()
				);
			foreach($user_list_arr as $cntdata)
			{
			
				if($cntdata['role_id']==1)
				{
					$cntdata['role_id'] = "Super Admin";
				}
				else if($cntdata['role_id']==2)
				{
					$cntdata['role_id'] = "Customer Service";
				}
				else if($cntdata['role_id']==3)
				{
					$cntdata['role_id'] = "Shopify App User";
				}
				if($cntdata['status']==1)
				{
					$cntdata['status'] = "Active";
				}
				else{
					$cntdata['status'] = "Deactive";
				}
				if($cntdata['is_deleted']==1)
				{
					$cntdata['is_deleted'] = "Yes";
				}
				else{
					$cntdata['is_deleted'] = "No";
				}
				$cntdata['Action'] = '
				<div class="table-data-feature">
				   <a href="admin/user/edit/'.$cntdata['id'].'" class="item" data-toggle="tooltip" data-placement="top">
					<i class="zmdi zmdi-edit"></i>
				   </a>
				  <a href="#" data-id="'.$cntdata['id'].'" data-toggle="modal" data-target="#countryModalpopup" id="country_modal" class="item" data-placement="top">
					<i class="zmdi zmdi-delete"></i>
				   </a>
				</div>';
				$raw = array($cntdata['name'],$cntdata['email'],$cntdata['role_id'],$cntdata['status'],$cntdata['is_deleted'],date('F d Y  h:i A',strtotime($cntdata['created_at'])),$cntdata['Action']);
				$output['aaData'][] = $raw;
			}
		}
		return $output;
	}
	
	/*Insert view load for country master*/
	public function insert_view(){
		//DB::enableQueryLog();
		$role_list = Role::where('is_deleted',0)->where('status',1)->get()->toArray();
		//$queries = DB::getQueryLog();
		//echo '<pre>';print_r($role_list);exit;
		
		return view('admin.theme.userinsert_view',array('rolelist' => $role_list));
		//return view('admin/theme/userinsert_view');
	}
	
	/*Insert data for country master*/
	public function insert_data(Request $request)
	{
		Country::create(
			array(
			'name' => $request->input('user_name'),
			'email' => $request->input('user_email'),
			'role_id' => $request->input('user_role')
			));
		return redirect('/admin/user')->with('message', 'Data inserted successfully.');	
	}
	
	/*Country Form Edit Data function*/
	public function edit_data(Request $request,$id)
	{
		$edit_data = Country::where('id',$id)->get()->toArray(); 
		return view('admin.theme.countryedit_view')->with('countryeditdata',$edit_data[0]);	
	}
	/*Country Form Update Data function*/
	public function update_data(Request $request)
	{
		$countryedit_id = $request->input('countryedit_id');
			if(isset($countryedit_id))
			{
				$update_country_array = array(
				   'name'=>$request->input('country_name'),
				   'iso'=>$request->input('country_shortname'),
				   'status'=>$request->input('country_status'),
				   'iso3'=>$request->input('country_iso'),
				   'phone_code'=>$request->input('country_code'),
				   'num_code'=>$request->input('country_numcode'),
				); 
				Country::where('id',$countryedit_id)->update($update_country_array); 
			}
		return redirect('/admin/country')->with('message', 'Country Data Update.');	
	}
	
	public function delete_data(Request $request,$id)
	{
		$delete_arr = array(
				'is_deleted'=>0
		);
		//DB::enableQueryLog();
		$delete = Country::where('id',$id)->update($delete_arr); 
		//$queries = DB::getQueryLog();
		//$delete = Country::where('id',$id)->delete();
		if($delete==1){
			$Response   = array(
            'success' => '1'
			);
		}
		else{
			$Response   = array(
            'success' => '0'
            );
		}
		return $Response;
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
