<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Country;

use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function index()
    {
		
        return view('admin/country/view');
    }
	/*country master load data*/
	/*public function preload_countrylist_oldbkp(Request $request)
	{
		/*$country_data = Country::get_countrylist();
		
        $output = array(
				"sEcho" => intval($_POST['draw']),
				"iTotalRecords" => $country_data['total_count'],
				"iTotalDisplayRecords" => $country_data['total_count'],
				"aaData" => array()
			);
		$countries_details = $country_data['data_found'];
		//print_r($country_data['total_count']);exit;
		foreach($countries_details as $cntdata)
		{
			if($cntdata->phone_code)
			{
				$cntdata->phone_code = '+'.$cntdata->phone_code;
			}
			if($cntdata->status==1)
			{
				$cntdata->status = "Active";
			}
			else
			{
				$cntdata->status = "Deactive";
			}
			if($cntdata->is_deleted==1){
				$cntdata->is_deleted = "Yes";
			}
			else{
				$cntdata->is_deleted = "No";
			}
			$raw = array($cntdata->name,$cntdata->iso,$cntdata->phone_code,$cntdata->num_code,$cntdata->status,$cntdata->is_deleted,$cntdata->created_at);
			$output['aaData'][] = $raw;
		}
		echo json_encode($output);
		*/
		
		//print_r($_POST['draw']);exit;
		/*$search = $request->query('search', array('value' => '', 'regex' => false));
		$draw = $request->query('draw', 0);
		$start = $request->query('start', 0);
		$length = $request->query('length', 10);
		$order = $request->query('order', array(1, 'asc'));  */   
		//print_r($draw);exit;
		//$filter = $search['value'];
		
	/*	$search_limit = "";
		if (isset($_POST['start']) && $_POST['length'] != '-1') 
		{
			//$search_limit = "LIMIT ".intval($_POST['start']).", ".intval($_POST['length']);
			$search_limit = " ".intval($_POST['start']).", ".intval($_POST['length']);
		}
		//print_r($search_limit);exit;
		//$main_query = DB::select('select SQL_CALC_FOUND_ROWS cnt.* from countries as cnt '.$search_limit.' ');
		//DB::enableQueryLog();
		//$country_list = Country::select('countries.*')->take($_POST['length'])->skip(intval($_POST['start']))->get();
		$country_list = Country::select('countries.*')->take($_POST['length'])->skip(intval($_POST['start']))->get();
		$country_list_arr = $country_list->toArray();
		
		
		//$queries = DB::getQueryLog();
		//print_r($queries);exit;
		//$main_query = Country::select('countries.*')->take($length)->skip($start);
		//$country_list = Country::select('countries.*')->take(intval($_POST['length']))->skip(intval($_POST['start']))->get();
		//$country_list->take(intval($_POST['length']))->skip(intval($_POST['start']));
		$record_total = Country::all();
		$total_count = $record_total->count();
		//echo '<pre>';print_r($total_count);exit;
		//$total_count = $country_list->count();
		
		$output = array(
				"sEcho" => intval($_POST['draw']),
				"iTotalRecords" => $total_count,
				"iTotalDisplayRecords" => $total_count,
				"aaData" => array()
			);
		foreach($country_list_arr as $cntdata)
		{
			if($cntdata['phone_code'])
			{
				$cntdata['phone_code'] = '+'.$cntdata['phone_code'];
			}
			if($cntdata['status']==1)
			{
				$cntdata['status'] = "Active";
			}
			else
			{
				$cntdata['status'] = "Deactive";
			}
			if($cntdata['is_deleted']==1){
				$cntdata['is_deleted'] = "Yes";
			}
			else{
				$cntdata['is_deleted'] = "No";
			}
			$raw = array($cntdata['name'],$cntdata['iso'],$cntdata['phone_code'],$cntdata['num_code'],$cntdata['status'],$cntdata['is_deleted'],$cntdata['created_at']);
			$output['aaData'][] = $raw;
		}
		
		return $output;
		
	/*$search = $request->query('search', array('value' => '', 'regex' => false));
    $draw = $request->query('draw', 0);
    $start = $request->query('start', 0);
    $length = $request->query('length', 10);
    $order = $request->query('order', array(1, 'asc'));  
	$filter = $search['value'];
//	echo '<pre>';print_r($filter);exit;
	
	$filter = $search['value'];
	 $sortColumns = array(
        0 => 'name'
    );
	
	$sortColumnName = $sortColumns[$order[0]['column']];
	$main_query = Country::select('countries.*')->orderBy($sortColumnName, $order[0]['dir'])->take($length)->skip($start);
	//$main_query = Country::all();
	
	$recordsTotal = $main_query->count();
	
	$json = array(
        'draw' => $draw,
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsTotal,
        'data' => [],
    );
	
	$products = $main_query->get();	
	 foreach ($products as $product) 
	 {

        $json['data'][] = [
           
            $product->name,
        ];
    }

    return $json;*/
	
	/*}*/
	
	public function preload_countrylist(Request $request)
	{
		
		/*if (isset($_POST['start']) && $_POST['length'] != '-1') 
		{
			//$search_limit = "LIMIT ".intval($_POST['start']).", ".intval($_POST['length']);
			$search_limit = " ".intval($_POST['start']).", ".intval($_POST['length']);
		}*/
		
		$search_limit = "";
		$countryname ='';
		if(isset($_POST['country_name']) && !empty($_POST['country_name'])){
			$countryname = $_POST['country_name'];
		}
		
		//$country_list_arr = Country::select('countries.*')->where('name','like', '%' .$countryname. '%')->where('is_deleted',1)->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
		$country_list_arr = Country::select('countries.*')->where('name','like', '%' .$countryname. '%')->where('is_deleted',1)->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
	
		//$total_count = Country::select('countries.*')->where('name','like', '%' .$countryname. '%')->where('is_deleted',1)->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->count();
		//$country_list_arr = Country::select('countries.*')->where('name','')->where('is_deleted',1)->take($_POST['length'])->skip(intval($_POST['start']))->orderBy('id', 'desc')->get()->toArray();
		/*DB::enableQueryLog();
		$queries = DB::getQueryLog();
		print_r($queries);exit;*/
		
		//$record_total = Country::all();
		//print_r($count_query);exit;
		
		/*$record_total = Country::all();
		$total_count = $record_total->count();*/
		
		if($country_list_arr)
		{
			/*Query for to get total record count*/
			$record_total = Country::where('name','like', '%' .$countryname. '%')->where('is_deleted',1)->get()->toArray();
			$total_count = count($record_total);
			
			$output = array(
					"sEcho" => intval($_POST['draw']),
					"iTotalRecords" => $total_count,
					"iTotalDisplayRecords" => $total_count,
					"aaData" => array()
				);
			foreach($country_list_arr as $cntdata)
			{
				if($cntdata['phone_code'])
				{
					$cntdata['phone_code'] = '+'.$cntdata['phone_code'];
				}
				if($cntdata['status']==1)
				{
					$cntdata['status'] = "Active";
				}
				else
				{
					$cntdata['status'] = "Deactive";
				}
				$cntdata['Action'] = '
				<div class="table-data-feature">
				   <a href="admin/country/edit/'.$cntdata['id'].'" class="item" data-toggle="tooltip" data-placement="top">
					<i class="zmdi zmdi-edit"></i>
				   </a>
				  <a href="#" data-id="'.$cntdata['id'].'" data-toggle="modal" data-target="#countryModalpopup" id="country_modal" class="item" data-placement="top">
					<i class="zmdi zmdi-delete"></i>
				   </a>
				</div>';
				$raw = array($cntdata['name'],$cntdata['iso'],$cntdata['phone_code'],$cntdata['num_code'],$cntdata['status'],$cntdata['created_at'],$cntdata['Action']);
				$output['aaData'][] = $raw;
			}
		}
		return $output;
	}
	
	/*Insert view load for country master*/
	public function insert_view(){
		return view('admin/theme/countryinsert_view');
	}
	
	/*Insert data for country master*/
	public function insert_data(Request $request)
	{
		$country_name = $request->input('country_name');
		$country_shortname = $request->input('country_shortname');
		$country_status = $request->input('country_status');
		$country_iso = $request->input('country_iso');
		$country_code = $request->input('country_code');
		$country_numcode = $request->input('country_numcode');
		Country::create(
			array(
			'name' => $request->input('country_name'),
			'iso' => $request->input('country_shortname'),
			'status' => $request->input('country_status'),
			'iso3' => $request->input('country_iso'),
			'phone_code' => $request->input('country_code'),
			'num_code' => $request->input('country_numcode')
			));
		return redirect('/admin/country')->with('message', 'Data inserted successfully.');	
	}
	
	/*Country Form Edit Data function*/
	public function edit_data(Request $request,$id)
	{
		$edit_data = Country::where('id',$id)->get()->toArray(); 
		return view('admin.theme.countryedit_view')->with('countryeditdata',$edit_data[0]);	
	}
	/*Country Form Update Data function*/
	public function update_data(Request $request)
	{
		$countryedit_id = $request->input('countryedit_id');
			if(isset($countryedit_id))
			{
				$update_country_array = array(
				   'name'=>$request->input('country_name'),
				   'iso'=>$request->input('country_shortname'),
				   'status'=>$request->input('country_status'),
				   'iso3'=>$request->input('country_iso'),
				   'phone_code'=>$request->input('country_code'),
				   'num_code'=>$request->input('country_numcode'),
				); 
				Country::where('id',$countryedit_id)->update($update_country_array); 
			}
		return redirect('/admin/country')->with('message', 'Country Data Update.');	
	}
	
	public function delete_data(Request $request,$id)
	{
		$delete_arr = array(
				'is_deleted'=>0
		);
		//DB::enableQueryLog();
		$delete = Country::where('id',$id)->update($delete_arr); 
		//$queries = DB::getQueryLog();
		//$delete = Country::where('id',$id)->delete();
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
	
	/*public function testmodalcall(){
		//First Way	
		 $post = User::all()->toArray();
          dd($post);
		 //Second Way
		  $data = User::get(array('name'))->toArray(); // Or Main::all(['title']);
		  dd($data);
	}*/
}
