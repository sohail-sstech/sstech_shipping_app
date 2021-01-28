@extends('admin.layouts.master')
@section('content')
<section class="p-t-20">
                <div class="container">
                    <div class="row">
				        <div class="col-md-12 top-campaign">
							<div id="custommsg"></div>
							@if(session()->has('message'))
								<div class="alert alert-success">
									{{ session()->get('message') }}
								</div>
							@endif
						    <div class="row">
							  <div class="col-md-10">
								<h3 class="title-5 m-b-35">User Details</h3>
							  </div>
							  <div class="col-md-2">
								<!--<button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                            <i class="zmdi zmdi-plus"></i>add item</button>-->
									<a href="{{asset('/admin/user/insert_form')}}" class="au-btn au-btn-icon au-btn--green au-btn--small">
                                           <i class="zmdi zmdi-plus"></i> add item
                                    </a>		
								  <!--<a href="{{asset('/admin/country/insert_form')}}" class="btn btn-primary btn-bg">
                                            <i class="fa fa-dot-circle-o"></i> Insert Form
                                  </a>-->
							  </div>
							</div>
								
								<div class="card">
                                    <div class="card-header">
                                        <strong>Filter</strong> Form
                                    </div>
                                    <div class="card-body card-block">
                                        <form action="" name="Country_filter_data" method="post" class="" id="Country_filter_data" >
                                          <div class="row form-group">
												<div class="col-sm-3">
													<label for="user_name" class="col-sm-9 col-form-label">User Name</label>
													 <input type="text" class="form-control" id="user_name" autocomplete="new-user_name" name="user_name" placeholder="Plase Enter User Name.">
												</div>
												<div class="col-sm-3">
												
												<button type="button" onclick="reload_table('usergrid_dt')" class="col-sm-6 btn btn-success btn-bg" style="margin-top:40px;">
													<i class="fa fa-dot-circle-o"></i> Filter
												</button>
												</div>
											</div>	
                                        </form>
                                    </div>
                                    
                                </div>
								
                          
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2" id="usergrid_dt" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="card-header">Name</th>
                                            <th class="card-header">Email</th>
                                            <th class="card-header">Role</th>
                                            <th class="card-header">Status</th>
                                            <th class="card-header">Is Deleted</th>
                                            <th class="card-header">Created At</th>
                                            <th class="card-header">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

@endsection

			
<script src="{{ asset('js/jquery-3.5.1.js')}}"></script>
<!--<script src="https://code.jquery.com/jquery-3.5.1.js"></script>-->

<script>

function reload_table(table)
{
	//$('#'+table).DataTable().ajax.reload();
	$('#'+table).DataTable().ajax.reload(function() {});
}

$(function(){
	$("#success").hide();
$('#countrygrid_dt').DataTable({
		serverSide:true,
		processing: true,
		"paging":true,
		"bFilter": false,
	"ajax": {
		"url": "{{asset('/admin/get_countrylist')}}",
		type: "POST",
		serverSide:true,
		"processing": true,
		"data": function(d) {
			d.country_name = $('#country_name').val();
			/*d.search_key = $('input[name="manifestsearch"]').val();
			d.startdate = $('#startdate').val();
			d.enddate = $('#enddate').val();*/
		}
	}
});
$.fn.dataTable.ext.errMode = 'none';

 $('body').on('click', '#country_modal', function () {	
        var product_id = $(this).data("id");
        if(confirm("Are You sure want to delete !"))
		{
          $.ajax({
              type: "get",
              //url: SITEURL + "admin/country/delete/"+product_id,
			  url: "admin/country/delete/"+product_id,
              success: function (data) {
				  if(data.success==1)
				  {
						$("#custommsg").html('<div class="alert alert-success" id="success">Selected Country Data Deleted Succesfully.</div>');
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
					   setTimeout(function(){ 
								$(".alert-danger").fadeTo(5000, 500).slideUp(500, function()
								{
									$(".alert-danger").slideUp(500);
									$("#custommsg").html('');									
								});	
						  }, 500);
				  }
              var oTable = $('#countrygrid_dt').dataTable(); 
				oTable.fnDraw(false);
              }
          });
        }
}); 		
	
});

$(document).ready(function(){
	slideupslidedown_event();
});
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

/*$(function(){
$('#Country_filter_data').validate({ 
    rules: {
        country_name: {
			required: true,
		}
    }
});
});*/
</script>