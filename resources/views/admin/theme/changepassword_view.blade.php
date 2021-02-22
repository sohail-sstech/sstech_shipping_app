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
									 
                                    <div class="card-header">
                                        <strong>Change Profile</strong> Password
                                    </div>
                                    <div class="card-body card-block">
                                <form action="{{asset('/admin/updatechangepassword')}}" method="post" class="form-horizontal" id="changepassword_form">
										<input type = "hidden" name ="_token" value = "<?php echo csrf_token(); ?>">
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="currentpassword" class="form-control-label">Current Password <span class="required">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-5">
													<div class="input-group">
													  <input type="password" name="current_password" id="current_password" placeholder="Enter Current Password..." class="form-control" data-toggle="password">
													  <div class="input-group-append">
														<span class="input-group-text"><i class="fa fa-eye"></i></span>
													  </div>
													</div>
													<p  class="error common_error" style="display:none;"></p>
                                                </div>
											</div>	
											<div class="row form-group">	
												<div class="col col-md-3">
                                                    <label for="newpassword" class=" form-control-label">New Password <span class="required">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-5">
													<div class="input-group">
													  <input type="password" name="new_password" id="new_password" placeholder="Enter New Password..." class="form-control" data-toggle="password">
													  <div class="input-group-append">
														<span class="input-group-text"><i class="fa fa-eye"></i></span>
													  </div>
													</div>
													<p class="error common_error" style="display:none;"></p>
                                                </div>
											</div>
											<div class="row form-group">	
												<div class="col col-md-3">
                                                    <label for="confirmpassword" class=" form-control-label">Confirm Password <span class="required">*</span></label>
                                                </div>
                                                <div class="col-12 col-md-5">
													<div class="input-group">
													  <input type="password" name="new_confirm_password" id="new_confirm_password" placeholder="Enter Confirm Password..." class="form-control" data-toggle="password">
													  <div class="input-group-append">
														<span class="input-group-text"><i class="fa fa-eye"></i></span>
													  </div>
													</div>
													<p class="error common_error" style="display:none;"></p>
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

<script src="{{ asset('js/jquery-3.5.1.js')}}"></script>
<link href="{{ asset('css/jquerysctipttop.css')}}" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
<script src="{{ asset('js/bootstrap-show-password.js')}}"></script>