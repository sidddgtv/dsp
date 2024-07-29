<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Footer extends MX_Controller {

	public function index()
	{
		$data=array();
		if (is_file(DIR_UPLOAD . $this->settings->config_site_logo)) {
			$data['logo'] = base_url('storage/uploads') . '/' . $this->settings->config_site_logo;
		} else {
			$data['logo'] = '';
		}
		$data['quicklinks']=$this->plugin->nav_menu(
			array(
				'theme_location'=>'',
				'menu_group_id'  => '4',
				'menu_class'     => 'menu'
			)
		);

		$data['departments']=$this->plugin->nav_menu(
			array(
				'theme_location'=>'',
				'menu_group_id'  => '5',
				'menu_class'     => 'menu'
			)
		);
		
		$data['popular']=$this->plugin->nav_menu(
			array(
				'theme_location'=>'',
				'menu_group_id'  => '6',
				'menu_class'     => 'menu'
			)
		);
		//printr($data['quicklinks']); exit;
		//$data['menu'] = $this->common_model->getFooterMenu();

		$data['config_email'] = $this->settings->config_email;
		$data['config_telephone'] = $this->settings->config_telephone;
		$data['config_address'] = $this->settings->config_address;
		$data['facebook'] = $this->settings->config_facebook;
		$data['twitter'] = $this->settings->config_twitter;	
		$data['instagram'] = $this->settings->config_instagram;
		$data['linkedin'] = $this->settings->config_linkedin;	
		$data['gplus'] = $this->settings->config_gplus;
		$data['youtube'] = $this->settings->config_youtube;
		$data['pinterest'] = $this->settings->config_pinterest;
		$data['yelp'] = $this->settings->config_yelp;
		$data['soundcloud'] = $this->settings->config_soundcloud;
		$data['weixin'] = $this->settings->config_weixin;
		$data['config_setting_facebook'] = $this->settings->config_setting_facebook;
		$data['config_setting_twitter'] = $this->settings->config_setting_twitter;	
		$data['config_setting_instagram'] = $this->settings->config_setting_instagram;
		$data['config_setting_linkedin'] = $this->settings->config_setting_linkedin;	
		$data['config_setting_gplus'] = $this->settings->config_setting_gplus;
		$data['config_setting_youtube'] = $this->settings->config_setting_youtube;
		$data['config_setting_pinterest'] = $this->settings->config_setting_pinterest;
		$data['config_setting_yelp'] = $this->settings->config_setting_yelp;
		$data['config_setting_soundcloud'] = $this->settings->config_setting_soundcloud;
		$data['config_setting_weixin'] = $this->settings->config_setting_weixin;
		
		$this->load->view('footer',$data);
	}
}

/* End of file templates.php */
/* Location: ./application/modules/templates/controllers/templates.php */
