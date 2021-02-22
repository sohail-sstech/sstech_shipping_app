<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Config;
use Log;

class RestController extends Controller
{

    /**
     * Index action
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
	{
        echo 'ApiController@index';
        exit();
	}
	
    /**
	 * Generate shipping rates
	 */
	public function getshipping_rates(Request $request) 
	{
		$apache_request_headers = apache_request_headers();
		$shop_domain = (isset($apache_request_headers['X-Shopify-Shop-Domain'])) ? $apache_request_headers['X-Shopify-Shop-Domain'] : NULL;
		/*if(isset($_GET['store_domain'])) {
			$shop_domain = $_GET['store_domain'];
		}*/
		$user_id = DB::table('users')->where('name', $shop_domain)->select('id')->pluck('id')->first();
		$shopify_header = json_encode(getallheaders());
		$shopify_request = file_get_contents('php://input');
		$request_data = json_decode($shopify_request,true);
		//echo '<pre>';print_r($request_data);exit;
		
		$resp = null;
		if(!empty($request_data)) {
			$access_key = Config::get('constants.default_access_token'); //'00BF47B1559899C7F6ED19CF40914841A9D0B8BC7C95C59C25';
			$content_type = 'application/json';
			$url = Config::get('constants.omni_rate_url'); //'https://api.omniparcel.com/labels/availablerateswithvalidation';
			$header = array(	
				'Access_Key: '.$access_key,
				'Content-Type: '.$content_type,
				'charset: utf-8'
			);
			/*
			$commodities = [];
			foreach($request_data['rate']['items'] as $item) {
				$commodities[] = array(
					'Description'=>$item['name'],
					'Units'=> $item['quantity'],
					'UnitValue'=> $item['price'],
					'UnitKg'=> $item['grams']/1000,
					'Currency'=> $request_data['rate']['currency'],
					'Country'=> $request_data['rate']['origin']['country']
				);
			}
			$packages = [];
			$packages[] = array(
					'Height'=> 1,
					'Length'=> 1,
					'Width'=> 1,
					'Kg'=> 1.25,
					'Name'=> null,
					'Type'=> 'BOX'
			);
			*/
			$shopify_request_data = [];
			$shopify_request_data['DeliveryReference'] = rand(100000, 999999);
			$shopify_request_data['Reference2'] = "";
			$shopify_request_data['Reference3'] = "";
			//origin data
			$origin = [];
			$origin['Name'] = !empty($request_data['rate']['origin']['company_name'])?$request_data['rate']['origin']['company_name']:NULL;
			$origin['ContactPerson'] = !empty($request_data['rate']['origin']['name'])?$request_data['rate']['origin']['name']:NULL;
			$origin['PhoneNumber'] = !empty($request_data['rate']['origin']['phone'])?$request_data['rate']['origin']['phone']:NULL;
			$origin['Email'] = !empty($request_data['rate']['origin']['email'])?$request_data['rate']['origin']['email']:NULL;
			$origin_address = [];
			$origin_address['BuildingName'] = !empty($request_data['rate']['origin']['address2'])?$request_data['rate']['origin']['address2']:NULL;
			$origin_address['StreetAddress'] = !empty($request_data['rate']['origin']['address1'])?$request_data['rate']['origin']['address1']:NULL;
			$origin_address['Suburb'] = !empty($request_data['rate']['origin']['city'])?$request_data['rate']['origin']['city']:NULL;
			$origin_address['City'] = !empty($request_data['rate']['origin']['province'])?$request_data['rate']['origin']['province']:NULL;
			$origin_address['PostCode'] = !empty($request_data['rate']['origin']['postal_code'])?$request_data['rate']['origin']['postal_code']:NULL;
			$origin_address['CountryCode'] = !empty($request_data['rate']['origin']['country'])?$request_data['rate']['origin']['country']:NULL;
			$origin['Address'] = $origin_address;
			$shopify_request_data['Origin'] = $origin;
			//destination data
			$destination = [];
			$destination['Name'] = !empty($request_data['rate']['destination']['company_name'])?$request_data['rate']['destination']['company_name']:NULL;
			$destination['ContactPerson'] = !empty($request_data['rate']['destination']['name'])?$request_data['rate']['destination']['name']:NULL;
			$destination['PhoneNumber'] = !empty($request_data['rate']['destination']['phone'])?$request_data['rate']['destination']['phone']:NULL;
			$destination['Email'] = !empty($request_data['rate']['destination']['email'])?$request_data['rate']['destination']['email']:NULL;
			$destinationAddress = [];
			$destinationAddress['BuildingName'] = !empty($request_data['rate']['destination']['address2'])?$request_data['rate']['destination']['address2']:NULL;
			$destinationAddress['StreetAddress'] = !empty($request_data['rate']['destination']['address1'])?$request_data['rate']['destination']['address1']:NULL;
			$destinationAddress['Suburb'] = !empty($request_data['rate']['destination']['city'])?$request_data['rate']['destination']['city']:NULL;
			$destinationAddress['City'] = !empty($request_data['rate']['destination']['province'])?$request_data['rate']['destination']['province']:NULL;
			$destinationAddress['PostCode'] = !empty($request_data['rate']['destination']['postal_code'])?$request_data['rate']['destination']['postal_code']:NULL;
			$destinationAddress['CountryCode'] = !empty($request_data['rate']['destination']['country'])?$request_data['rate']['destination']['country']:NULL;
			$destination['Address'] = $destinationAddress;
			$shopify_request_data['Destination'] = $destination;
			//pachage data
			$packages = [];
			$packages[] = array(
					'Height'=> 1,
					'Length'=> 1,
					'Width'=> 1,
					'Kg'=> 1.25,
					'Name'=> null,
					'Type'=> 'BOX'
			);
			$shopify_request_data['Packages'] = $packages;
			//commodity data
			$commodities = [];
			foreach($request_data['rate']['items'] as $item) {
				$commodities[] = array(
					'Description'=>$item['name'],
					'Units'=> $item['quantity'],
					'UnitValue'=> $item['price'],
					'UnitKg'=> $item['grams']/1000,
					'Currency'=> $request_data['rate']['currency'],
					'Country'=> $request_data['rate']['origin']['country']
				);
			}
			$shopify_request_data['Commodities'] = $commodities;
			//Others
			$shopify_request_data['issignaturerequired'] = false;
			$shopify_request_data['PrintToPrinter'] = false;
			$shopify_request_data['Carrier'] = "";
			$shopify_request_data['Service'] = "";
			$shopify_request_data['outputs'] = "";
			$shopify_request_data['IncludeLineDetails'] = true;
			//$shopify_request_data['ShipType'] = "INBOUND";
			$shopify_request_data['SendTrackingEmail'] = false;
			$shopify_request_data['CostCentreName'] = "";

			//JSON encode data
			$attachment = json_encode($shopify_request_data);

			/*
			echo $url . "<br/>";
			echo json_encode($header) . "<br/>";
			echo $attachment;
			exit();
			*/

			/*
			// set the target url
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($curl, CURLOPT_POSTFIELDS, $attachment);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			//curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
			$available_rate_response = curl_exec($curl);
			*/
			$available_rate_call_curl = call_curl($url, $header, $attachment);
			$available_rate_response = $available_rate_call_curl['response'];
			
			$available_rate_response_obj = json_decode($available_rate_response);
			//print_r($response);exit;
			if(!empty($available_rate_response_obj->Available)) {
				$response_code = 'Success';
			} else {
				$response_code = 'Failure';	
			}
			//$requestheader = $header;
			$origin_ip = $_SERVER['REMOTE_ADDR'];
			//$origin_ip = $getorigin;
			$apilog_insert_array=array(
				'user_id' => $user_id,
				'api_url' => $url,
				'request_type' => 'Available Rate',
				'request_headers'=> json_encode($header),
				'request' => $attachment,
				'response' => $available_rate_response,
				'response_code' => $response_code,
				'origin_ip' => $origin_ip,
				'created_by' => $user_id
			);
	    	DB::table('api_logs')->insert($apilog_insert_array);
		}
		//JSON encode data
		$available_rate_response_obj = json_decode($available_rate_response);
		$shipping_rates_arr = array();
		if(!empty($available_rate_response_obj->Available)) {
			$i=0; $service_name_arr = [];
			foreach($available_rate_response_obj->Available as $rates) {
					$sevice_name = 'SSTech Shipping'.' '.$rates->DeliveryType;
					$service_name_arr[] = $sevice_name;
					$count_values = array_count_values($service_name_arr);
					if($count_values[$sevice_name] > 1) {
						$sevice_name = $sevice_name . ' - ' . $count_values[$sevice_name];
					}
					$shipping_rates_arr['rates'][] = array(
						'id' => $i,
						'service_name' => $sevice_name,
						'service_code' => $rates->Route,
						'total_price' => $rates->Cost * 100,
						'description' => $rates->CarrierName . ' - ' . $rates->CarrierServiceType,
						'currency' => $request_data['rate']['currency']
					);
				$i++;		
			}
		}
		$shipping_rates_response_str = json_encode($shipping_rates_arr);
		$response_code = 'Success';
		$origin_ip = $_SERVER['REMOTE_ADDR'];
		$apilog_insert_array=array (
			'user_id' => $user_id,
			'api_url' => NULL,
			'request_type'=>'Shipping Rate',
			'request_headers'=> $shopify_header,
			'request'=> $shopify_request,
			'response' => $shipping_rates_response_str,
			'response_code' => $response_code,
			'origin_ip' => $origin_ip,
			'created_by' => $user_id
		);
	    DB::table('api_logs')->insert($apilog_insert_array);
		//$response_arr = json_decode($item);
		$response = \Response::json($shipping_rates_arr, 200);
		//echo '<pre>';print_r($response);exit;
		return $response;
	}
	
	/**
	 * Test get shipping rates 
	 */
	public function getshipping_rates_test() {
		
		
		$shop_domain="";
		if(isset($_GET['store_domain'])) {
			$shop_domain = $_GET['store_domain'];
		}
		//echo '<pre>';print_r($shop_domain);exit;
		$shopify_header = json_encode(getallheaders());
		$shopify_request = file_get_contents('php://input');
		
		$item = '{
				   "rates": [
					   {
						   "service_name": "canadapost-overnight",
						   "description":"Canadapost Overnight Service",
						   "service_code": "ON",
						   "total_price": "1295",
						   "currency": "USD"
					   },
					   {
						   "service_name": "fedex-2dayground",
						   "description":"Fedex 2 Day Ground Service",
						   "service_code": "2D",
						   "total_price": "2934",
						   "currency": "USD"
					   },
					   {
						   "service_name": "fedex-priorityovernight",
						   "description":"Fedex Priority Overnight Service",
						   "service_code": "1D",
						   "total_price": "3587",
						   "currency": "USD"
					   }
				   ]
				}';
		
		$apilog_insert_array = array(
			'user_id'=>'123',
			'api_url'=>null,
			'request_type'=>'Shipping Rate',
			'request_headers'=> $shopify_header,
			'request'=> $shopify_request,
			'response'=> json_encode(json_decode($item)),
			'response_code'=>'success',
			'origin_ip'=>'1.2.3.4',
			'created_by'=>123
		);
	    DB::table('api_logs')->insert($apilog_insert_array);
		
		$response_arr = json_decode($item);
		$response = \Response::json($response_arr, 200);
		//echo '<pre>';print_r($response);exit;
		return $response;
	}
   
}