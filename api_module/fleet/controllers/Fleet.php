<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//require 'front_module/login/models/Login_model.php';
//require 'front_module/login/controllers/Login.php';
//require 'front_module/common/models/Common_model.php';
//require 'front_module/pages/models/Pages_model.php';

class Fleet extends REST_Controller {
	private $error = array();
	function __construct(){
		parent::__construct();
		$this->load->model('fleet/fleet_model');
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

	public function fleetdetails_post(){
		$return = $this->common_model->checkHeader();
		$this->tokenStatus = $return[0];
		$this->userId = $return[1];

		//print_r($return);
		
		

		if($this->userId){
			$fleet_history_id = 0;
			if(array_key_exists('fleet_history_id', $_POST) && $_POST['fleet_history_id'] > 0){
				$fleet_history_id = $_POST['fleet_history_id'];
			}
			$fleet_data = $this->fleet_model->getFleetDetails($_POST['fleet_id'], $fleet_history_id);

			if(!empty($fleet_data)){
				//check if images are present, make it full path
				if(array_key_exists('front_side_image', $fleet_data) && $fleet_data['front_side_image'] != NULL && strlen($fleet_data['front_side_image']) > 0){
					$fleet_data['front_side_image'] = base_url('storage/uploads/images/'.$fleet_data['front_side_image']);
				}
				if(array_key_exists('left_side_image', $fleet_data) && $fleet_data['left_side_image'] != NULL && strlen($fleet_data['left_side_image']) > 0){
					$fleet_data['left_side_image'] = base_url('storage/uploads/images/'.$fleet_data['left_side_image']);
				}
				if(array_key_exists('back_side_image', $fleet_data) && $fleet_data['back_side_image'] != NULL && strlen($fleet_data['back_side_image']) > 0){
					$fleet_data['back_side_image'] = base_url('storage/uploads/images/'.$fleet_data['back_side_image']);
				}
				if(array_key_exists('right_side_image', $fleet_data) && $fleet_data['right_side_image'] != NULL && strlen($fleet_data['right_side_image']) > 0){
					$fleet_data['right_side_image'] = base_url('storage/uploads/images/'.$fleet_data['right_side_image']);
				}
				if(array_key_exists('odometer_image', $fleet_data) && $fleet_data['odometer_image'] != NULL && strlen($fleet_data['odometer_image']) > 0){
					$fleet_data['odometer_image'] = base_url('storage/uploads/images/'.$fleet_data['odometer_image']);
				}

				//print_r($fleet_data);

				$json=array(
					'status'=>1,
					'data'=>$fleet_data,
					'is_issued'=>(array_key_exists('retured_at', $fleet_data) && $fleet_data['retured_at'] != NULL ? 1 : 0)
					//'password'=>$this->input->post()
				);
			}else{
				$json=array(
					'status'=>0,
					'errors'=>array("Fleet not located/ Invalid request click."),
				);
			}

			
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Fleet not found"),
			);
		}

		
		
		$this->set_response($json, REST_Controller::HTTP_OK);
	}

	public function issuefleet_post(){
		$return = $this->common_model->checkHeader();
		$this->tokenStatus = $return[0];
		$this->userId = $return[1];

		//check if already issued or not by him or anybody
		
		

		if($this->userId){
			$this->fleet_model->issueFleet($this->userId, $_POST['fleet_id'], $_POST, $_FILES);

			$json=array(
				'status'=>1,
				'data'=>array("Fleet Issued"),
				//'password'=>$this->input->post()
			);
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Account not found for Fleet Issue"),
			);
		}

		
		
		$this->set_response($json, REST_Controller::HTTP_OK);
	}

	public function returnfleet_post(){
		$return = $this->common_model->checkHeader();
		$this->tokenStatus = $return[0];
		$this->userId = $return[1];
		
		//check if already returned

		if($this->userId){
			$this->fleet_model->returnFleet($this->userId, $_POST['fleet_id']);

			$json=array(
				'status'=>1,
				'data'=>array("Fleet Returned"),
				//'password'=>$this->input->post()
			);
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Account not found for Fleet Return"),
			);
		}

		
		
		$this->set_response($json, REST_Controller::HTTP_OK);
	}

	public function allissuedfleet_post(){
		$return = $this->common_model->checkHeader();
		$this->tokenStatus = $return[0];
		$this->userId = $return[1];

		if($this->userId){
			$all_fleets = $this->fleet_model->allIssuedFleet($this->userId);

			$all_fleet_data = array();
			if(empty($all_fleets)){
				$all_fleet_data = NULL;
			}else{
				foreach($all_fleets as $fd){
					$all_fleet_data[] = array(
						'fleet_id' => $fd['fleet_id'],
						'fleet_history_id' => $fd['fleet_history_id'],
						'vin' => $fd['vin'],
						'vehicle_name' => $fd['vehicle_name'],
						'license_plate_number' => $fd['license_plate_number'],
						'issued_at' => $fd['issued_at']
					);
				}
			}

			$json=array(
				'status'=>1,
				'data'=>$all_fleet_data,
				//'password'=>$this->input->post()
			);
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Account not found for Fleet Listings"),
			);
		}

		
		
		$this->set_response($json, REST_Controller::HTTP_OK);
	}


}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */