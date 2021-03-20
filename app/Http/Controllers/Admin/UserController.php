<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;


use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user-role');
    }
	public function index()
    {
        return view('admin/user/view');
    }	
	public function preload_userlist(Request $request)
	{
		//$search_limit = "";
		//Start: Order by logic
		$order_by_field = 'users.id';
		$order_by_field_value = 'desc';
		$order_by_field_arr = [
								'0' => 'users.name',
								'1' => 'users.email',
								'2' => 'rolename',
								'3' => 'users.status',
								'4' => 'users.created_at',
								'5' => 'users.id',
							];
		if(isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
			$order_by_field = !empty($order_by_field_arr[$_POST['order'][0]['column']])?$order_by_field_arr[$_POST['order'][0]['column']]:$order_by_field;
			$order_by_field_value = !empty($_POST['order'][0]['dir'])?$_POST['order'][0]['dir']:$order_by_field_value;
		}
		
		$query_result = User::select('users.*','role.name as rolename')->leftJoin('roles as role', 'users.role_id', '=','role.id');
		if(!empty($_POST['user_name'])){
			$query_result = $query_result->where('users.name','like', '%' .$_POST['user_name']. '%');	
		}
		
		$query_result = $query_result->where('users.is_deleted',0);
		$query_result = $query_result->whereIn('role.id',[1,2]);
		
		$total_count = $query_result->count();
		
		$query_result = $query_result->take($_POST['length'])->skip(intval($_POST['start']))->orderBy($order_by_field, $order_by_field_value)->get()->toArray();
		
		if($query_result)
		{
		
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => $total_count,
					"iTotalDisplayRecords" => $total_count,
					"aaData" => array()
				);
			foreach($query_result as $cntdata)
			{
				
				if($cntdata['role_id']==1)
				{
					$rolename_cls = "admin";
				}
				else if($cntdata['role_id']==2)
				{
					$rolename_cls = "member";
				}
				$cntdata['rolename'] = "<span class='role $rolename_cls'>".$cntdata['rolename']."</span>";
				
				if($cntdata['status']==1)
				{
					$cntdata['status'] = "<span class='status--process'>Active</span>";
				}
				else{
					$cntdata['status'] = "<span class='status--denied'>Deactive</span>";
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
				$raw = array($cntdata['name'],$cntdata['email'],$cntdata['rolename'],$cntdata['status'],date('F d Y  h:i A',strtotime($cntdata['created_at'])),$cntdata['Action']);
				$output['aaData'][] = $raw;
			}
		}
		else
		{
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => '0',
					"iTotalDisplayRecords" => '0',
					"aaData" => array()
				);
		}
		return $output;
	}
	
	/*Insert view load for country master*/
	public function insert_view(){
		$role_list = Role::where('is_deleted',0)->whereIn('id',[1,2])->where('status',1)->get()->toArray();
		return view('admin.user.insert',array('rolelist' => $role_list));
	}
	
	/*Insert data for country master*/
	public function insert_data(Request $request)
	{
		$userExists = User::where('email', '=',$request->input('user_email'))->first();
		if ($userExists === null) {
			$insert_user = User::create(
			array(
			'name' => $request->input('user_name'),
			'email' => $request->input('user_email'),
			'role_id' => $request->input('user_role'),
			'password' => Hash::make($request->input('user_password'))
			));
			if($insert_user){
				return redirect('/admin/user')->with('message', 'You have successfully added user.');		
			}
			else{
				return redirect()->back()->with('message_failed', 'Something went wrong while adding user.');
			}
		}
		else{
			
			return redirect()->back()->with('message_failed', 'You should enter a unique email address and try again.');
		}
	}
	
	/*Country Form Edit Data function*/
	public function edit_data(Request $request,$id)
	{
		$role_list = Role::where('is_deleted',0)->whereIn('id',[1,2])->where('status',1)->get()->toArray();
		$edit_data = User::where('id',$id)->get()->toArray(); 
		return view('admin.user.edit')->with(array('usereditdata'=>$edit_data[0],'rolelist' => $role_list));	
	}
	/*Country Form Update Data function*/
	public function update_data(Request $request)
	{
		$useredit_id = $request->input('useredit_id');
		if(!empty($useredit_id))
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
				return redirect('/admin/user')->with('message', 'You have successfully updated user.');	
		}
		else{
			return redirect()->back()->with('message_failed', 'Something went wrong while adding user.');
		}			
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
