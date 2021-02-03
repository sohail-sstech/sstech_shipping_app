<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Manifest;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class ManifestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function index()
    {
		$end_date = date("d-m-Y");
		$start_date = date("d-m-Y",strtotime("-1 month"));
		$storedetails = Manifest::select('manifest_details.*','us.name as storename')->join('users as us', 'manifest_details.user_id', '=','us.id')->orderBy('id', 'desc')->get()->toArray();
        return view('admin/manifest/view',array('store_details' => $storedetails,'start_date' => $start_date,'end_date' => $end_date));
    }	
	public function preload_manifestlist(Request $request)
	{
	
		$store = !empty($_POST['store']) ? $_POST['store'] : '';
		$startdate = !empty(date("Y-m-d",strtotime($_POST['startdate']))) ? date("Y-m-d",strtotime($_POST['startdate'])) : '';
		$enddate = !empty(date("Y-m-d",strtotime($_POST['enddate']))) ? date("Y-m-d",strtotime($_POST['enddate'])) : '';
		
		$label_list_arr = Manifest::select('manifest_details.*','us.name as storename')->join('users as us', 'manifest_details.user_id', '=','us.id')
			->where(function($query)
			{
				$query->where('manifest_no','=',$_POST['search_data'])->orWhere('manifest_file', 'like', '%'.$_POST['search_data'].'%');
			})->where('us.name','like', '%' .$store. '%')->whereBetween('manifest_details.created_at', ["$startdate 00:00:00","$enddate 23:59:59"])->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
		if($label_list_arr)
		{
			/*Query for to get total record count*/
			$record_total = Manifest::select('manifest_details.*','us.name as storename')->join('users as us', 'manifest_details.user_id', '=','us.id')
			->where(function($query)
			{
				$query->where('manifest_no','=',$_POST['search_data'])->orWhere('manifest_file', 'like', '%'.$_POST['search_data'].'%');
			})->where('us.name','like', '%' .$store. '%')->whereBetween('manifest_details.created_at', ["$startdate 00:00:00","$enddate 23:59:59"])->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
			$total_count = count($record_total);
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => $total_count,
					"iTotalDisplayRecords" => $total_count,
					"aaData" => array()
				);
			foreach($label_list_arr as $cntdata)
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
					$cntdata['is_deleted'] = "<span class='status--process'>Yes</span>";
				}
				else{
					$cntdata['is_deleted'] = "<span class='status--denied'>No</span>";
				}
				
				$cntdata['manifest_file'] = url('/').'/uploads/manifest/'.$cntdata['manifest_file'];
				$cntdata['manifest_file'] = '<a href="'.$cntdata['manifest_file'].'" target="_blank">'.$cntdata['manifest_no'].'</a>';
				$cntdata['Action'] = '
				<div class="table-data-feature">
				   <button type="button" onclick=get_row_detail('.$cntdata['id'].',"admin/manifest/getrowdata/") class="btn btn-secondary mb-1 item" data-placement="top">
					<i class="zmdi zmdi-eye"></i>
				   </button>
				</div>';
				
				$raw = array($cntdata['manifest_no'],$cntdata['manifest_file'],$cntdata['storename'],$cntdata['status'],$cntdata['is_deleted'],$cntdata['Action']);
				
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
			$manifest_details = Manifest::select('manifest_details.*','us.name as storename')->join('users as us', 'manifest_details.user_id', '=','us.id')->where('manifest_details.id',$id)->get()->toArray();
			
			if(!empty($manifest_details)){
				 $order_html = (string)view('admin.manifest.modal_view',array('All_ManifestDetails' => $manifest_details));
			}
			else{
				$order_html = 'Data Not Found';
			}
		}
		$array = array('details'=>$order_html,'title'=>'Manifest Details'); 
		echo json_encode($array);
	}
	

}
