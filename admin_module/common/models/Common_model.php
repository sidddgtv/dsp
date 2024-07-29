<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends MY_Model {

	public function sg_mail($subject, $email_id, $first_name, $mail_body, $from_email, $from_name){
        //echo getcwd();
        require getcwd().'/app/third_party/sendgrid-php/vendor/autoload.php';
        //sendgrid method
        $email = new \SendGrid\Mail\Mail(); 
       	$email->setFrom($from_email, $from_name);
       	//$email->setReplyTo($from_email, $from_name);
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
            return 11;
        } catch (Exception $e) {
            return 0;
        }
        //mail($email_id, $subject, $mail_body);
    }

}