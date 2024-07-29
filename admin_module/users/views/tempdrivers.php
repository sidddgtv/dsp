<div class="d-flex align-items-center justify-content-between">
<h6 class="mb-0"><strong><?php echo $heading_title; ?></strong></h6>
<div class="pull-right">
    <a href="<?php echo admin_url('users/add'); ?>" data-toggle="tooltip" title="Add" class="btn btn-success btn-sm"><i class="las la-plus-circle"></i> Add Driver</a>
</div>
</div>
<hr>

<div class="table-responsive">
<table id="datatable" class="table" width="100%">
	<thead>
		<tr>
			<th width="50px">#</th>
			<th>Name</th>
			<th>Date Created</th>
			<th width="250px" class="no-sort">Action</th>
		</tr>
	</thead>
	<?php echo $table_body; ?>
</table>
</div>


<?php js_start(); ?>
<script type="text/javascript">
$(function(){
	$('#datatable').DataTable({
		"pageLength": 50,
		"columnDefs": [
			{ targets: 'no-sort', orderable: false }
		]
	});
});
</script>
<?php js_end(); ?>