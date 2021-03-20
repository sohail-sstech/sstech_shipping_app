<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use App\Models\Admin\ApiLog;
use App\Models\ApiLog;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ApiLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('user-role');
    }
	public function index()
    {
		$storedetails='';
		$end_date = date("d-m-Y");
		$start_date = date("d-m-Y",strtotime("-1 month"));
		$storedetails = User::select('users.name as storename')->where('role_id',3)->orderBy('id', 'desc')->get()->toArray();
        return view('admin/api_log/view',array('store_details' => $storedetails,'start_date' => $start_date,'end_date' => $end_date));
    }
	public function preload_apiloglist(Request $request)
	{
		$startdate = !empty(date("Y-m-d",strtotime($_POST['startdate']))) ? date("Y-m-d",strtotime($_POST['startdate'])) : '';
		$enddate = !empty(date("Y-m-d",strtotime($_POST['enddate']))) ? date("Y-m-d",strtotime($_POST['enddate'])) : '';
		
		//Start: Order by logic
		$order_by_field = 'api_logs.Id';
		$order_by_field_value = 'desc';
		$order_by_field_arr = [
								'0' => 'api_logs.Id',
								'1' => 'storename',
								'2' => 'api_logs.api_url',
								'3' => 'api_logs.request_type',
								'4' => 'api_logs.response_code',
								'5' => 'api_logs.created_at',
								'6' => 'api_logs.Id',
							];
		if(isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
			$order_by_field = !empty($order_by_field_arr[$_POST['order'][0]['column']])?$order_by_field_arr[$_POST['order'][0]['column']]:$order_by_field;
			$order_by_field_value = !empty($_POST['order'][0]['dir'])?$_POST['order'][0]['dir']:$order_by_field_value;
		}
		
		$query_result = ApiLog::select('api_logs.*','us.name as storename')->join('users as us', 'api_logs.user_id', '=','us.id');
		if(!empty($_POST['search_data'])) {
			$query_result = $query_result->where(function($query)
			{
				$query->where('api_url','like', '%' .$_POST['search_data']. '%')->orWhere('request_headers', 'like', '%'.$_POST['search_data'].'%')->orWhere('request', 'like', '%'.$_POST['search_data'].'%')->orWhere('response_headers', 'like', '%'.$_POST['search_data'].'%')->orWhere('response', 'like', '%'.$_POST['search_data'].'%');
			});
		}
		if(!empty($_POST['request_type'])) {
			$query_result = $query_result->where('request_type','=',$_POST['request_type']);
		}
		if(!empty($_POST['response_code'])) {
			$query_result = $query_result->where('response_code','=',$_POST['response_code']);
		}
		if(!empty($_POST['store'])) {
			$query_result = $query_result->where('us.name','=',$_POST['store']);
		}
		$query_result = $query_result->whereBetween('api_logs.created_at', ["$startdate  00:00:00","$enddate 23:59:59"]);
		$query_result = $query_result->where('api_logs.is_deleted',0);
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
				if($cntdata['response_code']=='Success')
				{
					$cntdata['response_code'] = "<span class='status--process'>".$cntdata['response_code']."</span>";
				}
				else{
					$cntdata['response_code'] = "<span class='status--denied'>".$cntdata['response_code']."</span>";
				}
				if($cntdata['request_type']==1){
					$cntdata['request_type']  = '<span class="role member">Shipping Rate Request</span>';
				}
				else if($cntdata['request_type']==2){
					$cntdata['request_type']  = '<span class="role member">Available Rate Request</span>';
				}
				else if($cntdata['request_type']==3){
					$cntdata['request_type']  = '<span class="role member">Label Request</span>';
				}
				else if($cntdata['request_type']==4){
					$cntdata['request_type']  = '<span class="role member">Manifest Request</span>';
				}
				else if($cntdata['request_type']==5){
					$cntdata['request_type']  = '<span class="role member">Label Delete Request</span>';
				}
				
				$cntdata['Action'] = '
				<div class="table-data-feature">
				   <button type="button" onclick=get_row_detail('.$cntdata['Id'].',"admin/apilog/getrowdata/") class="btn btn-secondary mb-1 item" data-placement="top">
					<i class="zmdi zmdi-eye"></i>
				   </button>
				</div>';
				$raw = array($cntdata['Id'],$cntdata['storename'],$cntdata['api_url'],$cntdata['request_type'],$cntdata['response_code'],date('F d Y  h:i A',strtotime($cntdata['created_at'])),$cntdata['Action']);
				
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
			$api_details = ApiLog::select('api_logs.*','us.name as storename')->join('users as us', 'api_logs.user_id', '=','us.id')->where('api_logs.Id',$id)->where('api_logs.is_deleted',0)->get()->toArray();
			if(!empty($api_details)){
				 $order_html = (string)view('admin.api_log.modal_view',array('All_ApiDetails' => $api_details));
			}
			else{
				$order_html = 'Data Not Found';
			}
		}
		$array = array('details'=>$order_html,'title'=>'Api Log Details'); 
		echo json_encode($array);
	}
}
