<div class="d-flex align-items-center justify-content-between">
<h6 class="mb-0"><strong>Schedule</strong></h6>
<div class="fw-bold">
<a class="text-dark" href="#"><i class="las la-chevron-circle-left la-2x" style="vertical-align: bottom;"></i></a>
<span class="ms-2 me-3 fs-6">Week 38</span><a class="text-dark" href="#"><i class="las la-chevron-circle-right la-2x" style="vertical-align: bottom;"></i></a>
</div>
<div class="pull-right">
	<!--<a href="http://localhost/diggity/admin/users" class="btn btn-primary position-relative">
		New Leave Requests
		<span class="position-absolute top-0 start-100 translate-middle bg-danger border border-light rounded-circle" style="padding:6px">
			<span class="visually-hidden">New alerts</span>
		</span>
	</a>-->
</div>
</div>

<hr>

<div class="row">
<div class="col-auto my-auto">SEARCH/ FILTER</div>
<div class="col"><input type="text" class="form-control" placeholder="Employee Name" /></div>
<div class="col"><select class="form-select"><option>No. of Absence</option></select></div>
<div class="col"><select class="form-select"><option>Performance</option></select></div>
</div>

<hr/>

<div class="table-responsive">
<table id="datatable" class="table" width="100%">
<thead>
<tr class="fw-bold"><td>#</td><td>NAME</td><td>17-Sep</td><td>18-Sep</td><td>19-Sep</td><td>20-Sep</td><td>21-Sep</td><td>22-Sep</td><td>23-Sep</td><td>Days</td><td>From WK#36</td><td>Action</td></tr>
</thead>
<tbody>
<tr><td>1</td><td>Shawniki Lynette Taylor</td><td>1</td><td>1</td><td></td><td>1</td><td>1</td><td>1</td><td>1</td><td>5</td><td>
	
<div class="progress">
 <div class="progress-bar progress-bar-striped bg-danger" style="width: 100%">POOR</div>
</div>

</td><td class="text-center"><div class="btn-group btn-group-sm pull-right"><a class="btn btn-outline-dark" href="<?php  echo admin_url('schedule/add'); ?>"><i class="las la-eye"></i></a><a class="btn btn-outline-dark" href="#"><i class="las la-comment"></i></a><a href="#" class="btn btn-outline-dark"><i class="las la-paper-plane"></i></a></div></td></tr>
<tr><td>2</td><td>Anthony Michael Reed</td><td></td><td>1</td><td></td><td></td><td>1</td><td>1</td><td></td><td>4</td><td>

<div class="progress">
 <div class="progress-bar progress-bar-striped bg-warning" style="width: 100%">FAIR</div>
</div>
</td><td class="text-center"><div class="btn-group btn-group-sm pull-right"><a class="btn btn-outline-dark" href="<?php  echo admin_url('schedule/add'); ?>"><i class="las la-eye"></i></a><a class="btn btn-outline-dark" href="#"><i class="las la-comment"></i></a><a href="#" class="btn btn-outline-dark"><i class="las la-paper-plane"></i></a></div></td></tr>
<tr><td>3</td><td>Marco Antonio Serna</td><td></td><td>1</td><td>1</td><td></td><td>1</td><td>1</td><td>1</td><td>5</td><td>
	
<div class="progress">
 <div class="progress-bar progress-bar-striped bg-success" style="width: 100%">GREAT</div>
</div>
</td><td class="text-center"><div class="btn-group btn-group-sm pull-right"><a class="btn btn-outline-dark" href="<?php  echo admin_url('schedule/add'); ?>"><i class="las la-eye"></i></a><a class="btn btn-outline-dark" href="#"><i class="las la-comment"></i></a><a href="#" class="btn btn-outline-dark"><i class="las la-paper-plane"></i></a></div></td></tr>
<tr><td>4</td><td>Nicholas Ryan Hogue</td><td></td><td>1</td><td></td><td>1</td><td>1</td><td>1</td><td></td><td>5</td><td>
	
<div class="progress">
 <div class="progress-bar progress-bar-striped bg-danger" style="width: 100%">POOR</div>
</div>
</td><td class="text-center"><div class="btn-group btn-group-sm pull-right"><a class="btn btn-outline-dark" href="<?php  echo admin_url('schedule/add'); ?>"><i class="las la-eye"></i></a><a class="btn btn-outline-dark" href="#"><i class="las la-comment"></i></a><a href="#" class="btn btn-outline-dark"><i class="las la-paper-plane"></i></a></div></td></tr>
<tr><td>5</td><td>Andrew David Renteria</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td>5</td><td>
	
<div class="progress">
 <div class="progress-bar progress-bar-striped bg-warning" style="width: 100%">FAIR</div>
</div>
</td><td class="text-center"><div class="btn-group btn-group-sm pull-right"><a class="btn btn-outline-dark" href="<?php  echo admin_url('schedule/add'); ?>"><i class="las la-eye"></i></a><a class="btn btn-outline-dark" href="#"><i class="las la-comment"></i></a><a href="#" class="btn btn-outline-dark"><i class="las la-paper-plane"></i></a></div></td></tr>
</tbody>
</table>
</div>




<?php js_start(); ?>
<script type="text/javascript"><!--
$(function(){
	$('#datatable').DataTable();
});
//--></script>
<?php js_end(); ?>