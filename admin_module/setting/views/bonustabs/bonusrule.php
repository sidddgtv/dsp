
<?php echo form_open_multipart(admin_url('setting/updatebonusrule'), 'id="form-bonus" class="form-horizontal"'); ?>
<div class="my-3 fs-5">Bonus Amount</div>
		<div class="row">

			<?php if(!empty($bonus_amount)){
	            	foreach ($bonus_amount as $key => $amount) {

	            		
	            		?>
					<label class="col-1 control-label" for="name"><?php echo $amount->name; ?></label>
					<div class="col">
						<input type="hidden" class="form-control" value="<?php echo $amount->name; ?>"  name="amount[<?=$amount->id?>][name]">
						<div class="input-group">
						<span class="input-group-text">$</span>

						<input type="number" class="form-control" value="<?php echo $amount->amount; ?>"  name="amount[<?=$amount->id?>][amount]" placeholder="<?php echo $amount->name; ?> Amount">
						</div>
					</div>
					
			<?php
	            	}


	            } ?>
		</div>
		<hr class="" />
		<div class="my-3 fs-5">Bonus Conditions</div>

		<?php 

		$condition_arr = array(
						'If Greater than (>)',
						'If Less than (<)',
						'If Equal than (=)' 
						);
		?>
		<table class="table">
		<thead>
		<tr>
			<th width="20%">Field</th>
			<th>Condition</th>
			<?php if(!empty($bonus_amount)){
	            	foreach ($bonus_amount as $key => $amount) {
	            		$bonus_key[] = $amount->id;
	            		?>
					<th>Threshold (<?php echo $amount->name; ?>)</th>			
			<?php
	            	}
	            } 
	        ?>
		</tr>
		</thead>
		<tbody>

		<?php 

		if(!empty($bonus_type)){
	            foreach ($bonus_type as $key => $type) {
	            	// echo '<pre>';print_r($type['name']);exit;
			        echo '
					<tr>
						<th>'.$type['name'].'</th>';
						$condition = $type['condition'];
						$condition = explode(', ', $condition);

					echo '
						<td><div class="dropdown">
								<button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Select Condition
								</button>
								<div class="dropdown-menu p-2" aria-labelledby="dropdownMenuButton">';
					foreach( $condition_arr as $key => $value){
						$checked = '';
						if(in_array(($key+1),$condition)){
							$checked = 'checked';
						}
						
						echo '<div class="form-check">
									<input class="form-check-input options cond-'.$type['id'].' option'.($key+1).'" type="checkbox" value="'.($key+1).'" id="option'.($key+1).'" name="type['.$type['id'].'][condition][]" '.$checked.'>
									<label class="form-check-label" for="option'.($key+1).'">'.$value.'
									</label>
								</div>';
					}
					
								echo '<!-- Add more checkbox items as needed -->
								</div>
							</div>
							<div class="d-none multiSel-div"></div>
							<input class="form-check-input options multiSel" type="hidden" value="" name="type['.$type['id'].'][option]">
						</td>';
					if(!empty($type['amount'])){
						// print_r(count($type['amount']));exit();

		            	foreach ($type['amount'] as $key => $amount){
		            		$keys[] = $key;
		            		echo '<td><input type="number" class="form-control form-control-sm" name="type['.$type['id'].'][amount]['.$key.']" placeholder="Threshold"  value="'.$amount['amount'].'" ></td>';
		            	}
		            	if(count($bonus_amount) != count($type['amount'])){
		            		$diff = count($bonus_amount) - count($type['amount']);
		            		
		            		$remainingbonus = array_diff($bonus_key, $keys);
		            		foreach ($remainingbonus as $remaining){
		            			echo '<td><input type="number" class="form-control form-control-sm" value="" name="type['.$type['id'].'][amount]['.$remaining.']" placeholder="Threshold"></td>';
		            		
		            		}
		            	}
					}  else if(!empty($bonus_amount)) {
		            	foreach ($bonus_amount as $key => $amt){
		            		echo '<td><input type="number" class="form-control form-control-sm" value="" name="type['.$type['id'].'][amount]['.$amt->id.']" placeholder="Threshold"></td>';
		            	}
					}
					echo '</tr>';
				}
			}
		?>
		
	</tbody>
</table>
<div class="row mt-4 submit-btn">
    <label class="col-2 control-label">&nbsp;</label>
    <div class="col-4">
        <button type="submit" form="form-bonus" data-toggle="tooltip" title="Save" class="btn btn-primary btn-sm">
            <i class="las la-save"></i> Save </button>
        <input type="hidden" id="user_edit_form" name="user_edit_form" value="1">
    </div>
</div>
<?php echo form_close(); ?>	