<div class="row g-1">
<h6 class="mb-0 col"><strong><?php echo $heading_title; ?></strong></h6>
<div class="col-auto my-auto fw-bold">Show</div>
<div class="col-2 px-1">

	<select class="form-select form-select-sm form-control" id="driver_status_active_state" name="driver_status_active_state" onchange="showdriversasperstatus(this.value)">	
		<option value="1" <?php echo ($search_status == 1 ? 'selected' : ''); ?>>Active Drivers</option>
		<option value="2" <?php echo ($search_status == 2 ? 'selected' : ''); ?>>Deactive Drivers</option>
		<option value="3" <?php echo ($search_status == 3 ? 'selected' : ''); ?>>All Drivers</option>
	</select>
	
	
</div>
<div class="col-auto">
	<a href="<?php echo admin_url('users/tempdrivers'); ?>" data-toggle="tooltip" title="Add" class="btn btn-outline-success btn-sm"><i class="las la-plus-circle"></i> Drivers not Imported</a>
    <a href="<?php echo $add; ?>" data-toggle="tooltip" title="Add" class="btn btn-success btn-sm"><i class="las la-plus-circle"></i> Add Drivers</a>
</div>
</div>
<hr>

<div class="table-responsive">
<table id="datatable" class="table" width="100%">
	<thead>
		<tr>
			<th width="50px">#</th>
			<th>Name</th>
			<th>Email</th>
			<th class="no-sort">Daily Sheet</th>
			<th class="no-sort">Gas Pin</th>
			<th width="120px" class="no-sort">Status</th>
			<th width="100px" class="no-sort">Action</th>
		</tr>
	</thead>
</table>
</div>


<?php js_start(); ?>
<script type="text/javascript">
$(function(){
	/*$('.dropdown_filter').each( function () {
        var title = $(this).text();
        $(this).html( '<select style="height:28px;"><option value="">All</option><option value="Activated">Activated</option><option value="Not Activated">Not Activated</option></select>' );
    } );*/

	$('#datatable').DataTable({
		"processing": true,
		"serverSide": true,
		"pageLength": 100,
		"columnDefs": [
			{ targets: 'no-sort', orderable: false }
		],
		"order": [[1, 'asc']], // Sort by the second column in ascending order
		"ajax":{
			url :"<?=$datatable_url?>", // json datasource
			type: "post",  // method  , by default get
			error: function(){  // error handling
				$(".datatable-error").html("");
				$("#datatable").append('<tbody class="datatable-error"><tr><th colspan="6">No data found.</th></tr></tbody>');
				$("#datatable_processing").css("display","none");
				
			},
			dataType:'json'
		},
	});
});

function showdriversasperstatus(val){
	//alert(val);
	// Redirect to a particular URL
	window.location.href = "<?php echo admin_url('users/drivers'); ?>/"+val;
}

function showgasmodal(driver_id){
	$.ajax({
		url: "<?php echo admin_url('users/showgasmodalcontents'); ?>",
		type: "POST",
		data:{"driver_id": driver_id},
		success: function (response){
			$('#gas_card_output').html(response);
			$('#gasModal').modal('show');
		},
		error: function () {
			alert("Error in calling Gas Modal");
		}
	});
}

function updategaspin(driver_id){
	$.ajax({
		url: "<?php echo admin_url('users/updategaspin'); ?>",
		type: "POST",
		data:{"driver_id": driver_id, "gas_pin": $('#gas_pin').val()},
		success: function (response){
			$('#gasModal').modal('hide');
		},
		error: function () {
			alert("Error in updating Gas Modal");
		}
	});
}
</script>
<?php js_end(); ?>