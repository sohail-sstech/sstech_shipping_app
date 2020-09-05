<?php

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