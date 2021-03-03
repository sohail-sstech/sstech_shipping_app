<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



/**
* change plain number to formatted currency
*
* @param $number
* @param $currency
*/
function formatNumber($number, $currency = 'IDR')
{
   if($currency == 'USD') {
        return number_format($number, 2, '.', ',');
   }
   return number_format($number, 0, '.', '.');
}

/**
 * Call CURL
 * @url         string
 * @header      array
 * @attachment  string json
 * @cust_data   array [ 'method' => 'GET' ]
 */
function call_curl($url='', $header=array(), $attachment='', $cust_data=array()) {
    $return = [];
    $response = '';
    $response_info = '';
    if(!empty($cust_data['method'])){ $method = $cust_data['method']; } else { $method = "POST"; }
    //echo $method; exit();
    if(!empty($url)) {
        if(strtoupper($method) == "GET") {
            $curl = curl_init();  
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            $response = curl_exec($curl);
            $response_info = curl_getinfo($curl);
            //echo '<pre>'; print_r($info); echo '</pre>'; //exit();
            curl_close($curl);
        } else {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($curl, CURLOPT_URL,$url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $attachment);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
            $response = curl_exec($curl);
            $response_info = curl_getinfo($curl);
            //echo '<pre>'; print_r($info); echo '</pre>'; //exit();
            curl_close($curl);
        }      
    }
    $return = [ 'response' => $response, 'response_info' => $response_info];
    //echo "<pre>"; print_r($response); exit;
    return $return;
}

/*for get token dynamic*/
/*function get_dynamic_token()
{
	$curr_logged_user = Auth::user();
	$userid = !empty($curr_logged_user->toArray()) ? $curr_logged_user->toArray()['id'] : null;
	//echo '<pre>';print_r($userid);exit;
	/*$shop_request = $shop->api()->rest('GET', '/admin/shop.json');
	$shop_domain = $shop_request->body->shop->domain;*/
	
	//$userid = DB::table('users')->where('name', $shop_domain)->select('id')->pluck('id')->first();
/*	if(!empty($userid)){
		$AccessKey = DB::table('settings')->where('user_id', $userid)->select('custom_access_token')->pluck('custom_access_token')->first();
		if(empty($AccessKey)){
			$AccessKey = Config::get('constants.default_access_token');	
		}
	}
	else{
		$AccessKey = Config::get('constants.default_access_token');
	}
	return $AccessKey;
}*/
