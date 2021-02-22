<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Country extends Authenticatable
{
     protected $table = 'countries';
	 
	  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','iso','status','iso3','phone_code','num_code',
    ];
	public $timestamps = false;
	/*public static function test()
	 {
		 $search_limit = "";
		if (isset( $_POST['start']) && $_POST['length'] != '-1') 
		{
			$search_limit = "LIMIT ".intval($_POST['start']).", ".intval($_POST['length']);
		}
		$main_query = DB::select('select SQL_CALC_FOUND_ROWS cnt.* from countries as cnt '.$search_limit.' ');
		
		return $main_query;
		//echo '<pre>';print_r($main_query);exit;
	 }*/
	 
	/*public static function get_countrylist()
	 {
	
		$search_limit = "";
		if (isset($_POST['start']) && $_POST['length'] != '-1') 
		{
			$search_limit = "LIMIT ".intval($_POST['start']).", ".intval($_POST['length']);
		}
		//print_r($_POST);exit;
		DB::enableQueryLog();
		$main_query = DB::select('select SQL_CALC_FOUND_ROWS cnt.* from countries as cnt '.$search_limit.' ');
		
$queries = DB::getQueryLog();
//print_r($queries);exit;
		if($main_query)
		{
			$query2 = DB::select('SELECT FOUND_ROWS() as totalcount');
			$total_count = $query2[0]->totalcount;
			$table_data = array('data_found'=>$main_query,'total_count'=>$total_count);
			return $table_data;
		}
		else{
			return false;
		}
		
	 }*/
}