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
//Route::get('/', 'ShopifyController@get_shop')->middleware(['auth.shopify']);

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
    return view('theme/myHome');
})->middleware(['auth.shopify'])->name('myHome');

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

/*delete carrier view load*/
Route::get('/carrierdelete_view', function () {
    return view('theme/carrierdelete_view');
})->middleware(['auth.shopify'])->name('carrierdelete_view');
Route::post('carrierdelete','ShopifyController@delete_carrierservice')->middleware(['auth.shopify']);

//Route::get('shippingrates','ShopifyController@getshipping_rates')->middleware(['auth.shopify']);

//Route::get('shippingrates','ShopifyController@getshipping_rates');
//Route::post('shippingrates','ShopifyController@getshipping_rates');

/*Route::get('/shopdata', function () {
    return view('theme/shopdata');
})->middleware(['auth.shopify'])->name('shopdata');*/

/*Route::get('/', function () {
    return view('welcome');
})->middleware(['auth.shopify'])->name('home');

Route::get('shop', 'ShopifyController@get_shop')->middleware(['auth.shopify']);
Route::get('products', 'ShopifyController@get_products')->middleware(['auth.shopify']);
Route::get('orders', 'ShopifyController@get_orders')->middleware(['auth.shopify']);*/