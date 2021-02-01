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
        return view('admin/store/view');
    }	
	public function preload_storelist(Request $request)
	{
		$store_name ='';
		if(isset($_POST['store_name']) && !empty($_POST['store_name']))
		{
			$store_name = $_POST['store_name'];
		}
		//DB::enableQueryLog();
		//$user_list_arr = User::select('users.*')->where('name','like', '%' .$store_name. '%')->orWhere('email', 'like', '%'.$store_name.'%')->where('role_id',3)->where('is_deleted',0)->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
		$user_list_arr = User::whereRaw('name = ? or email like ?', ["%{$store_name}%","%{$store_name}%"])->Where('role_id',3)->Where('is_deleted',0)->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
		   
		//$queries = DB::getQueryLog();
		
		/*DB::enableQueryLog();
		$queries = DB::getQueryLog();
		print_r($queries);exit;*/
		//$output = array();
		//print_r($user_list_arr);exit;
		if($user_list_arr)
		{
			/*Query for to get total record count*/
			$record_total = User::whereRaw('name = ? or email like ?', ["%{$store_name}%","%{$store_name}%"])->where('role_id',3)->where('is_deleted',0)->get()->toArray();
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
