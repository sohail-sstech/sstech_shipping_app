<?php

	$All_LabelDetails=$All_LabelDetails[0];
	
	$storename  = !empty($All_LabelDetails['storename']) ? $All_LabelDetails['storename'] : null;
	$shopify_order_id  = !empty($All_LabelDetails['shopify_order_id']) ? $All_LabelDetails['shopify_order_id'] : null;
	$shopify_order_no  = !empty($All_LabelDetails['shopify_order_no']) ? $All_LabelDetails['shopify_order_no'] : null;
	$consignment_no  = !empty($All_LabelDetails['consignment_no']) ? $All_LabelDetails['consignment_no'] : null;
	$carrier_name  = !empty($All_LabelDetails['carrier_name']) ? $All_LabelDetails['carrier_name'] : null;
	
	if($All_LabelDetails['is_manifested']==1){
		$All_LabelDetails['is_manifested']="<span class='status--process'>Yes</span>";
	}
	else{
		$All_LabelDetails['is_manifested']="<span class='status--denied'>No</span>";
	}
	$is_manifested  = !empty($All_LabelDetails['is_manifested']) ? $All_LabelDetails['is_manifested'] : null;
	
	if($All_LabelDetails['status']==1){
		$All_LabelDetails['status']="<span class='status--process'>Active</span>";
	}
	else{
		$All_LabelDetails['status']="<span class='status--denied'>Deactive</span>";
	}
	$status  = !empty($All_LabelDetails['status']) ? $All_LabelDetails['status'] : null;
	$created_at  = !empty($All_LabelDetails['created_at']) ? $All_LabelDetails['created_at'] : null;
	
	if($All_LabelDetails['is_deleted']==1){
		$All_LabelDetails['is_deleted']="<span class='status--process'>Yes</span>";
	}
	else{
		$All_LabelDetails['is_deleted']="<span class='status--denied'>No</span>";
	}
	$is_deleted  = !empty($All_LabelDetails['is_deleted']) ? $All_LabelDetails['is_deleted'] : null;
?>
<div class="col-md-12">
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
				<td><b> Is Manifested  </b></td>
				<td align="center"> : </td>
				<td><?php echo $is_manifested; ?></td>
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
				<td><?php echo date('F d Y  h:i A',strtotime($created_at)); ?></td>
			</tr>
		</table>
		<br>
	</div>
</div>