<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class ShopifyController extends Controller
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $shop = Auth::user();
        $shop_request = $shop->api()->rest('GET', '/admin/shop.json');
        //echo $request->body->shop->name;
        echo '<pre>'; 
        print_r($shop_request->body->shop); 
        echo '</pre>';
    }

    /**
     * Get shop data
     *
     * @param  Request  $request
     * @return Response
     */
    public function get_shop(Request $request)
    {
		print_r('hello');exit;
        $shop = Auth::user();
		print_r($shop);exit;
        $get_shop_data = $shop->api()->rest('GET', '/admin/shop.json');
		
        //echo $request->body->shop->name;
        echo '<pre>';
        echo '<h1>Shop Data</h1>';
        echo $value = config('shopify-app.api_version').'<br/>';
        print_r($get_shop_data->body->shop);
        echo '</pre>';
        exit();
    }

    /**
     * Get product data
     *
     * @param  Request  $request
     * @return Response
     */
    public function get_products(Request $request)
    {
        $shop = Auth::user();
        $get_product_data = $shop->api()->rest('GET', '/admin/api/' . config('shopify-app.api_version') . '/products.json', ['limit' => 10]);
        //echo $request->body->shop->name;
        echo '<pre>'; 
        echo '<h1>Product Data</h1>';
        print_r($get_product_data->body->products); 
        echo '</pre>';
        exit();
    }

    /**
     * Get order data
     *
     * @param  Request  $request
     * @return Response
     */
    public function get_orders(Request $request)
    {
        $shop = Auth::user();
        $get_orders_data = $shop->api()->rest('GET', '/admin/api/' . config('shopify-app.api_version') . '/orders.json', ['limit' => 10]);
        //echo $request->body->shop->name;
        echo '<pre>'; 
        echo '<h1>Orders Data</h1>';
        print_r($get_orders_data->body->orders); 
        echo '</pre>';
        exit();
    }
}
