<?php
	$All_RolesDetails=$All_RolesDetails[0];

	
	$role_name  = !empty($All_RolesDetails['name']) ? $All_RolesDetails['name'] : "";
	$role_description  = !empty($All_RolesDetails['description']) ? $All_RolesDetails['description'] : "";
	if($All_RolesDetails['status']==1){
		$role_status  = "<span class='status--process'>Active</span>";
	}
	else{
		$role_status  = "<span class='status--process'>Deactive</span>";
	}
	$created_at  = !empty($All_RolesDetails['created_at']) ? date('F d Y  h:i A',strtotime($All_RolesDetails['created_at'])) : "";
	
?>
<div class="col-md-12">
	<div class="col-md-12">
		<table class="table">  
			<tr> 
				<td><b> Role Name  </b></td>
				<td align="center"> : </td>
				<td><?php echo $role_name; ?></td>
			</tr>
			<tr> 
				<td><b> Role Description  </b></td>
				<td align="center"> : </td>
				<td><?php echo $role_description; ?></td>
			</tr>
			<tr> 
				<td><b> Role Status  </b></td>
				<td align="center"> : </td>
				<td><?php echo $role_status; ?></td>
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