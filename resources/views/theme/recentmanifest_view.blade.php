@extends('layouts.master')
@section('content')
<div class="container-fluid">            
	<div class="row">
            <div class="col-lg-12 top-campaign">
                    <h3 class="card-header bg-dark"><strong class="card-title text-light">Recent Manifests</strong></h3>
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
    </div>
</div>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style>
#recentmanifest_details tr td {text-align:center;}
</style>
<script>

function reload_table(table){
	$('#'+table).DataTable().ajax.reload();
}

$(function(){
	
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
