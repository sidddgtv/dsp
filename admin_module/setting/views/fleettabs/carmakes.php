<div class="row required mt-4">
	<div class="d-flex align-items-center justify-content-between mb-2">
	    <div class="100w- ">
	    </div>
	    <div class="100w- text-end">
	        
	        <a href="javascript:void(0)" data-toggle="tooltip" title="Add" class="btn btn-success btn-sm" id="add_routetypes" onclick="addeditmodal('<?php echo admin_url('setting/addfleettype/') ?>', 'Car Make')"><i class="las la-plus-circle"></i> Add </a>
	    </div>
	</div>
	<hr>
	<div class="table-responsive">
	    <table id="carmakes" class="table" width="100%">
	        <thead>
	            <tr class="fw-bold">
	                <td>#</td>

	                <td>Makes</td>

	                <td>Date</td>
	                <td>Status</td>
	                <td>Action</td>
	            </tr>
	        </thead>
	        <tbody>
	            <?php if(!empty($car_makes)){
	            	foreach ($car_makes as $key => $car_make) {
	            		?>
	            		<tr class="">
			                <td class="sorting_1"><?= $key + 1 ?></td>
			                <td><?php echo $car_make['name']; ?></td>
			            	
			                <td><?php echo date('M d, Y', strtotime($car_make['added_on'])) ?></td>
			                <td><?php if($car_make['is_active']){echo  '<span class="text-success"><i class="las la-dot-circle"></i> Activated</span>';}else{ echo '<span class="text-danger"><i class="las la-dot-circle"></i> Deactivated</span>';}?></td>
			                <td>
			                	<div class="btn-group btn-group-sm pull-right">
									<a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="addeditmodal('<?php echo admin_url('setting/addfleettype/'.$car_make['id']) ?>', 'Car Make')"><i class="la la-edit"></i></a>
									<a class="btn-sm btn btn-danger btn-remove" href="<?php echo admin_url('setting/deletecarmakes/'.$car_make['id']) ?>" onclick="return confirm('Are you sure you want to delete ?') ? true : false;"><i class="las la-trash"></i></a>
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
