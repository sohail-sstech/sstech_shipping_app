<?php

namespace App\Http\Controllers;

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
			   "callback_url" => "https://3e5ddfc8881d.ngrok.io/shippingrates",
			   "format" => "json",
			   "active" => true,
			   "service_discovery" => "true"
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
		//echo 'in function';exit;
		/*$item = '{
		   "rates": [
			   {
				   "service_name": "canadapost-overnight",
				   "service_code": "ON",
				   "total_price": "1295",
				   "description": "This is the fastest option by far",
				   "currency": "USD"
			   },
			   {
				   "service_name": "fedex-2dayground",
				   "service_code": "2D",
				   "total_price": "2934",
				   "description": "This is the fastest option by far",
				   "currency": "USD"
			   },
			   {
				   "service_name": "fedex-priorityovernight",
				   "service_code": "1D",
				   "total_price": "3587",
				   "description": "This is the fastest option by far",
				   "currency": "USD"
			   }
			   ]
			}';*/
			/*description = carriername
			service name = deliverytype
			service-code : Route
			currency = */
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
		
		/*$item = "{
				   'rates': [
					   {
						   'service_name': 'canadapost-overnight',
						   'service_code': 'ON',
						   'total_price': '1295',
						   'currency': 'CAD',
						   'min_delivery_date': '2013-04-12 14:48:45 -0400',
						   'max_delivery_date': '2013-04-12 14:48:45 -0400'
					   },
					   {
						   'service_name': 'fedex-2dayground',
						   'service_code': '1D',
						   'total_price': '2934',
						   'currency': 'USD',
						   'min_delivery_date': '2013-04-12 14:48:45 -0400',
						   'max_delivery_date': '2013-04-12 14:48:45 -0400'
					   },
					   {
						   'service_name': 'fedex-2dayground',
						   'service_code': '1D',
						   'total_price': '2934',
						   'currency': 'USD',
						   'min_delivery_date': '2013-04-12 14:48:45 -0400',
						   'max_delivery_date': '2013-04-12 14:48:45 -0400'
					   }
				   ]
				}";	*/
		
		$response_arr = json_decode($item);
		$response = \Response::json($response_arr, 200);
		
		
		//$test = $response->original->rates;
		//$myjson = json_encode($test,true);
		//echo '<pre>';print_r($myjson);exit;
		return $response;
		//header('Content-Type: application/json');
		//echo json_encode($response_arr);
		
			
	}
	
}
