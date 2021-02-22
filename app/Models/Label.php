<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Label extends Authenticatable
{
     protected $table = 'label_details';
	 
	  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shopify_order_id','shopify_order_no','consignment_no','carrier_name','is_manifested','status','created_by','created_at','is_deleted'
    ];
	public $timestamps = false;
	
}