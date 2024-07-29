<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * AIO ADMIN
 *
 * @author      Mark Price
 * @copyright   Copyright (c) 2012
 * @license     MIT License
 * @link        http://aioadmin.com
 */

class Common_model extends MY_Model{	
   
	public function __construct(){
		parent::__construct();
	}

	public function sg_mail($subject, $email_id, $first_name, $mail_body){
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From: noreply <'noreply@oid.com'>\r\n";

		$mail_res = mail($email_id, $subject, $mail_body, $headers);

		return 1;
		
		//echo getcwd();
		/*require getcwd().'/app/third_party/sendgrid-php/vendor/autoload.php';
		//sendgrid method
		$email = new \SendGrid\Mail\Mail(); 
		$email->setFrom("noreply@oid.com", "Outer Image Delivery");
		$email->setSubject($subject);
		$email->addTo($email_id, $first_name);
		
		//$email->addCc($this->settings->config_email, $this->settings->config_email);
		//$email->addTo($to1, $name1);
		//$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
		$email->addContent(
			"text/html", $mail_body
		);
		$sendgrid = new \SendGrid('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');
		try {
			//$response = $sendgrid->send($email);
			//print_r($response);exit;
			return 1;
		} catch (Exception $e) {
			return 0;
		}*/
	}

	public function checkHeader(){
		$headers = getallheaders();
		if(array_key_exists('auth_token', $_POST)){
			//check token expiry
			$this->db->from("user");
			$this->db->where("auth_token", $_POST['auth_token']);
			$res = $this->db->get()->row_array();
			if(!empty($res))
				return array(TRUE, $res['id']);
			else
				return array(FALSE, 0);
		}else if(array_key_exists('Authorization', $headers)){
			$token = explode(' ', $headers['Authorization']);
			if(!empty($token[1])){
				//check token expiry
				$this->db->from("user");
				$this->db->where("auth_token", $token[1]);
				$res = $this->db->get()->row_array();
				if(!empty($res))
					return array(TRUE, $res['id']);
				else
					return array(FALSE, 0);
			}else{
				return array(FALSE, 0);
			}
		}else{
			return array(FALSE, 0);
		}
	}
	
}
