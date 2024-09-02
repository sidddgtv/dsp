<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//header("Access-Control-Allow-Headers: Authorization, Content-Type");

//require 'front_module/login/models/Login_model.php';
//require 'front_module/login/controllers/Login.php';
//require 'front_module/common/models/Common_model.php';
//require 'front_module/pages/models/Pages_model.php';

class Users extends REST_Controller {
	private $error = array();
	function __construct(){
		parent::__construct();
		$this->load->model('users/users_model');
		$this->load->model('common/common_model');
		$this->load->model('fleet/fleet_model');
		//we are using login model from the front end
		/*
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

	public function login_post(){
		$json=array();

		$result=$this->users_model->loginUser($this->post('email_id'), $this->post('password'));
		//print_r($result);
		//die;
		
		if(!empty($result) && $result['user_group_id'] == 1){
			$json=array(
				'status'=>0,
				'errors'=>array("You cannot login with this Email and Password"),
			);
		}else if(!empty($result)){
			//update auth token
			$auth_token_value = md5(time());
			$auth_token=array(
				"auth_token"=>$auth_token_value
			);
			$this->db->where("id",$result['id']);
			$this->db->update("user", $auth_token);

			//add auth token to resturn array
			$result['auth_token'] = $auth_token_value;

			//unset($result['auth_token']);
			unset($result['password']);
			unset($result['show_password']);

			//rewrite full path for files for app
			$result['image'] = base_url('storage/uploads/images/'.$result['image']);
			$json=array(
				'status'=>1,
				"user_data"=>$result,
				'message'=>"Login Successfully",
			);
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Wrong Email and Password"),
			);
		}
		$this->set_response($json, REST_Controller::HTTP_OK);
		
	}

	public function register_post(){
		$json=array();

		//check first
		
		$user_app_result = $this->users_model->emailAddressExists($this->post('email_id'));
		//echo print_r($user_app_result);die;
		
		
		

		if (empty($user_app_result)) {
			//echo 1;die;
			//$l = new Login();

			//$return_data = json_decode($l->confirmregister(TRUE));
			$result=$this->users_model->registerUser($_POST, $_FILES);
			
			if(empty($user_app_result) && $result){

				$json=array(
					'status'=>true,
					'message'=>'Driver Successfully Registered'
				);
				//send mail


			}else{
				$json=array(
					'status'=>false,
					'message'=>'Something went wrong, Please repost your request'//strip_tags($return_data->message)
				);
			}
			
			
			
		}else{
			//$json['status'] 	= false;
			$json=array(
				'status'=>false,
				'message'=>"Email Address already exists"
			);
		}
		$this->set_response($json, REST_Controller::HTTP_CREATED);
	}

	/*public function getaccountstatus_post(){
		$json = array();

		if(strlen($this->post('auth_token'))){
			$this->db->where('auth_token', $this->post('auth_token'));
			$result = $this->db->get('user')->row_array();
			unset($result['password']);
			
			if($result){
				if(strlen($result['image'])){
					unset($result['image']);
				}
				
				
				$json = array(
					'status'=>0,
					'token_status'=>1,
					'activated'=>$result['activated'],
					"user_data"=>$result
				);
			}else{
				$json = array(
					'status'=>0,
					'token_status'=>0,
					'activated'=>0,
					"user_data"=>'Invalid Token/ Token not found'
				);
			}
		}else{
			$json = array(
				'status'=>0,
				'token_status'=>0,
				'activated'=>0,
				"user_data"=>'Invalid Token/ Token not sent'
			);
		}

		$this->set_response($json, REST_Controller::HTTP_OK);
		
	}*/

	public function forgotpassword_post(){
		$json=array();
		
		$result = $this->users_model->forgotPassword($this->post('email_id'));
		
		if($result){
			$json=array(
				'status'=>1,
				'errors'=>array("Reset Password link has been sent to registered account"),
			);
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Account not found"),
			);
		}
		$this->set_response($json, REST_Controller::HTTP_OK);
		
	}

	public function updateprofile_post(){
		//print_r($_REQUEST);
		//print_r($_FILES);

		$this->users_model->editProfile($_POST, $this->post('driver_id'), $_FILES);
		/*$data = array(
			'full_name' => $_POST['name'],
			//'email_' => $_POST['phone']
		);
		$user_app_result = $this->login_model->updateUser($data, $_FILES, $this->userId);*/
		$result = array();
		//$result=$this->users_model->loginUser($this->post('email_id'), $this->post('password'));
		$result=$this->users_model->getUser($this->post('driver_id'));
		unset($result['password']);
		unset($result['show_password']);
		$result['image'] = base_url('storage/uploads/images/'.$result['image']);

		$json=array(
			'status'=>1,
			"user_data"=>$result,
			'data'=>array("Profile updated"),
		);
		
		$this->set_response($json, REST_Controller::HTTP_OK);
	}

	public function dashboard_post(){
		$return = $this->common_model->checkHeader();
		//print_r($return);
		$this->tokenStatus = $return[0];
		$this->userId = $return[1];
		//print_r($_SERVER);
		//print_r($_FILES);
		//$headers = getallheaders();
		//print_r($headers);

		//$id = $this->ticket_model->deleteTicket($this->post('ticket_id'));
		//$this->flogin_model->editProfile($this->input->post(), $this->input->post('user_id'));
		//$this->flogin_model->editPassword($this->input->post(), $this->input->post('user_id'));
		//echo $return[1];
		//echo $this->input->post('new_password');

		$last_updated_week = $this->users_model->getLastUpdatedWeekYear();
		

		if($this->userId){
			$scorecard = $this->users_model->getScorecard($this->userId, (int)$last_updated_week['max_week_number'], (int)$last_updated_week['max_year_number']);
			//get active fleets
			$fleet_data = $this->fleet_model->getActiveFleetsIssuedtoDriver($this->userId);
			//echo count($fleet_data);
			$send_fleet_data = array();
			if(empty($fleet_data)){
				$send_fleet_data = NULL;
			}else{
				foreach($fleet_data as $fd){
					$send_fleet_data[] = array(
						'fleet_id' => $fd['fleet_id'],
						'fleet_history_id' => $fd['fleet_history_id'],
						'vin' => $fd['vin'],
						'vehicle_name' => $fd['vehicle_name'],
						'license_plate_number' => $fd['license_plate_number']
					);
				}
				/*
				array(
					array(
						'fleet_id' => '111',
						'vin' => '1111-2222-3333-4444',
						'vehicle_name' => 'Test Vehicle',	
						'license_plate_number' => '123456'
					),
					array(
						'fleet_id' => '222',
						'vin' => '1111-2222-3333-4444',
						'vehicle_name' => 'Test Vehicle 2',	
						'license_plate_number' => '123456'
					)
				)*/
			}

			

			$overall_fico_rate = $this->users_model->overallFICORate((int)$last_updated_week['max_week_number'], (int)$last_updated_week['max_year_number']);

			$bonus_tier = $bonus_amount = 0;
			if(!empty($scorecard) && array_key_exists('id', $scorecard)){
				$bonus = $this->users_model->checkBonusAmount($scorecard['id']);
				$bonus_tier = $bonus['tier'];
				$bonus_amount = $bonus['bonus'];

				switch($bonus_tier){
					case 1:
						$bonus_tier = 'Fantastic';
						break;
					case 2:
						$bonus_tier = 'Great';
						break;
					case 3:
						$bonus_tier = 'Fair';
						break;
				}
			}
			
			$final = array(
				'scorecard' => $scorecard,
				'overall_fico_rate' => round($overall_fico_rate, 2),
				'attendance_points_scored' => 300,
				'attendance_total_points' => 500,
				'attendance_expiry' => 'Jun 13, 2024',
				'bonus_tier' => $bonus_tier,//'Fantastic',//
				'bonus_amount' => $bonus_amount,//'5',//
				/*'fico_rate' => '90',
				'delivery_was_great' => '90',
				'respect_property' => '90',
				'instruction_follow' => '90',
				'completion_rate' => '90',
				'pod_compliance' => '90',
				'contact_compliance' => '90',
				'bonus' => '1',
				'bonus_tier' => '1',
				'bonus_rate' => '5',
				'attendance_points' => '300',
				'attendance_total_points' => '500',
				'attendance_expiry' => 'Jun 13, 2024',*/
				//truck details
				'trucks' => $send_fleet_data
			);
			$json=array(
				'status'=>1,
				'data'=>$final,
				//'password'=>$this->input->post()
			);
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Account not found"),
			);
		}

		
		
		$this->set_response($json, REST_Controller::HTTP_OK);
	}

	public function scorecard_post(){
		$return = $this->common_model->checkHeader();
		$this->tokenStatus = $return[0];
		$this->userId = $return[1];
		
		$last_updated_week = $this->users_model->getLastUpdatedWeekYear();

		if($this->userId){
			//$score_data = $this->users_model->getScorecard($this->userId);
			$scorecard = $this->users_model->getScorecard($this->userId, (int)$last_updated_week['max_week_number'], (int)$last_updated_week['max_year_number']);
			$scorecard['cr'] = '-';
			$scorecard['podc'] = '-';
			$scorecard['podr'] = '-';
			$scorecard['hip'] = '-';
			$scorecard['cc'] = '-';
			
			$json=array(
				'status'=>1,
				'data'=>$scorecard,
				//'password'=>$this->input->post()
			);
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Account not found"),
			);
		}

		
		
		$this->set_response($json, REST_Controller::HTTP_OK);
	}

	public function acknowledgescorecard_post(){
		$return = $this->common_model->checkHeader();
		$this->tokenStatus = $return[0];
		$this->userId = $return[1];
		
		

		if($this->userId){
			$score_data = $this->users_model->acknowledgeScorecard($this->userId, $_POST['scorecard_id']);

			$json=array(
				'status'=>1,
				'data'=>array("Scorecard Acknowledged"),
				//'password'=>$this->input->post()
			);
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Account not found"),
			);
		}

		
		
		$this->set_response($json, REST_Controller::HTTP_OK);
	}

	public function updatepassword_post(){
		$return = $this->common_model->checkHeader();
		//$this->tokenStatus = $return[0];
		//$this->userId = $return[1];
		//print_r($_REQUEST);
		//print_r($_FILES);

		//$id = $this->ticket_model->deleteTicket($this->post('ticket_id'));
		//$this->flogin_model->editProfile($this->input->post(), $this->input->post('user_id'));
		//$this->flogin_model->editPassword($this->input->post(), $this->input->post('user_id'));
		//echo $return[1];
		//echo $this->input->post('new_password');
		$u_pass = $this->login_model->updatePassword($return[1], array('newpassword' => $this->input->post('new_password')));

		$json=array(
			'status'=>1,
			'data'=>array("Password updated"),
			//'password'=>$this->input->post()
		);
		
		$this->set_response($json, REST_Controller::HTTP_OK);
	}

	public function sendmessage_post(){
		$return = $this->common_model->checkHeader();
		$this->tokenStatus = $return[0];
		$this->userId = $return[1];
		
		

		if($this->userId){
			$this->users_model->replyChat($this->userId, $_POST['message']);

			$json=array(
				'status'=>1,
				'data'=>array("Message Sent"),
				//'password'=>$this->input->post()
			);
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Chat: Account not found"),
			);
		}

		
		
		$this->set_response($json, REST_Controller::HTTP_OK);
	}

	public function getmessages_post(){
		$return = $this->common_model->checkHeader();
		$this->tokenStatus = $return[0];
		$this->userId = $return[1];
		
		

		if($this->userId){
			$message_data = $this->users_model->getMessages($this->userId, 1);

			$data = array();
			if(!empty($message_data)){
				foreach($message_data as $md){
					if($md->from_id == 1){
						$data[] = array(
							'text' => $md->message_body,
							'sender' => 'admin',
							'sent_on' => $md->added_on
						);
					}else{
						$data[] = array(
							'text' => $md->message_body,
							'sender' => 'self',
							'sent_on' => $md->added_on
						);
					}
				}
			}
			//print_r($message_data);

			$json=array(
				'status'=>1,
				'data'=>$data,
				//'password'=>$this->input->post()
			);
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Chat: Account not found"),
			);
		}

		
		
		$this->set_response($json, REST_Controller::HTTP_OK);
	}

	public function gaspin_post(){
		$return = $this->common_model->checkHeader();
		//print_r($return);
		$this->tokenStatus = $return[0];
		$this->userId = $return[1];
		
		

		if($this->userId){
			//$message_data = $this->users_model->getMessages($this->userId, 1);

			$data = array('gaspin' => $this->users_model->getGasPin($this->userId));

			$json=array(
				'status'=>1,
				'data'=>$data,
				//'password'=>$this->input->post()
			);
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Account not found"),
			);
		}

		
		
		$this->set_response($json, REST_Controller::HTTP_OK);
	}

	public function getstates_post(){
		$json_child = array();
		$states = $this->users_model->getStates(231);
		
		if($states){
			//prepare
			$json=array(
				'status'=>1,
				'data'=>$states,
			);
		}else{
			$json=array(
				'status'=>0,
				'data'=>array("No records found"),
			);
		}
		
		$this->set_response($json, REST_Controller::HTTP_OK);	
	}

	public function getcities_post(){
		$json_child = array();
		$cities = $this->users_model->getCities($this->post('state_id'));
		
		if($cities){
			//prepare
			$json=array(
				'status'=>1,
				'data'=>$cities,
			);
		}else{
			$json=array(
				'status'=>0,
				'data'=>array("No records found"),
			);
		}
		
		$this->set_response($json, REST_Controller::HTTP_OK);	
	}

   protected function sendMessage($ticket_id){
        //fetch device token from ticket_id
        $device_query = 'SELECT u.device_token FROM user u inner join ticket t on t.user_id = u.id where t.id = 135';
        $device_sql = $this->db->query($device_query);
		$device_token = $device_sql->row();
		
		
		$content = array(
			"en" => 'English Message'
			);
		
		$fields = array(
			//'app_id' => "2f5a3ca4-c1e1-40f3-9583-ee502243d844",
			'app_id' => "7f2c0645-20d8-442d-aa3b-2976a10681fe",
			//'include_player_ids' => array("851daf30-d825-4a7e-b7d0-3f6009358926"),
			'include_player_ids' => array($device_token->device_token),
			'data' => array("message" => "Send your message here"),
			'contents' => $content
		);
		
		$fields = json_encode($fields);
		//print("\nJSON sent:\n");
		//print($fields);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

		$response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
	}

}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */