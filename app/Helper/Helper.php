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
function get_dynamic_token($shop_domain=null)
{
	$access_key = Config::get('constants.default_access_token');
	if(!empty($shop_domain)){ //echo 'else if';
		$access_key = DB::table('users')->leftJoin('settings', 'users.id', '=', 'settings.user_id')->where('users.name', $shop_domain)->select('settings.custom_access_token')->pluck('settings.custom_access_token')->first();
		if(empty($access_key)) {
			$access_key = Config::get('constants.default_access_token');
		}
	}
	//print_r($access_key);exit;
	return $access_key;
}
