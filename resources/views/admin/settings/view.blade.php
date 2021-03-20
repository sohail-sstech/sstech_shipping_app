@extends('admin.layouts.master')
@extends('admin.include.modal_popup')
@section('content')
<section class="p-t-20">
                <div class="container">
                    <div class="row">
				        <div class="col-md-12 top-campaign">
							<div id="custommsg"></div>
							@if(session()->has('message'))
								<div class="alert alert-success">
									{{ session()->get('message') }}
								</div>
							@endif
						    <div class="row">
							  <div class="col-md-8">
								<h3 class="title-5 m-b-35">Settings</h3>
							  </div>
							   <div class="col-md-4">
								<p style="float:right;">
									<a href="{{asset('/admin/settings/insert_form')}}" class="au-btn au-btn-icon au-btn--green au-btn--small">
                                           <i class="zmdi zmdi-plus"></i> Add Setting
                                    </a>		
								</p>	
							  </div>
							</div>
							<div class="card">
                                    <div class="card-header">
                                        <strong>Search</strong> Settings
                                    </div>
                                    <div class="card-body card-block">
                                        <form name="processqueue_filter_data" class="" id="processqueue_filter_data" >
                                          <div class="row form-group">
												<div class="col-sm-3">
													<label for="search_data" class="col-form-label">Search</label>
													 <input type="text" class="form-control" id="search_data" autocomplete="new-search_data" name="search_data" placeholder="Store,Token,Name,Email,Address.">
												</div>
												<div class="col-sm-3">
													<label for="search_data" class="col-form-label">Start Date</label>
													<div class="input-group date">
													<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
														<input id="startdate" class="form-control pull-right" name="startdate"  value="{{!empty($start_date) ? $start_date : ''}}" type="text">
													</div>
												</div>
												<div class="col-sm-3">
													<label for="search_data" class="col-form-label">End Date</label>
													<div class="input-group date">
													<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
														<input id="enddate" class="form-control pull-right"  name="enddate" value="{{!empty($end_date) ? $end_date : ''}}" type="text">
													</div>
												</div>
												<div class="col-sm-3">
													<label for="store" class="col-form-label">Store</label>
													<select name="store" id="store" class="form-control">
                                                        <option value="0">Please select</option>
														 @if(!empty($store_details))
															@foreach($store_details as $store_data) 
																<option value="{{$store_data['storename']}}"> {{$store_data['storename']}} </option>
															@endforeach    
														@endif
                                                    </select> 
												</div>
												<div class="col-sm-3">
													<label for="status" class="col-form-label">From Address Enabled</label>
													<select name="isfromaddress" id="isfromaddress" class="form-control">
                                                        <option value="">Please select</option>
														<option value='1'>Yes</option>
														<option value='0'>No</option>
                                                    </select>
												</div>
												<div class="col-sm-3">
												<button type="button" onclick="reload_table('settingsgrid_dt')" class="btn btn-success btn-bg setting_height">
													<i class="fa fa-dot-circle-o"></i> Search
												</button>
												</div>
											</div>	
                                        </form>
                                    </div>
                            </div>
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2" id="settingsgrid_dt" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
											<th class="card-header" style="min-width: 0px">Store</th>
											<th class="card-header" style="min-width: 0px">Label Receiver Email</th>
                                            <th class="card-header" style="min-width: 0px">Is From Address</th>
                                            <th class="card-header" style="min-width: 0px">Status</th>
											<th class="card-header" style="min-width: 0px;text-align:center!Important;">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
</section>
@endsection
<script src="{{ asset('js/jquery-3.5.1.js')}}"></script>