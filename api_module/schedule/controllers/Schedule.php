<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//header("Access-Control-Allow-Headers: Authorization, Content-Type");

//require 'front_module/login/models/Login_model.php';
//require 'front_module/login/controllers/Login.php';
//require 'front_module/common/models/Common_model.php';
//require 'front_module/pages/models/Pages_model.php';

class Schedule extends REST_Controller {
	private $error = array();
	function __construct(){
		parent::__construct();
		$this->load->model('schedule/schedule_model');
		$this->load->model('common/common_model');
		//we are using login model from the front end
		/*$this->load->model('login/login_model');
		//$this->load->library('login/Login');
		

		$return = $this->common_model->checkHeader();
		$this->tokenStatus = $return[0];
		$this->userId = $return[1];*/
	}
	
	public function index_get(){

		$json=array(
			'error'=>true,
			'message'=>'Invalid Request'
		);
		
		$this->set_response($json, REST_Controller::HTTP_OK);
	}

	public function month_post(){
		$json=array();

		$return = $this->common_model->checkHeader();
		$this->tokenStatus = $return[0];
		$this->userId = $return[1];
		
		$result = $this->schedule_model->getScheduleforMonth($this->userId, $_POST['month'], $_POST['year']);
		
		//echo $this->db->last_query();
		if($result){
			$final_result = array();
			foreach($result as $r){
				$final_result['schedule'][] = $r;
				$final_result['packages_delivered'] = 0;
				$final_result['remarks'] = 'In-time';
			}
			$json=array(
				'status'=>1,
				'data'=>$final_result,
				//'errors'=>array("Reset Password link has been sent to registered account"),
			);
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Account/ Schedule not found"),
			);
		}
		$this->set_response($json, REST_Controller::HTTP_OK);
		
	}

	public function search_post(){
		$json=array();

		$return = $this->common_model->checkHeader();
		$this->tokenStatus = $return[0];
		$this->userId = $return[1];
		
		$result = $this->schedule_model->getScheduleforDate($this->userId, $_POST['start_date'], $_POST['end_date']);
		
		//echo $this->db->last_query();
		if($result){
			$final_result = array();
			foreach($result as $r){
				$final_result['schedule'][] = $r;
				$final_result['packages_delivered'] = 0;
				$final_result['remarks'] = 'In-time';
			}
			$json=array(
				'status'=>1,
				'data'=>$final_result,
				//'errors'=>array("Reset Password link has been sent to registered account"),
			);
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Account/ Schedule not found"),
			);
		}
		$this->set_response($json, REST_Controller::HTTP_OK);
		
	}

}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */