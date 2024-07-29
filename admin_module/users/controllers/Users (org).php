<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends Admin_Controller {
	private $error = array();
	
	public function __construct(){
      parent::__construct();
		$this->load->model('users_model');	
	}
	
	public function index(){
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
		
		$filter_data = array(
			'filter_search' => $requestData['search']['value'],
			'order'  		 => $requestData['order'][0]['dir'],
			'sort' 			 => intval($requestData['order'][0]['column']) ? $columns[$requestData['order'][0]['column']] : 'u.id',
			'start' 			 => $requestData['start'],
			'limit' 			 => $requestData['length']
		);
		$totalFiltered = $this->users_model->getTotalUsers($filter_data);
			
		$filteredData = $this->users_model->getUsers($filter_data);
		//printr($filteredData);
		
		$datatable=array();
		$count = 1;
		foreach($filteredData as $result) {
			
			if (is_file(DIR_UPLOAD . $result->image)) {
				$image = resize($result->image, 40, 40);
			} else {
				$image = resize('no_image.png', 40, 40);
			}
			
			$action  = '<div class="btn-group btn-group-sm pull-right">';
			$action .= 		'<a class="btn btn-sm btn-primary" href="'.admin_url('users/edit/'.$result->id).'"><i class="la la-edit"></i></i></a>';
			
			$action .=		'<a class="btn-sm btn btn-danger btn-remove" href="'.admin_url('users/delete/'.$result->id).'" onclick="return confirm(\'Are you sure?\') ? true : false;"><i class="las la-trash"></i></a>';

			

			$action .=		'<a class="btn btn-sm btn-primary btn-remove" href="'.admin_url('users/delete/'.$result->id).'" onclick="return confirm(\'Are you sure to send credential to this user?\') ? true : false;"><i class="las la-paper-plane"></i></a>';
			$action .= '</div>';

			/*$action ='<div class="btn-group btn-group-sm pull-right">';
            $action .= '<a class="btn btn-sm btn-outline-secondary" title="Edit Page" href="'. admin_url('users/edit/' . $result->id) . '"><i class="la la-edit"></i></a>';
            $action .= '<a class="btn-sm btn btn-outline-secondary" title="Delete Page"  href="'. admin_url('users/delete/' . $result->id) . '" onclick="return confirm(\'Are you sure?\') ? true : false;"><i class="las la-trash"></i></a>';
            $action .= '</div>';*/

			

			
			$datatable[]=array(
				$count++,
				$result->name,
				$result->email,
				$result->activated ? 'Activated':'Deactivated',
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

	public function viewblysts(){
		$user_id = $this->uri->segment(4);
		//echo $user_id;
		$data['add'] = admin_url('users/addblyst/'.$user_id);
		$data['delete'] = admin_url('users/delete');
		$data['datatable_url'] = admin_url('users/blystsearch/'.$user_id);

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

		$this->template->view('users', $data);
	}

	public function blystsearch() {
		$user_id = $this->uri->segment(4);
		$requestData= $_REQUEST;
		
		$columns = array( 
			0 => '',
			1 => 'blyst_name',
			2 => 'category_name'
		);
		
		$totalData = $this->users_model->getTotalBlystsfor(array(), $user_id);
		
		$totalFiltered = $totalData;
		
		$filter_data = array(
			'filter_search' => $requestData['search']['value'],
			'order'  		 => $requestData['order'][0]['dir'],
			'sort' 			 => intval($requestData['order'][0]['column']) ? $columns[$requestData['order'][0]['column']] : 'b.id',
			'start' 			 => $requestData['start'],
			'limit' 			 => $requestData['length']
		);
		$totalFiltered = $this->users_model->getTotalBlystsfor($filter_data, $user_id);
			
		$filteredData = $this->users_model->getBlysts($filter_data, $user_id);
		//printr($filteredData);
		
		$datatable=array();
		$count = 1;
		foreach($filteredData as $result) {
			
			/*if (is_file(DIR_UPLOAD . $result->image)) {
				$image = resize($result->image, 40, 40);
			} else {
				$image = resize('no_image.png', 40, 40);
			}*/
			
			$action  = '<div class="btn-group btn-group-sm pull-right">';
			$action .= 		'<a class="btn btn-sm btn-primary" href="'.admin_url('users/edit/'.$result->id).'"><i class="glyphicon glyphicon-pencil"></i></a>';
			$action .=		'<a class="btn-sm btn btn-danger btn-remove" href="'.admin_url('users/delete/'.$result->id).'" onclick="return confirm(\'Are you sure?\') ? true : false;"><i class="glyphicon glyphicon-trash"></i></a>';
			$action .= '</div>';

			/*$action ='<div class="btn-group btn-group-sm pull-right">';
            $action .= '<a class="btn btn-sm btn-outline-secondary" title="Edit Blyst" href="'. admin_url('users/editblyst/' . $user_id . '/' . $result->blyst_id) . '"><i class="la la-edit"></i></a>';
            $action .= '<a class="btn-sm btn btn-outline-secondary" title="Delete Blyst"  href="'. admin_url('users/deleteblyst/' . $user_id . '/' . $result->blyst_id) . '" onclick="return confirm(\'Are you sure?\') ? true : false;"><i class="las la-trash"></i></a>';
            $action .= '</div>';*/			

			
			$datatable[]=array(
				$count++,
				$result->blyst_name,
				$result->category_name,
				$result->is_private ? 'Yes':'No',
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

	public function addblyst(){
		$this->lang->load('users');
		$this->template->set_meta_title($this->lang->line('heading_title'));
		
		if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->validateBlystForm()){	
			$userdata=array(
				"blyst_name"=>$this->input->post('blyst_name'),
				"category_id"=>$this->input->post('category_id'),
				"show_password"=>$this->input->post('password'),
				"email"=>$this->input->post('email'),
				"status"=>1,	
				"activated"=>$this->input->post('activated')
			);

			
			$userid=$this->users_model->addUser($userdata);
			
			//$return = $this->users_model->saveBlyst($_POST, $_FILES);
			
			$this->session->set_flashdata('message', 'Users Saved Successfully.');
			redirect(ADMIN_PATH.'/users/viewblysts/'.$this->uri->segment(4));
		}
		$this->getBlystForm();
	}
	
	public function editblyst(){
		
		$this->lang->load('users');
		$this->template->set_meta_title($this->lang->line('heading_title'));
		
		if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->validateBlystForm()){	
			//$lyst_id=$this->uri->segment(5);
			
			$userdata=array(
				"name"=>$this->input->post('name'),
				"password"=>md5($this->input->post('password')),
				"show_password"=>$this->input->post('password'),
				"email"=>$this->input->post('email'),
				"status"=>1,
				"activated"=>$this->input->post('activated')
			);
			$userid=$this->users_model->editUser($user_id,$userdata);
			
			$return = $this->users_model->updateBlyst($this->uri->segment(5), $_POST, $_FILES);
			
			$this->session->set_flashdata('message', 'Users Updated Successfully.');
			redirect(ADMIN_PATH.'/users/viewblysts/'.$this->uri->segment(4));
		}
		$this->getBlystForm();
	}
	
	public function deleteblyst(){
		/*
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
		$this->users_model->deleteUser($selected);
		*/
		$return = $this->users_model->deleteBlyst($this->uri->segment(5));
		$this->session->set_flashdata('message', 'User deleted Successfully.');
		redirect(ADMIN_PATH.'/users/viewblysts/'.$this->uri->segment(4));
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
				"activated"=>$this->input->post('activated')
			);

			
			$userid=$this->users_model->addUser($userdata);
			
			$this->session->set_flashdata('message', 'Users Saved Successfully.');
			redirect(ADMIN_PATH.'/users');
		}
		$this->getForm();
	}
	
	public function edit(){
		
		$this->lang->load('users');
		$this->template->set_meta_title($this->lang->line('heading_title'));
		
		if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->validateForm()){	
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
		}
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
	
	protected function getList() {
		
		
		
		//$this->template->add_package(array('datatable'),true);
      

		$data['add'] = admin_url('users/add');
		$data['delete'] = admin_url('users/delete');
		$data['datatable_url'] = admin_url('users/search');

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

		if ($this->uri->segment(3) && ($this->input->server('REQUEST_METHOD') != 'POST')) {
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
		
		$this->template->view('users_form',$data);
	}

	protected function getBlystForm(){
		
		$this->template->add_package(array('ckeditor','colorbox','select2'),true);
      
		
		
		$data['heading_title'] 	= $this->lang->line('heading_title');
		
		$data['text_form'] = $this->uri->segment(5) ? 'Edit Blyst' : 'Add Blyst';
		
		if(isset($this->error['warning']))
		{
			$data['error'] 	= 'Please check for errors.';
		}
		
		$data['cancel'] = admin_url('users/viewblysts/'.$this->uri->segment(4));

		if ($this->uri->segment(3) && ($this->input->server('REQUEST_METHOD') != 'POST')) {
			$blyst_info = $this->users_model->getBlyst($this->uri->segment(5));
		}

		//print_r($blyst_info);

		if ($this->input->post('blyst_name')) {
			$data['blyst_name'] = $this->input->post('blyst_name');
		} elseif (!empty($blyst_info)) {
			$data['blyst_name'] = $blyst_info->blyst_name;
		} else {
			$data['blyst_name'] = '';
		}
		
		$data['categories'] = $this->users_model->getCategories();
		
		if ($this->input->post('category_id')) {
			$data['category_id'] = $this->input->post('category_id');
		} elseif (!empty($blyst_info)) {
			$data['category_id'] = $blyst_info->category_id;
		} else {
			$data['category_id'] = '';
		}

		if ($this->input->post('blyst_pic')) {
			$data['blyst_pic'] = $this->input->post('blyst_pic');
		} elseif (!empty($blyst_info)) {
			$data['blyst_pic'] = $blyst_info->blyst_pic;
		} else {
			$data['blyst_pic'] = '';
		}

		if ($this->input->post('blyst_pic_website')) {
			$data['blyst_pic_website'] = $this->input->post('blyst_pic_website');
		} else {
			$data['blyst_pic_website'] = '';
		}
		


		/*

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
		
		if ($this->input->post('is_private')) {
			$data['is_private'] = $this->input->post('is_private');
		} elseif (!empty($blyst_info)) {
			$data['is_private'] = $blyst_info->is_private;
		} else {
			$data['is_private'] = '';
		}

		$data['blyst_items'] = $this->users_model->getBlystItems($this->uri->segment(5));

		$data['user_id'] = $this->uri->segment(4);
		
		$this->template->view('blyst_form',$data);
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

	protected function validateBlystForm() {
		$blyst_id=$this->uri->segment(4);
		
		$regex = "(\/?([a-zA-Z0-9+\$_-]\.?)+)*\/?"; // Path
      $regex .= "(\?[a-zA-Z+&\$_.-][a-zA-Z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
      $regex .= "(#[a-zA-Z_.-][a-zA-Z0-9+\$_.-]*)?"; // Anchor 
		$rules=array(
			
			'blyst_name' => array(
				'field' => 'blyst_name', 
				'label' => 'Blyst Name', 
				'rules' => 'trim|required|max_length[100]'
			),
		);
		$this->form_validation->set_rules($rules);
		//$this->form_validation->set_rules('email', 'Email', 'required|callback_email_check');
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
	
}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */