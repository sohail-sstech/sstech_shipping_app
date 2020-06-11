<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class apilog_model extends Model
{
   protected $table="api_logs";
   
   public function test(){
    return $test = "This is a test function";
   }

}
