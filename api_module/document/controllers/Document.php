<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//header("Access-Control-Allow-Headers: Authorization, Content-Type");

//require 'front_module/login/models/Login_model.php';
//require 'front_module/login/controllers/Login.php';
//require 'front_module/common/models/Common_model.php';
//require 'front_module/pages/models/Pages_model.php';

class Document extends REST_Controller {
	private $error = array();
	function __construct(){
		parent::__construct();
		$this->load->model('document/document_model');
		$this->load->model('users/users_model');
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

	public function all_post(){
		$json=array();

		$return = $this->common_model->checkHeader();
		$this->tokenStatus = $return[0];
		$this->userId = $return[1];
		
		//$result = $this->document_model->getDocuments($this->userId);

		$result = array(
			'unsigned' => array(
				'onboarding' => $this->document_model->getDocumentsbyType($this->userId, 1, 0),
				'coaching' => $this->document_model->getDocumentsbyType($this->userId, 2, 0),
				'scorecards' => $this->document_model->getDocumentsbyType($this->userId, 3, 0)
			),
			'signed' => array(
				'onboarding' => $this->document_model->getDocumentsbyType($this->userId, 1, 1),
				'coaching' => $this->document_model->getDocumentsbyType($this->userId, 2, 1),
				'scorecards' => $this->document_model->getDocumentsbyType($this->userId, 3, 1)
			),
		);
		
		if($result){
			$json=array(
				'status'=>1,
				'data'=>$result,
				//'errors'=>array("Reset Password link has been sent to registered account"),
			);
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Account/ Document not found"),
			);
		}
		$this->set_response($json, REST_Controller::HTTP_OK);
		
	}

	public function acknowledgedocument_post(){
		$return = $this->common_model->checkHeader();
		$this->tokenStatus = $return[0];
		$this->userId = $return[1];
		
		

		if($this->userId){
			$score_data = $this->document_model->acknowledgeDocument($this->userId, $_POST['document_id']);

			$json=array(
				'status'=>1,
				'data'=>array("Document Acknowledged"),
				//'password'=>$this->input->post()
			);
		}else{
			$json=array(
				'status'=>0,
				'errors'=>array("Account/ Document not found"),
			);
		}

		
		
		$this->set_response($json, REST_Controller::HTTP_OK);
	}

}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */