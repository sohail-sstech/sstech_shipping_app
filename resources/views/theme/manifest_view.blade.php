@extends('layouts.master')
@section('content')
<div class="container-fluid">            
    <!--<div class="row">
        <div class="col-lg-12">
            <div class="au-card">
                <div class="card-header">
                    <strong>Setting Insert Form</strong> 
                </div>
            </div>
        </div>
    </div>-->
	<div class="row">
		<!--<div class="col-lg-12">
            <div class="au-card">
                <div class="card-header">
                    <strong>Manifest View</strong> 
                </div>
            </div>
        </div>-->
            <div class="col-lg-12 top-campaign">
				
                <!-- MANIFEST DATA-->
                <!--<div class="user-data m-b-30">-->
				
                    <h3 class="card-header bg-dark">
                        <strong class="card-title text-light">Manifest Details</strong>
					</h3>
					<form method="post" name="manifestfilterform" id="manifestfilterform">
					 <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
						<div class="card-body card-block">
							<div class="row form-group filters">
								<div class="col-md-4">
											<label for="manifestsearch" class="control-label col-md-6" style="padding-left:0px;">Search </label>
											<input id="manifestsearch" class="form-control pull-right" placeholder="Consignment" name="manifestsearch" value="" type="text">
                                </div>
							</div>
							<div class="row form-group filters">
                                        <div class="col-md-4">
                                           <label for="startdate" class="control-label col-md-6" style="padding-left:0px;">Start Date  <span aria-required="true" class="required"></span></label>
											<div class="input-group date">
												<div class="input-group-addon">
													<i class="fa fa-calendar"></i>
												</div>
													<input id="startdate" class="form-control pull-right" name="startdate"  value="{{!empty($start_date) ? $start_date : ''}}" type="text">
											</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="enddate" class="control-label col-md-6" style="padding-left:0px;">End Date  <span aria-required="true" class="required"></span></label>
											<div class="input-group date ">
													<div class="input-group-addon">
															<i class="fa fa-calendar"></i>
													</div>
															<input id="enddate" class="form-control pull-right"  name="enddate" value="{{!empty($end_date) ? $end_date : ''}}" type="text">
											</div>
                                        </div>
										<div class="col-md-4">
											  <label for="enddate" class="control-label col-md-12" style="text-align:center!important;padding-left:0px;">&nbsp;  <span aria-required="true" class="required"></span></label>
                                                
                                                    <button name="cr_search" id="cr_search" style="" type="button" onclick="reload_table('mainmanifest_details')" class="btn btn-primary col-md-6"><i class="fa fa-dot-circle-o"></i> Search</button>
													
												<!--<label for="enddate" class="control-label col-md-12" style="text-align:center!important;padding-left:0px;"></label>
													<button type="submit" class="btn btn-primary btn-sm">
														<i class="fa fa-dot-circle-o"></i> Search
													</button>	-->
										 </div>
                             </div>
						</div>
					</form>
					
                    <div class="top-campaign table-responsive table--no-card m-b-30">
                        <!--<table id="mainmanifest_details" class="table table-bordered table-hover table table-borderless table-striped table-earning" width="100%" cellspacing="0">-->
                        <table id="mainmanifest_details" class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="7%" style="vertical-align: text-top;">
									   <!--<input class="au-checkbox" type="checkbox" name="select_chkbox" id="select_chkbox"  /><span class="au-checkmark">  All</span>-->
                                        <label class="au-checkbox">
                                            <input type="checkbox" name="select_chkbox" id="select_chkbox"/>
                                            <span class="au-checkmark"></span>
                                        </label>
										
                                    </th>
                                    <th>Consignment Number</th>
                                    <th>Carrier</th>
                                    <th>Insert Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
					<div class="col-md-12" id="msgmanifest" style="display:none;"></div>
					<div class="col-md-12" id="msgmanifest_er" style="display:none;"></div>
                    <div class="user-data__footer">
                        <!--<button class="au-btn au-btn-load">REPRINT</button>-->
						<button class="au-btn au-btn-load" onclick="Manifest_consignment()">SEND MANIFEST</button>
                        <button class="au-btn au-btn-load" onclick="Delete_consignment()">DELETE</button>
                    </div>
					
					
                <!--</div>-->
                <!-- END Manifest DATA-->
            </div>
            <div class="col-lg-12">
                <!-- TOP recent manifest-->
                <div class="top-campaign">
                    <h3 class="card-header bg-dark"><strong class="card-title text-light">Recent Manifest Details</strong></h3>
                    <div class="top-campaign table-responsive table--no-card m-b-30">
                        <table id="recentmanifest_details" class="table table-bordered table-hover" width="100%" cellspacing="0">
						 <thead>
                                <tr>
                                    <th style="text-align:center;">MANIFEST NUMBER</th>
                                    <th style="text-align:center;">GENERATED DATE</th>
                                </tr>
                            </thead>
                           
                        </table>
                    </div>
                </div>
                <!--  END TOP recent manifest-->
            </div>
    </div>
</div>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style>
#manifest_processing {
   background: url("{{secure_asset('images/ring-alt.gif')}}") 	no-repeat scroll 0 0; !important;
   height: 100%;
   margin: 0 auto;
   z-index: 1000;
}
#recentmanifest_details tr td {text-align:center;}
</style>
<script>

function reload_table(table){
	$('#'+table).DataTable().ajax.reload();
}

$(function(){
	
	
$('#mainmanifest_details').DataTable({
		serverSide:true,
		processing: true,
		"bFilter": false,
	"ajax": {
		"url": "{{secure_asset('/get_manifestdata')}}",
		type: "POST",
		serverSide:true,
		"processing": true,
		"data": function(d) {
			d.search_key = $('input[name="manifestsearch"]').val();
			d.startdate = $('#startdate').val();
			d.enddate = $('#enddate').val();
		}
	}
});
$.fn.dataTable.ext.errMode = 'none';
	/*manifest main grid load data table*/
	/*$('#mainmanifest_details').dataTable({	
		"processing": true,
		"serverSide": false,
		// "responsive": true,
		//"dom": 'lBfrtip',
		
		"ajax": "{{secure_asset('/get_manifestdata')}}",
		"columns": 
		[
			{ "data": "customcheckbox"},
			{ "data": "consignment_no"},
			{ "data": "carrier_name"},
			{ "data": "created_at"}
		]
		
	});*/

$(document).ready(function(){
	//load_manifest_table();
});

$('#manifestfilterform #cr_search').click(function() { 
	//load_manifest_table();
});	
/*function load_manifest_table() {	
	
	$('#mainmanifest_details11').dataTable({
         
           //dom: 'lBfrtip',
            responsive: true,
            buttons: [{
                exportOptions: {
                    modifier: {
                        bFilter: false,
                    }
                }
            }],
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ secure_asset("/filterdata") }}',
                type: "POST",
                data: function(d) {
                    //d.retailer_id = $('#retailer_name').val();
                    //d.subretailer_id = $('#SubRetailer').val();
                    //d.Carrier = $('#Carrier').val();
                   // d.Dport = $('#Dport').val();
                   // d.hub_id = $('#hub_name').val();
                    d.startdate = $('#startdate').val();
                    d.enddate = $('#enddate').val();
                }
            },
			"columns": 
			[
				{ "data": "customcheckbox"},
				{ "data": "consignment_no"},
				{ "data": "carrier_name"},
				{ "data": "created_at"}
			]
            
        });
}*/
	
	
	/*manifest recent grid load data table*/
	$('#recentmanifest_details').dataTable({	
		"processing": true,
		"serverSide": false,
		//"dom": 'lBfrtip',
		 "order": [
					[ 0, 'desc' ], 
					[ 1, 'desc' ]
				  ],
		"ajax": "{{secure_asset('/recentmanifest')}}",
		"columns": 
		[
			{ "data": "manifestlink"},
			{ "data": "created_at"}
		]
	});
	//$.fn.dataTable.ext.errMode = 'none';
			
		
	/*Date Picker*/	
	if ($('#startdate').val()) {
        var startdate = $('#startdate').val();
    } else { //var startdate = new Date(); 
        var date = new Date();
        //var last = new Date(date.getTime() - (7 * 24 * 60 * 60 * 1000));
        //var startdate = last.getDate() + '-' + (last.getMonth() + 1) + '-' + last.getFullYear();
		var startdate = date;
    }

    if ($('#enddate').val()) {
        var enddate = $('#enddate').val();
    } else {
        var enddate = new Date();
    }

    $('#startdate').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'DD-MM-YYYY'
        },
        startDate: startdate,
        maxDate: new Date()
    }).on('apply.daterangepicker', function(ev, picker) {
        /*if ($('#enddate').length > 0) {
            $('#enddate').daterangepicker({
                singleDatePicker: true,
                minDate: $('#startdate').val(),
                startDate: $('#startdate').val(),
                locale: {
                    format: 'DD-MM-YYYY'
                },
                maxDate: new Date()
            });
        }*/
    });
    $('#enddate').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'DD-MM-YYYY'
        },
        startDate: enddate,
        maxDate: new Date()
    });
			


/*All checkbox checked and unchecked*/
$("#select_chkbox").change(function() {
    if(this.checked) {
			$('#mainmanifest_details tbody  input[type="checkbox"]').each(function(){
			$(this).prop('checked', true);
		});
}else{
			$('#mainmanifest_details tbody  input[type="checkbox"]').each(function(){
			$(this).prop('checked', false);
		});
		}
});			

});

/* function for getting checked connote details to Manifest consignment API request */
function Manifest_consignment() {
    var connote=[""];
    var count = 0;
    var hubsel = "";
    var retailersel = "";
    $("#mainmanifest_details tbody  input[type='checkbox']:checked").each(function(index, element) {
        //connote[index] = $(this).attr("data-ConsignmentNo"); Before Consignment Number was inserted now return Id will be inserted. 19-Jan-2018
        connote[count] = $(this).attr("data-consignmentno");
        Token = $(this).attr("data-accesstoken");
        count++;
    });
    $.ajax({
        type: "POST",
        data: {
        	connote_list: connote,
            token:Token,
        },
        //url: baseurl + "reprint_manifest/manifest_consignment",
        url: '{{ secure_asset("/sendmanifest") }}',
		beforeSend: function(msg) {
            $("#manifest_processing").show();
        },
        success: function(data) {
        	var data_json=JSON.parse(data);
        	//console.log(data_json);
        	if (typeof data_json.ManifestedConnotes !== 'undefined') {
		        	var msg='<div class="alert alert-success" role="alert"><strong>Manifest [ ';
		        	//alert(msg);
		        	len=Object.keys(data_json.ManifestedConnotes).length;
		        	i=1;
		        	//alert(len);
		        	$.each(data_json.ManifestedConnotes, function( key, value ) {
		        		 //alert( key + ": " + value );
		        		if(i<len){msg = msg+' '+key+ ',';}
		        		else{msg = msg+' '+key;}
		        		//while($i<=$len){$msg=$msg+' '+key+ ',';}
		        		i++;
		        		});
		        	msg+= ' ] generated and sent.</strong></div>';
		        	//alert(msg);
	        	 	$("#msgmanifest").html(msg);
	            	$("#msgmanifest").show();
	                if ($.fn.DataTable.isDataTable('#mainmanifest_details')) {
	            	        $('#mainmanifest_details').DataTable().ajax.reload(function() {});
	            	    }
	                if ($.fn.DataTable.isDataTable('#recentmanifest_details')) {
            	        $('#recentmanifest_details').DataTable().ajax.reload(function() {});
            	    }
        	}
        	if (typeof data_json.UnManifestedConnotes !== 'undefined' && data_json.UnManifestedConnotes!='') {
        		var msg1='<div class="alert alert-danger" role="alert"><strong>';
	        	$.each(data_json.UnManifestedConnotes, function( key, value ) {
	        		 	msg1 = msg1+' '+value+' ';
	        		});
	        	msg1+= '</strong></div>';
	        	//alert(msg);
        	 	$("#msgmanifest_er").html(msg1);
            	$("#msgmanifest_er").show();
            	if ($.fn.DataTable.isDataTable('#mainmanifest_details')) {
        	        $('#mainmanifest_details').DataTable().ajax.reload(function() {});
        	    }
            	if ($.fn.DataTable.isDataTable('#recentmanifest_details')) {
        	        $('#recentmanifest_details').DataTable().ajax.reload(function() {});
        	    }
        	}
        	if ((typeof data_json.ManifestedConnotes == 'undefined') && ((typeof data_json.UnManifestedConnotes == 'undefined') || (data_json.UnManifestedConnotes=='')))
        	{
        		$("#msgmanifest_er").html('<div class="alert alert-danger" role="alert"><strong>No Record Found</strong></div>');
            	$("#msgmanifest_er").show();
        	}
			$("#manifest_processing").hide();
			slideupslidedown_event();
        }
    });
}

/* function for getting checked connote details to delete consignment API request */
function Delete_consignment() {
    var connote=[""];
    var count = 0;
    var hubsel = "";
    var retailersel = "";
    $("#mainmanifest_details tbody  input[type='checkbox']:checked").each(function(index, element) {
        //connote[index] = $(this).attr("data-ConsignmentNo"); Before Consignment Number was inserted now return Id will be inserted. 19-Jan-2018
        connote[count] = $(this).attr("data-consignmentno");
        Token = $(this).attr("data-accesstoken");
        count++;
    	});
    $.ajax({
        type: "POST",
        data: {
        	connote_list: connote,
            token:Token,
        },
        //url: baseurl + "reprint_manifest/delete_consignment",
        url: '{{ secure_asset("/deleteconsignment") }}',
        success: function(data) {
        	var data_json=JSON.parse(data);
        	//console.log(data_json);
        	var msg='<div class="alert alert-success" role="alert"><strong>';
        	$.each(data_json, function( key, value ) {
					//alert( key + ": " + value );
					msg = msg + ' ' + key +': '+ value+'<br>';
        		});
        	msg+='</strong></div>';
        	//alert(msg);
    	 	$("#msgmanifest").html(msg);
        	$("#msgmanifest").show();
        	if ($.fn.DataTable.isDataTable('#mainmanifest_details')) {
     	        $('#mainmanifest_details').DataTable().ajax.reload(function() {});
     	    }
			slideupslidedown_event();
        }
    });
}

/*trigger function slide up and slide down*/
function slideupslidedown_event(){
	$(".alert-success").fadeTo(5000, 500).slideUp(500, function()
	{
		$(".alert-success").slideUp(500);		
	});	

	$(".alert-danger").fadeTo(5000, 500).slideUp(500, function()
	{
		$(".alert-danger").slideUp(500);		
	});
}
</script>
