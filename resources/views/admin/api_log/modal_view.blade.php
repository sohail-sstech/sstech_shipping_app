<?php

	$All_ApiDetails=$All_ApiDetails[0];
	
	$api_url  = !empty($All_ApiDetails['api_url']) ? $All_ApiDetails['api_url'] : null;
	$created_at  = !empty($All_ApiDetails['created_at']) ? $All_ApiDetails['created_at'] : null;
	$request_type  = !empty($All_ApiDetails['request_type']) ? $All_ApiDetails['request_type'] : null;
	$response_code  = !empty($All_ApiDetails['response_code']) ? $All_ApiDetails['response_code'] : null;
	$request_headers  = !empty($All_ApiDetails['request_headers']) ? $All_ApiDetails['request_headers'] : null;
	$request  = !empty($All_ApiDetails['request']) ? $All_ApiDetails['request'] : null;
	$response_headers  = !empty($All_ApiDetails['response_headers']) ? $All_ApiDetails['response_headers'] : null;
	$response  = !empty($All_ApiDetails['response']) ? $All_ApiDetails['response'] : null;
?>
<div class="col-md-12">
	<div class="col-md-12">
		<table class="table">  
			<tr> 
				<td><b> URL  </b></td>
				<td align="center"> : </td>
				<td><?php echo $api_url; ?></td>
			</tr>
			<tr> 
				<td><b> Time  </b></td>
				<td align="center"> : </td>
				<td><?php echo $created_at; ?></td>
			</tr>
			<tr> 
				<td><b> Type  </b></td>
				<td align="center"> : </td>
				<td><?php echo $request_type; ?></td>
			</tr>
			<tr> 
				<td><b> Status  </b></td>
				<td align="center"> : </td>
				<td><?php echo $response_code; ?></td>
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