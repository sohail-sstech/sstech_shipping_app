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
		$limit = '';
		if(isset($_POST['start']) && $_POST['length'] != '-1') 
		{
			$limit = "LIMIT ".intval($_POST['start']).", ".intval($_POST['length']);
		}
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
		
		$manifestdata_query = DB::select('select SQL_CALC_FOUND_ROWS lbldt.* from label_details as lbldt where lbldt.is_manifested=0 '.$where.' '.$searchkey_filter.' order by lbldt.id desc '.$limit.' ');
		
		
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
			
			$AccessKey = get_dynamic_token();
			
			for($a=0; $a<count($table); $a++){
				if(!empty($table[$a]->consignment_no))
				{
					$checkbox = '<label class="au-checkbox" ><input type="checkbox" data-userid="'.$table[$a]->user_id.'" data-id="'.$table[$a]->id.'"  data-ConsignmentNo="'.$table[$a]->consignment_no.'" data-accesstoken="'.$AccessKey.'"><span class="au-checkmark"></span></label>';
					$raw = array($checkbox,$table[$a]->consignment_no,$table[$a]->carrier_name,$table[$a]->created_at);
				}
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
	
	/*Load recent manifest view*/
	public function recent_manifestview(){
		return view('theme.recentmanifest_view');
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
	
	
	public function manifest_consignment()
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
		
		/*
		echo 'URL: ' . $url . '<br/>';
		echo 'Header: ' . json_encode($header) . '<br/>';
		echo 'Attachment: ' . $attachment . '<br/>';
		exit();
		*/

	    $manifest_api_response = call_curl($url,$header,$attachment);
	    $manifest_resp=json_decode($manifest_api_response['response']);
	    $res_result=array();
	   if(!empty($manifest_resp->OutboundManifest) && $manifest_resp->OutboundManifest!='')
	   {
	       foreach($manifest_resp->OutboundManifest as $val)
		   {
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
							'manifest_error'=>$manifest_resp->Error,
							'manifest_status_code'=>$manifest_resp->StatusCode,
							'un_manifested_connotes'=> json_encode($manifest_resp->UnManifestedConnotes),
							'created_by'=>$userid
							);
						//DB::table('manifest_details')->insert($manifest_details);
						DB::table('manifest_details')->insert($manifest_details);
						$manifestdetails_id = DB::getPdo()->lastInsertId();

						foreach($val->ManifestedConnotes as $key_mc=>$val_mc)
						{
							/*Get label detals through the consignment no*/
							$label_detailsid = DB::table('label_details')->where('consignment_no', $val_mc)->select('id')->pluck('id')->first();
							/*Add details in manifest label details table*/
							$manifest_label_details = array(
							'user_id'=>$userid,
							'manifest_detail_id'=>$manifestdetails_id,
							'label_detail_id'=>$label_detailsid,
							'consignment_no'=>$val_mc,
							'created_by'=>$userid
							);
							DB::table('manifest_label_details')->insert($manifest_label_details);
							/*label details update*/
							DB::table('label_details')->where('consignment_no',$val_mc)->update(['is_manifested' => 1]);
						}
						
						/*label details update*/
						//DB::table('label_details')->where('consignment_no',$val->ManifestedConnotes)->update(['is_manifested' => 1]);
        				//$update_export_manifest = $this->reprint_manifest_model->update_manifest_details($update_manifest_details,$val->ManifestedConnotes);
				}
				$res_result['ManifestedConnotes'][$val->ManifestNumber]=$val->ManifestedConnotes;
				$res_result['UnManifestedConnotes'][]=$manifest_resp->UnManifestedConnotes;
				
				/*api log insert data*/
				$responsecode = empty($manifest_resp->Errors)? 'Success':'Failure';
				$status = empty($manifest_resp->Errors)? '1':'0';
				$originip=$_SERVER['REMOTE_ADDR'];
				$apilog_insert_array=array(
					'api_url'=>$url,
					'user_id'=>$userid,
					'request_type'=>'4',
					'request_headers'=> json_encode($header),
					'request'=> $attachment,
					'response'=> json_encode($manifest_resp),
					'response_code'=>$responsecode,
					'origin_ip'=>$originip,
					'status'=>$status,
					'created_by'=>$userid
				);
				DB::table('api_logs')->insert($apilog_insert_array);
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
	public function delete_consignment()
	{
	    //$data = $this->general->check_currrent_session();
	    //echo "<pre>";print_r($_POST);exit();
	    $connote=$_POST['connote_list'];
	    $accesstoken=$_POST['token'];
		$shop = Auth::user();
		$shop_request = $shop->api()->rest('GET', '/admin/shop.json');
		$shop_domain = $shop_request->body->shop->domain;
		$userid = DB::table('users')->where('name', $shop_domain)->select('id')->pluck('id')->first();
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
		$responsecode ='';
		$status ='';
	    foreach(json_decode($delete_api_response['response']) as $key=>$val)
		{
	       if($val=='Deleted')
		   {
			    DB::table('label_details')->where('consignment_no', $key)->update(['is_deleted' => 1]);
	           //$del_consignment=$this->reprint_manifest_model->del_consignment($key);
			   $responsecode = 'Success';
			   $status = '1';
	       }
		   else
		   {
			   $responsecode = 'Failure';	
			   $status = '0';
		   }	
		    /*api log insert data when label delete api call*/
			$originip=$_SERVER['REMOTE_ADDR'];
			$apilog_insert_array=array(
				'api_url'=>$url,
				'user_id'=>$userid,
				'request_type'=>'5',
				'request_headers'=> json_encode($header),
				'request'=> $attachment,
				'response'=> json_encode($delete_api_response['response']),
				'response_code'=>$responsecode,
				'origin_ip'=>$originip,
				'status'=>$status,
				'created_by'=>$userid
			);
			DB::table('api_logs')->insert($apilog_insert_array);
	    }
		
	    //echo $delete_api_response;
	    echo json_encode($delete_api_response,true);
	}

	
}