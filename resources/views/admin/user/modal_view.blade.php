<?php

	$user_name = !empty($All_UsersDetails['name']) ? $All_UsersDetails['name'] : null;
	$user_email = !empty($All_UsersDetails['email']) ? $All_UsersDetails['email'] : null;
	$user_address1 = !empty($All_UsersDetails['address1']) ? $All_UsersDetails['address1'] : null;
	$user_address2 = !empty($All_UsersDetails['address2']) ? $All_UsersDetails['address2'] : null;
	$user_country = !empty($All_UsersDetails['country']) ? $All_UsersDetails['country'] : null;
	$user_state = !empty($All_UsersDetails['state']) ? $All_UsersDetails['state'] : null;
	$user_city = !empty($All_UsersDetails['city']) ? $All_UsersDetails['city'] : null;
	$user_pincode = !empty($All_UsersDetails['pincode']) ? $All_UsersDetails['pincode'] : null;
	$user_phone = !empty($All_UsersDetails['phone']) ? $All_UsersDetails['phone'] : null;
	$user_mobile = !empty($All_UsersDetails['mobile']) ? $All_UsersDetails['mobile'] : null;
	$created_at  = !empty($All_UsersDetails['created_at']) ? date('F d Y  h:i A',strtotime($All_UsersDetails['created_at'])) : "";
	
	if($All_UsersDetails['role_id']==1)
	{
			$rolename_cls = "admin";
	}
	else if($All_UsersDetails['role_id']==2)
	{
			$rolename_cls = "member";
	}
	$rolename = "<span class='role $rolename_cls'>".$All_UsersDetails['rolename']."</span>";
	
	if($All_UsersDetails['status']==1){
		$status = "<span class='status--process'>Yes</span>";
	}
	else{
		$status = "<span class='status--denied'>No</span>";
	}
	
?>
<div class="col-md-12">
	<div class="col-md-12">
		<table class="table">  
			<tr> 
				<td><b> User Name  </b></td>
				<td align="center"> : </td>
				<td><?php echo $user_name; ?></td>
			</tr>
			<tr> 
				<td><b> User Email  </b></td>
				<td align="center"> : </td>
				<td><?php echo $user_email; ?></td>
			</tr>
			<tr> 
				<td><b> User Role  </b></td>
				<td align="center"> : </td>
				<td><?php echo $rolename; ?></td>
			</tr>
			<tr> 
				<td><b> User Address1  </b></td>
				<td align="center"> : </td>
				<td><?php echo $user_address1; ?></td>
			</tr>
			<tr> 
				<td><b> User Address2  </b></td>
				<td align="center"> : </td>
				<td><?php echo $user_address2; ?></td>
			</tr>
			<tr> 
				<td><b> Country  </b></td>
				<td align="center"> : </td>
				<td><?php echo $user_country; ?></td>
			</tr>
			<tr> 
				<td><b> State  </b></td>
				<td align="center"> : </td>
				<td><?php echo $user_state; ?></td>
			</tr>
			<tr> 
				<td><b> City  </b></td>
				<td align="center"> : </td>
				<td><?php echo $user_city; ?></td>
			</tr>
			<tr> 
				<td><b> Pincode  </b></td>
				<td align="center"> : </td>
				<td><?php echo $user_pincode; ?></td>
			</tr>
			<tr> 
				<td><b> Phone  </b></td>
				<td align="center"> : </td>
				<td><?php echo $user_phone; ?></td>
			</tr>
			<tr> 
				<td><b> Mobile  </b></td>
				<td align="center"> : </td>
				<td><?php echo $user_mobile; ?></td>
			</tr>
			<tr> 
				<td><b> Status  </b></td>
				<td align="center"> : </td>
				<td><?php echo $status; ?></td>
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