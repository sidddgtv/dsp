<div class="row required mt-4">
	<div class="d-flex align-items-center justify-content-between mb-2">
	    <div class="100w- ">
	    </div>
	    <div class="100w- text-end">
	        
	        <a href="javascript:void(0)" data-toggle="tooltip" title="Add" class="btn btn-success btn-sm" id="add_routetypes" onclick="addeditmodal('<?php echo admin_url('setting/addbonustype/') ?>', 'Point Rule')"><i class="las la-plus-circle"></i> Add </a>
	    </div>
	</div>
	<hr>
	<div class="table-responsive">
	    <table id="point_rule" class="table" width="100%">
	        <thead>
	            <tr class="fw-bold">
	                <td>#</td>

	                <td>Name</td>
					<td>Type</td>
					<td>Value</td>
	                <td>Date</td>
	                <td>On/Off</td>
	                <td>Action</td>
	            </tr>
	        </thead>
	        <tbody>
	            <?php if(!empty($point_rule)){
	            	foreach ($point_rule as $key => $rule) {
	            		?>
	            		<tr class="">
			                <td class="sorting_1"><?= $key + 1 ?></td>
			                <td><?php echo $rule->name; ?></td>
			            	<td><?php echo $rule->type; ?></td>
			            	<td><?php echo $rule->value; ?></td>
			                <td><?php echo date('M d, Y', strtotime($rule->added_on)) ?></td>
			                <td><?php if($rule->on_off){echo  '<span class="text-success"><i class="las la-dot-circle"></i> On</span>';}else{ echo '<span class="text-danger"><i class="las la-dot-circle"></i> Off</span>';}?></td>
			                <td>
			                	<div class="btn-group btn-group-sm pull-right">
									<a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="addeditmodal('<?php echo admin_url('setting/addbonustype/'.$rule->id) ?>', 'Point Rule')"><i class="la la-edit"></i></a>
									<a class="btn-sm btn btn-danger btn-remove" href="<?php echo admin_url('setting/deletePointRuleType/'.$rule->id) ?>" onclick="return confirm('Are you sure you want to delete ?') ? true : false;"><i class="las la-trash"></i></a>
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
