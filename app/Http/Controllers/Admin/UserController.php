<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\User;
use App\Models\Admin\Role;


use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function index()
    {
        return view('admin/user/view');
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
					$cntdata['role_id'] = "<span class='role admin'>Super Admin</span>";
				}
				else if($cntdata['role_id']==2)
				{
					$cntdata['role_id'] = "<span class='role member'>Customer Service</span>";
				}
				else if($cntdata['role_id']==3)
				{
					$cntdata['role_id'] = "<span class='role user'>Shopify App User</span>";
				}
				if($cntdata['status']==1)
				{
					$cntdata['status'] = "<span class='status--process'>Active</span>";
				}
				else{
					$cntdata['status'] = "<span class='status--denied'>Deactive</span>";
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
				  <a href="#" data-id="'.$cntdata['id'].'" data-toggle="modal" data-target="#countryModalpopup" onclick=delete_data('.$cntdata['id'].',"admin/user/delete/","usergrid_dt") id="user_modaltest" class="item" data-placement="top">
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
		$role_list = Role::where('is_deleted',0)->where('status',1)->get()->toArray();
		return view('admin.user.insert',array('rolelist' => $role_list));
	}
	
	/*Insert data for country master*/
	public function insert_data(Request $request)
	{
		
		$userExists = User::where('email', '=',$request->input('user_email'))->first();
		if ($userExists === null) {
			User::create(
			array(
			'name' => $request->input('user_name'),
			'email' => $request->input('user_email'),
			'role_id' => $request->input('user_role'),
			'password' => Hash::make($request->input('user_password'))
			));
			return redirect('/admin/user')->with('message', 'Data inserted successfully.');	
		}
		else{
			return redirect()->back()->with('message_failed', 'This User already exist.Please try again.');
		}
	}
	
	/*Country Form Edit Data function*/
	public function edit_data(Request $request,$id)
	{
		$role_list = Role::where('is_deleted',0)->where('status',1)->get()->toArray();
		$edit_data = User::where('id',$id)->get()->toArray(); 
		return view('admin.user.edit')->with(array('usereditdata'=>$edit_data[0],'rolelist' => $role_list));	
	}
	/*Country Form Update Data function*/
	public function update_data(Request $request)
	{
		$useredit_id = $request->input('useredit_id');
			if(isset($useredit_id))
			{ 
				if(!empty($request->input('user_password')))
				{
					$update_user_array = array(
					   'name'=>$request->input('user_name'),
					   'email'=>$request->input('user_email'),
					   'role_id'=>$request->input('user_role'),
					   'password'=> Hash::make($request->input('user_password')),
					); 
				}
				else
				{
					$update_user_array = array(
					   'name'=>$request->input('user_name'),
					   'email'=>$request->input('user_email'),
					   'role_id'=>$request->input('user_role'),
					); 
				}
				User::where('id',$useredit_id)->update($update_user_array); 
			}
		return redirect('/admin/user')->with('message', 'User Data Update.');	
	}
	
	public function delete_data(Request $request,$id)
	{
		$delete_arr = array(
				'is_deleted'=>1
		);
		//DB::enableQueryLog();
		$delete = User::where('id',$id)->update($delete_arr); 
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
