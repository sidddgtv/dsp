<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Header extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('pages/pages_model');
		$this->load->model('common_model');
		$this->load->library('session');
        // User login status 
        $this->isUserLoggedIn = $this->session->userdata('isUserLoggedIn');
	}
	public function index(){	
		//die('UNDER CONSTRUCTION');
		$data=array();	
		$data['site_name'] = $this->settings->config_site_title;
		if (is_file(DIR_UPLOAD . $this->settings->config_site_logo)) {
			$data['logo'] = base_url('storage/uploads') . '/' . $this->settings->config_site_logo;
		} else {
			$data['logo'] = '';
		}
		$data['islogin'] = isset($_SESSION['isUserLoggedIn'])?$_SESSION['isUserLoggedIn']:'';
	
		$data['email_id'] = $this->settings->config_email;
		$data['phone'] = $this->settings->config_telephone;	
		$data['facebook'] = $this->settings->config_facebook;
		$data['twitter'] = $this->settings->config_twitter;	
		$data['instagram'] = $this->settings->config_instagram;
		$data['linkedin'] = $this->settings->config_linkedin;	
		

		//for category
		$data['isUserLoggedIn'] = $this->isUserLoggedIn;
		
		$data['top_menu'] = $this->common_model->getFooterMenuforClass('top_menu');



		$this->load->view('header',$data);
	}
	
}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */