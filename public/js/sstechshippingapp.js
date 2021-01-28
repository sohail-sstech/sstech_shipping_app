/*Role master DataTable*/
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
		}
    }
});

});

/*User master DataTable*/
$(function(){
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
});

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