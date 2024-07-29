<div class="d-flex h-100">
<div class="m-auto login-box">
	

<?php if ($logo) { ?>
		<img src="<?php echo $logo; ?>" title="<?php echo $site_name; ?>" alt="<?php echo $site_name; ?>"  />
		<?php } else { ?>
		<span><?php echo $site_name; ?></span>
		<?php } ?>
		
		<h6 class="mb-4 text-muted">A DSP's right hand</h6>
		
			<?php echo form_open(null,array('class' => 'form-horizontal m-t-10', 'id' => 'form-signin','role'=>'form')); ?>
			<?php if(isset($error)){?>
				<div class="alert alert-danger text-white mb-4 rounded-0 py-2" role="alert"><strong>Error!</strong> <?php echo $error; ?></div>
			<?}else if($this->session->flashdata('message')){?>
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="fa fa-exclamation-circle"></i> <?php echo $this->session->flashdata('message'); ?>
				</div>
			<?}?>

			<?php 
			if(array_key_exists('error', $_SESSION)){
				echo $_SESSION['error'];
				$_SESSION['error'] = '';
				unset($_SESSION['error']);
			}
			?>
			<div class="form-group">
				<!--<label for="input-username"><?php echo $entry_username; ?></label>    -->
				<div class="input-group">
					<span class="input-group-text px-2"><i class="las la-user"></i></span>
					<input type="text" name="username" id="input-username" class="form-control"  value="<?php echo $username; ?>" placeholder="<?php echo $entry_username; ?>" required="" autofocus="">
				</div>
			</div>

			<div class="form-group mt-2">
				<!--<label for="input-password"><?php echo $entry_password; ?></label>-->
				<div class="input-group">
					<span class="input-group-text px-2"><i class="las la-lock"></i></span>
					<input type="password" name="password" id="input-password" class="form-control" value="<?php echo $password; ?>" placeholder="<?php echo $entry_password; ?>" required="">
				</div> 
			</div>

			<!--<div class="form-group">
				<div class="col-xs-12">
					<div class="checkbox checkbox-primary">
						<input type="checkbox" value="<?=$rememberme?>" name="rememberme" id="checkbox-signup">  
						<label for="checkbox-signup">
						<?=$text_remember?>
						</label>
					</div>					 
				</div>
			</div>-->
			  
			
			<?php if ($redirect) { ?>
				<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
			<?php } ?>
			<div class="form-group mt-4">
				<button class="btn btn-danger w-100 text-uppercase" type="submit"><?=$button_login?></button>
			</div>
			<?php echo form_close(); ?>
		
</div>
</div>