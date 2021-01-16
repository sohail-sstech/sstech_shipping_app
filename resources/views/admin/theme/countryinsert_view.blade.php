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
									 
									
                                    <!--<div class="card-header">
                                        <strong>Country Insert </strong>Form
                                    </div>-->
									 <div class="row">
										 <div class="col-md-12">
												<div class="card-header">
													 <div class="row">
													<div class="col-md-10">
														<p><strong>Country Insert </strong>Form</p>
													</div>
													<div class="col-md-2">
														<p>
															<!--<a href="{{asset('/admin/country')}}" class="btn btn-primary btn-bg">
															<i class="fa fa-dot-circle-o"></i> View
															</a>-->
															<a href="{{asset('/admin/country')}}" class="au-btn au-btn-icon au-btn--green au-btn--small">
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
                                <form action="{{asset('/admin/country/insert')}}" method="post" class="form-horizontal" id="countryinsert_form" autocomplete="off">
										<input type ="hidden" name ="_token" value = "<?php echo csrf_token(); ?>">
											<div class="row form-group">
												<div class="col-md-6">	
													<div class="form-group row">
														<label for="countryname" class="col-sm-3 col-form-label">Country Name</label>
														<div class="col-sm-9">
														  <input type="text" class="form-control" id="country_name" autocomplete="new-country_name" name="country_name" placeholder="Plase Enter Country Full Name.">
														</div>
													</div>
													<div class="form-group row">
														<label for="countryshortname" class="col-sm-3 col-form-label">Country Short Name</label>
														<div class="col-sm-9">
														  <input type="text" class="form-control" id="country_shortname" autocomplete="new-country_shortname" placeholder="Plase Enter like IN,AU..." name="country_shortname" maxlength="2" >
														</div>
													</div>
													<div class="form-group row">
														<label for="countryshortname" class="col-sm-3 col-form-label">Status</label>
														<div class="col-sm-9">
														  <select name="country_status" id="select" class="form-control">
															<option value="1">Active</option>
															<option value="0">Deactive</option>
														  </select>
														</div>
													</div>

												</div>
												<div class="col-md-6">	
													<div class="form-group row">
													<label for="countryiso" class="col-sm-3 col-form-label">Country ISO</label>
													<div class="col-sm-9">
													  <input type="text" class="form-control" id="country_iso" name="country_iso" autocomplete="new-country_iso" placeholder="Plase Enter like AFG,ATG..." maxlength="3" >
													</div>
													</div>
													<div class="form-group row">
														<label for="countrycode" class="col-sm-3 col-form-label">Country Code</label>
														<div class="col-sm-9">
														  <input type="number" class="form-control" id="country_code" autocomplete="new-country_code" name="country_code" placeholder="Plase Enter like 91,93..." maxlength="10"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" >
														</div>
													</div>
													<div class="form-group row">
														<label for="countrynumcode" class="col-sm-3 col-form-label">Country NumCode</label>
														<div class="col-sm-9">
														  <input type="number" class="form-control" id="country_numcode" autocomplete="new-country_numcode" name="country_numcode" placeholder="Plase Enter like 9,660..." maxlength="10"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" >
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
<!--<script src="{{ asset('js/jquery-3.5.1.js')}}"></script>-->
<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}">
  
 
<!--<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>-->

<!--<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>-->


<style>
 .error {
      color: #a81515;
    
   }
</style>

<script>
$(function(){
$('#countryinsert_form').validate({ 
    rules: {
        country_name: {
			required: true,
		},
		country_shortname: {
			required: true,
		},
		country_iso: {
			required: true,
		},
		country_code: {
			required: true,
		},
		country_numcode: {
			required: true,
		},
    }
});
});
$(document).ready(function()
{
	slideupslidedown_event();
});
/*trigger function slide up and slide down*/
function slideupslidedown_event(){
	$(".alert-success").fadeTo(5000, 500).slideUp(500, function()
	{
		$(".alert-success").slideUp(500);		
	});	

	$(".alert-danger").fadeTo(5000, 500).slideUp(500, function()
	{
		$(".alert-danger").slideUp(500);		
	});
}
</script>
