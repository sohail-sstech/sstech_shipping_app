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
														<p><strong>Role Edit </strong>Form</p>
													</div>
													<div class="col-md-2">
														<p style="float:right;">
															<a href="{{asset('/admin/role')}}" class="au-btn au-btn-icon au-btn--green au-btn--small">
																<i class="zmdi zmdi-plus"></i> View
															</a>	
														</p>
													</div>
													</div>
												</div>
										 </div>
										 
									 </div>
                                    <div class="card-body card-block">
                                <form action="{{asset('/admin/role/update')}}" method="post" class="form-horizontal" id="roleedit_form" autocomplete="off">
										<input type ="hidden" name ="_token" value = "<?php echo csrf_token(); ?>">
										<input type = "hidden" name ="roleedit_id" value = "{{$roleeditdata['id']}}">
											<div class="row form-group">
												<div class="col-md-6">	
													<div class="form-group row">
														<label for="role_name" class="col-sm-3 col-form-label">Role Name <span class="required">*</span></label>
														<div class="col-sm-9">
														  <input type="text" class="form-control" id="role_name" autocomplete="new-role_name" name="role_name" value="@if(isset($roleeditdata['name'])){{$roleeditdata['name']}}@endif">
														</div>
													</div>
													
												</div>
												<div class="col-md-6">	
													<div class="form-group row">
														<label for="role_description" class="col-sm-3 col-form-label">Role Description <span class="required">*</span></label>
														<div class="col-sm-9">
															<textarea class="form-control" id="role_description" autocomplete="new-role_description" name="role_description">@if(isset($roleeditdata['description'])){{$roleeditdata['description']}}@endif</textarea>
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