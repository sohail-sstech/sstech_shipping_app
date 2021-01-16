@extends('admin.layouts.master')
@section('content')
<section class="p-t-20">
                <div class="container">
                    <div class="row">
				        <div class="col-md-12">
							<div id="custommsg"></div>
							@if(session()->has('message'))
								<div class="alert alert-success">
									{{ session()->get('message') }}
								</div>
							@endif
						    <div class="row">
							  <div class="col-md-10">
								<h3 class="title-5 m-b-35">Country Details</h3>
							  </div>
							  <div class="col-md-2">
								<!--<button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                            <i class="zmdi zmdi-plus"></i>add item</button>-->
									<a href="{{asset('/admin/country/insert_form')}}" class="au-btn au-btn-icon au-btn--green au-btn--small">
                                           <i class="zmdi zmdi-plus"></i> add item
                                    </a>		
								  <!--<a href="{{asset('/admin/country/insert_form')}}" class="btn btn-primary btn-bg">
                                            <i class="fa fa-dot-circle-o"></i> Insert Form
                                  </a>-->
							  </div>
							</div>
                            <!--<div class="table-data__tool">
                                <div class="table-data__tool-left">
                                    <div class="rs-select2--light rs-select2--md">
                                        <select class="js-select2" name="property">
                                            <option selected="selected">All Properties</option>
                                            <option value="">Option 1</option>
                                            <option value="">Option 2</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                    <div class="rs-select2--light rs-select2--sm">
                                        <select class="js-select2" name="time">
                                            <option selected="selected">Today</option>
                                            <option value="">3 Days</option>
                                            <option value="">1 Week</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                    <button class="au-btn-filter">
                                        <i class="zmdi zmdi-filter-list"></i>filters</button>
                                </div>
                                <div class="table-data__tool-right">
                                    <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                        <i class="zmdi zmdi-plus"></i>add item</button>
                                    <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                                        <select class="js-select2" name="type">
                                            <option selected="selected">Export</option>
                                            <option value="">Option 1</option>
                                            <option value="">Option 2</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>-->
                            <div class="table-responsive table-responsive-data2">
                                <table class="table table-data2" id="countrygrid_dt">
                                    <thead>
                                        <tr>
                                            <!--<th>
                                                <label class="au-checkbox">
                                                    <input type="checkbox">
                                                    <span class="au-checkmark"></span>
                                                </label>
                                            </th>-->
                                            <th class="card-header">Name</th>
                                            <th class="card-header">ISO</th>
                                            <th class="card-header">PhoneCode</th>
                                            <th class="card-header">NumCode</th>
                                            <th class="card-header">Status</th>
                                            <th class="card-header">Is Deleted</th>
                                            <th class="card-header">CreatedAt</th>
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

<style>
<!--#manifest_processing {
   background: url("{{secure_asset('images/ring-alt.gif')}}") 	no-repeat scroll 0 0; !important;
   height: 100%;
   margin: 0 auto;
   z-index: 1000;
}
#recentmanifest_details tr td {text-align:center;}-->
</style>


<script>

function reload_table(table){
	$('#'+table).DataTable().ajax.reload();
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
			/*d.search_key = $('input[name="manifestsearch"]').val();
			d.startdate = $('#startdate').val();
			d.enddate = $('#enddate').val();*/
		}
	}
});
$.fn.dataTable.ext.errMode = 'none';

//$('body').on('click', '#delete-product', function () 
//{
//$('#country_modal').click(function(){

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
              /*error: function (data) {
                  //console.log('Error:', data);
              }*/
          });
        }
}); 		
	/*Date Picker*/	
/*	if ($('#startdate').val()) {
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
    });*/
			


/*All checkbox checked and unchecked*/
/*$("#select_chkbox").change(function() {
    if(this.checked) {
			$('#mainmanifest_details tbody  input[type="checkbox"]').each(function(){
			$(this).prop('checked', true);
		});
}else{
			$('#mainmanifest_details tbody  input[type="checkbox"]').each(function(){
			$(this).prop('checked', false);
		});
		}
});	*/		

});

$(document).ready(function(){
	$("#success").hide();
	//$('#countryModalpopup').modal('hide');
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
</script>