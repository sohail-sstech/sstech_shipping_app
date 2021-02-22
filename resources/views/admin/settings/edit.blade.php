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
									@foreach ($errors->all() as $error)
										<div class="alert alert-danger">
											{{ $error }}
										</div>
									 @endforeach 
									
									 <div class="row">
										 <div class="col-md-12">
												<div class="card-header">
													 <div class="row">
													<div class="col-md-10">
														<p><strong>Settings Edit </strong>Form</p>
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
                                <!--<form action="{{asset('updatechangepassword')}}" method="post" class="form-horizontal" oninput='confirm_password.setCustomValidity(confirm_password.value != new_password.value ? "Passwords do not match." : "")'>-->
                                <form action="{{asset('/admin/settings/update')}}" method="post" class="form-horizontal" id="settings_form" autocomplete="off">
										<input type ="hidden" name ="_token" value = "<?php echo csrf_token(); ?>">
										<input type = "hidden" name ="settingsedit_id" value = "{{$settingseditdata['id']}}">
											<div class="row form-group">
												<div class="col-md-6">	
													<div class="form-group row">
														<label for="store_name" class="col-sm-3 col-form-label">Store <span class="required">*</span></label>
														<div class="col-sm-9">
														  <select name="store_name" id="store_name" class="form-control">
															<option value="">Please select</option>
															 @if(!empty($store_list))
																 @foreach($store_list as $store) 
																	<option value="{{$store['user_id']}}" {{ $settingseditdata['user_id']==$store['user_id'] ? 'selected' : '' }}> {{$store['storename']}} </option>
																 @endforeach    
															 @endif
														  </select>
														</div>
													</div>
													<div class="form-group row">
														<label for="accesstoken" class="col-sm-3 col-form-label">Customer Access Token <span class="required">*</span></label>
														<div class="col-sm-9">
														  <input type="text" class="form-control" id="accesstoken" autocomplete="new-accesstoken" name="accesstoken" value="{{ $settingseditdata['custom_access_token'] }}">
														</div>
													</div>
													<div class="form-group row">
														<label for="recevieremail" class="col-sm-3 col-form-label">Lable Receiver Email <span class="required">*</span></label>
														<div class="col-sm-9">
														<input type="email" id="recevieremail" name="recevieremail" autocomplete="new-recevieremail" class="form-control" value="{{ $settingseditdata['label_receiver_email'] }}">
														</div>
													</div>
													<div class="row form-group">
													<div class="col col-md-3">
														<label class=" form-control-label">From Address</label>
													</div>
													<div class="col col-md-9">
														<div class="form-check-inline form-check" id="radioButtonsdiv">
															<label for="inline-radio1" class="form-check-label" style="padding:1px;margin-right:9px;">
																<input type="radio" id="fromaddressradiobtn" name="fromaddress" value="1"  class="form-check-input fromaddressradiobtn" {{ $settingseditdata['is_from_address'] == 1 ? 'checked' : ''}}>Yes
															</label>
															<label for="inline-radio2" class="form-check-label" style="padding:1px;">
																<input type="radio" id="fromaddressradiobtn" name="fromaddress" value="0"  class="form-check-input fromaddressradiobtn" {{ $settingseditdata['is_from_address'] == 0 ? 'checked' : ''}}>No
															</label>
														</div>
													</div>
													</div>
												</div>
												<div class="col-md-6">	
													
													<div class="customformaddressfields" style="display:none;">
														<div class="form-group row">
															<label for="Name" class="col-sm-3 col-form-label">Name <span class="required">*</span></label>
															<div class="col-sm-9">
																<input type="text" id="Name" name="Name"  class="form-control" value="{{ $settingseditdata['name'] }}">
															</div>
														</div>
														<div class="form-group row">
															<label for="contactperson" class="col-sm-3 col-form-label">Contact Person <span class="required">*</span></label>
															<div class="col-sm-9">
																<input type="text" id="contactperson" name="contactperson" class="form-control" value="{{ $settingseditdata['contact_person'] }}">
															</div>
														</div>
														<div class="form-group row">
															<label for="Address1" class="col-sm-3 col-form-label">Address1 <span class="required">*</span></label>
															<div class="col-sm-9">
																<input type="text" id="fromaddress1" name="fromaddress1" class="form-control" value="{{ $settingseditdata['address1'] }}">
															</div>
														</div>
														<div class="form-group row">
															<label for="Address2" class="col-sm-3 col-form-label">Address2</label>
															<div class="col-sm-9">
																<input type="text" id="fromaddress2" name="fromaddress2" class="form-control" value="{{ $settingseditdata['address2'] }}">
															</div>
														</div>
														<div class="form-group row">
														<label for="select" class="col-sm-3 col-form-label">Country <span class="required">*</span></label>
														<div class="col-sm-9">
															 <select name="countryname" id="countryname" class="form-control">
																<option value="">Please select</option>
															 @if(isset($countrylist))
																 @foreach($countrylist as $cntlist) 
																 <option value="{{$cntlist['name'] .'-'.$cntlist['iso']}}" {{ $settingseditdata['country'] == $cntlist['name'] .'-'.$cntlist['iso'] ? 'selected' : ''}}> {{$cntlist['name'] .'-'.$cntlist['iso']}} </option>
																 @endforeach    
															 @endif	 
															 </select>
															 
														</div>
														</div>
														<div class="form-group row">
															<label for="province" class="col-sm-3 col-form-label">Province <span class="required">*</span></label>
															<div class="col-sm-9">
																<input type="text" id="Province" name="province" class="form-control" value="{{ $settingseditdata['province'] }}">
															</div>
														</div>
														<div class="form-group row">
															<label for="city" class="col-sm-3 col-form-label">City <span class="required">*</span></label>
															<div class="col-sm-9">
																<input type="text" id="city" name="city"  class="form-control" value="{{ $settingseditdata['city'] }}">
															</div>
														</div>
														<div class="form-group row">
															<label for="zipcode" class="col-sm-3 col-form-label">Zip Code <span class="required">*</span></label>
															<div class="col-sm-9">
																<input type="text" id="zipcode" name="zipcode"  class="form-control" value="{{ $settingseditdata['zip'] }}">
															</div>
														</div>
														<div class="form-group row">
															<label for="phone" class="col-sm-3 col-form-label">Phone <span class="required">*</span></label>
															<div class="col-sm-9">
																<input type="number" id="phone" name="phone"  class="form-control" value="{{ $settingseditdata['phone'] }}">
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