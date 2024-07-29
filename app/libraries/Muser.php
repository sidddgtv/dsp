<?php
class Muser {
	public $CI;
	private $user_id;
	private $user_group_id;
	private $user_group_name;
	private $username;
	private $firstname;
	private $lastname;
	private $email;
	private $image;
	private $permission = array();
	private $user = array();

	public function __construct(){
		$this->CI =& get_instance(); 
		
		if ($this->CI->session->userdata('m_user_id')) {
			
			$this->CI->db->where('id',(int)$this->CI->session->userdata('m_user_id'));
			$this->CI->db->where('(user_group_id = 3 or user_group_id = 4)');
			$user_query = $this->CI->db->get('user');
			if($user_query->num_rows()){
				$res = $user_query->row();
				
				$this->user_id 		= $res->id;
				$this->username 		= $res->username;
				$this->firstname		= $res->firstname;
				$this->lastname		= $res->lastname;
				$this->email			= $res->email;
				$this->user_group_id	= $res->user_group_id;
				$this->image			= $res->image;
				
				//user group info
				$this->CI->db->where('id',$this->user_group_id);
				$user_group_query=$this->CI->db->get('user_group');
				$groups=$user_group_query->row();
				$this->user_group_name	= $groups->name;
				$permissions = json_decode($groups->permissions, true);
				
				//printr($permissions);
				if (is_array($permissions)) {
					foreach ($permissions as $key => $value) {
						$this->permission[$key] = $value;
					}
				}
			} else {
				$this->logout();
			}
		}
	}

	public function login($username, $password) {
		$this->CI->db->where('email',$username);
		$this->CI->db->where('password',md5($password));
		$this->CI->db->where('(user_group_id != 1)');
		
		$user_query = $this->CI->db->get('user');

		if ($user_query->num_rows())
		{

			$res = $user_query->row();

			if (!$res->enabled){
	            $this->CI->session->set_flashdata('message', $this->CI->lang->line('error_login_disable'));
	        }else if (!$res->activated){
				 $this->CI->session->set_flashdata('message', $this->CI->lang->line('error_login_deactive'));
			}else{

				$this->CI->session->set_userdata('m_user_id', $res->id);
				
				$this->user_id 		= $res->id;
				$this->username 		= $res->username;
				$this->firstname		= $res->firstname;
				$this->lastname		= $res->lastname;
				$this->email			= $res->email;
				$this->user_group_id	= $res->user_group_id;

				$this->image			= $res->image;
				
				$this->last_login 	= date("Y-m-d H:i:s");
				
				//user group info
				$this->CI->db->where('id',$this->user_group_id);
				$user_group_query=$this->CI->db->get('user_group');
				$groups=$user_group_query->row();
				$this->user_group_name	= $groups->name;
				$permissions = json_decode($groups->permissions, true);
				
				if (is_array($permissions)) {
					foreach ($permissions as $key => $value) {
						$this->permission[$key] = $value;
					}
				}
				
				//$this->user = $res;
				return $res;
				//return true;
			}
		} 
		else
		{
			$this->CI->session->set_flashdata('message', $this->CI->lang->line('error_login'));
		}
		return false;
	}

	public function logout() {
		$this->CI->session->unset_userdata('m_user_id');
		
		$this->user_id = '';
		$this->username = '';
	}
	
	
	public function hasPermission($key, $value=""){
		//echo $key;
		//printr($this->permission);
		//echo $value;
		//return true;
		//exit;
		if($this->user_group_id == 1)
		{
			return true;
		}
		if(!$value)
		{
			$value=$this->CI->uri->uri_string();
		}
		if (isset($this->permission[$key])) {
			return in_array($value, $this->permission[$key]);
		} else {
			return false;
		}
	}
	
	public function checkLogin() {
		
		$route = '';
		
		if($this->CI->uri->total_segments() == 2)
		{
			$route=$this->CI->uri->uri_string();
		}
		
		$ignore = array(	
			'common/login',
			'common/logout',
			'common/forgotten',
			'common/reset',
			'error/not_found',
			'error/permission'
		);
		
		if (!$this->isLogged() && !in_array($route, $ignore)) {
			return true;
		}
		
	}
	public function checkPermission() {
		
		$route = '';
		
		$uri_string=$this->CI->uri->uri_string();
		
		//echo $this->CI->uri->total_segments();
		if($this->CI->uri->total_segments() == 1)
			$uri_string = $this->CI->uri->uri_string().'/common/dashboard/index';
		elseif($this->CI->uri->total_segments() == 2)
			$uri_string=$this->CI->uri->uri_string().'/index';
		//echo $uri_string;

		$uri_string = substr($uri_string, strpos($uri_string, '/') + 1);
		$segment_array=$this->CI->uri->segment_array();
		//print_r($segment_array);
		if(isset($segment_array[2]))
		{
			$class=$this->CI->router->fetch_class();
			$method=$this->CI->router->fetch_method();
			
			//echo $class;
			
			if($segment_array[2]==$class)
			{
				$uri_string=$class."/".$method;
			}else{
				//echo "ok";
				$uri_string=$segment_array[2]."/".$class."/".$method;
			}
		} 
		//echo $uri_string;
		//$uri_string = substr($uri_string, strpos($uri_string, '/') + 1);
		
		$route=str_replace('-', '_', $uri_string);
		//echo $route;
		//$route=substr($route, 0, strpos($route, "/index"));
		//echo $route;
		//exit;
		if($route==""){
			$route="common/dashboard/index";
		}
		//printr($this->permission);
		$ignore = array(
			'common/dashboard/index',
			'login/index',
			'logout/index',
			'forgot-password',
			'column_left/index',
			'column_top/index',
			'errors/index',
			'footer/index',
			'header/index'
		);

		if($this->user_group_id == 1){
			return true;
		}else if (!in_array($route, $ignore) && !$this->hasPermission('access', $route)) {
			//echo "pk";
			return false;
		}else{
			return true;
		}
		
		
		
	}
	/*
     * Check Remember Me
     *
     * Checks if user has a remember me cookie set 
     * and logs user in if validation is true
     *
     * @return bool
     */
    function check_remember_me()
    {
        
        $rememberme = $this->CI->input->cookie('rememberme');

        if ($rememberme !== FALSE)
        {
            $rememberme = @unserialize($rememberme);

            // Insure we have all the data we need
            if ( ! isset($rememberme['username']) || ! isset($rememberme['token']))
            {
                return FALSE;
            }

            
			
			// Database query to lookup email and password
			$this->db->where('username', $rememberme['username']);
			$this->db->where('(group_id=1 or group_id=2)');
			$query = $this->db->get('users');
			$User=$query->row();
			
            // If user found validate token and login
            if ($query->num_rows() && $rememberme['token'] == md5($User->last_login . $this->CI->config->item('encryption_key') . $User->password))
            {
                if ( ! $User->enabled || ($this->CI->settings->users_module->email_activation && ! $User->activated))
                {
                    return FALSE;
                }

                $User->last_login = date("Y-m-d H:i:s");
                $this->create_session($User->id);
                
                $this->set_remember_me($User);
                return TRUE;
            }
        }

        return FALSE;
    }
	/*
     * Set Remember Me
     *
     * Sets a remember  me cookie on the clients computer
     *
     * @param object
     * @return void
     */
    function set_remember_me($User)
    {
        

        $cookie = array(
            'name'   => 'rememberme',
            'value'  => serialize(array(
                'username' => $User->username,
                'token' => md5($User->last_login . $this->CI->config->item('encryption_key') . $User->password),
            )),
            'expire' => '1209600',
        );

        $this->CI->input->set_cookie($cookie);
    }

    // --------------------------------------------------------------------

    /*
     * Destroy Remember Me
     *
     * Destroy remember me cookie on the clients computer
     *
     * @return void
     */
    function destroy_remember_me()
    {
        
        $cookie = array(
            'name'   => 'rememberme',
            'value'  => '',
            'expire' => '',
        );

        $this->CI->input->set_cookie($cookie);
   }
	public function isLogged() {
		
		return $this->user_id;
	}

	public function getId() {
		return $this->user_id;
	}

	public function getUserName() {
		return $this->username;
	}
	
	public function getFirstName() {
		return $this->firstname;
	}

	public function getLastName() {
		return $this->lastname;
	}

	public function getEmail() {
		return $this->email;
	}

	public function getPhone() {
		return $this->phone;
	}
	
	public function getGroupId() {
		return $this->user_group_id;
	}

	public function getGroupName() {
		return $this->user_group_name;
	}
	
	public function getImage() {
		
		if ($this->image && is_file(DIR_UPLOAD . $this->image)) {
			$photo = resize($this->image, 300, 300);
		} else {
			$photo = resize('no_image.png', 20, 20);
		}
		return $photo;
	}
}