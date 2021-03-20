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
		$this->middleware('user-role');
    }
	public function index()
    {
        return view('admin/store/view');
    }	
	public function preload_storelist(Request $request)
	{
		/*start logic for order by*/
		$order_by_field = 'id';
		$order_by_field_value = 'desc';
		$order_by_field_arr = [
								'0' => 'name',
								'1' => 'email',
								'2' => 'status',
								'3' => 'created_at',
							];
		if(isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
			$order_by_field = !empty($order_by_field_arr[$_POST['order'][0]['column']])?$order_by_field_arr[$_POST['order'][0]['column']]:$order_by_field;
			$order_by_field_value = !empty($_POST['order'][0]['dir'])?$_POST['order'][0]['dir']:$order_by_field_value;
		}
		
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
