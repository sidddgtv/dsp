<?php
class Plugin {
	public $CI;
	
	public function __construct(){
		$this->CI =& get_instance(); 
	}

	public function nav_menu($data = array()) {
		//print_r($data);//die;
		//a_user_id
		$this->CI->db->from("menu_group");
		$this->CI->db->join("menu","menu_group.id=menu.menu_group_id");
		//$this->CI->db->where("menu_group.theme_location",$data['theme_location']);
		$this->CI->db->where("menu.menu_group_id",$data['menu_group_id']);
		//198 loans 199 promoters digitalvtx
		//88 promoters 90 loans digitalvtx

		//208 loans 209 promoters savepros.co
		//88 promoters 90 loans savepros.co

		//print_r($_SERVER);
		$this->CI->db->order_by("menu.sort_order","asc");
		$menu = $this->CI->db->get()->result();
		if(empty($menu) && $data['menu_type']=="admin")
		{
			$menu=array();
		}
		$arg=$data;
		$menus=$this->get_menu_nested($menu);
		return $this->create_nav($menus,$arg);
	}
	
	public function get_menu_nested($treelist,$parent = 0){
		$array = array();
		foreach($treelist as $tree)
		{
			if($tree->parent_id == $parent)
			{
				$tree->sub = isset($tree->sub) ? $tree->sub : $this->get_menu_nested($treelist, $tree->id);
				$array[] = $tree;
			}
		}
		return $array;
	}
	
	public function create_nav($nav,$arg, $depth = 1){
		if($arg['theme_location']=="admin"){
			$url='admin_url';
		}else{
			$url='base_url';
		}
      if(isset($arg['menu_class']) && $depth == 1){
			$list_item = '<ul>';
		}else{
			$list_item = '<ul class="dropdown">';
		}
      foreach($nav as $item){
		 //find active
		 $link_active = '';
		 if (strpos($_SERVER['REQUEST_URI'], $item->url) !== false && $item->url != '/') {
			$link_active = 'active';
		 }
         $item->url = trim($item->url, '/');
         //print_r($item);
//         echo strpos($_SERVER['REQUEST_URI'], 'what-sets-us-aside');
         if(empty($item->sub) && $depth == 1){
	         $list_item .= '<li'. ((isset($item->menu_id)) ? ' id="' . $item->menu_id . '"' : '') . '>';
	      }else{
	      	$list_item .= '<li'. ((isset($item->menu_id)) ? ' id="' . $item->menu_id . '"' : '') . ' class="navbar-dropdown">';
	      }
	       if(empty($item->sub) && $depth == 1){
			$request_uri = '';
			if($item->url == '' && (strpos($_SERVER['REQUEST_URI'], strtolower($item->title)) !== false)){
				//dashbaord
				$request_uri = 'dashboard';
			}else{
				$request_uri = $_SERVER['REQUEST_URI'];
			}
	       	if($item->url == '#'){
	       		$list_item .= '<a href="javascript:void(0)" class="nav-link '.((strpos($request_uri, $item->title) !== false) ? 'active' : '').'" id="menu-'.$item->id.'" aria-haspopup="true" aria-expanded="false"><i class="' . $item->iconmenu . ' d-none d-lg-inline-block"></i><span>' . $item->title . '</span></a>';
	       	}else{
	       		$list_item .= '<a href="' .$url($item->url) .'" class="nav-link '.((strpos($request_uri, strtolower($item->title)) !== false) ? 'active' : '').'" id="menu-'.$item->id.'" aria-haspopup="true" aria-expanded="false"><i class="' . $item->iconmenu . ' d-none d-lg-inline-block"></i><span>' . $item->title . '</span></a>';
	       	}
	         
	      }else{
	      	if(empty($item->sub)){
	      		if($item->url == '#'){
	      			$list_item .= '<a href="javascript:void(0)" class="nav-link" id="menu-'.$item->menu_id.'" aria-haspopup="true" aria-expanded="false"><i class="fas ' . $item->iconmenu . ' d-none d-lg-inline-block"></i><span>' . $item->title . '</span></a>';
	      		}else{
	      			$list_item .= '<a href="' .$url($item->url) .'" class="nav-link" id="menu-'.$item->menu_id.'" aria-haspopup="true" aria-expanded="false"><i class="fas ' . $item->iconmenu . ' d-none d-lg-inline-block"></i><span>' . $item->title . '</span></a>';
	      		}
	      		
	      	}else{
	      		if($item->url == '#'){
	      			$list_item .= '<a href="javascript:void(0)" class="nav-link" id="menu-'.$item->menu_id.'" aria-haspopup="true" aria-expanded="false"><i class="fas ' . $item->iconmenu . ' d-none d-lg-inline-block"></i><span>' . $item->title . '</span></a>';
	      		}else{
	      			$list_item .= '<a href="' .$url($item->url) .'" class="nav-link" id="menu-'.$item->menu_id.'" aria-haspopup="true" aria-expanded="false"><i class="fas ' . $item->iconmenu . ' d-none d-lg-inline-block"></i><span>' . $item->title . '</span></a>';

	      		}
	      		
	      		
	      		//'.((strpos($_SERVER['REQUEST_URI'], 'what-sets-us-aside') !== false || strpos($_SERVER['REQUEST_URI'], 'the-process') !== false || strpos($_SERVER['REQUEST_URI'], 'family-application') !== false) ? 'active' : '').'
	      	}
	      }

			if ( ! empty($item->sub)){
				$list_item .= $this->create_nav($item->sub,$arg, $depth + 1);
			}
         $list_item .= '</li>';
      }
     // exit;
      $list_item .= '</ul>';
      return $list_item;
	} 

	public function list_menu_nav($list, $depth = 1){
      $nav = '<ul class="dd-list">';
  
      foreach($list as $Item){
      	$delete_url = admin_url().'menu/deleteMenuItem?id='.$Item->id;
      	$det = "return confirm('Are you sure delete this menu?') ? true : false;";
         $nav .= '<li class="dd-item" data-id="'.$Item->id.'">';
			$nav .=  '<div class="dd-handle dd3-handle"></div>';
			$nav .= 	'<div class="row dd3-content">';
			$nav .=			'<div class="col-4 ps-2">'.($Item->title?:"&nbsp;") .'</div>';
			$nav .=			'<div class="col-2">'.($Item->url?:"&nbsp;") .'</div>';
			$nav .=			'<div class="col-2">'.($Item->class?:"&nbsp;") .'</div>';
			$nav .=			'<div class="col-2">'.($Item->iconmenu?:"&nbsp;") .'</div>';
			$nav .=			'<div class="col-2 text-end">';
			$nav .=				'<div class="btn-group btn-group-xs pull-right">';
			$nav .=					'<a href="#" title="Edit Menu" class="edit-menu btn btn-primary"><i class="fa fa-edit"></i></a>';
			$nav .=					'<a href="'.$delete_url.'" class="delete-menu btn btn-danger" onclick="'.$det.'"><i class="fa fa-trash"></i></a>';
			$nav .=				'</div>';
			$nav .=			'</div>';
			$nav .=	'</div>';
			
			if ( ! empty($Item->sub)){
				 $nav .= $this->list_menu_nav($Item->sub, $depth + 1);
			}
         $nav .= '</li>';
      }
      $nav .= '</ul>';
      return $nav;
   }

}
