<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Manifest extends Authenticatable
{
     protected $table = 'manifest_details';
	 
	  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'manifest_no','manifest_file','status','created_by','created_at','updated_by','updated_at','is_deleted'
    ];
	public $timestamps = false;
	
}