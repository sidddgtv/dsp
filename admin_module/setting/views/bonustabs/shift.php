<div class="row required mt-4">
	<div class="d-flex align-items-center justify-content-between mb-2">
	    <div class="100w- ">
	    </div>
	    <div class="100w- text-end">
	        
	        <a href="javascript:void(0)" data-toggle="tooltip" title="Add" class="btn btn-success btn-sm" id="add_routetypes" onclick="addeditmodal('<?php echo admin_url('setting/addbonustype/') ?>', 'Working Shift')"><i class="las la-plus-circle"></i> Add </a>
	    </div>
	</div>
	<hr>
	<div class="table-responsive">
	    <table id="working_shift" class="table" width="100%">
	        <thead>
	            <tr class="fw-bold">
	                <td>#</td>

	                <td>Name</td>

	                <td>Date</td>
	                <td>Status</td>
	                <td>Action</td>
	            </tr>
	        </thead>
	        <tbody>
	            <?php if(!empty($working_shift)){
	            	foreach ($working_shift as $key => $shift) {
	            		?>
	            		<tr class="">
			                <td class="sorting_1"><?= $key + 1 ?></td>
			                <td><?php echo $shift->name; ?></td>
			            	
			                <td><?php echo date('M d, Y', strtotime($shift->added_on)) ?></td>
			                <td><?php if($shift->is_active){echo  '<span class="text-success"><i class="las la-dot-circle"></i> Activated</span>';}else{ echo '<span class="text-danger"><i class="las la-dot-circle"></i> Deactivated</span>';}?></td>
			                <td>
			                	<div class="btn-group btn-group-sm pull-right">
									<a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="addeditmodal('<?php echo admin_url('setting/addbonustype/'.$shift->id) ?>', 'Working Shift')"><i class="la la-edit"></i></a>
									<a class="btn-sm btn btn-danger btn-remove" href="<?php echo admin_url('setting/deleteworkingshift/'.$shift->id) ?>" onclick="return confirm('Are you sure you want to delete ?') ? true : false;"><i class="las la-trash"></i></a>
								</div>
							</td>
			            </tr>
	            		<?php
	            	}


	            } ?>
	        </tbody>
	    </table>
	</div>
</div>
