<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class Temp extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    //protected $table = 'temps';
    protected $table = 'webhook_queues';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
	
	/*public function mytest($status)
    {
       $labeldetails_results = DB::select('select * from webhook_queues where status='.$status.' ORDER BY id ASC LIMIT 2');
	   return $labeldetails_results;
        
    }*/
}
