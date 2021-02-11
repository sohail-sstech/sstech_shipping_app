<?php
	$All_ProcessQueueDetails=$All_ProcessQueueDetails[0];

	if($All_ProcessQueueDetails['type']==1){
		$type = !empty($All_ProcessQueueDetails['type'])? 'Create Order Webhook' : '';
	}
	$shop_domain  = !empty($All_ProcessQueueDetails['shop_domain']) ? $All_ProcessQueueDetails['shop_domain'] : null;
	$headers  = !empty($All_ProcessQueueDetails['headers']) ? $All_ProcessQueueDetails['headers'] : null;
	$body  = !empty($All_ProcessQueueDetails['body']) ? $All_ProcessQueueDetails['body'] : null;
		
	if($All_ProcessQueueDetails['status']==0){
		//$status = !empty($All_ProcessQueueDetails['status'])? "<span class='role user'>Pending</span>" : "";
		$All_ProcessQueueDetails['status'] = "<span class='role user'>Pending</span>";
	}
	else if($All_ProcessQueueDetails['status']==1){
		//$status = !empty($All_ProcessQueueDetails['status'])? "<span class='role member'>Completed</span>" : '';
		$All_ProcessQueueDetails['status']="<span class='role member'>Completed</span>";
	}
	else if($All_ProcessQueueDetails['status']==2){
		//$status = !empty($All_ProcessQueueDetails['status'])? "<span class='role admin'>Failed</span>" : '';
		$All_ProcessQueueDetails['status']="<span class='role admin'>Failed</span>";
	}
	
	if($All_ProcessQueueDetails['is_deleted']==1){
		$is_deleted = "<span class='status--process'>Yes</span>";
	}
	else{
		$is_deleted = "<span class='status--denied'>No</span>";
	}
	$created_at  = !empty($All_ProcessQueueDetails['created_at']) ? date('F d Y  h:i A',strtotime($All_ProcessQueueDetails['created_at'])) : "";
?>
<div class="col-md-12">
	<div class="col-md-12">
		<table class="table">  
			<tr> 
				<td><b> Type  </b></td>
				<td align="center"> : </td>
				<td><?php echo $type; ?></td>
			</tr>
			<tr> 
				<td><b> Shop Domain  </b></td>
				<td align="center"> : </td>
				<td><?php echo $shop_domain; ?></td>
			</tr>
			<tr> 
				<td><b> Status  </b></td>
				<td align="center"> : </td>
				<td><?php echo $All_ProcessQueueDetails['status']; ?></td>
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

	<table class="table table-striped table-bordered  table-bordered table-dark">
		<tr><td>Headers :</td></tr>
		<tr><td><textarea name="peoplevox_request_header" style="width:100%;" rows="3"><?php echo $headers; ?></textarea></td></tr>
		
		<tr><td>Body :</td></tr>
		<tr><td><textarea name="peoplevox_request_attachment" style="width:100%;" rows="3"><?php echo $body; ?></textarea></td></tr>
	</table>
	
</div>