<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ManifestLabel extends Authenticatable
{
     protected $table = 'manifest_label_details';
	 
	  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','manifest_detail_id','label_detail_id','consignment_no','status','created_by','created_at','updated_by','updated_at','is_deleted'
    ];
	public $timestamps = false;
	
}