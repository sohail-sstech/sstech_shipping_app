<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Config;
use Log;

class ShippingController extends Controller
{
    /**
     * Index action
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request) 
	{
		$end_date = date("d-m-Y");
		$start_date = date("d-m-Y",strtotime("-1 month"));
		return view('theme.orderlabel_view',array('start_date' => $start_date,'end_date' => $end_date));
    }
	/*main manifest datatable grid load*/
	public function preload_orderlabeldata(Request $request)
	{
		$where = '';
		$searchkey_filter='';
		$ismanifest_filter='';
		$limit = '';
		if(isset($_POST['start']) && $_POST['length'] != '-1') 
		{
			$limit = "LIMIT ".intval($_POST['start']).", ".intval($_POST['length']);
		}
		if(isset($_POST['search_key']) && !empty($_POST['search_key'])){
			$searchkey_filter = 'AND lbldt.shopify_order_no like ("%'.$_POST['search_key'].'%") OR lbldt.consignment_no like ("%'.$_POST['search_key'].'%")';
		}
		
		//if(isset($_POST['ismanifest']) && !empty($_POST['ismanifest'])){
		if($_POST['ismanifest']!=''){
			$ismanifest_filter = 'AND lbldt.is_manifested IN ("'.$_POST['ismanifest'].'") ';
		}
		if (isset($_POST['startdate']) && isset($_POST['enddate'])) {
			//$search_limit = "LIMIT ".intval( $_GET['start'] ).", ".intval( $_GET['length']);
			$startdate = date("Y-m-d",strtotime($_POST['startdate']));
			$startdate = $startdate. ' 00:00:01';
			
			$enddate = date("Y-m-d",strtotime($_POST['enddate']));	
			$enddate =  $enddate. ' 23:59:59';
			
			$where .= ' AND lbldt.created_at between "'.$startdate.'" and "'.$enddate.'"';
		}
		//DB::enableQueryLog();
		$orderlabel_query = DB::select('select SQL_CALC_FOUND_ROWS lbldt.* from label_details as lbldt where lbldt.status=1 '.$where.' '.$searchkey_filter.' '.$ismanifest_filter.' order by lbldt.id desc '.$limit.' ');
		//$queries = DB::getQueryLog();
		//print_r($queries);exit;

		//echo '<pre>';print_r($where);exit;
		
		if($orderlabel_query)
		{
			$query2 = DB::select('SELECT FOUND_ROWS() as totalcount');
			$total_count = $query2[0]->totalcount;
			$table_data = array('data_found'=>$orderlabel_query,'total_count'=>$total_count);
			
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => $table_data['total_count'],
					"iTotalDisplayRecords" => $table_data['total_count'],
					"aaData" => array()
				);
			$table = $table_data['data_found'];
			$raw = array();
			//$AccessKey = '00BF47B1559899C7F6ED19CF40914841A9D0B8BC7C95C59C25';
			for($a=0; $a<count($table); $a++)
			{
				if(!empty($table[$a]->consignment_no))
				{
					if($table[$a]->is_manifested=='1')
					{
						$ismanifest = 'Yes';
					}
					else
					{
						$ismanifest = 'No';
					}
					if(!empty($table[$a]->consignment_no))
					{
						//$tackingurl =  '<a href="http://track.omniparcel.com/'.$table[$a]->consignment_no.'" target="_blank">Tracking ConsignmentNo</a>'; 
						//$tackingurl =  '<a href="http://track.omniparcel.com/'.$table[$a]->consignment_no.'" target="_blank" style="cursor:pointer;"><img src="images/tracking_icon.png" alt="Track Consignment" style="height:auto;width:64%;"></a>'; 
						$tackingurl =  '<a href="http://track.omniparcel.com/'.$table[$a]->consignment_no.'" target="_blank" style="cursor:pointer;"><i class="fa fa-truck fa-sm" style="color:#666;"></i></a>'; 
						//$pdf_label =  '<a href="javascript:void(0);" target="_blank" onclick=get_pdf_label('.$table[$a]->id.')>Download Label</a>';
						//$pdf_label =  '<span style="cursor:pointer;" onclick=get_pdf_label('.$table[$a]->id.')><img src="images/pdf_icon.png" alt="Download Label" style="height:auto;width:64%;"></span>';
						$pdf_label =  '<span style="cursor:pointer;" onclick=get_pdf_label('.$table[$a]->id.')><i class="fas fa-download fa-sm"></i></span>';
						
					}
					else
					{
						$pdf_label = 'Not available';
						$tackingurl = 'Not available';
					}
				
				$table[$a]->Action = '
				<div class="table-data-feature1">
					<a href="orderlabeldetails_view/'.$table[$a]->id.'" class="btn btn-secondary mb-1 item" data-toggle="tooltip" data-placement="top">
					<i class="zmdi zmdi-eye"></i>
				    </a>
				</div>';		
				//$checkbox = '<label class="au-checkbox" ><input type="checkbox" data-id="'.$table[$a]->id.'"  data-ConsignmentNo="'.$table[$a]->consignment_no.'" data-accesstoken="'.$AccessKey.'"><span class="au-checkmark"></span></label>';
				//$raw = array(table[$a]->shopify_order_no,$table[$a]->consignment_no,$table[$a]->carrier_name,$pdf_label,$tackingurl,$ismanifest);
				$raw = array($table[$a]->shopify_order_no,$table[$a]->consignment_no,$table[$a]->carrier_name,$pdf_label,$tackingurl,$ismanifest,$table[$a]->Action);
				
				}
				$output['aaData'][] = $raw;
			}
		}
		else{
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => '0',
					"iTotalDisplayRecords" => '0',
					"aaData" => array()
				);
		}
		echo json_encode( $output );
	}
	
	/*get pdf label*/
	public function get_pdf_labeldetails() 
	{
		$shop = Auth::user();
		$shop_request = $shop->api()->rest('GET', '/admin/shop.json');
		$shop_domain = !empty($shop_request->body->shop->domain) ? $shop_request->body->shop->domain : null;
		
		$return = array();
		$labelid=$_POST['labelid'];
		$dyanmic_accesskey='';
		$AccessKey = get_dynamic_token($shop_domain);
		//$get_return_data = $this->return_model->get_return_data_for_label($return_id);
		$get_label_data = DB::select('select * from label_details where id='.$labelid.' ');
		
		$consignment = !empty($get_label_data[0]->consignment_no)? $get_label_data[0]->consignment_no:NULL;
		$carrier_name = !empty($get_label_data[0]->carrier_name)? $get_label_data[0]->carrier_name : NULL;
		$created_at = !empty ($get_label_data[0]->created_at) ? $get_label_data[0]->created_at : NULL;
		//echo '<pre>';print_r($get_label_data);exit;
		//echo '<pre>'; print_r($get_return_data); exit();
		$url="http://api.omniparcel.com/labels/download?connote={$consignment}&format=LABEL_PDF&rotate=false";
		$header =array('Access_Key:'.$AccessKey,
			  'Content-Type: application/json',
			  'charset:utf-8');
		$cust_data = array('method' => 'GET');
		$api_response = call_curl($url, $header, '', $cust_data);
		//echo '<pre>'; print_r($api_response); exit();
		$api_response_arr = json_decode($api_response['response'], true);
		if(!empty($api_response_arr)) {
			$CustomerName = $carrier_name;
			//$shopify_order_no = $shopify_order_no;
			$file_name = $CustomerName.'-'.date("d-m-y", strtotime($created_at)).'-'.substr(uniqid(rand(), true), 4,4);
			$file_name = strtolower(trim(preg_replace('#\W+#', '_', $file_name), '_')).'.pdf';
			//echo $api_response_arr[0];
			$return = array('Success' => 1,'Filename' => $file_name, 'Content' => $api_response_arr[0]);
		} else {
			$return = array('Success' => 0);
		}
		echo json_encode($return);
		exit();
	}
	
	
	/*row wise data get for front order label grid*/
	public function get_label_details($id='')
	{
		if(isset($id))
		{
			$labeldetails_results = DB::select('select lbldt.*,us.name as storename from label_details as lbldt
			left join users as us ON lbldt.user_id=us.id where lbldt.id='.$id.' ');
			
			//echo '<pre>';print_r($labeldetails_results);exit;
			
			//$label_details = Label::select('label_details.*','us.name as storename')->join('users as us', 'label_details.user_id', '=','us.id')->where('label_details.id',$id)->get()->toArray();

			if(!empty($labeldetails_results)){
				
				//$orderlabel_html = (string)view('admin.label.modal_view',array('All_LabelDetails' => $label_details));
				 $orderlabel_details = !empty($labeldetails_results[0]) ? $labeldetails_results[0] : null;
			}
			else{
				 $orderlabel_details = 'Data Not Found';
			}
		}
		return view('theme.orderlabeldetails_view',array('LabelDetails' => $orderlabel_details));
		//$array = array('details'=>$order_html,'title'=>'Label Details'); 
		//echo json_encode($array);
		
	}
	
	
		/*call curl for manifest api*/
	/*public function call_curl($url='', $header=array(), $attachment='', $cust_data=array()) {
		$response = '';
		if(empty($cust_data)){$method="POST";}else{$method=$cust_data['method'];}
		if(!empty($url)) {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl, CURLOPT_URL,$url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST,$method);
			curl_setopt($curl, CURLOPT_POSTFIELDS,$attachment);
			curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
			$response = curl_exec($curl);			
		}
		return $response;
	}*/
	
	
	
   
}