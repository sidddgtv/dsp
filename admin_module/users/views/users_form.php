<div class="d-flex align-items-center justify-content-between">
	<div class="fs-6 fw-bold">User Management</div>
	<div>
		<a href="<?php echo admin_url('users'); ?>" data-toggle="tooltip" title="Cancel" class="btn btn-danger btn-sm"><i class="fa fa-reply"></i></a>
	</div>
</div>
<hr/>

<ul class="nav nav-tabs" id="userTab" role="tablist"> 
	<li class="nav-item" role="presentation">
		<button class="nav-link <?php echo ($activeTab == 1 ? 'active' : ''); ?>" id="tab-general-btn" data-bs-toggle="tab" data-bs-target="#tab-edit" type="button" role="tab" aria-controls="edit" aria-selected="true">Edit User</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link <?php echo ($activeTab == 2 ? 'active' : ''); ?>" id="tab-site-button" data-bs-toggle="tab" data-bs-target="#tab-document" type="button" role="tab" aria-controls="document" aria-selected="false">Send Documents</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-pending-button" data-bs-toggle="tab" data-bs-target="#tab-status-pending" type="button" role="tab" aria-controls="status" aria-selected="false">Unfilled Document(s)</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link" id="tab-signed-button" data-bs-toggle="tab" data-bs-target="#tab-status-signed" type="button" role="tab" aria-controls="status" aria-selected="false">Filled Document(s)</button>
	</li>
</ul>


<div id="settingsTabContent" class="tab-content">
	<div class="tab-pane fade  <?php echo ($activeTab == 1 ? 'show active' : ''); ?>" id="tab-edit" role="tabpanel">
		<?php echo form_open_multipart(null, 'id="form-user" class="form-horizontal"'); ?>
		<div class="row mt-4 required">
			<label class="col-2 control-label" for="name">Name</label>
				<div class="col-10">
					<?php echo form_input(array('class'=>'form-control','name' => 'name', 'id' => 'name', 'placeholder'=>'Name','value' => set_value('name', $name))); ?>
					<?php echo form_error('name', '<div class="text-danger">', '</div>'); ?>
				</div>
		</div>
		<div class="row mt-2 required">
			<label class="col-2 control-label" for="email">Email ID</label>
				<div class="col-10">
					<?php echo form_input(array('type' => 'email', 'class'=>'form-control','name' => 'email', 'id' => 'email', 'placeholder'=>'Email ID','value' => set_value('email', $email))); ?>
					<?php echo form_error('email', '<div class="text-danger">', '</div>'); ?>
				</div>
		</div>
		<div class="row mt-2 required">
			<label class="col-2 control-label" for="password">Password</label>
				<div class="col-10">
					<?php echo form_input(array('class'=>'form-control','name' => 'password', 'id' => 'password', 'placeholder' => 'Password', 'value' => set_value('password', $password))); ?>
					<?php echo form_error('password', '<div class="text-danger">', '</div>'); ?>
				</div>
		</div>

		<!--<div class="row mt-2 required">
			<label class="col-2 control-label" for="template_file">Template</label>
			<div class="col-10">
				<?php //echo form_dropdown('template_file', $all_templates, set_value('template_file',$template_file),array('class'=>'form-select select2','id' => 'template_file')); ?>
			</div>
		</div>-->

		<div class="row mt-2 required">
			<label class="col-2 control-label" for="activated">Status</label>
			<div class="col-10">
				<?php  echo form_dropdown('activated', array('1'=>'Activated','0'=>'Deactivated'), set_value('activated',$activated),array('class'=>'form-select select2','id' => 'activated')); ?>
			</div>
		</div>

		<div class="row mt-2">
			<label class="col-2 control-label">&nbsp;</label>
			<div class="col-10">
				<button type="submit" form="form-user" data-toggle="tooltip" title="Save" class="btn btn-primary btn-sm"><i class="las la-save"></i> Save</button>
				<input type="hidden" id="user_edit_form" name="user_edit_form" value="1" />
			</div>
		</div>


		<?php echo form_close(); ?>
	</div>


	<div class="tab-pane p-3  <?php echo ($activeTab == 2 ? 'show active' : ''); ?>" id="tab-document" role="tabpanel">
		<?php //echo form_open_multipart(null, 'id="file-user" class="form-horizontal"'); ?>
		<!--<form action="" method="POST" enctype="multipart/form-data">
		
		

		<div class="row mt-4 required">
			<label for="title" class="col-2 control-label">Choose</label>
			<div class="col">
				<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="choose" id="send_file" value="1" onclick="choose_method(1)" checked>
				<label class="form-check-label" for="send_file">Upload File</label>
				</div>
				<div class="form-check form-check-inline">
				<input class="form-check-input" type="radio" name="choose" id="send_template" value="2" onclick="choose_method(2)">
				<label class="form-check-label" for="send_template">Send Template</label>
				</div>
			</div>
			
		</div>


		<div class="row mt-4 required g-2" id="row_file">
			<label for="title" class="col-2 control-label">File Name</label>
    		<div class="col-10">
       			 <input class="form-control" type="text" id="doc_title" name="doc_title" required>
    		</div>
    		<label for="title" class="col-2 control-label">File Upload</label>
    		<div class="col-10">
       			 <input class="form-control" type="file" id="pdf_file" name="pdf_file" accept="application/pdf" required>
    		</div>
    		
		</div>

		<div class="row mt-4 required d-none" id="row_template">
			<label class="col-2 control-label" for="template_file">Template</label>
			<div class="col-10">
				<?php //echo form_dropdown('template_file', $all_templates, set_value('template_file',$template_file),array('class'=>'form-select select2','id' => 'template_file')); ?>
			</div>
		</div>

		<div class="row">
			<label class="col-2 control-label"></label>
			<div class="col-10">
				<input type="hidden" id="file_upload_form" name="file_upload_form" value="1" />
				<button type="submit" class="btn btn-primary btn-sm mt-3"><i class="las la-cloud-upload-alt"></i> Upload</button>
			</div>
		</div>

		

		<?php
		/*
    if (isset($_POST['submit'])) {
 
        $name = $_POST['name'];
 
        if (isset($_FILES['pdf_file']['name']))
        {
          $file_name = $_FILES['pdf_file']['name'];
          $file_tmp = $_FILES['pdf_file']['tmp_name'];
 
          move_uploaded_file($file_tmp,"./pdf/".$file_name);
 
         
        }
        else
        {
           ?>
            <div class=
            "alert alert-danger alert-dismissible
            fade show text-center">
              <a class="close" data-dismiss="alert"
                 aria-label="close">×</a>
              <strong>Failed!</strong>
                  File must be uploaded in PDF format!
            </div>
          <?php
        }
    }*/
?>
		</form>

		<hr/>-->

		<?php 

		/*if(!empty($all_templates)){
			echo '<form id="files_form" action="" method="POST">';
			//echo '<table class="table">';
			//print_r($templates);
			foreach($templates as $d){
				
				echo '
				<div class="form-check pb-2">
				<input class="form-check-input mt-1" type="checkbox" value="'.$d->id.'" id="file_'.$d->id.'" name="file[]">
				<label class="form-check-label" for="file_'.$d->id.'">
					'.$d->template_title.'
				</label>
				</div>
				';
			}
			//echo '</table>';
			echo '<div id="files_error"></div>';
			echo '<button type="submit" class="btn btn-sm btn-dark" id="btn_send" name="btn_send" value="1" onclick="return checkTicks()"><i class="las la-paper-plane"></i> Send</button>';
			//echo '<button type="submit" class="btn btn-sm btn-danger ms-2" id="btn_remove" name="btn_remove" value="2" onclick="return checkTicks()"><i class="las la-trash"></i> Remove</button>';
			echo '<input type="hidden" id="file_send_form" name="file_send_form" value="1" />';
			echo '</form>';
		}else{
			echo '<div class="text-danger">No documents to show</div>';
		}*/

		//template section closed, signed and unsigned document added
		?>

		<?php echo form_open_multipart(null, 'id="files_form" class="form-horizontal"'); ?>


			<div class="row mt-4 required" id="row_file">
				<label for="title" class="col-2 control-label">File Upload</label>
				<div class="col-10">
					<input class="form-control" type="file" id="upload_file" name="upload_file" accept="application/pdf" required>
				</div>
			</div>

			<div class="row mt-4 required" id="row_template">
				<label class="col-2 control-label" for="doc_type">Document Type</label>
				<div class="col-10">
					<?php echo form_dropdown('doc_type', array(1 => 'Onboarding', 2 => 'Coaching', 3 => 'Scorecard'), set_value('doc_type', 1),array('class'=>'form-select select2','id' => 'doc_type')); ?>
				</div>
			</div>

			<div class="row">
				<label class="col-2 control-label"></label>
				<div class="col-10">
					<input type="hidden" id="file_upload_form" name="file_upload_form" value="1" />
					<button type="submit" class="btn btn-sm btn-primary mt-3" id="btn_send" name="btn_send" value="1"><i class="las la-paper-plane"></i> Send</button>
				</div>
			</div>

			
			
		<?php echo form_close(); ?>

	</div>


	


	<div class="tab-pane" id="tab-status-pending" role="tabpanel">
		<?php 
		if(empty($not_sent_doc_data)){
			echo '<div class="text-danger m-4 text-center">No documents to show</div>';
		}else{
			echo '<table class="table table-bordered mt-4">';
			echo '<thead><tr>
			<th>#</th>
			<th>Document</th>
			<th>Type</th>
			<th>Download</th>
			<th>Sent On</th>
			<th>Status</th>
			</tr></thead><tbody>';
			$c = 1;
			foreach($not_sent_doc_data as $dd){
				$dt = new DateTime($dd['added_on']);
				//doc type
				$doc_type = '';
				switch($dd['doc_type']){
					case 1:
						$doc_type = 'Onboarding';
						break;
					case 2:
						$doc_type = 'Coaching';
						break;
					case 3:
						$doc_type = 'Scorecard';
						break;		
				}
				if($dd['status'] == 0){
					//show only pending ones
					echo '<tr>
					<td>'.($c++).'</td>
					<td>'.$dd['doc_title'].'</td>
					<td>'.$doc_type.'</td>
					<td><a href="'.base_url('storage/uploads/files/'.$dd['uploadfile']).'" class="btn btn-danger btn-sm"><i class="las la-file-pdf"></i> Download</a></td>
					<td>'.$dt->format('M d, Y H:i:s A').'</td>
					<td>'.($dd['status'] == 1 ? '<div class="text-success">Signed</div>' : '<div class="text-danger">Pending</div>').'</td>
					</tr>';
				}
				
			}
			echo '</tbody></table>';
		}
		?>
	</div>


	<div class="tab-pane" id="tab-status-signed" role="tabpanel">
		<?php 
		if(empty($sent_doc_data)){
			echo '<div class="text-danger m-4 text-center">No documents to show</div>';
		}else{
			echo '<table class="table table-bordered mt-4">';
			echo '<thead><tr>
			<th>#</th>
			<th>Document</th>
			<th>Type</th>
			<th>Download</th>
			<th>Sent On</th>
			<th>Signed On</th>
			<th>Status</th>
			</tr></thead><tbody>';
			$c = 1;
			foreach($sent_doc_data as $dd){
				$sdt = new DateTime($dd['added_on']);
				$ddt = new DateTime($dd['signed_on']);
				//doc type
				$doc_type = '';
				switch($dd['doc_type']){
					case 1:
						$doc_type = 'Onboarding';
						break;
					case 2:
						$doc_type = 'Coaching';
						break;
					case 3:
						$doc_type = 'Scorecard';
						break;		
				}
				if($dd['status'] == 1){
					//show only signed ones
					echo '<tr>
					<td>'.($c++).'</td>
					<td>'.$dd['doc_title'].'</td>
					<td>'.$doc_type.'</td>
					<td><a href="'.base_url('storage/uploads/files/'.$dd['uploadfile']).'" class="btn btn-danger btn-sm"><i class="las la-file-pdf"></i> Download</a></td>
					<td>'.$sdt->format('M d, Y H:i:s A').'</td>
					<td>'.$ddt->format('M d, Y H:i:s A').'</td>
					<td>'.($dd['status'] == 1 ? '<div class="text-success">Signed</div>' : '<div class="text-danger">Pending</div>').'</td>
					</tr>';
				}
				
			}
			echo '</tbody></table>';
		}
		?>
	</div>


	
</div>



<?php js_start(); ?>
<script type="text/javascript">
	function image_upload(field, thumb) {
		window.KCFinder = {
			callBack: function(url) {
				window.KCFinder = null;
				var lastSlash = url.lastIndexOf("uploads/");
				var fileName=url.substring(lastSlash+7);
				url=url.replace("images", ".thumbs/images"); 
				$('#'+thumb).attr('src', "<?=base_url()?>"+ url);
				$('#'+field).attr('value', fileName);
				$.colorbox.close();
				/*$.post('<?php echo site_url('setting/create-thumb'); ?>', {'image_path': fileName}, function(image_path) {
					$('#'+thumb).attr('src', image_path);
					$('#'+field).attr('value', fileName);
					$.colorbox.close();
				});*/
			}
		};
		$.colorbox({href:BASE_URL+"storage/plugins/kcfinder/browse.php?type=images",width:"850px", height:"550px", iframe:true,title:"Image Manager"});	
	};

	function checkTicks(){
		
		var check = $('#files_form').find('input[type=checkbox]:checked').length;
		if(check == 0){
			$('#files_error').html('<div class="alert alert-danger text-white py-1"><i class="las la-exclamation-circle"></i> No file selected</div>');
			return false;
		}

	}

	function choose_method(type){
		//show hide accordingly
		if(type == 1){
			$('#row_file').removeClass('d-none');
			$('#row_template').addClass('d-none');

			$('#doc_title').prop('required',true);
			$('#pdf_file').prop('required',true);
			$('#template_file').prop('required',false);
		}else if(type == 2){
			$('#row_template').removeClass('d-none');
			$('#row_file').addClass('d-none');

			$('#doc_title').prop('required',false);
			$('#pdf_file').prop('required',false);
			$('#template_file').prop('required',true);
		}
	}
</script>

<?php js_end(); ?>