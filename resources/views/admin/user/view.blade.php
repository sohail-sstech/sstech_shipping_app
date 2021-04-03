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
								<h3 class="title-5 m-b-35">Users</h3>
							  </div>
							  <div class="col-md-4">
								<p style="float:right;">
									<a href="{{asset('/admin/user/insert_form')}}" class="au-btn au-btn-icon au-btn--green au-btn--small">
                                           <i class="zmdi zmdi-plus"></i> Add User
                                    </a>		
								</p>	
							  </div>
							</div>
								
							<div class="card">
                                    <div class="card-header">
                                        <strong>Search</strong> Users
                                    </div>
                                    <div class="card-body card-block">
                                        <form  name="Country_filter_data" class="" id="Country_filter_data" >
                                          <div class="row form-group">
												<div class="col-sm-3">
													<label for="user_name" class="col-form-label">Search</label>
													 <input type="text" class="form-control" id="user_name" autocomplete="new-user_name" name="user_name" placeholder="Please Enter User Name.">
												</div>
												<div class="">
												
												<button type="button" onclick="reload_table('usergrid_dt')" class=" btn btn-success btn-bg" style="margin-top:40px;">
													<i class="fa fa-dot-circle-o"></i> Search
												</button>
												</div>
											</div>	
                                        </form>
                                    </div>
                                    
                            </div>
								
                          
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2" id="usergrid_dt" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="card-header">Name</th>
                                            <th class="card-header">Email</th>
                                            <th class="card-header">Role</th>
                                            <th class="card-header">Status</th>
                                            <th class="card-header">Created At</th>
                                            <th class="card-header">Action</th>
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
