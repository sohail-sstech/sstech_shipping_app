@extends('shopify-app::layouts.default')

@section('content')
    <!-- You are: (shop domain name) -->
    <p>You are: {{ Auth::user()->name }}</p>
    <p>
	 
    
        <a href="{{url('/shop')}}" target="_blank" title="Shop">Shop</a>
        <a href="{{url('/products')}}" target="_blank" title="Products">Products</a>
        <a href="{{url('/orders')}}" target="_blank" title="Orders">Orders</a>
    </p>
    @php
        //$shop = Auth::user();
        //$shop_request = $shop->api()->rest('GET', '/admin/shop.json');
        //echo $request->body->shop->name;
        //echo '<pre>'; print_r($shop_request->body->shop); echo '</pre>';
    @endphp
@endsection

@section('scripts')
    @parent

    <script type="text/javascript">
        /*
        var AppBridge = window['app-bridge'];
        var actions = AppBridge.actions;
        var TitleBar = actions.TitleBar;
        var Button = actions.Button;
        var Redirect = actions.Redirect;
        var titleBarOptions = {
            title: 'Welcome',
        };
        var myTitleBar = TitleBar.create(app, titleBarOptions);
        //*/
    </script>
@endsection