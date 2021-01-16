<?php

return [
    
    /*
    'options' => [
        'option_attachment' => '13',
        'option_email' => '14',
        'option_monetery' => '15',
        'option_ratings' => '16',
        'option_textarea' => '17',
    ],
    */

    //Default Access Token
    'default_access_token' => '00BF47B1559899C7F6ED19CF40914841A9D0B8BC7C95C59C25',

    //Omni Rate URL
    'omni_rate_url' => 'https://api.omniparcel.com/labels/availablerateswithvalidation',

    //Omni Label URL
    'omni_label_url' => 'https://api.omniparcel.com/labels/printcheapestcourier',
	
	//create manifest consignment api url
    'create_manifest_url' => 'https://api.omniparcel.com/v2/publishmanifestv4',
	
	//omni delete manifest consignment api url
    'delete_manifest_url' => 'https://api.omniparcel.com/labels/delete',

];