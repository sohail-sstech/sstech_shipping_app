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

});

/*dynamic function for delete data*/
function delete_data(deleteid,url,table)
{
	if(confirm("Are You sure want to delete !"))
		{
          $.ajax({
              type: "get",
              //url: SITEURL + "admin/country/delete/"+product_id,
			  url: url+deleteid,
              success: function (data) {
				  if(data.success==1)
				  {
						$("#custommsg").html('<div class="alert alert-success" id="success">Selected Data Deleted Succesfully.</div>');
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
					  $("#custommsg").html('<div class="alert alert-success" id="success">Error Occured in Delete Data.</div>');
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
           {className: "dt-body-center", "targets": [5]}
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
		"columnDefs": [
          {className: "dt-body-center", "targets": [5]}
        ],
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
		}
	}
});

$('#apiloggrid_dt').DataTable({
		serverSide:true,
		processing: true,
		"paging":true,
		"bFilter": false,
	"ajax": {
		"url": "/admin/apilog/get_apiloglist",
		type: "POST",
		serverSide:true,
		"processing": true,
		"data": function(d) {
			d.search_data = $('#search_data').val();
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
			d.store = $('#store option:selected').val();
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
	slideupslidedown_event();
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