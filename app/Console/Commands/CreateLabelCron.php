<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateLabelCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create_label:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron job will fetch no of pending return label data and will process those data.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("Create Label Cron is working fine!");
        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */
		$curl=curl_init();
		curl_setopt($curl,CURLOPT_URL,'https://sstechshippingapp.driver007.com/api/createlabel');
		curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,2);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$response = curl_exec($curl);
		curl_close($curl);
		\Log::info($response);
        //$this->info($response_json);
    }
}
