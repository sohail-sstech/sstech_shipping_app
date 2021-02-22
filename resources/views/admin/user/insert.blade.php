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
														<p><strong>User Insert </strong>Form</p>
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
                                <form action="{{asset('/admin/user/insert')}}" method="post" class="form-horizontal" id="userinsert_form" autocomplete="off">
										<input type ="hidden" name ="_token" value = "<?php echo csrf_token(); ?>">
											<div class="row form-group">
												<div class="col-md-6">	
													<div class="form-group row">
														<label for="user_name" class="col-sm-3 col-form-label">User Name <span class="required">*</span></label>
														<div class="col-sm-9">
														  <input type="text" class="form-control" id="user_name" autocomplete="new-user_name" name="user_name" placeholder="Plase Enter User Name.">
														</div>
													</div>
													<div class="form-group row">
														<label for="user_password" class="col-sm-3 col-form-label">User Password <span class="required">*</span></label>
														<div class="col-sm-9">
														  <input type="password" class="form-control" id="user_password" autocomplete="new-user_password" name="user_password" placeholder="Plase Enter User Password." autocomplete="off">
														</div>
													</div>
													<div class="form-group row">
														<label for="user_role" class="col-sm-3 col-form-label">User Role <span class="required">*</span></label>
														<div class="col-sm-9">
														  <select name="user_role" id="select" class="form-control">
															<option value="">Please select</option>
															 @if(!empty($rolelist))
																 @foreach($rolelist as $role) 
																 <option value="{{$role['id']}}"> {{$role['name']}} </option>
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
														  <input type="text" class="form-control" id="user_email" autocomplete="new-user_email" name="user_email" placeholder="Plase Enter User Email.">
														</div>
													</div>
													
													<div class="form-group row">
														<label for="user_password" class="col-sm-3 col-form-label">User Confirm Password</label>
														<div class="col-sm-9">
														  <input type="password" class="form-control" id="user_confirmpwd" autocomplete="new-user_confirmpwd" name="user_confirmpwd" placeholder="Plase Enter User Confirm Password." autocomplete="off">
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