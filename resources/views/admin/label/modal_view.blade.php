<?php

	$All_LabelDetails=$All_LabelDetails[0];
	
	$storename  = !empty($All_LabelDetails['storename']) ? $All_LabelDetails['storename'] : 'Not Available';
	$shopify_order_id  = !empty($All_LabelDetails['shopify_order_id']) ? $All_LabelDetails['shopify_order_id'] : 'Not Available';
	$shopify_order_no  = !empty($All_LabelDetails['shopify_order_no']) ? $All_LabelDetails['shopify_order_no'] : 'Not Available';
	$consignment_no  = !empty($All_LabelDetails['consignment_no']) ? $All_LabelDetails['consignment_no'] : 'Not Available';
	$carrier_name  = !empty($All_LabelDetails['carrier_name']) ? $All_LabelDetails['carrier_name'] : 'Not Available';
	
	if($All_LabelDetails['is_manifested']==1){
		$All_LabelDetails['is_manifested']="<span class='status--process'>Yes</span>";
	}
	else{
		$All_LabelDetails['is_manifested']="<span class='status--denied'>No</span>";
	}
	$is_manifested  = !empty($All_LabelDetails['is_manifested']) ? $All_LabelDetails['is_manifested'] : 'Not Available';
	
	if($All_LabelDetails['status']==1)
	{
		$All_LabelDetails['status']="<span class='status--process'>Active</span>";
	}
	else
	{
		$All_LabelDetails['status']="<span class='status--denied'>Deactive</span>";
	}
	
	$status  = !empty($All_LabelDetails['status']) ? $All_LabelDetails['status'] : 'Not Available';
	$is_signature_required  = !empty($All_LabelDetails['is_signature_required']) ? $All_LabelDetails['is_signature_required'] : 'Not Available';
	$charge  = !empty($All_LabelDetails['charge']) ? $All_LabelDetails['charge'] : 'Not Available';
	$delivery_reference  = !empty($All_LabelDetails['delivery_reference']) ? $All_LabelDetails['delivery_reference'] : 'Not Available';
	$service_name  = !empty($All_LabelDetails['service_name']) ? $All_LabelDetails['service_name'] : 'Not Available';
	$created_at  = !empty($All_LabelDetails['created_at']) ? $All_LabelDetails['created_at'] : 'Not Available';
	
	if($All_LabelDetails['is_deleted']==1){
		$All_LabelDetails['is_deleted']="<span class='status--process'>Yes</span>";
	}
	else{
		$All_LabelDetails['is_deleted']="<span class='status--denied'>No</span>";
	}
	
	
	$commodities_details = !empty($All_LabelDetails['commodities']) ? json_decode($All_LabelDetails['commodities']) : '';
	
	$packages_details = !empty($All_LabelDetails['packages']) ? json_decode($All_LabelDetails['packages']) : '';

	$sender_name = !empty($All_LabelDetails['sender_name']) ? $All_LabelDetails['sender_name'] : 'Not Available';
	$sender_building = !empty($All_LabelDetails['sender_building']) ? $All_LabelDetails['sender_building'] : 'Not Available';
	$sender_street = !empty($All_LabelDetails['sender_street']) ? $All_LabelDetails['sender_street'] : 'Not Available';
	$sender_country = !empty($All_LabelDetails['sender_country']) ? $All_LabelDetails['sender_country'] : 'Not Available';
	$sender_suburb = !empty($All_LabelDetails['sender_suburb']) ? $All_LabelDetails['sender_suburb'] : 'Not Available';
	$sender_state_or_city = !empty($All_LabelDetails['sender_state_or_city']) ? $All_LabelDetails['sender_state_or_city'] : 'Not Available';
	$sender_postcode = !empty($All_LabelDetails['sender_postcode']) ? $All_LabelDetails['sender_postcode'] : 'Not Available';
	$sender_contact = !empty($All_LabelDetails['sender_contact']) ? $All_LabelDetails['sender_contact'] : 'Not Available';
	$sender_phone = !empty($All_LabelDetails['sender_phone']) ? $All_LabelDetails['sender_phone'] : 'Not Available';
	$sender_email = !empty($All_LabelDetails['sender_email']) ? $All_LabelDetails['sender_email'] : 'Not Available';
	
	$receiver_name = !empty($All_LabelDetails['receiver_name']) ? $All_LabelDetails['receiver_name'] : 'Not Available';
	$receiver_building = !empty($All_LabelDetails['receiver_building']) ? $All_LabelDetails['receiver_building'] : 'Not Available';
	$receiver_street = !empty($All_LabelDetails['receiver_street']) ? $All_LabelDetails['receiver_street'] : 'Not Available';
	$receiver_country = !empty($All_LabelDetails['receiver_country']) ? $All_LabelDetails['receiver_country'] : 'Not Available';
	$receiver_suburb = !empty($All_LabelDetails['receiver_suburb']) ? $All_LabelDetails['receiver_suburb'] : 'Not Available';
	$receiver_state_or_city = !empty($All_LabelDetails['receiver_state_or_city']) ? $All_LabelDetails['receiver_state_or_city'] : 'Not Available';
	$receiver_postcode = !empty($All_LabelDetails['receiver_postcode']) ? $All_LabelDetails['receiver_postcode'] : 'Not Available';
	$receiver_contact = !empty($All_LabelDetails['receiver_contact']) ? $All_LabelDetails['receiver_contact'] : 'Not Available';
	$receiver_phone = !empty($All_LabelDetails['receiver_phone']) ? $All_LabelDetails['receiver_phone'] : 'Not Available';
	$receiver_email = !empty($All_LabelDetails['receiver_email']) ? $All_LabelDetails['receiver_email'] : 'Not Available';
	
?>
<div class="col-md-12">
	
		<table class="table table-striped table-bordered">  
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
	
</div>
<div class="col-md-12">

<div style="margin-bottom: 15px;">
<table class="table table-striped table-bordered table-responsive" width="100%" cellspacing="0">
		<tr>
		<h4 class="modal-title">Sender Details</h4>
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
</div>
<div style="margin-bottom:15px;">
<table class="table table-striped table-bordered table-responsive" width="100%" cellspacing="0">
		<tr>
		<h4 class="modal-title">Receiver Details</h4>
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
</div>
<?php 
/*echo '<pre>Package';print_r($All_LabelDetails['packages']).'<br>';
echo '<pre>commodities';print_r($All_LabelDetails['commodities']).'<br>';exit;*/
?>
<div style="margin-bottom: 15px;">
<table class="table table-striped table-bordered" id="pkg_details" width="100%" cellspacing="0">
		<tr>
		<h4 class="modal-title">Packages Details</h4>
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
</div>
<div style="margin-bottom: 15px;">
<table class="table table-striped table-bordered">
		<tr>
		<h4 class="modal-title">Commodities Details</h4>
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