<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Setting extends Admin_Controller {
	private $error = array();
	
	function __construct(){
      parent::__construct();
		$this->load->model('setting_model');
		$this->load->model('users/users_model');
		$this->load->model('fleet/fleet_model');			
	}
	
	public function index(){
		// Init
      $data = array();
		$data = $this->lang->load('setting');
		$this->template->set_meta_title($this->lang->line('heading_title'));
		$this->template->add_package(array('ckeditor','colorbox', 'select2'),true);
        
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => base_url('setting')
		);
		
		
		if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->validateSetting()){
			//printr($this->input->post());
			$this->setting_model->editSetting('config',$this->input->post());
			
			$userdata=array(
                            
				"name"=>$this->input->post('name'),
				"password"=>md5($this->input->post('password')),
				"show_password"=>$this->input->post('password'),
			);
			
			$userid=$this->users_model->editUser(1,$userdata);
			$this->session->set_flashdata('message', 'Settings Saved');
			redirect(current_url());
		}
		
		
		$data['action'] = admin_url('setting');
		$data['cancel'] = admin_url('setting');

				
		if(isset($this->error['warning']))
		{
			$data['error'] 	= $this->error['warning'];
		}
		
		if ($this->input->server('REQUEST_METHOD') != 'POST') {
			$user_info = $this->users_model->getUser(1);
		}
		
		/*General Tab*/
		if ($this->input->post('config_site_title')){
			$data['config_site_title'] = $this->input->post('config_site_title');
		} else {
			$data['config_site_title'] = $this->settings->config_site_title;
		}
		
		if ($this->input->post('config_site_tagline')){
			$data['config_site_tagline'] = $this->input->post('config_site_tagline');
		} else {
			$data['config_site_tagline'] = $this->settings->config_site_tagline;
		}
		
        if ($this->input->post('config_site_logo')) {
			$data['config_site_logo'] = $this->input->post('config_site_logo');
		} else {
			$data['config_site_logo'] = $this->settings->config_site_logo;
		}
		
		if ($this->input->post('config_site_logo') && is_file(DIR_UPLOAD . $this->input->post('config_site_logo'))) {
			$data['thumb_logo'] = resize($this->input->post('config_site_logo'), 100, 100);
		} elseif ($this->settings->config_site_logo && is_file(DIR_UPLOAD . $this->settings->config_site_logo)) {
			$data['thumb_logo'] = resize($this->settings->config_site_logo, 100, 100);
		} else {
			$data['thumb_logo'] = resize('no_image.png', 100, 100);
		}
        
		if ($this->input->post('config_site_icon')) {
			$data['config_site_icon'] = $this->input->post('config_site_icon');
		} else {
			$data['config_site_icon'] = $this->settings->config_site_icon;
		}

		if ($this->input->post('config_site_icon') && is_file(DIR_UPLOAD . $this->input->post('config_site_icon'))) {
			$data['thumb_icon'] = resize($this->input->post('config_site_icon'), 100, 100);
		} elseif ($this->settings->config_site_icon && is_file(DIR_UPLOAD . $this->settings->config_site_icon)) {
			$data['thumb_icon'] = resize($this->settings->config_site_icon, 100, 100);
		} else {
			$data['thumb_icon'] = resize('no_image.png', 100, 100);
		}
		
		$data['no_image'] = resize('no_image.png', 100, 100);
		
		if ($this->input->post('config_meta_title')) {
			$data['config_meta_title'] = $this->input->post('config_meta_title');
		} else {
			$data['config_meta_title'] = $this->settings->config_meta_title;
		}
		
		if ($this->input->post('config_meta_description')) {
			$data['config_meta_description'] = $this->input->post('config_meta_description');
		} else {
			$data['config_meta_description'] = $this->settings->config_meta_description;
		}
		
		if ($this->input->post('config_meta_keywords')) {
			$data['config_meta_keywords'] = $this->input->post('config_meta_keywords');
		} else {
			$data['config_meta_keywords'] = $this->settings->config_meta_keywords;
		}
		
		/*Site info tab*/
		
		if ($this->input->post('config_site_owner')) {
			$data['config_site_owner'] = $this->input->post('config_site_owner');
		} else {
			$data['config_site_owner'] = $this->settings->config_site_owner;
		}
		
		if ($this->input->post('config_address')) {
			$data['config_address'] = $this->input->post('config_address');
		} else {
			$data['config_address'] = $this->settings->config_address;
		}
		
		//$this->load->model('localisation/country_model');
		//$data['countries'] = $this->country_model->getCountries();
		$data['countries'] = '';
		
		if ($this->input->post('config_country_id')) {
			$data['config_country_id'] = $this->input->post('config_country_id');
		} else {
			$data['config_country_id'] = $this->settings->config_country_id;
		}
		
		if ($this->input->post('config_state_id')) {
			$data['config_state_id'] = $this->input->post('config_state_id');
		} else {
			$data['config_state_id'] = $this->settings->config_state_id;
		}
		
		if ($this->input->post('config_email')) {
			$data['config_email'] = $this->input->post('config_email');
		} else {
			$data['config_email'] = $this->settings->config_email;
		}
		
		if ($this->input->post('config_telephone')) {
			$data['config_telephone'] = $this->input->post('config_telephone');
		} else {
			$data['config_telephone'] = $this->settings->config_telephone;
		}
		/*account tab*/
		
		if ($this->input->post('name')) {
			$data['name'] = $this->input->post('name');
		} elseif (!empty($user_info)) {
			$data['name'] = $user_info->name;
		} else {
			$data['name'] = '';
		}
                
		
		if ($this->input->post('password')) {
			$data['password'] = $this->input->post('password');
		} elseif (!empty($user_info)) {
			$data['password'] = $user_info->show_password;
		} else {
			$data['password'] = '';
		}

		if ($this->input->post('config_loginid')) {
			$data['config_loginid'] = $this->input->post('config_loginid');
		} else {
			$data['config_loginid'] = $this->settings->config_loginid;
		}

		if ($this->input->post('config_key')) {
			$data['config_key'] = $this->input->post('config_key');
		} else {
			$data['config_key'] = $this->settings->config_key;
		}
		
		/*social tab*/
		
		if ($this->input->post('config_facebook')) {
			$data['config_facebook'] = $this->input->post('config_facebook');
		} else {
			$data['config_facebook'] = $this->settings->config_facebook;
		}
		
		if ($this->input->post('config_setting_facebook')) {
			$data['config_setting_facebook'] = $this->input->post('config_setting_facebook');
		} else {
			$data['config_setting_facebook'] = $this->settings->config_setting_facebook;
		}
		
		if ($this->input->post('config_twitter')) {
			$data['config_twitter'] = $this->input->post('config_twitter');
		} else {
			$data['config_twitter'] = $this->settings->config_twitter;
		}
		
		if ($this->input->post('config_setting_twitter')) {
			$data['config_setting_twitter'] = $this->input->post('config_setting_twitter');
		} else {
			$data['config_setting_twitter'] = $this->settings->config_setting_twitter;
		}
		
		if ($this->input->post('config_gplus')) {
			$data['config_gplus'] = $this->input->post('config_gplus');
		} else {
			$data['config_gplus'] = $this->settings->config_gplus;
		}
		
		if ($this->input->post('config_setting_gplus')) {
			$data['config_setting_gplus'] = $this->input->post('config_setting_gplus');
		} else {
			$data['config_setting_gplus'] = $this->settings->config_setting_gplus;
		}
		
		if ($this->input->post('config_youtube')) {
			$data['config_youtube'] = $this->input->post('config_youtube');
		} else {
			$data['config_youtube'] = $this->settings->config_youtube;
		}
		
		if ($this->input->post('config_setting_youtube')) {
			$data['config_setting_youtube'] = $this->input->post('config_setting_youtube');
		} else {
			$data['config_setting_youtube'] = $this->settings->config_setting_youtube;
		}
		
		if ($this->input->post('config_pinterest')) {
			$data['config_pinterest'] = $this->input->post('config_pinterest');
		} else {
			$data['config_pinterest'] = $this->settings->config_pinterest;
		}
		
		if ($this->input->post('config_setting_pinterest')) {
			$data['config_setting_pinterest'] = $this->input->post('config_setting_pinterest');
		} else {
			$data['config_setting_pinterest'] = $this->settings->config_setting_pinterest;
		}
		
		if ($this->input->post('config_instagram')) {
			$data['config_instagram'] = $this->input->post('config_instagram');
		} else {
			$data['config_instagram'] = $this->settings->config_instagram;
		}
		
		if ($this->input->post('config_setting_instagram')) {
			$data['config_setting_instagram'] = $this->input->post('config_setting_instagram');
		} else {
			$data['config_setting_instagram'] = $this->settings->config_setting_instagram;
		}
		
		if ($this->input->post('config_linkedin')) {
			$data['config_linkedin'] = $this->input->post('config_linkedin');
		} else {
			$data['config_linkedin'] = $this->settings->config_linkedin;
		}
		
		if ($this->input->post('config_setting_linkedin')) {
			$data['config_setting_linkedin'] = $this->input->post('config_setting_linkedin');
		} else {
			$data['config_setting_linkedin'] = $this->settings->config_setting_linkedin;
		}
		
		if ($this->input->post('config_yelp')) {
			$data['config_yelp'] = $this->input->post('config_yelp');
		} else {
			$data['config_yelp'] = $this->settings->config_yelp;
		}
		
		if ($this->input->post('config_setting_yelp')) {
			$data['config_setting_yelp'] = $this->input->post('config_setting_yelp');
		} else {
			$data['config_setting_yelp'] = $this->settings->config_setting_yelp;
		}
		
		if ($this->input->post('config_soundcloud')) {
			$data['config_soundcloud'] = $this->input->post('config_soundcloud');
		} else {
			$data['config_soundcloud'] = $this->settings->config_soundcloud;
		}
		
		if ($this->input->post('config_setting_soundcloud')) {
			$data['config_setting_soundcloud'] = $this->input->post('config_setting_soundcloud');
		} else {
			$data['config_setting_soundcloud'] = $this->settings->config_setting_soundcloud;
		}
		
		if ($this->input->post('config_weixin')) {
			$data['config_weixin'] = $this->input->post('config_weixin');
		} else {
			$data['config_weixin'] = $this->settings->config_weixin;
		}

		if ($this->input->post('config_footer_content')) {
			$data['config_footer_content'] = $this->input->post('config_footer_content');
		} else {
			$data['config_footer_content'] = $this->settings->config_footer_content;
		}
		
		if ($this->input->post('config_setting_weixin')) {
			$data['config_setting_weixin'] = $this->input->post('config_setting_weixin');
		} else {
			$data['config_setting_weixin'] = $this->settings->config_setting_weixin;
		}
		
		if ($this->input->post('config_zipcode_check')) {
			$data['config_zipcode_check'] = $this->input->post('config_zipcode_check');
		} else {
			$data['config_zipcode_check'] = $this->settings->config_zipcode_check;
		}

		if ($this->input->post('config_sfwash_step')) {
			$data['config_sfwash_step'] = $this->input->post('config_sfwash_step');
		} else {
			$data['config_sfwash_step'] = $this->settings->config_sfwash_step;
		}

		if ($this->input->post('config_sfwash_focus')) {
			$data['config_sfwash_focus'] = $this->input->post('config_sfwash_focus');
		} else {
			$data['config_sfwash_focus'] = $this->settings->config_sfwash_focus;
		}

		if ($this->input->post('config_sfwash_mission')) {
			$data['config_sfwash_mission'] = htmlspecialchars($this->settings->config_sfwash_mission);
		} else {
			$data['config_sfwash_mission'] =  html_entity_decode(stripslashes($this->settings->config_sfwash_mission), ENT_QUOTES, 'UTF-8');
		}
		
		/*Library tab*/
		
		if ($this->input->post('config_library_fine')) {
			$data['config_library_fine'] = $this->input->post('config_library_fine');
		} else {
			$data['config_library_fine'] = $this->settings->config_library_fine;
		}
		
		if ($this->input->post('config_auto_fine')) {
			$data['config_auto_fine'] = $this->input->post('config_auto_fine');
		} else {
			$data['config_auto_fine'] = $this->settings->config_auto_fine;
		}
		
		if ($this->input->post('config_issue_limit_books')) {
			$data['config_issue_limit_books'] = $this->input->post('config_issue_limit_books');
		} else {
			$data['config_issue_limit_books'] = $this->settings->config_issue_limit_books;
		}
		
		if ($this->input->post('config_issue_limit_days')) {
			$data['config_issue_limit_days'] = $this->input->post('config_issue_limit_days');
		} else {
			$data['config_issue_limit_days'] = $this->settings->config_issue_limit_days;
		}
		
		if ($this->input->post('config_receipt_prefix')) {
			$data['config_receipt_prefix'] = $this->input->post('config_receipt_prefix');
		} else {
			$data['config_receipt_prefix'] = $this->settings->config_receipt_prefix;
		}
		
		if ($this->input->post('config_display_stock')) {
			$data['config_display_stock'] = $this->input->post('config_display_stock');
		} else {
			$data['config_display_stock'] = $this->settings->config_display_stock;
		}
		
		if ($this->input->post('config_stock_warning')) {
			$data['config_stock_warning'] = $this->input->post('config_stock_warning');
		} else {
			$data['config_stock_warning'] = $this->settings->config_stock_warning;
		}
		
		if ($this->input->post('config_display_stock')) {
			$data['config_display_stock'] = $this->input->post('config_display_stock');
		} else {
			$data['config_display_stock'] = $this->settings->config_display_stock;
		}
		
		if ($this->input->post('config_mail_alert')) {
			$data['config_mail_alert'] = $this->input->post('config_mail_alert');
		} else {
			$data['config_mail_alert'] = $this->settings->config_mail_alert;
		}
		
		if ($this->input->post('config_sms_alert')) {
			$data['config_sms_alert'] = $this->input->post('config_sms_alert');
		} else {
			$data['config_sms_alert'] = $this->settings->config_sms_alert;
		}
		
		if ($this->input->post('config_delay_members')) {
			$data['config_delay_members'] = $this->input->post('config_delay_members');
		} else {
			$data['config_delay_members'] = $this->settings->config_delay_members;
		}
		
		/*Apperance tab*/
		
		$data['pages'] = $this->setting_model->getPages();
		
		if ($this->input->post('config_site_homepage')) {
			$data['config_site_homepage'] = $this->input->post('config_site_homepage');
		} else {
			$data['config_site_homepage'] = $this->settings->config_site_homepage;
		}
		
		$data['front_themes'] = $this->template->get_themes();
		//printr($data['front_themes']);
		
		if ($this->input->post('config_front_theme')) {
			$data['config_front_theme'] = $this->input->post('config_front_theme');
		} else {
			$data['config_front_theme'] = $this->settings->config_front_theme;
		}
		
		$front_theme = $this->settings->config_front_theme?$this->settings->config_front_theme:'default';
		
      $data['front_templates'] = $this->template->get_theme_layouts($front_theme);
		
		if ($this->input->post('config_front_template')) {
			$data['config_front_template'] = $this->input->post('config_front_template');
		} else {
			$data['config_front_template'] = $this->settings->config_front_template;
		}
		
		
		if ($this->input->post('config_header_layout')) {
			$data['config_header_layout'] = $this->input->post('config_header_layout');
		} else {
			$data['config_header_layout'] = $this->settings->config_header_layout;
		}
		
		if ($this->input->post('config_header_image')) {
			$data['config_header_image'] = $this->input->post('config_header_image');
		} else {
			$data['config_header_image'] = $this->settings->config_header_image;
		}
		
		if ($this->input->post('config_header_image') && is_file(DIR_UPLOAD . $this->input->post('config_header_image'))) {
			$data['thumb_header_image'] = resize($this->input->post('config_header_image'), 100, 100);
		} elseif ($this->settings->config_header_image && is_file(DIR_UPLOAD . $this->settings->config_header_image)) {
			$data['thumb_header_image'] = resize($this->settings->config_header_image, 100, 100);
		} else {
			$data['thumb_header_image'] = resize('no_image.png', 100, 100);
		}
		
		$data['banners'] = '';//$this->setting_model->getBanners();
		
		if ($this->input->post('config_header_banner')) {
			$data['config_header_banner'] = $this->input->post('config_header_banner');
		} else {
			$data['config_header_banner'] = $this->settings->config_header_banner;
		}
		
		if ($this->input->post('config_background_image')) {
			$data['config_background_image'] = $this->input->post('config_background_image');
		} else {
			$data['config_background_image'] = $this->settings->config_background_image;
		}
		
		if ($this->input->post('background_image') && is_file(DIR_UPLOAD . $this->input->post('background_image'))) {
			$data['thumb_background_image'] = resize($this->input->post('background_image'), 100, 100);
		} elseif ($this->settings->config_background_image && is_file(DIR_UPLOAD . $this->settings->config_background_image)) {
			$data['thumb_background_image'] = resize($this->settings->config_background_image, 100, 100);
		} else {
			$data['thumb_background_image'] = resize('no_image.png', 100, 100);
		}
		
		if ($this->input->post('config_background_position')) {
			$data['config_background_position'] = $this->input->post('config_background_position');
		} else {
			$data['config_background_position'] = $this->settings->config_background_position;
		}
		
		if ($this->input->post('config_background_repeat')) {
			$data['config_background_repeat'] = $this->input->post('config_background_repeat');
		} else {
			$data['config_background_repeat'] = $this->settings->config_background_repeat;
		}
		
		if ($this->input->post('config_background_attachment')) {
			$data['config_background_attachment'] = $this->input->post('config_background_attachment');
		} else {
			$data['config_background_attachment'] = $this->settings->config_background_attachment;
		}
		
		if ($this->input->post('config_background_color')) {
			$data['config_background_color'] = $this->input->post('config_background_color');
		} else {
			$data['config_background_color'] = $this->settings->config_background_color;
		}
		
		if ($this->input->post('config_text_color')) {
			$data['config_text_color'] = $this->input->post('config_text_color');
		} else {
			$data['config_text_color'] = $this->settings->config_text_color;
		}
		
		/*Ftp tab*/
		
		if ($this->input->post('config_ftp_host')) {
			$data['config_ftp_host'] = $this->input->post('config_ftp_host');
		} else {
			$data['config_ftp_host'] = $this->settings->config_ftp_host;
		}
		
		if ($this->input->post('config_ftp_port')) {
			$data['config_ftp_port'] = $this->input->post('config_ftp_port');
		} else {
			$data['config_ftp_port'] = $this->settings->config_ftp_port;
		}
		
		if ($this->input->post('config_ftp_name')) {
			$data['config_ftp_name'] = $this->input->post('config_ftp_name');
		} else {
			$data['config_ftp_name'] = $this->settings->config_ftp_name;
		}
		
		if ($this->input->post('config_ftp_password')) {
			$data['config_ftp_password'] = $this->input->post('config_ftp_password');
		} else {
			$data['config_ftp_password'] = $this->settings->config_ftp_password;
		}
		
		if ($this->input->post('config_ftp_root')) {
			$data['config_ftp_root'] = $this->input->post('config_ftp_root');
		} else {
			$data['config_ftp_root'] = $this->settings->config_ftp_root;
		}
		
		if ($this->input->post('config_ftp_enable')) {
			$data['config_ftp_enable'] = $this->input->post('config_ftp_enable');
		} else {
			$data['config_ftp_enable'] = $this->settings->config_ftp_enable;
		}
		
		/*Mail tab*/
		
		if ($this->input->post('config_mail_protocol')) {
			$data['config_mail_protocol'] = $this->input->post('config_mail_protocol');
		} else {
			$data['config_mail_protocol'] = $this->settings->config_mail_protocol;
		}
		
		if ($this->input->post('config_mail_parameter')) {
			$data['config_mail_parameter'] = $this->input->post('config_mail_parameter');
		} else {
			$data['config_mail_parameter'] = $this->settings->config_mail_parameter;
		}
		
		if ($this->input->post('config_smtp_host')) {
			$data['config_smtp_host'] = $this->input->post('config_smtp_host');
		} else {
			$data['config_smtp_host'] = $this->settings->config_smtp_host;
		}
		
		if ($this->input->post('config_smtp_name')) {
			$data['config_smtp_name'] = $this->input->post('config_smtp_name');
		} else {
			$data['config_smtp_name'] = $this->settings->config_smtp_name;
		}
		
		if ($this->input->post('config_smtp_password')) {
			$data['config_smtp_password'] = $this->input->post('config_smtp_password');
		} else {
			$data['config_smtp_password'] = $this->settings->config_smtp_password;
		}
		
		if ($this->input->post('config_smtp_port')) {
			$data['config_smtp_port'] = $this->input->post('config_smtp_port');
		} else {
			$data['config_smtp_port'] = $this->settings->config_smtp_port;
		}
		
		if ($this->input->post('config_smtp_timeout')) {
			$data['config_smtp_timeout'] = $this->input->post('config_smtp_timeout');
		} else {
			$data['config_smtp_timeout'] = $this->settings->config_smtp_timeout;
		}
		
		/*Server tab*/
		
		if ($this->input->post('config_ssl')) {
			$data['config_ssl'] = $this->input->post('config_ssl');
		} else {
			$data['config_ssl'] = $this->settings->config_ssl;
		}
		
		if ($this->input->post('config_robots')) {
			$data['config_robots'] = $this->input->post('config_robots');
		} else {
			$data['config_robots'] = $this->settings->config_robots;
		}
		//$this->load->helper('date');
		//printr(tz_list());
		$data['timezone']=tz_list();
		//printr($data['timezone']);
		if ($this->input->post('config_time_zone')) {
			$data['config_time_zone'] = $this->input->post('config_time_zone');
		} else {
			$data['config_time_zone'] = $this->settings->config_time_zone;
		}
		
		if ($this->input->post('config_date_format')) {
			$data['config_date_format'] = $this->input->post('config_date_format');
		} else {
			$data['config_date_format'] = $this->settings->config_date_format;
		}
		
		if ($this->input->post('config_date_format_custom')) {
			$data['config_date_format_custom'] = $this->input->post('config_date_format_custom');
		} else {
			$data['config_date_format_custom'] = $this->settings->config_date_format_custom;
		}
		
		if ($this->input->post('config_time_format')) {
			$data['config_time_format'] = $this->input->post('config_time_format');
		} else {
			$data['config_time_format'] = $this->settings->config_time_format;
		}
		
		if ($this->input->post('config_time_format_custom')) {
			$data['config_time_format_custom'] = $this->input->post('config_time_format_custom');
		} else {
			$data['config_time_format_custom'] = $this->settings->config_time_format_custom;
		}
		
		if ($this->input->post('config_pagination_limit_front')) {
			$data['config_pagination_limit_front'] = $this->input->post('config_pagination_limit_front');
		} else {
			$data['config_pagination_limit_front'] = $this->settings->config_pagination_limit_front;
		}
		
		if ($this->input->post('config_pagination_limit_admin')) {
			$data['config_pagination_limit_admin'] = $this->input->post('config_pagination_limit_admin');
		} else {
			$data['config_pagination_limit_admin'] = $this->settings->config_pagination_limit_admin;
		}
		
		if ($this->input->post('config_seo_url')) {
			$data['config_seo_url'] = $this->input->post('config_seo_url');
		} else {
			$data['config_seo_url'] = $this->settings->config_seo_url;
		}
		
		if ($this->input->post('config_max_file_size')) {
			$data['config_max_file_size'] = $this->input->post('config_max_file_size');
		} else {
			$data['config_max_file_size'] = $this->settings->config_max_file_size;
		}
		
		if ($this->input->post('config_file_extensions')) {
			$data['config_file_extensions'] = $this->input->post('config_file_extensions');
		} else {
			$data['config_file_extensions'] = $this->settings->config_file_extensions;
		}
		
		if ($this->input->post('config_file_mimetypes')) {
			$data['config_file_mimetypes'] = $this->input->post('config_file_mimetypes');
		} else {
			$data['config_file_mimetypes'] = $this->settings->config_file_mimetypes;
		}
		
		if ($this->input->post('config_maintenance_mode')) {
			$data['config_maintenance_mode'] = $this->input->post('config_maintenance_mode');
		} else {
			$data['config_maintenance_mode'] = $this->settings->config_maintenance_mode;
		}
		
		if ($this->input->post('config_compression_level')) {
			$data['config_compression_level'] = $this->input->post('config_compression_level');
		} else {
			$data['config_compression_level'] = $this->settings->config_compression_level;
		}
		
		if ($this->input->post('config_encryption_key')) {
			$data['config_encryption_key'] = $this->input->post('config_encryption_key');
		} else {
			$data['config_encryption_key'] = $this->settings->config_encryption_key;
		}
		
		if ($this->input->post('config_display_error')) {
			$data['config_display_error'] = $this->input->post('config_display_error');
		} else {
			$data['config_display_error'] = $this->settings->config_display_error;
		}
		
		if ($this->input->post('config_log_error')) {
			$data['config_log_error'] = $this->input->post('config_log_error');
		} else {
			$data['config_log_error'] = $this->settings->config_log_error;
		}
		
		if ($this->input->post('config_error_log_filename')) {
			$data['config_error_log_filename'] = $this->input->post('config_error_log_filename');
		} else {
			$data['config_error_log_filename'] = $this->settings->config_error_log_filename;
		}
		

      	$this->template->view('setting', $data);
	}

	public function fleets(){

		$data = $this->lang->load('setting');
		$this->template->set_meta_title($this->lang->line('heading_title'));
		$this->template->add_package(array('ckeditor','colorbox', 'select2'),true);
        
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => base_url('setting')
		);

		$data['cancel'] = admin_url('setting');
		/*Route Type Tab*/
		$data['route_types'] = $this->fleet_model->getAllRouteType();

		/*Vehicle Provider Tab*/
		$data['vehicle_providers'] = $this->fleet_model->getAllVehicleProvider();

		/*Ownership Type Tab*/
		$data['ownership_types'] = $this->fleet_model->getAllOwnershipType();
		
		/*Service Tier Tab*/
		$data['service_tier'] = $this->fleet_model->getAllServiceTier();
		/*Car Makes Tab*/
		$data['car_makes'] = $this->fleet_model->getAllVehicleMakes();
		/*Status Reason Codes Tab*/
		$data['status_reason_codes'] = $this->fleet_model->getAllStatusReasonCode();
		/*Car Models Tab*/
		$data['car_models'] = $this->fleet_model->getAllVehicleModels();
		$this->template->view('fleet', $data);
	}

	public function bonus(){

		$data = $this->lang->load('setting');
		$this->template->set_meta_title($this->lang->line('heading_title'));
		$this->template->add_package(array('ckeditor','colorbox', 'select2'),true);
        
		$data['breadcrumbs'] = array();
		$data['breadcrumbs'][] = array(
			'text' => $this->lang->line('heading_title'),
			'href' => base_url('setting')
		);
		
		$data['cancel'] = admin_url('setting');

		/* Bonus Amount Tab*/
		$data['bonus_amount'] = $this->setting_model->getActiveBonusAmount();
		/* Bonus Amount Tab*/
		$data['bonus_type'] = $this->setting_model->getActiveBonusType();
		$data['all_bonus_type'] = $this->setting_model->getAllBonusType();

		/* Point Type Tab*/
		$data['all_point_type'] = $this->setting_model->getAllPointType();
		$data['point_type'] = $this->setting_model->getActivePointType();
		// echo '<pre>';
		// print_r($data);exit;
		$data['point_rule'] = $this->setting_model->getAllPointRule();
		$data['fall_off'] = $this->setting_model->getFallOff();
		
		/* Point Type Tab*/
		$data['working_shift'] = $this->setting_model->getActiveWorkingShift();

		/* Payroll Tab*/
		$data['all_payroll'] = $this->setting_model->getPayroll();
		$data['payroll'] = $this->setting_model->getActivePayroll();
		
		$this->template->view('bonus', $data);
	}
	
	public function validateSetting(){
		$regex = "(\/?([a-zA-Z0-9+\$_-]\.?)+)*\/?"; // Path
      $regex .= "(\?[a-zA-Z+&\$_.-][a-zA-Z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
      $regex .= "(#[a-zA-Z_.-][a-zA-Z0-9+\$_.-]*)?"; // Anchor 
		
		$rules=array(
			'config_site_title' => array(
				'field' => 'config_site_title', 
				'label' => 'Site Title', 
				'rules' => "trim|required"
			),
			'config_site_tagline' => array(
				'field' => 'config_site_tagline', 
				'label' => 'Site Tagline', 
				'rules' => "trim|required"
			),
			'config_meta_title' => array(
				'field' => 'config_meta_title', 
				'label' => 'Meta Title', 
				'rules' => "trim|required"
			),
			/*
			'config_pagination_limit_front' => array(
				'field' => 'config_pagination_limit_front', 
				'label' => 'Pagination limit For front', 
				'rules' => "trim|required|numeric"
			),
			'config_pagination_limit_admin' => array(
				'field' => 'config_pagination_limit_admin', 
				'label' => 'pagination limit for admin', 
				'rules' => "trim|required|numeric"
			),
			*/
			'name' => array(
				'field' => 'name', 
				'label' => 'name', 
				'rules' => "trim|required|max_length[255]"
			),
			'password' => array(
				'field' => 'password', 
				'label' => 'Password', 
				'rules' => 'trim|required|max_length[100]'
			),
			
		);
		
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE)
		{
			return true;
    	}
		else
		{
			$this->error['warning']=$this->lang->line('error_warning');
			return false;
    	}
	}

	public function deletevehicleproviders(){
		
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
       	// print_r($selected);exit;
		$this->fleet_model->deleteVehicleProviders($selected);
		
		$this->fleet_model->deleteVehicleProviders($this->uri->segment(4));
		$this->session->set_flashdata('message', 'Vehicle Providers deleted Successfully.');
		redirect(ADMIN_PATH.'/setting/fleets');
	}

	public function deleteroutetype(){
		
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
       	// print_r($selected);exit;
		$this->fleet_model->deleteRouteType($selected);
		
		$this->fleet_model->deleteRouteType($this->uri->segment(4));
		$this->session->set_flashdata('message', 'Route Type deleted Successfully.');
		redirect(ADMIN_PATH.'/setting/fleets');
	}

	public function deletestatusreasoncodes(){
		
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
       	// print_r($selected);exit;
		$this->fleet_model->deleteStatusReasonCodes($selected);
		
		$this->fleet_model->deleteStatusReasonCodes($this->uri->segment(4));
		$this->session->set_flashdata('message', 'Status Reason Codes deleted Successfully.');
		redirect(ADMIN_PATH.'/setting/fleets');
	}

	public function deletecarmakes(){
		
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
       	// print_r($selected);exit;
		$this->fleet_model->deleteCarMakes($selected);
		
		$this->fleet_model->deleteCarMakes($this->uri->segment(4));
		$this->session->set_flashdata('message', 'Car Makes deleted Successfully.');
		redirect(ADMIN_PATH.'/setting/fleets');
	}

	public function deleteownershiptype(){
		
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
       	// print_r($selected);exit;
		$this->fleet_model->deleteOwnershipType($selected);
		
		$this->fleet_model->deleteOwnershipType($this->uri->segment(4));
		$this->session->set_flashdata('message', 'Ownership Type deleted Successfully.');
		redirect(ADMIN_PATH.'/setting/fleets');
	}

	public function deleteservicetier(){
		
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
       	// print_r($selected);exit;
		$this->fleet_model->deleteServiceTier($selected);
		
		$this->fleet_model->deleteServiceTier($this->uri->segment(4));
		$this->session->set_flashdata('message', 'Service Tier deleted Successfully.');
		redirect(ADMIN_PATH.'/setting/fleets');
	}

	public function addfleettype(){
		$title = $this->uri->segment(4) ? "Edit ".$_POST['fleettype'] : "Add ".$_POST['fleettype'];
		$make_id = 0;

		$html='<div class="modal-header">
        <div class="title"><h5>'.$title.'</h5></div>
        <button type="button" class="btn btn-none" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times-circle"></i></button>
      </div>
      <div class="modal-body" id="imageinfobody">';
		$html.='<form action="" id="form-add" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">';
		$html.='<div class="row">';
		$html.='<div class="mb-3 col-md-6">';
		$html.='<label for="type" class="form-label">Name</label>';
		if( $this->uri->segment(4)){
			
			switch ($_POST['fleettype']) {
				case 'Route Types':
				// echo 'hihi';
					$fleetid=$this->fleet_model->getRouteTypebyId($this->uri->segment(4));
					break;
				case 'Vehicle Providers':
				
					$fleetid=$this->fleet_model->getVehicleProvidersbyId($this->uri->segment(4));
					break;
				case 'Ownership Type':
				// echo 'hihi';
					
					$fleetid=$this->fleet_model->getOwnershipTypebyId($this->uri->segment(4));
					break;
				case 'Service Tier':
				
					$fleetid=$this->fleet_model->getServiceTierbyId($this->uri->segment(4));
					break;
				case 'Status Reason Code':
				
					$fleetid=$this->fleet_model->getStatusReasonCodesbyId($this->uri->segment(4));
					break;
				case 'Car Make':
				
					$fleetid=$this->fleet_model->getCarMakesbyId($this->uri->segment(4));
					break;
				case 'Car Model':
				
					$fleetid=$this->fleet_model->getVehicleModelsbyId($this->uri->segment(4));
					$make_id = $fleetid[0]['makes_id'];
					break;
				default:
					$fleetid[0]['id'] = '';
					$fleetid[0]['name'] = '';
					$fleetid[0]['is_active'] = '';
					$user_id = '';
					break;
			}
			// exit;
			// echo json_encode($fleetid)
			
			$html.='<input type="hidden" class="form-control" name="id" value="'.$fleetid[0]['id'].'" id="id" >';
			$html.='<input type="text" class="form-control" name="type" value="'.$fleetid[0]['name'].'" id="type" >';
			$url = admin_url('setting/saveroutetype/'.$fleetid[0]['id']);
			$is_active = $fleetid[0]['is_active'];
			$btn =  'Update';
		} else {
			$html.='<input type="text" class="form-control" name="type" value="" id="type" >';
			$url = admin_url('setting/saveroutetype/');
			$is_active = 1;
			$btn =  'Add';
		}
		
		$html.='</div>';
		
		if($_POST['fleettype'] == 'Car Model'){
			$car_makes = $this->fleet_model->getVehicleMakes();
			$html.='<div class="mb-3 col-md-6">';
			$html.='<label for="car_make" class="form-label">Car Make</label>';
			$html.='<select data-plugin-selectTwo class="form-control form-select populate select2" name="makes_id"  id="car_make" aria-label="Default select example">';
			$html.='<option value="0">  --Select--  </option>';
			foreach($car_makes as $car_make){
				$selected_user = '';
				if($car_make['id'] == $make_id ){
					$selected_user = 'selected';
				}
				
				$html.='<option value="'.$car_make['id'].'"  '. $selected_user .'>'.$car_make['name'].'</option>';
			}
			$html.='</select>';
			
			$html.='</div>';
		}
		$html.='<div class="mb-3 col-md-6">';
		$html.='<label for="exampleInputEmail1" class="form-label">Status</label>';
		$html.='<select class="form-select" name="is_active"  id="is_active" aria-label="Default select example">';
		if($is_active){
			$html.=' <option value="1" selected>Active</option>';
			$html.=' <option value="0" >Inactive</option>';
		} else {
			$html.=' <option value="1" >Active</option>';
			$html.=' <option value="0" selected>Inactive</option>';
		}
		
		$html.='</select>';
		$html.='</div>';
		$html.='<div class="d-flex align-items-center justify-content-between mt-2">';
		$html.='<div></div>';
		$html.='<button type="button" name="update_btn" id="updateMenuForm" class="btn btn-primary updateMenuForm" value="1" onclick="updatesetting(\''.$url.'\', \''.$_POST['fleettype'].'\')"><i class="las la-save"></i> '.$btn .'</button>';
		$html.='</div>';
		$html.='</div>';
		$html.='<div class="eror_msg text-danger"></div>';
		$html.='</form></div>';
		echo $html;
		
	}

	public function saveroutetype(){
		$data['status'] = false;
		if($_POST['fleettype'] == 'Car Model' && !$this->validatemodelForm()){
			$this->session->set_flashdata('warning', '  Warning: Please check the form carefully for errors! ');
			$data['message'] = ' Warning: Please check the form carefully for errors!';
			echo json_encode($data); exit;
		} else if(!$this->validateForm() ){
			$this->session->set_flashdata('warning', '  Warning: Please check the form carefully for errors! ');
			$data['message'] = ' Warning: Please check the form carefully for errors!';
			echo json_encode($data); exit;
		} 

		if ($this->input->server('REQUEST_METHOD') === 'POST'  && $this->validateForm() && $this->uri->segment(4)){
			$id = $this->uri->segment(4);	
			
			$fleetdata=array(
				"name" => $_POST['name'],
				"is_active" => $_POST['is_active'],
			);

			switch ($_POST['fleettype']) {
				case 'Route Types':
				
					$fleetid=$this->fleet_model->editRouteType($fleetdata, $id);
					break;
				case 'Vehicle Providers':
				
					$fleetid=$this->fleet_model->editVehicleProviders($fleetdata, $id);
					break;
				case 'Ownership Type':
				
					$fleetid=$this->fleet_model->editOwnershipType($fleetdata, $id);
					break;
				case 'Service Tier':
				
					$fleetid=$this->fleet_model->editServiceTier($fleetdata, $id);
					break;
				case 'Status Reason Code':
				
					$fleetid=$this->fleet_model->editStatusReasonCodes($fleetdata, $id);
					break;
				case 'Car Make':
				
					$fleetid=$this->fleet_model->editCarMakes($fleetdata, $id);
					break;
				case 'Car Model':
					$fleetdata['makes_id'] = $_POST['make_id'];
					$fleetdata['series'] = '';
					$fleetid=$this->fleet_model->editVehicleModels($fleetdata, $id);
					break;
				default:
					
					break;
			}
			if(!$fleetid){
			
				$data['message'] = $_POST['fleettype'].' Already Exists.';
				$this->session->set_flashdata('warning', $_POST['fleettype'].' Already Exists.');
				echo json_encode($data); exit;
			}
			$data['status'] = true;
			$this->session->set_flashdata('message', $_POST['fleettype'].' Updated Successfully.');
			echo json_encode($data); exit;
		} else if($this->input->server('REQUEST_METHOD') === 'POST'  && $this->validateForm()){
			$fleetdata=array(
				"name" => $_POST['name'],
				"is_active" => $_POST['is_active'],
			);

			switch ($_POST['fleettype']) {
				case 'Route Types':
				
					
					$fleetid=$this->fleet_model->addRouteType($fleetdata);
					break;
				case 'Vehicle Providers':
				
					$fleetid=$this->fleet_model->addVehicleProviders($fleetdata);
					break;
				case 'Ownership Type':
			
					
					$fleetid=$this->fleet_model->addOwnershipType($fleetdata);
					break;
				case 'Service Tier':
				
					$fleetid=$this->fleet_model->addServiceTier($fleetdata);
					break;
				case 'Status Reason Code':
				
					$fleetid=$this->fleet_model->addStatusReasonCodes($fleetdata);
					break;
				case 'Car Make':
				
					$fleetid=$this->fleet_model->addCarMakes($fleetdata);
					break;
				case 'Car Model':
					$fleetdata['makes_id'] = $_POST['make_id'];
					$fleetdata['series'] = '';
					
					$fleetid=$this->fleet_model->addVehicleModels($fleetdata);
					break;
				default:
					
					break;
			}
			if(!$fleetid){
				$data['message'] = $_POST['fleettype'].' Already Exists.';
				$this->session->set_flashdata('warning', $_POST['fleettype'].' Already Exists.');
				echo json_encode($data); exit;
			}
			$data['status'] = true;
			$this->session->set_flashdata('message', $_POST['fleettype'].' Created Successfully.');
			echo json_encode($data); exit;
		}
	}

	public function deletevehiclemodels(){
		
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
       	// print_r($selected);exit;
		$this->fleet_model->deleteVehicleModels($selected);
		
		$this->fleet_model->deleteVehicleModels($this->uri->segment(4));
		$this->session->set_flashdata('message', 'Car Model deleted Successfully.');
		redirect(ADMIN_PATH.'/setting/fleets');
	}

	public function deletepayrolltype(){
		
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
       	// print_r($selected);exit;
		$this->setting_model->deletePayrollType($selected);
		
		$this->setting_model->deletePayrollType($this->uri->segment(4));
		$this->session->set_flashdata('message', 'Payroll Type deleted Successfully.');
		redirect(ADMIN_PATH.'/setting/bonus');
	}
	public function deleteworkingshift(){
		
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
       	// print_r($selected);exit;
		$this->setting_model->deleteShift($selected);
		
		$this->setting_model->deleteShift($this->uri->segment(4));
		$this->session->set_flashdata('message', 'Working Shift deleted Successfully.');
		redirect(ADMIN_PATH.'/setting/bonus');
	}

	public function deletePointRuleType(){
		
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
       	// print_r($selected);exit;
		$this->setting_model->deletePointRuleType($selected);
		
		$this->setting_model->deletePointRuleType($this->uri->segment(4));
		$this->session->set_flashdata('message', 'Point Rule Type deleted Successfully.');
		redirect(ADMIN_PATH.'/setting/bonus');
	}

	public function deletebonustype(){
		
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
       	// print_r($selected);exit;
		$this->setting_model->deletebonusType($selected);
		
		$this->setting_model->deletebonusType($this->uri->segment(4));
		$this->session->set_flashdata('message', 'Bonus Type deleted Successfully.');
		redirect(ADMIN_PATH.'/setting/bonus');
	}
	public function deletebonusamount(){
		
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
       	// print_r($selected);exit;
		$this->setting_model->deletebonusamount($selected);
		
		$this->setting_model->deletebonusamount($this->uri->segment(4));
		$this->session->set_flashdata('message', 'Bonus Amount deleted Successfully.');
		redirect(ADMIN_PATH.'/setting/bonus');
	}

	

	public function deletePointType(){
		
		if ($this->input->post('selected')){
        	$selected = $this->input->post('selected');
      	}else{
        	$selected = (array) $this->uri->segment(3);
       	}
       	// print_r($selected);exit;
		$this->setting_model->deletePointType($selected);
		
		$this->setting_model->deletePointType($this->uri->segment(4));
		$this->session->set_flashdata('message', 'Point Type deleted Successfully.');
		redirect(ADMIN_PATH.'/setting/bonus');
	}

	public function addbonustype(){
		$title = $this->uri->segment(4) ? "Edit ".$_POST['bonustype'] : "Add ".$_POST['bonustype'];
		$make_id = 0;

		$html='<div class="modal-header">
        <div class="title"><h5>'.$title.'</h5></div>
        <button type="button" class="btn btn-none" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times-circle"></i></button>
      </div>
      <div class="modal-body" id="imageinfobody">';
		$html.='<form action="" id="form-add" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">';
		$html.='<div class="row">';
		$html.='<div class="mb-3 col-md-6">';
		$html.='<label for="type" class="form-label">Name</label>';
		$value = '';
		$type_id= '';
		if( $this->uri->segment(4)){
			
			switch ($_POST['bonustype']) {
				case 'Payroll':
					$fleetid=$this->setting_model->getPayrollbyId($this->uri->segment(4));
					break;
				case 'Working Shift':
				
					$fleetid=$this->setting_model->getShiftbyId($this->uri->segment(4));
					break;
				case 'Bonus Amount':
				// echo 'hihi';
					
					$fleetid=$this->setting_model->getBonusAmountbyId($this->uri->segment(4));
					$value = $fleetid[0]['amount'];
					break;
				case 'Point Rule':
				
					$fleetid=$this->setting_model->getPointRulebyId($this->uri->segment(4));
					$value = $fleetid[0]['value'];
					$type_id = $fleetid[0]['type_id'];
					break;
				case 'Point Type':
				
					$fleetid=$this->setting_model->getPointTypebyId($this->uri->segment(4));
					break;
				case 'Bonus Type':
				
					$fleetid=$this->setting_model->getBonusTypebyId($this->uri->segment(4));
					break;
				
				default:
					$fleetid[0]['id'] = '';
					$fleetid[0]['name'] = '';
					$fleetid[0]['is_active'] = '';
					$user_id = '';
					break;
			}
			// exit;
			// echo json_encode($fleetid)
			
			$html.='<input type="hidden" class="form-control" name="id" value="'.$fleetid[0]['id'].'" id="id" >';
			$html.='<input type="text" class="form-control" name="name" value="'.$fleetid[0]['name'].'" id="name" >';
			$url = admin_url('setting/savebonussetting/'.$fleetid[0]['id']);
			$is_active = $fleetid[0]['is_active'];
			$btn =  'Update';
		} else {
			$html.='<input type="text" class="form-control" name="name" value="" id="name" >';
			$url = admin_url('setting/savebonussetting/');
			$is_active = 1;
			$btn =  'Add';
		}
		
		$html.='</div>';
		if($_POST['bonustype'] == 'Point Rule' || $_POST['bonustype'] == 'Bonus Amount'){
			
			$html.='<div class="mb-3 col-md-6">';
			$html.='<label for="car_make" class="form-label">Value </label>';
			$html.='<input type="number" class="form-control" name="value" value="'.$value .'" id="value" >';
			
			$html.='</div>';
		}

		if($_POST['bonustype'] == 'Point Rule'){
			$point_types = $this->setting_model->getActivePointType();
			$html.='<div class="mb-3 col-md-6">';
			$html.='<label for="car_make" class="form-label">Points Type</label>';
			$html.='<select data-plugin-selectTwo class="form-control form-select populate select2" name="points_id"  id="points_id" aria-label="Default select example">';
			$html.='<option value="0">  --Select--  </option>';
			foreach($point_types as $point_type){
				$selected_user = '';
				if($point_type['id'] == $type_id ){
					$selected_user = 'selected';
				}
				
				$html.='<option value="'.$point_type['id'].'"  '. $selected_user .'>'.$point_type['name'].'</option>';
			}
			$html.='</select>';
			
			$html.='</div>';
			
		}
		
		$html.='<div class="mb-3 col-md-6">';
		$html.='<label for="exampleInputEmail1" class="form-label">Status</label>';
		$html.='<select class="form-select" name="is_active"  id="is_active" aria-label="Default select example">';
		if($is_active){
			$html.=' <option value="1" selected>Active</option>';
			$html.=' <option value="0" >Inactive</option>';
		} else {
			$html.=' <option value="1" >Active</option>';
			$html.=' <option value="0" selected>Inactive</option>';
		}
		
		$html.='</select>';
		$html.='</div>';
		$html.='<div class="d-flex align-items-center justify-content-between mt-2">';
		$html.='<div></div>';
		$html.='<button type="button" name="update_btn" id="updateMenuForm" class="btn btn-primary updateMenuForm" value="1" onclick="updatesetting(\''.$url.'\', \''.$_POST['bonustype'].'\')"><i class="las la-save"></i> '.$btn .'</button>';
		$html.='</div>';
		$html.='</div>';
		$html.='<div class="eror_msg text-danger"></div>';
		$html.='</form></div>';
		echo $html;
		
	}

	public function savebonussetting(){
		$data['status'] = false;
		if($_POST['bonustype'] == 'Point Rule' && !$this->validatePointRuleForm() ){
			
			$this->session->set_flashdata('warning', '  Warning: Please check the form carefully for errors! Fill the remaining empty Fields. ');
			$data['message'] = ' Warning: Please check the form carefully for errors!';
			echo json_encode($data); exit;
		} else if($_POST['bonustype'] == 'Bonus Amount' && !$this->validateBonusAmountForm()){
			$this->session->set_flashdata('warning', '  Warning: Please check the form carefully for errors! Fill the remaining empty Fields. ');
			$data['message'] = ' Warning: Please check the form carefully for errors!';
			echo json_encode($data); exit;
		} else if(!$this->validateForm() ){
			$this->session->set_flashdata('warning', '  Warning: Please check the form carefully for errors! Fill the remaining empty Fields ');
			$data['message'] = ' Warning: Please check the form carefully for errors!';
			echo json_encode($data); exit;
		} 

		if ($this->input->server('REQUEST_METHOD') === 'POST'  && $this->validateForm() && $this->uri->segment(4)){
			$id = $this->uri->segment(4);	
			
			$bonusdata=array(
				"name" => $_POST['name'],
				"is_active" => $_POST['is_active'],
			);

			switch ($_POST['bonustype']) {
				case 'Payroll':
				
					$fleetid=$this->setting_model->editPayroll($bonusdata, $id);
					break;
				case 'Working Shift':
				
					$fleetid=$this->setting_model->editShift($bonusdata, $id);
					break;
				case 'Point Type':
				
					$fleetid=$this->setting_model->editPointType($bonusdata, $id);
					break;
				case 'Point Rule':
					$bonusdata['value'] = $_POST['value'];
					$bonusdata['type_id'] = $_POST['points_id'];
					$bonusdata['on_off'] = 1;
					$fleetid=$this->setting_model->editPointRule($bonusdata, $id);
					break;
				case 'Bonus Type':
				
					$fleetid=$this->setting_model->editBonusType($bonusdata, $id);
					break;
				case 'Bonus Amount':
					$bonusdata['amount'] = $_POST['value'];
					$fleetid=$this->setting_model->editBonusAmount($bonusdata, $id);
					break;
				default:
					
					break;
			}
			if(!$fleetid){
			
				$data['message'] = $_POST['bonustype'].' Already Exists.';
				$this->session->set_flashdata('warning', $_POST['bonustype'].' Already Exists.');
				echo json_encode($data); exit;
			}
			$data['status'] = true;
			$this->session->set_flashdata('message', $_POST['bonustype'].' Updated Successfully.');
			echo json_encode($data); exit;
		} else if($this->input->server('REQUEST_METHOD') === 'POST'  && $this->validateForm()){
			$bonusdata=array(
				"name" => $_POST['name'],
				"is_active" => $_POST['is_active'],
			);

			switch ($_POST['bonustype']) {
				case 'Payroll':
				
					
					$bonusid=$this->setting_model->addPayroll($bonusdata);
					break;
				case 'Working Shift':
				
					$bonusid=$this->setting_model->addShift($bonusdata);
					break;
				case 'Point Type':
			
					
					$bonusid=$this->setting_model->addPointType($bonusdata);
					break;
				case 'Point Rule':
					$bonusdata['value'] = $_POST['value'];
					$bonusdata['type_id'] = $_POST['points_id'];
					$bonusdata['on_off'] = 1;
					$bonusid=$this->setting_model->addPointRule($bonusdata);
					break;
				case 'Bonus Type':
				
					$bonusid=$this->setting_model->addBonusType($bonusdata);
					break;
				case 'Bonus Amount':
					$bonusdata['amount'] = $_POST['value'];
					$bonusid=$this->setting_model->addBonusAmount($bonusdata);
					break;
				default:
					
					break;
			}
			if(!$bonusid){
				$data['message'] = $_POST['bonustype'].' Already Exists.';
				$this->session->set_flashdata('warning', $_POST['bonustype'].' Already Exists.');
				echo json_encode($data); exit;
			}
			$data['status'] = true;
			$this->session->set_flashdata('message', $_POST['bonustype'].' Created Successfully.');
			echo json_encode($data); exit;
		}
	}
	public function updatepayrolltype(){
	
		if ($this->input->server('REQUEST_METHOD') === 'POST' ){
			
        	$selected=$this->input->post('tnt_payroll_provider');
			$this->setting_model->UpdatePayroll($selected);

			$this->session->set_flashdata('message', 'Payroll Updated Successfully.');
      	} else{
			 $this->session->set_flashdata("error","Your data has been missing");
      	}
       
		redirect(ADMIN_PATH.'/setting/bonus');
	}

	public function updatepointrule(){
		
		if ($this->input->server('REQUEST_METHOD') === 'POST' ){
			
        	$rules= $this->input->post('rules');

        	foreach($rules as $key => $val){
				$switch = 0;
				if(isset($val['switch']) && $val['switch'] ==  'on'){
					$switch = 1;
				}
        		$savearr = array(
        			'value' => $val['val'],
        			'on_off' => $switch
        		);
        		$this->setting_model->editPointRule($savearr, $key);
        	}

        	$selected=$this->input->post('tnt_falloff_period');
			$this->setting_model->UpdateFallOff($selected);
        	
			
			$shift= $this->input->post('shift');
			// print_r($shift);exit;

			foreach($shift as $key => $val){
				
        		$this->setting_model->editShiftTiming($val, $key);
        	}

			$this->session->set_flashdata('message', 'Point Rule Updated Successfully.');
      	} else{
			 $this->session->set_flashdata("error","Your data has been missing");
      	}
       
		redirect(ADMIN_PATH.'/setting/bonus');
	}

	public function updatebonusrule(){
		
		if ($this->input->server('REQUEST_METHOD') === 'POST' ){
			
        	$amount= $this->input->post('amount');

        	foreach($amount as $key => $val){
				
        		$this->setting_model->editBonusAmount($val, $key);
        	}

        	
			$type= $this->input->post('type');
			// echo '<pre>';
			// print_r($type);exit;
			foreach($type as $key => $val){
				
				$condition = '';
				if(isset($val['condition'])){
					$condition = implode(', ',$val['condition']);
				}
				$data = array(
					'threshold_condition' =>$condition,
					'bonus_type_id' => $key,
					
				);
				foreach($val['amount'] as $key => $amount){
					$data['bonus_amount_id'] = $key;
					$data['threshold_value'] = $amount;
					$this->setting_model->addEditBonusRule($data);
				}
        		
        	}

			$this->session->set_flashdata('message', 'Bonus Rule Updated Successfully.');
      	} else{
			 $this->session->set_flashdata("error","Your data has been missing");
      	}
       
		redirect(ADMIN_PATH.'/setting/bonus');
	}

	protected function validatePayrollForm() {

		$rules = array(
            'config_payroll' => array(
                'config_payroll' => 'config_payroll',
                'label' => 'Provider',
                'rules' => 'required'
            ),
        );

		$this->form_validation->set_rules($rules);
		
		if ($this->form_validation->run() == TRUE)
		{
			return true;
    	}
		else
		{
			$this->error['warning']=$this->lang->line('error_warning');
			return false;
    	}
		return !$this->error;
	}

	protected function validateForm() {
		$rules = array(
            'name' => array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'trim|required|max_length[100]'
            ),
        );
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE)
		{
			return true;
    	}
		else
		{
			$this->error['warning']=$this->lang->line('error_warning');
			return false;
    	}
		return !$this->error;
	}

	protected function validatemodelForm() {
		$rules = array(
            'name' => array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'trim|required|max_length[100]'
            ),
            'makes_id' => array(
                'field' => 'makes_id',
                'label' => 'Car Make',
                'rules' => 'required'
            ),
        );
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE)
		{
			return true;
    	}
		else
		{
			$this->error['warning']=$this->lang->line('error_warning');
			return false;
    	}
		return !$this->error;
	}

	protected function validateBonusAmountForm() {
		$rules = array(
            'name' => array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'trim|required|max_length[100]'
            ),
            'value' => array(
                'field' => 'value',
                'label' => 'Value',
                'rules' => 'required'
            ),
        );
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE)
		{
			return true;
    	}
		else
		{
			$this->error['warning']=$this->lang->line('error_warning');
			return false;
    	}
		return !$this->error;
	}
	protected function validatePointRuleForm() {
		$rules = array(
            'name' => array(
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'trim|required|max_length[100]'
            ),
            'value' => array(
                'field' => 'value',
                'label' => 'Value',
                'rules' => 'required'
            ),
            'points_id' => array(
                'field' => 'points_id',
                'label' => 'Points Type',
                'rules' => 'required'
            ),
        );
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run() == TRUE)
		{
			return true;
    	}
		else
		{
			$this->error['warning']=$this->lang->line('error_warning');
			return false;
    	}

		return !$this->error;
	}
	
}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */