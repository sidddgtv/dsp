
<?php echo form_open_multipart(admin_url('setting/updatepointrule'), 'id="form-points" class="form-horizontal"'); ?>
<?php 

	if(!empty($point_type)){
	    foreach ($point_type as $key => $type) {
	    	if(!empty($type['rules'])){
	    		?>
			
				<div class="my-3 fs-5"><?= $type['name']?> </div>
				<table class="table">
				<thead>
				<tr>
					<th width="25%"><label class=" control-label" for="site_owner"></label></th>
					<th style="width: 66% !important;"><label class=" control-label" for="site_owner">Points</label></th>
					<th ><label class=" d-flex justify-content-center mt-2 control-label" for="site_owner" >On/Off</label></th>
				</tr>
				</thead>
				<tbody>
					<?php 
						
						    foreach ($type['rules'] as $key => $rule) {?>
							<tr>
								<td ><label class=" control-label" for="site_owner"><?= $rule->name ?> </label></td>
								<td>
									<div class="">
										<input type="number" class="form-control" name="rules[<?= $rule->id ?>][val]" id="config_site_owner" value="<?= $rule->value ?>">
									</div>
								</td>
								<td class="d-flex justify-content-center " >	
									<div class=" form-check form-switch mt-2">
										<?php
											$checkedfield = '';
											if($rule->on_off ){
												$checkedfield = 'checked';
											}

										?>
										<input class="form-check-input" type="checkbox" name="rules[<?= $rule->id ?>][switch]" role="switch" id="flexSwitchCheckChecked" <?= $checkedfield ?>>
									</div>
								</td>
							</tr>

						<?php
		            	}
		            
		        ?>
		        </tbody>
			</table>
			
	<?php
			}
    	}
    } 
?>

	<div class="row mt-4 payroll-div">
			<label class="col-3 control-label" for="site_owner">Fall Off Period</label>
			<div class="col-9">
				<select name="tnt_falloff_period" class="form-select select2" id="tnt_falloff_period">
					<option value="">-- select --</option>
	                <?php if(!empty($fall_off)){
		            	foreach ($fall_off as $key => $off) {
		            		$selected  = '';

		            		if($off->is_selected == '1'){
		            			$selected  = 'selected';
		            		}
		            		echo '<option value="'.$off->id.'" '.$selected.'>'.$off->name.'</option>';

		            	}
		            }?>
	            </select>
			</div>
		</div>
	<hr>
	<div class="my-3 fs-5">Check In/Out Timings</div>
	<table class="table">
	<thead>
	<tr>
		<th width="25%"><label class=" control-label" for="site_owner">Shift</label></th>
		<th><label class=" control-label" for="site_owner">Check In Time</label></th>
		<th><label class=" control-label" for="site_owner">Check Out Time</label></th>
	</tr>
	</thead>
	<tbody>
		<?php 
				if(!empty($working_shift)){

				    foreach ($working_shift as $key => $shift) {?>
					<tr>
						<td ><label class=" control-label" for="site_owner"><?= $shift->name ?> </label></td>

						<?php
						 $check_in = '';
						 $check_out = '';
						 if(!empty($shift->in_time)){
						 	$check_in =  date('h:i:s', strtotime($shift->in_time));
						 }

						 if(!empty($shift->out_time)){
						 	$check_out =  date('h:i:s', strtotime($shift->out_time));
						 }
						?>
						<td><input type="time" class="form-control" name="shift[<?= $shift->id ?>][in_time]" id="config_site_owner" value="<?= $check_in ?>"></td>
						<td><input type="time" class="form-control" name="shift[<?= $shift->id ?>][out_time]" id="config_site_owner" value="<?= $check_out ?>"></td>
					</tr>

				<?php
            	}
            } 
        ?>
	</tbody>
</table>
 <div class="row mt-4 submit-btn">
        <label class="col-3 control-label">&nbsp;</label>
        <div class="col-9">
            <button type="submit" form="form-points" data-toggle="tooltip" title="Save" class="btn btn-primary btn-sm" style="margin-left: 15px;">
                <i class="las la-save"></i> Save </button>
            <input type="hidden" id="user_edit_form" name="user_edit_form" value="1">
        </div>
    </div>	

<?php echo form_close(); ?>		