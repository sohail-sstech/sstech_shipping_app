<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Log;

class TaxController extends Controller
{
    /**
     * Index action
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request) {
		return view('theme.tax_view');
    }
   
}