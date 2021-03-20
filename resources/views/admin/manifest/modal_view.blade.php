<?php

	$All_ManifestDetails=$All_ManifestDetails[0];
	
	$storename  = !empty($All_ManifestDetails['storename']) ? $All_ManifestDetails['storename'] : null;
	$manifest_no  = !empty($All_ManifestDetails['manifest_no']) ? $All_ManifestDetails['manifest_no'] : null;
	$manifest_url = url('/').'/uploads/manifest/'.$All_ManifestDetails['manifest_file'];
	$manifest_file = '<a href="'.$manifest_url.'" target="_blank">'.$All_ManifestDetails['manifest_no'].'</a>';
	if($All_ManifestDetails['status']==1)
	{
		$All_ManifestDetails['status'] = "<span class='status--process'>Active</span>";
	}
	else{
		$All_ManifestDetails['status'] = "<span class='status--denied'>Deactive</span>";
	}
	$status = !empty($All_ManifestDetails['status']) ? $All_ManifestDetails['status'] : null;
	
	if($All_ManifestDetails['is_deleted']==1){
		$All_ManifestDetails['is_deleted']="<span class='status--process'>Yes</span>";
	}
	else{
		$All_ManifestDetails['is_deleted']="<span class='status--denied'>No</span>";
	}
	$manifest_error  = !empty($All_ManifestDetails['manifest_error']) ? $All_ManifestDetails['manifest_error'] : null;
	$manifest_statuscode  = !empty($All_ManifestDetails['manifest_status_code']) ? $All_ManifestDetails['manifest_status_code'] : null;
	
	$unmanifested_consignment  = !empty($All_ManifestDetails['un_manifested_connotes']) ? json_decode($All_ManifestDetails['un_manifested_connotes']) : null;
	if(!empty($All_ManifestDetails['un_manifested_connotes'])){
		$unmanifest_decode = json_decode($All_ManifestDetails['un_manifested_connotes']);
		$unmanifest_impl = implode(',',$unmanifest_decode);
	}
	else{
		$unmanifest_decode='';
		$unmanifest_impl = 'null';
	}
	
	$created_at = !empty($All_ManifestDetails['created_at']) ? $All_ManifestDetails['created_at'] : null;
	
	/*Labels details*/
	//$shopify_order_id = !empty($All_ManifestDetails['shopify_order_id']) ? $All_ManifestDetails['shopify_order_id'] : null;
	//$shopify_order_no = !empty($All_ManifestDetails['shopify_order_no']) ? $All_ManifestDetails['shopify_order_no'] : null;
	//$consignment_no = !empty($All_ManifestDetails['consignment_no']) ? $All_ManifestDetails['consignment_no'] : null;
	//$carrier_name = !empty($All_ManifestDetails['carrier_name']) ? $All_ManifestDetails['carrier_name'] : null;
	//$service_name = !empty($All_ManifestDetails['service_name']) ? $All_ManifestDetails['service_name'] : null;
	
	/*if($All_ManifestDetails['is_manifested']==1)
	{
		$All_ManifestDetails['is_manifested'] = "<span class='status--process'>Yes</span>";
	}
	else{
		$All_ManifestDetails['is_manifested'] = "<span class='status--denied'>No</span>";
	}
	if($All_ManifestDetails['label_status']==1)
	{
		$All_ManifestDetails['label_status'] = "<span class='status--process'>Active</span>";
	}
	else{
		$All_ManifestDetails['label_status'] = "<span class='status--denied'>Deactive</span>";
	}*/
	
	
?>

<div class="col-md-12">
	<div class="col-md-12">
		<table class="test table table-striped table-bordered" width="100%">   
			<tr> 
				<th> Store Name  </th>
				<td align="center"> : </td>
				<td><?php echo $storename; ?></td>
			</tr>
			<tr> 
				<th> Manifest No  </th>
				<td align="center"> : </td>
				<td><?php echo $manifest_no; ?></td>
			</tr>
			<tr> 
				<th> Manifest File  </th>
				<td align="center"> : </td>
				<td><?php echo $manifest_file; ?></td>
			</tr>
			<tr> 
				<th> Manifest Error  </th>
				<td align="center"> : </td>
				<td><?php echo $manifest_error; ?></td>
			</tr>
			<tr> 
				<td><b> Manifest Status Code  </th>
				<td align="center"> : </td>
				<td><?php echo $manifest_statuscode; ?></td>
			</tr>
			<tr> 
				<th> UnManifestd Consignment  </th>
				<td align="center"> : </td>
				<td><?php echo $unmanifest_impl; ?></td>
			</tr>
			<tr> 
				<th> Status  </th>
				<td align="center"> : </td>
				<td><?php echo $status; ?></td>
			</tr>
			<tr> 
				<th> Created At  </th>
				<td align="center"> : </td>
				<td><?php echo date('F d Y  h:i A',strtotime($created_at)); ?></td>
			</tr>
		</table>
		<br>
	</div>
	<div class="col-md-12">
		<table class="table table-striped table-bordered" width="100%">  
			<tr>
				<h4 class="modal-title" style="padding-bottom:10px;">Label Details</h4>
			</tr>
			<tr>
				<th> Shopify Order Id  </th>
				<th> Shopify Order No  </th>
				<th> Consignment No  </th>
			</tr>
			<tbody>
			
			<?php
			if(!empty($MultiLabelConsignment_Details)){
			foreach($MultiLabelConsignment_Details as $val){ ?>
			<tr>
				<td><?php if(isset($val['shopify_order_id']))echo $val['shopify_order_id'];?> </td>
				<td><?php if(isset($val['shopify_order_no']))echo $val['shopify_order_no'];?> </td>
				<td><?php if(isset($val['consignment_no']))echo $val['consignment_no'];?> </td>
			</tr>	
			<?php } } else {?>
			 <tr> <td colspan="3" align="center"> No data available in table</td> </tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
