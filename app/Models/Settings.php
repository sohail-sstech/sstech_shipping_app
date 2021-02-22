<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Settings extends Authenticatable
{
     protected $table = 'settings';
	 
	  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','custom_access_token','label_receiver_email','is_from_address','name','contact_person','address1','address2','city','province','country','zip','phone','status','created_by','created_at','is_deleted'
    ];
	public $timestamps = false;
	
}