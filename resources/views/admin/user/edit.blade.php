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
									@foreach ($errors->all() as $error)
										<div class="alert alert-danger">
											{{ $error }}
										</div>
									 @endforeach 
									
									 <div class="row">
										 <div class="col-md-12">
												<div class="card-header">
													 <div class="row">
													<div class="col-md-8">
														<p><strong>User </strong>Edit</p>
													</div>
													<div class="col-md-4">
														<p style="float:right;">
															<a href="{{asset('/admin/user')}}" class="au-btn au-btn-icon au-btn--green au-btn--small">
																<i class="zmdi zmdi-plus"></i> View Users
															</a>	
														</p>
													</div>
													</div>
												</div>
										 </div>
										 
									 </div>
                                    <div class="card-body card-block">
                                <!--<form action="{{asset('updatechangepassword')}}" method="post" class="form-horizontal" oninput='confirm_password.setCustomValidity(confirm_password.value != new_password.value ? "Passwords do not match." : "")'>-->
                                <form action="{{asset('/admin/user/update')}}" method="post" class="form-horizontal" id="useredit_form" autocomplete="off">
										<input type ="hidden" name ="_token" value = "<?php echo csrf_token(); ?>">
										<input type = "hidden" name ="useredit_id" value = "{{$usereditdata['id']}}">
										
										<div class="col-lg-12">
											<div class="row form-group">
												<div class="col-lg-6 row form-group">	
													<div class="col col-md-3">
														<label for="user_name" class="form-control-label">Name <span class="required">*</span></label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" class="form-control" id="user_name" autocomplete="new-user_name" name="user_name" value="@if(isset($usereditdata['name'])){{$usereditdata['name']}}@endif">
													</div>
												</div>
												<div class="col-lg-6 row form-group">	
													<div class="col col-md-3">
														<label for="user_email" class="form-control-label">Email <span class="required">*</span></label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" class="form-control" id="user_email" autocomplete="new-user_email" name="user_email" value="@if(isset($usereditdata['email'])){{$usereditdata['email']}}@endif">
													</div>
												</div>
											</div>
											<div class="row form-group">
												<div class="col-lg-6 row form-group">	
													<div class="col col-md-3">
														<label for="user_password" class="form-control-label">Password <span class="required">*</span></label>
													</div>
													<div class="col-12 col-md-9">
														<input type="password" class="form-control" id="user_password" autocomplete="new-user_password" name="user_password" autocomplete="off">
													</div>
												</div>
												<div class="col-lg-6 row form-group">	
													<div class="col col-md-3">
														<label for="user_role" class="form-control-label">Role <span class="required">*</span></label>
													</div>
													<div class="col-12 col-md-9">
														 <select name="user_role" id="select" class="form-control">
															<option value="">Please select</option>
															 @if(!empty($rolelist))
																 @foreach($rolelist as $role) 
																 <option value="{{$role['id']}}"@if($role['id']==$usereditdata['role_id']) selected='selected' @endif> {{$role['name']}} </option>
																 @endforeach    
															 @endif
														  </select>
													</div>
												</div>
											</div>
											<div class="row form-group">
												<div class="col-lg-6 row form-group">	
													<div class="col col-md-3">
														<label for="user_company" class="form-control-label">Company</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" class="form-control" id="user_company" autocomplete="new-user_company" name="user_company" value="@if(isset($usereditdata['company'])){{$usereditdata['company']}}@endif">
													</div>
												</div>
												<div class="col-lg-6 row form-group">	
													<div class="col col-md-3">
														<label for="user_address1" class="form-control-label">Address1 <span class="required">*</span></label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" class="form-control" id="user_address1" autocomplete="new-user_address1" name="user_address1" value="@if(isset($usereditdata['address1'])){{$usereditdata['address1']}}@endif">
													</div>
												</div>
											</div>
											<div class="row form-group">
												<div class="col-lg-6 row form-group">	
													<div class="col col-md-3">
														<label for="user_address2" class="form-control-label">Address2</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" class="form-control" id="user_address2" autocomplete="new-user_address2" name="user_address2" value="@if(isset($usereditdata['address2'])){{$usereditdata['address2']}}@endif">
													</div>
												</div>
												<div class="col-lg-6 row form-group">	
													<div class="col col-md-3">
														<label for="user_city" class="form-control-label">City <span class="required">*</span></label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" class="form-control" id="user_city" autocomplete="new-user_city" name="user_city" value="@if(isset($usereditdata['city'])){{$usereditdata['city']}}@endif">
													</div>
												</div>
											</div>
											<div class="row form-group">
												<div class="col-lg-6 row form-group">	
													<div class="col col-md-3">
														<label for="user_state" class="form-control-label">State <span class="required">*</span></label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" class="form-control" id="user_state" autocomplete="new-user_state" name="user_state" value="@if(isset($usereditdata['state'])){{$usereditdata['state']}}@endif">
													</div>
												</div>
												<div class="col-lg-6 row form-group">	
													<div class="col col-md-3">
														<label for="user_pincode" class="form-control-label">Pincode <span class="required">*</span></label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" class="form-control" id="user_pincode" autocomplete="new-user_pincode" name="user_pincode" value="@if(isset($usereditdata['pincode'])){{$usereditdata['pincode']}}@endif">
													</div>
												</div>
											</div>
											<div class="row form-group">
												<div class="col-lg-6 row form-group">	
													<div class="col col-md-3">
														<label for="user_country" class="form-control-label">Country <span class="required">*</span></label>
													</div>
													<div class="col-12 col-md-9">
														<select name="user_country" id="select" class="form-control apply_select2">
															<option value="">Please select</option>
															 @if(!empty($country_list))
																 @foreach($country_list as $country) 
																 <option value="{{$country['id']}}" @if($country['id']==$usereditdata['country_id']) selected='selected' @endif> {{$country['name']}}-{{$country['iso']}} </option>
																 @endforeach    
															 @endif
														  </select>
													</div>
												</div>
												<div class="col-lg-6 row form-group">	
													<div class="col col-md-3">
														<label for="user_phone" class="form-control-label">Phone</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" class="form-control" id="user_phone" autocomplete="new-user_phone" name="user_phone" value="@if(isset($usereditdata['phone'])){{$usereditdata['phone']}}@endif">
													</div>
												</div>
											</div>
											<div class="row form-group">
												<div class="col-lg-6 row form-group">	
													<div class="col col-md-3">
														<label for="user_mobile" class="form-control-label">Mobile</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" class="form-control" id="user_mobile" autocomplete="new-user_mobile" name="user_mobile" value="@if(isset($usereditdata['mobile'])){{$usereditdata['mobile']}}@endif">
													</div>
												</div>
												<div class="col-lg-6 row form-group">	
													<div class="col col-md-3">
														<label for="user_phone" class="form-control-label">Status</label>
													</div>
													<div class="col-12 col-md-9">
														<div class="form-check-inline form-check">
                                                        <label for="inline-radio1" class="form-check-label form-check-inline">
                                                            <input type="radio" id="inline-radio1" name="user_status" value="1" class="form-check-input" {{ $usereditdata['status'] == 1 ? 'checked' : ''}} >Active
                                                        </label>
                                                        <label for="inline-radio2" class="form-check-label form-check-inline">
                                                            <input type="radio" id="inline-radio2" name="user_status" value="0"  class="form-check-input" {{ $usereditdata['status'] == 0 ? 'checked' : ''}} >Deactive
                                                        </label>
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