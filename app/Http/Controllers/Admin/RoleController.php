<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function index()
    {
        return view('admin/role/view');
    }
	/*this is preload role grid*/
	public function preload_rolelist(Request $request)
	{
		$search_limit = "";
		$role_list_arr = Role::select('roles.*')->where('is_deleted',0)->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
		if($role_list_arr)
		{
			$record_total = Role::all();
			$total_count = $record_total->count();
			
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => $total_count,
					"iTotalDisplayRecords" => $total_count,
					"aaData" => array()
				);
			foreach($role_list_arr as $cntdata)
			{
				
				if($cntdata['status']==1)
				{
					$cntdata['status'] = "<span class='status--process'>Active</span>";
				}
				else
				{
					$cntdata['status'] = "<span class='status--denied'>Deactive</span>";
				}
				
				$cntdata['Action'] = '
				<div class="table-data-feature">
				   <a href="admin/role/edit/'.$cntdata['id'].'" class="item" data-toggle="tooltip" data-placement="top">
					<i class="zmdi zmdi-edit"></i>
				   </a>
				    <button type="button" onclick=get_row_detail('.$cntdata['id'].',"admin/role/getrowdata/") class="btn btn-secondary mb-1 item" data-placement="top">
					<i class="zmdi zmdi-eye"></i>
				   </button>
				</div>';
				$raw = array($cntdata['name'],$cntdata['description'],$cntdata['status'],date('F d Y  h:i A',strtotime($cntdata['created_at'])),$cntdata['Action']);
				$output['aaData'][] = $raw;
			}
		}
		return $output;
	}

	/*Country Form Edit Data function*/
	public function edit_data(Request $request,$id)
	{
		$edit_data = Role::where('id',$id)->get()->toArray(); 
		return view('admin.role.edit')->with('roleeditdata',$edit_data[0]);	
	}
	/*Country Form Update Data function*/
	public function update_data(Request $request)
	{
		$roleedit_id = $request->input('roleedit_id');
			if(isset($roleedit_id))
			{
				$update_country_array = array(
				   'name'=>$request->input('role_name'),
				   'description'=>$request->input('role_description')
				); 
				Role::where('id',$roleedit_id)->update($update_country_array); 
			}
		return redirect('/admin/role')->with('message', 'Role Data Update.');	
	}
	
	/*get single record data for modal popup*/
	public function get_single_row_data($id='')
	{
		if(isset($id))
		{
		
			$roles_details = Role::select('roles.*')->where('roles.id',$id)->get()->toArray();
			
			if(!empty($roles_details)){
				 $order_html = (string)view('admin.role.modal_view',array('All_RolesDetails' => $roles_details));
			}
			else{
				$order_html = 'Data Not Found';
			}
		}
		$array = array('details'=>$order_html,'title'=>'Role Details'); 
		echo json_encode($array);
	}
}
