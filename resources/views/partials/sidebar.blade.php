 <?php 
							/*$shop = Auth::user();
							$shop_request = $shop->api()->rest('GET', '/admin/shop.json');
							$shop_domain = $shop_request->body->shop->domain;
							$shopify_shopurl =  'https://'.$shop_domain.'/admin';
							*/
							$shopify_shopurl ='';
							
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
                            <a href="{{secure_asset('/')}}"><i class="fas fa-chart-bar"></i>Dashboard</a>
                        </li>
                        <li>
                            <a href="{{secure_asset('/orderlabel')}}"><i class="fas fa-chart-bar"></i>Order Labels</a>
                        </li>
						
                        <li>
                            <a href="{{$shopify_shopurl}}" target="_blank"><i class="fas fa-table"></i>Store Admin</a>
                        </li>
                        <li>
                            <a href="#"><i class="far fa-check-square"></i>Tax</a>
                        </li>
                        <li>
                            <a href="{{secure_asset('/manifest')}}"><i class="fas fa-calendar-alt"></i>Manifest</a>
                        </li>
                        <li>
                            <a href="{{secure_asset('/settingview')}}"><i class="fas fa-map-marker-alt"></i>Settings</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#"><i class="fas fa-copy"></i>Carrier Service</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="{{secure_asset('/create')}}">Create Carrier Service</a>
                                </li>
                                <li>
                                    <a href="{{secure_asset('/carrierdelete_view')}}">Delete Carrier Service</a>
                                </li>
                                <li>
                                    <a href="{{secure_asset('/carrierservicelist')}}">List Carrier Service</a>
                                </li>
                            </ul>
                        </li>
						 <li class="has-sub">
                            <a class="js-arrow" href="#"><i class="fas fa-copy"></i>Webhook</a>
							<ul class="list-unstyled navbar__sub-list js-sub-list">
								<li>
									<a href="{{secure_asset('/createwebhook')}}">Create Webhook</a>
								</li>
								<li>
									<a href="{{secure_asset('/webhookdelete')}}">Delete Webhook</a>
								</li>
								<li>
									<a href="{{secure_asset('/webhooklist')}}">List Webhook</a>
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