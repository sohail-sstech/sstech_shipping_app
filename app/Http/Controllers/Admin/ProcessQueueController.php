<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProcessQueue;
use App\Models\User;

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
		$startdate = !empty(date("Y-m-d",strtotime($_POST['startdate']))) ? date("Y-m-d",strtotime($_POST['startdate'])) : '';
		$enddate = !empty(date("Y-m-d",strtotime($_POST['enddate']))) ? date("Y-m-d",strtotime($_POST['enddate'])) : '';
		$query_result=ProcessQueue::select('*');
		if(!empty($_POST['search_data'])) 
		{
			$query_result->where(function($query)
			{
				$query->where('headers','like','%'.$_POST['search_data'].'%')->orWhere('body','like','%'.$_POST['search_data'].'%');
			});
		}
		if(!empty($_POST['store'])) {
			$query_result = $query_result->where('shop_domain','like', '%' .$_POST['store']. '%');
		}
		if($_POST['processqueue_status']!='') {
			$query_result = $query_result->where('status','like','%'.$_POST['processqueue_status'].'%');
		}
		if(!empty($_POST['processqueue_type'])) {
			$query_result = $query_result->where('type','like','%'.$_POST['processqueue_type'].'%');
		}
		$query_result = $query_result->whereBetween('created_at', ["$startdate 00:00:00","$enddate 23:59:59"]);
		$query_result = $query_result->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
		
		if($query_result)
		{
			$total_count = count($query_result);
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => $total_count,
					"iTotalDisplayRecords" => $total_count,
					"aaData" => array()
				);
			foreach($query_result as $cntdata)
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
				
				$cntdata['Action'] = '
				<div class="table-data-feature">
				   <button type="button" onclick=get_row_detail('.$cntdata['id'].',"admin/processqueue/getrowdata/") class="btn btn-secondary mb-1 item" data-placement="top">
					<i class="zmdi zmdi-eye"></i>
				   </button>
				</div>';
				
				$raw = array($cntdata['type'],$cntdata['shop_domain'],$cntdata['status'],$cntdata['Action']);
				
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
	public function get_single_row_data($id='')
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
