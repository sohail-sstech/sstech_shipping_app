<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Osiset\BasicShopifyAPI;


use Log;

class SettingsController extends Controller
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
		//$common_array = array();
		$shop_domain = '';
		$userid ='';
		$settingdata='';
		$getcountry_list = DB::table('countries')->get();
		//$common_array['country_list'] = $getcountry_list;
		//echo '<pre>';print_r($getcountry_list);exit;
		$shop_domain = $shop_request->body->shop->domain;
		if(!empty($shop_domain))
		{
			$userid = DB::table('users')->where('name', $shop_domain)->select('id')->pluck('id')->first();
			if(!empty($userid))
			{
				$settingdata = DB::table('settings')->where('user_id',$userid)->get();
				//echo '<pre>';print_r($settingdata);exit;
				if(count($settingdata) > 0)
				{
					if(isset($settingdata[0]))
					{
						$settingdata = $settingdata[0];
						//$common_array['settingdata'] = $settingdata;
						//return view('theme.settings_edit')->with('settingdata',$settingdata);	
						return view('theme.settings_edit',array('settingdata' => $settingdata,'countrylist' => $getcountry_list));
					}
				}
				else
				{
					return view('theme.settings_insert',array('countrylist' => $getcountry_list));
					//return view('theme.settings_insert',)->with('countrylist',$getcountry_list);	
					//return view('theme.settings_insert');	
				}
			}
		}
    }
	
	public function insert_data(Request $request)
    {
		$shop = Auth::user();
		$shop_request = $shop->api()->rest('GET', '/admin/shop.json');
		
		$accesstoken = $request->input('accesstoken');
		$recevieremail = $request->input('recevieremail');
	
		$fromaddress = $request->input('fromaddress');
		if($fromaddress==1)
		{
			$Name = $request->input('Name');
			$contactperson = $request->input('contactperson');
			$fromaddress1 = $request->input('fromaddress1');
			$fromaddress2 = $request->input('fromaddress2');
			$countryname = $request->input('countryname');
			$province = $request->input('province');
			$city = $request->input('city');
			$zipcode = $request->input('zipcode');
			$phone = $request->input('phone');
		}
		else{
			$Name='';$contactperson='';$fromaddress1='';$fromaddress2='';$countryname='';$province='';$city='';$zipcode='';$phone='';$fromaddress='0';
		}
		
		$shop_domain = '';
		$userid ='';
		/*check shop id exit or not*/
		$address_details = $shop_request->body->shop;
		//echo '<pre>';print_r($address_details);exit;
		$shop_domain = $shop_request->body->shop->domain;
			if(!empty($shop_domain))
			{
				$userid = DB::table('users')->where('name', $shop_domain)->select('id')->pluck('id')->first();
				if(!empty($userid))
				{
					$setting_array = array(
					   'user_id'=>$userid,
					   'custom_access_token'=>$accesstoken,
					   'label_receiver_email'=> $recevieremail,
					   'is_from_address'=> $fromaddress,
					   'name'=> $Name,
					   'contact_person'=> $contactperson,
					   'address1'=> $fromaddress1,
					   'address2'=> $fromaddress2,
					   'city'=> $city,
					   'province'=> $province,
					   'country'=> $countryname,
					   'zip'=> $zipcode,
					   'phone'=> $phone,
					   'created_by'=> $userid
					); 
					DB::table('settings')->insert($setting_array);
				}
			}
		return redirect('/settingview');
    }
	/*update data in setting table*/
	public function update_data(Request $request)
    {
		$accesstoken = $request->input('accesstoken');
		$recevieremail = $request->input('recevieremail');
		
		$fromaddress = $request->input('fromaddress');
		if($fromaddress==1)
		{
			$Name = $request->input('Name');
			$contactperson = $request->input('contactperson');
			$fromaddress1 = $request->input('fromaddress1');
			$fromaddress2 = $request->input('fromaddress2');
			$countryname = $request->input('countryname');
			$province = $request->input('province');
			$city = $request->input('city');
			$zipcode = $request->input('zipcode');
			$phone = $request->input('phone');
		}else{
			$Name='';$contactperson='';$fromaddress1='';$fromaddress2='';$countryname='';$province='';$city='';$zipcode='';$phone='';$fromaddress='0';
		}
		
		$setting_id = $request->input('setting_id');
				if(!empty($setting_id))
				{
					$update_setting_array = array(
					   'custom_access_token'=>$accesstoken,
					   'label_receiver_email'=> $recevieremail,
					   'is_from_address'=> $fromaddress,
					   'name'=> $Name,
					   'contact_person'=> $contactperson,
					   'address1'=> $fromaddress1,
					   'address2'=> $fromaddress2,
					   'city'=> $city,
					   'province'=> $province,
					   'country'=> $countryname,
					   'zip'=> $zipcode,
					   'phone'=> $phone
					); 
					DB::table('settings')->where('id', $setting_id)->update($update_setting_array); 
				}
			
		return redirect('/settingview');
    }

   
}
