<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

use Illuminate\Notifications\Notifiable;

class UserDetails extends Authenticatable
{ 
	
     protected $table = 'user_details';
	 
	 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','country_id', 'company','address1','address2','city','state','country','pincode','phone','mobile','status','created_by','updated_by'
    ];
	
	 /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
      'password', 'remember_token',
	  'deleted_at',
    ];*/
	
	/**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    /*protected $casts = [
        'email_verified_at' => 'datetime',
    ];*/
}