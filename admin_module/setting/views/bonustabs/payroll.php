
<?php echo form_open_multipart(admin_url('setting/updatepayrolltype'), 'id="form-payroll" class="form-horizontal"'); ?>
	<div class="row mt-4">
		<label class="col-2 control-label" for="name">Provider</label>
		<div class="col-10">
			<select class="form-select select2" name="tnt_payroll_provider" id="config_payroll">
				<option value="0">--  select --</option>
				 <?php if(!empty($payroll)){

		            	foreach ($payroll as $key => $roll) {
		            		$selected  = '';
		            		if($roll->is_selected == '1'){
		            			$selected  = 'selected';
		            		}
		            		echo '<option value="'.$roll->id.'" '.$selected.'>'.$roll->name.'</option>';

		            	}
		            }?>
				
			</select>
		</div>

	</div>
	 <div class="row mt-4 submit-btn">
        <label class="col-2 control-label">&nbsp;</label>
        <div class="col-4">
            <button type="submit" form="form-payroll" data-toggle="tooltip" title="Save" class="btn btn-primary btn-sm" >
                <i class="las la-save"></i> Save </button>
            <input type="hidden" id="user_edit_form" name="user_edit_form" value="1">
        </div>
    </div>
<?php echo form_close(); ?>		
		
		