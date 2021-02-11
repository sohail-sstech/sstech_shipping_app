<?php

	$All_ApiDetails=$All_ApiDetails[0];
	
	$api_url  = !empty($All_ApiDetails['api_url']) ? $All_ApiDetails['api_url'] : null;
	$created_at  = !empty($All_ApiDetails['created_at']) ? $All_ApiDetails['created_at'] : null;
	//echo '<pre>';print_r($All_ApiDetails);exit;
	$request_type  = !empty($All_ApiDetails['request_type']) ? $All_ApiDetails['request_type'] : null;
	if($request_type==1){
		$request_type  = '<span class="role member">Shipping Rate Request</span>';
	}
	else if($request_type==2){
		$request_type  = '<span class="role member">Available Rate Request</span>';
	}
	else if($request_type==3){
		$request_type  = '<span class="role member">Label Request</span>';
	}
	else if($request_type==4){
		$request_type  = '<span class="role member">Manifest Request</span>';
	}
	else if($request_type==5){
		$request_type  = '<span class="role member">Label Delete Request</span>';
	}
	$response_code  = !empty($All_ApiDetails['response_code']) ? $All_ApiDetails['response_code'] : null;
	//$status  = !empty($All_ApiDetails['status']) ? $All_ApiDetails['status'] : null;
	if($response_code=='Success'){
		$response_code  = '<span class="status--process">Success</span>';
	}
	else{
		$response_code  = '<span class="status--denied">Failed</span>';
	}
	$request_headers  = !empty($All_ApiDetails['request_headers']) ? $All_ApiDetails['request_headers'] : null;
	$request  = !empty($All_ApiDetails['request']) ? $All_ApiDetails['request'] : null;
	$response_headers  = !empty($All_ApiDetails['response_headers']) ? $All_ApiDetails['response_headers'] : null;
	$response  = !empty($All_ApiDetails['response']) ? $All_ApiDetails['response'] : null;
	$origin_ip  = !empty($All_ApiDetails['origin_ip']) ? $All_ApiDetails['origin_ip'] : null;
	$storename  = !empty($All_ApiDetails['storename']) ? $All_ApiDetails['storename'] : null;
	
?>
<div class="col-md-12">
	<div class="col-md-12">
		<table class="table">  
			<tr> 
				<td><b> Store Name  </b></td>
				<td align="center"> : </td>
				<td><?php echo $storename; ?></td>
			</tr>
			<tr> 
				<td><b> URL  </b></td>
				<td align="center"> : </td>
				<td><?php echo $api_url; ?></td>
			</tr>
			<tr> 
				<td><b> Request Type  </b></td>
				<td align="center"> : </td>
				<td><?php echo $request_type; ?></td>
			</tr>
			<tr> 
				<td><b> Status  </b></td>
				<td align="center"> : </td>
				<td><?php echo $response_code; ?></td>
			</tr>
			<tr> 
				<td><b> Origin Ip  </b></td>
				<td align="center"> : </td>
				<td><?php echo $origin_ip; ?></td>
			</tr>
			<tr> 
				<td><b> Time  </b></td>
				<td align="center"> : </td>
				<td><?php echo $created_at; ?></td>
			</tr>
		</table>
		<br>
	</div>

	<table class="table table-striped table-bordered  table-bordered table-dark">
		<tr><td>Request Headers :</td></tr>
		<tr><td><textarea name="peoplevox_request_header" style="width:100%;" rows="3"><?php echo $request_headers; ?></textarea></td></tr>
		
		<tr><td>Request Body :</td></tr>
		<tr><td><textarea name="peoplevox_request_attachment" style="width:100%;" rows="3"><?php echo $request; ?></textarea></td></tr>
		
		<tr><td>Response Headers :</td></tr>
		<tr><td><textarea name="peoplevox_request_header" style="width:100%;" rows="3"><?php echo $response_headers; ?></textarea></td></tr>
		
		<tr><td>Response Body :</td></tr>
		<tr><td><textarea name="peoplevox_request_attachment" style="width:100%;" rows="3"><?php echo $response; ?></textarea></td></tr>
	</table>
	<!--<div class="col-md-12">
		<h4><span style="font-weight:bold;">Request Headers :</span></h4>	
		<div style="width:98%;overflow:auto;background:rgb(245,245,245);width:100%;border:2px solid #cccccc;padding:5px;">
			<textarea name="peoplevox_request_header" style="width:100%;" rows="3"><?php echo $request_headers; ?></textarea>
		</div>
	</div>
	<div class="col-md-12">
		<h4><span style="font-weight:bold;">Request Body :</span></h4>	
		<div style="width:98%;overflow:auto;background:rgb(245,245,245);width:100%;border:2px solid #cccccc;padding:5px;">
			<textarea name="peoplevox_request_attachment" style="width:100%;" rows="3"><?php echo $request; ?></textarea>
		</div>
	</div>
	<div class="col-md-12">
		<h4><span style="font-weight:bold;">Response Headers :</span></h4>	
		<div style="width:98%;overflow:auto;background:rgb(245,245,245);width:100%;border:2px solid #cccccc;padding:5px;">
			<textarea name="peoplevox_request_header" style="width:100%;" rows="3"><?php echo $response_headers; ?></textarea>
		</div>
	</div>
	<div class="col-md-12">
		<h4><span style="font-weight:bold;">Response Body :</span></h4>	
		<div style="width:98%;overflow:auto;background:rgb(245,245,245);width:100%;border:2px solid #cccccc;padding:5px;">
			<textarea name="peoplevox_request_attachment" style="width:100%;" rows="3"><?php echo $response; ?></textarea>
		</div>
	</div> -->
	
</div>