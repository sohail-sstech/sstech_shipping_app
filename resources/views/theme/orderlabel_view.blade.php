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
                    <strong>Order Label View</strong> 
                </div>
            </div>
        </div>-->
            <div class="col-lg-12">
				
                <!-- MANIFEST DATA-->
                <div class="user-data m-b-30">
				
                    <h3 class="card-header bg-dark">
                        <strong class="card-title text-light">Order Label Details </strong>
					</h3>
					<form method="post" name="manifestfilterform" id="manifestfilterform">
					 <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>">
						<div class="card-body card-block">
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
							</div>		
							<div class="row form-group filters">
										<div class="col-md-4">
											<label for="lbldtsearch" class="control-label col-md-6" style="padding-left:0px;">Search </label>
											<input id="lbldtsearch" class="form-control pull-right" placeholder="OrderNumber/Consignment" name="lbldtsearch" value="" type="text">
                                        </div>
										<div class="col-md-4">
                                            <label for="ismanifest" class="control-label col-md-6" style="padding-left:0px;">Is Manifest</label>
											<select name="ismanifest" id="ismanifest" class="form-control">
                                                        <option value="">Please select</option>
                                                        <option value="1">Yes</option>
                                                        <option value="0">No</option>
                                            </select>
                                        </div>
										<div class="col-md-4">
											  <label for="enddate" class="control-label col-md-12" style="text-align:center!important;padding-left:0px;">&nbsp;  <span aria-required="true" class="required"></span></label>
                                              <button name="cr_search" id="cr_search" style="" type="button" onclick="reload_table('orderlabel_details')" class="btn btn-primary col-md-6"><i class="fa fa-dot-circle-o"></i> Search</button>
										</div>
                             </div>
						</div>
					</form> 
					
                    <div class="top-campaign table-responsive table--no-card m-b-30">
                        <table id="orderlabel_details" class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Consignment Number</th>
                                    <th>Carrier</th>
                                    <th>Download Label</th>
									<th>Tracking</th>
									<th>Is Manifest</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</div>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--<link href="{{ secure_asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" media="all">-->

<script>

function reload_table(table){
	$('#'+table).DataTable().ajax.reload();
}

$(function(){
$('#orderlabel_details').DataTable({
		serverSide:true,
		processing: true,
		"bFilter": false,
	"ajax": {
		url: "{{secure_asset('/get_orderlabeldata')}}",
		type: "POST",
		serverSide:true,
		
		"processing": true,
		"data": function(d) {
			d.search_key = $('input[name="lbldtsearch"]').val();
			d.ismanifest = $('#ismanifest').val();
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
});

/*pdf label function*/
function get_pdf_label(labelid) {
	$.ajax({
		//url: base_url+"returns/get_pdf_label",
		url: "{{secure_asset('pdflabeldetails')}}",
		type: 'POST',
		data: { labelid : labelid, },
		success: function(data) {
			data_obj = $.parseJSON(data);
			if(data_obj.Success == '1') {
				download(data_obj.Filename, data_obj.Content);					
			} else {
				alert('Something went wrong while downloading a label!!!');
			}
		}
		/*complete: function(jqXHR, textStatus) {
			$('#'+loading_blk).hide();
		},*/
	});
}	
//download file
function download(filename, content) {
	/*var element = document.createElement('a');
	element.setAttribute('href', 'data:application/pdf;base64,' + encodeURIComponent(content));
	element.setAttribute('download', filename);
	element.style.display = 'none';
	document.body.appendChild(element);
	element.click();
	document.body.removeChild(element);*/
	
	var element = document.createElement('a');
	element.setAttribute('href', 'data:application/pdf;base64,' + encodeURIComponent(content));
	element.setAttribute('download', filename);
	//element.style.display = 'none';
	//document.body.appendChild(element);
	//window.open(element, '_blank');
	element.click();
	//document.body.removeChild(element);
	
	/*var a = document.createElement("a");
	a.href = "data:application/octet-stream;base64,"+encodeURIComponent(content);
	a.download = filename;
	a.style.display = 'none';
	document.body.appendChild("a");
	a.click();
	document.body.removeChild("a");*/
	

}
</script>
