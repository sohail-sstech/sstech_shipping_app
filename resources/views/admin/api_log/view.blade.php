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
							  <div class="col-md-10">
								<h3 class="title-5 m-b-35">API Logs</h3>
							  </div>
							</div>
							<div class="card">
                                    <div class="card-header">
                                        <strong>Search</strong> API Logs
                                    </div>
                                    <div class="card-body card-block">
                                        <form  name="apilog_filter_data" class="" id="apilog_filter_data" >
                                          <div class="row form-group">
												<div class="col-sm-3">
													<label for="search_data" class="col-form-label">Search</label>
													 <input type="text" class="form-control" id="search_data" autocomplete="new-search_data" name="search_data" placeholder="ApiUrl, Request, Response, Header.">
												</div>
												<div class="col-sm-3">
													<label for="search_data" class="col-form-label">Request Type</label>
													<select name="request_type" id="request_type" class="form-control">
                                                        <option value="0">Please select</option>
                                                        <!--<option value="Available Rate">Available Rate</option>
                                                        <option value="Shipping Rate">Shipping Rate</option>
                                                        <option value="Label Rate">Label Rate</option>-->
														<option value="1">Shipping Rate Request</option>
														<option value="2">Available Rate Request</option>
														<option value="3">Label Request</option>
														<option value="4">Manifest Request</option>
														<option value="5">Label Delete Request</option>
                                                    </select> 
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
													<label for="search_data" class="col-form-label">Response Code</label>
													<select name="response_code" id="response_code" class="form-control">
                                                        <option value="0">Please select</option>
                                                        <option value="Success">Success</option>
                                                        <option value="Failure">Failure</option>
                                                    </select> 
													
												</div>
												<div class="col-sm-3">
													<label for="search_data" class="col-form-label">Store</label>
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
												<button type="button" onclick="reload_table('apiloggrid_dt')" class="btn btn-success btn-bg" style="margin-top:40px;">
													<i class="fa fa-dot-circle-o"></i> Search
												</button>
												</div>
											</div>	
                                        </form>
                                    </div>
                            </div>
                            <div class="table-responsive table-responsive-data2 ">
                                <table class="table table-data2" id="apiloggrid_dt" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="card-header" data-mdb-sort="false" style="min-width: 100px">Id</th>
											<th class="card-header" style="min-width: 100px">Store Name</th>
                                            <th class="card-header" style="min-width: 100px">Api Url</th>
                                            <th class="card-header" style="min-width: 200px">Request Type</th>
											<th class="card-header" style="min-width: 100px">Response Code</th>
											<th class="card-header" style="min-width: 100px">Created At</th>
											<th class="card-header" style="min-width: 100px">Action</th>
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