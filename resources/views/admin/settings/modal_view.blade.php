<?php
	$All_SettingsDetails=$All_SettingsDetails[0];
	
	$storename = !empty($All_SettingsDetails['storename']) ? $All_SettingsDetails['storename'] : '';
	$custom_access_token = !empty($All_SettingsDetails['custom_access_token']) ? $All_SettingsDetails['custom_access_token'] : '';
	$label_receiver_email = !empty($All_SettingsDetails['label_receiver_email']) ? $All_SettingsDetails['label_receiver_email'] : '';
	
	
	if($All_SettingsDetails['is_from_address']==1){
		$is_from_address = !empty($All_SettingsDetails['is_from_address'])? "<span class='status--process'>Yes</span>" : '';
	}
	else{
		$is_from_address = !empty($All_SettingsDetails['is_from_address'])? "<span class='status--denied'>No</span>" : '';
	}
	$name  = !empty($All_SettingsDetails['name']) ? $All_SettingsDetails['name'] : null;
	$contact_person  = !empty($All_SettingsDetails['contact_person']) ? $All_SettingsDetails['contact_person'] : null;
	$address1  = !empty($All_SettingsDetails['address1']) ? $All_SettingsDetails['address1'] : null;
	$address2  = !empty($All_SettingsDetails['address2']) ? $All_SettingsDetails['address2'] : null;
	$country  = !empty($All_SettingsDetails['country']) ? $All_SettingsDetails['country'] : null;
	$province  = !empty($All_SettingsDetails['province']) ? $All_SettingsDetails['province'] : null;
	$city  = !empty($All_SettingsDetails['city']) ? $All_SettingsDetails['city'] : null;
	$zip  = !empty($All_SettingsDetails['zip']) ? $All_SettingsDetails['zip'] : null;
	$phone  = !empty($All_SettingsDetails['phone']) ? $All_SettingsDetails['phone'] : null;
	
	if($All_SettingsDetails['status']==1){
		$status = "<span class='status--process'>Yes</span>";
	}
	else{
		$status = "<span class='status--denied'>No</span>";
	}
	
	if($All_SettingsDetails['is_deleted']==1){
		$is_deleted = "<span class='status--process'>Yes</span>";
	}
	else{
		$is_deleted = "<span class='status--denied'>No</span>";
	}
	$created_at  = !empty($All_SettingsDetails['created_at']) ? date('F d Y  h:i A',strtotime($All_SettingsDetails['created_at'])) : "";
?>
<div class="col-md-12">
	<div class="col-md-12">
		<table class="table">  
			<tr> 
				<td><b> Store  </b></td>
				<td align="center"> : </td>
				<td><?php echo $storename; ?></td>
			</tr>
			<tr> 
				<td><b> Custom Access Token  </b></td>
				<td align="center"> : </td>
				<td><?php echo $custom_access_token; ?></td>
			</tr>
			<tr> 
				<td><b> Label Receiver Email  </b></td>
				<td align="center"> : </td>
				<td><?php echo $label_receiver_email; ?></td>
			</tr>
			<tr> 
				<td><b> Name  </b></td>
				<td align="center"> : </td>
				<td><?php echo $name; ?></td>
			</tr>
			<tr> 
				<td><b> Contact Person  </b></td>
				<td align="center"> : </td>
				<td><?php echo $contact_person; ?></td>
			</tr>
			<tr> 
				<td><b> Address1  </b></td>
				<td align="center"> : </td>
				<td><?php echo $address1; ?></td>
			</tr>
			<tr> 
				<td><b> Address2  </b></td>
				<td align="center"> : </td>
				<td><?php echo $address2; ?></td>
			</tr>
			<tr> 
				<td><b> Address2  </b></td>
				<td align="center"> : </td>
				<td><?php echo $address2; ?></td>
			</tr>
			<tr> 
				<td><b> Country  </b></td>
				<td align="center"> : </td>
				<td><?php echo $country; ?></td>
			</tr>
			<tr> 
				<td><b> Province  </b></td>
				<td align="center"> : </td>
				<td><?php echo $province; ?></td>
			</tr>
			<tr> 
				<td><b> City  </b></td>
				<td align="center"> : </td>
				<td><?php echo $city; ?></td>
			</tr>
			<tr> 
				<td><b> Zip  </b></td>
				<td align="center"> : </td>
				<td><?php echo $zip; ?></td>
			</tr>
			<tr> 
				<td><b> Phone  </b></td>
				<td align="center"> : </td>
				<td><?php echo $phone; ?></td>
			</tr>
			<tr> 
				<td><b> Status  </b></td>
				<td align="center"> : </td>
				<td><?php echo $status; ?></td>
			</tr>
			<tr> 
				<td><b> Is Deleted  </b></td>
				<td align="center"> : </td>
				<td><?php echo $is_deleted; ?></td>
			</tr>
			<tr> 
				<td><b> Created At  </b></td>
				<td align="center"> : </td>
				<td><?php echo $created_at; ?></td>
			</tr>
		</table>
		<br>
	</div>

	<!--<table class="table table-striped table-bordered  table-bordered table-dark">
		<tr><td>Headers :</td></tr>
		<tr><td><textarea name="peoplevox_request_header" style="width:100%;" rows="3"><?php //echo $headers; ?></textarea></td></tr>
		
		<tr><td>Body :</td></tr>
		<tr><td><textarea name="peoplevox_request_attachment" style="width:100%;" rows="3"><?php //echo $body; ?></textarea></td></tr>
	</table>
	-->
</div>