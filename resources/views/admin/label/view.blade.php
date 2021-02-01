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
								<h3 class="title-5 m-b-35">Label Details</h3>
							  </div>
							</div>
							<div class="card">
                                    <div class="card-header">
                                        <strong>Filter</strong> Form
                                    </div>
                                    <div class="card-body card-block">
                                        <form  name="lbldetails_filter_data" class="" id="lbldetails_filter_data" >
                                          <div class="row form-group">
												<div class="col-sm-3">
													<label for="search_data" class="col-sm-9 col-form-label">Search</label>
													 <input type="text" class="form-control" id="search_data" autocomplete="new-search_data" name="search_data" placeholder="ApiUrl,Request,Response,Header.">
												</div>
												
												<div class="col-sm-3">
													<label for="search_data" class="col-sm-9 col-form-label">Store</label>
													<select name="store" id="store" class="form-control">
                                                        <option value="0">Please select</option>
														 @if(!empty($store_details))
															@foreach($store_details as $store_data) 
																<option value="{{$store_data['storename']}}"> {{$store_data['storename']}} </option>
															@endforeach    
														@endif
                                                    </select> 
													
												</div>
												
												<div class="col-sm-3">
												<button type="button" onclick="reload_table('apiloggrid_dt')" class="col-sm-6 btn btn-success btn-bg" style="margin-top:40px;">
													<i class="fa fa-dot-circle-o"></i> Filter
												</button>
												</div>
											</div>	
                                        </form>
                                    </div>
                            </div>
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2" id="lbldetailsgrid_dt" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="card-header" style="min-width: 100px">Shopify Order</th>
											<th class="card-header" style="min-width: 100px">Shopify Order No</th>
                                            <th class="card-header" style="min-width: 100px">Consignment</th>
                                            <th class="card-header" style="min-width: 100px">Carrier</th>
											<th class="card-header" style="min-width: 100px">Is Manifest</th>
											<th class="card-header" style="min-width: 100px">Action</th>
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