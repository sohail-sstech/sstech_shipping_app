<?php

namespace App\Http\Controllers;

use App\Models\Temp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Config;
use Log;

class TestController extends Controller
{
    /**
     * Test Controller index Action
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
       echo 'TestController@index';exit();
    }
	public function get_shopify_offline_data()
	{
		$shopify_domain = 'smart-bicycles.myshopify.com';
		$access_token = DB::table('users')->where('name', $shopify_domain)->select('password')->pluck('password')->first();
		$api_version = \Config::get('shopify-app.api_version');
		$url = "https://{$shopify_domain}/admin/api/{$api_version}/shop.json";
		$header = array('X-Shopify-Access-Token:'.$access_token,'Content-Type: application/json','charset:utf-8');
		$cust_data = array('method' => 'GET');
		$api_response = call_curl($url, $header, '', $cust_data);
		if($api_response['response_info']['http_code']==200){
			return $api_response['response'];
		}
		else{
			return $api_response['response'];
		}
	}

    /**
     * Test constants
     */
    public function test_constants(Request $request)
    {
		
		/*$app_url = config('app.url');
		echo '<pre>';print_r($app_url);exit;*/
		$temp = new Temp;
		//$abc = $temp::select('select * from webhook_queues where status='.$status.' ORDER BY id ASC LIMIT 2');
		$flights = $temp::where('status', 1)
					->orderBy('id', 'ASC')
					->take(2)
					->get();
		foreach($flights as $val){
			//$array = (array) $val;
			echo '<pre>';print_r($val->id);	
		}			
		exit;
		//$abc = $temp->mytest($status);
		
		
        echo 'TestController@test_constants' . '<br/>';
        echo '1. ' . \Config::get('app.name') . '<br/>';
        echo '2. ' . \Config::get('constants.default_access_token') . '<br/>';
        echo '3. ' . \Config::get('constants.omni_rate_url') . '<br/>';
        echo '4. ' . \Config::get('constants.omni_label_url') . '<br/>';
        echo '5. ' . formatNumber('45000', 'USD') . '<br/>';
		echo '6. ' . \Config::get('constants.create_manifest_url') . '<br/>';
        echo '7. ' . \Config::get('constants.delete_manifest_url') . '<br/>';
        
        /*
        //Insert record in model
        $temp = new Temp;
        $temp->first_name = 'Sohail-' . rand(100, 999);
        $temp->last_name = 'Mulla-' . rand(100, 999);
        if($temp->save()) {
            echo 'Save succsessfully.' . '<br/>';
        } else {
            echo 'Error in save.' . '<br/>';
        }
       
        //Update record in model
        $temp = Temp::find($temp->id);
        $temp->first_name = 'Updated Sohail-' . rand(100, 999);
        $temp->last_name = 'Mulla-' . rand(100, 999);
        if($temp->save()) {
            echo 'Update succsessfully.' . '<br/>';
        } else {
            echo 'Error in update.' . '<br/>';
        }
        
        //Delete record
        $temp = Temp::find($temp->id);
        if($temp->delete()) {
            echo 'Deleted succsessfully.' . '<br/>';
        } else {
            echo 'Error in delete.' . '<br/>';
        }
        */
        exit();
    }
   
}