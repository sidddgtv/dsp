<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends Admin_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('users/users_model');
		$this->load->model('fleet/fleet_model');
	}
	
	public function index(){
		//print_r($_SESSION);
		//redirect('pages');
		($_SESSION['user_group_id'] == 1 ? '' : redirect(admin_url('document')));

		$data=array();
		$this->lang->load('dashboard');
		$this->template->set_meta_title($this->lang->line('heading_title'));
		$data['heading_title'] 	= $this->lang->line('heading_title');

		$data['active_employees_text'] = $this->users_model->getActiveDriversCount().'/'.$this->users_model->getAllDriversCount();

		
		//week details
		$last_updated_week = $this->users_model->getLastUpdatedWeekYear();
		//print_r($last_updated_week);
		$data['max_week_number'] = $last_updated_week['max_week_number'];
		$data['max_year_number'] = $last_updated_week['max_year_number'];

		//week at a glance
		/*
		Fantastic
		Great
		Fair
		Poor
		*/
		/*$data['Fantastic'] = $this->users_model->getWeekGlanceCount('Fantastic', (int)date("W"), (int)date("Y"));
		$data['Great'] = $this->users_model->getWeekGlanceCount('Great', (int)date("W"), (int)date("Y"));
		$data['Fair'] = $this->users_model->getWeekGlanceCount('Fair', (int)date("W"), (int)date("Y"));
		$data['Poor'] = $this->users_model->getWeekGlanceCount('Poor', (int)date("W"), (int)date("Y"));

		$data['overall_fico_rate'] = $this->users_model->overallFICORate((int)date("W"), (int)date("Y"));*/

		$data['Fantastic'] = $this->users_model->getWeekGlanceCount('Fantastic', (int)$data['max_week_number'], (int)$data['max_year_number']);
		$data['Great'] = $this->users_model->getWeekGlanceCount('Great', (int)$data['max_week_number'], (int)$data['max_year_number']);
		$data['Fair'] = $this->users_model->getWeekGlanceCount('Fair', (int)$data['max_week_number'], (int)$data['max_year_number']);
		$data['Poor'] = $this->users_model->getWeekGlanceCount('Poor', (int)$data['max_week_number'], (int)$data['max_year_number']);

		$data['overall_fico_rate'] = $this->users_model->overallFICORate((int)$data['max_week_number'], (int)$data['max_year_number']);
		
		//fleet
		$data['available_fleet'] = $this->fleet_model->getFleetCount(1);
		$data['not_available_fleet'] = $this->fleet_model->getFleetCount(2);
		$data['issued_fleet'] = $this->fleet_model->getFleetCount(3);
		
		$this->template->view('dashboard',$data);
	}
	
}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */