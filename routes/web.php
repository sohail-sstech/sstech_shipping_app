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



/*Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');*/


/*This is all routes for super admin panel goes here*/
Auth::routes();
Route::get('/admin/home', 'Admin\HomeController@index')->name('home');

Route::get('/admin/country', 'Admin\CountryController@index')->name('country');

/*For country grid route goes here*/
Route::post('/admin/get_countrylist','Admin\CountryController@preload_countrylist');
//Route::get('/get_countrylist','Admin\CountryController@preload_countrylist')->middleware(['auth']);
/*Country Insert route goes here*/
Route::get('/admin/country/insert_form','Admin\CountryController@insert_view')->name('/admin/insert_form');
Route::post('/admin/country/insert','Admin\CountryController@insert_data');
/*Country Edit Form Data*/
Route::get('/admin/country/edit/{id}','Admin\CountryController@edit_data')->name('/admin/Edit/{id}');
/*Country Update Data*/
Route::post('/admin/country/update','Admin\CountryController@update_data');
/*Country Delete Data*/
Route::get('/admin/country/delete/{id}','Admin\CountryController@delete_data');

/*For update profile form route goes here*/
Route::get('/admin/profile', 'Admin\ProfileController@index')->name('profile');
Route::post('/admin/updateprofile','Admin\ProfileController@update_profile');

/*For change profile password form route goes here*/
Route::get('/admin/changepassword', 'Admin\ProfileController@changepassword_view')->name('changepassword');
Route::post('/admin/updatechangepassword','Admin\ProfileController@update_changepassword');

/*For Role Master routes goes here*/
Route::get('/admin/role', 'Admin\RoleController@index')->name('role');
Route::post('/admin/role/get_rolelist','Admin\RoleController@preload_rolelist');
Route::get('/admin/role/edit/{id}','Admin\RoleController@edit_data')->name('/admin/Edit/{id}');
Route::post('/admin/role/update','Admin\RoleController@update_data');

/*For User Master routes goes here*/
Route::get('/admin/user', 'Admin\UserController@index')->name('user');
Route::post('/admin/user/get_userlist','Admin\UserController@preload_userlist');
Route::get('/admin/user/insert_form','Admin\UserController@insert_view')->name('/admin/user/insert_form');
Route::post('/admin/user/insert','Admin\UserController@insert_data');
Route::get('/admin/user/edit/{id}','Admin\UserController@edit_data')->name('/admin/Edit/{id}');
Route::post('/admin/user/update','Admin\UserController@update_data');
Route::get('/admin/user/delete/{id}','Admin\UserController@delete_data');


/*For Store Master routes goes here*/
Route::get('/admin/store', 'Admin\StoreController@index')->name('store');
Route::post('/admin/store/get_storelist','Admin\StoreController@preload_storelist');

/*For Api Logs routes goes here*/
Route::get('/admin/apilog', 'Admin\ApiLogController@index')->name('apilog');
Route::post('/admin/apilog/get_apiloglist','Admin\ApiLogController@preload_apiloglist');
Route::get('/admin/apilog/getrowdata/{id}','Admin\ApiLogController@get_row_log_details');

/*For Label Details routes goes here*/
Route::get('/admin/label', 'Admin\LabelController@index')->name('label');
Route::post('/admin/label/get_labellist','Admin\LabelController@preload_labellist');
Route::get('/admin/label/getrowdata/{id}','Admin\LabelController@get_row_log_details');

/*For Manifest Details routes goes here*/
Route::get('/admin/manifest', 'Admin\ManifestController@index')->name('manifest');
Route::post('/admin/manifest/get_manifestlist','Admin\ManifestController@preload_manifestlist');
Route::get('/admin/manifest/getrowdata/{id}','Admin\ManifestController@get_row_log_details');