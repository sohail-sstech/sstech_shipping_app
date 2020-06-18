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
			   "callback_url" => "https://ee0d2e8feabb.ngrok.io/api/shippingrates",
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

	
	/*Create webhook*/
	public function create_orderwebhook()
	{
		$shop = Auth::user();
		$webhook = $shop->api()->rest('POST', '/admin/api/' . config('shopify-app.api_version') . '/webhooks.json', 
		array
		(
		 'webhook' => array
			(
			   "topic" => "orders/create",
			   "address" => "https://ee0d2e8feabb.ngrok.io/api/generatelabel",
			   "format" => "json"
		    )
		));
		if($webhook->status==201)
		{
			echo 'webhook created succesfully.';
		}
		else
		{
			echo 'failed to create webhook.';
		}
	}
	
	/*list of webhook*/
	public function getlist_webhook()
	{
		$shop = Auth::user();
        $list_webhook = $shop->api()->rest('GET', '/admin/api/' . config('shopify-app.api_version') . '/webhooks.json');
		echo '<pre>';print_r($list_webhook->body);exit;
	}
	
	/*Delete Webhook*/
	public function delete_webhook(Request $request)
	{
		 //dd($request->all());
		$shop = Auth::user();
		$webhookid = $request->webhookid;
		if(!empty($webhookid)){
			$delete_wbhk = $shop->api()->rest('DELETE', '/admin/api/' . config('shopify-app.api_version') . '/webhooks/'.$webhookid.'.json');	
			if($delete_wbhk->status==200){
				echo 'Webhook deleted succesfully';
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
	
	public function create_labels(Request $request)
	{
		/*$webhook_request = file_get_contents('php://input');
		
		$webhook_array = array(
					'description'=>$webhook_request
				);
				DB::table('webhook_details')->insert($webhook_array);
				exit;*/
		$webhook_request='
			{
    "id": 2525468229795,
    "email": "myemail@gmail.com",
    "closed_at": null,
    "created_at": "2020-06-17T08:14:03-04:00",
    "updated_at": "2020-06-17T08:14:04-04:00",
    "number": 17,
    "note": null,
    "token": "e6389cafa671a8dab471a7fc8767cc73",
    "gateway": "shopify_payments",
    "test": true,
    "total_price": "2225.65",
    "subtotal_price": "2225.60",
    "total_weight": 0,
    "total_tax": "0.00",
    "taxes_included": false,
    "currency": "USD",
    "financial_status": "paid",
    "confirmed": true,
    "total_discounts": "0.00",
    "total_line_items_price": "2225.60",
    "cart_token": "96c00270ab90e1f7562434c9d1d6883e",
    "buyer_accepts_marketing": false,
    "name": "#1017",
    "referring_site": "",
    "landing_site": "/password",
    "cancelled_at": null,
    "cancel_reason": null,
    "total_price_usd": "2225.65",
    "checkout_token": "71aa1717e995281c3ee466a8a934d609",
    "reference": null,
    "user_id": null,
    "location_id": null,
    "source_identifier": null,
    "source_url": null,
    "processed_at": "2020-06-17T08:14:02-04:00",
    "device_id": null,
    "phone": null,
    "customer_locale": "en",
    "app_id": 580111,
    "browser_ip": "49.34.66.150",
    "landing_site_ref": null,
    "order_number": 1017,
    "discount_applications": [],
    "discount_codes": [],
    "note_attributes": [],
    "payment_gateway_names": [
        "shopify_payments"
    ],
    "processing_method": "direct",
    "checkout_id": 14291972587683,
    "source_name": "web",
    "fulfillment_status": null,
    "tax_lines": [],
    "tags": "",
    "contact_email": "myemail@gmail.com",
    "order_status_url": "https://newzeland-laravel-shipping-app.myshopify.com/40102559907/orders/e6389cafa671a8dab471a7fc8767cc73/authenticate?key=e4f026467670347463b81feeab65db00",
    "presentment_currency": "USD",
    "total_line_items_price_set": {
        "shop_money": {
            "amount": "2225.60",
            "currency_code": "USD"
        },
        "presentment_money": {
            "amount": "2225.60",
            "currency_code": "USD"
        }
    },
    "total_discounts_set": {
        "shop_money": {
            "amount": "0.00",
            "currency_code": "USD"
        },
        "presentment_money": {
            "amount": "0.00",
            "currency_code": "USD"
        }
    },
    "total_shipping_price_set": {
        "shop_money": {
            "amount": "0.05",
            "currency_code": "USD"
        },
        "presentment_money": {
            "amount": "0.05",
            "currency_code": "USD"
        }
    },
    "subtotal_price_set": {
        "shop_money": {
            "amount": "2225.60",
            "currency_code": "USD"
        },
        "presentment_money": {
            "amount": "2225.60",
            "currency_code": "USD"
        }
    },
    "total_price_set": {
        "shop_money": {
            "amount": "2225.65",
            "currency_code": "USD"
        },
        "presentment_money": {
            "amount": "2225.65",
            "currency_code": "USD"
        }
    },
    "total_tax_set": {
        "shop_money": {
            "amount": "0.00",
            "currency_code": "USD"
        },
        "presentment_money": {
            "amount": "0.00",
            "currency_code": "USD"
        }
    },
    "line_items": [
        {
            "id": 5573551194275,
            "variant_id": 34523786248355,
            "title": "Electric bike 48v Electric bike  4.0 fat tire electric bike powerful fat tire ebike beach cruiser bike Booster bicycle electric",
            "quantity": 1,
            "sku": "25038683-mx20-white-china",
            "variant_title": "MX20-white / CHINA",
            "vendor": "Newzeland Laravel Shipping App",
            "fulfillment_service": "manual",
            "product_id": 5265852170403,
            "requires_shipping": true,
            "taxable": false,
            "gift_card": false,
            "name": "Electric bike 48v Electric bike  4.0 fat tire electric bike powerful fat tire ebike beach cruiser bike Booster bicycle electric - MX20-white / CHINA",
            "variant_inventory_management": "shopify",
            "properties": [],
            "product_exists": true,
            "fulfillable_quantity": 1,
            "grams": 0,
            "price": "2225.60",
            "total_discount": "0.00",
            "fulfillment_status": null,
            "price_set": {
                "shop_money": {
                    "amount": "2225.60",
                    "currency_code": "USD"
                },
                "presentment_money": {
                    "amount": "2225.60",
                    "currency_code": "USD"
                }
            },
            "total_discount_set": {
                "shop_money": {
                    "amount": "0.00",
                    "currency_code": "USD"
                },
                "presentment_money": {
                    "amount": "0.00",
                    "currency_code": "USD"
                }
            },
            "discount_allocations": [],
            "duties": [],
            "admin_graphql_api_id": "gid://shopify/LineItem/5573551194275",
            "tax_lines": [],
            "origin_location": {
                "id": 2190751334563,
                "country_code": "US",
                "province_code": "NY",
                "name": "US Laravel Shipping App",
                "address1": "1024 Main Street",
                "address2": "origin address",
                "city": "New York",
                "zip": "10001"
            }
        }
    ],
    "fulfillments": [],
    "refunds": [],
    "total_tip_received": "0.0",
    "original_total_duties_set": null,
    "current_total_duties_set": null,
    "admin_graphql_api_id": "gid://shopify/Order/2525468229795",
    "shipping_lines": [
        {
            "id": 2080594854051,
            "title": "SSTech Shipping SmartLabel Returns",
            "price": "0.05",
            "code": "UNITED STATES->UNITED STATES",
            "source": "Sstech Shipping Rate Provider",
            "phone": null,
            "requested_fulfillment_service_id": null,
            "delivery_category": null,
            "carrier_identifier": "f1c10d774205650ff9a0d0f7a1a89020",
            "discounted_price": "0.05",
            "price_set": {
                "shop_money": {
                    "amount": "0.05",
                    "currency_code": "USD"
                },
                "presentment_money": {
                    "amount": "0.05",
                    "currency_code": "USD"
                }
            },
            "discounted_price_set": {
                "shop_money": {
                    "amount": "0.05",
                    "currency_code": "USD"
                },
                "presentment_money": {
                    "amount": "0.05",
                    "currency_code": "USD"
                }
            },
            "discount_allocations": [],
            "tax_lines": []
        }
    ],
    "billing_address": {
        "first_name": "upcoming",
        "address1": "1024 Main Street",
        "phone": null,
        "city": "New York",
        "zip": "10001",
        "province": "New York",
        "country": "United States",
        "last_name": "user",
        "address2": "destination address",
        "company": null,
        "latitude": 40.75368539999999,
        "longitude": -73.9991637,
        "name": "upcoming user",
        "country_code": "US",
        "province_code": "NY"
    },
    "shipping_address": {
        "first_name": "upcoming",
        "address1": "1024 Main Street",
        "phone": null,
        "city": "New York",
        "zip": "10001",
        "province": "New York",
        "country": "United States",
        "last_name": "user",
        "address2": "destination address",
        "company": null,
        "latitude": 40.75368539999999,
        "longitude": -73.9991637,
        "name": "upcoming user",
        "country_code": "US",
        "province_code": "NY"
    },
    "client_details": {
        "browser_ip": "49.34.66.150",
        "accept_language": "en-US,en;q=0.5",
        "user_agent": "Mozilla/5.0 (Windows NT 10.0; rv:77.0) Gecko/20100101 Firefox/77.0",
        "session_hash": "bc2ca39ae37552d62376fb9496985460",
        "browser_width": 1349,
        "browser_height": 626
    },
    "payment_details": {
        "credit_card_bin": "424242",
        "avs_result_code": "Y",
        "cvv_result_code": "M",
        "credit_card_number": "•••• •••• •••• 4242",
        "credit_card_company": "Visa"
    },
    "customer": {
        "id": 3686994641059,
        "email": "myemail@gmail.com",
        "accepts_marketing": false,
        "created_at": "2020-06-17T08:13:12-04:00",
        "updated_at": "2020-06-17T08:14:04-04:00",
        "first_name": "upcoming",
        "last_name": "user",
        "orders_count": 0,
        "state": "disabled",
        "total_spent": "0.00",
        "last_order_id": null,
        "note": null,
        "verified_email": true,
        "multipass_identifier": null,
        "tax_exempt": false,
        "phone": null,
        "tags": "",
        "last_order_name": null,
        "currency": "USD",
        "accepts_marketing_updated_at": "2020-06-17T08:13:12-04:00",
        "marketing_opt_in_level": null,
        "admin_graphql_api_id": "gid://shopify/Customer/3686994641059",
        "default_address": {
            "id": 4485640978595,
            "customer_id": 3686994641059,
            "first_name": "upcoming",
            "last_name": "user",
            "company": null,
            "address1": "1024 Main Street",
            "address2": "destination address",
            "city": "New York",
            "province": "New York",
            "country": "United States",
            "zip": "10001",
            "phone": null,
            "name": "upcoming user",
            "province_code": "NY",
            "country_code": "US",
            "country_name": "United States",
            "default": true
        }
    }
}
		';
		$webhook_data = json_decode($webhook_request,true);
		echo '<pre>';print_r($webhook_data['line_items'][0]['origin_location']);exit;
		if(isset($webhook_data))
		{
			$shipping_method = $webhook_data['shipping_lines'][0]['title'];
			$mymethod_name="Sstech Shipping";
			if(strpos($shipping_method, $mymethod_name) !== FALSE) 
			{
				$AccessKey = '00BF47B1559899C7F6ED19CF40914841A9D0B8BC7C95C59C25';
				$ContentType = 'application/json';
				$url = 'https://api.omniparcel.com/labels/printcheapestcourier';
				
				
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
				
				$shopifyrequest_data = array
				(
					'Origin'=> array(
								'Name'=>$webhook_data['line_items'][0]['origin_location']['name'],
								'ContactPerson'=>$webhook_data['line_items'][0]['origin_location']['name'],
								'phonenumber'=>"",
								'email'=>$request_data['rate']['origin']['email'],
								'Address'=>array(
								
											'BuildingName'=>$webhook_data['line_items'][0]['origin_location']['address1'],
											'StreetAddress'=>$webhook_data['line_items'][0]['origin_location']['address1'],
											'Suburb'=>$webhook_data['line_items'][0]['origin_location']['city'],
											'City'=>$webhook_data['line_items'][0]['origin_location']['city'],
											'PostCode'=>$webhook_data['line_items'][0]['origin_location']['zip'],
											'CountryCode'=>$webhook_data['line_items'][0]['origin_location']['country_code']
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
				
				
				
				
				
				/*$webhook_array = array(
					'description'=>"Match Found"
				);
				DB::table('webhook_details')->insert($webhook_array);*/
			}
			else
			{
				//echo '<pre>';print_r("Match Not Found");exit;
				$webhook_array = array(
					'description'=>"Match Not Found"
				);
				DB::table('webhook_details')->insert($webhook_array);
			}
		}
		
		//echo '<pre>';print_r($webhook_data);exit;
		
		//echo 'testst';exit;
		/*$webhook_content = '';
		$webhook = fopen('php://input' , 'rb');
		while(!feof($webhook)){ //loop through the input stream while the end of file is not reached
			$webhook_content .= fread($webhook, 4096); //append the content on the current iteration
		}
		fclose($webhook); //close the resource
		$orders = json_decode($webhook_content, true); //convert the json to array
		*/
	}
	
	
	
	public function getshipping_rates(Request $request)
	{	
	
		 /*$shop = Auth::user();
         $get_shop_data = $shop->api()->rest('GET', '/admin/shop.json');
		 if($get_shop_data){
			$shopid = $get_shop_data->body->shop->id;	
		 }
		 else{
			 $shopid = '';
		 }*/
		//$shopid =  $this->get_shop();
		//echo '<pre>';print_r($shop_data);exit;
	//print_r($shop_data);exit;
	
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
		
		if($shopify_request)
		{
			
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
		
		$shopifyrequest_data = array
		(
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
		/*$attachment = json_encode($shopifyrequest_data);
		$header_logdata =$header;
		$attachment_logdata = json_encode($shopifyrequest_data);
		$request_parameter['Parameteres']['Header'] =  $header;				
		$request_parameter['Parameteres']['Body'] =  json_decode($attachment_logdata);//array($attachment);
		$apirequest = json_encode($request_parameter);
		$response='Success';
		$responsecode='1';
		$getorigin=$_SERVER['REMOTE_ADDR'];
		$originip=$getorigin;
		$requestby = $AccessKey;
		
		$apilog_insert_array=array(
				   'Api_Url'=>$url,
				   'Request_Type'=>'Shipping Rate Api Rquest',
				   'Request'=> $apirequest,
				   'Response'=>$response,
				   'Response_Code'=>$responsecode,
				   'Origin_IP'=>$originip,
				   'Request_By'=>$requestby
			  ); 
			  
	    /*DB::table('api_logs')->insert($apilog_insert_array);*/
		
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
		//print_r($validationerror->ValidationErrors);exit;
		
		/*store api log of omni parcel rate request*/
		$apirequest = $attachment;
		$response=$resp;
		//print_r($response);exit;
		
		
		
		
		$validationerror = json_decode($response);
		//print_r($response);exit;
		if(isset($validationerror->ValidationErrors))
		{
			$responsecode='Success';
		}
		else
		{
			$responsecode='Failed';	
		}
		$getorigin=$_SERVER['REMOTE_ADDR'];
		$originip=$getorigin;
		$requestby = "1";
		//$requestheader = $header;
		$apilog_insert_array=array(
				   'api_url'=>$url,
				   'request_type'=>'Available Rate',
				   //'request_headers'=> $requestheader,
				   'request'=> $apirequest,
				   'response'=>$response,
				   'response_code'=>$responsecode,
				   'origin_ip'=>$originip,
				   'created_by'=>$requestby
				   //'responsetime'=>$response_time,
				   //'CreatedAt'=>$dtstarttime,
			  ); 
	    DB::table('api_logs')->insert($apilog_insert_array);
		
		/*store response from omni parcel api */
		/*$request_parameter['Parameteres']['Header'] =  $header;				
		$request_parameter['Parameteres']['Body'] =  json_decode($resp);//array($attachment);
		$apirequest = json_encode($request_parameter);
		$response='Success';
		$responsecode='1';
		$getorigin=$_SERVER['REMOTE_ADDR'];
		$originip=$getorigin;
		$requestby = $AccessKey;
		$apilog_insert_array=array(
				   'Api_Url'=>$url,
				   'Request_Type'=>'Omni Shipping Rate Response',
				   'Request'=> $apirequest,
				   'Response'=>$response,
				   'Response_Code'=>$responsecode,
				   'Origin_IP'=>$originip,
				   'Request_By'=>$requestby
				   //'responsetime'=>$response_time,
				   //'CreatedAt'=>$dtstarttime,
			  ); 
			  
		  
	    DB::table('api_logs')->insert($apilog_insert_array);*/
		
		$jsondata = json_decode($resp);
		
		$myarray = array();
		$i=0;
		foreach($jsondata->Available as $rates)
		{		//$space[$i] = " ";
				$myarray['rates'][] = 
				array(
					'id'=> $i,
					'service_name'=> 'SSTech Shipping'.' '.$rates->DeliveryType,
					'service_code'=>$rates->Route,
					'total_price'=> $rates->Cost,
					'description'=>$rates->CarrierName,
					'currency'=>"NZD"
				);
			$i++;		
		}
		//print_r($myarray);exit;
		//print_r($myarray);exit;
		/*shipping rate api response set */
		//$store_response = json_encode($myarray);
		//$store_response = json_encode($myarray);
		
		$apirequest = $shopify_request;
		$response=json_encode($myarray);
		$responsecode='Success';
		$getorigin=$_SERVER['REMOTE_ADDR'];
		$originip=$getorigin;
		$requestby = "1";
		//$requestheader = $header;
		$apilog_insert_array=array(
				   'api_url'=>$url,
				   'request_type'=>'Shipping Rate',
				   //'request_headers'=> $$requestheader,
				   'request'=> $apirequest,
				   'response'=>$response,
				   'response_code'=>$responsecode,
				   'origin_ip'=>$originip,
				   'created_by'=>$requestby
			  ); 
	    DB::table('api_logs')->insert($apilog_insert_array);
		
		/*$request_parameter['Parameteres']['Header'] =  $header;				
		$request_parameter['Parameteres']['Body'] =  json_decode($store_response);//array($attachment);
		$apirequest = json_encode($request_parameter);
		$response='Success';
		$responsecode='1';
		$getorigin=$_SERVER['REMOTE_ADDR'];
		$originip=$getorigin;
		$requestby = $AccessKey;
		$apilog_insert_array=array(
				   'Api_Url'=>$url,
				   'Request_Type'=>'Omni Shipping Rate Response',
				   'Request'=> $apirequest,
				   'Response'=>$response,
				   'Response_Code'=>$responsecode,
				   'Origin_IP'=>$originip,
				   'Request_By'=>$requestby
			  ); 
	    DB::table('api_logs')->insert($apilog_insert_array);*/
		
		
		//$response_arr = json_decode($item);
		$response = \Response::json($myarray, 200);
		//echo '<pre>';print_r($response);exit;
		return $response;
		}
		
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
