@extends('admin.layouts.master')
@section('content')
<section class="p-t-20">
                <div class="container">
                    <div class="row">
				        <div class="col-md-12 top-campaign">
							@if(session()->has('message'))
								<div class="alert alert-success">
									{{ session()->get('message') }}
								</div>
							@endif
						    <div class="row">
							  <div class="col-md-10">
								<h3 class="title-5 m-b-35">Roles Details</h3>
							  </div>
							</div>
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2" id="rolegrid_dt" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="card-header">Name</th>
                                            <th class="card-header">Description</th>
                                            <th class="card-header">Status</th>
                                            <th class="card-header">Is Deleted</th>
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