<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * AIO ADMIN
 *
 * @author      Mark Price
 * @copyright   Copyright (c) 2012
 * @license     MIT License
 * @link        http://aioadmin.com
 */

class Setting_model extends MY_Model
{	
   public function __construct(){
		 parent::__construct();
	}
	public function group(){
      $this->db->select("id,name");
		$this->db->from("groups");
		if ($this->Group_session->type != SUPERADMIN)
        {
			$this->db->where("type != ".SUPERADMIN);
		}
		$res = $this->db->get()->result();
        return $res;
	}
	public function getUsers($data = array())
	{
		$this->db->from("users u");
		$this->db->join('groups gp', 'gp.id = u.group_id');
		if ($this->Group_session->type != SUPERADMIN)
        {
			$this->db->where("gp.type != ".SUPERADMIN);
		}
		if (!empty($data['filter_search'])) {
			$this->db->where("(concat_ws(' ', u.first_name, u.last_name) LIKE '%{$data['filter_search']}%' OR u.email LIKE '%{$data['filter_search']}%')");
		}

		if (!empty($data['filter_groupid'])) {
			$this->db->where("u.group_id", $data['filter_groupid']);
		}


		$sort_data = array(
			'u.first_name',
			'u.last_name',
			'u.email',
			'gp.name',
			'u.last_login'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			//echo "ok";
			$sort = $data['sort'];
		} else {
			$sort = "u.first_name";
		}

		if (isset($data['order']) && ($data['order'] == 'desc')) {
			$order = "desc";
		} else {
			$order = "asc";
		}
		$this->db->order_by($sort, $order); 
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}
			$this->db->limit((int)$data['limit'],(int)$data['start']);
		}

		$res = $this->db->get()->result();

		return $res;
	}
	public function getTotalUsers($data = array())
	{
		$this->db->from("users u");
		$this->db->join('groups gp', 'gp.id = u.group_id');
		if ($this->Group_session->type != SUPERADMIN)
        {
			$this->db->where("gp.type != ".SUPERADMIN);
		}
		if (!empty($data['filter_search'])) {
			$this->db->where("(concat_ws(' ', u.first_name, u.last_name) LIKE '%{$data['filter_search']}%' OR u.email LIKE '%{$data['filter_search']}%')");
		}

		if (!empty($data['filter_groupid'])) {
			$this->db->where("u.group_id", $data['filter_groupid']);
		}

		$count = $this->db->count_all_results();

		return $count;
	}
	public function getGroups($data = array())
	{
		$this->db->from("groups");
		if ($this->Group_session->type != SUPERADMIN)
        {
			$this->db->where("type != ".SUPERADMIN);
		}

		$sort_data = array(
			'name'
		);
		
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			//echo "ok";
			$sort = $data['sort'];
		} else {
			$sort = "name";
		}

		if (isset($data['order']) && ($data['order'] == 'desc')) {
			$order = "desc";
		} else {
			$order = "asc";
		}
		$this->db->order_by($sort, $order); 
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}
			$this->db->limit((int)$data['limit'],(int)$data['start']);
		}

		$res = $this->db->get()->result();

		return $res;
	}
	public function getTotalGroups($data = array())
	{
		$this->db->from("groups");
		if ($this->Group_session->type != SUPERADMIN)
        {
			$this->db->where("type != ".SUPERADMIN);
		}
		$count = $this->db->count_all_results();

		return $count;
	}
	public function getUserGroup($user_group_id) {
		$this->db->distinct();
		$this->db->where("id",$user_group_id);
		$query=$this->db->get('groups')->row();
		
		$user_group = array(
			'name'      	=> $query->name,
			'type'			=> $query->type,
			'permissions'	=> unserialize($query->permissions)
		);

		return $user_group;
	}
	public function groupname_check($name)
	{
		$this->db->where('name', $name);
		$query = $this->db->get('groups');
		$Group=$query->row();
		return $Group;
	}
	public function editUserGroup($user_group_id, $data) {
		$this->db->where("id",$user_group_id);
        $status=$this->db->update("groups", $data);
        
        if($status) 
        return "success";
	}
	public function getCountries($data = array()) {
		$this->db->from("country");
			
		$sort_data = array(
			'country_name',
			'country_code',
		);
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			//echo "ok";
			$sort = $data['sort'];
		} else {
			$sort = "country_name";
		}
		if (isset($data['order']) && ($data['order'] == 'desc')) {
			$order = "desc";
		} else {
			$order = "asc";
		}
		$this->db->order_by($sort, $order); 	
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}
			$this->db->limit((int)$data['limit'],(int)$data['start']);
		}

		$res = $this->db->get()->result();
	
		return $res;
		 
	}
	
	public function getCityByStateId($state_id) {
		$this->db->from("city");
		$this->db->where("city_state_id",$state_id);
		$res = $this->db->get()->result();
		return $res;
	}
	public function getPages() {
		$this->db->from("pages");
		$this->db->where("status","published");
		$res = $this->db->get()->result();
		return $res;
	}
	public function getBanners() {
		$this->db->from("banners");
		$this->db->where("status",1);
		$res = $this->db->get()->result();
		return $res;
	}
	public function getSliders() {
		$this->db->from("sliders");
		$this->db->where("status",1);
		$res = $this->db->get()->result();
		return $res;
	}
	public function editSetting($module, $data) {
		$this->db->where('module',$module);
		$this->db->delete('config');
		
		foreach ($data as $key => $value) {
			if (substr($key, 0, strlen($module)) == $module) {
				
				if (!is_array($value)) {
					$this->db->insert('config', array("key"=>$key,"value"=>$value,"module"=>$module)); 
				} else {
					$this->db->insert('config', array("key"=>$key,"value"=>json_encode($value, true),"module"=>$module,"serialized"=>1)); 
				}
			}
		}
			
	}

	public function getActiveBonusAmount() {
		$this->db->from("bonus_amount");
		$this->db->where("is_active",1);
		$res = $this->db->get()->result();
		return $res;
	}

	public function getActiveWorkingShift() {
		$this->db->from("working_shift ws" );
		$this->db->join('shift_timing st', 'ws.id = st.working_shift_id', 'left');
		$this->db->where("is_active",1);
		$res = $this->db->get()->result();
// 		echo '<pre>';
// print_r($res);exit;
		// $resuletarr = [];
		// foreach ($res as $key => $value) {
		
		// 	$arr = [];
		// 	$this->db->from("shift_timing");
		// 	$this->db->where("working_shift_id",$value->id);

		// 	$condition = $this->db->get()->result();

		// 	$arr['id']= $value->id;
		// 	$arr['name']= $value->name;
		// 	$arr['timing']= $condition;
		// 	$resuletarr[] = $arr;
		// // }
		// echo '<pre>';
		// print_r($res);exit;
		return $res;
	}

	public function getActiveBonusType() {
		$this->db->from("bonus_type bt");

		$this->db->where("bt.is_active",1);
		$res = $this->db->get()->result();

		$resuletarr = [];
		foreach ($res as $key => $value) {
			// code...$this->db->join('bonus_condition bc', 'bt.id = bc.bonus_type_id', 'left');
			$arr = [];
			$this->db->from("bonus_amount ba");

			// $this->db->join('bonus_condition bc', 'ba.id = bc.bonus_amount_id', 'left');
			// $this->db->where("bc.bonus_type_id",$value->id);

			$bonus_amount = $this->db->get()->result();
			$amounts = [];
			foreach($bonus_amount as $amt){
				
				$this->db->from("bonus_condition ");
				$this->db->where("bonus_type_id",$value->id);
				$this->db->where("bonus_amount_id",$amt->id);
				$is_present=$this->db->count_all_results();

				if($is_present){
					$this->db->from("bonus_condition ");
					$this->db->where("bonus_type_id",$value->id);
					$this->db->where("bonus_amount_id",$amt->id);
					$res = $this->db->get()->result();
					$condition = $res[0]->threshold_condition;
					$amounts[$amt->id]['amount'] = $res[0]->threshold_value;
					
				} 
				

			}

			$arr['id']= $value->id;
			$arr['name']= $value->name;
			$arr['condition']= $condition;
			$arr['amount']= $amounts;
			$resuletarr[] = $arr;
		}
// echo '<pre>';
// 		print_r($resuletarr);exit;
		return $resuletarr;
	}

	public function getActivePointType() {
		$this->db->from("point_type ");
		$this->db->where("is_active",1);
		$res = $this->db->get()->result();

		$resuletarr = [];
		foreach ($res as $key => $value) {
		
			$arr = [];
			$this->db->from("point_rule");
			$this->db->where("type_id",$value->id);

			$condition = $this->db->get()->result();

			$arr['id']= $value->id;
			$arr['name']= $value->name;
			$arr['is_active']= $value->is_active;
			$arr['added_on']= $value->added_on;
			$arr['rules']= $condition;
			$resuletarr[] = $arr;
		}
		return $resuletarr;
	}

	public function getAllPointType() {
		$this->db->from("point_type ");
		$res = $this->db->get()->result();

		return $res;
	}

	public function getAllBonusType() {
		$this->db->from("bonus_type ");
		$res = $this->db->get()->result();

		return $res;
	}

	public function getPayroll() {
		$this->db->from("payroll_type ");
		$res = $this->db->get()->result();

		return $res;
	}
	public function getActivePayroll() {
		$this->db->from("payroll_type ");
		$this->db->where("is_active",1);
		$res = $this->db->get()->result();

		return $res;
	}

	public function getFallOff() {
		$this->db->from("recurrence ");
		$res = $this->db->get()->result();

		return $res;
	}

	public function getAllPointRule() {
		$this->db->from("point_rule pr");
		$this->db->select('pr.*, pt.name as type');
		$this->db->join('point_type pt', 'pt.id = pr.type_id', 'left');
		$res = $this->db->get()->result();
		return $res;
	}

	
	public function deletePayrollType($id){
		$this->db->select("*");
		$this->db->from("payroll_type");
		$this->db->where_in("id", $id);
		$this->db->delete("payroll_type");
	}
	public function deleteShift($id){
		$this->db->select("*");
		$this->db->from("working_shift");
		$this->db->where_in("id", $id);
		$this->db->delete("working_shift");

		$this->db->select("*");
		$this->db->from("shift_timing");
		$this->db->where_in("working_shift_id", $id);
		$this->db->delete("shift_timing");
	}

public function deletePointRuleType($id){
		$this->db->select("*");
		$this->db->from("point_rule");
		$this->db->where_in("id", $id);
		$this->db->delete("point_rule");
	}

	public function deletebonusType($id){
		$this->db->select("*");
		$this->db->from("bonus_type");
		$this->db->where_in("id", $id);
		$this->db->delete("bonus_type");
	}
	public function deletebonusamount($id){
		$this->db->select("*");
		$this->db->from("bonus_amount");
		$this->db->where_in("id", $id);
		$this->db->delete("bonus_amount");
	}

public function deletePointType($id){
		$this->db->select("*");
		$this->db->from("point_type");
		$this->db->where_in("id", $id);
		$this->db->delete("point_type");
	}

	public function getPayrollbyId($id){
		$this->db->where("id",$id);
		$res=$this->db->get('payroll_type')->result_array();
		return $res;
	}

	public function getShiftbyId($id){
		$this->db->where("id",$id);
		$res=$this->db->get('payroll_type')->result_array();
		return $res;
	}

	public function getPointRulebyId($id){
		$this->db->where("id",$id);
		$res=$this->db->get('point_rule')->result_array();

		return $res;
	}
	public function getPointTypebyId($id){
		$this->db->where("id",$id);
		$res=$this->db->get('point_type')->result_array();
		return $res;
	}

	public function getBonusTypebyId($id){
		$this->db->where("id",$id);
		$res=$this->db->get('bonus_type')->result_array();
		return $res;
	}

	public function getBonusAmountbyId($id){
		$this->db->where("id",$id);
		$res=$this->db->get('bonus_amount')->result_array();
		return $res;
	}

	public function addPayroll($data) {
      $this->db->from("payroll_type");
		$this->db->where("name",$data['name']);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}
     	
     	$status=$this->db->insert("payroll_type", $data);
      return $this->db->insert_id() ;
	}

	public function editPayroll($data, $id) {
		$this->db->from("payroll_type");
		$this->db->where("name",$data['name']);
		$this->db->where("id !=", $id);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}

		$this->db->where("id",$id);
      $status=$this->db->update("payroll_type", $data); 
     
      if($status) {
			return "success";
		}
	}

	public function UpdatePayroll($id) {
		// print_r($id);exit;
      $this->db->from("payroll_type");
      $this->db->update("payroll_type", ['is_selected' => '0']);

      $this->db->from("payroll_type");
		$this->db->where("id",$id);
		$status=$this->db->update("payroll_type", ['is_selected' => '1']); 

 		if($status) {
			return "success";
		}
	}

	public function UpdateFallOff($id) {
       $this->db->from("recurrence");
      $this->db->update("recurrence", ['is_selected' => '0']);

      $this->db->from("recurrence");
		$this->db->where("id",$id);
		$status=$this->db->update("recurrence", ['is_selected' => '1']);

 		if($status) {
			return "success";
		}
	}

	public function getSettingDetails() {
	   $this->db->from("settings");
		$res = $this->db->get()->result();

		return $res;
	}

	public function addShift($data) {
      $this->db->from("working_shift");
		$this->db->where("name",$data['name']);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}


     	
     	$status=$this->db->insert("working_shift", $data);

     	$this->db->from("shift_timing");
     	$data = [
     		'working_shift_id' =>$this->db->insert_id()
     	];
     	$status=$this->db->insert("shift_timing", $data);
      return $this->db->insert_id() ;
	}

	public function editShift($data, $id) {
		$this->db->from("working_shift");
		$this->db->where("name",$data['name']);
		$this->db->where("id !=", $id);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}

		$this->db->where("id",$id);
      $status=$this->db->update("working_shift", $data); 
     
      if($status) {
			return "success";
		}
	}

	public function addPointType($data) {
      $this->db->from("point_type");
		$this->db->where("name",$data['name']);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}
     	
     	$status=$this->db->insert("point_type", $data);
      return $this->db->insert_id() ;
	}

	public function editPointType($data, $id) {
		$this->db->from("point_type");
		$this->db->where("name",$data['name']);
		$this->db->where("id !=", $id);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}

		$this->db->where("id",$id);
      $status=$this->db->update("point_type", $data); 
     
      if($status) {
			return "success";
		}
	}

	public function addPointRule($data) {
      $this->db->from("point_rule");
		$this->db->where("name",$data['name']);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}
     	
     	$status=$this->db->insert("point_rule", $data);
      return $this->db->insert_id() ;
	}

	public function editPointRule($data, $id) {
		
		$this->db->where("id",$id);
      $status=$this->db->update("point_rule", $data); 
     
      if($status) {
			return "success";
		}
	}

	public function editShiftTiming($data, $id) {
		$this->db->from("shift_timing");
		
		$this->db->where("working_shift_id",$id);
      $status=$this->db->update("shift_timing", $data); 
     
      if($status) {
			return "success";
		}
	}

	public function addBonusType($data) {
      $this->db->from("bonus_type");
		$this->db->where("name",$data['name']);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}
     	
     	$status=$this->db->insert("bonus_type", $data);
      return $this->db->insert_id() ;
	}

	public function editBonusType($data, $id) {
		$this->db->from("bonus_type");
		$this->db->where("name",$data['name']);
		$this->db->where("id !=", $id);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}

		$this->db->where("id",$id);
      $status=$this->db->update("bonus_type", $data); 
     
      if($status) {
			return "success";
		}
	}

	public function addBonusAmount($data) {
      $this->db->from("bonus_amount");
		$this->db->where("name",$data['name']);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}
     	
     	$status=$this->db->insert("bonus_amount", $data);
      return $this->db->insert_id() ;
	}

	public function editBonusAmount($data, $id) {
		$this->db->from("bonus_amount");
		$this->db->where("name",$data['name']);
		$this->db->where("id !=", $id);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}

		$this->db->where("id",$id);
      $status=$this->db->update("bonus_amount", $data); 
     
      if($status) {
			return "success";
		}
	}

	public function addEditBonusRule($data){
		$this->db->from(" bonus_condition");
		$this->db->where("bonus_type_id",$data['bonus_type_id']);
		$this->db->where("bonus_amount_id",$data['bonus_amount_id']);
		
		$is_present=$this->db->count_all_results();

		if($is_present) {
 			$this->db->from(" bonus_condition");
			$this->db->where("bonus_type_id",$data['bonus_type_id']);
			$this->db->where("bonus_amount_id",$data['bonus_amount_id']);
      	$status=$this->db->update("bonus_condition", $data); 
 		} else{
 			$status=$this->db->insert("bonus_condition", $data);
      	$status= $this->db->insert_id() ;
 		}

 		return $status;
	}
}
