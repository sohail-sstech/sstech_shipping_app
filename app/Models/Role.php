<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Role extends Authenticatable
{
     protected $table = 'roles';
	 
	  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','description','status','created_by','created_at','updated_by','updated_at','is_deleted',
    ];
	public $timestamps = false;
	
}