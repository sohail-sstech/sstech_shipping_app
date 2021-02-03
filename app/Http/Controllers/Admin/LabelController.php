<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Label;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function index()
    {
		$end_date = date("d-m-Y");
		$start_date = date("d-m-Y",strtotime("-1 month"));
		$storedetails = Label::select('label_details.*','us.name as storename')->join('users as us', 'label_details.user_id', '=','us.id')->orderBy('id', 'desc')->get()->toArray();
        return view('admin/label/view',array('store_details' => $storedetails,'start_date' => $start_date,'end_date' => $end_date));
    }	
	public function preload_labellist(Request $request)
	{
	
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		$startdate = !empty(date("Y-m-d",strtotime($_POST['startdate']))) ? date("Y-m-d",strtotime($_POST['startdate'])) : '';
		$enddate = !empty(date("Y-m-d",strtotime($_POST['enddate']))) ? date("Y-m-d",strtotime($_POST['enddate'])) : '';
		
		DB::enableQueryLog();
		$label_list_arr = Label::select('label_details.*','us.name as storename')->join('users as us', 'label_details.user_id', '=','us.id')
			->where(function($query)
			{
				$query->where('shopify_order_id','=',$_POST['search_data'])->orWhere('shopify_order_no', 'like', '%'.$_POST['search_data'].'%')->orWhere('consignment_no', '=',$_POST['search_data'])->orWhere('carrier_name', 'like', '%'.$_POST['search_data'].'%');
			})->where('is_manifested','like','%' .$_POST['is_manifest']. '%')->where('us.name','like', '%' .$store. '%')->whereBetween('label_details.created_at', ["$startdate 00:00:00","$enddate 23:59:59"])->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
		
		if($label_list_arr)
		{
			/*Query for to get total record count*/
			 $record_total = Label::select('label_details.*','us.name as storename')->join('users as us', 'label_details.user_id', '=','us.id')
			->where(function($query)
			{
				$query->where('shopify_order_id','=',$_POST['search_data'])->orWhere('shopify_order_no', 'like', '%'.$_POST['search_data'].'%')->orWhere('consignment_no', '=',$_POST['search_data'])->orWhere('carrier_name', 'like', '%'.$_POST['search_data'].'%');
			})->where('is_manifested','like','%' .$_POST['is_manifest']. '%')->where('us.name','like', '%' .$store. '%')->whereBetween('label_details.created_at', ["$startdate 00:00:00","$enddate 23:59:59"])->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
			$total_count = count($record_total);
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => $total_count,
					"iTotalDisplayRecords" => $total_count,
					"aaData" => array()
				);
			foreach($label_list_arr as $cntdata)
			{
				if($cntdata['is_manifested']==1)
				{
					$cntdata['is_manifested'] = "<span class='status--process'>Yes</span>";
				}
				else{
					$cntdata['is_manifested'] = "<span class='status--denied'>No</span>";
				}
				$cntdata['Action'] = '
				<div class="table-data-feature">
				   <button type="button" onclick=get_row_detail('.$cntdata['id'].',"admin/label/getrowdata/") class="btn btn-secondary mb-1 item" data-placement="top">
					<i class="zmdi zmdi-eye"></i>
				   </button>
				</div>';
				
				$raw = array($cntdata['shopify_order_id'],$cntdata['shopify_order_no'],$cntdata['consignment_no'],$cntdata['carrier_name'],$cntdata['storename'],$cntdata['is_manifested'],$cntdata['Action']);
				
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
	public function get_row_log_details($id='')
	{
		if(isset($id))
		{
			$label_details = Label::select('label_details.*','us.name as storename')->join('users as us', 'label_details.user_id', '=','us.id')->where('label_details.id',$id)->get()->toArray();
			
			if(!empty($label_details)){
				 $order_html = (string)view('admin.label.modal_view',array('All_LabelDetails' => $label_details));
			}
			else{
				$order_html = 'Data Not Found';
			}
		}
		$array = array('details'=>$order_html,'title'=>'Label Details'); 
		echo json_encode($array);
	}
	

}
