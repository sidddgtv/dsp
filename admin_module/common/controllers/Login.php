<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends Admin_Controller {
	
	private $error = array();
	
	function __construct(){
      parent::__construct();
	}
	
	public function index(){
		
		$data=array();
		$this->lang->load('login');
		$this->template->title($this->lang->line('heading_title'));
		
		if ($this->user->isLogged()) {
			redirect(ADMIN_PATH);
		}
		if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->validate()){
         	//print_r($_POST);die;
			// Database query to lookup email and password
			$this->db->select('*'); 
        	$this->db->from('user'); 
        	$this->db->where('email', $_POST['username']);
        	$this->db->where('password', md5($_POST['password']));

        	$query = $this->db->get(); 
            $result = ($query->num_rows() > 0)?$query->row_array():FALSE;

            //print_r($result);die;

            if(!empty($result)){
            	$this->session->set_userdata('a_user_id', $result['id']);
            	$this->session->set_userdata('user_group_id', $result['user_group_id']);
            	if ($this->input->post('redirect') && (strpos($this->input->post('redirect'), admin_url()) == 0 )) {
					redirect($this->input->post('redirect'));
				} else {
					redirect(ADMIN_PATH);
				}
            }else{
				$_SESSION['error'] = '<div class="alert alert-danger text-white mb-4 rounded-0" role="alert"><strong>Error!</strong> Invalid Credentials</div>';
				redirect(ADMIN_PATH);
			}
                  
         /*if ($this->user->login($this->input->post('username'), $this->input->post('password'))){
         	//print_r($_SESSION);die;
				if ($this->input->post('redirect') && (strpos($this->input->post('redirect'), admin_url()) == 0 )) {
					redirect($this->input->post('redirect'));
				} else {
					redirect(ADMIN_PATH);
				}
         }else{
				redirect(ADMIN_PATH);
			}*/
      }
		
		$this->template->add_stylesheet('admin_module/common/assets/css/login.css');
		
		$data['heading_title']				= $this->lang->line('heading_title');
		
		$data['text_login'] 					= $this->lang->line('text_login');
		$data['text_forgotten']				= $this->lang->line('text_forgotten');
		$data['text_remember'] 				= $this->lang->line('text_remember');
		$data['text_register'] 				= $this->lang->line('text_register');
		
		$data['entry_username'] 			= $this->lang->line('entry_username');
		$data['entry_password'] 			= $this->lang->line('entry_password');
		$data['entry_confirmpassword'] 	= $this->lang->line('entry_confirmpassword');
		$data['entry_email'] 				= $this->lang->line('entry_email');
		$data['entry_forgotten'] 			= $this->lang->line('entry_forgotten');

		$data['button_login'] 				= $this->lang->line('button_login');
		$data['button_register'] 			= $this->lang->line('button_register');
		$data['button_reset'] 				= $this->lang->line('button_reset');		

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		$data['site_name'] = $this->settings->config_site_title;
		
		if (is_file(DIR_UPLOAD . $this->settings->config_site_logo)) {
			$data['logo'] = base_url('storage/uploads') . '/' . $this->settings->config_site_logo;
		} else {
			$data['logo'] = '';
		}
		
		if ($this->input->post('username')) {
			$data['username'] = $this->input->post('username');
		} else {
			$data['username'] = '';
		}

		if ($this->input->post('password')) {
			$data['password'] = $this->input->post('password');
		} else {
			$data['password'] = '';
		}
		
		if ($this->input->post('rememberme')) {
			$data['rememberme'] = $this->input->post('rememberme');
		} else {
			$data['rememberme'] = 0;
		}
		
		if($this->uri->total_segments() > 0){
			$route=$this->uri->uri_string();
			$data['redirect'] = $route;
		} else {
			$data['redirect'] = '';
		}
		
		$this->template->view('common/login',$data);
	}

	public function logout(){
		$this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('a_user_id');
		$this->session->unset_userdata('chat_window_drivers');
        $this->session->sess_destroy();
        redirect(ADMIN_PATH);
	}
	
	protected function validate(){
		$rules=array(
			'username' => array(
				'field' => 'username', 
				'label' => 'Username', 
				'rules' => 'trim|required'
			),
			'password' => array(
				'field' => 'password', 
				'label' => 'Password', 
				'rules' => 'trim|required'
			),
		);
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE)
		{
			return true;
    	}
		else
		{
			$this->error['warning']='Enter Username and Password !!';
			return false;
    	}
   }
	
}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */