<?php
namespace App\Models\Admin;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProcessQueue extends Authenticatable
{
     protected $table = 'process_queues';
	 
	  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type','shop_domain','headers','body','status','created_by','created_at','updated_by','updated_at','is_deleted'
    ];
	public $timestamps = false;
	
}