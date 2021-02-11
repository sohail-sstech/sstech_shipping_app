<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\User;
use App\Models\Admin\Role;


use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class PricingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	public function index()
    {
        return view('admin/pricing/view');
    }	
	
}