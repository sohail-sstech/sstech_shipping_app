@extends('admin.layouts.master')
@section('content')

<section class="p-t-20">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
									@if(session()->has('message'))
										<div class="alert alert-success">
											{{ session()->get('message') }}
										</div>
									@endif
									@if(session()->has('message_failed'))
										<div class="alert alert-danger">
											{{ session()->get('message_failed') }}
										</div>
									@endif
									
									 <div class="row">
										 <div class="col-md-12">
												<div class="card-header">
													 <div class="row">
													<div class="col-md-10">
														<p><strong>Settings Insert </strong>Form</p>
													</div>
													<div class="col-md-2">
														<p style="float:right;">
															<a href="{{asset('/admin/settings')}}" class="au-btn au-btn-icon au-btn--green au-btn--small">
																<i class="zmdi zmdi-plus"></i> View
															</a>	
														</p>
													</div>
													</div>
												</div>
										 </div>
									 </div>
                                    <div class="card-body card-block">
                                <form action="{{asset('/admin/settings/insert')}}" method="post" class="form-horizontal" id="settings_form" autocomplete="off">
										<input type ="hidden" name ="_token" value = "<?php echo csrf_token(); ?>">
										
										
											<div class="row form-group">
												<div class="col-md-6">	
													<div class="form-group row">
														<label for="store_name" class="col-sm-3 col-form-label">Store</label>
														<div class="col-sm-9">
														  <select name="store_name" id="store_name" class="form-control">
															<option value="">Please select</option>
															 @if(!empty($store_list))
																 @foreach($store_list as $store) 
																	<option value="{{$store['user_id']}}"> {{$store['storename']}} </option>
																 @endforeach    
															 @endif
														  </select>
														</div>
													</div>
													<div class="form-group row">
														<label for="accesstoken" class="col-sm-3 col-form-label">Customer Access Token</label>
														<div class="col-sm-9">
														  <input type="text" class="form-control" id="accesstoken" autocomplete="new-accesstoken" name="accesstoken" placeholder="Plase Enter Access Token.">
														</div>
													</div>
													<div class="form-group row">
														<label for="recevieremail" class="col-sm-3 col-form-label">Lable Receiver Email</label>
														<div class="col-sm-9">
														<input type="email" id="recevieremail" name="recevieremail" autocomplete="new-recevieremail" class="form-control" placeholder="Plase Enter Receiver Email.">
														</div>
													</div>
													<div class="row form-group">
													<div class="col col-md-3">
														<label class=" form-control-label">From Address</label>
													</div>
													<div class="col col-md-9">
														<div class="form-check-inline form-check" id="radioButtonsdiv">
															<label for="inline-radio1" class="form-check-label" style="padding:1px;margin-right:9px;">
																<input type="radio" id="fromaddressradiobtn" name="fromaddress" value="1"  class="form-check-input fromaddressradiobtn">Yes
															</label>
															<label for="inline-radio2" class="form-check-label" style="padding:1px;">
																<input type="radio" id="fromaddressradiobtn" name="fromaddress" value="0"  class="form-check-input fromaddressradiobtn" {{'checked'}}>No
															</label>
														</div>
													</div>
													</div>
												</div>
												<div class="col-md-6">	
													
													<div class="customformaddressfields" style="display:none;">
														<div class="form-group row">
															<label for="Name" class="col-sm-3 col-form-label">Name</label>
															<div class="col-sm-9">
																<input type="text" id="Name" name="Name"  class="form-control" placeholder="Plase Enter Name.">
															</div>
														</div>
														<div class="form-group row">
															<label for="contactperson" class="col-sm-3 col-form-label">Contact Person</label>
															<div class="col-sm-9">
																<input type="text" id="contactperson" name="contactperson" class="form-control" placeholder="Plase Enter Contact Person.">
															</div>
														</div>
														<div class="form-group row">
															<label for="Address1" class="col-sm-3 col-form-label">Address1</label>
															<div class="col-sm-9">
																<input type="text" id="fromaddress1" name="fromaddress1" class="form-control" placeholder="Plase Enter Address1.">
															</div>
														</div>
														<div class="form-group row">
															<label for="Address2" class="col-sm-3 col-form-label">Address2</label>
															<div class="col-sm-9">
																<input type="text" id="fromaddress2" name="fromaddress2" class="form-control" placeholder="Plase Enter Address2.">
															</div>
														</div>
														<div class="form-group row">
														<label for="select" class="col-sm-3 col-form-label">Country</label>
														<div class="col-sm-9">
															 <select name="countryname" id="countryname" class="form-control">
																<option value="">Please select</option>
															 @if(isset($countrylist))
																 @foreach($countrylist as $cntlist) 
																 <option value="{{$cntlist['name'] .'-'.$cntlist['iso']}}" > {{$cntlist['name'] .'-'.$cntlist['iso']}} </option>
																 @endforeach    
															 @endif	 
															 </select>
															 
														</div>
														</div>
														<div class="form-group row">
															<label for="province" class="col-sm-3 col-form-label">Province</label>
															<div class="col-sm-9">
																<input type="text" id="Province" name="province" class="form-control" placeholder="Plase Enter Province.">
															</div>
														</div>
														<div class="form-group row">
															<label for="city" class="col-sm-3 col-form-label">City</label>
															<div class="col-sm-9">
																<input type="text" id="city" name="city"  class="form-control" placeholder="Plase Enter City.">
															</div>
														</div>
														<div class="form-group row">
															<label for="zipcode" class="col-sm-3 col-form-label">Zip Code</label>
															<div class="col-sm-9">
																<input type="text" id="zipcode" name="zipcode"  class="form-control" placeholder="Plase Enter Zip Code.">
															</div>
														</div>
														<div class="form-group row">
															<label for="phone" class="col-sm-3 col-form-label">Phone</label>
															<div class="col-sm-9">
																<input type="number" id="phone" name="phone"  class="form-control" placeholder="Plase Enter Phone.">
															</div>
														</div>
												</div>
													
												</div>
											</div>	
                                    </div>
									
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
								</form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

@endsection
<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">