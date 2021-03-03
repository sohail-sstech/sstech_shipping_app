<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function index()
    {
        return view('admin/store/view');
    }	
	public function preload_storelist(Request $request)
	{
		$query_result = User::select('*');
		if(!empty($_POST['store_name']))
		{
			$query_result->where(function($query)
			{
				$query->where('name','like', '%' .$_POST['store_name']. '%')->orWhere('email', 'like', '%'.$_POST['store_name'].'%');
			});
		}
		$query_result = $query_result->where('role_id','=',3);
		$query_result = $query_result->where('is_deleted','=',0);
		$query_result = $query_result->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
			
		if($query_result)
		{
			/*Query for to get total record count*/
			$total_count = count($query_result);
			
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => $total_count,
					"iTotalDisplayRecords" => $total_count,
					"aaData" => array()
				);
			foreach($query_result as $cntdata)
			{
			
				if($cntdata['status']==1)
				{
					$cntdata['status'] = "<span class='status--process'>Active</span>";
				}
				else{
					$cntdata['status'] = "<span class='status--denied'>Deactive</span>";
				}
				
				$raw = array($cntdata['name'],$cntdata['email'],$cntdata['status'],date('F d Y  h:i A',strtotime($cntdata['created_at'])));
				
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
		echo json_encode($output);
	}
	
}
