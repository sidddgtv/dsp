<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Fleet extends Admin_Controller {
	private $error = array();
	
	public function __construct(){
      parent::__construct();
		$this->load->model('fleet_model');
		$this->load->model('common/common_model');
		$this->load->model('templates/templates_model');
	}
	
	public function index(){
      	$this->lang->load('fleet');
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
		
		$totalData = $this->fleet_model->getTotalFleet();
		
		$totalFiltered = $totalData;
		
		$filter_data = array(
			'filter_search' => $requestData['search']['value'],
			'order'  		 => $requestData['order'][0]['dir'],
			'sort' 			 => intval($requestData['order'][0]['column']) ? $columns[$requestData['order'][0]['column']] : 'u.id',
			'start' 			 => $requestData['start'],
			'limit' 			 => $requestData['length']
		);
		
		$totalFiltered = $this->fleet_model->getTotalFleet($filter_data);
			
		$filteredData = $this->fleet_model->getFleets($filter_data);
		//printr($filteredData);
		
		$datatable=array();
		$count = 1;
		foreach($filteredData as $result) {
			
			// if (is_file(DIR_UPLOAD . $result->image)) {
			// 	$image = resize($result->image, 40, 40);
			// } else {
			// 	$image = resize('no_image.png', 40, 40);
			// }
			$vin =  '<strong>VIN:</strong> '.$result->vin.' <div class="link-success small" id="view-image" data-test="'.$result->id.'"><button class="btn btn-sm btn-ouline"><i class="las la-external-link-alt"></i> View Images</button></div>';
			$view = '<a class="btn btn-sm btn-outline-dark" href="'.admin_url('fleet/history/'.$result->id).'">View <span class="badge text-bg-secondary">'.$result->history.'</span></a>';
			$action  = '<div class="btn-group btn-group-sm pull-right">';
			$action .= 		'<a class="btn btn-sm btn-primary" href="'.admin_url('fleet/edit/'.$result->id).'"><i class="la la-edit"></i></i></a>';
			$action .= 		'<a class="btn btn-sm btn-warning" href="'.admin_url('fleet/view/'.$result->id).'"><i class="la la-eye"></i></i></a>';
			
			$action .=		'<a class="btn-sm btn btn-danger btn-remove" href="'.admin_url('fleet/delete/'.$result->id).'" onclick="return confirm(\'Are you sure you want to delete this Fleet?\') ? true : false;"><i class="las la-trash"></i></a>';
			$action .= '</div>';

			$datatable[]=array(
				$count++,
				//'<img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl='.$result->id.'&choe=UTF-8" width="30px" />',
				'<img src="https://api.qrserver.com/v1/create-qr-code/?data='.$result->id.'&amp;size=100x100" width="30px" />',
				
				$result->vehicle_id,
				$result->route_type,
				$vin,
				$result->notes ? $result->notes : '...',
				$result->status ? '<span class="text-success"><i class="las la-dot-circle"></i> Activated</span>':'<span class="text-danger"><i class="las la-dot-circle"></i> Deactivated</span>',
				$view,
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

	public function add(){
		$this->lang->load('fleet');
		$this->template->set_meta_title($this->lang->line('heading_title'));
		

		if ($this->input->server('REQUEST_METHOD') === 'POST'  && $this->validateForm()){	

			
			$fleetdata=array(
				"vin" => $this->input->post('vin'),
				"vehicle_name" => $this->input->post('vehicle_name'),
				"license_plate_number" => $this->input->post('license_plate_number'),
				"make_id" => $this->input->post('make_id'),
				"model_id" => $this->input->post('model_id'),
				"sub_model" => $this->input->post('sub_model'),
				"subcontractor_name" => $this->input->post('subcontractor_name'),
				"vehicle_provider_id" => $this->input->post('vehicle_provider_id'),
				"vehicle_registration_type" => $this->input->post('vehicle_registration_type'),
				"year" => $this->input->post('year'),
				"ownership_type_id" => $this->input->post('ownership_type_id'),
				"type" => $this->input->post('type'),
				"ownership_start_date" => $this->input->post('ownership_start_date'),
				"ownership_end_date" => $this->input->post('ownership_end_date'),
				"status" => $this->input->post('status'),
				"status_reason_code" => $this->input->post('status_reason_code'),
				"operational_status" => $this->input->post('operational_status'),
				"status_reason_message" => $this->input->post('status_reason_message'),
				"status_search_value" => $this->input->post('status_search_value'),
				"status_priority" => $this->input->post('status_priority'),
				"pm_stat" => $this->input->post('pm_stat'),
				"registration_expiry_date" => $this->input->post('registration_expiry_date'),
				"registered_state_id" => $this->input->post('registered_state_id'),
				"service_tier_id" => $this->input->post('service_tier_id'),
				"route_type_id" => $this->input->post('route_type_id'),
				"station_code" => $this->input->post('station_code'),
				"notes" => $this->input->post('notes'),
			);
			$fleetid=$this->fleet_model->addFleet($fleetdata, $_FILES);
			
			$this->session->set_flashdata('message', 'Fleet Saved Successfully.');
			redirect(ADMIN_PATH.'/fleet');
		}
		$this->getForm();
	}
	
	public function edit(){
		
		$this->lang->load('fleet');
		$this->template->set_meta_title($this->lang->line('heading_title'));

		$data = array();
		
		
		if($this->input->server('REQUEST_METHOD') === 'POST'  && $this->validateForm()){
			 // $file_name = time().'.pdf';//$_FILES['uploadfile']['name'];
        $file_tmp = $_FILES['fleet_file']['name'];
        $ext = pathinfo($file_tmp, PATHINFO_EXTENSION);
        
        // move_uploaded_file($file_tmp,'storage/uploads/files/'.$file_name);
			if(array_key_exists('user_edit_form', $_POST)){
				$fleet_id = $this->uri->segment(4);
				$fleetdata=array(
					"vin" => $this->input->post('vin'),
					"vehicle_name" => $this->input->post('vehicle_name'),
					"license_plate_number" => $this->input->post('license_plate_number'),
					"make_id" => $this->input->post('make_id'),
					"model_id" => $this->input->post('model_id'),
					"sub_model" => $this->input->post('sub_model'),
					"subcontractor_name" => $this->input->post('subcontractor_name'),
					"vehicle_provider_id" => $this->input->post('vehicle_provider_id'),
					"vehicle_registration_type" => $this->input->post('vehicle_registration_type'),
					"year" => $this->input->post('year'),
					"ownership_type_id" => $this->input->post('ownership_type_id'),
					"type" => $this->input->post('type'),
					"ownership_start_date" => $this->input->post('ownership_start_date'),
					"ownership_end_date" => $this->input->post('ownership_end_date'),
					"status" => $this->input->post('status'),
					"status_reason_code" => $this->input->post('status_reason_code'),
					"operational_status" => $this->input->post('operational_status'),
					"status_reason_message" => $this->input->post('status_reason_message'),
					"status_search_value" => $this->input->post('status_search_value'),
					"status_priority" => $this->input->post('status_priority'),
					"pm_stat" => $this->input->post('pm_stat'),
					"registration_expiry_date" => $this->input->post('registration_expiry_date'),
					"registered_state_id" => $this->input->post('registered_state_id'),
					"service_tier_id" => $this->input->post('service_tier_id'),
					"route_type_id" => $this->input->post('route_type_id'),
					"station_code" => $this->input->post('station_code'),
					"notes" => $this->input->post('notes'),
					
				);
				$userid=$this->fleet_model->editFleet($fleet_id,$fleetdata, $_FILES);
				
				$this->session->set_flashdata('message', 'Fleet Updated Successfully.');
				redirect(ADMIN_PATH.'/fleet');
			}
		}
		
		$this->getForm();
	}

	public function view(){
		
		$this->lang->load('fleet');
		$this->template->set_meta_title($this->lang->line('heading_title'));

		$data = array();
		
		$this->getForm();
	}
	
	public function delete(){
		
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
       	// print_r($selected);exit;
		$this->fleet_model->deleteFleet($selected);
		
		$this->fleet_model->deleteFleet($this->uri->segment(4));
		$this->session->set_flashdata('message', 'Fleet deleted Successfully.');
		redirect(ADMIN_PATH.'/fleet');
	}

	public function sendmail(){
		//$this->fleet_model->sendmailUser($this->uri->segment(4));
		$user_info = $this->fleet_model->getUser($this->uri->segment(4));
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
		$this->common_model->sg_mail('Tranton: Account Credentials', $user_info->email, $user_info->name, $mail_body, 'noreply@trantonhr.co', 'Tranton Admin');
		//die;
		$this->session->set_flashdata('message', 'Sent mail Successfully.');
		redirect(ADMIN_PATH.'/fleet');
		//$this->template->view('email',$user_info);
	}
	
	protected function getList() {
		
		//$this->template->add_package(array('datatable'),true);
      	$data['add'] = admin_url('fleet/add');
		$data['delete'] = admin_url('fleet/delete');
		$data['datatable_url'] = admin_url('fleet/search');

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

		$this->template->view('fleets', $data);
	}
	
	protected function getForm(){
		
		$this->template->add_package(array('ckeditor','colorbox','select2', 'datetimepicker'),true);
      
		
		
		$data['heading_title'] 	= $this->lang->line('heading_title');
		
		$data['text_form'] = $this->uri->segment(4) ? $this->lang->line('text_edit') : $this->lang->line('text_add');
		$data['models'] = [];
		if(isset($this->error['warning']))
		{
			$data['error'] 	= 'Please check for errors.';
		}
		
		$data['cancel'] = admin_url('fleet');

		if (($this->uri->segment(3) && !array_key_exists('user_edit_form', $_POST)) && ($this->input->server('REQUEST_METHOD') != 'POST')) {
			$fleet_info = $this->fleet_model->getFleet($this->uri->segment(4));
		}
		if ($this->input->post('vin')) {
			$data['vin'] = $this->input->post('vin');
		} elseif (!empty($fleet_info)) {
			$data['vin'] = $fleet_info->vin;
		} else {
			$data['vin'] = '';
		}
		
		if ($this->input->post('vehicle_name')) {
			$data['vehicle_name'] = $this->input->post('vehicle_name');
		} elseif (!empty($fleet_info)) {
			$data['vehicle_name'] = $fleet_info->vehicle_name;
		} else {
			$data['vehicle_name'] = '';
		}

		if ($this->input->post('license_plate_number')) {
			$data['license_plate_number'] = $this->input->post('license_plate_number');
		} elseif (!empty($fleet_info)) {
			$data['license_plate_number'] = $fleet_info->license_plate_number;
		} else {
			$data['license_plate_number'] = '';
		}
		if ($this->input->post('make_id')) {
			$data['make_id'] = $this->input->post('make_id');
		} elseif (!empty($fleet_info)) {
			$data['make_id'] = $fleet_info->make_id;
			$data['models'] = $this->fleet_model->getVehicleModelsByMakeID($data['make_id']);
		} else {
			$data['make_id'] = '';
		}
		if ($this->input->post('model_id')) {
			$data['model_id'] = $this->input->post('model_id');
		} elseif (!empty($fleet_info)) {
			$data['model_id'] = $fleet_info->model_id;
		} else {
			$data['model_id'] = '';
		}
		if ($this->input->post('sub_model')) {
			$data['sub_model'] = $this->input->post('sub_model');
		} elseif (!empty($fleet_info)) {
			$data['sub_model'] = $fleet_info->sub_model;
		} else {
			$data['sub_model'] = '';
		}
		if ($this->input->post('subcontractor_name')) {
			$data['subcontractor_name'] = $this->input->post('subcontractor_name');
		} elseif (!empty($fleet_info)) {
			$data['subcontractor_name'] = $fleet_info->subcontractor_name;
		} else {
			$data['subcontractor_name'] = '';
		}
		if ($this->input->post('vehicle_provider_id')) {
			$data['vehicle_provider_id'] = $this->input->post('vehicle_provider_id');
		} elseif (!empty($fleet_info)) {
			$data['vehicle_provider_id'] = $fleet_info->vehicle_provider_id;
		} else {
			$data['vehicle_provider_id'] = '';
		}
		if ($this->input->post('vehicle_registration_type')) {
			$data['vehicle_registration_type'] = $this->input->post('vehicle_registration_type');
		} elseif (!empty($fleet_info)) {
			$data['vehicle_registration_type'] = $fleet_info->vehicle_registration_type;
		} else {
			$data['vehicle_registration_type'] = '';
		}
		if ($this->input->post('year')) {
			$data['year'] = $this->input->post('year');
		} elseif (!empty($fleet_info)) {
			$data['year'] = $fleet_info->year;
		} else {
			$data['year'] = '';
		}
		if ($this->input->post('ownership_type_id')) {
			$data['ownership_type_id'] = $this->input->post('ownership_type_id');
		} elseif (!empty($fleet_info)) {
			$data['ownership_type_id'] = $fleet_info->ownership_type_id;
		} else {
			$data['ownership_type_id'] = '';
		}
		if ($this->input->post('type')) {
			$data['type'] = $this->input->post('type');
		} elseif (!empty($fleet_info)) {
			$data['type'] = $fleet_info->type;
		} else {
			$data['type'] = '';
		}
		if ($this->input->post('ownership_start_date')) {
			$data['ownership_start_date'] = $this->input->post('ownership_start_date');
		} elseif (!empty($fleet_info)) {
			$data['ownership_start_date'] = date('Y-m-d', strtotime($fleet_info->ownership_start_date));
		} else {
			$data['ownership_start_date'] = '';
		}
		if ($this->input->post('ownership_end_date')) {
			$data['ownership_end_date'] = $this->input->post('ownership_end_date');
		} elseif (!empty($fleet_info)) {
			$data['ownership_end_date'] = date('Y-m-d', strtotime($fleet_info->ownership_end_date));
		} else {
			$data['ownership_end_date'] = '';
		}
		if ($this->input->post('status')) {
			$data['status'] = $this->input->post('status');
		} elseif (!empty($fleet_info)) {
			$data['status'] = $fleet_info->status;
		} else {
			$data['status'] = '';
		}
		if ($this->input->post('status_reason_code')) {
			$data['status_reason_code'] = $this->input->post('status_reason_code');
		} elseif (!empty($fleet_info)) {
			$data['status_reason_code'] = $fleet_info->status_reason_code;
		} else {
			$data['status_reason_code'] = '';
		}
		if ($this->input->post('operational_status')) {
			$data['operational_status'] = $this->input->post('operational_status');
		} elseif (!empty($fleet_info)) {
			$data['operational_status'] = $fleet_info->operational_status;
		} else {
			$data['operational_status'] = '';
		}
		if ($this->input->post('status_reason_message')) {
			$data['status_reason_message'] = $this->input->post('status_reason_message');
		} elseif (!empty($fleet_info)) {
			$data['status_reason_message'] = $fleet_info->status_reason_message;
		} else {
			$data['status_reason_message'] = '';
		}
		if ($this->input->post('status_search_value')) {
			$data['status_search_value'] = $this->input->post('status_search_value');
		} elseif (!empty($fleet_info)) {
			$data['status_search_value'] = $fleet_info->status_search_value;
		} else {
			$data['status_search_value'] = '';
		}
		if ($this->input->post('status_priority')) {
			$data['status_priority'] = $this->input->post('status_priority');
		} elseif (!empty($fleet_info)) {
			$data['status_priority'] = $fleet_info->status_priority;
		} else {
			$data['status_priority'] = '';
		}
		if ($this->input->post('pm_stat')) {
			$data['pm_stat'] = $this->input->post('pm_stat');
		} elseif (!empty($fleet_info)) {
			$data['pm_stat'] = $fleet_info->pm_stat;
		} else {
			$data['pm_stat'] = '';
		}
		if ($this->input->post('registration_expiry_date')) {
			$data['registration_expiry_date'] = $this->input->post('registration_expiry_date');
		} elseif (!empty($fleet_info)) {
			$data['registration_expiry_date'] = date('Y-m-d', strtotime($fleet_info->registration_expiry_date));
		} else {
			$data['registration_expiry_date'] = '';
		}
		if ($this->input->post('service_tier_id')) {
			$data['service_tier_id'] = $this->input->post('service_tier_id');
		} elseif (!empty($fleet_info)) {
			$data['service_tier_id'] = $fleet_info->service_tier_id;
		} else {
			$data['service_tier_id'] = '';
		}
		if ($this->input->post('registered_state_id')) {
			$data['registered_state_id'] = $this->input->post('registered_state_id');
		} elseif (!empty($fleet_info)) {
			$data['registered_state_id'] = $fleet_info->registered_state_id;
		} else {
			$data['registered_state_id'] = '';
		}
		if ($this->input->post('route_type_id')) {
			$data['route_type_id'] = $this->input->post('route_type_id');
		} elseif (!empty($fleet_info)) {
			$data['route_type_id'] = $fleet_info->route_type_id;
		} else {
			$data['route_type_id'] = '';
		}
		if ($this->input->post('station_code')) {
			$data['station_code'] = $this->input->post('station_code');
		} elseif (!empty($fleet_info)) {
			$data['station_code'] = $fleet_info->station_code;
		} else {
			$data['station_code'] = '';
		}
		if ($this->input->post('notes')) {
			$data['notes'] = $this->input->post('notes');
		} elseif (!empty($fleet_info)) {
			$data['notes'] = $fleet_info->notes;
		} else {
			$data['notes'] = '';
		}
	
		//fetch my
		$data['car_makes'] = $this->fleet_model->getVehicleMakes();
		$data['ownership_types'] = $this->fleet_model->getOwnershipType();
		$data['route_types'] = $this->fleet_model->getRouteType();
		$data['service_tier'] = $this->fleet_model->getServiceTier();
		$data['vehicle_providers'] = $this->fleet_model->getVehicleProvider();
		$data['status_reason_codes'] = $this->fleet_model->getStatusReasonCode();
		$data['countries'] = $this->fleet_model->getRegisteredStates();
// 				
		$tt = $this->templates_model->getTemplatess();
		//print_r($tt);
		$t_array = array('' => 'Select a Template');

		foreach($tt as $t){
			$t_array[$t->id] = $t->template_title;
		}
		//print_r($t_array);
		$data['all_templates'] = $t_array;
		$data['templates'] = $tt;
		$data['template_file'] = '';


		$data['activeTab'] = 1;
		if(array_key_exists('user_edit_form', $_POST)){
			$data['activeTab'] = 1;
		}else if(array_key_exists('file_upload_form', $_POST) || array_key_exists('file_send_form', $_POST)){
			$data['activeTab'] = 2;
		}

		// $curl = curl_init();
// echo '<pre>';
// print_r($data);exit;
// $payload =  array( "country" => "India" );
// 		$ch = curl_init();
// 		curl_setopt($ch, CURLOPT_URL, 'https://countriesnow.space/api/v0.1/countries/states');
		
// 		// curl_setopt($ch, CURLOPT_POST, true);
// 		// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// 		// curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($payload));
// 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
// 		    'Content-Type: application/x-www-form-urlencoded',
// 		    'Accept: application/json',
// 		));
// 		$output = curl_exec($ch);
// 		curl_close($ch);
		// $data['fleet'] = $fleet_info;

		$this->template->view('fleet_form',$data);
	}


	public function chat(){
		$this->lang->load('fleet');
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

			
			$userid=$this->fleet_model->addUser($userdata);
			
			$this->session->set_flashdata('message', 'Fleet Saved Successfully.');
			redirect(ADMIN_PATH.'/fleet');
		}
		$this->getForm();*/
		$data = array();
		$data['fleet'] = $this->fleet_model->getFleet();

		$this->template->view('chats_form',$data);
	}

	public function loadchatajax(){
		$emp = $this->fleet_model->getUser($_POST['user_id']);
		echo '
		<div class="card mb-1">
			<div class="card-header p-1">
				<div class="row g-0">
				<div class="col-1 my-auto p-1">
					<div class=" position-relative">
						<img src="'.base_url('storage/uploads/images/'.(empty($emp->image) ? 'user.png' : $emp->image)).'" style="border-radius:50%" class="img-fluid" alt="Employee">
						<span style="right:0px" class="position-absolute p-1 bg-success border border-white rounded-circle">
							<span class="visually-hidden">New alerts</span>
						</span>
					</div>
				</div>
				<div class="col my-auto ps-2">
					<strong class="card-title">'.$emp->name.'</strong>
					<small class="d-block py-0 text-success">Typing...</small>
				</div>
				<div class="col-auto my-auto pe-2">
				<button type="button" class="btn btn-sm btn-none p-0"><i class="las la-ellipsis-v"></i></button>
				</div>
				</div>
			</div>
			<div class="card-body">

			<div class="row g-0">
				<div class="col-12 text-center"><div class="px-2 d-inline-block text-muted bg-light small">TODAY</div></div>

				<div class="col-12"><div class="p-2 d-inline-block bg-light">Hello</div></div>
				<div class="col-12 text-muted" style="font-size:9px">10:30PM</div>
				
				<div class="col-12 text-end"><div class="p-2 d-inline-block bg-primary text-white">hi there</div></div>
				<div class="col-12 text-end text-muted" style="font-size:9px">11:30PM</div>
			</div>
			


			
			</div>
			<div class="card-footer bg-white p-0 border-0">

				<div id="is_typing_167" class="typing"></div>

				
				<input type="hidden" id="from_id" name="from_id" value="164">
				<input type="hidden" id="to_id" name="to_id" value="167">
				<div class="row g-0">
					<div class="col-md col-12 text-danger small"><input type="text" id="message_body" name="message_body" class="form-control rounded-0" rows="1" placeholder="Enter your Message here" oninput="typing(164, 167)"/></div>
					<div class="col-auto ms-auto"><button onclick="send_message()" class="btn btn-primary rounded-0" type="button"><i class="las la-paper-plane"></i></button></div>
				</div>
			</div>
		</div>

		';
	}

	

	protected function validateForm() {
		$rules = array(
            'vehicle_name' => array(
                'field' => 'vehicle_name',
                'label' => 'Vehicle ID',
                'rules' => 'trim|required|max_length[100]'
            ),
            'vin' => array(
                'field' => 'vin',
                'label' => 'Vin',
                'rules' => 'trim|required|max_length[150]'
            ),
            'license_plate_number' => array(
                'field' => 'license_plate_number',
                'label' => 'License Plate Number',
                'rules' => 'trim|required|max_length[100]'
            ),
            'route_type_id' => array(
                'field' => 'route_type_id',
                'label' => 'Route Type',
                'rules' => 'required'
            ),
        );
		$this->form_validation->set_rules($rules);
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

	public function history(){
		
		$this->lang->load('fleet');
		$this->template->set_meta_title($this->lang->line('heading_title'));

		$data = array();
		
		$fleet_id = $this->uri->segment(4);
		$data['fleet'][] = $this->fleet_model->getFleet($this->uri->segment(4));
		$data['history'] = $this->fleet_model->getFleetHistory($this->uri->segment(4));
		// echo '<pre>';
		// print_r($data);exit;

		$data['heading_title'] = $this->lang->line('history_title');
		$this->template->view('history',$data);
	}

	public function images(){
		
		
		$fleet_id = $this->uri->segment(4);

		$data = array();
		$fleet_img = $this->fleet_model->getFleetImages($fleet_id);


		$fleet_info = $this->fleet_model->getFleet($this->uri->segment(4));
		// echo json_encode($fleet_img);exit;
		$selected_user = '';
		$html = '<div class="modal-header">
        <div class="title"><h5>'. $fleet_info->vehicle_name.' Images </h5><small>VIN: '.$fleet_info->vin.'</small></div>
        <button type="button" class="btn btn-none" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times-circle"></i></button>
      </div>
      <div class="modal-body" id="imageinfobody">
      
            <div class="row mt-2">
                
      				<div class="row imageGallery">';
		// echo $html;exit;
		$html .= '<div id="" class="col-12 text-md-center mx-lg-3">Regrettably, the images for this fleet could not be located.</div>';      	
		/*if(!empty($fleet_img)){
      		foreach ($fleet_img as $key => $value) {
      			$html .= '
                    <div id="" class="col-4">
                        <img class="image" src="'.base_url('storage/uploads/images/'.(empty($value->document_name) ? 'user.png' : $value->document_name)).'" style="width: 250px;height: 250px;">
                    </div>
                    ';
      		}
      	} else {
      		$html .= '<div id="" class="col-12 text-md-center mx-lg-3">Regrettably, the images for this fleet could not be located.</div>';
      	}*/
      	

      	$html .= '</div></div></div></div>';


		echo $html;
		
	}

	
	public function email_check($email){
      
		$User = $this->fleet_model->getUserByEmail($email);
		
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
      $User = $this->fleet_model->getUserByUsername($name);
		
      if (!empty($User) && $User->user_id != $user_id){
            $this->form_validation->set_message('name_check', "This {field} provided is already in use.");
            return FALSE;
		}else{
         return TRUE;
      }
   }

   	public function getmodels(){

   		$makes_id = $_POST['makes_id'];
   		$models = $this->fleet_model->getVehicleModelsByMakeID($makes_id);
		$edit = $view = '';
		if (!empty($models)){
			$view .= '<option value="" selected  hidden>-- select --</option>';
		    foreach ($models as $key => $value) {
		    	$view .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
		    }
		}
		echo $view;
   }
	
}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */