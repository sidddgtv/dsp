<?php echo Modules::run('common/header/index'); ?>
	
	<div class="content-page">
		
			<?php if(isset($error)){?>
				<div class="alert alert-danger alert-dismissable errormsg">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="fa fa-exclamation-circle"></i> <?php echo $error; ?>
				</div>
			<?}else if($this->session->flashdata('message')){?>
				<div class="alert alert-info alert-dismissable flashmsg">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<i class="fa fa-exclamation-circle"></i> <?php echo $this->session->flashdata('message'); ?>
				</div>
			<?}?>		
<div class="innerbanner"></div>
		<div class="container top-btm-space-sm">
			<div class="row profile">
				<?php echo Modules::run('subscribers/sidebar'); ?>
				<div class="col-md-9">
					<div class="panel panel-default">
						<?php if(isset($heading_title)){?>
							<div class="panel-heading"><?=$heading_title?></div>
						<?}?>
						<div class="panel-body profile-content">
							<?php echo $template['body']; ?>
						</div>
					</div>
					
				</div>
			</div>
		</div>		
	</div>
<?php echo Modules::run('common/footer/index'); ?>
