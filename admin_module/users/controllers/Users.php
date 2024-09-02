<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends Admin_Controller {
	private $error = array();
	
	public function __construct(){
      parent::__construct();
		$this->load->model('users_model');
		$this->load->model('common/common_model');
		$this->load->model('templates/templates_model');
	}
	
	public function index(){
		redirect(admin_url('users/drivers'));
	}

	public function drivers(){
		$this->lang->load('users');
		$this->template->set_meta_title($this->lang->line('heading_title'));
		$this->getList();  
	}
	
	public function search() {
		$requestData= $_REQUEST;
		
		$columns = array( 
			0 => '',
			1 => 'u.name',
			2 => 'u.email'
		);
		
		$totalData = $this->users_model->getTotalUsers();
		
		$totalFiltered = $totalData;

		$activated_status = $this->uri->segment(4);
		
		$filter_data = array(
			'filter_search' => $requestData['search']['value'],
			'order'  		 => $requestData['order'][0]['dir'],
			'sort' 			 => intval($requestData['order'][0]['column']) ? $columns[$requestData['order'][0]['column']] : 'u.id',
			'start' 			 => $requestData['start'],
			'limit' 			 => $requestData['length']
		);
		$totalFiltered = $this->users_model->getTotalUsers($filter_data, $activated_status);
			
		$filteredData = $this->users_model->getUsers($filter_data, $activated_status);
		//printr($filteredData);
		
		$datatable=array();
		$count = 1;

		$progress_bar = array(
			2 => '<div class="progress" ><div class="progress-bar bg-danger small fw-bold" style="width: 25%">25%</div></div>',
			3 => '<div class="progress" ><div class="progress-bar bg-dark small fw-bold" style="width: 50%">50%</div></div>',
			4 => '<div class="progress" ><div class="progress-bar bg-dark small fw-bold" style="width: 50%">50%</div></div>',
			5 => '<div class="progress" ><div class="progress-bar bg-success small fw-bold" style="width: 100%">100%</div></div>',
			6 => '<div class="progress" ><div class="progress-bar bg-warning small fw-bold" style="width: 75%">75%</div></div>',
			7 => '<div class="progress" ><div class="progress-bar bg-warning small fw-bold" style="width: 65%">65%</div></div>',
			8 => '<div class="progress" ><div class="progress-bar bg-warning small fw-bold" style="width: 45%">45%</div></div>'
		);


		foreach($filteredData as $result) {
			
			if (is_file(DIR_UPLOAD . $result->image)) {
				$image = resize($result->image, 40, 40);
			} else {
				$image = resize('no_image.png', 40, 40);
			}

			//$viewdetails = '<a class="btn btn-sm btn-outline-dark" href="'.admin_url('users/details/'.$result->id).'">View </a>';
			$viewdetails = '<a class="btn btn-sm btn-outline-dark text-nowrap" href="'.admin_url('sheet').'"><i class="las la-eye"></i> View</a>';
			$gasmodal = '<button type="button" class="btn btn-sm btn-outline-danger text-nowrap" onclick="showgasmodal('.$result->id.')"><i class="las la-plus-circle"></i> Pin</button>';
			
			$action  = '<div class="btn-group btn-group-sm pull-right">';
			// href="'.admin_url('users/chatroom/'.$result->id).'"
			$action .= 		'<button class="btn btn-outline-dark" title="Chat" onclick="startchat('.$result->id.')"><i class="las la-sms"></i></i></button>';
			//$action .= 		'<a class="btn btn-outline-dark" href="'.admin_url('users/details/'.$result->id).'"><i class="la la-eye"></i></i></a>';
			
			$action .= 		'<a class="btn btn-outline-dark" title="Edit" href="'.admin_url('users/edit/'.$result->id).'"><i class="la la-edit"></i></i></a>';
			
			

			

			$action .=		'<a class="btn btn-outline-dark" title="Send Credentials" href="'.admin_url('users/sendmail/'.$result->id).'" onclick="return confirm(\'Are you sure you want to send the credentials?\') ? true : false;"><i class="las la-paper-plane"></i></a>';
			$action .=		'<a class="btn btn-danger btn-remove" title="Delete" href="'.admin_url('users/delete/'.$result->id).'" onclick="return confirm(\'Are you sure you want to delete this Driver?\') ? true : false;"><i class="las la-trash"></i></a>';
			$action .= '</div>';

			/*$action ='<div class="btn-group btn-group-sm pull-right">';
            $action .= '<a class="btn btn-outline-secondary" title="Edit Page" href="'. admin_url('users/edit/' . $result->id) . '"><i class="la la-edit"></i></a>';
            $action .= '<a class="btn btn-outline-secondary" title="Delete Page"  href="'. admin_url('users/delete/' . $result->id) . '" onclick="return confirm(\'Are you sure?\') ? true : false;"><i class="las la-trash"></i></a>';
            $action .= '</div>';*/

			$datatable[]=array(
				$count++,
				$result->name,
				$result->email,
				//$result->activated ? '<span class="text-success"><i class="las la-dot-circle"></i> Activated</span>':'<span class="text-danger"><i class="las la-dot-circle"></i> Deactivated</span>',
				$viewdetails,
				$gasmodal,
				($result->activated ? '<span class="text-success"><i class="las la-dot-circle"></i> Activated</span>' : '<span class="text-danger"><i class="las la-dot-circle"></i> Not Activated</span>'),
				//0,//$progress_bar[$count],
				$action
			);
	
		}
		//printr($datatable);
		$json_data = array(
			"draw"            => isset($requestData['draw']) ? intval( $requestData['draw'] ):1,
			"recordsTotal"    => intval( $totalData ),
			"recordsFiltered" => intval( $totalFiltered ),
			"data"            => $datatable
		);

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($json_data));  // send data as json format
	}

	public function showgasmodalcontents(){
		//echo 'done'. $_POST['driver_id'];
		$driver = $this->users_model->getUser($_POST['driver_id']);
		$gaspin = $this->users_model->getGasPin($_POST['driver_id']);
		echo '
		<form action="'.admin_url('users/updategaspin').'" method="POST">
			<div class="form-floating mb-3">
                <input type="text" class="form-control" readonly id="driver_name" name="driver_name" value="'.$driver->name.'">
                <label for="driver_name">Driver</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="gas_pin" name="gas_pin" value="'.$gaspin.'">
                <label for="gas_pin">Gas Pin</label>
            </div>
            <button type="button" id="gas_submit" name="gas_submit" onclick="updategaspin('.$_POST['driver_id'].')" class="btn btn-danger btn-sm">Update</button>
        </form>
		';
	}

	public function add(){
		$this->lang->load('users');
		$this->template->set_meta_title($this->lang->line('heading_title'));
		
		if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->validateForm()){	
			$userdata=array(
				"name"=>$this->input->post('name'),
				"password"=>md5($this->input->post('password')),
				"show_password"=>$this->input->post('password'),
				"email"=>$this->input->post('email'),
				"status"=>1,	
				"user_group_id" => 2,
				//"template_file"=>$this->input->post('template_file'),
				"activated"=>$this->input->post('activated')
			);

			
			$userid=$this->users_model->addUser($userdata);
			
			$this->session->set_flashdata('message', 'Driver '.$this->input->post('name').' Created Successfully.');
			redirect(ADMIN_PATH.'/users');
		}
		$this->getForm();
	}
	
	public function edit(){
		
		$this->lang->load('users');
		$this->template->set_meta_title($this->lang->line('heading_title'));

		$data = array();
		
		
		if($this->input->server('REQUEST_METHOD') === 'POST'){
			//print_r($_FILES);
			if(array_key_exists('user_edit_form', $_POST)){
				$user_id=$this->uri->segment(4);
				$userdata=array(
					"name"=>$this->input->post('name'),
					"password"=>md5($this->input->post('password')),
					"show_password"=>$this->input->post('password'),
					"email"=>$this->input->post('email'),
					"status"=>1,
					//"template_file"=>$this->input->post('template_file'),
					"activated"=>$this->input->post('activated')
				);
				$userid=$this->users_model->editUser($user_id,$userdata);
				
				$this->session->set_flashdata('message', 'Users Updated Successfully.');
				//redirect(ADMIN_PATH.'/users');
			}else if(array_key_exists('file_upload_form', $_POST)){
				//upload file
				//print_r($_POST);
				//print_r($_FILES);
				//die;
				//Array ( [choose] => 2 [template_file] => 2
				$file_name = $doc_title = '';

				$file_name = time().'.pdf';
				$file_tmp = $_FILES['upload_file']['tmp_name'];
				move_uploaded_file($file_tmp,'storage/uploads/files/'.$file_name);

				$this->session->set_flashdata('message', 'File Added Successfully.');
				//redirect(ADMIN_PATH.'/users');
				/*if ($_POST['choose'] == 1 && isset($_FILES['pdf_file']['name'])){
			          //$file_name = time().$_FILES['pdf_file']['name'];
					  $doc_title = $_POST['doc_title']; 
					  $file_name = time().'.pdf';
			          $file_tmp = $_FILES['pdf_file']['tmp_name'];
			          move_uploaded_file($file_tmp,'storage/uploads/files/'.$file_name);
			          $this->session->set_flashdata('message', 'File Added Successfully.');
				    //redirect(ADMIN_PATH.'/users');
				}else if ($_POST['choose'] == 2 && $_POST['template_file'] > 0){
					$tmt = $this->templates_model->getTemplates($_POST['template_file']);
					$doc_title = $tmt->template_title; 
					$file_name = time().'.pdf';
					copy('storage/uploads/files/'.$tmt->template_file, 'storage/uploads/files/'.$file_name);
				}*/
				//save the document in table
				$user_id=$this->uri->segment(4);
				$docdata=array(
							"doc_title"=>$file_name,
							"doc_description"=>"New Document",
							"doc_type"=>$_POST['doc_type'],
							"uploadfile"=>$file_name,
							"user"=>$user_id
						);
				$this->db->insert("document", $docdata);
				//redirect to fetch users properly
				redirect(ADMIN_PATH.'/users/edit/'.$user_id);

			}else if(array_key_exists('file_send_form', $_POST)){
				//check which btn pressed
				if(array_key_exists('btn_send', $_POST)){
					//make all approved
					//print_r($_POST);die;
					for($i=0;$i<count($_POST['file']);$i++){
						//copy each template for signing
						$tmt = $this->templates_model->getTemplates($_POST['file'][$i]);
						$doc_title = $tmt->template_title; 
						$file_name = time().'.pdf';
						copy('storage/uploads/files/'.$tmt->template_file, 'storage/uploads/files/'.$file_name);
						//save the document in table
						$user_id=$this->uri->segment(4);
						$docdata=array(
									"doc_title"=>$doc_title,
									"doc_description"=>"New Document",
									"uploadfile"=>$file_name,
									"user"=>$user_id,
									"is_approved"=>0
								);
						$this->db->insert("document", $docdata);
						$doc_id = $this->db->insert_id();
						//send email
						$user_info = $this->users_model->getUser($this->uri->segment(4));
						//print_r($user_info);die;
						$mail_body = '
						<html>
						<head>
						<style>
						* {
						margin: 0;
						padding: 0;
						box-sizing: border-box;
						}

						body {
						font-family: "Poppins", sans-serif;
						background-color: #f1f1f1;
						}

						body,
						input {
						color: #1a1a1a;
						}

						main {
						min-height: 100vh;

						display: grid;
						place-items: center;

						padding: 2em;
						}

						/* Subscribe Card */
						.subscribe-card {
						position: relative;

						padding: 3em 4em;

						background-color: white;
						box-shadow: 2px 0 15px -2px rgba(0, 0, 0, 0.2);

						border-radius: 12px;

						display: grid;
						row-gap: 1.6em;
						
						transition: all .1s ease-in-out;
						}

						.subscribe-card > h2 {
						color: #3e54ac;

						font-weight: 800;
						font-size: 1.8em;

						text-align: center;
						}

						.subscribe-card > p {
						line-height: 1.8;
						font-weight: 400;

						text-align: center;

						opacity: 0.9;
						}

						.form-email {
						margin-top: 1em;

						display: grid;
						row-gap: 1.6em;
						}

						.input-email {
						padding: 1em;

						background-color: #ecf2ff;

						border: none;
						outline: none;
						border-radius: 7px;

						font-weight: 500;
						}

						/* Error Message */
						.error-message {
						font-size: 0.8em;
						font-weight: 400;
						
						color: red;
						
						display: none;
						}

						.input-email:not(:placeholder-shown):invalid
						~ .error-message {
						display: block;
						}

						.send-button {
						display: flex;
						align-items: center;
						justify-content: center;

						gap: 1em;
						padding: 0.8em;

						color: white;
						background-color: #655dbb;

						border: none;
						border-radius: 7px;

						font-weight: 600;

						cursor: pointer;
						}

						@media (hover: hover) {
						.send-button:hover {
							background-color: #bface2;
							color: #4e31aa;

							transition: all 0.1s ease-in-out;
						}
						}

						</style>
						</head>
						<body>
						<main>
						<div class="subscribe-card">
							<h2>New Document</h2>
							<p>
							Dear <strong>'.$user_info->name.'</strong>,<br />
							A new document has been assigned to you. Please login to portal to e-sign the same.
							</p>

							<form class="form-email">
							<p style="text-align:center;font-weight:bold">DOCUMENT: '.$doc_title.'</p>
							
							<a href="'.base_url('admin/document/docusign/'.$doc_id).'" class="send-button">LOGIN</a>
							</form>
						</div>
						</main>
						</body>
						</html>
						';
						//http://trantonhr.co/admin/document/docusign/19
						//$this->common_model->sg_mail('Tranton: New Document Assigned', $user_info->email, $user_info->name, $mail_body, 'noreply@trantonhr.co', 'Tranton Admin');
						//die;
						//mark - approve it
						/*$dt_approve = array('is_approved' => 1);
						$this->db->where("id",$_POST['file'][$i]);
						$status=$this->db->update("document", $dt_approve);*/
					}
					$this->session->set_flashdata('message', 'File(s) sent to user.');
					/**/
				}/*else if(array_key_exists('btn_remove', $_POST)){
					//delete all those files
					$this->db->where_in("id",$_POST['file']);
					$query = $this->db->get('document');
					$dd = $query->result();
					foreach($dd as $d){
						@unlink('storage/uploads/files/'.$d->uploadfile);
					}
					//remove all files
					$this->db->where_in("id",$_POST['file']);
					$status=$this->db->delete("document");
					$this->session->set_flashdata('message', 'File(s) removed from server.');
				}*/
				
			}
			//print_r($_POST);
			
		}
		/*if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->validateForm()){	
			$user_id=$this->uri->segment(4);
			$userdata=array(
				"name"=>$this->input->post('name'),
				"password"=>md5($this->input->post('password')),
				"show_password"=>$this->input->post('password'),
				"email"=>$this->input->post('email'),
				"status"=>1,
				"activated"=>$this->input->post('activated')
			);
			$userid=$this->users_model->editUser($user_id,$userdata);
			
			$this->session->set_flashdata('message', 'Users Updated Successfully.');
			redirect(ADMIN_PATH.'/users');
		}*/
		//$this->session->set_flashdata('message', 'File Added Successfully.');
		$this->getForm();
	}
	
	public function delete(){
		/*
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
		$this->users_model->deleteUser($selected);
		*/
		$this->users_model->deleteUser($this->uri->segment(4));
		$this->session->set_flashdata('message', 'User deleted Successfully.');
		redirect(ADMIN_PATH.'/users');
	}

	public function sendmail(){
		//$this->users_model->sendmailUser($this->uri->segment(4));
		$user_info = $this->users_model->getUser($this->uri->segment(4));
		//print_r($user_info);die;
		$mail_body = '
		<html>
		<head>
		<style>
		* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
		}

		body {
		font-family: "Poppins", sans-serif;
		background-color: #f1f1f1;
		}

		body,
		input {
		color: #1a1a1a;
		}

		main {
		min-height: 100vh;

		display: grid;
		place-items: center;

		padding: 2em;
		}

		/* Subscribe Card */
		.subscribe-card {
		position: relative;

		padding: 3em 4em;

		background-color: white;
		box-shadow: 2px 0 15px -2px rgba(0, 0, 0, 0.2);

		border-radius: 12px;

		display: grid;
		row-gap: 1.6em;
		
		transition: all .1s ease-in-out;
		}

		.subscribe-card > h2 {
		color: #3e54ac;

		font-weight: 800;
		font-size: 1.8em;

		text-align: center;
		}

		.subscribe-card > p {
		line-height: 1.8;
		font-weight: 400;

		text-align: center;

		opacity: 0.9;
		}

		.form-email {
		margin-top: 1em;

		display: grid;
		row-gap: 1.6em;
		}

		.input-email {
		padding: 1em;

		background-color: #ecf2ff;

		border: none;
		outline: none;
		border-radius: 7px;

		font-weight: 500;
		}

		/* Error Message */
		.error-message {
		font-size: 0.8em;
		font-weight: 400;
		
		color: red;
		
		display: none;
		}

		.input-email:not(:placeholder-shown):invalid
		~ .error-message {
		display: block;
		}

		.send-button {
		display: flex;
		align-items: center;
		justify-content: center;

		gap: 1em;
		padding: 0.8em;

		color: white;
		background-color: #655dbb;

		border: none;
		border-radius: 7px;

		font-weight: 600;

		cursor: pointer;
		}

		@media (hover: hover) {
		.send-button:hover {
			background-color: #bface2;
			color: #4e31aa;

			transition: all 0.1s ease-in-out;
		}
		}

		</style>
		</head>
		<body>
		<main>
		<div class="subscribe-card">
			<h2>Welcome</h2>
			<p>
			Dear <strong>'.$user_info->name.'</strong>,<br />
			Please find your credentials below.
			</p>

			<form class="form-email">
			<p style="text-align:center;font-weight:bold">'.$user_info->email.'<br/>'.$user_info->show_password.'</p>
			
			<a href="'.base_url().'" class="send-button">LOGIN</a>
			</form>
		</div>
		</main>
		</body>
		</html>
		';
		//$this->common_model->sg_mail('Tranton: Account Credentials', $user_info->email, $user_info->name, $mail_body, 'noreply@trantonhr.co', 'Tranton Admin');
		//die;
		$this->session->set_flashdata('message', 'Sent mail Successfully.');
		redirect(ADMIN_PATH.'/users');
		//$this->template->view('email',$user_info);
	}
	
	protected function getList() {
		
		//$this->template->add_package(array('datatable'),true);
		$activated = 1;
		$search_status = 1;
		if($this->uri->segment(4) >= 1 && $this->uri->segment(4) <= 3){
			//update status
			if($this->uri->segment(4) > 0){
				$activated = $this->uri->segment(4);
			}
			/*switch($this->uri->segment(4)){
				case 1:
					$activated = 1;
					break;
				case 2:
					$activated = 2;
					break;
				case 3:
					$activated = 3;
					break;
			}*/

			$search_status = $this->uri->segment(4);
		}

		$data['search_status'] = $search_status;

      	$data['add'] = admin_url('users/add');
		$data['delete'] = admin_url('users/delete');
		$data['datatable_url'] = admin_url('users/search/'.$activated);

		$data['heading_title'] = $this->lang->line('heading_title');
		
		$data['text_list'] = $this->lang->line('text_list');
		$data['text_no_results'] = $this->lang->line('text_no_results');
		$data['text_confirm'] = $this->lang->line('text_confirm');

		$data['column_name'] = $this->lang->line('column_name');
		$data['column_status'] = $this->lang->line('column_status');
		$data['column_date_added'] = $this->lang->line('column_date_added');
		$data['column_action'] = $this->lang->line('column_action');

		$data['button_add'] = $this->lang->line('button_add');
		$data['button_edit'] = $this->lang->line('button_edit');
		$data['button_delete'] = $this->lang->line('button_delete');

		if(isset($this->error['warning'])){
			$data['error'] 	= $this->error['warning'];
		}

		if ($this->input->post('selected')) {
			$data['selected'] = (array)$this->input->post('selected');
		} else {
			$data['selected'] = array();
		}

		$data['gas_pin'] = $this->users_model->getGasPin(1);

		$this->template->view('users', $data);
	}
	
	protected function getForm(){
		
		$this->template->add_package(array('ckeditor','colorbox','select2'),true);
      
		
		
		$data['heading_title'] 	= $this->lang->line('heading_title');
		
		$data['text_form'] = $this->uri->segment(4) ? $this->lang->line('text_edit') : $this->lang->line('text_add');
		
		if(isset($this->error['warning']))
		{
			$data['error'] 	= 'Please check for errors.';
		}
		
		$data['cancel'] = admin_url('users');

		if (($this->uri->segment(3) && !array_key_exists('user_edit_form', $_POST)) && ($this->input->server('REQUEST_METHOD') != 'POST')) {
			$user_info = $this->users_model->getUser($this->uri->segment(4));
		}

		if ($this->input->post('name')) {
			$data['name'] = $this->input->post('name');
		} elseif (!empty($user_info)) {
			$data['name'] = $user_info->name;
		} else {
			$data['name'] = '';
		}
		
		
		if ($this->input->post('email')) {
			$data['email'] = $this->input->post('email');
		} elseif (!empty($user_info)) {
			$data['email'] = $user_info->email;
		} else {
			$data['email'] = '';
		}
		
		if ($this->input->post('password')) {
			$data['password'] = $this->input->post('password');
		} elseif (!empty($user_info)) {
			$data['password'] = $user_info->show_password;
		} else {
			$data['password'] = '';
		}

		/*if ($this->input->post('image')) {
			$data['image'] = $this->input->post('image');
		} elseif (!empty($user_info)) {
			$data['image'] = $user_info->image;
		} else {
			$data['image'] = '';
		}

		if ($this->input->post('image') && is_file(DIR_UPLOAD . $this->input->post('image'))) {
			$data['thumb_icon'] = resize($this->input->post('image'), 100, 100);
		} elseif (!empty($user_info) && is_file(DIR_UPLOAD . $user_info->image)) {
			$data['thumb_icon'] = resize($user_info->image, 100, 100);
		} else {
			$data['thumb_icon'] = resize('no.png', 100, 100);
		}


		$data['thumb_icon'] = resize(base_url('storage/no.png'), 100, 100);

		//print_r($data);
		
		$data['no_image'] = resize('no.png', 100, 100);*/
		
		if ($this->input->post('activated')) {
			$data['activated'] = $this->input->post('activated');
		} elseif (!empty($user_info)) {
			$data['activated'] = $user_info->activated;
		} else {
			$data['activated'] = '';
		}

		/*if ($this->input->post('template_file')) {
			$data['template_file'] = $this->input->post('template_file');
		} elseif (!empty($user_info)) {
			$data['template_file'] = $user_info->template_file;
		} else {
			$data['template_file'] = 0;
		}*/


		/*if ($this->input->post('config_site_title')){
			$data['config_site_title'] = $this->input->post('config_site_title');
		} else {
			$data['config_site_title'] = $this->settings->config_site_title;
		}
		
		if ($this->input->post('config_site_tagline')){
			$data['config_site_tagline'] = $this->input->post('config_site_tagline');
		} else {
			$data['config_site_tagline'] = $this->settings->config_site_tagline;
		}
		
        if ($this->input->post('config_site_logo')) {
			$data['config_site_logo'] = $this->input->post('config_site_logo');
		} else {
			$data['config_site_logo'] = $this->settings->config_site_logo;
		}
		
		if ($this->input->post('config_site_logo') && is_file(DIR_UPLOAD . $this->input->post('config_site_logo'))) {
			$data['thumb_logo'] = resize($this->input->post('config_site_logo'), 100, 100);
		} elseif ($this->settings->config_site_logo && is_file(DIR_UPLOAD . $this->settings->config_site_logo)) {
			$data['thumb_logo'] = resize($this->settings->config_site_logo, 100, 100);
		} else {
			$data['thumb_logo'] = resize('no_image.png', 100, 100);
		}
        
		if ($this->input->post('config_site_icon')) {
			$data['config_site_icon'] = $this->input->post('config_site_icon');
		} else {
			$data['config_site_icon'] = $this->settings->config_site_icon;
		}

		if ($this->input->post('config_site_icon') && is_file(DIR_UPLOAD . $this->input->post('config_site_icon'))) {
			$data['thumb_icon'] = resize($this->input->post('config_site_icon'), 100, 100);
		} elseif ($this->settings->config_site_icon && is_file(DIR_UPLOAD . $this->settings->config_site_icon)) {
			$data['thumb_icon'] = resize($this->settings->config_site_icon, 100, 100);
		} else {
			$data['thumb_icon'] = resize('no_image.png', 100, 100);
		}
		
		$data['no_image'] = resize('no_image.png', 100, 100);*/
		
		/*if ($this->input->post('config_meta_title')) {
			$data['config_meta_title'] = $this->input->post('config_meta_title');
		} else {
			$data['config_meta_title'] = $this->settings->config_meta_title;
		}
		
		if ($this->input->post('config_meta_description')) {
			$data['config_meta_description'] = $this->input->post('config_meta_description');
		} else {
			$data['config_meta_description'] = $this->settings->config_meta_description;
		}
		
		if ($this->input->post('config_meta_keywords')) {
			$data['config_meta_keywords'] = $this->input->post('config_meta_keywords');
		} else {
			$data['config_meta_keywords'] = $this->settings->config_meta_keywords;
		}*/


		//fetch my documents
		$data['not_sent_doc_data'] = $this->users_model->getUserNotSentDocuments($this->uri->segment(4));
		$data['doc_data'] = $this->users_model->getUserDocuments($this->uri->segment(4));
		$data['sent_doc_data'] = $this->users_model->getUserSentDocuments($this->uri->segment(4));
		
		
		//templates
		/*$tt = $this->templates_model->getTemplatess();
		//print_r($tt);
		$t_array = array('' => 'Select a Template');

		foreach($tt as $t){
			$t_array[$t->id] = $t->template_title;
		}
		//print_r($t_array);
		$data['all_templates'] = $t_array;
		$data['templates'] = $tt;
		$data['template_file'] = '';*/


		$data['activeTab'] = 1;
		if(array_key_exists('user_edit_form', $_POST)){
			$data['activeTab'] = 1;
		}else if(array_key_exists('file_upload_form', $_POST) || array_key_exists('file_send_form', $_POST)){
			$data['activeTab'] = 2;
		}

		


		$this->template->view('users_form',$data);
	}

	public function details(){
		$this->lang->load('users');
		$this->template->set_meta_title($this->lang->line('heading_title'));
		
		$user_id = $this->uri->segment(4);
		$data = array();
		$data['user'][] = $this->users_model->getUser($user_id);
		// $data['user'] = $user;
		$data['heading_title'] = $this->lang->line('driver');
		$this->template->view('userdetails',$data);
	}

	public function updatedetails(){
		// $data['text_form'] = $this->uri->segment(4) ? "Edit Menu Group" : "Add Menu Group";
		
		$user_id = $this->uri->segment(4);
		$data = array();
		$data = $this->users_model->getActiveUsers();
		// $data = $this->users_model->getUser($user_id);
		// echo $data->name;
		// print_r($data)
		$selected_user = '';
		$html='';
		$html.='<form method="post" action="" class="addDetailsForm">';
		$html.='<div class="row">';
		$html.='<div class="mb-3 col-md-6">';
		$html.='<label for="exampleInputEmail1" class="form-label">Driver Name</label>';
		$html.='<select class="form-select" name="menu_group_id" aria-label="Default select example">';
		$html.='<option value="0">  --Select--  </option>';
		foreach($data as $u){
			$selected_user = '';
			if($u->id == $user_id){
				$selected_user = 'selected';
			}
			
			$html.='<option value="'.$u->id.'"  '. $selected_user .'>'.$u->name.'</option>';
		}
		$html.='</select>';
		
		$html.='</div>';
		$html.='<div class="mb-3 col-md-6">';
		$html.='<label for="exampleInputEmail1" class="form-label">Date</label>';
		$html.='<input type="date" class="form-control" name="iconmenu" id="exampleInputEmail1" value="'. date("Y-m-d").'" >';
		$html.='</div>';
		
		$html.='<div class="mb-3 col-md-6">';
		$html.='<label for="exampleInputEmail1" class="form-label">Wave</label>';
		$html.='<input type="text" class="form-control" name="title" value="" id="exampleInputEmail1" aria-describedby="emailHelp">';
		$html.='</div>';
		$html.='<div class="mb-3 col-md-6">';
		$html.='<label for="exampleInputEmail1" class="form-label">Route</label>';
		$html.='<input type="text" class="form-control" name="url" value="" id="exampleInputEmail1" aria-describedby="emailHelp">';
		$html.='</div>';
		$html.='<div class="mb-3 col-md-6">';
		$html.='<label for="exampleInputEmail1" class="form-label">Staging Zone </label>';
		$html.='<input type="text" class="form-control" name="class" value="" id="exampleInputEmail1" aria-describedby="emailHelp">';
		$html.='</div>';
		$html.='<div class="mb-3 col-md-6">';
		$html.='<label for="exampleInputEmail1" class="form-label">Select Van</label>';
		$html.='<select class="form-select" name="menu_group_id" aria-label="Default select example">';
		// foreach($menu_groups as $v){
			$html.='<option value="0">  --Select--  </option>';
			$html.='<option value="1">Van 1 ( 1111-2222-3333-4444 ) </option>';
			$html.='<option value="1">Van 2 ( AAAA-BBBB-CCCC-DDDD ) </option>';
			// $html.='<option value="2">'.$v['title'].'</option>';
		// }
		$html.='</select>';
		$html.='</div>';
		
		$html.='<div class="d-flex align-items-center justify-content-between mt-2">';
		$html.='<div></div>';
		$html.='<button type="submit" name="update_btn" id="updateMenuForm" class="btn btn-primary updateMenuForm" value="1"><i class="las la-save"></i> Add</button>';
		$html.='</div>';
		$html.='</div>';
		$html.='<div class="eror_msg text-danger"></div>';
		$html.='</form>';
		echo $html;
		
	}

	public function uploaddetails(){
		$html='';
		$html.='<form method="post" action="" class="addDetailsForm">';
		$html.='<div class="row">';
		$html.='<div class="mb-3 col-md-12">';
		$html.='<label for="exampleInputEmail1" class="form-label">Upload</label>';
		$html.='<input type="file" name="jobs_file" value="" class="form-control" id="jobs_file" placeholder="" accept=".csv" required>';
		$html.='<small class="text-danger">Only CSV format allowed</small>';
		
		$html.='</div>';
			
		$html.='<div class="d-flex align-items-center justify-content-between mt-2">';
		$html.='<div></div>';
		$html.='<button type="submit" name="update_btn" id="updateMenuForm" class="btn btn-primary updateMenuForm" value="1"><i class="las la-save"></i> Upload</button>';
		$html.='</div>';
		$html.='</div>';
		$html.='<div class="eror_msg text-danger"></div>';
		$html.='</form>';
		echo $html;

	}

	public function chatroom(){
		if (!$this->user->isLogged()){
			return NULL;
		}
		$this->lang->load('users');
		$this->template->set_meta_title($this->lang->line('heading_title'));
		
		/*if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->validateForm()){	
			$userdata=array(
				"name"=>$this->input->post('name'),
				"password"=>md5($this->input->post('password')),
				"show_password"=>$this->input->post('password'),
				"email"=>$this->input->post('email'),
				"status"=>1,	
				//"template_file"=>$this->input->post('template_file'),
				"activated"=>$this->input->post('activated')
			);

			
			$userid=$this->users_model->addUser($userdata);
			
			$this->session->set_flashdata('message', 'Users Saved Successfully.');
			redirect(ADMIN_PATH.'/users');
		}
		$this->getForm();*/
		$data = array();
		if($this->uri->segment(4) > 0){
			$data['active_user'] = $this->uri->segment(4);
			//remove it from chat window
			$array = array();
			if(array_key_exists('chat_window_drivers', $_SESSION))
				$array = $_SESSION['chat_window_drivers'];

			//find the key
			for($i=0;$i<count($array);$i++){
				if($array[$i]['driver_id'] == $data['active_user']){
					//item found, remove it
					unset($array[$i]);
					$_SESSION['chat_window_drivers'] = array_values($array);
				}
			}
		}
		

		$this->template->view('chats_form',$data);
	}

	public function loadchatusersajax(){
		if (!$this->user->isLogged()){
			return NULL;
		}
		$data = array();
		if(strlen($_POST['search_text'])){
			$data['filter_search'] = $_POST['search_text'];
		}

		$users = $this->users_model->getActiveUsers($data);

		if(empty($users)){
			echo '<div class="alert alert-secondary p-2">No Users found</div>';
		}

		foreach($users as $emp){
			echo '
		<div class="card mb-1">
			<div class="row g-0">
			<div class="col-3 my-auto p-1">
				<div class=" position-relative">
					<img src="'.base_url('storage/uploads/images/'.(empty($emp->image) ? 'user.png' : $emp->image)).'" style="width: 100px; height: 50px; border-radius: 50%;" class="img-fluid" alt="Employee">
					<span class="position-absolute p-1 bg-success border border-white rounded-circle d-none" style="right:0">
						<span class="visually-hidden">New alerts</span>
					</span>
				</div>
			</div>
			<div class="col my-auto ps-2">
				<strong class="card-title">'.$emp->name.'</strong>
				<small class="d-block py-0 text-muted d-none">Yes</small>
			</div>
			<div class="col-auto my-auto pe-2">
			<button type="button" onclick="loadchat('.$emp->id.')" class="btn btn-sm btn-none p-0 stretched-link"><span class="badge rounded-pill text-white bg-success d-none">13</span></button>
			</div>
			</div>
		</div>

		';
		//<small class="d-block py-0 text-success">Typing...</small>
		}


	}

	public function loadchatajax(){

		if(!array_key_exists('user_id', $_POST)){
			return NULL;
		}
		$emp = $this->users_model->getUser($_POST['user_id']);

		$all_chats = $this->users_model->getMessages($_POST['user_id'], $this->session->userdata('a_user_id'));
		
		$output = '';
        $date_before = '';
        //$clearfix = ' class="clearfix"';
		if(empty($all_chats)){
			$output .= '<div class="col-12 text-center"><div class="px-2 d-inline-block text-muted bg-light small">No chats to show</div></div>';
		}
        foreach($all_chats as $c){

            //mesage li starts
            //$output .= '<li'.$clearfix.'>';
            //$clearfix = '';
            $time = new DateTime($c->added_on);

            $date_this = $time->format('Y-m-d');
            // Use comparison operator to
            // compare dates
            if ($date_this != $date_before){
                //change and update dates
                /*$output .= '
                    <div class="message-data float-start fw-bold mb-2 mt-4">
                        <span class="message-data-time">'.$time->format('M d, Y').'</span>
                    </div>
                ';*/
				$output .= '<div class="col-12 text-center"><div class="px-2 d-inline-block text-muted bg-light small">'.$time->format('M d, Y').'</div></div>';
                $date_before = $date_this;
            }

            

            if($c->from_id == $this->session->userdata('a_user_id')){
                //my message
                /*$output .= '
                <div class="alert alert-primary ms-5" role="alert">
                '.$c->message_body.'
                <div class="small border-top border-light mt-2 pt-1 text-end text-muted">'.$time->format('M d, Y H:i A').'</div>
                </div>
                ';*/
                /*$output .= '
                <div class="message my-message float-end">
                    '.$c->message_body.'
                </div>
                <div class="message-data float-end">
                    <span class="message-data-time">'.$time->format('H:i A').'</span>
                </div>
                ';*/
				//right one
				$output .= '<div class="col-12 text-end"><div class="p-2 d-inline-block bg-primary text-white">'.$c->message_body.'</div></div>
				<div class="col-12 text-end text-muted" style="font-size:9px">'.$time->format('H:i A').'</div>';
            }else{
                /*$output .= '
            <div class="alert alert-secondary me-5" role="alert">
            '.$c->message_body.'
            <div class="small border-top border-light mt-2 pt-1 text-end text-muted">'.$time->format('M d, Y H:i A').'</div>
            </div>
            ';*/
                /*$output .= '
                <div class="message other-message float-start">
                    '.$c->message_body.'
                </div>
                <div class="message-data float-start">
                    <span class="message-data-time">'.$time->format('H:i A').'</span>
                </div>
                ';*/
				//left one
				$output .= '<div class="col-12"><div class="p-2 d-inline-block bg-light">'.$c->message_body.'</div></div>
				<div class="col-12 text-muted" style="font-size:9px">'.$time->format('H:i A').'</div>';
            }

            $output .= '';
        }
		
		echo '
		<div class="card mb-1">
			<div class="card-header p-1">
				<div class="row g-0">
				<div class="col-1 my-auto p-1">
					<div class=" position-relative">
						<img src="'.base_url('storage/uploads/images/'.(empty($emp->image) ? 'user.png' : $emp->image)).'" style="width: 100px; height: 50px; border-radius: 50%;" class="img-fluid" alt="Employee">
						<span style="right:0px" class="position-absolute p-1 bg-success border border-white rounded-circle">
							<span class="visually-hidden">New alerts</span>
						</span>
					</div>
				</div>
				<div class="col my-auto ps-2">
					<strong class="card-title">'.$emp->name.'</strong>
					<small id="is_typing_'.$_POST['user_id'].'" class="typing d-block py-0 text-success"></small>
				</div>
				<div class="col-auto my-auto pe-2">
				<button type="button" class="btn btn-none p-0"><i class="las la-ellipsis-v"></i></button>
				</div>
				</div>
			</div>
			<!--<div class="card-body">

			<div id="chat_box_body" class="row g-0">
				<div class="col-12 text-center"><div class="px-2 d-inline-block text-muted bg-light small">TODAY</div></div>

				<div class="col-12"><div class="p-2 d-inline-block bg-light">Hello</div></div>
				<div class="col-12 text-muted" style="font-size:9px">10:30PM</div>
				
				<div class="col-12 text-end"><div class="p-2 d-inline-block bg-primary text-white">hi there</div></div>
				<div class="col-12 text-end text-muted" style="font-size:9px">11:30PM</div>
			</div>
			


			
			</div>-->

			<div class="card-body">
			<div id="chat_box_body" class="row g-0">'.$output.'</div>
			</div>

			<div class="card-footer bg-white p-0 border-0">

				

				
				<div class="row g-0">
					<div class="col-md col-12 text-danger small"><input type="text" id="message_body" name="message_body" class="form-control rounded-0" rows="1" placeholder="Enter your Message here" oninput="typing('.$this->session->userdata('a_user_id').', '.$_POST['user_id'].')" /></div>
					<input type="hidden" id="from_id" name="from_id" value="'.$this->session->userdata('a_user_id').'" />
            		<input type="hidden" id="to_id" name="to_id" value="'.$_POST['user_id'].'" />
					<div class="col-auto ms-auto"><button onclick="send_message()" class="btn btn-primary rounded-0" type="button"><i class="las la-paper-plane"></i></button></div>
				</div>
			</div>
		</div>

		';
	}

	public function loadchatbodyajax(){

		if(!array_key_exists('user_id', $_POST)){
			return NULL;
		}
		$emp = $this->users_model->getUser($_POST['user_id']);

		$all_chats = $this->users_model->getMessages($_POST['user_id'], $this->session->userdata('a_user_id'));
		
		$output = '';
        $date_before = '';
        //$clearfix = ' class="clearfix"';
		if(empty($all_chats)){
			$output .= '<div class="col-12 text-center"><div class="px-2 d-inline-block text-muted bg-light small">No chats to show</div></div>';
		}
        foreach($all_chats as $c){

            //mesage li starts
            //$output .= '<li'.$clearfix.'>';
            //$clearfix = '';
            $time = new DateTime($c->added_on);

            $date_this = $time->format('Y-m-d');
            // Use comparison operator to
            // compare dates
            if ($date_this != $date_before){
                //change and update dates
				$output .= '<div class="col-12 text-center"><div class="px-2 d-inline-block text-muted bg-light small">'.$time->format('M d, Y').'</div></div>';
                $date_before = $date_this;
            }

            

            if($c->from_id == $this->session->userdata('a_user_id')){
                //my message
				//right one
				$output .= '<div class="col-12 text-end"><div class="p-2 d-inline-block bg-primary text-white">'.$c->message_body.'</div></div>
				<div class="col-12 text-end text-muted" style="font-size:9px">'.$time->format('H:i A').'</div>';
            }else{
				//left one
				$output .= '<div class="col-12"><div class="p-2 d-inline-block bg-light">'.$c->message_body.'</div></div>
				<div class="col-12 text-muted" style="font-size:9px">'.$time->format('H:i A').'</div>';
            }

            $output .= '';
        }
		
		echo $output;
	}

	public function valueExistsInArray($array, $value){
		if (!$this->user->isLogged()){
			return NULL;
		}
		$exists = false; // Flag to track if value exists
		array_walk_recursive($array, function($item) use ($value, &$exists) {
			if ($item === $value) {
				$exists = true;
			}
		});
		return $exists;
	}

	public function addchatboxajax(){
		//print_r($_SESSION);
		

		if(!array_key_exists('driver_id', $_POST)){
			return NULL;
		}

		if(!array_key_exists('chat_window_drivers', $_SESSION)){
			$_SESSION['chat_window_drivers'] = array();
		}

		$posted_driver_id = $_POST['driver_id'];
		//add this to open tabs list
		//check if already exists
		//print_r($_SESSION['chat_window_drivers']);
		if($this->valueExistsInArray($_SESSION['chat_window_drivers'], $posted_driver_id) == false && $posted_driver_id > 0){
			$_SESSION['chat_window_drivers'][] = array('driver_id' => $posted_driver_id, 'window_status' => 1);
		}

		//loop all windows
		for($i=0;$i<count($_SESSION['chat_window_drivers']);$i++){
			//each window
			$driver_id = $_SESSION['chat_window_drivers'][$i]['driver_id'];
			$chat_window_status = $_SESSION['chat_window_drivers'][$i]['window_status'];
			//fetch user details
			$driver_data = $this->users_model->getUser($driver_id);

			//prepare name
			$name = $driver_data->name;
			$roundedName = (strlen($name) > 15) ? substr($name, 0, 12) . '...' : $name;

			//prepare image
			$image = 'user.png';
			if(strlen($driver_data->image) && file_exists(base_url('storage/uploads/images/'.$driver_data->image))){
				$image = $driver_data->image;
			}
			//echo $driver_data->image;
			echo '

				<div id="chat_'.$driver_id.'" class="card">
				<div class="card-header bg-light px-2">
				<div class="row gx-2">
					<div class="col-auto my-auto">
						<div class=" position-relative">
							<img src="'.base_url('storage/uploads/images/'.$image).'" style="border-radius:50%;max-width:28px" alt="Driver">
							<span class="position-absolute p-1 bg-success border border-white rounded-circle" style="right:-5px">
								<span class="visually-hidden">New alerts</span>
							</span>
						</div>
					</div>

					

					<div id="title_minus_'.$driver_id.'" class="col fw-bold cursor-pointer" onclick="minimize('.$driver_id.')">'.$roundedName.'</div>
					<div id="title_plus_'.$driver_id.'" style="display:none" class="col fw-bold cursor-pointer" onclick="maximize('.$driver_id.')">'.$roundedName.'</div>
					

				<div class="col-auto">
				

				<button id="chat_minus_'.$driver_id.'" type="button" class="btn btn-none p-0" onclick="minimize('.$driver_id.')"><i class="las la-minus"></i></button>
				<button id="chat_plus_'.$driver_id.'" style="display:none" type="button" class="btn btn-none p-0" onclick="maximize('.$driver_id.')"><i class="las la-plus"></i></button>
				
				<button onclick="enlargechat('.$driver_id.', \''.admin_url('users/chatroom/'.$driver_id).'\')" class="btn btn-none p-0"><i class="las la-expand mx-2"></i></button>
				<button id="chat_close_'.$driver_id.'" type="button" class="btn btn-none p-0" onclick="removewindow('.$driver_id.')"><i class="las la-times"></i></button>
				</div>
				</div>

				</div><!--card header ends-->';

		//chat body starts
		echo '<div class="card-body px-3 py-2 chatbody" id="chat_body_'.$driver_id.'">';
		$all_chats = $this->users_model->getMessages($driver_id, $this->session->userdata('a_user_id'));
		
		$output = '';
        $date_before = '';
        //$clearfix = ' class="clearfix"';
		if(empty($all_chats)){
			echo '<div class="col-12 text-center"><div class="px-2 d-inline-block text-muted bg-light small">No chats to show</div></div>';
		}else{
			/*echo '
					
			<div class="alert alert-light p-0 mx-0 mb-2 text-center fw-bold small">Wednesday, Oct 12, 2023</div>

			<div class="row">
				<div class="col-auto px-0"><img src="'.base_url('storage/uploads/images/'.(empty($emp->image) ? 'user1.jpeg' : $emp->image)).'" style="border-radius:50%;max-width:20px" alt="Employee"></div>
				<div class="col">
				<strong>Arnold</strong>
				<p class="text-muted my-0 small">10:36</p>
				<p>Hello Sir, how are you?</p>
				</div><!--col ends, this contains name time and chat text-->
			</div><!--row ends-->


			<div class="row">
				<div class="col-auto px-0"><img src="'.base_url('storage/uploads/images/'.(empty($emp->image) ? 'user.png' : $emp->image)).'" style="border-radius:50%;max-width:20px" alt="Employee"></div>
				<div class="col">
				<strong>Admin</strong>
				<p class="text-muted my-0 small">10:37</p>
				<p>Hello, i am going great!! How are you?</p>
				</div><!--col ends, this contains name time and chat text-->
			</div><!--row ends-->



			<div class="alert alert-light p-0 mx-0 mb-2 text-center fw-bold small">Thursday, Oct 13, 2023</div>

			<div class="row">
				<div class="col-auto px-0"><img src="'.base_url('storage/uploads/images/'.(empty($emp->image) ? 'user1.jpeg' : $emp->image)).'" style="border-radius:50%;max-width:20px" alt="Employee"></div>
				<div class="col">
				<strong>Andrew</strong>
				<p class="text-muted my-0 small">10:36</p>
				<p>Hello Sir, how are you?</p>
				</div><!--col ends, this contains name time and chat text-->
			</div><!--row ends-->


			<div class="row">
				<div class="col-auto px-0"><img src="'.base_url('storage/uploads/images/'.(empty($emp->image) ? 'user.png' : $emp->image)).'" style="border-radius:50%;max-width:20px" alt="Employee"></div>
				<div class="col">
				<strong>Admin</strong>
				<p class="text-muted my-0 small">10:37</p>
				<p>Hello, i am going great!! How are you?</p>
				</div><!--col ends, this contains name time and chat text-->
			</div><!--row ends-->

			';*/
			//mesage li starts
            //$output .= '<li'.$clearfix.'>';
            //$clearfix = '';
			foreach($all_chats as $c){
				$time = new DateTime($c->added_on);

				$date_this = $time->format('Y-m-d');
				// Use comparison operator to
				// compare dates
				if ($date_this != $date_before){
					//change and update dates
					echo '<div class="col-12 text-center"><div class="px-2 d-inline-block text-muted bg-light small">'.$time->format('M d, Y').'</div></div>';
					$date_before = $date_this;
				}

				

				if($c->from_id == $this->session->userdata('a_user_id')){
					//my message
					//right one
					echo '<div class="col-12 text-end"><div class="p-2 d-inline-block bg-primary text-white">'.$c->message_body.'</div></div>
					<div class="col-12 text-end text-muted" style="font-size:9px">'.$time->format('H:i A').'</div>';
				}else{
					//left one
					echo '<div class="col-12"><div class="p-2 d-inline-block bg-light">'.$c->message_body.'</div></div>
					<div class="col-12 text-muted" style="font-size:9px">'.$time->format('H:i A').'</div>';
				}

			}//forreach all chats ends
            

		}//empty else ends
		




		echo '</div><!--card body ends-->';

		//chat footer
		echo '<div class="card-footer bg-white p-0 border-0" id="chat_footer_'.$driver_id.'">

					<div id="is_typing_'.$driver_id.'" class="typing"></div>

					
					<input type="hidden" id="from_id_'.$driver_id.'" name="from_id_'.$driver_id.'" value="'.$this->session->userdata('a_user_id').'" />
					<input type="hidden" id="to_id_'.$driver_id.'" name="to_id_'.$driver_id.'" value="'.$driver_id.'" />
					<div class="row g-0">
						<div class="col-md col-12 text-danger small"><input type="text" id="message_body_'.$driver_id.'" name="message_body_'.$driver_id.'" class="form-control rounded-0" rows="1" placeholder="Enter your Message here" oninput="typing('.$this->session->userdata('a_user_id').', '.$driver_id.')"></div>
						<div class="col-auto ms-auto"><button onclick="send_message('.$driver_id.')" class="btn btn-primary rounded-0" type="button"><i class="las la-paper-plane"></i></button></div>
					</div>
				</div><!--card footer ends-->
				</div><!--card ends-->

			';
		}//each window for loop ends

		
	}

	public function removechatboxajax(){
		if (!$this->user->isLogged()){
			return NULL;
		}

		if(!array_key_exists('driver_id', $_POST) || !array_key_exists('chat_window_drivers', $_SESSION)){
			return NULL;
		}
		$array = $_SESSION['chat_window_drivers'];

		//find the key
		for($i=0;$i<count($array);$i++){
			if($array[$i]['driver_id'] == $_POST['driver_id']){
				//item found, remove it
				unset($array[$i]);
				$_SESSION['chat_window_drivers'] = array_values($array);
			}
		}
	}

	public function updatechatwindowstatusajax(){
		if (!$this->user->isLogged()){
			return NULL;
		}

		if(!array_key_exists('driver_id', $_POST) || !array_key_exists('chat_window_drivers', $_SESSION)){
			return NULL;
		}
		$array = $_SESSION['chat_window_drivers'];

		//find the key
		for($i=0;$i<count($array);$i++){
			if($array[$i]['driver_id'] == $_POST['driver_id']){
				//item found, update window status
				$array[$i]['window_status'] = $_POST['window_status'];
				$_SESSION['chat_window_drivers'] = array_values($array);
			}
		}
	}

	public function replychat(){
		if (!$this->user->isLogged()){
			return NULL;
		}
        $this->users_model->replyChat($_POST);
    }

    public function addtyping(){
		if (!$this->user->isLogged()){
			return NULL;
		}
        $this->users_model->addTyping($_POST);
    }

    public function removetyping(){
		if (!$this->user->isLogged()){
			return NULL;
		}
        $this->users_model->removeTyping($_POST);
    }

    public function checktyping(){
		if (!$this->user->isLogged()){
			return NULL;
		}
        echo $this->users_model->checkTyping($_POST);
    }

    public function refreshchat(){
		if (!$this->user->isLogged()){
			return NULL;
		}
        echo $this->users_model->checkIfChatUpdateRequired($_POST);
    }

	public function broadcast(){
		if (!$this->user->isLogged()){
			return NULL;
		}
		//print_r($_POST);
		//Array ( [broadcast_message] => asdasdasd ) 
		$this->users_model->broadcastMessage($_POST['broadcast_message']);
		redirect(admin_url('users/chatroom'));
	}

	public function scorecards(){
		$data = array();
		// Get the current year (according to the ISO-8601 standard)
		$data['currentYear'] = date("o");
		// Get the current week number (according to the ISO-8601 standard)
		$data['currentWeek'] = (int)date("W");

		$this->template->view('scorecards', $data);
	}

	public function getDatesOfWeek($year, $weekNumber) {
		$result = [];
	
		// Create a new DateTime object and set it to the first day of the specified week
		$date = new DateTime();
		$date->setISODate($year, $weekNumber);
		//make it sunday
		$date->modify('-1 day');
	
		// Iterate through the next 7 days to get all dates of the week
		for ($i = 0; $i < 7; $i++) {
			// Add the date to the result array
			$result[] = $date->format('d-M');
	
			// Move to the next day
			$date->add(new DateInterval('P1D'));
		}
	
		return $result;
	}

	public function loadscorecardtable(){
		$html = '';
		$scorecard_modal = '';
		$drivers = $this->users_model->getActiveUsers();
		//print_r($drivers);
		// Example usage
		$year = $_POST['year'];
		$weekNumber = $_POST['week'];
		$datesOfWeek = $this->getDatesOfWeek($year, $weekNumber);
		

		$html.= '
		<table id="datatable" class="table" width="100%">
		<thead>';

		$html.= '<tr class="fw-bold"><td>#</td><td>Name</td><td>Deliveries</td><td>Ranking</td><td>Overall Tier</td><td>Bonus Tier</td><td width="80px">Download</td></tr>';

		

		$html.= '</thead>
		<tbody>';

		$c = 1;

		foreach($drivers as $d){
			//fetch scorecard data
			$scorecard_data = $this->users_model->getScorecard($d->id, $weekNumber, $year);
			//print_r($scorecard_data);die;
			
			//generate progress bar
			$progress_bar = '-';
			if(!empty($scorecard_data['overall_standing'])){
				
				switch($scorecard_data['overall_standing']){
					case 'Fantastic':
						$progress_bar = '<div class="progress">
						<div class="progress-bar progress-bar-striped bg-primary" style="width: 100%">FANTASTIC</div>
						</div>';
						break;
					case 'Great':
						$progress_bar = '<div class="progress">
						<div class="progress-bar progress-bar-striped bg-success" style="width: 100%">GREAT</div>
						</div>';
						break;
					case 'Fair':
						$progress_bar = '<div class="progress">
						<div class="progress-bar progress-bar-striped bg-warning" style="width: 100%">FAIR</div>
						</div>';
						break;
					case 'Poor':
						$progress_bar = '<div class="progress">
						<div class="progress-bar progress-bar-striped bg-danger" style="width: 100%">POOR</div>
						</div>';
						break;
				}
			}

			$bonus_amount = '';
			if(!empty($scorecard_data['id'])){
				$bonus_amount = $this->users_model->checkBonusAmount($scorecard_data['id']);
			}
			
			


			$html .= '<tr><td>'.$c++.'</td><td>'.$d->name.'</td>
			<td>'.(empty($scorecard_data['delivered_packages']) ? '-' : $scorecard_data['delivered_packages']).'</td>
			<td>'.(empty($scorecard_data['ranking']) ? '-' : $scorecard_data['ranking']).'</td>
			
			<td>
			'.$progress_bar.'
			</td>

			<td>'.((!empty($bonus_amount) && array_key_exists('tier', $bonus_amount) && $bonus_amount['bonus'] > 0) ? '<a target="_blank" href="'.admin_url('users/bonus/'.$scorecard_data['id']).'" class="btn btn-outline-success btn-sm"><i class="las la-money-bill"></i> Tier '.$bonus_amount['tier'].'</a>' : '').'</td>

			
			
			<td class="text-center d-flex">

			
			
			<button type="button" title="View" class="btn btn-sm btn-outline-dark" onclick="loadscorecardmodal('.$d->id.', '.$weekNumber.', '.$year.', '.(!empty($scorecard_data['id']) ? $scorecard_data['id'] : 0).')"><i class="las la-eye"></i></button>
			
			<form method="POST" target="_blank" action="'.admin_url('users/generate').'">
			<input type="hidden" id="driver_id" name="driver_id" value="'.$d->id.'" />
			<input type="hidden" id="week" name="week" value="'.$weekNumber.'" />
			<input type="hidden" id="year" name="year" value="'.$year.'" />
			<button type="submit" title="Download" class="btn btn-sm btn-outline-dark ms-2"><i class="las la-arrow-circle-down"></i></button>
			</form>
			
			</td></tr>';

			// data-bs-toggle="modal" data-bs-target="#scorecardModal"


			//scorecard modal generate
			

			$scorecard_modal .= '';

			
			//$_SESSION['scorecard_modal'] = $scorecard_modal;
		}
		
		




		
		$html .= '</tbody>
		</table>
		';

		//$html .= $scorecard_modal;

		echo $html;

		/*

		<tr><td>2</td><td>Anthony Michael Reed</td><td><span class="fw-normal small">NCNS</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-danger" style="font-size:11px">20:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td><span class="fw-normal small">NCNS</span></td><td><span class="fw-normal small">NCNS</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td><span class="fw-normal small">NCNS</span></td><td>4</td><td class="text-center"><div class="btn-group btn-group-sm pull-right"><a class="btn btn-outline-dark" href=""><i class="las la-eye"></i></a><a class="btn btn-outline-dark" href="#"><i class="las la-comment"></i></a></div></td></tr>
		<tr><td>3</td><td>Marco Antonio Serna</td><td><span class="fw-normal small">NCNS</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td><span class="fw-normal small">NCNS</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td>5</td><td class="text-center"><div class="btn-group btn-group-sm pull-right"><a class="btn btn-outline-dark" href=""><i class="las la-eye"></i></a><a class="btn btn-outline-dark" href="#"><i class="las la-comment"></i></a></div></td></tr>
		<tr><td>4</td><td>Nicholas Ryan Hogue</td><td><span class="fw-normal small">NCNS</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td><span class="fw-normal small">NCNS</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td><span class="fw-normal small">NCNS</span></td><td>5</td><td class="text-center"><div class="btn-group btn-group-sm pull-right"><a class="btn btn-outline-dark" href=""><i class="las la-eye"></i></a><a class="btn btn-outline-dark" href="#"><i class="las la-comment"></i></a></div></td></tr>
		<tr><td>5</td><td>Andrew David Renteria</td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td class="text-center"><div class="d-flex"><span class="text-primary" style="font-size:11px">08:31</span> - <span class="text-success" style="font-size:11px">18:00</div></span><p class="mb-0">1</p><span class="fw-normal small">LATE</span></td><td>5</td><td class="text-center"><div class="btn-group btn-group-sm pull-right"><a class="btn btn-outline-dark" href=""><i class="las la-eye"></i></a><a class="btn btn-outline-dark" href="#"><i class="las la-comment"></i></a></div></td></tr>

		*/
	}

	public function uploadweekscorecard(){

		//very important
		//print_r($_POST);
		//print_r($_FILES);
		$scorecard_id = $scorecard_count = 0;
		$driver_not_found = 0;

		$_SESSION['message'] = '';

		// Check if a file was uploaded without errors
		if(isset($_FILES['scorecard_file']) && $_FILES['scorecard_file']['error'] === UPLOAD_ERR_OK) {
			// Get the temporary file name
			$tmpFile = $_FILES['scorecard_file']['tmp_name'];

			// Open the temporary file for reading
			$csvFile = fopen($tmpFile, 'r');

			if ($csvFile == false){
				$_SESSION['message'] .= '<div class="alert alert-danger text-white mb-2" role="alert"><strong>Error!</strong> Unable to open/ read file</div>';
			}else{
				//check if file is CSV also number of columns
				$extension = pathinfo($_FILES['scorecard_file']['name'], PATHINFO_EXTENSION);
				//echo strtolower($extension);
				//die;
				$first_row = fgetcsv($csvFile);
				//echo count($first_row);die;
				if(strtolower($extension) !== 'csv' || count($first_row) !== 37){
					//invalid file format
					$_SESSION['message'] .= '<div class="alert alert-danger text-white mb-2" role="alert"><strong>Error!</strong> Invalid file format</div>';
				}else{
					//start reading file
					// Read the CSV headers - not required as its already read in previous line
					//$headers = fgetcsv($csvFile);

					// Initialize an empty array to store the data
					$data = [];

					// Read the remaining rows
					while (($row = fgetcsv($csvFile)) !== false) {
						// Push each row into the data array
						$data[] = $row;
					}

					// Close the file pointer
					fclose($csvFile);

					// Output the data
					/*echo "<pre>";
					print_r($headers); // Print headers
					print_r($data);    // Print data
					echo "</pre>";die;*/
					$ranking = 1;
					foreach($data as $d){
						//echo $d[1];
						//read each line for entry
						//first check if week exists for driver
						$driver = $this->users_model->getUserByUsername($d[1]);
						//print_r($driver);die;

						//create driver if not found/ exists
						if(empty($driver)){
							$tmp_driver_data=array(
								"name"=>$d[1],
								"password"=>md5(1234),
								"show_password"=>1234,
								"email"=>time().$ranking.'@tntmail.com',
								"status" => 1,	
								"user_group_id" => 2,
								//"template_file"=>$this->input->post('template_file'),
								"activated" => 1
							);
							$driver_id = $this->users_model->addUser($tmp_driver_data);
							$driver = $this->users_model->getUserByUsername($d[1]);
						}
						

						if(!empty($driver)){
							//driver exists
							$t_week = explode('-', $d[0]);
							$no_data_exists = $this->users_model->noScorecardExists($driver->id, $t_week[1], $t_week[0]);

							if($no_data_exists && $driver->id > 0){
								//enter data to DB for that driver and week
								$insert_data = array();
								$insert_data['driver_id'] = $driver->id;
								$insert_data['week_number'] = $t_week[1];
								$insert_data['year_number'] = $t_week[0];
								$insert_data['transporter_id'] = $d[2];
								$insert_data['ranking'] = $ranking++;
								$insert_data['overall_standing'] = $d[3];
								$insert_data['delivered_packages'] = $d[4];
								$insert_data['key_focus_areas'] = $d[5];
								$insert_data['onroad_safety_score'] = $d[6];
								$insert_data['overall_quality_score'] = $d[7];
								$insert_data['fico'] = $d[8];
								$insert_data['acceleration'] = $d[9];
								$insert_data['braking'] = $d[10];
								$insert_data['cornering'] = $d[11];
								$insert_data['distraction'] = $d[12];
								$insert_data['seatbelt_off_rate'] = $d[13];
								$insert_data['speeding'] = $d[14];
								$insert_data['speeding_event_rate'] = $d[15];
								$insert_data['distractions_rate'] = $d[16];
								$insert_data['looking_at_phone'] = $d[17];
								$insert_data['talking_on_phone'] = $d[18];
								$insert_data['looking_down'] = $d[19];
								$insert_data['following_distance_rate'] = $d[20];
								$insert_data['sign_signal_violations_rate'] = $d[21];
								$insert_data['stop_sign_violations'] = $d[22];
								$insert_data['stop_light_violations'] = $d[23];
								$insert_data['illegal_u_turns'] = $d[24];
								$insert_data['cdf'] = $d[25];
								$insert_data['dcr'] = $d[26];
								$insert_data['dsb'] = $d[27];
								$insert_data['swc_pod'] = $d[28];
								$insert_data['swc_cc'] = $d[29];
								$insert_data['swc_ad'] = $d[30];
								$insert_data['dnrs'] = $d[31];
								$insert_data['shipments_zone_hour'] = $d[32];
								$insert_data['pod_opps'] = $d[33];
								$insert_data['cc_opps'] = $d[34];
								$insert_data['customer_escalation_defect'] = $d[35];
								$insert_data['customer_delivery_feedback'] = $d[36];


								$scorecard_id = $this->users_model->addScorecard($insert_data);
								if($scorecard_id > 0){
									$scorecard_count += 1;
								}
							}else{
								$_SESSION['message'] .= '<div class="alert alert-danger text-white mb-2" role="alert"><strong>Error!</strong> Data already exists</div>';
							}
						}else{
							/*$driver_not_found += 1;
							//insert that driver to temporary location table
							$this->users_model->addTempDriver($d[1]);*/
							//NEW CODE
							//create the driver and import scorecard
						}
						
						//echo ;
						//[0] => 2023-37
						//[1] => Shawniki Lynette Taylor

					}
				}//file reading success ends
			}//$csvFile == true else part ends
		} else {
			$_SESSION['message'] .= '<div class="alert alert-danger text-white mb-2" role="alert"><strong>Error!</strong> Unable to upload file</div>';
		}

		if($driver_not_found > 0){
			$_SESSION['message'] .= '<div class="alert alert-danger text-white mb-2" role="alert"><a href="'.admin_url('users/tempdrivers').'" class="text-white text-decoration-none"><strong>Error!</strong> '.$driver_not_found.' Driver(s) not found. Click here to Approve/ Deny.</a></div>';
		}
		
		if($scorecard_id > 0){
			$_SESSION['message'] .= '<div class="alert alert-success text-white mb-2" role="alert"><strong>Success!</strong> '.$scorecard_count.' Scorecard(s) uploaded successfully</div>';
		}

		

		redirect(admin_url('users/scorecards'));

	}

	public function loadscorecardmodalbody($pdf = FALSE){
		$driver_data = $this->users_model->getUser($_POST['driver_id']);
		$scorecard_data = $this->users_model->getScorecard($_POST['driver_id'], $_POST['week'], $_POST['year']);

		$output = '';

		if(empty($scorecard_data)){
			$output = '<div class="alert alert-danger text-white" role="alert">No Scorecard available</div>';
		}else{
			if($pdf == TRUE){
				$output = '
				<div class="row g-2">
					<div class="col-12" style="border: 1px solid black;padding:10px;margin-bottom:10px">
						<div class="card bg-light">
						<div class="card-body">
							<h4>'.$driver_data->name.'</h4>
							<p class="text-muted mb-0">TNTL</p>
							<p class="mb-0">Week '.$_POST['week'].', '.$_POST['year'].'</p> Deliveries: '.$scorecard_data['delivered_packages'].'
						</div>
						</div>
					</div>
					<div class="col-12" style="border: 1px solid black;padding:10px;margin-bottom:10px">
						<div class="card bg-dark text-white">
						<div class="card-body">
							<p class="mb-0 fw-bold">Overall Tier</p>
							<h3>'.$scorecard_data['overall_standing'].'</h3>
							
						</div>
						</div>
					</div>
					<div class="col-12" style="border: 1px solid black;padding:10px;margin-bottom:10px">
						<div class="card bg-dark text-white">
						<div class="card-body">
							<p class="mb-0">Ranking</p>
							<h3>'.$scorecard_data['ranking'].'</h3>
						</div>
						</div>
					</div>
				</div>
				<!--row ends-->';
			}else{
				$output = '
				<div class="row g-2">
					<div class="col-6">
						<div class="card bg-light">
						<div class="card-body">
							<h4>'.$driver_data->name.'</h4>
							<p class="text-muted mb-0">TNTL</p>
							<p class="mb-0">Week '.$_POST['week'].', '.$_POST['year'].'</p> Deliveries: '.$scorecard_data['delivered_packages'].'
						</div>
						</div>
					</div>
					<div class="col">
						<div class="card bg-dark text-white">
						<div class="card-body text-center">
							<i class="las la-3x la-chart-area"></i>
							<h3>'.$scorecard_data['overall_standing'].'</h3>
							<p class="mb-0">Overall Tier</p>
						</div>
						</div>
					</div>
					<div class="col">
						<div class="card bg-dark text-white">
						<div class="card-body text-center">
							<i class="las la-3x la-trophy"></i>
							<h3>'.$scorecard_data['ranking'].'</h3>
							<p class="mb-0">Ranking</p>
						</div>
						</div>
					</div>
				</div>
				<!--row ends-->';
			}
			


			$output .= '<div class="mt-2 row g-2">
				<div class="col m-0">
					<div class="row g-2">
					<div class="col-12">
						<div class="card">
						<div class="card-header">
							<i class="las la-shield-alt"></i> Driving Safety
						</div>
						<div class="card-body">
							<p class="card-text">Looks like you dont have any driving safety events. <br />Keep up the great work! </p>
						</div>
						</div>
					</div>



					<div class="col-12">
					<div class="card">
					  <div class="card-header">
						  
							<div class="d-flex align-items-center justify-content-between">
								<div><i class="las la-shield-alt"></i> Driving Safety</div>
								
							</div>
					  </div>
					  <div class="card-body">
						<!--<p class="card-text">Looks like you dont have any driving safety events.<br/>Keep up the great work!</p>-->
						<table class="table table-sm small">
					
						<tr><th>FICO</th><td class="text-end">'.$scorecard_data['fico'].'</td></tr>
						<tr><th>Acceleration</th><td class="text-end">'.$scorecard_data['acceleration'].'</td></tr>
						<tr><th>Braking</th><td class="text-end">'.$scorecard_data['braking'].'</td></tr>
						<tr><th>Cornering</th><td class="text-end">'.$scorecard_data['cornering'].'</td></tr>
						<tr><th>Distraction</th><td class="text-end">'.$scorecard_data['distraction'].'</td></tr>
						<tr><th>Seatbelt-Off Rate</th><td class="text-end">'.$scorecard_data['seatbelt_off_rate'].'</td></tr>
					
						<tr><th>Speeding</th><td class="text-end">'.$scorecard_data['speeding'].'</td></tr>
						<tr><th>Speeding Event Rate</th><td class="text-end">'.$scorecard_data['speeding_event_rate'].'</td></tr>
						<tr><th>Distractions Rate</th><td class="text-end">'.$scorecard_data['distractions_rate'].'</td></tr>
						<tr><th>Looking at Phone</th><td class="text-end">'.$scorecard_data['looking_at_phone'].'</td></tr>
						<tr><th>Talking on Phone</th><td class="text-end">'.$scorecard_data['talking_on_phone'].'</td></tr>
						<tr><th>Looking Down</th><td class="text-end">'.$scorecard_data['looking_down'].'</td></tr>
						<tr><th>Following Distance Rate</th><td class="text-end">'.$scorecard_data['following_distance_rate'].'</td></tr>
					
						<tr><th>Sign/ Signal Violations Rate</th><td class="text-end">'.$scorecard_data['sign_signal_violations_rate'].'</td></tr>
						<tr><th>Stop Sign Violations</th><td class="text-end">'.$scorecard_data['stop_sign_violations'].'</td></tr>
						<tr><th>Stop Light Violations</th><td class="text-end">'.$scorecard_data['stop_light_violations'].'</td></tr>
						<tr><th>Illegal U-Turns</th><td class="text-end">'.$scorecard_data['illegal_u_turns'].'</td></tr>
					
						</table>
					  </div>
					</div>
					</div>



					
					<div class="col-12">
						<div class="card">
						<div class="card-header">
							<i class="las la-chart-line"></i> Productivity
						</div>
						<div class="card-body">
							<p class="card-text">Weekly productivity results.</p>
						</div>
						</div>
					</div>
					</div>
					<!--inenr row ends left side for 2 cards-->
				</div>
				<div class="col mt-0">



						<div class="col-12 mb-2">
						<div class="card">
						<div class="card-header">
							<i class="las la-check-square"></i> Delivery Quality
						</div>
						<div class="card-body">

							<table class="table table-sm small">
							<tr><th>Completion Rate</th><td class="text-end">-</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
							<tr><th>Photo-On-Delivery Compliance</th><td class="text-end">-</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
							<tr><th>Photo-On-Delivery Rejects</th><td class="text-end">-</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
							<tr><th>Human in Photo</th><td class="text-end">-</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
							<tr><th>Contact Compliance</th><td class="text-end">-</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
							</table>
							
						</div>
						</div>
					</div>









					<div class="card">
					<div class="card-header">
						<i class="las la-grin"></i> Customer Feedback
					</div>
					<div class="card-body">




						<table class="table table-sm small">
						<tr><th>Feedback Score (CDF)</th><td class="text-end">'.(floatval($scorecard_data['cdf'])*100).'%</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
						<tr><th>Tier</th><td class="text-end">'.$scorecard_data['overall_standing'].'</td><!-- <td class="d-flex justify-content-center mt-2"><div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"></div></td>--></tr>
						
						<tr><th>DCR</th><td class="text-end">'.(floatval($scorecard_data['dcr'])*100).'%</td>
						<tr><th>DSB</th><td class="text-end">'.(floatval($scorecard_data['dsb'])*100).'%</td>
						<tr><th>SWC POD</th><td class="text-end">'.(floatval($scorecard_data['swc_pod'])*100).'%</td>
						<tr><th>SWC CC</th><td class="text-end">'.(floatval($scorecard_data['swc_cc'])*100).'%</td>
						<tr><th>SWC AD</th><td class="text-end">'.(floatval($scorecard_data['swc_ad'])*100).'%</td>
					
						<tr><th>DNRS</th><td class="text-end">'.$scorecard_data['dnrs'].'</td>
						<tr><th>Shipments Zone Hour</th><td class="text-end">'.$scorecard_data['shipments_zone_hour'].'</td>
					
						<tr><th>POD OPPS</th><td class="text-end">'.$scorecard_data['pod_opps'].'</td>
						<tr><th>CC OPPS</th><td class="text-end">'.$scorecard_data['cc_opps'].'</td>
						<tr><th>Customer Escalation Defect</th><td class="text-end">'.$scorecard_data['customer_escalation_defect'].'</td>
						<tr><th>Customer Delivery Feedback</th><td class="text-end">'.(floatval($scorecard_data['customer_delivery_feedback'])*100).'%</td>
					
						</table>





						<table class="table table-sm small d-none">
						<tr>
							<th>Feedback Score (CDF)</th>
							<td class="text-end">'.(is_numeric($scorecard_data['customer_delivery_feedback']) ? ($scorecard_data['customer_delivery_feedback']*100).'%' : '-').'</td>
						</tr>
						<tr>
							<th>Tier</th>
							<td class="text-end">'.$scorecard_data['overall_standing'].'</td>
						</tr>
						<tr>
							<th>Alexa Thank-My-Driver</th>
							<td class="text-end">0</td>
						</tr>
						<tr>
							<th>No Feedback</th>
							<td class="text-end">'.($scorecard_data['delivered_packages'] - $scorecard_data['customer_escalation_defect']).'</td>
						</tr>
						<tr>
							<th colspan="2">Negative Feedback <br />No Negative Feedback - Excellent! </td>
						</tr>
						<tr>
							<th colspan="2">Positive Feedback </td>
						</tr>
						<tr>
							<th>Delivery was Great!</th>
							<td class="text-end">0</td>
						</tr>
						<tr>
							<th>Delivered with Care</th>
							<td class="text-end">0</td>
						</tr>
						<tr>
							<th>Respectful of Property</th>
							<td class="text-end">0</td>
						</tr>
						<tr>
							<th>Above &amp Beyond</th>
							<td class="text-end">0</td>
						</tr>
						<tr>
							<th>Followed Instructions</th>
							<td class="text-end">0</td>
						</tr>
						<tr>
							<th>Friendly</th>
							<td class="text-end">0</td>
						</tr>
						</table>
					</div>
					</div>
				</div>
			</div>
			<!--row ends-->
			';


			/*
			<table class="table table-sm small d-none">
			<tr>
				<th>Completion Rate</th>
				<td class="text-end">'.(is_numeric($scorecard_data['dcr']) ? ($scorecard_data['dcr']*100).'%' : '-').'</td>
			</tr>
			<tr>
				<th>Photo-On-Delivery Compliance</th>
				<td class="text-end">'.(is_numeric($scorecard_data['swc_pod']) ? ($scorecard_data['swc_pod']*100).'%' : '-').'</td>
			</tr>
			<tr>
				<th>Photo-On-Delivery Rejects</th>
				<td class="text-end">'.(is_numeric($scorecard_data['cc_opps']) ? $scorecard_data['cc_opps'] : '-').'/'.(is_numeric($scorecard_data['pod_opps']) ? $scorecard_data['pod_opps'] : '-').'</td>
			</tr>
			<tr>
				<th>Human in Photo</th>
				<td class="text-end">0</td>
			</tr>
			<tr>
				<th>Contact Compliance</th>
				<td class="text-end">'.(is_numeric($scorecard_data['swc_cc']) ? ($scorecard_data['swc_cc']*100).'%' : '-').'</td>
			</tr>
			</table>*/
		}

		if($pdf == FALSE){
			echo $output;
		}else{
			return $output;
		}
		
	}

	public function bonus(){
		$data = array();
		$scorecard_id = $this->uri->segment(4);
		$data['scorecard_data'] = $this->users_model->getScorecardbyID($scorecard_id);
		$data['driver_data'] = (array) $this->users_model->getUser($data['scorecard_data']['driver_id']);

		$data['bonus_data'] = $this->users_model->bonusConditions();
		$data['bonus_amount'] = $this->users_model->checkBonusAmount($scorecard_id);
		//echo $scorecard_id;die;
		$this->template->view('bonus', $data);
	}

	

	protected function validateForm() {
		$user_id=$this->uri->segment(3);
		
		$regex = "(\/?([a-zA-Z0-9+\$_-]\.?)+)*\/?"; // Path
      $regex .= "(\?[a-zA-Z+&\$_.-][a-zA-Z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
      $regex .= "(#[a-zA-Z_.-][a-zA-Z0-9+\$_.-]*)?"; // Anchor 
		$rules=array(
			
			'password' => array(
				'field' => 'password', 
				'label' => 'Password', 
				'rules' => 'trim|required|max_length[100]'
			),
		);
		$this->form_validation->set_rules($rules);
		$this->form_validation->set_rules('email', 'Email', 'required|callback_email_check');
		if ($this->form_validation->run() == TRUE)
		{
			return true;
    	}
		else
		{
			$this->error['warning']=$this->lang->line('error_warning');
			return false;
    	}
		return !$this->error;
	}


	
	public function email_check($email){
      
		$User = $this->users_model->getUserByEmail($email);
		
    	if(empty($email)){
			$this->form_validation->set_message('email_check', "The Email field is required.");
			return FALSE;
		}else if(!empty($User) && $User->id != $this->uri->segment(4)){
			$this->form_validation->set_message('email_check', "This Email address is already in use.");
			return FALSE;
		}else{
         return TRUE;
      }
   }
	
	public function name_check($name, $user_id=''){
      $User = $this->users_model->getUserByUsername($name);
		
      if (!empty($User) && $User->user_id != $user_id){
            $this->form_validation->set_message('name_check', "This {field} provided is already in use.");
            return FALSE;
		}else{
         return TRUE;
      }
   }

	public function tempdrivers(){
		$data = array();
		$data['heading_title'] = 'New Driver(s) found in Scorecard';

		$data['table_body'] = '<tbody>';
		$tmp_data = $this->users_model->getallTempDrivers();

		$c = 1;

		foreach($tmp_data as $td){
			$dt = new DateTime($td->added_on);
			$data['table_body'] .= '
			<tr>
			<td>'.$c.'</td>
			<td id="approve_driver_'.$c.'">'.$td->full_name.'</td>
			<td>'.$dt->format('M d, Y H:i:s A').'</td>
			<td>
				<div class="btn-group w-100" role="group">
				<input type="hidden" id="tmp_id_'.$c.'" name="tmp_id_'.$c.'" value="'.$td->id.'">
				<button type="button" class="btn btn-sm btn-outline-success" onclick="approve_driver('.$c.')"><i class="las la-check-circle"></i> Approve</button>
				<a href="'.admin_url('users/deletetempdriver/'.$td->id).'" onclick="return confirm(\'Are you sure you want to delete this Driver?\') ? true : false;" class="btn btn-sm btn-outline-danger"><i class="las la-times-circle"></i> Deny</a>
				</div>
			</td>
			</tr>';
			$c++;
		}

		$data['table_body'] .= '</tbody>';

		$this->template->view('tempdrivers', $data);
	}

	public function approvedriver(){
		//Array ( [full_name] => Luis Alberto Magallon santiago 
		//[email_id] => santosh@g.aom [user_pwd] => santosh ) 
		$userdata=array(
			"name"=>$this->input->post('full_name'),
			"password"=>md5($this->input->post('user_pwd')),
			"show_password"=>$this->input->post('user_pwd'),
			"email"=>$this->input->post('email_id'),
			"status" => 1,	
			"user_group_id" => 2,
			//"template_file"=>$this->input->post('template_file'),
			"activated" => 1
		);

		
		$userid=$this->users_model->addUser($userdata);
		
		$res = $this->users_model->deleteTempUser($_POST['tmp_user_id']);
		
		$this->session->set_flashdata('message', 'Driver '.$this->input->post('full_name').' Created Successfully.');
		redirect(ADMIN_PATH.'/users/tempdrivers');
	}

	public function deletetempdriver(){
		//delete from temp
		$this->users_model->deleteTempUser($this->uri->segment(4));
		$this->session->set_flashdata('message', 'Driver deleted Successfully.');
		redirect(ADMIN_PATH.'/users/tempdrivers');
	}

	public function checkemailid(){
		$res = 0;
		if(array_key_exists('email_id', $_POST)){
			if(filter_var($_POST['email_id'], FILTER_VALIDATE_EMAIL)){
				
				$res = $this->users_model->emailAddressExists($_POST['email_id']);
			}else{
				$res = 50;
			}
			
		}
		
		if($res == 50){
			echo 2;//email invalid
		}else if($res > 0 && $res < 10){
			echo 1;//email exists
		}else{
			echo 0;//go ahead, it is available
		}
		
	}

   public function generate(){
	//require_once './vendor/autoload.php';
	require_once getcwd().'/app/third_party/mpdf/vendor/autoload.php';

	// Load your view file, optionally passing data if needed
	$html = $this->loadscorecardmodalbody(TRUE);//$this->load->view('your_view_file', $data, true);
	//$this->load->helper('url');
	//$html = $this->load->view('users/bonus', [], true);

	// Create an instance of the mPDF class
	$mpdf = new \Mpdf\Mpdf();

	// Write some HTML code:
	$stylesheet = file_get_contents('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
	//$mpdf->WriteHTML($html);

	$mpdf->WriteHTML($stylesheet,1);
	$mpdf->WriteHTML($html,2);

	// Output a PDF file directly to the browser
	$mpdf->Output('scorecard.pdf', 'I');


   }


   public function updategaspin(){
	   //echo $_POST['gas_pin'];
	   $this->users_model->updateGasPin($_POST['driver_id'], $_POST['gas_pin']);
	   //redirect(admin_url('users'));
   }
	
}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */