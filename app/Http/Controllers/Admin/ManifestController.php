<?php
namespace App\Http\Controllers\Admin;
	
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manifest;
use App\Models\ManifestLabel;
use App\Models\Label;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ManifestController extends Controller
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
        return view('admin/manifest/view',array('store_details' => $storedetails,'start_date' => $start_date,'end_date' => $end_date));
    }	
	public function preload_manifestlist(Request $request)
	{
		
		$startdate = !empty(date("Y-m-d",strtotime($_POST['startdate']))) ? date("Y-m-d",strtotime($_POST['startdate'])) : '';
		$enddate = !empty(date("Y-m-d",strtotime($_POST['enddate']))) ? date("Y-m-d",strtotime($_POST['enddate'])) : '';
		//Start: Order by logic
		$order_by_field = 'manifest_details.id';
		$order_by_field_value = 'desc';
		$order_by_field_arr = [
								'0' => 'manifest_details.manifest_no',
								'1' => 'manifest_details.manifest_file',
								'2' => 'storename',
								'3' => 'manifest_details.status',
								'4' => 'manifest_details.id',
							];
		if(isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
			$order_by_field = !empty($order_by_field_arr[$_POST['order'][0]['column']])?$order_by_field_arr[$_POST['order'][0]['column']]:$order_by_field;
			$order_by_field_value = !empty($_POST['order'][0]['dir'])?$_POST['order'][0]['dir']:$order_by_field_value;
		}
		
		//$query_result = Manifest::select('manifest_details.*','us.name as storename','mld.label_detail_id as label_detail_id','lbl.shopify_order_id','lbl.shopify_order_no','lbl.consignment_no','lbl.carrier_name','lbl.service_name','lbl.is_manifested','lbl.status as label_status')->leftJoin('users as us', 'manifest_details.user_id', '=','us.id')->leftJoin('manifest_label_details as mld', 'manifest_details.id', '=','mld.manifest_detail_id')->leftJoin('label_details as lbl', 'mld.label_detail_id', '=','lbl.id');
		
		$query_result = Manifest::select('manifest_details.*','us.name as storename')->leftJoin('users as us', 'manifest_details.user_id', '=','us.id');
		if(!empty($_POST['search_data'])) 
		{
			$query_result->where(function($query)
			{
				$query->where('manifest_details.manifest_no','=',$_POST['search_data'])->orWhere('manifest_details.manifest_file', 'like', '%'.$_POST['search_data'].'%');
			});
		}
		if(!empty($_POST['store'])) {
			$query_result = $query_result->where('us.name','=',$_POST['store']);
		}
		$query_result = $query_result->whereBetween('manifest_details.created_at', ["$startdate 00:00:00","$enddate 23:59:59"]);
		
		//DATE(manifest_details.created_at) BETWEEN DATE($startdate) AND DATE($enddate) -- YYYY-MM-DD
		$total_count = $query_result->count();
		$query_result = $query_result->take($_POST['length'])->skip(intval($_POST['start']))->orderBy($order_by_field, $order_by_field_value)->get()->toArray();
		$queries = DB::getQueryLog();
		//print_r($queries);exit;

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
				
				
				$cntdata['manifest_file'] = url('/').'/uploads/manifest/'.$cntdata['manifest_file'];
				$cntdata['manifest_file'] = '<a href="'.$cntdata['manifest_file'].'" target="_blank">'.$cntdata['manifest_no'].'</a>';
				$cntdata['Action'] = '
				<div class="table-data-feature">
				   <button type="button" onclick=get_row_detail('.$cntdata['id'].',"admin/manifest/getrowdata/") class="btn btn-secondary mb-1 item" data-placement="top">
					<i class="zmdi zmdi-eye"></i>
				   </button>
				</div>';
				
				$raw = array($cntdata['manifest_no'],$cntdata['manifest_file'],$cntdata['storename'],$cntdata['status'],$cntdata['Action']);
				
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
			//$manifest_details = Manifest::select('manifest_details.*','us.name as storename')->join('users as us', 'manifest_details.user_id', '=','us.id')->where('manifest_details.id',$id)->get()->toArray();
			
			//$manifest_details = Manifest::select('manifest_details.*','us.name as storename','mld.label_detail_id as label_detail_id','lbl.shopify_order_id','lbl.shopify_order_no','lbl.consignment_no','lbl.carrier_name','lbl.service_name','lbl.is_manifested','lbl.status as label_status')->join('users as us', 'manifest_details.user_id', '=','us.id')->join('manifest_label_details as mld', 'manifest_details.id', '=','mld.manifest_detail_id')->join('label_details as lbl', 'mld.label_detail_id', '=','lbl.id')->where('manifest_details.id',$id)->get()->toArray();
			
			$manifest_details = Manifest::select('manifest_details.*','us.name as storename')->leftJoin('users as us', 'manifest_details.user_id', '=','us.id')->where('manifest_details.id',$id)->get()->toArray();
			
			$multiple_label = ManifestLabel::select('manifest_label_details.*')->where('manifest_label_details.manifest_detail_id',$id)->get()->toArray();
			$multilabel_query ='';
			$multilabel_details_arr = array();
			foreach($multiple_label as $val){
				if(isset($val['label_detail_id'])){
				$multilabel_query = Label::select('label_details.*')->where('id',$val['label_detail_id'])->get()->toArray();
					if(!empty($multilabel_query)){
						$multilabel_details_arr[] = array(
							'shopify_order_id'=>$multilabel_query[0]['shopify_order_id'],
							'shopify_order_no'=>$multilabel_query[0]['shopify_order_no'],
							'consignment_no'=>$multilabel_query[0]['consignment_no']
						);
					}
				}
				
			}
			if(!empty($manifest_details))
			{
				 $order_html = (string)view('admin.manifest.modal_view',array('All_ManifestDetails' => $manifest_details,'MultiLabelConsignment_Details'=>$multilabel_details_arr));
			}
			else
			{
				 $order_html = 'Data Not Found';
			}
		}
		$array = array('details'=>$order_html,'title'=>'Manifest Details'); 
		echo json_encode($array);
	}
	

}
