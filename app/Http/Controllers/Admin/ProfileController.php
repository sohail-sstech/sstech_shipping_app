<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Rules\MatchOldPassword;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
		$this->middleware('user-role');
    }
	public function index()
    {
		$Authentication_data = Auth::User()->toArray();
		if(isset($Authentication_data))
		{
			return view('admin.theme.profile_view')->with('profiledata',$Authentication_data);	
		}
		else{
			return view('admin/theme/profile_view');
		}
    }
	
	/*update profile data*/
	public function update_profile(Request $request)
    {
		$profile_name = $request->input('profile_name');
		$profile_id = $request->input('profile_id');
			if(isset($profile_id))
			{
				$update_profile_array = array(
				   'name'=>$profile_name
				); 
				User::where('id', $profile_id)->update($update_profile_array); 
			}
		
		  return redirect()->back()->with('message', 'Profile Data Update!');
    }
	
	/*change password view load*/
	public function changepassword_view(Request $request){
		
		return view('admin/theme/changepassword_view');
	}
	/*update change password*/
	public function update_changepassword(Request $request)
	{
		$request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
		User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
		return redirect()->back()->with('message', 'Password change successfully.');
	}
}
