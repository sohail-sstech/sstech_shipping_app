@extends('layouts.master')
@section('content')
<div class="container-fluid">
        <div class="row">
           <div class="col-lg-12 top-campaign">
               <div class="au-card">
					<h4 class="card-header bg-dark">
                        <strong class="card-title text-light">Setting Update </strong>
					</h4>
                   <!--<div class="card-header">
                       <strong>Setting Update</strong> 
                   </div>-->
				<form action="{{secure_asset('/updatesettingsdata')}}" method="post">
				 <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
				 <input type = "hidden" name = "setting_id" value = "{{$settingdata->id}}">
					<div class="card-body card-block">
							<div class="form-group">
								<label for="nf-accesstoken" class=" form-control-label">Customer Access Token</label>
										<input type="text" id="accesstoken" name="accesstoken"  value="{{ $settingdata->custom_access_token }}"  class="form-control">
							</div>
							<div class="form-group">
								<label for="nf-recevieremail" class=" form-control-label">Lable Receiver Email</label>
								<input type="email" id="recevieremail" name="recevieremail"  value="{{ $settingdata->label_receiver_email }}" class="form-control">
							</div>
							
							
							<div class="row form-group">
                                    <div class="col col-md-2">
                                        <label class=" form-control-label">From Address</label>
                                    </div>
                                    <div class="col col-md-10">
                                        <div class="form-check-inline form-check" id="radioButtonsdiv">
                                            <label for="inline-radio1" class="form-check-label" style="padding:1px;margin-right:9px;">
                                                <input type="radio" id="fromaddressradiobtn" name="fromaddress" value="1"  class="form-check-input fromaddressradiobtn" {{ $settingdata->is_from_address == 1 ? 'checked' : ''}}>Yes
                                            </label>
                                            <label for="inline-radio2" class="form-check-label" style="padding:1px;">
                                                <input type="radio" id="fromaddressradiobtn" name="fromaddress" value="0"  class="form-check-input fromaddressradiobtn" {{ $settingdata->is_from_address == 0 ? 'checked' : ''}}>No
                                            </label>
                                        </div>
                                    </div>
                            </div>
							
							<div class="customformaddressfields" style="display:none;">
									<div class="form-group">
										<label for="company_name" class="form-control-label">Company</label>
										<input type="text" id="company_name" name="company_name" value="{{$settingdata->company_name}}" class="form-control">
									</div>
									<div class="form-group">
										<label for="Name" class="form-control-label">Name</label>
										<input type="text" id="Name" name="Name" value="{{$settingdata->name}}" class="form-control">
									</div>
									<div class="form-group">
										<label for="contactperson" class=" form-control-label">Contact Person</label>
										<input type="text" id="contactperson" name="contactperson"  value="{{$settingdata->contact_person}}" class="form-control">
									</div>
									<div class="form-group">
										<label for="Address1" class=" form-control-label">Address1</label>
										<input type="text" id="fromaddress1" name="fromaddress1" value="{{$settingdata->address1}}" class="form-control">
									</div>
									<div class="form-group">
										<label for="Address2" class=" form-control-label">Address2</label>
										<input type="text" id="fromaddress2" name="fromaddress2" value="{{$settingdata->address2}}" class="form-control">
									</div>
									<div class="form-group">
										 
										 <label for="select" class=" form-control-label">Country</label>
										 <select name="countryname" id="countryname" class="form-control">
											<option value="">Please select</option>
										 @if(isset($countrylist))
											 @foreach($countrylist as $cntlist) 
											 <option value="{{$cntlist->name .'-'.$cntlist->iso}}" {{ $settingdata->country == $cntlist->name .'-'.$cntlist->iso ? 'selected' : ''}} > {{$cntlist->name .'-'.$cntlist->iso}} </option>
											 @endforeach    
										 @endif	 
										 </select>
										 
									</div>
									<div class="form-group">
										<label for="province" class=" form-control-label">Province</label>
										<input type="text" id="Province" name="province" value="{{$settingdata->province}}" class="form-control">
									</div>
									<div class="form-group">
										<label for="city" class=" form-control-label">City</label>
										<input type="text" id="city" name="city" value="{{$settingdata->city}}" class="form-control">
									</div>
									<div class="form-group">
										<label for="zipcode" class=" form-control-label">Zip Code</label>
										<input type="text" id="zipcode" name="zipcode" value="{{$settingdata->zip}}" class="form-control">
									</div>
									<div class="form-group">
										<label for="phone" class=" form-control-label">Phone</label>
										<input type="text" id="phone" name="phone" value="{{$settingdata->phone}}" class="form-control">
									</div>
							</div>
							
								
					</div>
				
					<div class="card-footer">
						<button type="submit" class="btn btn-primary btn-sm">
							<i class="fa fa-dot-circle-o"></i> Update
						</button>	
					</div>
				</form>
               </div>
           </div>
       </div>
       <div class="row">
           <div class="col-md-12">
               <div class="copyright">
                   <p>Copyright © 2020 <a href="https://sstechsystem.com" target="_self">SSTECHSYSTEM</a>. All rights reserved.</p>
               </div>
           </div>
       </div>
</div>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--<script src="{{ secure_asset('vendor/jquery-3.2.1.min.js')}}"></script>-->
<script>
$(document).ready(function() {
	$('form').attr('autocomplete','off');
	 var editradiobutton_values = $("input[name='fromaddress']:checked").val();
	 if(editradiobutton_values==1){
		 $('.customformaddressfields').css('display','block');
		 $('.customformaddressfields').find("input[type=text],input[type=number],textarea,select").attr('required', 'required');
	 }
	else{
		$('.customformaddressfields').find("input[type=text],input[type=number],textarea,select").removeAttr('required');
	} 
	 
});	
$(function(){
$('#radioButtonsdiv').on('change', 'input[name=fromaddress]:radio', function (e) {
$('form').attr('autocomplete','off');	
var radioscurrent_values = $(this).val();
	if(radioscurrent_values==1){
		$('.customformaddressfields').css('display','block');
		$('.customformaddressfields').find("input[type=text],input[type=number],textarea,select").attr('required', 'required');
	}
	else{
		$('.customformaddressfields').css('display','none');
		//$('.customformaddressfields').find("input[type=text],input[type=number],textarea,select").val("");
		$('.customformaddressfields').find("input[type=text],input[type=number],textarea,select").removeAttr('required');
	}
});	
});
</script>