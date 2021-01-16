<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Config;
use Log;

class ManifestController extends Controller
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
		return view('theme.manifest_view',array('start_date' => $start_date,'end_date' => $end_date));
    }
	/*main manifest datatable grid load*/
	public function preload_manifestdata(Request $request)
	{
		$where = '';
		$searchkey_filter='';
		if(isset($_POST['search_key']) && !empty($_POST['search_key']))
		{
			$searchkey_filter = 'AND lbldt.consignment_no like ("%'.$_POST['search_key'].'%")';
		}
		if (isset($_POST['startdate']) && isset($_POST['enddate'])) 
		{
			//$search_limit = "LIMIT ".intval( $_GET['start'] ).", ".intval( $_GET['length']);
			$startdate = date("Y-m-d",strtotime($_POST['startdate']));
			$startdate = $startdate. ' 00:00:01';
			$enddate = date("Y-m-d",strtotime($_POST['enddate']));	
			$enddate =  $enddate. ' 23:59:59';
			$where .= ' AND lbldt.created_at between "'.$startdate.'" and "'.$enddate.'"';
		}
		$manifestdata_query = DB::select('select SQL_CALC_FOUND_ROWS lbldt.* from label_details as lbldt where lbldt.is_manifested=0 '.$where.' '.$searchkey_filter.' ');
		//echo '<pre>';print_r($where);exit;
		
		if($manifestdata_query)
		{
			$query2 = DB::select('SELECT FOUND_ROWS() as totalcount');
			$total_count = $query2[0]->totalcount;
			$table_data = array('data_found'=>$manifestdata_query,'total_count'=>$total_count);
			
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => $table_data['total_count'],
					"iTotalDisplayRecords" => $table_data['total_count'],
					"aaData" => array()
				);
			$table = $table_data['data_found'];
			//$AccessKey = '00BF47B1559899C7F6ED19CF40914841A9D0B8BC7C95C59C25';
			$AccessKey = Config::get('constants.default_access_token');
			for($a=0; $a<count($table); $a++){
				$checkbox = '<label class="au-checkbox" ><input type="checkbox" data-id="'.$table[$a]->id.'"  data-ConsignmentNo="'.$table[$a]->consignment_no.'" data-accesstoken="'.$AccessKey.'"><span class="au-checkmark"></span></label>';
				$raw = array($checkbox,$table[$a]->consignment_no,$table[$a]->carrier_name,$table[$a]->created_at);
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
	
	
	/*recent manifest grid load*/
	public function preload_recentmanifest()
	{
		$recent_manifestdeatils = DB::table('manifest_details')->where('status','1')->Orderby('created_at', 'desc')->take(25)->get();
		
		if($recent_manifestdeatils)
		{
			//$inc=1;
			for($a=0; $a<count($recent_manifestdeatils); $a++){
				$recent_manifestdeatils[$a]->manifest_file = url('/').'/uploads/manifest/'.$recent_manifestdeatils[$a]->manifest_file;
				$recent_manifestdeatils[$a]->manifestlink = '<a href="'.$recent_manifestdeatils[$a]->manifest_file.'" target="_blank">'.$recent_manifestdeatils[$a]->manifest_no.'</a>';
				$recent_manifestdeatils[$a]->created_at;
			}
		}
		else{
			$recent_manifestdeatils = '';	
		}	
		echo json_encode(array('data'=>$recent_manifestdeatils),JSON_PRETTY_PRINT);
	}
	
	function manifest_consignment()
	{
		
	    $connote=$_POST['connote_list'];
	    $Access_Key=$_POST['token'];
		$shop = Auth::user();
		$shop_request = $shop->api()->rest('GET', '/admin/shop.json');
		$shop_domain = $shop_request->body->shop->domain;
		$userid = DB::table('users')->where('name', $shop_domain)->select('id')->pluck('id')->first();
	    $attachment=json_encode($connote);
		$url = Config::get('constants.create_manifest_url');
	    //$url='https://api.omniparcel.com/v2/publishmanifestv4';
	    $header =array('Access_Key:'.$Access_Key,'Content-Type: application/json', 'charset:utf-8');
	    $manifest_api_response = call_curl($url,$header,$attachment);
	    $manifest_resp=json_decode($manifest_api_response['response']);
	    $res_result=array();
	   if(!empty($manifest_resp->OutboundManifest) && $manifest_resp->OutboundManifest!=''){
	       foreach($manifest_resp->OutboundManifest as $val){
	           $manifest_number[$val->ManifestNumber]=$val->ManifestedConnotes;
	           $path =  public_path().'/uploads/manifest/';
	           $unique = substr(uniqid(rand(), true), 4,4);
	           $attachment_label = $path.$val->ManifestNumber.'.pdf';
	           $file = fopen($attachment_label,'w+');
	           $file_st=file_put_contents($attachment_label,base64_decode($val->ManifestContent));
	           fclose($file);
	           if($file_st){
	                   // $filepath= url('/').'/uploads/manifest/'.$val->ManifestNumber.'.pdf';
						$filepath= $val->ManifestNumber.'.pdf'; 
				}
				if(isset($val->ManifestNumber)&& !empty($val->ManifestedConnotes)){
        				$manifest_details = array(
							'user_id'=>$userid,
							'manifest_no'=>$val->ManifestNumber,
							'manifest_file'=>$filepath,
							'created_by'=>$userid
							);
						DB::table('manifest_details')->insert($manifest_details);
						
						/*label details update*/
						DB::table('label_details')->where('consignment_no',$val->ManifestedConnotes)->update(['is_manifested' => 1]);
        				//$update_export_manifest = $this->reprint_manifest_model->update_manifest_details($update_manifest_details,$val->ManifestedConnotes);
				}
				$res_result['ManifestedConnotes'][$val->ManifestNumber]=$val->ManifestedConnotes;
				$res_result['UnManifestedConnotes'][]=$manifest_resp->UnManifestedConnotes;
	       }
	   }
	   else{
	      $res_result['UnManifestedConnotes'][]=$manifest_resp->UnManifestedConnotes;
	   }
	   
	    echo json_encode($res_result);
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
		//echo "<pre>"; print_r($response); exit;
		return $response;
	}*/
	

	/*delete consignment functionality*/
	function delete_consignment(){
	    //$data = $this->general->check_currrent_session();
	    //echo "<pre>";print_r($data);exit();
	    $connote=$_POST['connote_list'];
	    $accesstoken=$_POST['token'];
	    $attachment=json_encode($connote);
	    //$attachment=json_encode(array("WRX1004265"));
	    ///// Call Reprint API of OmniParcel ///
	    //$url='https://api.omniparcel.com/labels/delete';
		$url = Config::get('constants.delete_manifest_url');
	    $header =array('Access_Key:'.$accesstoken, 'Content-Type: application/json', 'charset:utf-8');
	    //print_r($header);print_r($attachment);exit();
	    $delete_api_response = call_curl($url,$header,$attachment);
		//echo '<pre>';print_r($delete_api_response);exit();
	    ///// Delete consolidated connote from export_details and create_export_consignment if the delete API is success///
	    foreach(json_decode($delete_api_response['response']) as $key=>$val){
			
	       if($val=='Deleted'){
			   
			    DB::table('label_details')->where('consignment_no', $key)->update(['is_deleted' => 1]);
	           //$del_consignment=$this->reprint_manifest_model->del_consignment($key);
	       }
	    }
	    echo $delete_api_response;
	}

	
}