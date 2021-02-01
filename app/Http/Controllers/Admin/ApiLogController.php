<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\ApiLog;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class ApiLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function index()
    {
		$storedetails = ApiLog::select('api_logs.*','us.name as storename')->join('users as us', 'api_logs.user_id', '=','us.id')->orderBy('id', 'desc')->get()->toArray();
        return view('admin/api_log/view',array('store_details' => $storedetails));
    }	
	public function preload_apiloglist(Request $request)
	{
		$search_data = !empty($_POST['search_data']) ? $_POST['search_data'] : '';
		$request_type = !empty($_POST['request_type']) ? $_POST['request_type'] : '';
		$response_code = !empty($_POST['response_code']) ? $_POST['response_code'] : '';
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		
		$ApiLog_list_arr = ApiLog::select('api_logs.*','us.name as storename')->join('users as us', 'api_logs.user_id', '=','us.id')
			->where(function($query)
			{
				$query->where('api_url','like', '%' .$_POST['search_data']. '%')->orWhere('request_headers', 'like', '%'.$_POST['search_data'].'%')->orWhere('request', 'like', '%'.$_POST['search_data'].'%')->orWhere('response_headers', 'like', '%'.$_POST['search_data'].'%')->orWhere('response', 'like', '%'.$_POST['search_data'].'%');
			})->where('request_type','like', '%' .$request_type. '%')->where('response_code','like', '%' .$response_code. '%')->where('us.name','like', '%' .$store. '%')->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
		
		$queries = DB::getQueryLog();
		if($ApiLog_list_arr)
		{
			/*Query for to get total record count*/
			 $record_total = ApiLog::select('api_logs.*','us.name as storename')->join('users as us', 'api_logs.user_id', '=','us.id')
			->where(function($query)
			{
				$query->where('api_url','like', '%' .$_POST['search_data']. '%')->orWhere('request_headers', 'like', '%'.$_POST['search_data'].'%')->orWhere('request', 'like', '%'.$_POST['search_data'].'%')->orWhere('response_headers', 'like', '%'.$_POST['search_data'].'%')->orWhere('response', 'like', '%'.$_POST['search_data'].'%');
			})->where('request_type','like', '%' .$request_type. '%')->where('response_code','like', '%' .$response_code. '%')->where('us.name','like', '%' .$store. '%')->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
			$total_count = count($record_total);
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => $total_count,
					"iTotalDisplayRecords" => $total_count,
					"aaData" => array()
				);
			foreach($ApiLog_list_arr as $cntdata)
			{
				if($cntdata['response_code']=='Success')
				{
					$cntdata['response_code'] = "<span class='status--process'>".$cntdata['response_code']."</span>";
				}
				else{
					$cntdata['response_code'] = "<span class='status--denied'>".$cntdata['response_code']."</span>";
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
	public function get_row_log_details($id=''){
		
		if(isset($id))
		{
			$api_details = ApiLog::where('Id',$id)->get()->toArray();
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
