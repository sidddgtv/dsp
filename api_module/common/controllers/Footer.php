<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Footer extends MX_Controller {

	public function index()
	{
		$data=array();
		$data['email_id'] = $this->settings->config_email;
		$data['phone'] = $this->settings->config_telephone;	
		$data['facebook'] = $this->settings->config_facebook;
		$data['twitter'] = $this->settings->config_twitter;	
		$data['instagram'] = $this->settings->config_instagram;
		$data['linkedin'] = $this->settings->config_linkedin;

		$data['site_title'] = $this->settings->config_site_title;

		if (is_file(DIR_UPLOAD . $this->settings->config_site_logo)) {
			$data['logo'] = base_url('storage/uploads') . '/' . $this->settings->config_site_logo;
		} else {
			$data['logo'] = '';
		}

		$this->load->model('common_model');

		$data['first_row_menu'] = $this->common_model->getFooterMenuforClass('first_row');
		$data['second_row_menu'] = $this->common_model->getFooterMenuforClass('second_row');
		$data['third_row_menu'] = $this->common_model->getFooterMenuforClass('third_row');

		$this->load->view('footer',$data);
	}
}

/* End of file templates.php */
/* Location: ./application/modules/templates/controllers/templates.php */
