<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Config;
use DB;
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		//return view('/homepage');
		 return view('/apphome');
		//return view('/admin/theme/home');
		/*$shop = Auth::user()->toArray();
		//echo '<pre>';print_r($shop);exit;
		if(!empty($shop)){
			if($shop['role_id']==3)
			{
				$label_count = DB::select('SELECT COUNT(ldt.id) as total_label from label_details as ldt where ldt.consignment_no!="" ');
				$manifest_count = DB::select('SELECT COUNT(mnf.id) as total_manifest from manifest_details as mnf');
				return view('theme.home',array('label_count' => $label_count,'manifest_count' => $manifest_count));
				//return view('/admin/theme/home');
			}
			else{
				return redirect('/admin/home');		
			}
		}*/
		
    }
}
