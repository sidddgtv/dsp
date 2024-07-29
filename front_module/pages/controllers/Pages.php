<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pages extends MY_Controller {
	private $error = array();
	function __construct(){
		parent::__construct();
		$this->load->model('pages_model');
		$this->load->model('common/common_model');
	}
	
	/*public function index(){
		$data = array();
		$this->lang->load('pages');
		$id=0;
		if($this->uri->segment(3)){
			$id=$this->uri->segment(3);
		}else if($this->uri->segment(1)){
			$id=$this->pages_model->getIdbySlug($this->uri->segment(1));
		}		
		$page = $this->pages_model->getPageinfobyId($id);
		$Page_marketing_bottom = $this->pages_model->getPageContentinfobyId(18);
      	if (isset($page) && !empty($page)){  
         	if ($page['status'] != 'published'){
            	if ($page['status'] != 'draft' || ($page['status'] == 'draft' &&  ! $this->secure->group_types(array(ADMINISTRATOR))->is_auth())){
               		return $this->_404_error();
				}
         	}
         	$this->template->set('page_id', $page['id']);
         	$data['heading_title'] = $page['title'];
			$data['content'] = html_entity_decode($page['content'], ENT_QUOTES, 'UTF-8');	
			$data['meta_title'] = $page['meta_title'];
			$data['meta_description'] = html_entity_decode($page['meta_description'], ENT_QUOTES, 'UTF-8');	
			$data['data_position'] = 'left top';			
			$this->template->set_meta_description($page['meta_description'])
							->set_meta_keywords($page['meta_keywords']); 
			$data['layout']=$page['layout'];
			$data['page_info']=$page;
			$data['image'] = $page['image'];
			$data['config_email'] = $this->settings->config_email;
			$data['config_telephone'] = $this->settings->config_telephone;
			$data['config_web'] = $this->settings->config_web;
			$data['config_map'] = $this->settings->config_map;
			$data['config_footer_content'] = $this->settings->config_footer_content;
			$data['section_data'] = $this->pages_model->getPageSectionContent($page['id']);

			$menu_url = $this->uri->segment(1);	     
			$menu = $this->pages_model->getAllMenu($menu_url);	
			if($menu){
				$menu_id = $menu->parent_id;
				if($menu_id == 0){
					$menu_id = $menu->id;
				}else{
					$menu_id = $menu->parent_id;
				}
				$data['sub_menu'] = $this->pages_model->getAllSubMenu($menu_id);
				$data['parent_menu'] = $this->pages_model->getParentMenu($menu_id);
				$data['current_menu_title'] = $this->pages_model->getCurrentMenuTitle($page['slug']);
			}else{
				$data['sub_menu'] = array();
				$data['parent_menu'] = array();
				$data['current_menu_title'] = array();
			}
			$data['banner_description'] = $page['banner_description'];
			$data['testimonials'] = $this->pages_model->getTestimonial();
			$data['buildings'] = $this->pages_model->getBuildings();
			//printr($data['buildings']);exit;
			$data['what-sets-us-aside_banner'] = $this->pages_model->getBanner(33);
			$data['jobs'] = $this->pages_model->getjob();
			//printr($data['jobs']);exit;
			$this->template->view('pages', $data);
		}
	}

	public function viewdetails(){
		$data = array();
		$id = $this->uri->segment(3);
		$data['portfolio_data'] = $this->pages_model->getPortfolioWhere($id);
		$data['slider'] = $this->pages_model->getGalleriesById($id);
		$data['portfolios_before'] = $this->pages_model->getPortfolioBefore($id); 
		$this->template->view('viewdetails', $data);
	}

	public function home(){
		$data=array();
		$Page = $this->pages_model->getPageinfobyId(1);
      	if (isset($Page) && !empty($Page)){  
         	if ($Page['status'] != 'published'){
            	if ($Page->status != 'draft'){
               		return $this->error();
				}
         	}
         	$data['page_id']=$Page['id'];
			$data['content'] = html_entity_decode($Page['content'], ENT_QUOTES, 'UTF-8');
			$data['meta_title'] = $Page['meta_title'];
			$data['meta_description'] = html_entity_decode($Page['meta_description'], ENT_QUOTES, 'UTF-8');
			$data['video_content'] = html_entity_decode($Page['video_content'], ENT_QUOTES, 'UTF-8');	
			$data['config_email'] = $this->settings->config_email;
			$data['config_telephone'] = $this->settings->config_telephone;
			$data['config_web'] = $this->settings->config_web;
			$data['headertext']=true;
			$data['image'] = $Page['image'];
			$data['banner_description'] = $Page['banner_description'];
			$data['home_content'] = $Page['home_content'];	
      	}
		  
		$data['home_banners'] = $this->pages_model->getallbanners(32);
		
		
		
		$data['section_data'] = $this->pages_model->getPageSectionContent($data['page_id']);
		
		
		$slider = $data['current_featured_html'] = '';
		$data['current_id'] = 0;
		
		$data['slider'] = '<div class="projectslider homeslider lh-base">'.$slider.'</div>';
		
		
		$this->template->view('home',$data);

      	
	}

	public function familyapplication(){
		$data = array();
		$this->template->view('application', $data);
	}


	


	public function request(){
		$data['heading_title'] = "Info Request Form";
		$this->template->view('request', $data);
	}

	public function homeform(){
		if($_POST){
			if(trim($_POST['fname'])=='')
			{
				echo 'Must enter your first name';
			}
			elseif(trim($_POST['lname'])=='')
			{
				echo 'Must enter your Last name';
			}
			elseif(trim($_POST['email'])=='')
			{
				echo 'Must enter your email';
			}
			elseif (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", trim(strtolower($_POST['email']))))
			{ 
				echo "Must enter a valid email";
			}
			elseif(trim($_POST['phone'])=='')
			{
				echo 'Must enter your phone';
			}			
			else{
				//printr($_POST); exit;
				$to=$this->settings->config_email;
				$fname=$_POST["fname"];
				$lname=$_POST["lname"];
				$email=$_POST["email"];
				$phone=$_POST["phone"];
				//$this->db->insert("contact", $contact_data);
				$subject="Home Form | Serennna";
				$message="
				<table border='0' align='center' cellpadding='0' cellspacing='10' width='100%'>
				<tr>
				<td><strong>First Name:</strong>&nbsp;&nbsp;".$fname."</td>
				</tr>
				<tr>
				<td><strong>Last Name:</strong>&nbsp;&nbsp;".$lname."</td>
				</tr>
				<tr>
				<td><strong>Email:</strong>&nbsp;&nbsp;".$email."</td>
				</tr>
				<tr>
				<td><strong>Phone:</strong>&nbsp;&nbsp;".$phone."</td>
				</tr>
				</table>
				";	
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";	
				//$headers .= "From: ".$fname." <".$email.">\r\n";
				$headers .= "From: ".$fname." \r\n";
				//if(mail($to, $subject, $message, $headers))
				//{
				mail($to, $subject, $message, $headers);
					echo "12"; exit;
				//}
			}
		}else{
			return $this->error();
		}
	}

public function contactform(){
		if($_POST){
			if(trim($_POST['name'])=='')
			{
				echo 'Must enter your Name';
			}
			elseif(trim($_POST['email'])=='')
			{
				echo 'Must enter your email';
			}
			elseif (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", trim(strtolower($_POST['email']))))
			{ 
				echo "Must enter a valid email";
			}
			elseif(trim($_POST['phone'])=='')
			{
				echo 'Must enter your phone';
			}
			elseif(trim($_POST['comment'])=='')
			{
				echo 'Must enter your comment';
			}			
			else{
				//printr($_POST); exit;
				$to=$this->settings->config_email;
				$name=$_POST["name"];
				$email=$_POST["email"];
				$phone=$_POST["phone"];
				$comment=$_POST["comment"];
	
				//$this->db->insert("contact", $contact_data);
				$subject="Contact Form | Serennna";
				$message="
				<table border='0' align='center' cellpadding='0' cellspacing='10' width='100%'>
				<tr>
				<td><strong>Name:</strong>&nbsp;&nbsp;".$name."</td>
				</tr>
				<tr>
				<td><strong>Email:</strong>&nbsp;&nbsp;".$email."</td>
				</tr>
				<tr>
				<td><strong>Phone:</strong>&nbsp;&nbsp;".$phone."</td>
				</tr>
				<tr>
				<td><strong>Comment:</strong>&nbsp;&nbsp;".$comment."</td>
				</tr>
				</table>
				";	
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";	
				$headers .= "From: ".$name." <".$email.">\r\n";
				//if(mail($to, $subject, $message, $headers))
				//{
				mail($to, $subject, $message, $headers);
					echo "12"; exit;
				//}
			}
		}else{
			return $this->error();
		}
	}


	
	public function featured(){
		$data = $this->pages_model->getFeaturedwhereID($_POST['current_id']);

		$output = array();

		if($_POST['direction']){
			$output['current_id'] = $this->pages_model->getnextFeaturedID($_POST['current_id']);
		}else{
			$output['current_id'] = $this->pages_model->getprevFeaturedID($_POST['current_id']);
		}
		//<p class="lead">'.$data->description.'</p>
		//<h5 class="my-lg-4 my-2">'.$data->subtitle.'</h5>
		$output['html'] = '
				<h2 class="mt-xl-0 mt-4">'.$data->title.'</h2>
				
				<p class="lead">'.$data->description.'</p>
				<a href="'.base_url('pages/viewdetails/'.$data->id).'" class="btn btn-2 btn btn-outline-dark btn-lg my-4"><span>View Details<i class="las la-arrow-right ms-3"></i></span></a>
		';

		echo json_encode($output);
	}

	public function familyform(){
		$to=$this->settings->config_email;
		$page_data = array(
    				"fname" => $_POST["fname"],
    				"lname" => $_POST["lname"],
    				"email" => $_POST["email"],
    				"cellnumber" => $_POST["cellnumber"],
    				"location" => $_POST["location"],
    				"address" => $_POST["address"],
    				"neighborhood" => $_POST["neighborhood"],
    				"zipcode" => $_POST["zipcode"],
    				"settle" => $_POST["settle"],
    				"best" => $_POST["best"],
    				"schedule" => $_POST["schedule"],
    				"preferred" => $_POST["preferred"],
    				"children" => $_POST["children"],
    				"allergies" => $_POST["allergies"],
    				"employed" => $_POST["employed"],
    				"experience" => $_POST["experience"],
    				"preferred1" => $_POST["preferred1"],
    				"routine" => $_POST["routine"],
    				"spend" => $_POST["spend"],
    				"authority" => $_POST["authority"],
    				"position" => $_POST["position"],
    				"comfortable" => $_POST["comfortable"]
    			);

				$this->db->insert("family", $page_data);

				//$this->db->insert("contact", $contact_data);
				$subject="Family Application Form | Serennna";
				$message="
				<table border='0' align='center' cellpadding='0' cellspacing='10' width='100%'>
				<tr>
				<td><strong>First Name:</strong>&nbsp;&nbsp;".$_POST["fname"]."</td>
				</tr>
				<tr>
				<td><strong>Last Name:</strong>&nbsp;&nbsp;".$_POST["lname"]."</td>
				</tr>
				<tr>
				<td><strong>Email:</strong>&nbsp;&nbsp;".$_POST["email"]."</td>
				</tr>
				<tr>
				<td><strong>Phone:</strong>&nbsp;&nbsp;".$_POST["cellnumber"]."</td>
				</tr>
				<tr>
				<td><strong>Where are you currently located:</strong>&nbsp;&nbsp;".$_POST["location"]."</td>
				</tr>
				<tr>
				<td><strong>Address:</strong>&nbsp;&nbsp;".$_POST["address"]."</td>
				</tr>
				<tr>
				<td><strong>Neighborhood:</strong>&nbsp;&nbsp;".$_POST["neighborhood"]."</td>
				</tr>
				<tr>
				<td><strong>Zip code:</strong>&nbsp;&nbsp;".$_POST["zipcode"]."</td>
				</tr>
				<tr>
				<td><strong>If you are moving, please tell us where you plan to settle:</strong>&nbsp;&nbsp;".$_POST["settle"]."</td>
				</tr>
				<tr>
				<td><strong>Which option best describes what you're looking for:</strong>&nbsp;&nbsp;".$_POST["best"]."</td>
				</tr>
				<tr>
				<td><strong>What type of schedule are you searching for:</strong>&nbsp;&nbsp;".$_POST["schedule"]."</td>
				</tr>
				<tr>
				<td><strong>Preferred start date:</strong>&nbsp;&nbsp;".$_POST["preferred"]."</td>
				</tr>
				<tr>
				<td><strong>Number of children:</strong>&nbsp;&nbsp;".$_POST["children"]."</td>
				</tr>
				<tr>
				<td><strong>Special Needs- allergies, medical, behavioral:</strong>&nbsp;&nbsp;".$_POST["allergies"]."</td>
				</tr>
				<tr>
				<td><strong>Have you previously employed a nanny:</strong>&nbsp;&nbsp;".$_POST["employed"]."</td>
				</tr>
				<tr>
				<td><strong>If yes- what did you like most about the experience/nanny? Least or most challenging:</strong>&nbsp;&nbsp;".$_POST["experience"]."</td>
				</tr>
				<tr>
				<td><strong>Preferred start date:</strong>&nbsp;&nbsp;".$_POST["preferred1"]."</td>
				</tr>
				<tr>
				<td><strong>What is your child/children's normal routine:</strong>&nbsp;&nbsp;".$_POST["routine"]."</td>
				</tr>
				<tr>
				<td><strong>How do you like to spend time with your child:</strong>&nbsp;&nbsp;".$_POST["spend"]."</td>
				</tr>
				<tr>
				<td><strong>What's your method of authority/discipline like with your child:</strong>&nbsp;&nbsp;".$_POST["authority"]."</td>
				</tr>
				<tr>
				<td><strong>Is there anything else that you would like to tell us about your children, family, or the position?:</strong>&nbsp;&nbsp;".$_POST["position"]."</td>
				</tr>
				<tr>
				<td><strong>Current rates range from $30-$40+/hr. Is that a rate range you’re comfortable with:</strong>&nbsp;&nbsp;".$_POST["comfortable"]."</td>
				</tr>
				</table>
				";	
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";	
				//$headers .= "From: ".$fname." <".$email.">\r\n";
				$headers .= "From: ".$_POST["fname"]." \r\n";
				//if(mail($to, $subject, $message, $headers))
				//{
				mail($to, $subject, $message, $headers);
					//echo "12"; exit;
		echo 12;
	}
	
   

public function newjobform(){
	
		$to=$this->settings->config_email;
		
		$page_data = array(
			"job_id" => $_POST['job_id'],
			"name"=>$_POST["name"],
			"lname"=>$_POST["lname"],
			"preferred"=>$_POST["preferred"],
			"email"=>$_POST["email"],
			"cellphone"=>$_POST["cellphone"],
			"authorized" => (isset($_POST['authorized'])?$_POST['authorized']:''),
			"professional"=>$_POST["professional"],
			"area"=>$_POST["area"],
			"current_address"=>$_POST["current_address"],
			"license" => (isset($_POST['license'])?$_POST['license']:''),
			"vehicle" => (isset($_POST['vehicle'])?$_POST['vehicle']:''),
			"interested"=>$_POST["interested"],
			"caregiver"=>$_POST["caregiver"],
			"challenge"=>$_POST["challenge"],
			"education"=>$_POST["education"],
			"language"=>$_POST["language"],
			"looking" => isset($_POST['looking'])?$_POST['looking']:'',
			"commit" => isset($_POST['commit'])?$_POST['commit']:'',
			"relocate" => isset($_POST['relocate'])?$_POST['relocate']:'',
			"twins" => isset($_POST['twins'])?$_POST['twins']:'',
			"experience" => isset($_POST['experience'])?$_POST['experience']:'',
			"childcare"=>$_POST["childcare"],
			"comfortable" => isset($_POST['comfortable'])?$_POST['comfortable']:'',
			"passport" => isset($_POST['passport'])?$_POST['passport']:'',
			"certified" => isset($_POST['certified'])?$_POST['certified']:'',
			"hobbies"=>$_POST["hobbies"],

			//"fileToUpload" => '',



			"pastname"=>$_POST["pastname"],
			"pastphone"=>$_POST["pastphone"],
			"pastemail"=>$_POST["pastemail"],
			"pastwork"=>$_POST["pastwork"]
			);


				$this->db->insert("job_applications", $page_data);
				//$this->db->insert("contact", $contact_data);
				$subject="Job Form | Serennna";
				$message="
				<table border='0' align='center' cellpadding='0' cellspacing='10' width='100%'>
				<tr>
				<td><strong>Name:</strong>&nbsp;&nbsp;".$_POST["name"]."</td>
				</tr>
				<tr>
				<td><strong>lname:</strong>&nbsp;&nbsp;".$_POST["lname"]."</td>
				</tr>
				<tr>
				<td><strong>Preferred:</strong>&nbsp;&nbsp;".$_POST["preferred"]."</td>
				</tr>
				<tr>
				<td><strong>Email:</strong>&nbsp;&nbsp;".$_POST["email"]."</td>
				</tr>
				<tr>
				<td><strong>Phone number:</strong>&nbsp;&nbsp;".$_POST["cellphone"]."</td>
				</tr>
				<tr>
				<td><strong>Are you authorized to work in the US:</strong>&nbsp;&nbsp;".(isset($_POST['authorized'])?$_POST['authorized']:'')."</td>
				</tr>
				<tr>
				<td><strong>How many professional years of nanny experience do you have:</strong>&nbsp;&nbsp;".$_POST["professional"]."</td>
				</tr>
				<tr>
				<td><strong>Please tell us what area you are located in:</strong>&nbsp;&nbsp;".$_POST["area"]."</td>
				</tr>
				<tr>
				<td><strong>Current address:</strong>&nbsp;&nbsp;".$_POST["current_address"]."</td>
				</tr>
				<tr>
				<td><strong>Do you have a valid driver's license:</strong>&nbsp;&nbsp;".(isset($_POST['license'])?$_POST['license']:'')."</td>
				</tr>
				<tr>
				<td><strong>Do you have a reliable and insured vehicle:</strong>&nbsp;&nbsp;".(isset($_POST['vehicle'])?$_POST['vehicle']:'')."</td>
				</tr>
				<tr>
				<td><strong>What makes you interested in working with children:</strong>&nbsp;&nbsp;".$_POST["interested"]."</td>
				</tr>
				<tr>
				<td><strong>Please tell us more:</strong>&nbsp;&nbsp;".$_POST["caregiver"]."</td>
				</tr>
				<tr>
				<td><strong>What do you find most challenging or difficult about being a caregiver:</strong>&nbsp;&nbsp;".$_POST["challenge"]."</td>
				</tr>
				<tr>
				<td><strong>Highest form of education:</strong>&nbsp;&nbsp;".$_POST["education"]."</td>
				</tr>
				<tr>
				<td><strong>What is your first language? Do you speak any other languages:</strong>&nbsp;&nbsp;".$_POST["language"]."</td>
				</tr>
				<tr>
				<td><strong>Looking for:</strong>&nbsp;&nbsp;".(isset($_POST['looking'])?$_POST['looking']:'')."</td>
				</tr>
				<tr>
				<td><strong>Can you commit to one year:</strong>&nbsp;&nbsp;".(isset($_POST['commit'])?$_POST['commit']:'')."</td>
				</tr>
				<tr>
				<td><strong>Open to relocate for a new job:</strong>&nbsp;&nbsp;".(isset($_POST['relocate'])?$_POST['relocate']:'')."</td>
				</tr>
				<tr>
				<td><strong>Experience with twins, triplets:</strong>&nbsp;&nbsp;".(isset($_POST['twins'])?$_POST['twins']:'')."</td>
				</tr>
				<tr>
				<td><strong>Special needs experience:</strong>&nbsp;&nbsp;".(isset($_POST['experience'])?$_POST['experience']:'')."</td>
				</tr>
				<tr>
				<td><strong>Describe tasks you'd feel comfortable providing out of childcare:</strong>&nbsp;&nbsp;".$_POST["childcare"]."</td>
				</tr>
				<tr>
				<td><strong>Comfortable with traveling with the family:</strong>&nbsp;&nbsp;".(isset($_POST['comfortable'])?$_POST['comfortable']:'')."</td>
				</tr>
				<tr>
				<td><strong>Valid passport:</strong>&nbsp;&nbsp;".(isset($_POST['passport'])?$_POST['passport']:'')."</td>
				</tr>
				<tr>
				<td><strong>Are you currently cpr and/or first aid certified:</strong>&nbsp;&nbsp;".isset($_POST['certified'])?$_POST['certified']:''."</td>
				</tr>
				<tr>
				<td><strong>Now to the fun stuff, what do you like to do out of work? Hobbies? Interests? Self care routines:</strong>&nbsp;&nbsp;".$_POST["hobbies"]."</td>
				</tr>
				<tr>
				<td><strong>Past Employment Name:</strong>&nbsp;&nbsp;".$_POST["pastname"]."</td>
				</tr>
				<tr>
				<td><strong>Past Employment Phone Number:</strong>&nbsp;&nbsp;".$_POST["pastphone"]."</td>
				</tr>
				<tr>
				<td><strong>Past Employment Email:</strong>&nbsp;&nbsp;".$_POST["pastemail"]."</td>
				</tr>
				<tr>
				<td><strong>Past Employment work relationship:</strong>&nbsp;&nbsp;".$_POST["pastwork"]."</td>
				</tr>
				</table>
				";	
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";	
				//$headers .= "From: ".$fname." <".$email.">\r\n";
				$headers .= "From: ".$_POST["name"]." \r\n";
				mail($to, $subject, $message, $headers);
					echo 12;

}
				
	


















   //ADDITIONAL CODES
    function validate_captcha() {
        $captcha = $this->input->post('g-recaptcha-response');
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$this->config->item('recaptcha_sitekey')."&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']);

        if ($response . 'success' == false) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

	public function zzz(){

	}*/


   	public function error(){
      // Send a 404 Header
      	header("HTTP/1.0 404 Not Found");
		$data['heading_title'] = "Unknown Page.";
		$data['content'] = "Page not found.";
		$data['feature_image'] = '';
		$data['data_position'] = '';
      	$this->template->view('error', $data);
   }
	
			

/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */
}