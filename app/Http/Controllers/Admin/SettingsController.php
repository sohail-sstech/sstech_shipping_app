<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('user-role');
    }
	public function index()
    {
		$storedetails='';
		$end_date = date("d-m-Y");
		$start_date = date("d-m-Y",strtotime("-1 month"));
		$storedetails = User::select('users.name as storename')->where('role_id',3)->orderBy('id', 'desc')->get()->toArray();
        return view('admin/settings/view',array('store_details' => $storedetails,'start_date' => $start_date,'end_date' => $end_date));
    }	
	public function preload_settingslist(Request $request)
	{
		
		$startdate = !empty(date("Y-m-d",strtotime($_POST['startdate']))) ? date("Y-m-d",strtotime($_POST['startdate'])) : '';
		$enddate = !empty(date("Y-m-d",strtotime($_POST['enddate']))) ? date("Y-m-d",strtotime($_POST['enddate'])) : '';

		//Start: Order by logic
		$order_by_field = 'settings.id';
		$order_by_field_value = 'desc';
		$order_by_field_arr = [
								'0' => 'storename',
								'1' => 'settings.label_receiver_email',
								'2' => 'settings.is_from_address',
								'3' => 'settings.status',
								'4' => 'settings.id',
							];
		if(isset($_POST['order'][0]['column']) && isset($_POST['order'][0]['dir'])) {
			$order_by_field = !empty($order_by_field_arr[$_POST['order'][0]['column']])?$order_by_field_arr[$_POST['order'][0]['column']]:$order_by_field;
			$order_by_field_value = !empty($_POST['order'][0]['dir'])?$_POST['order'][0]['dir']:$order_by_field_value;
		}
		
		$query_result = Settings::select('settings.*','us.name as storename')->join('users as us', 'settings.user_id', '=','us.id');
		if(!empty($_POST['search_data'])) 
		{
			$query_result->where(function($query)
			{
				$query->where('custom_access_token','like',"%".$_POST['search_data']."%")->orWhere('label_receiver_email', 'like', "%".$_POST['search_data']."%")->orWhere('label_receiver_email', 'like', "%".$_POST['search_data']."%")->orWhere('us.name','like', '%' .$_POST['search_data']. '%')->orWhere('settings.name','like', '%' .$_POST['search_data']. '%')->orWhere('settings.address1','like', '%' .$_POST['search_data']. '%')->orWhere('settings.country','like', '%' .$_POST['search_data']. '%')->orWhere('settings.province','like', '%' .$_POST['search_data']. '%')->orWhere('settings.city','like', '%' .$_POST['search_data']. '%')->orWhere('settings.zip','like', '%' .$_POST['search_data']. '%')->orWhere('settings.phone','like', '%' .$_POST['search_data']. '%');
			});
		}
		if(!empty($_POST['store'])) {
			$query_result = $query_result->where('us.name','like', '%' .$_POST['store']. '%');
		}
		if($_POST['isfromaddress']!='') {
			$query_result = $query_result->where('is_from_address','like','%'.$_POST['isfromaddress'].'%');
		}
		$query_result = $query_result->where('settings.is_deleted',0);
		$query_result = $query_result->whereBetween('settings.created_at', ["$startdate 00:00:00","$enddate 23:59:59"]);
		$total_count = $query_result->count();
		$query_result = $query_result->take($_POST['length'])->skip(intval($_POST['start']))->orderBy($order_by_field, $order_by_field_value)->get()->toArray();
		
		if($query_result)
		{
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => $total_count,
					"iTotalDisplayRecords" => $total_count,
					"aaData" => array()
				);
			foreach($query_result as $cntdata)
			{
				if($cntdata['is_from_address']==1)
				{
					$cntdata['is_from_address'] = "<span class='status--process'>Yes</span>";
				}
				else{
					$cntdata['is_from_address'] = "<span class='status--denied'>No</span>";
				}
				if($cntdata['status']==1)
				{
					$cntdata['status'] = "<span class='status--process'>Active</span>";
				}
				else{
					$cntdata['status'] = "<span class='status--denied'>Deactive</span>";
				}
				
				
				$cntdata['Action'] = '
				<div class="table-data-feature">
					<a href="admin/settings/edit/'.$cntdata['id'].'" class="item" data-toggle="tooltip" data-placement="top">
					<i class="zmdi zmdi-edit"></i>
				   </a>
				   <a href="#" data-id="'.$cntdata['id'].'" data-toggle="modal" data-target="#countryModalpopup" onclick=delete_data('.$cntdata['id'].',"admin/settings/delete/","settingsgrid_dt") id="user_modaltest" class="item" data-placement="top">
					<i class="zmdi zmdi-delete"></i>
				   </a>
				   <button type="button" onclick=get_row_detail('.$cntdata['id'].',"admin/settings/getrowdata/") class="btn btn-secondary mb-1 item" data-placement="top">
					<i class="zmdi zmdi-eye"></i>
				   </button>
				</div>';
				
				$raw = array($cntdata['storename'],$cntdata['label_receiver_email'],$cntdata['is_from_address'],$cntdata['status'],$cntdata['Action']);
				
				$output['aaData'][] = $raw;
			}
		}
		else
		{
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => '0',
					"iTotalDisplayRecords" => '0',
					"aaData" => array()
				);
		}
		echo json_encode($output);
	}
	
	/*Insert view load for settings master*/
	public function insert_view(){
		$country_list = Country::select('countries.*')->get()->toArray();
		$store_list = User::select('users.id as user_id','users.name as storename')->where('role_id',3)->get()->toArray();
		return view('admin.settings.insert',array('store_list'=>$store_list,'countrylist'=>$country_list));
	}
	
	/*Insert data for settings master*/
	public function insert_data(Request $request)
	{
		$Authentication_data = Auth::User()->toArray();
		//echo '<pre>';print_r($Authentication_data['id']);exit;
		$settings_data =  Settings::create(
			array(
				'user_id' => $request->input('store_name'),
				'custom_access_token' => $request->input('accesstoken'),
				'label_receiver_email' => $request->input('recevieremail'),
				'is_from_address' => $request->input('fromaddress'),
				'name' => $request->input('Name'),
				'contact_person' => $request->input('contactperson'),
				'address1' => $request->input('fromaddress1'),
				'address2' => $request->input('fromaddress2'),
				'city' => $request->input('city'),
				'province' => $request->input('province'),
				'country' => $request->input('countryname'),
				'zip' => $request->input('zipcode'),
				'phone' => $request->input('phone'),
				'created_by' => $Authentication_data['id']
			));
		if($settings_data)	{
			return redirect('/admin/settings')->with('message', 'You have successfully added settings.');	
		}
		else{
			return redirect()->back()->with('message_failed', 'Something went wrong while adding settings.');
		}
	}
	
	/*Settings Form Edit Data function*/
	public function edit_data(Request $request,$id)
	{
		$country_list = Country::select('countries.*')->get()->toArray();
		$store_list = User::select('users.id as user_id','users.name as storename')->where('role_id',3)->get()->toArray();
		$edit_data = Settings::where('id',$id)->get()->toArray(); 
		return view('admin.settings.edit')->with(array('settingseditdata'=>$edit_data[0],'store_list'=>$store_list,'countrylist'=>$country_list));	
	}
	/*Settings Form Update Data function*/
	public function update_data(Request $request)
	{
		$Authentication_data = Auth::User()->toArray();
		$settingsedit_id = $request->input('settingsedit_id');
		if(!empty($settingsedit_id))
		{ 
			$update_user_array = array(
			    'user_id' => $request->input('store_name'),
				'custom_access_token' => $request->input('accesstoken'),
				'label_receiver_email' => $request->input('recevieremail'),
				'is_from_address' => $request->input('fromaddress'),
				'name' => $request->input('Name'),
				'contact_person' => $request->input('contactperson'),
				'address1' => $request->input('fromaddress1'),
				'address2' => $request->input('fromaddress2'),
				'city' => $request->input('city'),
				'province' => $request->input('province'),
				'country' => $request->input('countryname'),
				'zip' => $request->input('zipcode'),
				'phone' => $request->input('phone'),
				'created_by' => $Authentication_data['id']
			); 
			Settings::where('id',$settingsedit_id)->update($update_user_array); 
			return redirect('/admin/settings')->with('message', 'You have successfully updated settings.');
		}
		else{
			//return redirect('/admin/settings')->with('message_failed', 'Something went wrong while adding settings.');
			return redirect()->back()->with('message_failed', 'Something went wrong while adding settings.');
		}
		
	}
	
	public function delete_data(Request $request,$id)
	{
		$delete_arr = array(
				'is_deleted'=>1
		);
		//DB::enableQueryLog();
		$delete = Settings::where('id',$id)->update($delete_arr); 
		if($delete==1){
			$Response   = array(
            'success' => '1'
			);
		}
		else{
			$Response   = array(
            'success' => '0'
            );
		}
		return $Response;
	}
	
	/*get single record data for modal popup*/
	public function get_single_row_data($id='')
	{
		if(isset($id))
		{
			$settings_details = Settings::select('settings.*','us.name as storename')->join('users as us', 'settings.user_id', '=','us.id')
			->where('settings.id',$id)->get()->toArray();
			
			if(!empty($settings_details)){
				 $order_html = (string)view('admin.settings.modal_view',array('All_SettingsDetails' => $settings_details));
			}
			else{
				$order_html = 'Data Not Found';
			}
		}
		$array = array('details'=>$order_html,'title'=>'Settings Details'); 
		echo json_encode($array);
	}
	

}
