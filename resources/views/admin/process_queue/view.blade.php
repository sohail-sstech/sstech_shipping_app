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
								<h3 class="title-5 m-b-35">Process Queue Details</h3>
							  </div>
							</div>
							<div class="card">
                                    <div class="card-header">
                                        <strong>Filter</strong> Form
                                    </div>
                                    <div class="card-body card-block">
                                        <form name="processqueue_filter_data" class="" id="processqueue_filter_data" >
                                          <div class="row form-group">
												<div class="col-sm-3">
													<label for="search_data" class="col-sm-9 col-form-label">Search</label>
													 <input type="text" class="form-control" id="search_data" autocomplete="new-search_data" name="search_data" placeholder="Header,Body.">
												</div>
												<div class="col-sm-3">
													<label for="search_data" class="col-sm-9 col-form-label">Start Date</label>
													<div class="input-group date">
													<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
														<input id="startdate" class="form-control pull-right" name="startdate"  value="{{!empty($start_date) ? $start_date : ''}}" type="text">
													</div>
												</div>
												<div class="col-sm-3">
													<label for="search_data" class="col-sm-9 col-form-label">End Date</label>
													<div class="input-group date">
													<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
														<input id="enddate" class="form-control pull-right"  name="enddate" value="{{!empty($end_date) ? $end_date : ''}}" type="text">
													</div>
												</div>
												<div class="col-sm-3">
													<label for="store" class="col-sm-9 col-form-label">Store</label>
													<select name="store" id="store" class="form-control">
                                                        <option value="0">Please select</option>
														 @if(!empty($user_details))
															@foreach($user_details as $user_data) 
																<option value="{{$user_data['storename']}}"> {{$user_data['storename']}} </option>
															@endforeach    
														@endif
                                                    </select> 
												</div>
												<div class="col-sm-3">
													<label for="status" class="col-sm-9 col-form-label">Status</label>
													<select name="processqueue_status" id="processqueue_status" class="form-control">
                                                        <option value="">Please select</option>
														<option value='0'>Pending</option>
														<option value='1'>Completed</option>
														<option value='2'>Failed</option>
                                                    </select>
												</div>
												<div class="col-sm-3">
													<label for="processqueue_type" class="col-sm-9 col-form-label">Status</label>
													<select name="processqueue_type" id="processqueue_type" class="form-control">
                                                        <option value="">Please select</option>
														<option value='1'>Create Order Webhook</option>
                                                    </select>
												</div>
												<div class="col-sm-3">
												<button type="button" onclick="reload_table('processqueuegrid_dt')" class="col-sm-6 btn btn-success btn-bg" style="margin-top:40px;">
													<i class="fa fa-dot-circle-o"></i> Filter
												</button>
												</div>
											</div>	
                                        </form>
                                    </div>
                            </div>
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2" id="processqueuegrid_dt" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="card-header" style="min-width: 100px">Type</th>
											<th class="card-header" style="min-width: 100px">Shop Domain</th>
											<th class="card-header" style="min-width: 100px">Status</th>
                                            <th class="card-header" style="min-width: 50px">Is Deleted</th>
											<th class="card-header" style="min-width: 50px">Action</th>
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