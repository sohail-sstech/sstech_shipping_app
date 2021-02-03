<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\User;

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
		$end_date = date("d-m-Y");
		$start_date = date("d-m-Y",strtotime("-1 month"));
        return view('admin/store/view',array('start_date' => $start_date,'end_date' => $end_date));
    }	
	public function preload_storelist(Request $request)
	{
		$startdate = !empty(date("Y-m-d",strtotime($_POST['startdate']))) ? date("Y-m-d",strtotime($_POST['startdate'])) : '';
		$enddate = !empty(date("Y-m-d",strtotime($_POST['enddate']))) ? date("Y-m-d",strtotime($_POST['enddate'])) : '';
		//$user_list_arr = User::whereRaw('name = ? or email like ?', ["%{$store_name}%","%{$store_name}%"])->Where('role_id',3)->Where('is_deleted',0)->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
		$user_list_arr = User::where(function($query)
			{
				$query->where('name','like', '%' .$_POST['store_name']. '%')->orWhere('email', 'like', '%'.$_POST['store_name'].'%');
			})->where('role_id','=',3)->where('is_deleted','=',0)->whereBetween('created_at', ["$startdate ' 00:00:00'","$enddate' 23:59:59'"])->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
		if($user_list_arr)
		{
			/*Query for to get total record count*/
			//$record_total = User::whereRaw('name = ? or email like ?', ["%{$store_name}%","%{$store_name}%"])->where('role_id',3)->where('is_deleted',0)->get()->toArray();
			$record_total = User::where(function($query)
			{
				$query->where('name','like', '%' .$_POST['store_name']. '%')->orWhere('email', 'like', '%'.$_POST['store_name'].'%');
			})->where('role_id','=',3)->where('is_deleted','=',0)->whereBetween('created_at', ["$startdate ' 00:00:00'","$enddate' 23:59:59'"])->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
		if($user_list_arr)
			$total_count = count($record_total);
			
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => $total_count,
					"iTotalDisplayRecords" => $total_count,
					"aaData" => array()
				);
			foreach($user_list_arr as $cntdata)
			{
			
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
				$raw = array($cntdata['name'],$cntdata['email'],$cntdata['status'],$cntdata['is_deleted'],date('F d Y  h:i A',strtotime($cntdata['created_at'])));
				
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
