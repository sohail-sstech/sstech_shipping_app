<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ProcessQueue;
use App\Models\Admin\User;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class ProcessQueueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function index()
    {
		$end_date = date("d-m-Y");
		$start_date = date("d-m-Y",strtotime("-1 month"));
		$user_details = User::select('users.name as storename')->where('role_id',3)->orderBy('id', 'desc')->get()->toArray();
        return view('admin/process_queue/view',array('user_details' => $user_details,'start_date' => $start_date,'end_date' => $end_date));
    }	
	public function preload_processqueuelist(Request $request)
	{
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		$startdate = !empty(date("Y-m-d",strtotime($_POST['startdate']))) ? date("Y-m-d",strtotime($_POST['startdate'])) : '';
		$enddate = !empty(date("Y-m-d",strtotime($_POST['enddate']))) ? date("Y-m-d",strtotime($_POST['enddate'])) : '';
		
		DB::enableQueryLog();
		/*$processqueue_list_arr = ProcessQueue::where(function($query)
			{
				$query->where('headers','like',"%".$_POST['search_data']."%")->orWhere('body', 'like', "%".$_POST['search_data']."%");
			})->where('shop_domain','like', '%' .$store. '%')->where('status','like','%'.$_POST['processqueue_status'].'%')->where('type','like','%'.$_POST['processqueue_type'].'%')->whereBetween('created_at', ["$startdate 00:00:00","$enddate 23:59:59"])->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
		*/
		$processqueue_list_arr = ProcessQueue::where(function($query)
			{
				$query->where('headers','like',"%".$_POST['search_data']."%")->orWhere('body', 'like', "%".$_POST['search_data']."%");
				//$query->where('headers','REGEXP',''.$_POST['search_data'].'')->orWhere('body', 'REGEXP', ''.$_POST['search_data'].'');
			})->where('shop_domain','like', '%' .$store. '%')->where('status','like','%'.$_POST['processqueue_status'].'%')->where('type','like','%'.$_POST['processqueue_type'].'%')->whereBetween('created_at', ["$startdate 00:00:00","$enddate 23:59:59"])->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();		
		$queries = DB::getQueryLog();
		//print_r($queries);exit;
		if($processqueue_list_arr)
		{
			/*Query for to get total record count*/
			$record_total = ProcessQueue::where(function($query)
			{
				//$query->where('headers','REGEXP',''.$_POST['search_data'].'')->orWhere('body', 'REGEXP', ''.$_POST['search_data'].'');
				$query->where('headers','like','%'.$_POST['search_data'].'%')->orWhere('body', 'like', '%'.$_POST['search_data'].'%');
			})->where('shop_domain','like', '%' .$store. '%')->where('status','like','%'.$_POST['processqueue_status'].'%')->where('type','like','%'.$_POST['processqueue_type'].'%')->whereBetween('created_at', ["$startdate 00:00:00","$enddate 23:59:59"])->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
			$total_count = count($record_total);
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => $total_count,
					"iTotalDisplayRecords" => $total_count,
					"aaData" => array()
				);
			foreach($processqueue_list_arr as $cntdata)
			{
				if($cntdata['type']==1)
				{
					$cntdata['type'] = "Create Order Webhook";
				}
				if($cntdata['status']==0)
				{
					$cntdata['status'] = "<span class='role user'>Pending</span>";
				}
				else if($cntdata['status']==1){
					$cntdata['status'] = "<span class='role member'>Completed</span>";
				}
				else if($cntdata['status']==2){
					$cntdata['status'] = "<span class='role admin'>Failed</span>";
				}
				if($cntdata['is_deleted']==1)
				{
					$cntdata['is_deleted'] = "<span class='status--process'>Yes</span>";
				}
				else{
					$cntdata['is_deleted'] = "<span class='status--denied'>No</span>";
				}
				
				$cntdata['Action'] = '
				<div class="table-data-feature">
				   <button type="button" onclick=get_row_detail('.$cntdata['id'].',"admin/processqueue/getrowdata/") class="btn btn-secondary mb-1 item" data-placement="top">
					<i class="zmdi zmdi-eye"></i>
				   </button>
				</div>';
				
				$raw = array($cntdata['type'],$cntdata['shop_domain'],$cntdata['status'],$cntdata['is_deleted'],$cntdata['Action']);
				
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
	
	/*get single record data for modal popup*/
	public function get_row_detail($id='')
	{
		if(isset($id))
		{
			$processqueue_details = ProcessQueue::where('id',$id)->get()->toArray();
			
			if(!empty($processqueue_details)){
				 $order_html = (string)view('admin.process_queue.modal_view',array('All_ProcessQueueDetails' => $processqueue_details));
			}
			else{
				$order_html = 'Data Not Found';
			}
		}
		$array = array('details'=>$order_html,'title'=>'Process Queue Details'); 
		echo json_encode($array);
	}
	

}
