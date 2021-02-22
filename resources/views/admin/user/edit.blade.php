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
														<p><strong>User Edit </strong>Form</p>
													</div>
													<div class="col-md-2">
														<p style="float:right;">
															<a href="{{asset('/admin/user')}}" class="au-btn au-btn-icon au-btn--green au-btn--small">
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
                                <form action="{{asset('/admin/user/update')}}" method="post" class="form-horizontal" id="useredit_form" autocomplete="off">
										<input type ="hidden" name ="_token" value = "<?php echo csrf_token(); ?>">
										<input type = "hidden" name ="useredit_id" value = "{{$usereditdata['id']}}">
											<div class="row form-group">
												<div class="col-md-6">	
													<div class="form-group row">
														<label for="user_name" class="col-sm-3 col-form-label">User Name <span class="required">*</span></label>
														<div class="col-sm-9">
														  <input type="text" class="form-control" id="user_name" autocomplete="new-user_name" name="user_name" value="@if(isset($usereditdata['name'])){{$usereditdata['name']}}@endif">
														</div>
													</div>
													<div class="form-group row">
														<label for="user_role" class="col-sm-3 col-form-label">User Role <span class="required">*</span></label>
														<div class="col-sm-9">
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
												<div class="col-md-6">	
													<div class="form-group row">
														<label for="user_email" class="col-sm-3 col-form-label">User Email <span class="required">*</span></label>
														<div class="col-sm-9">
														  <input type="text" class="form-control" id="user_email" autocomplete="new-user_email" name="user_email" value="@if(isset($usereditdata['email'])){{$usereditdata['email']}}@endif">
														</div>
													</div>
													<div class="form-group row">
														<label for="user_password" class="col-sm-3 col-form-label">User Password </label>
														<div class="col-sm-9">
														  <input type="password" class="form-control" id="user_password" autocomplete="new-user_password" name="user_password" autocomplete="off">
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