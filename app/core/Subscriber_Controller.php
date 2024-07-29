<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* The MX_Controller class is autoloaded as required */
class Subscriber_Controller extends MX_Controller
{
	private $CI;
	function __construct(){
		
		parent::__construct();
		$this->CI =& get_instance();
		$this->form_validation->CI =& $this;
      // Create Dynamic Page Title
      if ( ! $title = str_replace('-', ' ', $this->uri->segment(1))){
         $title = 'Home';
      }

      if ($segment2 = str_replace('-', ' ', $this->uri->segment(2))){
         $title = $segment2 . " - " . $title;
      }
		
      $this->template->set_meta_title(ucwords($title) . " | " . $this->settings->config_site_name);
		$this->template->set_theme($this->settings->config_front_theme);
		//$this->template->set('sitename', $this->settings->site_name);
		if($this->profile->isLogged())
		{
 
		}
	}
	public function _remap($method, $params = array())
   {
	  
		if($this->profile->checkLogin())
		{
			redirect('/');
			//return Modules::run("/",$params);
			exit;
		}
		else if (method_exists($this, $method))
		{
			return call_user_func_array(array($this, $method), $params);
		}
		else
		{
			return modules::run("common/error",$params);
		}
		//show_404();
    }
	
}