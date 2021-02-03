<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Config;
use Log;

class WebhookController extends Controller
{
    /**
     * Index action
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request) {
        echo 'WebhookController@index';
        exit();
	}
	
	/**
	 * Webhook for orders create
	 */
	public function orders_create() {
		$type = '1';
		$apache_request_headers = apache_request_headers();
		$shop_domain = (isset($apache_request_headers['X-Shopify-Shop-Domain'])) ? $apache_request_headers['X-Shopify-Shop-Domain'] : NULL;
		$headers_json = json_encode($apache_request_headers);
		
		/*get user id*/
		$userid = '';
		$userid = DB::table('users')->where('name',$shop_domain)->select('id')->pluck('id')->first();
		if(!empty($userid)){
			$userid = !empty($userid)?$userid:null;
		}
		//Load Variable
		$create_order_json = NULL;
		// Get webhook content from the POST
		$webhook_payload = fopen('php://input' , 'rb');
		while (!feof($webhook_payload)) {
			$create_order_json .= fread($webhook_payload, 4096);
		}
		fclose($webhook_payload);
		//$create_order_json = file_get_contents("php://input");
		$status = '0';
		$is_deleted = '0';
		//create order webhook insert data
		$create_order_webhook_insert_array = array(
			'type' => $type,
			'shop_domain' => $shop_domain,
			'headers' => $headers_json,
			'body' => $create_order_json,
			'status' => $status,
			'created_by' => $userid,
			'is_deleted' => $is_deleted
		); 
		DB::table('process_queues')->insert($create_order_webhook_insert_array);
	}

	/**
	 * Webhoook for app uninstalled
	 */
	public function app_uninstalled() {
		
	}
   
}