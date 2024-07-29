<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menu extends Admin_Controller {
	private $error = array();
	
	public function __construct(){
      parent::__construct();
		$this->load->model('menu_model');		
	}
	
	public function index(){
      $this->lang->load('menu');
		$this->template->set_meta_title($this->lang->line('heading_title'));
		$this->template->add_package(array('jquerynestable'),true);
		$data['heading_title'] 	= $this->lang->line('heading_title');
		$data['menu_groups'] = $menu_groups = $this->menu_model->getMenuGroups();
		
		foreach($menu_groups as $group){
			if($group['theme_location']=="admin"){
				$menu_group_id=$group['id'];
				break;
			}
		}
		
		if($this->uri->segment(4)){
			$menu_group_id = $this->uri->segment(4);
		}
		
		if($menu_group_id && $this->input->server('REQUEST_METHOD') != 'POST') {
			$data['menugroup'] = $this->menu_model->getMenuGroup($menu_group_id);
			$data['menu_group_id'] = $menu_group_id;
			$menulist =$this->menu_model->getMenuItems($menu_group_id);
			
			$treelist =$this->plugin->get_menu_nested($menulist);
			// printr($treelist);
			$data['menu']=$this->plugin->list_menu_nav($treelist);
		}
		$data['menu_group_id'] = $menu_group_id;
		$data['action'] = admin_url('menu/save_position');
		//printr($data['menu_groups']);
		$this->template->view('menu', $data);  
	}
	
	public function add() {
		
		if ($this->input->server('REQUEST_METHOD') === 'POST'){	
			
			$json=array();
			
			if(!$this->validateForm()){
				if(isset($this->error['warning']))
				{
					$json['error'] 	= $this->error['warning'];
				}
				if(isset($this->error['server_errors'])){
					$json['server_errors'] 	= $this->error['server_errors'];
				}
			}
			if (!$json) {
				$sort=$this->menu_model->getMaxSortorder($_POST['menu_group_id']);
			
				$menuitem=array(
					"menu_group_id"=>$this->input->post('menu_group_id'),
					"menu_type"=>"custom",
					"title"=>$this->input->post('title'),
					"url"=>$this->input->post('url'),
					"class"=>$this->input->post('class'),
					"parent_id"=>0,
					"sort_order"=>$sort+1
				);
				$menu_id=$this->menu_model->addMenuItem($menuitem);
				if($menu_id){
					$json['menu']=array(
						"status"=>1,
						"li"=>'<li class="dd-item" data-id="'.$menu_id.'">'.$this->get_label($menuitem).'</li>',
						"msg"=>"Menu added Successfully",
					);
				} else {
					$json['menu']=array(
						"status"=>2,
						"msg"=>"Add menu error.",
					);
				}
				
			}
			echo json_encode($json);
			exit;
			
		}
	}
	
	public function edit() {
		$menu_id = $this->input->post('id');
		//echo $menu_id;exit;
		//echo $menu_id;exit;
		$menu_info = $this->menu_model->getMenuItem($menu_id);
		$html='';
		$html.='<form method="post" action="" class="updateForm">';
		$html.='<input type="hidden" class="form-control" name="id" value="'.$menu_info['id'].'" id="exampleInputEmail1" aria-describedby="emailHelp">';
		$html.='<input type="hidden" class="form-control group_id" name="menu_group_id" value="'.$menu_info['menu_group_id'].'" id="exampleInputEmail1" aria-describedby="emailHelp">';
		$html.='<div class="mb-3">';
		$html.='<label for="exampleInputEmail1" class="form-label">Title</label>';
		$html.='<input type="text" class="form-control" name="title" value="'.$menu_info['title'].'" id="exampleInputEmail1" aria-describedby="emailHelp">';
		$html.='</div>';
		$html.='<div class="mb-3">';
		$html.='<label for="exampleInputEmail1" class="form-label">Url</label>';
		$html.='<input type="text" class="form-control" name="url" value="'.$menu_info['url'].'" id="exampleInputEmail1" aria-describedby="emailHelp">';
		$html.='</div>';
		$html.='<div class="mb-3">';
		$html.='<label for="exampleInputEmail1" class="form-label">Class</label>';
		$html.='<input type="text" class="form-control" name="class" value="'.$menu_info['class'].'" id="exampleInputEmail1" aria-describedby="emailHelp">';
		$html.='</div>';
		$html.='<div class="mb-3">';
		$html.='<label for="exampleInputEmail1" class="form-label">Icon</label>';
		$html.='<input type="text" class="form-control" name="iconmenu" value="'.$menu_info['iconmenu'].'" id="exampleInputEmail1" aria-describedby="emailHelp">';
		$html.='</div>';
		$html.='<div class="mb-3">';
		$html.='<button type="submit" name="update_btn" id="updateMenuForm" class="btn btn-primary updateMenuForm" value="1">Update</button>';
		$html.='</div>';
		$html.='</form>';
		echo $html;
		
	}

	public function addmenuform() {
		$menu_groups = $this->menu_model->getMenuGroups();
		$html='';
		$html.='<form method="post" action="" class="addMenuForm">';
		$html.='<div class="mb-3">';
		$html.='<label for="exampleInputEmail1" class="form-label">Select Menu group</label>';
		$html.='<select class="form-select" name="menu_group_id" aria-label="Default select example">';
		foreach($menu_groups as $v){
			$html.='<option value="'.$v['id'].'">'.$v['title'].'</option>';
		}
		$html.='</select>';
		$html.='</div>';
		$html.='<div class="mb-3">';
		$html.='<label for="exampleInputEmail1" class="form-label">Title</label>';
		$html.='<input type="text" class="form-control" name="title" value="" id="exampleInputEmail1" aria-describedby="emailHelp">';
		$html.='</div>';
		$html.='<div class="mb-3">';
		$html.='<label for="exampleInputEmail1" class="form-label">Url</label>';
		$html.='<input type="text" class="form-control" name="url" value="" id="exampleInputEmail1" aria-describedby="emailHelp">';
		$html.='</div>';
		$html.='<div class="mb-3">';
		$html.='<label for="exampleInputEmail1" class="form-label">Class</label>';
		$html.='<input type="text" class="form-control" name="class" value="" id="exampleInputEmail1" aria-describedby="emailHelp">';
		$html.='</div>';
		$html.='<div class="mb-3">';
		$html.='<label for="exampleInputEmail1" class="form-label">Icon</label>';
		$html.='<input type="text" class="form-control" name="iconmenu" value="" id="exampleInputEmail1" aria-describedby="emailHelp">';
		$html.='</div>';
		$html.='<div class="mb-3">';
		$html.='<button type="submit" name="update_btn" id="updateMenuForm" class="btn btn-primary updateMenuForm" value="1">Add</button>';
		$html.='</div>';
		$html.='<div class="eror_msg text-danger"></div>';
		$html.='</form>';
		echo $html;
		
	}

	public function addGroupMenuform() {
		$html='';
		$html.='<form method="post" action="" class="addGroupMenuForm">';
		$html.='<div class="mb-3">';
		$html.='<label for="exampleInputEmail1" class="form-label">Title</label>';
		$html.='<input type="text" class="form-control" name="title" value="" id="exampleInputEmail1" aria-describedby="emailHelp">';
		$html.='</div>';
		$html.='<div class="mb-3">';
		$html.='<button type="submit" name="update_btn" id="updateGroupMenuForm" class="btn btn-primary updateMenuForm" value="1">Add</button>';
		$html.='</div>';
		$html.='<div class="eror_msg text-danger"></div>';
		$html.='</form>';
		echo $html;
		
	}

	public function updateMenu() {
		$id = $this->menu_model->getUpdatemenu($_POST);
		echo 'sucess';
	}

	public function deleteMenuItem(){
		$id=$_GET['id'];
		$this->menu_model->deleteMenuItem($id);
		redirect(ADMIN_PATH . '/menu');
	}

	public function insertMenuForm() {
		if($this->input->post('title') == ''){
			echo 'Please put title';
		}elseif($this->input->post('url') == ''){
			echo 'Please put url';
		}else{
			$id = $this->menu_model->getAddmenu($_POST);
			echo 'sucess';
		}
	}

	public function insertGroupMenuForm() {
		if($this->input->post('title') == ''){
			echo 'Please put title';
		}else{
			$id = $this->menu_model->getAddGropmenu($_POST);
			echo 'sucess';
		}
	}
	
	public function group(){
		$data['text_form'] = $this->uri->segment(4) ? "Edit Menu Group" : "Add Menu Group";
		
		if (!$this->uri->segment(4)) {
			$data['action'] = admin_url("menu/group");
		} else {
			$data['action'] = admin_url("menu/group/".$this->uri->segment(4));
		}
		
		if ($this->uri->segment(4) && ($this->input->server('REQUEST_METHOD') != 'POST')) {
			$menu_group_info = $this->menu_model->getMenuGroup($this->uri->segment(4));
		}
		
		if ($this->input->post('title')) {
			$data['title'] = $this->input->post('title');
		} elseif (!empty($menu_group_info)) {
			$data['title'] = $menu_group_info['title'];
		} else {
			$data['title'] = '';
		}
		
		if ($this->input->server('REQUEST_METHOD') === 'POST'){
			
			if ($this->input->post('title')) {
				if($this->uri->segment(4)){
					$menu_group_id=$this->uri->segment(4);
					$this->menu_model->editMenuGroup($menu_group_id,$this->input->post());
					$action="edit";
				}else{
					$menu_group_id=$this->menu_model->addMenuGroup($this->input->post());
					$action="add";
				}
				if($menu_group_id){
					$response['status'] = 1;
					$response['id'] = $menu_group_id;
					$response['action'] = $action;
				} else {
					$response['status'] = 2;
					$response['msg'] = 'menu group error.';
				}
			} else {
				$response['status'] = 3;
				$response['msg'] = 'Group name blank';
			}
			header('Content-type: application/json');
			echo json_encode($response);

		}else{
			$this->load->view('group', $data);
		}
 
	}
	
	protected function getListForm() {
		
		$data['text_form'] = $this->uri->segment(3) ? 'Edit Menu' : 'Add Menu';
		
		if (!$this->uri->segment(4)) {
			$data['action'] = admin_url("menu/add");
		} else {
			$data['action'] = admin_url("menu/edit/".$this->uri->segment(4));
		}
		
		
		if ($this->uri->segment(4) && ($this->input->server('REQUEST_METHOD') != 'POST')) {
			$menu_info = $this->menu_model->getMenuItem($this->uri->segment(4));
		}
		
		if ($this->input->post('title')) {
			$data['title'] = $this->input->post('title');
		} elseif (!empty($menu_info)) {
			$data['title'] = $menu_info['title'];
		} else {
			$data['title'] = '';
		}
		
		if ($this->input->post('url')) {
			$data['url'] = $this->input->post('url');
		} elseif (!empty($menu_info)) {
			$data['url'] = $menu_info['url'];
		} else {
			$data['url'] = '';
		}
		
		if ($this->input->post('class')) {
			$data['class'] = $this->input->post('class');
		} elseif (!empty($menu_info)) {
			$data['class'] = $menu_info['class'];
		} else {
			$data['class'] = '';
		}
		
		
		$this->load->view('menuForm', $data);
	}
	
	public function delete(){
		if(isset($_POST['menu_group_id'])) {
			$menu_group_id = (int)$_POST['menu_group_id'];
			$delete=$this->menu_model->deleteMenuGroup($menu_group_id);

			if ($delete) {
				$response['success'] = true;
			} else {
				$response['success'] = false;
			}
			$this->session->set_flashdata('message', '<p class="success">Menu deleted Successfully.</p>');
		
			header('Content-type: application/json');
			echo json_encode($response);
		}
	}
	
	public function deleteMenuItem1() {
		if (isset($_POST['menu_id'])) {
			$menu_id = (int)$_POST['menu_id'];

			$delete=$this->menu_model->deleteMenuItem($menu_id);
			if ($delete) {
				$response['success'] = true;
			} else {
				$response['success'] = false;
			}
			header('Content-type: application/json');
			echo json_encode($response);
		}
	}
	
	public function save_position() {
		if(isset($_POST['menu'])){
			$menu = json_decode($_POST['menu'], true, 64);
			$this->update_position(0, $menu);
		}
	}

	/**
	 * Recursive function for save menu position
	 */
	private function update_position($parent, $children) {
		$i = 1;
		foreach ($children as $k => $v) {
			$menu_id = (int)$children[$k]['id'];
			$node_info_array = array();
			$node_info_array['parent_id'] =  $parent;
			$node_info_array['sort_order'] = $i;
	
			$this->menu_model->updateMenuItemsOrder($menu_id,$node_info_array);
			if (isset($children[$k]['children'][0])) {
				$this->update_position($menu_id, $children[$k]['children']);
			}
			$i++;
		}
	}
	
	protected function validateForm() {
	
		$rules=array(
			'title' => array(
				'field' => 'title', 
				'label' => 'Menu Name', 
				'rules' => 'trim|required|max_length[100]'
			),
			'url' => array(
				'field' => 'url', 
				'label' => 'Menu URL', 
				'rules' => 'trim|required'
			),
		);
		$this->form_validation->set_rules($rules);
		if ($this->form_validation->run($this) == TRUE){
			return true;
    	}
		else
		{
			$this->error['warning']="Warning: Please check the form carefully for errors! ";
			$this->error['server_errors'] = $this->form_validation->error_array();
			return false;
    	}
		return !$this->error;
	}
	
	private function get_label($row) {
		$label =
		'<div class="dd-handle dd3-handle"></div>'.
		'<div class="row dd3-content">'.
			'<div class="col-md-5 title">'.$row['title'].'</div>'.
			'<div class="col-md-3 url">'.$row['url'].'</div>'.
			'<div class="col-md-3 class">'.$row['class'].'</div>'.
			'<div class="col-md-1">'.
				'<div class="btn-group btn-group-xs pull-right">'.
					'<a href="#" title="Edit Menu" class="edit-menu btn btn-primary"><i class="fa fa-edit"></i></a>'.
					'<a href="#" title="Delete Menu" class="delete-menu btn btn-danger"><i class="fa fa-trash"></i></a>'.
				'</div>'.
			'</div>'.
		'</div>';	
		return $label;
	}
	
}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */