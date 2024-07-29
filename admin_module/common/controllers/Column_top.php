<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Column_top extends MX_Controller {

	public function index()
	{
		$data=array();
		$this->lang->load('column_left');
		
		$data['menu']=$this->plugin->nav_menu(
			array(
				'theme_location' => 'admin',
				'menu_group_id'  => ($_SESSION['user_group_id'] == 1 ? 1 : 7),
				'menu_class'     => 'nano-content'
			)
		);
		
		$this->load->view('column_top',$data);
	}
}

/* End of file templates.php */
/* Location: ./application/modules/templates/controllers/templates.php */
