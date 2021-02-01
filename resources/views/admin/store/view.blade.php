@extends('admin.layouts.master')
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
								<h3 class="title-5 m-b-35">Store Details</h3>
							  </div>
							</div>
							<div class="card">
                                    <div class="card-header">
                                        <strong>Filter</strong> Form
                                    </div>
                                    <div class="card-body card-block">
                                        <form  name="store_filter_data" class="" id="store_filter_data" >
                                          <div class="row form-group">
												<div class="col-sm-3">
													<label for="store_name" class="col-sm-9 col-form-label">Store Name</label>
													 <input type="text" class="form-control" id="store_name" autocomplete="new-store_name" name="store_name" placeholder="Plase Enter Store Name/Email.">
												</div>
												<div class="col-sm-3">
												
												<button type="button" onclick="reload_table('storegrid_dt')" class="col-sm-6 btn btn-success btn-bg" style="margin-top:40px;">
													<i class="fa fa-dot-circle-o"></i> Filter
												</button>
												</div>
											</div>	
                                        </form>
                                    </div>
                                    
                            </div>
								
                          
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2" id="storegrid_dt" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="card-header">Store Name</th>
                                            <th class="card-header">Store Email</th>
                                            <th class="card-header">Status</th>
                                            <th class="card-header">Is Deleted</th>
                                            <th class="card-header">Created At</th>
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
