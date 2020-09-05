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
    public function get_shop(Request $request) {
		
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
    }
	
	/**
	 * Get shop details
	 */
	public function getshop_details(Request $request) {
		$shop = Auth::user();
        $get_shop_data = $shop->api()->rest('GET', '/admin/shop.json');
		echo '<pre>';print_r($get_shop_data->body->shop);exit;
		// Create options for the API
		//$options = new BasicShopifyAPI();
		//$options->setVersion('2020-04');

		//Create the client and session
		$api = new BasicShopifyAPI();
		//$api->setType(true);
		$api->setVersion('2020-04');
		$api->setApiKey('675cd25b6dbb54255775f0811deaa12a');
		$api->setApiSecret('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');
		//$api->setApiKey('675cd25b6dbb54255775f0811deaa12a');
		//$api->setApiPassword('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');
		$api->setSession('newzeland-laravel-shipping-app.myshopify.com','fd40104007e7dd9bce9ac07e3f343585-1592914803');
		//$shop_data = $api->rest('GET','/admin/2020-04/shop.json');
		$shop_data = $api->rest('GET', '/admin/api/' . config('shopify-app.api_version') . '/shop.json', ['limit' => 10]);
		//$shop_data = $api->api()->rest('GET', '/admin/api/' . config('shopify-app.api_version') . '/shop.json');
		echo '<pre>'; print_r($shop_data->body); exit();
    }
	
    /**
     * Get product data
     *
     * @param  Request  $request
     * @return Response
     */
    public function get_products(Request $request) {
        $shop = Auth::user();
        $get_product_data = $shop->api()->rest('GET', '/admin/api/' . config('shopify-app.api_version') . '/products.json', ['limit' => 10]);
        //echo $request->body->shop->name;
		/*
		echo '<pre>'; 
        echo '<h1>Product Data</h1>';
        print_r($get_product_data->body->products); 
        echo '</pre>';
		exit();
		*/
		$products_data = $get_product_data->body->products;
		return view('theme.product_view')->with('details',$products_data);
    }

    /**
     * Get order data
     *
     * @param  Request  $request
     * @return Response
     */
    public function get_orders(Request $request) {
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
	
	/**
	 * Create Carrier Service
	 */
	public function create_carrierservice() {
		$shop = Auth::user();
		$shop_request = $shop->api()->rest('GET', '/admin/shop.json');
		$shop_domain = $shop_request->body->shop->domain;
		$carrier_service = $shop->api()->rest('POST', '/admin/api/' . config('shopify-app.api_version') . '/carrier_services.json', 
		array
		(
		 'carrier_service' => array
			(
			   "name" => "Sstech Shipping Rate Provider",
			   "callback_url" => "https://sstechshippingapp.driver007.com/api/shippingrates",
			   //"callback_url" => "https://test.omnirps.com/test/getshipping_rates_test",
			   //"format" => "json",
			   //"active" => true,
			   "service_discovery" => true
		    )
		));
		
		if($carrier_service->status==201) {
			echo 'carrier service created succesfully.';
		}
	}
	
	/**
	 * View all carrier services
	 */
	public function view_carrierservices() {
		$shop = Auth::user();
        $list_carrierservices = $shop->api()->rest('GET', '/admin/api/' . config('shopify-app.api_version') . '/carrier_services.json');
		echo '<pre>';print_r($list_carrierservices->body);exit;
	}
	
	/*check carrier service create or not*/
	public function carrierservice_check() {
		$shop = Auth::user();
        $list_carrierservices = $shop->api()->rest('GET', '/admin/api/' . config('shopify-app.api_version') . '/carrier_services.json');
		$listofcarrierservice = $list_carrierservices->body;
		$i=0;
		foreach($listofcarrierservice as $val)
		{
			$current_carrierservicename = 'Sstech Shipping Rate Provider';
			if(strpos($val[$i]->name,$current_carrierservicename) !== FALSE) {
				echo '1';
			}
			else{
				echo '0';
			}
			$i++;
		}
	}
	
	public function createnewcarrier_service() {
		$shop = Auth::user();
		$shop_request = $shop->api()->rest('GET', '/admin/shop.json');
		$shop_details = $shop_request->body->shop;
		//echo '<pre>';print_r($shop_details);exit;
		$carrier_service = $shop->api()->rest('POST', '/admin/api/' . config('shopify-app.api_version') . '/carrier_services.json', 
		array
		(
		 'carrier_service' => array
			(
			   "name" => "Sstech Shipping Rate Provider",
			   "callback_url" => "https://sstechshippingapp.driver007.com/api/shippingrates",
			   "service_discovery" => true
		    )
		));
		if($carrier_service->status==201) {
			/*if carrier service created succesfully then add setting table data by default*/
			if($shop_details){
				$userid = DB::table('users')->where('name',$shop_details->domain)->select('id')->pluck('id')->first();
				$settingdata = array(
					'user_id'=>$userid,
					'custom_access_token'=>'00BF47B1559899C7F6ED19CF40914841A9D0B8BC7C95C59C25',
					'label_receiver_email'=> $shop_details->email,
					'is_from_address'=>1,
					'name'=>$shop_details->name,
					'contact_person'=>$shop_details->shop_owner,
					'address1'=>$shop_details->address1,
					'address2'=>$shop_details->address2,
					'city'=>$shop_details->city,
					'province'=>$shop_details->province,
					'country'=>$shop_details->country_name.'-'.$shop_details->country,
					'zip'=>$shop_details->zip,
					'phone'=>$shop_details->phone,
					'created_by'=>$userid,
				);
				DB::table('settings')->insert($settingdata);
			}
			$message = '1';
		}
		else{
			$message = '0';
		}
		echo $message;
	}

	/**
	 * View all carrier services
	 */
	public function delete_carrierservice(Request $request) {
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
	}

	
	/**
	 * Create webhook
	 */
	public function create_orderwebhook() {
		$shop = Auth::user();
		$shop_request = $shop->api()->rest('GET', '/admin/shop.json');
		$shop_domain = $shop_request->body->shop->domain;
		$webhook = $shop->api()->rest('POST', '/admin/api/' . config('shopify-app.api_version') . '/webhooks.json', 
		array
		(
		 'webhook' => array
			(
			   "topic" => "orders/create",
			   "address" => "https://sstechshippingapp.driver007.com/api/orders_create",
			   "format" => "json"
		    )
		));
		//echo '<pre>';print_r($webhook);exit;
		if($webhook->status==201) {
			echo 'webhook created succesfully.';
		} else {
			echo 'failed to create webhook.';
		}
	}
	
	/**
	 * List of Webhook
	 */
	public function getlist_webhook() {
		$shop = Auth::user();
        $list_webhook = $shop->api()->rest('GET', '/admin/api/' . config('shopify-app.api_version') . '/webhooks.json');
		echo '<pre>';print_r($list_webhook->body);exit;
	}
	
	/**
	 * Delete Webhook
	 */
	public function delete_webhook(Request $request) {
		 //dd($request->all());
		$shop = Auth::user();
		$webhookid = $request->webhookid;
		if(!empty($webhookid)) {
			$delete_wbhk = $shop->api()->rest('DELETE', '/admin/api/' . config('shopify-app.api_version') . '/webhooks/'.$webhookid.'.json');	
			if($delete_wbhk->status==200) {
				echo 'Webhook deleted succesfully';
			}
		} else {
			echo 'Carrier Id is Rquired Field';
		}		
	}
   
}