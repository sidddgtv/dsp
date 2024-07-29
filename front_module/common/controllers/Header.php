<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Header extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('common/common_model');
	}
	public function index(){	
		$data=array();
		$id=$this->pages_model->getIdbySlug($this->uri->segment(1));
		$Page = $this->pages_model->getPageinfobyId($id);
		if (strlen($Page["meta_title"]) > 0) {
			$data['site_name'] = $Page['meta_title'];
		}else{
			$data['site_name'] = $this->settings->config_site_title;
		}

		if(!empty($_SESSION['cart'])){
			$data['cnt'] = count($_SESSION['cart']);
		}else{
			$data['cnt'] = 0;
		}
		//$data['site_name'] = $this->settings->config_site_title;	
		if (is_file(DIR_UPLOAD . $this->settings->config_site_logo)) {
			$data['logo'] = base_url('storage/uploads') . '/' . $this->settings->config_site_logo;
		} else {
			$data['logo'] = '';
		}
		if (is_file(DIR_UPLOAD . $this->settings->config_site_icon)) {
			$data['favicon'] = base_url('storage/uploads') . '/' . $this->settings->config_site_icon;
		} else {
			$data['favicon'] = '';
		}
		$data['menu']=$this->plugin->nav_menu(
			array(
				'theme_location'=>'',
				'menu_group_id'  => '2',
				'menu_class'     => 'menu'
			)
		);	
		//echo"<pre>";
		//printr($data['menu']); exit;
		//$data['menu'] = $this->common_model->getTopMenu();
	
		//printr($data['menu']); exit;
		if ($this->uri->segment(1)) {
			$data['class'] = $this->uri->segment(1);
		} else {
			$data['class'] = 'home';
		}
		$this->load->model('pages/pages_model');
		$Page=$this->pages_model->getPageinfobySlug($this->uri->segment(1));
		
		$data['config_email'] = $this->settings->config_email;
		$data['config_telephone'] = $this->settings->config_telephone;
		$data['config_address'] = $this->settings->config_address;
		$this->load->view('header',$data);
	}
	
}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */