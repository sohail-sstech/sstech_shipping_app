<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Label;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class LabelController extends Controller
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
        return view('admin/label/view',array('store_details' => $storedetails,'start_date' => $start_date,'end_date' => $end_date));
    }
	public function preload_labellist(Request $request)
	{
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		$startdate = !empty(date("Y-m-d",strtotime($_POST['startdate']))) ? date("Y-m-d",strtotime($_POST['startdate'])) : '';
		$enddate = !empty(date("Y-m-d",strtotime($_POST['enddate']))) ? date("Y-m-d",strtotime($_POST['enddate'])) : '';
		$ismanifestd = !empty($_POST['is_manifest']) ? $_POST['is_manifest'] : null;
		
		$order_by_field = 'label_details.id';
		$order_by_field_value = 'desc';
		$order_by_field_arr = [
								'0' => 'label_details.shopify_order_id',
								'1' => 'label_details.shopify_order_no',
								'2' => 'label_details.consignment_no',
								'3' => 'label_details.carrier_name',
								'4' => 'storename',
								'5' => 'label_details.is_manifested',
								'6' => 'label_details.id',
							];
		if(isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
			$order_by_field = !empty($order_by_field_arr[$_POST['order'][0]['column']])?$order_by_field_arr[$_POST['order'][0]['column']]:$order_by_field;
			$order_by_field_value = !empty($_POST['order'][0]['dir'])?$_POST['order'][0]['dir']:$order_by_field_value;
		}
		
		$query_result = Label::select('label_details.*','us.name as storename')->join('users as us', 'label_details.user_id', '=','us.id');
		if(!empty($_POST['search_data'])) 
		{
			$query_result->where(function($query)
			{
				$query->where('shopify_order_id','=',$_POST['search_data'])->orWhere('shopify_order_no', 'like', '%'.$_POST['search_data'].'%')->orWhere('consignment_no', '=',$_POST['search_data'])->orWhere('carrier_name', 'like', '%'.$_POST['search_data'].'%');
			});
		}
		
		if(($_POST['is_manifest'])!='') {
			$query_result = $query_result->where('is_manifested','=',$_POST['is_manifest']);
		}
		if(!empty($_POST['store'])) {
			$query_result = $query_result->where('us.name','=',$_POST['store']);
		}
		$query_result = $query_result->whereBetween('label_details.created_at', ["$startdate 00:00:00","$enddate 23:59:59"]);
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
	public function get_single_row_data($id='')
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
