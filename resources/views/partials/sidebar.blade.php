 <?php 		$shopify_shopurl ='';
			$shop_inner ='';
			$shop = Auth::user()->toArray();
			if(!empty($shop)){
				if($shop['role_id']==3){
				$shop_inner = !empty(Auth::user())? Auth::user(): '';
				$shop_request = !empty($shop_inner->api()->rest('GET', '/admin/shop.json')) ? $shop_inner->api()->rest('GET', '/admin/shop.json'):'';
				$shop_domain = !empty($shop_request->body->shop->domain)?$shop_request->body->shop->domain:'';
				$shopify_shopurl =  'https://'.$shop_domain.'/admin';
				}
			}
							
						?>
 <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img src="{{secure_asset('images/icon/logo.png')}}" alt="Cool Admin" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <!--<li class="active has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="index.html">Dashboard 1</a>
                                </li>
                                <li>
                                    <a href="index2.html">Dashboard 2</a>
                                </li>
                                <li>
                                    <a href="index3.html">Dashboard 3</a>
                                </li>
                                <li>
                                    <a href="index4.html">Dashboard 4</a>
                                </li>
                            </ul>
                        </li>-->
						<li>
                            <a href="{{secure_asset('/')}}"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="{{secure_asset('/orderlabel')}}"><i class="fab fa-first-order"></i>Order Labels</a>
                        </li>
						
                        <li>
                            <a href="{{$shopify_shopurl}}" target="_blank"><i class="fas fa-shopping-cart"></i>Store Admin</a>
                        </li>
                        <li>
                            <a href="{{secure_asset('/tax')}}"><i class="fas fa-calculator"></i></i>Tax</a>
                        </li>
						
						 <li class="has-sub">
                            <a class="js-arrow" href="#"><i class="fas fa-check-square"></i>Manifest</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="{{secure_asset('/manifest')}}"><i class="fas fa-rocket"></i>Send Manifest</a>
                                </li>
                                <li>
                                    <a href="{{secure_asset('/recent_manifest')}}"><i class="fas fa-history"></i>Recent Manifest</a>
                                </li>
                            </ul>
                        </li>
						
                        <!--<li>
                            <a href="{{secure_asset('/manifest')}}"><i class="fas fa-calendar-alt"></i>Manifest</a>
                        </li>-->
						
                        <li>
                            <a href="{{secure_asset('/settingview')}}"><i class="fas fa-cog"></i>Settings</a>
                        </li>
						
                        <li class="has-sub">
                            <a class="js-arrow" href="#"><i class="fa fa-wrench"></i>Carrier Service</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="{{secure_asset('/create')}}"><i class="fa fa-plus"></i>Create Carrier Service</a>
                                </li>
                                <li>
                                    <a href="{{secure_asset('/carrierdelete_view')}}"><i class="fa fa-remove"></i>Delete Carrier Service</a>
                                </li>
                                <li>
                                    <a href="{{secure_asset('/carrierservicelist')}}"><i class="fa fa-list"></i>List Carrier Service</a>
                                </li>
                            </ul>
                        </li>
						 <li class="has-sub">
                            <a class="js-arrow" href="#"><i class="fas fa-globe"></i>Webhook</a>
							<ul class="list-unstyled navbar__sub-list js-sub-list">
								<li>
									<a href="{{secure_asset('/createwebhook')}}"><i class="fa fa-plus"></i>Create Webhook</a>
								</li>
								<li>
									<a href="{{secure_asset('/webhookdelete')}}"><i class="fa fa-remove"></i>Delete Webhook</a>
								</li>
								<li>
									<a href="{{secure_asset('/webhooklist')}}"><i class="fa fa-list"></i>List Webhook</a>
								</li>
							</ul>
                        </li>
						<li>
                            <a href="{{secure_asset('shopdetails')}}"><i class="fas fa-map-marker-alt"></i>Shop Data</a>
                        </li> 
						
						
                        <!--<li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-desktop"></i>UI Elements</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="button.html">Button</a>
                                </li>
                                <li>
                                    <a href="badge.html">Badges</a>
                                </li>
                                <li>
                                    <a href="tab.html">Tabs</a>
                                </li>
                                <li>
                                    <a href="card.html">Cards</a>
                                </li>
                                <li>
                                    <a href="alert.html">Alerts</a>
                                </li>
                                <li>
                                    <a href="progress-bar.html">Progress Bars</a>
                                </li>
                                <li>
                                    <a href="modal.html">Modals</a>
                                </li>
                                <li>
                                    <a href="switch.html">Switchs</a>
                                </li>
                                <li>
                                    <a href="grid.html">Grids</a>
                                </li>
                                <li>
                                    <a href="fontawesome.html">Fontawesome Icon</a>
                                </li>
                                <li>
                                    <a href="typo.html">Typography</a>
                                </li>
                            </ul>
                        </li>-->
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->	