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
	
	public function addMember($data) {
		$userdata=array(
			"user_group_id"=>$data['user_group_id'],
			"firstname"=>$data['name'],
			"phone"=>$data['phone'],
			"address"=>$data['address'],
			"username"=>$data['username'],
			"password"=>md5($data['password']),
			"show_password"=>$data['password'],
			"email"=>$data['email'],
			"enabled"=>($data['user_group_id']==3)?0:1,
			"date_added"=>date("Y-m-d"),
		);
      $this->db->insert("user", $userdata);
      $user_id=$this->db->insert_id() ;
		
		$memberdata=array(
			"user_id"=>$user_id,
			"company"=>$data['company'],
			"business_id"=>isset($data['business_id'])?$data['business_id']:'',
		);
		$this->db->insert("member", $memberdata);
		
		return $user_id;
	}
	public function getBusinessTypes(){
		$this->db->from("business_type");
		$res = $this->db->get()->result_array();
		return $res;	
	}

	public function getTopMenu(){
		$this->db->from("menu");
		$this->db->where("menu_group_id",2);
		$res = $this->db->get()->result_array();
		return $res;
	}

	public function getFooterMenu(){
		$this->db->from("menu");
		$this->db->where("menu_group_id",4);
		$res = $this->db->get()->result_array();
		return $res;
	}

	public function getMenu(){
		$this->db->from("menu");
		$this->db->where("menu_group_id",4);
		$res = $this->db->get()->result_array();
		return $res;
	}

public function sg_mail($subject, $email_id, $first_name, $mail_body, $from_email, $from_name){
        //echo getcwd();
        require getcwd().'/app/third_party/sendgrid-php/vendor/autoload.php';
        //sendgrid method
        $email = new \SendGrid\Mail\Mail(); 
       	$email->setFrom("noreply@digitalvertex.com", 'Digital Vertex');
       	$email->setReplyTo($from_email, $from_name);
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
            $response = $sendgrid->send($email);
            //printr($response);exit;
            return 11;
        } catch (Exception $e) {
            return 0;
        }
    }


	
}
