<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Logout extends Admin_Controller {
	function __construct(){
      parent::__construct();
	}
	public function index(){
		$this->user->logout();
		unset($_SESSION['chat_window_drivers']);
		//$this->common_model->destroy_remember_me();
      redirect(ADMIN_PATH);
	}
	
}
