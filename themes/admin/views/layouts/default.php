<?php echo Modules::run('common/header/index');?>

<?php if ($this->user->isLogged()): ?>
	<!--
	ERRORS SECTION HERE

	<div class="alert alert-info text-white alert-dismissible fade show" role="alert">
		<strong>Holy guacamole!</strong> You should check in on some of those fields below.
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="las la-times"></i></button>
	</div>
	-->
	<?php if(isset($error)){?>
		<div class="alert alert-danger text-white alert-dismissible fade show" role="alert">
			<i class="fa fa-exclamation-circle"></i>&nbsp;<?php echo $error; ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="las la-times"></i></button>
		</div>
	<?}else if(validation_errors()){?>
		<div class="alert alert-danger text-white alert-dismissible fade show" role="alert">
			<i class="fa fa-exclamation-circle"></i>&nbsp;<?php echo validation_errors(); ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="las la-times"></i></button>
		</div>
	<?}else if($this->session->flashdata('message')){?>
		<div class="alert alert-info text-white alert-dismissible fade show" role="alert">
			<i class="fa fa-exclamation-circle"></i>&nbsp;<?php echo $this->session->flashdata('message'); ?>
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="las la-times"></i></button>
		</div>
	<?}?>


	


<?endif; ?>

<?php echo $template['body']; ?>


		<?php /*if ($this->user->isLogged()): ?>
		<!--<div class="row">
			<div class="col-sm-12">
				<h2 class="pull-left page-title"><?php echo isset($heading_title)?$heading_title:""; ?></h2>			
			</div>
		</div>-->
		<?php if(isset($error)){?>
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<i class="fa fa-exclamation-circle"></i> <?php echo $error; ?>
			</div>
		<?}else if(validation_errors()){?>
			<div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<i class="fa fa-exclamation-circle"></i> <?php echo validation_errors(); ?>
			</div>
		<?}else if($this->session->flashdata('message')){?>
			<div class="alert alert-info alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<i class="fa fa-exclamation-circle"></i> <?php echo $this->session->flashdata('message'); ?>
			</div>
		<?}?>
		<?endif;*/ ?>
					
           
<?php echo Modules::run('common/footer/index'); ?>
