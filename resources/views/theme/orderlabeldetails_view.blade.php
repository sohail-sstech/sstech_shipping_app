@extends('layouts.master')
@section('content')
<?php

	
	//$All_LabelDetails=$All_LabelDetails[0];
	
	$storename  = !empty($LabelDetails->storename) ? $LabelDetails->storename : 'Not Available';
	
	$shopify_order_id  = !empty($LabelDetails->shopify_order_id) ? $LabelDetails->shopify_order_id : 'Not Available';
	$shopify_order_no  = !empty($LabelDetails->shopify_order_no) ? $LabelDetails->shopify_order_no : 'Not Available';
	$consignment_no  = !empty($LabelDetails->consignment_no) ? $LabelDetails->consignment_no : 'Not Available';
	$carrier_name  = !empty($LabelDetails->carrier_name) ? $LabelDetails->carrier_name : 'Not Available';
	
	if($LabelDetails->is_manifested==1){
		$LabelDetails->is_manifested="<span class='status--process'>Yes</span>";
	}
	else{
		$LabelDetails->is_manifested="<span class='status--denied'>No</span>";
	}
	$is_manifested  = !empty($LabelDetails->is_manifested) ? $LabelDetails->is_manifested : 'Not Available';
	
	if($LabelDetails->status==1)
	{
		$LabelDetails->status="<span class='status--process'>Active</span>";
	}
	else
	{
		$LabelDetails->status="<span class='status--denied'>Deactive</span>";
	}
	
	$status  = !empty($LabelDetails->status) ? $LabelDetails->status : 'Not Available';
	$is_signature_required  = !empty($LabelDetails->is_signature_required) ? $LabelDetails->is_signature_required : 'Not Available';
	$charge  = !empty($LabelDetails->charge) ? $LabelDetails->charge : 'Not Available';
	$delivery_reference  = !empty($LabelDetails->delivery_reference) ? $LabelDetails->delivery_reference : 'Not Available';
	$service_name  = !empty($LabelDetails->service_name) ? $LabelDetails->service_name : 'Not Available';
	$created_at  = !empty($LabelDetails->created_at) ? $LabelDetails->created_at : 'Not Available';
	
	if($LabelDetails->is_deleted==1){
		$LabelDetails->is_deleted="<span class='status--process'>Yes</span>";
	}
	else{
		$LabelDetails->is_deleted="<span class='status--denied'>No</span>";
	}
	
	
	$commodities_details = !empty($LabelDetails->commodities) ? json_decode($LabelDetails->commodities) : '';
	
	$packages_details = !empty($LabelDetails->packages) ? json_decode($LabelDetails->packages) : '';

	$sender_name = !empty($LabelDetails->sender_name) ? $LabelDetails->sender_name : 'Not Available';
	$sender_building = !empty($LabelDetails->sender_building) ? $LabelDetails->sender_building : 'Not Available';
	$sender_street = !empty($LabelDetails->sender_street) ? $LabelDetails->sender_street : 'Not Available';
	$sender_country = !empty($LabelDetails->sender_country) ? $LabelDetails->sender_country : 'Not Available';
	$sender_suburb = !empty($LabelDetails->sender_suburb) ? $LabelDetails->sender_suburb : 'Not Available';
	$sender_state_or_city = !empty($LabelDetails->sender_state_or_city) ? $LabelDetails->sender_state_or_city : 'Not Available';
	$sender_postcode = !empty($LabelDetails->sender_postcode) ? $LabelDetails->sender_postcode : 'Not Available';
	$sender_contact = !empty($LabelDetails->sender_contact) ? $LabelDetails->sender_contact : 'Not Available';
	$sender_phone = !empty($LabelDetails->sender_phone) ? $LabelDetails->sender_phone : 'Not Available';
	$sender_email = !empty($LabelDetails->sender_email) ? $LabelDetails->sender_email : 'Not Available';
	
	$receiver_name = !empty($LabelDetails->receiver_name) ? $LabelDetails->receiver_name : 'Not Available';
	$receiver_building = !empty($LabelDetails->receiver_building) ? $LabelDetails->receiver_building : 'Not Available';
	$receiver_street = !empty($LabelDetails->receiver_street) ? $LabelDetails->receiver_street : 'Not Available';
	$receiver_country = !empty($LabelDetails->receiver_country) ? $LabelDetails->receiver_country : 'Not Available';
	$receiver_suburb = !empty($LabelDetails->receiver_suburb) ? $LabelDetails->receiver_suburb : 'Not Available';
	$receiver_state_or_city = !empty($LabelDetails->receiver_state_or_city) ? $LabelDetails->receiver_state_or_city : 'Not Available';
	$receiver_postcode = !empty($LabelDetails->receiver_postcode) ? $LabelDetails->receiver_postcode : 'Not Available';
	$receiver_contact = !empty($LabelDetails->receiver_contact) ? $LabelDetails->receiver_contact : 'Not Available';
	$receiver_phone = !empty($LabelDetails->receiver_phone) ? $LabelDetails->receiver_phone : 'Not Available';
	$receiver_email = !empty($LabelDetails->receiver_email) ? $LabelDetails->receiver_email : 'Not Available';
	
?>
<div class="container-fluid col-lg-12 top-campaign"> 
<div class="col-md-12">
<!--<button type="button" class="btn btn-secondary mb-1" data-toggle="modal" data-target="#mediumModal">
<a href="{{secure_asset('/orderlabel')}}">Back</a>
</button>-->
<div class="fa-hover col-lg-12 col-md-12">
    <a href="{{secure_asset('/orderlabel')}}" style="cursor: pointer;padding-bottom:30px;">
    <i class="fa fa-chevron-circle-left"></i> Back</a>
</div>
</div>
<div class="col-md-12">
	
		<table class="table table-striped table-bordered">  
		<tr>
		<h4 class="card-header bg-dark">
                        <strong class="card-title text-light">Order Label Details</strong>
		</h4>
		</tr>
			<tr> 
				<td><b> Store Name  </b></td>
				<td align="center"> : </td>
				<td><?php echo $storename; ?></td>
			</tr>
			<tr> 
				<td><b> Shopify Order Id  </b></td>
				<td align="center"> : </td>
				<td><?php echo $shopify_order_id; ?></td>
			</tr>
			<tr> 
				<td><b> Shopify Order No  </b></td>
				<td align="center"> : </td>
				<td><?php echo $shopify_order_no; ?></td>
			</tr>
			<tr> 
				<td><b> Consignment No  </b></td>
				<td align="center"> : </td>
				<td><?php echo $consignment_no; ?></td>
			</tr>
			<tr> 
				<td><b> Carrier Name  </b></td>
				<td align="center"> : </td>
				<td><?php echo $carrier_name; ?></td>
			</tr>
			
			<tr> 
				<td><b> Signature Rquired  </b></td>
				<td align="center"> : </td>
				<td><?php echo $is_signature_required; ?></td>
			</tr>
			<tr> 
				<td><b> Charge </b></td>
				<td align="center"> : </td>
				<td><?php echo $charge; ?></td>
			</tr>
			<tr> 
				<td><b> Delivery Reference </b></td>
				<td align="center"> : </td>
				<td><?php echo $delivery_reference; ?></td>
			</tr>
			<tr> 
				<td><b> Service Name </b></td>
				<td align="center"> : </td>
				<td><?php echo $service_name; ?></td>
			</tr>
			<tr> 
				<td><b> Manifested  </b></td>
				<td align="center"> : </td>
				<td><?php echo $is_manifested; ?></td>
			</tr>
			<tr> 
				<td><b> Status  </b></td>
				<td align="center"> : </td>
				<td><?php echo $status; ?></td>
			</tr>
		
			<tr> 
				<td><b> Created At  </b></td>
				<td align="center"> : </td>
				<td><?php echo date('F d Y  h:i A',strtotime($created_at)); ?></td>
			</tr>
		</table>
		<br>
	
<!--</div>
<div class="col-md-12">-->


<table class="table table-striped table-bordered table-responsive" width="100%" cellspacing="0">
		<tr>
		<h4 class="card-header bg-dark">
                        <strong class="card-title text-light">Sender Details</strong>
		</h4>
		</tr>
		<thead>
		<tr>
			<th>Sender Name</th>
			<th>Sender Building</th>
			<th>Sender Street</th>
			<th>Sender Country</th>
			<th>Sender Suburb</th>
			<th>Sender State/City</th>
			<th>Sender Postcode</th>
			<th>Sender Contact</th>
			<th>Sender Phone</th>
			<th>Sender Email</th>
		</tr>
		</thead>
		<tr>
			<td><?php echo $sender_name;?></td>
			<td><?php echo $sender_building;?></td>
			<td><?php echo $sender_street;?></td>
			<td><?php echo $sender_country;?></td>
			<td><?php echo $sender_suburb;?></td>
			<td><?php echo $sender_state_or_city;?></td>
			<td><?php echo $sender_postcode;?></td>
			<td><?php echo $sender_contact;?></td>
			<td><?php echo $sender_phone;?></td>
			<td><?php echo $sender_email;?></td>
		</tr>
		
		
</table>
<br>


<table class="table table-striped table-bordered table-responsive" width="100%" cellspacing="0">
		<tr>
		<h4 class="card-header bg-dark">
                        <strong class="card-title text-light">Receiver Details</strong>
		</h4>
		</tr>
		<thead>
		<tr>
			<th>Receiver Name</th>
			<th>Receiver Building</th>
			<th>Receiver Street</th>
			<th>Receiver Country</th>
			<th>Receiver Suburb</th>
			<th>Receiver State/City</th>
			<th>Receiver Postcode</th>
			<th>Receiver Contact</th>
			<th>Receiver Phone</th>
			<th>Receiver Email</th>
		</tr>
		</thead>
		<tr>
			<td><?php echo $receiver_name;?></td>
			<td><?php echo $receiver_building;?></td>
			<td><?php echo $receiver_street;?></td>
			<td><?php echo $receiver_country;?></td>
			<td><?php echo $receiver_suburb;?></td>
			<td><?php echo $receiver_state_or_city;?></td>
			<td><?php echo $receiver_postcode;?></td>
			<td><?php echo $receiver_contact;?></td>
			<td><?php echo $receiver_phone;?></td>
			<td><?php echo $receiver_email;?></td>
		</tr>
		
		
</table>
<br>

<?php 
/*echo '<pre>Package';print_r($All_LabelDetails['packages']).'<br>';
echo '<pre>commodities';print_r($All_LabelDetails['commodities']).'<br>';exit;*/
?>

<table class="table table-striped table-bordered" id="pkg_details" width="100%" cellspacing="0">
		<tr>
		<h4 class="card-header bg-dark">
                        <strong class="card-title text-light">Packages Details</strong>
		</h4>
		</tr>
		<tr>
			<th>Height</th>
			<th>Length</th>
			<th>Width</th>
			<th>Kg</th>
			<th>Name</th>
			<th>Type</th>
		</tr>
		<?php if(!empty($packages_details)) {  
			foreach($packages_details as $pkg_val){ 
		?>
		<tr>
			<td><?php if(isset($pkg_val->Height))echo $pkg_val->Height;?></td>
			<td><?php if(isset($pkg_val->Length))echo $pkg_val->Length;?></td>
			<td><?php if(isset($pkg_val->Width))echo $pkg_val->Width;?></td>
			<td><?php if(isset($pkg_val->Kg))echo $pkg_val->Kg;?></td>
			<td><?php if(isset($pkg_val->Name))echo $pkg_val->Name;?></td>
			<td><?php if(isset($pkg_val->Type))echo $pkg_val->Type;?></td>
		</tr>
		<?php } } else {?>
		<tr> <td colspan="7" align="center"> Data Not Available </td></tr>
		<?php } ?>
</table>
<br>


<table class="table table-striped table-bordered">
		<tr>
		<h4 class="card-header bg-dark">
                        <strong class="card-title text-light">Commodities Details</strong>
		</h4>
		</tr>
		<tr>
			<th>Description</th>
			<th>HarmonizedCode</th>
			<th>Units</th>
			<th>UnitValue</th>
			<th>UnitKg</th>
			<th>Currency</th>
			<th>Country</th>
		</tr>
		<?php if(!empty($commodities_details)) {  
			foreach($commodities_details as $comm_val){  
		?>
		<tr>
			<td><?php if(isset($comm_val->Description))echo $comm_val->Description;?></td>
			<td><?php if(isset($comm_val->HarmonizedCode))echo $comm_val->HarmonizedCode;?></td>
			<td><?php if(isset($comm_val->Units))echo $comm_val->Units;?></td>
			<td><?php if(isset($comm_val->UnitValue))echo $comm_val->UnitValue;?></td>
			<td><?php if(isset($comm_val->UnitKg))echo $comm_val->UnitKg;?></td>
			<td><?php if(isset($comm_val->Currency))echo $comm_val->Currency;?></td>
			<td><?php if(isset($comm_val->Country))echo $comm_val->Country;?></td>
			
			
		</tr>
		<?php } } else { ?>
		<tr> <td colspan="6" align="center"> Data Not Available </td></tr>
		<?php } ?>
</table>

</div>
</div>
@endsection