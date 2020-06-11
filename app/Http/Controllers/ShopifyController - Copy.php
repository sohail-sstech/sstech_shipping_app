<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Log;

class ShopifyController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $shop = Auth::user();
        $shop_request = $shop->api()->rest('GET', '/admin/shop.json');
        //echo $request->body->shop->name;
        echo '<pre>'; 
        print_r($shop_request->body->shop); 
        echo '</pre>';
    }

    /**
     * Get shop data
     *
     * @param  Request  $request
     * @return Response
     */
    public function get_shop(Request $request)
    {
		
        $shop = Auth::user();
        $get_shop_data = $shop->api()->rest('GET', '/admin/shop.json');
        //echo $request->body->shop->name;
       // echo '<pre>';
       // echo '<h1>Shop Data</h1>';
        //echo $value = config('shopify-app.api_version').'<br/>';
        //print_r($get_shop_data->body->shop);
		// print_r($get_shop_data->body->shop);exit;
		 $shop_data = array(
            'shop_id'=>$get_shop_data->body->shop->id,
            'shop_name'=>$get_shop_data->body->shop->name,
            'shop_email'=>$get_shop_data->body->shop->email,
            'shop_province'=>$get_shop_data->body->shop->province,
            'shop_country'=>$get_shop_data->body->shop->country,
            'shop_address1'=>$get_shop_data->body->shop->address1,
            'shop_zip'=>$get_shop_data->body->shop->zip,
            'shop_city'=>$get_shop_data->body->shop->city,
            'shop_phone'=>$get_shop_data->body->shop->phone,
            'shop_country_code'=>$get_shop_data->body->shop->country_code,
            'shop_country_name'=>$get_shop_data->body->shop->country_name,
            'shop_currency'=>$get_shop_data->body->shop->currency,
            'shop_customer_email'=>$get_shop_data->body->shop->customer_email,
            );
        return view('theme.shop_view')->with($shop_data);
		 //return view('pages.contact')->with($data);
       // echo '</pre>';
       // exit();
    }
    /**
     * Get product data
     *
     * @param  Request  $request
     * @return Response
     */
    public function get_products(Request $request)
    {
        $shop = Auth::user();
        $get_product_data = $shop->api()->rest('GET', '/admin/api/' . config('shopify-app.api_version') . '/products.json', ['limit' => 10]);
        //echo $request->body->shop->name;
        /*echo '<pre>'; 
        echo '<h1>Product Data</h1>';
        print_r($get_product_data->body->products); 
        echo '</pre>';
        exit();*/
		
		$products_data = $get_product_data->body->products;
		//$productdetails = array('productdetails'=>$products_data);
		/*$i=0;
		foreach($products_data as $object){
			echo '<pre>'; 
		 echo '<h1>Product Data</h1>';
        print_r($object->body_html); 
        echo '</pre>';	
		$i++;
		}
		exit;*/
		return view('theme.product_view')->with('details',$products_data);
    }

    /**
     * Get order data
     *
     * @param  Request  $request
     * @return Response
     */
    public function get_orders(Request $request)
    {
        $shop = Auth::user();
        $get_orders_data = $shop->api()->rest('GET', '/admin/api/' . config('shopify-app.api_version') . '/orders.json', ['limit' => 10]);
        //echo $request->body->shop->name;
        echo '<pre>'; 
        echo '<h1>Orders Data</h1>';
        print_r($get_orders_data->body->orders); 
        echo '</pre>';
        exit();
		 return view('theme.order_view')->with($data);
    }
	
	/*Create Carrier Service*/
	public function create_carrierservice()
	{
		$shop = Auth::user();
		$carrier_service = $shop->api()->rest('POST', '/admin/api/' . config('shopify-app.api_version') . '/carrier_services.json', 
		array
		(
		 'carrier_service' => array
			(
			   "name" => "Sstech Shipping Rate Provider",
			   "callback_url" => "https://e60d4113da23.ngrok.io/api/shippingrates",
			   "format" => "json",
			   "active" => true,
			   "service_discovery" => true
		    )
		));
		
		if($carrier_service->status==201){
			echo 'carrier service created succesfully.';
		}
		//echo '<pre>';print_r($carrier_service);exit;
	  //echo '<pre>';print_r($carrier_service);exit;
		/*$carrier_request = $shop->api()->rest('POST', '/admin/api/' . config('shopify-app.api_version') . '/carrier_services.json', 
		$shop_request = $shop->api()->rest('POST', '/admin/carrier_services.json',
		{
		  "carrier_service":
		  {
			"name": "Sstech Shipping Rate Provider",
			"callback_url": "https://da6a3259.ngrok.io/",
			"service_discovery": true
		  }
		}
		);*/
		
		
	}
	
	/*View all carrier services*/
	public function view_carrierservices()
	{
		$shop = Auth::user();
        $list_carrierservices = $shop->api()->rest('GET', '/admin/api/' . config('shopify-app.api_version') . '/carrier_services.json');
		echo '<pre>';print_r($list_carrierservices->body);exit;
	}
	/*View all carrier services*/
	public function delete_carrierservice(Request $request)
	{
		 //dd($request->all());
		$shop = Auth::user();
		$carrierid = $request->carrrierid;
		if(!empty($carrierid)){
			$delete_carrierservices = $shop->api()->rest('DELETE', '/admin/api/' . config('shopify-app.api_version') . '/carrier_services/'.$carrierid.'.json');	
			if($delete_carrierservices->status==200){
				echo 'carrier services deleted succesfully';
			}
		}
		else{
			echo 'Carrier Id is Rquired Field';
		}
		/* echo '<pre>'; 
        print_r($carrierid); 
        echo '</pre>';
		exit;*/
		
        
		//echo '<pre>';print_r($list_carrierservices);exit;
	}



	
	public function getshipping_rates(Request $request)
	{		

		$shopify_request = file_get_contents('php://input');
		$request_data = json_decode($shopify_request,true);
		//print_r($request_data);exit;
		/*$header =getallheaders();
		if(empty($header['Access_Key']))
		{
				$message['success'] = "0"; 
				$message['message'] =  'Missing Apikey in header.';
				echo json_encode($message); exit;
		}
		else{
			$AccessKey = $header['Access_Key'];
			$ContentType = $header['Content-Type'];
		}*/
		$AccessKey = '00BF47B1559899C7F6ED19CF40914841A9D0B8BC7C95C59C25';
		$ContentType = 'application/json';
		$url = 'https://api.omniparcel.com/labels/availablerateswithvalidation';
		$header =array('Access_Key:'.$AccessKey,'Content-Type:'.$ContentType,'charset:utf-8'); 
		
		
		$commodities=array();
		foreach($request_data['rate']['items'] as $item){
			$commodities[]=array(
				'Description'=>$item['name'],
				'Units'=> $item['quantity'],
				'UnitValue'=> $item['price'],
				'UnitKg'=> $item['grams']/1000,
				'Currency'=> $request_data['rate']['currency'],
				'Country'=> $request_data['rate']['origin']['country']
			);
		}
		$packages = array();
		$packages[]=array(
				'Height'=> 1,
				  'Length'=> 1,
				  'Width'=> 1,
				  'Kg'=> 1.25,
				  'Name'=> null,
				  'Type'=> 'BOX'
			);
		
		
		$shopifyrequest_data = array(
			'DeliveryReference'=>'123',
			'Origin'=> array(
						'Name'=>$request_data['rate']['origin']['company_name'],
						'ContactPerson'=>$request_data['rate']['origin']['name'],
						'phonenumber'=>$request_data['rate']['origin']['phone'],
						'email'=>$request_data['rate']['origin']['email'],
						'Address'=>array(
									'BuildingName'=>$request_data['rate']['origin']['address1'],
									'StreetAddress'=>$request_data['rate']['origin']['address2'],
									'Suburb'=>$request_data['rate']['origin']['city'],
									'City'=>$request_data['rate']['origin']['city'],
									'PostCode'=>$request_data['rate']['origin']['postal_code'],
									'CountryCode'=>$request_data['rate']['origin']['country']
									)
						
						),
			'Destination'=> array(
						'Id'=>0,
						'Name'=>$request_data['rate']['destination']['name'],
						'ContactPerson'=>$request_data['rate']['destination']['name'],
						'phonenumber'=>$request_data['rate']['destination']['phone'],
						'email'=>$request_data['rate']['destination']['email'],
						'liveryInstructions'=> null,
						'Address'=>array(
									'BuildingName'=>$request_data['rate']['destination']['address1'],
									'StreetAddress'=>$request_data['rate']['destination']['address2'],
									'Suburb'=>$request_data['rate']['destination']['city'],
									'City'=>$request_data['rate']['destination']['city'],
									'PostCode'=>$request_data['rate']['destination']['postal_code'],
									'CountryCode'=>$request_data['rate']['destination']['country']
									)
						
						),
			'Packages'=>$packages,
				
			'Commodities'=>$commodities,
			
			 'issignaturerequired'=> false,
			  'PrintToPrinter'=> false,
			  'Carrier'=> '',
			  'Service'=> '',
			  'outputs'=> '',
			  'IncludeLineDetails'=> true,
			  'ShipType'=> 'INBOUND',
			  'SendTrackingEmail'=> false,
			  'CostCentreName'=>'' 	
		);
	
		$attachment = json_encode($shopifyrequest_data);
		$header_logdata =$header;
		$attachment_logdata = json_encode($shopifyrequest_data);
		$request_parameter['Parameteres']['Header'] =  $header;				
		$request_parameter['Parameteres']['Body'] =  json_decode($attachment_logdata);//array($attachment);
		//$apirequest = json_encode($request_parameter);
		$apirequest = json_encode($request_parameter);
		$response='Success';
		$responsecode='1';
		/*$currentdt= date('Y-m-d h:i:s');
		$starttime = new DateTime($currentdt);*/
		$getorigin=$_SERVER['REMOTE_ADDR'];
		$originip=$getorigin;
		$requestby = $AccessKey;
		/*$endtime= date('Y-m-d h:i:s');
		$endtime = new DateTime($endtime);
		$dtendtime = $endtime->format('Y-m-d h:i:s');
		$dtstarttime = $starttime->format('Y-m-d h:i:s');
		$dteStart = new DateTime($dtstarttime); 
		$dteEnd   = new DateTime($dtendtime); 
		$dteDiff  = $dteStart->diff($dteEnd); 
		$response_time = $dteDiff->format("%H:%I:%S"); */
		$apilog_insert_array=array(
				   'apiurl'=>$url,
				   'requesttype'=>'Shipping Rate Api Rquest',
				   'request'=> $apirequest,
				   'response'=>$response,
				   'responsecode'=>$responsecode,
				   'originip'=>$originip,
				   'requestby'=>$requestby
				   //'responsetime'=>$response_time,
				   //'CreatedAt'=>$dtstarttime,
			  ); 
			  
		/*insert request into api_log table*/	  
	    DB::table('api_logs')->insert($apilog_insert_array);
		
		//print_r($attachment);exit;
		//$AccessKey = '00BF47B1559899C7F6ED19CF40914841A9D0B8BC7C95C59C25';
		/*$url = 'https://api.omniparcel.com/labels/availablerateswithvalidation';
		$header =array('Access_Key:'.$AccessKey,'Content-Type: application/json','charset:utf-8'); 
		
		$attachment = "
		{
			  'DeliveryReference': '#1145',
			  'Reference2': '',
			  'Reference3': '',
			  'Origin': {
				'Name': 'Jamie Ds Emporium',
				'ContactPerson': 'Sohail Anjum gmail',
				'phonenumber': '16135551212',
				'email': 'sstech.sohail@gmail.com',
				'Address': {
				  'BuildingName': '1024',
				  'StreetAddress': '150 Elgin St.',
				  'Suburb': 'Ottawa',
				  'City': 'Ottawa',
				  'PostCode': 'K2P1L4',
				  'CountryCode': 'CA'
				}
			  },
			  'Destination': {
				'Id': 0,
				'Name': 'Bob Norman',
				'ContactPerson': 'Bob Norman',
				'phonenumber': ,
				'email': 'support@omniparcel.com',
				'liveryInstructions': null,
				'Address': {
				  'BuildingName': '1550',
				  'StreetAddress': '24 Sussex Dr.',
				  'Suburb': 'Ottawa',
				  'City': 'Ottawa',
				  'PostCode': 'K1M1M4',
				  'CountryCode': 'CA'
				}
			  },
			  'Packages': [
				{
				  'Height': 1,
				  'Length': 1,
				  'Width': 1,
				  'Kg': 1.25,
				  'Name': null,
				  'Type': 'BOX'
				}
			  ],
			  'Commodities': [
				{
				  'Description': 'Short Sleeve T-Shirt',
				  'Units': '1',
				  'UnitValue': '1999.00',
				  'UnitKg': '1000',
				  'Currency': 'USD',
				  'Country': 'US'
				}
			  ],
			  'issignaturerequired': false,
			  'PrintToPrinter': false,
			  'Carrier': '',
			  'Service': '',
			  'outputs': '',
			  'IncludeLineDetails': true,
			  'ShipType': 'INBOUND',
			  'SendTrackingEmail': false,
			  'CostCentreName':'' 
			}
		";*/
		
		
		// set the target url
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($curl, CURLOPT_POSTFIELDS, $attachment);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		//curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

		$resp = curl_exec($curl);
		
			
		/*store response from omni parcel api */
		$request_parameter['Parameteres']['Header'] =  $header;				
		$request_parameter['Parameteres']['Body'] =  json_decode($resp);//array($attachment);
		$apirequest = json_encode($request_parameter);
		$response='Success';
		$responsecode='1';
		$getorigin=$_SERVER['REMOTE_ADDR'];
		$originip=$getorigin;
		$requestby = $AccessKey;
		$apilog_insert_array=array(
				   'apiurl'=>$url,
				   'requesttype'=>'Omni Shipping Rate Response',
				   'request'=> $apirequest,
				   'response'=>$response,
				   'responsecode'=>$responsecode,
				   'originip'=>$originip,
				   'requestby'=>$requestby
				   //'responsetime'=>$response_time,
				   //'CreatedAt'=>$dtstarttime,
			  ); 
			  
		/*insert request into api_log table*/	  
	    DB::table('api_logs')->insert($apilog_insert_array);
		
		$jsondata = json_decode($resp);
		//$myarray = array();
		
		foreach($jsondata->Available as $rates)
		{
				$myarray['rates'][] = 
				array(
					'service_name'=>$rates->DeliveryType,
					'service_code'=>$rates->Route,
					'total_price'=> $rates->Cost,
					'description'=>$rates->CarrierName,
					'currency'=>"NZD"
				);
		}
		
		//print_r($myarray);exit;
		
		/*shipping rate api response set */
		//$store_response = json_encode($myarray);
		$store_response = json_encode($myarray);
		
		$request_parameter['Parameteres']['Header'] =  $header;				
		$request_parameter['Parameteres']['Body'] =  json_decode($store_response);//array($attachment);
		$apirequest = json_encode($request_parameter);
		$response='Success';
		$responsecode='1';
		$getorigin=$_SERVER['REMOTE_ADDR'];
		$originip=$getorigin;
		$requestby = $AccessKey;
		$apilog_insert_array=array(
				   'apiurl'=>$url,
				   'requesttype'=>'Omni Shipping Rate Response',
				   'request'=> $apirequest,
				   'response'=>$response,
				   'responsecode'=>$responsecode,
				   'originip'=>$originip,
				   'requestby'=>$requestby
				   //'responsetime'=>$response_time,
				   //'CreatedAt'=>$dtstarttime,
			  ); 
			  
		/*insert request into api_log table*/	  
	    DB::table('api_logs')->insert($apilog_insert_array);
		
		//$response_arr = json_decode($item);
		$response = \Response::json($myarray, 200);
		
		//echo '<pre>';print_r($response);exit;
		return $response;
	}
	
	
	
	
	
	/*public function getshipping_rates_old(Request $request)
	{
		$item = '
				{
				   "rates": [
					   {
						   "service_name": "canadapost-overnight",
						   "service_code": "ON",
						   "total_price": "1295",
						   "description": "This is the fastest option by far",
						   "currency": "NZD"
					   },
					   {
						   "service_name": "fedex-2dayground",
						   "service_code": "2D",
						   "total_price": "2934",
						   "currency": "NZD"
					   },
					   {
						   "service_name": "fedex-priorityovernight",
						   "service_code": "1D",
						   "total_price": "3587",
						   "currency": "NZD"
					   }
				   ]
				}
		';	
		
		$response_arr = json_decode($item);
		$response = \Response::json($response_arr, 200);
		
		return $response;
	
	}*/
	
}
