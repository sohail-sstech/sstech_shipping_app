$(function() {
	if($('.apply_select2').length > 0) {
		$('.apply_select2').select2();
	}
});

/*Role master DataTable*/
$(function(){
/*Role Edit form jQuery Validation*/
$('#roleedit_form').validate({ 
    rules: {
        role_name: {
			required: true,
		},
		role_description: {
			required: true,
		}
    }
});	
/*User Insert form jQuery Validation*/
$('#userinsert_form').validate({
    rules: {
        user_name: {
			required: true,
		},
		user_email: {
			required: true,
		},
		user_role: {
			required: true,
		},
		user_password: {
			required: true,
		},
		user_confirmpwd: {
			required: true,
			equalTo : "#user_password",
		},
		user_country: {
			required: true,
		},
		user_state: {
			required: true,
		},
		user_city: {
			required: true,
		},
		user_mobile: {
			required: true,
		},
		user_company: {
			required: true,
		},
		user_address1: {
			required: true,
		},
		user_address2: {
			required: true,
		},
		user_pincode: {
			required: true,
		},
		user_phone: {
			required: true,
		}
    },
	messages:{
		user_confirmpwd : "The user confirm password and user password must match.",
	}
});
/*User Edit form jQuery Validation*/
$('#useredit_form').validate({
    rules: {
        user_name: {
			required: true,
		},
		user_email: {
			required: true,
		},
		user_role: {
			required: true,
		},
		user_country: {
			required: true,
		},
		user_state: {
			required: true,
		},
		user_city: {
			required: true,
		},
		user_mobile: {
			required: true,
		},
		user_company: {
			required: true,
		},
		user_address1: {
			required: true,
		},
		user_address2: {
			required: true,
		},
		user_pincode: {
			required: true,
		},
		user_phone: {
			required: true,
		}
    }
});

/*Update Profile jQuery Validation*/
$('#updateprofileform').validate({
		rules: {
            profile_name: {
				required: true,
			},
        }
});

/*Change Password Form jQuery Validation*/
$('#changepassword_form').validate({ 
		errorPlacement: function(error, element) {
            $(".common_error").css('display', 'block');
            $(".common_error").html('This field is required.');
        },
		rules: {
            current_password: {
				required: true,
			},
		
			new_password: {
				required: true,
			},
			new_confirm_password: {
				required: true,
			},
        }
    });

/*Settings Form jQuery Validation*/
$('#settings_form').validate({ 
		rules: {
            store_name: {
				required: true,
			},
		
			accesstoken: {
				required: true,
			},
			recevieremail: {
				required: true,
			},
			Name: {
				required: true,
			},
			contactperson: {
				required: true,
			},
			fromaddress1: {
				required: true,
			},
			countryname: {
				required: true,
			},
			province: {
				required: true,
			},
			city: {
				required: true,
			},
			zipcode: {
				required: true,
			},
			phone: {
				required: true,
			}
        }
    });
});

/*dynamic function for delete data*/
function delete_data(deleteid,url,table)
{
	if(confirm("Are you sure want to delete ?"))
		{
          $.ajax({
              type: "get",
              //url: SITEURL + "admin/country/delete/"+product_id,
			  url: url+deleteid,
              success: function (data) {
				  if(data.success==1)
				  {
						$("#custommsg").html('<div class="alert alert-success" id="success">You have successfully deleted data.</div>');
						  //$(window).scrollTop(0); 
						  $("html, body").animate({ scrollTop: 0 }, 1000);
						  setTimeout(function(){ 
								$(".alert-success").fadeTo(5000, 500).slideUp(500, function()
								{
										$(".alert-success").slideUp(500);		
										$("#custommsg").html('');
								});	
						  }, 500);
							
				  }
				  else{
					  $("#custommsg").html('<div class="alert alert-success" id="success">Something went wrong while deleted data.</div>');
					  $("html, body").animate({ scrollTop: 0 }, 1000);
					   setTimeout(function(){ 
								$(".alert-danger").fadeTo(5000, 500).slideUp(500, function()
								{
									$(".alert-danger").slideUp(500);
									$("#custommsg").html('');									
								});	
						  }, 500);
				  }
              //var oTable = $('#usergrid_dt').dataTable(); 
              var oTable = $('#'+table).dataTable(); 
				oTable.fnDraw(false);
              }
          });
        }
}
/*User master DataTable*/
$(function(){
$("#success").hide();
$('#rolegrid_dt').DataTable({
		serverSide:true,
		processing: true,
		"paging":true,
		"bFilter": false,
		"columnDefs": [
           {className: "dt-body-center", "targets": [4]}
        ],
		"ajax": {
			"url": "/admin/role/get_rolelist",
			type: "POST",
			serverSide:true,
			"processing": true,
			"data": function(d) {
			}
		}
});
$.fn.dataTable.ext.errMode = 'none';
$("#success").hide();
$('#usergrid_dt').DataTable({
		serverSide:true,
		processing: true,
		"paging":true,
		"bFilter": false,
		/*"columnDefs": [
          {className: "dt-body-center", "targets": [5]}
        ],*/
		"ajax": {
			"url": "/admin/user/get_userlist",
			type: "POST",
			serverSide:true,
			"processing": true,
			"data": function(d) {
				d.user_name = $('#user_name').val();
			}
		}
});
$.fn.dataTable.ext.errMode = 'none';
$('#storegrid_dt').DataTable({
		serverSide:true,
		processing: true,
		"paging":true,
		"bFilter": false,
		"ajax": {
			"url": "/admin/store/get_storelist",
			type: "POST",
			serverSide:true,
			"processing": true,
			"data": function(d) {
				d.store_name = $('#store_name').val();
				d.startdate = $('#startdate').val();
				d.enddate = $('#enddate').val();
			}
		}
});

$('#apiloggrid_dt').DataTable({
		serverSide:true,
		processing: true,
		"bFilter": false,
		"responsive": true,
		'columnDefs': [ {
			'targets': [0,1], /* column index */
			'orderable': true, /* true or false */
		}],
		"ajax": {
			"url": "/admin/apilog/get_apiloglist",
			type: "POST",
			serverSide:true,			
			"processing": true,
			"data": function(d) {
				d.search_data = $('#search_data').val();
				d.startdate = $('#startdate').val();
				d.enddate = $('#enddate').val();
				d.request_type = $('#request_type option:selected').val();
				d.response_code = $('#response_code option:selected').val();
				d.store = $('#store option:selected').val();
			}
		}
		
		 
		
			
		
});

/*label details js goes here*/
$('#lbldetailsgrid_dt').DataTable({
		serverSide:true,
		processing: true,
		"paging":true,
		"bFilter": false,
		"ajax": {
			"url": "/admin/label/get_labellist",
			type: "POST",
			serverSide:true,
			"processing": true,
			"data": function(d) {
				d.search_data = $('#search_data').val();
				d.startdate = $('#startdate').val();
				d.enddate = $('#enddate').val();
				d.store = $('#store option:selected').val();
				d.is_manifest = $('#is_manifest option:selected').val();
			}
		}
});

/*label details js goes here*/
$('#manifestgrid_dt').DataTable({
		serverSide:true,
		processing: true,
		"paging":true,
		"bFilter": false,
		"ajax": {
			"url": "/admin/manifest/get_manifestlist",
			type: "POST",
			serverSide:true,
			"processing": true,
			"data": function(d) {
				d.search_data = $('#search_data').val();
				d.startdate = $('#startdate').val();
				d.enddate = $('#enddate').val();
				d.store = $('#store option:selected').val();
			}
		}
});

/*process queue details js goes here*/
$('#processqueuegrid_dt').DataTable({
		"columnDefs": [
          {className: "dt-body-center", "targets": [3]}
        ],
		serverSide:true,
		processing: true,
		"paging":true,
		"bFilter": false,
		"ajax": {
			"url": "/admin/processqueue/get_processqueuelist",
			type: "POST",
			serverSide:true,
			"processing": true,
			"data": function(d) {
				d.search_data = $('#search_data').val();
				d.startdate = $('#startdate').val();
				d.enddate = $('#enddate').val();
				d.store = $('#store option:selected').val();
				d.processqueue_status = $('#processqueue_status option:selected').val();
				d.processqueue_type = $('#processqueue_type option:selected').val();
			}
		}
});


/*settings details js goes here*/
$('#settingsgrid_dt').DataTable({
		serverSide:true,
		processing: true,
		"paging":true,
		"bFilter": false,
		"ajax": {
			"url": "/admin/settings/get_settingslist",
			type: "POST",
			serverSide:true,
			"processing": true,
			"data": function(d) {
				d.search_data = $('#search_data').val();
				d.startdate = $('#startdate').val();
				d.enddate = $('#enddate').val();
				d.store = $('#store option:selected').val();
				d.isfromaddress = $('#isfromaddress option:selected').val();
				
			}
		}
});

});

/*for modal popup common function */
function get_row_detail(id,url)
{
		$.ajax({
		 type: "GET",
		 url: url+id,
		 success: function(res){
			var data = $.parseJSON(res)
			$("#common_modalbody").html(data.details); 
			$('#common_scrollmodal').modal('show');
			$("#common_popup_title").html(data.title);
		}
	});
}

function reload_table(table)
{
	$('#'+table).DataTable().ajax.reload(function() {});
}

$(document).ready(function()
{
	$('form').attr('autocomplete','off');
	 var editradiobutton_values = $("input[name='fromaddress']:checked").val();
	 if(editradiobutton_values==1){
		 $('.customformaddressfields').css('display','block');
		 $('.customformaddressfields').find("input[type=text],input[type=number],textarea,select").attr('required', 'required');
	 }
	else{
		$('.customformaddressfields').find("input[type=text],input[type=number],textarea,select").removeAttr('required');
	} 
	
	slideupslidedown_event();
});

$(function(){
$('#radioButtonsdiv').on('change', 'input[name=fromaddress]:radio', function (e) {
$('form').attr('autocomplete','off');	
var radioscurrent_values = $(this).val();
	if(radioscurrent_values==1){
		$('.customformaddressfields').css('display','block');
		//$('.customformaddressfields').find("input[type=text],input[type=number],textarea,select").attr('required', 'required');
	}
	else{
		$('.customformaddressfields').css('display','none');
		$('.customformaddressfields').find("input[type=text],input[type=number],textarea,select").val("");
		//$('.customformaddressfields').find("input[type=text],input[type=number],textarea,select").removeAttr('required');
	}
});	
});

function slideupslidedown_event()
{
	$(".alert-success").fadeTo(5000, 500).slideUp(500, function()
	{
		$(".alert-success").slideUp(500);		
	});	

	$(".alert-danger").fadeTo(5000, 500).slideUp(500, function()
	{
		$(".alert-danger").slideUp(500);		
	});
}
$(function(){
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