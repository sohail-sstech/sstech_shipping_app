<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
//Route::get('/', 'ShopifyController@index');
//Route::get('/test', 'ShopifyController@get_shop')->middleware(['auth.shopify']);
//Route::get('/mydata', 'ShopifyController@dummydata')->middleware(['auth.shopify']);
//Route::post('/mydata', 'ShopifyController@dummydata')->middleware(['auth.shopify']);
//Route::get('/my-home', 'HomeController@myHome');

/*Route::get('/', function () {
    return view('welcome');
})->middleware(['auth.shopify'])->name('home');*/
//Route::get('/my-home', 'HomeController@myHome')->middleware(['auth.shopify']);

/*Route::get('/', function () {
    return view('myHome');
})->middleware(['auth.shopify'])->name('myHome');*/

//Route::get('my-users', 'HomeController@myUsers');


Route::get('/', function () {
    return view('theme/home');
})->middleware(['auth.shopify'])->name('home');



/*
Route::get('/', function () {
    return view('welcome');
})->middleware(['auth.shopify'])->name('home');
*/

Route::get('shop','ShopifyController@get_shop')->middleware(['auth.shopify']);
Route::get('products','ShopifyController@get_products')->middleware(['auth.shopify']);
Route::get('orders','ShopifyController@get_orders')->middleware(['auth.shopify']);


Route::get('create','ShopifyController@create_carrierservice')->middleware(['auth.shopify']);
Route::get('carrierservicelist','ShopifyController@view_carrierservices')->middleware(['auth.shopify']);

/*check carrier service exist or not*/
Route::get('validatecarrierservice','ShopifyController@carrierservice_check')->middleware(['auth.shopify']);
Route::post('createcarrierservicedashboard','ShopifyController@createnewcarrier_service');

/*delete carrier view load*/
Route::get('/carrierdelete_view', function () {
    return view('theme/carrierdelete_view');
})->middleware(['auth.shopify'])->name('carrierdelete_view');
Route::post('carrierdelete','ShopifyController@delete_carrierservice')->middleware(['auth.shopify']);

Route::get('createwebhook','ShopifyController@create_orderwebhook')->middleware(['auth.shopify']);
Route::get('webhooklist','ShopifyController@getlist_webhook')->middleware(['auth.shopify']);
Route::get('/webhookdelete', function () {
    return view('theme/webhookdelete_view');
})->middleware(['auth.shopify'])->name('webhookdelete_view');
Route::post('webhookdelete','ShopifyController@delete_webhook')->middleware(['auth.shopify']);

Route::get('shopdetails','ShopifyController@getshop_details')->middleware(['auth.shopify']);

/*Setting Controller Routes*/
Route::get('/settingview','SettingsController@index')->middleware(['auth.shopify']);
//Route::post('insertsettingsdata','SettingsController@insert_data')->middleware(['auth.shopify']);
Route::post('insertsettingsdata','SettingsController@insert_data');
Route::post('updatesettingsdata','SettingsController@update_data');

/*Manifest view load*/
Route::get('/manifest','ManifestController@index')->middleware(['auth.shopify']);

/*Main Manifest Data Table Load*/
//Route::get('/get_manifestdata','ManifestController@preload_manifestdata')->middleware(['auth.shopify']);
Route::post('get_manifestdata','ManifestController@preload_manifestdata');


/*Recent Manifest Data Table load*/
Route::get('/recentmanifest','ManifestController@preload_recentmanifest')->middleware(['auth.shopify']);

/*send manifest consignment*/
Route::post('sendmanifest','ManifestController@manifest_consignment');
Route::get('/sendmanifest','ManifestController@manifest_consignment')->middleware(['auth.shopify']);

/*delete consignment*/
Route::post('deleteconsignment','ManifestController@delete_consignment');


/*Order Label view load*/
Route::get('/orderlabel','ShippingController@index')->middleware(['auth.shopify']);
/*Order Label Grid*/
Route::post('get_orderlabeldata','ShippingController@preload_orderlabeldata');

/*call label pdf controller function*/
Route::post('pdflabeldetails','ShippingController@get_pdf_labeldetails');
//Route::get('/pdflabeldetails','ShippingController@get_pdf_labeldetails')->middleware(['auth.shopify']);

