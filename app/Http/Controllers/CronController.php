<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Config;
use Log;

class CronController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        echo 'CronController@index';
        exit();
    }

    /**
	 * Create Label
	 */
	public function create_labels(Request $request)
	{

		$labeldetails_results = DB::select('select * from webhook_queues where status=0 ORDER BY id ASC LIMIT 2');
		if(!empty($labeldetails_results)){
			//$i=0;
			foreach($labeldetails_results as $label_obj){
			//for($i=0;$i<count($labeldetails_results);$i++){
				
				$userid = DB::table('users')->where('name',$label_obj->shop_domain)->select('id')->pluck('id')->first();
				$settingdata = DB::table('settings')->where(array('user_id'=>$userid,'is_from_address'=>1))->get();
				
				$webhook_data = json_decode($label_obj->body,true);
				//echo '<pre>';print_r($webhook_data['shipping_lines'][0]['title']);exit;
				if(isset($webhook_data)){

					$shipping_method = !empty($webhook_data['shipping_lines'][0]['title'])? $webhook_data['shipping_lines'][0]['title']:NULL;
					//$shipping_method = !empty($webhook_data['shipping_lines'][$i]['title'])? $webhook_data['shipping_lines'][$i]['title']:NULL;
					$carrier_methodname="SSTech Shipping";
					if(strpos($shipping_method, $carrier_methodname) !== FALSE) {
						$AccessKey = Config::get('constants.default_access_token'); //'00BF47B1559899C7F6ED19CF40914841A9D0B8BC7C95C59C25';
						$ContentType = 'application/json';
						$url = Config::get('constants.omni_label_url'); //'https://api.omniparcel.com/labels/printcheapestcourier';
						$header =array('Access_Key:'.$AccessKey,'Content-Type:'.$ContentType,'charset:utf-8');
						
						$countrydata = explode("-",$settingdata[0]->country);
						$country_shortname= !empty($countrydata[1])? $countrydata[1]:NULL;
						
							
						$webhook_request_data = [];
						$origin = [];
						$origin['Name'] = !empty($settingdata[0]->name)? $settingdata[0]->name:NULL;
						$origin['ContactPerson'] = !empty($settingdata[0]->contact_person)? $settingdata[0]->contact_person:NULL;
						$origin['phonenumber'] = !empty($settingdata[0]->phone)? $settingdata[0]->phone:NULL;
						$origin['email'] = !empty($settingdata[0]->label_receiver_email)? $settingdata[0]->label_receiver_email:NULL;
						
						$origin_address = [];
						$origin_address['BuildingName'] = !empty($settingdata[0]->address1)? $settingdata[0]->address1:NULL;
						$origin_address['StreetAddress'] = !empty($settingdata[0]->address2)? $settingdata[0]->address2:NULL;
						$origin_address['Suburb'] = !empty($settingdata[0]->province)? $settingdata[0]->province:NULL;
						$origin_address['City'] = !empty($settingdata[0]->city)? $settingdata[0]->city:NULL;
						$origin_address['PostCode'] = !empty($settingdata[0]->zip)? $settingdata[0]->zip:NULL;
						$origin_address['CountryCode'] = !empty($country_shortname)? $country_shortname:NULL;
						$origin['Address'] = $origin_address;
					
						$webhook_request_data['Origin'] = $origin;
						
						$destination = [];
						$destination['Id'] = !empty($webhook_data['customer']['id'])? $webhook_data['customer']['id']:NULL;
						$destination['Name'] = !empty($webhook_data['shipping_address']['name'])? $webhook_data['shipping_address']['name']:NULL;
						$destinationAddress = [];
						$destinationAddress['BuildingName'] = !empty($webhook_data['shipping_address']['address1'])? $webhook_data['shipping_address']['address1']:NULL;
						$destinationAddress['StreetAddress'] = !empty($webhook_data['shipping_address']['address2'])? $webhook_data['shipping_address']['address2']:NULL;
						$destinationAddress['Suburb'] = !empty($webhook_data['shipping_address']['province'])? $webhook_data['shipping_address']['province']:NULL;
						$destinationAddress['City'] = !empty($webhook_data['shipping_address']['city'])? $webhook_data['shipping_address']['city']:NULL;
						$destinationAddress['PostCode'] = !empty($webhook_data['shipping_address']['zip'])? $webhook_data['shipping_address']['zip']:NULL;
						$destinationAddress['CountryCode'] = !empty($webhook_data['shipping_address']['country_code'])? $webhook_data['shipping_address']['country_code']:NULL;
						$destination['Address'] = $destinationAddress;
						$destination['ContactPerson'] = !empty($webhook_data['shipping_address']['name'])? $webhook_data['shipping_address']['name']:NULL;
						$destination['phonenumber'] = !empty($webhook_data['shipping_address']['phone'])? $webhook_data['shipping_address']['phone']:NULL;
						$destination['email'] = !empty($webhook_data['customer']['email'])? $webhook_data['customer']['email']:NULL;
						$destination['DeliveryInstructions'] = NULL;
						
						
						$webhook_request_data['Destination'] = $destination;
						
						$packages = [];
						$packages[]=array(
								  'Height'=> 1,
								  'Length'=> 1,
								  'Width'=> 1,
								  'Kg'=> 1.25,
								  'Name'=> null,
								  'Type'=> 'BOX'
							);
						$webhook_request_data['Packages'] = $packages;	
					
						$commodities = [];
						foreach($webhook_data['line_items'] as $line_items){
							$commodities[]=array(
								'Description'=>$line_items['title'],
								'HarmonizedCode'=>'',
								'Units'=> $line_items['quantity'],
								'UnitValue'=> $line_items['price'],
								'UnitKg'=> $line_items['grams']/1000,
								'Currency'=> $webhook_data['customer']['currency'],
								'Country'=> $webhook_data['shipping_address']['country']
							);
						}
						
						$webhook_request_data['Commodities'] = $commodities;
						$webhook_request_data['PrintToPrinter'] = 'false';
						$webhook_request_data['Carrier'] = "";
						$webhook_request_data['Service'] = '';
						$webhook_request_data['outputs'] = array('LABEL_PDF');
						$webhook_request_data['issignaturerequired'] = 'false';
						$webhook_request_data['DeliveryReference'] =  rand(100000, 999999);
						$webhook_request_data['Reference3'] = 'RETAILER PAID';
						$webhook_request_data['IncludeLineDetails'] = 'true';
						//$webhook_request_data['ShipType'] = 'INBOUND';
						$webhook_request_data['SendTrackingEmail'] = 'false';
						$webhook_request_data['CostCentreName'] = '';
						
						$attachment = json_encode($webhook_request_data);
						/*
						$curl = curl_init();
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($curl, CURLOPT_URL, $url);
						curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
						curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
						curl_setopt($curl, CURLOPT_POSTFIELDS, $attachment);
						curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
						
						$available_rate_response = curl_exec($curl);
						*/
						$available_rate_call_curl = call_curl($url, $header, $attachment);
						$available_rate_response = $available_rate_call_curl['response'];
						//echo '<pre>';print_r($available_rate_response);exit;
						$available_rate_response_obj = json_decode($available_rate_response);
						unset($available_rate_response_obj->Consignments[0]->OutputFiles);
						$responsecode = empty($available_rate_response_obj->Errors)? 'Success':'Failed';
						//echo '<pre>';print_r($available_rate_response_obj->Consignments[0]);exit;
						$originip=$_SERVER['REMOTE_ADDR'];
						$apilog_insert_array=array(
						   'api_url'=>$url,
						   'user_id'=>$userid,
						   'request_type'=>'Label Rate',
						   'request_headers'=> json_encode($header),
						   'request'=> $attachment,
						   'response'=> json_encode($available_rate_response_obj),
						   'response_code'=>$responsecode,
						   'origin_ip'=>$originip,
						   'created_by'=>$userid
						); 
						DB::table('api_logs')->insert($apilog_insert_array);
						
						$consignmentno = !empty($available_rate_response_obj->Consignments[0]->Connote)? $available_rate_response_obj->Consignments[0]->Connote:NULL; 
						
						/*label details table insert data*/
						$labeldetails_insert_array=array(
						   'shopify_order_id'=>$webhook_data['id'],
						   //'shopify_order_id'=>'123',
						   'shopify_order_no'=>$webhook_data['name'],
						   'carrier_name'=>$available_rate_response_obj->CarrierName,
						   'consignment_no'=> $consignmentno,
						   'is_manifested'=> '0',
						   'status'=>'1',
						   'created_by'=>$userid,
						   'is_deleted'=>'0'
						); 
						DB::table('label_details')->insert($labeldetails_insert_array);
						
						$status = empty($available_rate_response_obj->Errors)? '1':'2';
						$webhookid = !empty($label_obj->id) ? $label_obj->id : null;
						DB::table('webhook_queues')->where('id',$webhookid)->update(['status' => $status]);
						
					}
					
				}
				
			}
			
		}
	}	
	
		 
	/*
	public function create_labels_old(Request $request)
	{
		$labeldetails_results = DB::select('select * from webhook_queues where status=0 ORDER BY id ASC LIMIT 2');
		//$labeldetails_results = DB::select('select * from webhook_queues where status=0 ORDER BY id DESC LIMIT 2');
		if(!empty($labeldetails_results)){
			$i=0;
			foreach($labeldetails_results as $label_obj){
				$userid = DB::table('users')->where('name',$label_obj->shop_domain)->select('id')->pluck('id')->first();
				$settingdata = DB::table('settings')->where(array('user_id'=>$userid,'is_from_address'=>1))->get();
				//echo '<pre>';print_r($labeldetails_results[$i]->body);exit;
				$webhook_data = json_decode($label_obj->body,true);
				if(isset($webhook_data)){

					$shipping_method = !empty($webhook_data['shipping_lines'][$i]['title'])? $webhook_data['shipping_lines'][$i]['title']:NULL;
					//$shipping_method = !empty($webhook_data['shipping_lines'][$i]['title'])? $webhook_data['shipping_lines'][$i]['title']:NULL;
					$carrier_methodname="SSTech Shipping";
					if(strpos($shipping_method, $carrier_methodname) !== FALSE) {
						$AccessKey = '00BF47B1559899C7F6ED19CF40914841A9D0B8BC7C95C59C25';
						$ContentType = 'application/json';
						$url = 'https://api.omniparcel.com/labels/printcheapestcourier';
						$header =array('Access_Key:'.$AccessKey,'Content-Type:'.$ContentType,'charset:utf-8');
						
						$countrydata = explode("-",$settingdata[$i]->country);
						$country_shortname= !empty($countrydata[1])? $countrydata[1]:NULL;
						
							
						$webhook_request_data = [];
						$origin = [];
						$origin['Name'] = !empty($settingdata[$i]->name)? $settingdata[$i]->name:NULL;
						$origin['ContactPerson'] = !empty($settingdata[$i]->contact_person)? $settingdata[$i]->contact_person:NULL;
						$origin['phonenumber'] = !empty($settingdata[$i]->phone)? $settingdata[$i]->phone:NULL;
						$origin['email'] = !empty($settingdata[$i]->label_receiver_email)? $settingdata[$i]->label_receiver_email:NULL;
						
						$origin_address = [];
						$origin_address['BuildingName'] = !empty($settingdata[$i]->address1)? $settingdata[$i]->address1:NULL;
						$origin_address['StreetAddress'] = !empty($settingdata[$i]->address2)? $settingdata[$i]->address2:NULL;
						$origin_address['Suburb'] = !empty($settingdata[$i]->province)? $settingdata[$i]->province:NULL;
						$origin_address['City'] = !empty($settingdata[$i]->city)? $settingdata[$i]->city:NULL;
						$origin_address['PostCode'] = !empty($settingdata[$i]->zip)? $settingdata[$i]->zip:NULL;
						$origin_address['CountryCode'] = !empty($country_shortname)? $country_shortname:NULL;
						$origin['Address'] = $origin_address;
					
						$webhook_request_data['Origin'] = $origin;
						
						$destination = [];
						$destination['Id'] = !empty($webhook_data['customer']['id'])? $webhook_data['customer']['id']:NULL;
						$destination['Name'] = !empty($webhook_data['shipping_address']['name'])? $webhook_data['shipping_address']['name']:NULL;
						$destination['ContactPerson'] = !empty($webhook_data['shipping_address']['name'])? $webhook_data['shipping_address']['name']:NULL;
						$destination['phonenumber'] = !empty($webhook_data['shipping_address']['phone'])? $webhook_data['shipping_address']['phone']:NULL;
						$destination['email'] = !empty($webhook_data['customer']['email'])? $webhook_data['customer']['email']:NULL;
						$destination['DeliveryInstructions'] = NULL;
						
						$destinationAddress = [];
						$destinationAddress['BuildingName'] = !empty($webhook_data['shipping_address']['address1'])? $webhook_data['shipping_address']['address1']:NULL;
						$destinationAddress['StreetAddress'] = !empty($webhook_data['shipping_address']['address2'])? $webhook_data['shipping_address']['address2']:NULL;
						$destinationAddress['Suburb'] = !empty($webhook_data['shipping_address']['province'])? $webhook_data['shipping_address']['province']:NULL;
						$destinationAddress['City'] = !empty($webhook_data['shipping_address']['city'])? $webhook_data['shipping_address']['city']:NULL;
						$destinationAddress['PostCode'] = !empty($webhook_data['shipping_address']['zip'])? $webhook_data['shipping_address']['zip']:NULL;
						$destinationAddress['CountryCode'] = !empty($webhook_data['shipping_address']['country_code'])? $webhook_data['shipping_address']['country_code']:NULL;
						$destination['Address'] = $destinationAddress;
						$webhook_request_data['Destination'] = $destination;
						
						$packages = [];
						$packages[]=array(
								  'Height'=> 1,
								  'Length'=> 1,
								  'Width'=> 1,
								  'Kg'=> 1.25,
								  'Name'=> null,
								  'Type'=> 'BOX'
							);
						$webhook_request_data['Packages'] = $packages;	
						
						
						
						$commodities = [];
						$commodities[]=array(
							'Description'=>$webhook_data['line_items'][$i]['title'],
							'Units'=> $webhook_data['line_items'][$i]['quantity'],
							'UnitValue'=> $webhook_data['line_items'][$i]['price'],
							'UnitKg'=> $webhook_data['line_items'][$i]['grams']/1000,
							'Currency'=> $webhook_data['customer']['currency'],
							'Country'=> $webhook_data['shipping_address']['country']
						);
						
						$webhook_request_data['Commodities'] = $commodities;
						$webhook_request_data['PrintToPrinter'] = false;
						$webhook_request_data['Carrier'] = "";
						$webhook_request_data['Service'] = '';
						$webhook_request_data['outputs'] = array('LABEL_PDF');
						$webhook_request_data['issignaturerequired'] = false;
						$webhook_request_data['DeliveryReference'] =  rand(100000, 999999);
						$webhook_request_data['Reference3'] = '';
						$webhook_request_data['IncludeLineDetails'] = true;
						$webhook_request_data['ShipType'] = 'INBOUND';
						$webhook_request_data['SendTrackingEmail'] = false;
						$webhook_request_data['CostCentreName'] = '';
						
						$attachment = json_encode($webhook_request_data);
						$curl = curl_init();
						curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($curl, CURLOPT_URL, $url);
						curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
						curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
						curl_setopt($curl, CURLOPT_POSTFIELDS, $attachment);
						curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
						
						$available_rate_response = curl_exec($curl);
						//echo '<pre>';print_r($available_rate_response);
						
						$available_rate_response_obj = json_decode($available_rate_response);
						unset($available_rate_response_obj->Consignments[0]->OutputFiles);
						$responsecode = empty($available_rate_response_obj->Errors)? 'Success':'Failed';
						$originip=$_SERVER['REMOTE_ADDR'];
						$apilog_insert_array=array(
						   'api_url'=>$url,
						   'user_id'=>$userid,
						   'request_type'=>'Label Rate',
						   'request_headers'=> json_encode($header),
						   'request'=> $attachment,
						   'response'=>json_encode($available_rate_response_obj),
						   'response_code'=>$responsecode,
						   'origin_ip'=>$originip,
						   'created_by'=>$userid
						); 
						DB::table('api_logs')->insert($apilog_insert_array);
						
						$consignmentno = !empty($available_rate_response_obj->Consignments[$i]->Connote)? $available_rate_response_obj->Consignments[$i]->Connote:NULL; 
						
						//label details table insert data
						$labeldetails_insert_array=array(
						   'shopify_order_id'=>$webhook_data['id'],
						   //'shopify_order_id'=>'123',
						   'shopify_order_no'=>$webhook_data['name'],
						   'carrier_name'=>$available_rate_response_obj->CarrierName,
						   'consignment_no'=> $consignmentno,
						   'is_manifested'=> '0',
						   'status'=>'1',
						   'created_by'=>$userid,
						   'is_deleted'=>'0'
						); 
						DB::table('label_details')->insert($labeldetails_insert_array);
						
						$status = empty($available_rate_response_obj->Errors)? '1':'2';
						$webhookid = !empty($label_obj->id) ? $label_obj->id : null;
						DB::table('webhook_queues')->where('id',$webhookid)->update(['status' => $status]);
						
					}
					
				}
			$i++;	
			}
		}
		
	}
	*/
}