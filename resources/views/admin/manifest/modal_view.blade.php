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
	$is_deleted  = !empty($All_ManifestDetails['is_deleted']) ? $All_ManifestDetails['is_deleted'] : null;
	$created_at = !empty($All_ManifestDetails['created_at']) ? $All_ManifestDetails['created_at'] : null;
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
				<td><b> Manifest No  </b></td>
				<td align="center"> : </td>
				<td><?php echo $manifest_no; ?></td>
			</tr>
			<tr> 
				<td><b> Manifest File  </b></td>
				<td align="center"> : </td>
				<td><?php echo $manifest_file; ?></td>
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
</div>