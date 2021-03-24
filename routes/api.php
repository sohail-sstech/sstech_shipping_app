<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Rest Controller Routes
Route::get('shippingrates','RestController@getshipping_rates');
Route::post('shippingrates','RestController@getshipping_rates');

//Webhook Controller Routes
Route::get('orders_create','WebhookController@orders_create');
Route::post('orders_create','WebhookController@orders_create');

/*for test purpose*/
Route::post('createlabel','CronController@create_labels');
Route::get('createlabel','CronController@create_labels');

Route::get('app_uninstalled','WebhookController@app_uninstalled');
Route::post('app_uninstalled','WebhookController@app_uninstalled');

//Test controller
Route::get('test_constants','TestController@test_constants');
Route::post('test_constants','TestController@test_constants');