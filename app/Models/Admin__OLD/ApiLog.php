<?php
namespace App\Models\Admin;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApiLog extends Authenticatable
{
     protected $table = 'api_logs';
	 
	  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','api_url','request_type','request_headers','request','response_headers','response','response_code','origin_ip','response_time','created_by','created_at','is_deleted',
    ];
	public $timestamps = false;
	
}