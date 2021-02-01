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
                                    <div class="card-header">
                                        <strong>Update User</strong> Profile
                                    </div>
                                    <div class="card-body card-block">
                                <form action="{{asset('/admin/updateprofile')}}" method="post" class="form-horizontal" id="updateprofileform">
										<input type = "hidden" name ="_token" value = "<?php echo csrf_token(); ?>">
										<input type = "hidden" name ="profile_id" value = "{{$profiledata['id']}}">
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="hf-name" class=" form-control-label">Name</label>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <input type="text" id="hf-name" name="profile_name" autocomplete="new-profile_name" placeholder="Enter Name..." class="form-control" value="{{$profiledata['name']}}" required>
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