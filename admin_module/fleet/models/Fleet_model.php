<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * AIO ADMIN
 *
 * @author      Mark Price
 * @copyright   Copyright (c) 2012
 * @license     MIT License
 * @link        http://aioadmin.com
 */

class Fleet_model extends MY_Model
{	
   public function __construct(){
		parent::__construct();
	}
	
	public function addFleet($data, $files) {
      $status=$this->db->insert("fleet", $data);
      $res = $this->db->insert_id() ;
      if(!empty($_FILES['fleet_file']['name'])){
			$file_name = $_FILES['fleet_file']['name'];
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			$file_name = $data['vin'].'-'.time().'.'.$ext;

			$file_tmp = $_FILES['fleet_file']['tmp_name'];
			move_uploaded_file($file_tmp,'storage/uploads/images/'.$file_name);

			$page_data = array(
				"fleet_id" => $res,
				"document_name" => $file_name
			);
			$this->db->insert("fleet_image", $page_data);

     }
     return $res;
	}
	
	public function editFleet($id, $data, $files) {
		$this->db->where("id",$id);
      $status=$this->db->update("fleet", $data); 

     if(!empty($_FILES['fleet_file']['name'])){
			$file_name = $_FILES['fleet_file']['name'];
			$ext = pathinfo($file_name, PATHINFO_EXTENSION);
			$file_name = $data['vin'].'-'.time().'.'.$ext;

			$file_tmp = $_FILES['fleet_file']['tmp_name'];
			move_uploaded_file($file_tmp,'storage/uploads/images/'.$file_name);

			$page_data = array(
				"fleet_id" => $id,
				"document_name" => $file_name
			);
			$this->db->insert("fleet_image", $page_data);

     }
     
      if($status) {
			return "success";
		}
	}
	public function getFleets($data = array()){
		$this->db->from("fleet u");
		$this->db->join('route_type rt', 'rt.id = u.route_type_id', 'left');
		$this->db->join('fleet_history fh', 'fh.fleet_id = u.id', 'left');
		$this->db->group_by('u.id');
		$this->db->select("u.id as id, u.vin as vin, u.vehicle_name as vehicle_id, u.notes as notes,u.status as status, rt.name as route_type, COUNT(fh.id) as history");
		
		if (!empty($data['filter_search'])) {
			$this->db->where("
				u.vin LIKE '%{$data['filter_search']}%'
				OR u.vehicle_name LIKE '%{$data['filter_search']}%'
				OR rt.name LIKE '%{$data['filter_search']}%'
				OR u.notes LIKE '%{$data['filter_search']}%'
				"				
			);
		}

		if (isset($data['sort']) && $data['sort']) {
			$sort = $data['sort'];
		} else {
			$sort = "u.vin";
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
	public function getTotalFleet($data = array()) {
		$this->db->from("fleet u");
		$this->db->join('route_type rt', 'rt.id = u.route_type_id', 'left');
		$this->db->select("u.id as id, u.vin as vin, u.vehicle_name as vehicle_id, u.notes as notes,u.status as status, rt.name as route_type");
		
		if (!empty($data['filter_search'])) {
			$this->db->where("
				u.vin LIKE '%{$data['filter_search']}%'
				OR u.vehicle_name LIKE '%{$data['filter_search']}%'
				OR rt.name LIKE '%{$data['filter_search']}%'
				OR u.notes LIKE '%{$data['filter_search']}%'
				"				
			);
		}
		//$this->db->where("user_group_id",4);
		
		$count = $this->db->count_all_results();

		return $count;
		
	}

	public function getFleetImages($id){
		$this->db->where("fleet_id",$id);
		$res=$this->db->get('fleet_image')->result();
		return $res;
	}
	
	public function getFleet($id){
		
		$this->db->where("id",$id);
		$res=$this->db->get('fleet')->row();
		return $res;
	}

	public function getFleetHistory($id){
		$this->db->from("fleet u");
		$this->db->join('fleet_history fh', 'fh.fleet_id = u.id');
		$this->db->join('user ur', 'fh.driver_id = ur.id', 'left');
		$this->db->select("u.id as id, fh.notes as notes,  ur.name as driver, fh.issued_at, fh.retured_at");
		$this->db->where('u.id',$id);
		$res = $this->db->get()->result();

		return $res;
	}
	
	public function getUserByEmail($email) {
		$this->db->where('email',$email);
		$query = $this->db->get('user');
		$User=$query->row();
		
		return $User;
	}
	
	public function getUserByUsername($name) {
		$this->db->where('name', $name);
		$query = $this->db->get('user');
		$User=$query->row();
		return $User;
	}
	
	
	public function deleteFleet($id){
		$this->db->select("*");
		$this->db->from("fleet");
		$this->db->where_in("id", $id);
		$this->db->delete("fleet");
	}
	
	public function sendmail($id){
		$this->db->select("*");
		$this->db->from("user");
		$this->db->where_in("id", $id);
	}

	public function getCountry($country_id) {
		$this->db->from("aio_country");
		$this->db->where("country_id",$country_id);
		$res = $this->db->get()->row();
		return $res->name;
	}
	
	public function getState($state_id) {
		$this->db->from("aio_state");
		$this->db->where("state_id",$state_id);
		$res = $this->db->get()->row();
		if(!empty($res))
		return $res->name;
		else
		return '';
	}

	//blysts




	public function getCategories(){
		$this->db->from("category");
		$res = $this->db->get()->result_array();
		return $res;	
	}

	public function getUserDocuments($user_id){
		$this->db->from("document");
		$this->db->where("user", $user_id);
		$this->db->where("is_approved", 0);
		$res = $this->db->get()->result_array();
		return $res;	
	}

	public function getUserSentDocuments($user_id){
		$this->db->from("document");
		$this->db->where("user", $user_id);
		$this->db->where("is_approved", 1);
		$res = $this->db->get()->result_array();
		return $res;	
	}

	public function getUserNotSentDocuments($user_id){
		$this->db->from("document");
		$this->db->where("user", $user_id);
		$this->db->where("is_approved IS NULL");
		$res = $this->db->get()->result_array();
		//echo $this->db->last_query();
		return $res;	
	}

	public function getVehicleMakes(){
		$this->db->from("car_makes");
		$this->db->where("is_active", 1);
		$this->db->order_by('name', 'ASC');
		$res = $this->db->get()->result_array();
		return $res;
	}

	public function getAllVehicleMakes(){
		$this->db->from("car_makes");
		$this->db->order_by('name', 'ASC');
		$res = $this->db->get()->result_array();
		return $res;
	}

	public function getOwnershipType(){
		$this->db->from("ownership_type");
		
		$this->db->where("is_active", 1);
		$this->db->order_by('name', 'ASC');
		$res = $this->db->get()->result_array();
		return $res;
	}


	public function getAllOwnershipType(){
		$this->db->from("ownership_type");
		$this->db->order_by('name', 'ASC');
		$res = $this->db->get()->result_array();
		return $res;
	}

	public function getRouteType(){
		$this->db->from("route_type");
		$this->db->where("is_active", 1);
		$this->db->order_by('name', 'ASC');
		$res = $this->db->get()->result_array();
		return $res;
	}
	public function getAllRouteType(){
		$this->db->from("route_type");
		$this->db->order_by('name', 'ASC');
		$res = $this->db->get()->result_array();
		return $res;
	}


	public function getAllServiceTier(){
		$this->db->from("service_tier");
		$this->db->order_by('name', 'ASC');
		$res = $this->db->get()->result_array();
		return $res;
	}

	public function getServiceTier(){
		$this->db->from("service_tier");
		$this->db->where("is_active", 1);
		$this->db->order_by('name', 'ASC');
		$res = $this->db->get()->result_array();
		return $res;
	}

	public function getAllVehicleProvider(){
		$this->db->from("vehicle_provider");
		$this->db->order_by('name', 'ASC');
		$res = $this->db->get()->result_array();
		return $res;
	}

public function getVehicleProvider(){
		$this->db->from("vehicle_provider");
		$this->db->where("is_active", 1);
		$this->db->order_by('name', 'ASC');
		$res = $this->db->get()->result_array();
		return $res;
	}
	
	public function getAllStatusReasonCode(){
		$this->db->from("status_reason_code");
		$this->db->order_by('name', 'ASC');
		$res = $this->db->get()->result_array();
		return $res;
	}

	public function getStatusReasonCode(){
		$this->db->from("status_reason_code");
		$this->db->where("is_active", 1);
		$this->db->order_by('name', 'ASC');
		$res = $this->db->get()->result_array();
		return $res;
	
	}

	public function getRegisteredStates(){
		$this->db->from("states");
		$this->db->select("states.name as name, states.id as id,  states.code as state_code");
		$this->db->join('countries', 'states.country_id = countries.id');

		$this->db->where("countries.name", "United States");
		$res = $this->db->get()->result_array();

		$data['data'][0]['name'] = "United States";
		$data['data'][0]['states'] = $res;
		return $data;
	}



	public function getVehicleModelsByMakeID($makes_id){
		$this->db->from("car_models");
		$this->db->where("is_active", 1);
		$this->db->where("makes_id", $makes_id);
		$res = $this->db->get()->result_array();
		return $res;
	}


	public function addRouteType($data) {
		$this->db->from("route_type");
		$this->db->where("name",$data['name']);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}
     	
     	$status=$this->db->insert("route_type", $data);
      return $this->db->insert_id() ;
      
	}
	public function deleteRouteType($id){
		$this->db->select("*");
		$this->db->from("route_type");
		$this->db->where_in("id", $id);
		$this->db->delete("route_type");
	}

	public function getRouteTypebyId($id){
		$this->db->where("id",$id);
		$res=$this->db->get('route_type')->result_array();
		return $res;
	}

	public function editRouteType($data, $id) {
		$this->db->from("route_type");
		$this->db->where("name",$data['name']);
		$this->db->where("id !=", $id);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}
 		
		$this->db->where("id",$id);
      $status=$this->db->update("route_type", $data); 
     
      if($status) {
			return "success";
		}
	}

	public function enabledisableRouteType( $id) {
		$this->db->from("route_type");
		$this->db->where("id ", $id);
		$is_present=$this->db->result_array();

 		if($is_present) {
 			return $is_present;
 		}
 		
      if($status) {
			return "success";
		}
	}

	public function addVehicleProviders($data) {
		$this->db->from("vehicle_provider");
		$this->db->where("name",$data['name']);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}
     	
     	$status=$this->db->insert("vehicle_provider", $data);
      return $this->db->insert_id() ;
	}
	public function deleteVehicleProviders($id){
		$this->db->select("*");
		$this->db->from("vehicle_provider");
		$this->db->where_in("id", $id);
		$this->db->delete("vehicle_provider");
	}

	public function getVehicleProvidersbyId($id){
		$this->db->where("id",$id);
		$res=$this->db->get('vehicle_provider')->result_array();
		return $res;
	}

	public function editVehicleProviders($data, $id) {
		$this->db->from("vehicle_provider");
		$this->db->where("name",$data['name']);
		$this->db->where("id !=", $id);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}
		$this->db->where("id",$id);
      $status=$this->db->update("vehicle_provider", $data); 
     
      if($status) {
			return "success";
		}
	}

	public function addOwnershipType($data) {

		$this->db->from("ownership_type");
		$this->db->where("name",$data['name']);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}
     	
     	$status=$this->db->insert("ownership_type", $data);
      return $this->db->insert_id() ;

	}
	public function deleteOwnershipType($id){
		$this->db->select("*");
		$this->db->from("ownership_type");
		$this->db->where_in("id", $id);
		$this->db->delete("ownership_type");
	}

	public function getOwnershipTypebyId($id){
		$this->db->where("id",$id);
		$res=$this->db->get('ownership_type')->result_array();
		return $res;
	}

	public function editOwnershipType($data, $id) {
		$this->db->from("ownership_type");
		$this->db->where("name",$data['name']);
		$this->db->where("id !=", $id);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}
		$this->db->where("id",$id);
      $status=$this->db->update("ownership_type", $data); 
     
      if($status) {
			return "success";
		}
	}


	public function addServiceTier($data) {
		$this->db->from("service_tier");
		$this->db->where("name",$data['name']);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}
     	
     	$status=$this->db->insert("service_tier", $data);
      return $this->db->insert_id() ;
	}
	public function deleteServiceTier($id){
		$this->db->select("*");
		$this->db->from("service_tier");
		$this->db->where_in("id", $id);
		$this->db->delete("service_tier");
	}

	public function getServiceTierbyId($id){
		$this->db->where("id",$id);
		$res=$this->db->get('service_tier')->result_array();
		return $res;
	}

	public function editServiceTier($data, $id) {
		$this->db->from("service_tier");
		$this->db->where("name",$data['name']);
		$this->db->where("id !=", $id);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}

		$this->db->where("id",$id);
      $status=$this->db->update("service_tier", $data); 
     
      if($status) {
			return "success";
		}
	}


	public function addStatusReasonCodes($data) {
		$this->db->from("status_reason_code");
		$this->db->where("name",$data['name']);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}
     	
     	$status=$this->db->insert("status_reason_code", $data);
      return $this->db->insert_id() ;

	}
	public function deleteStatusReasonCodes($id){
		$this->db->select("*");
		$this->db->from("status_reason_code");
		$this->db->where_in("id", $id);
		$this->db->delete("status_reason_code");
	}

	public function getStatusReasonCodesbyId($id){
		$this->db->where("id",$id);
		$res=$this->db->get('status_reason_code')->result_array();
		return $res;
	}

	public function editStatusReasonCodes($data, $id) {
		$this->db->from("status_reason_code");
		$this->db->where("name",$data['name']);
		$this->db->where("id !=", $id);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}

		$this->db->where("id",$id);
      $status=$this->db->update("status_reason_code", $data); 
     
      if($status) {
			return "success";
		}
	}


	public function addCarMakes($data) {
      $this->db->from("car_makes");
		$this->db->where("name",$data['name']);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}
     	
     	$status=$this->db->insert("car_makes", $data);
      return $this->db->insert_id() ;
	}

	public function deleteCarMakes($id){
		$this->db->select("*");
		$this->db->from("car_makes");
		$this->db->where_in("id", $id);
		$this->db->delete("car_makes");

		//delete related models
		$this->db->select("*");
		$this->db->from("car_models");
		$this->db->where("makes_id",$id);
		$this->db->delete("car_models");
	}

	public function getCarMakesbyId($id){
		$this->db->where("id",$id);
		$res=$this->db->get('car_makes')->result_array();
		return $res;
	}

	public function editCarMakes($data, $id) {
		$this->db->from("car_makes");
		$this->db->where("name",$data['name']);
		$this->db->where("id !=", $id);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}

		$this->db->where("id",$id);
      $status=$this->db->update("car_makes", $data); 
     	if($data['is_active'] == 1){
     		$this->db->from("car_models");
			$this->db->where("makes_id",$id);
			$status=$this->db->update("car_models", ['is_active' => 1]);
     	} else {
     		$this->db->from("car_models");
			$this->db->where("makes_id",$id);
			$status=$this->db->update("car_models", ['is_active' => 0]);
     	}
      if($status) {
			return "success";
		}
	}

	public function getAllVehicleModels(){
		$this->db->from("car_models cd");
		$this->db->join('car_makes ck', 'ck.id = cd.makes_id');
		$this->db->select("cd.*, ck.name as makes");
		$res = $this->db->get()->result_array();
		return $res;
	}

		public function addVehicleModels($data) {
      $this->db->from("car_models");
		$this->db->where("name",$data['name']);
		$this->db->where("makes_id", $data['makes_id']);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}
     	
     	$status=$this->db->insert("car_models", $data);
      return $this->db->insert_id() ;
	}

	public function deleteVehicleModels($id){
		$this->db->select("*");
		$this->db->from("car_models");
		$this->db->where_in("id", $id);
		$this->db->delete("car_models");
	}

	public function getVehicleModelsbyId($id){
		$this->db->where("id",$id);
		$res=$this->db->get('car_models')->result_array();
		return $res;
	}

	public function editVehicleModels($data, $id) {
		$this->db->from("car_models");
		$this->db->where("name",$data['name']);
		$this->db->where("makes_id", $data['makes_id']);
		$this->db->where("id !=", $id);
		$is_present=$this->db->count_all_results();

 		if($is_present) {
 			return false;
 		}

		$this->db->where("id",$id);
      $status=$this->db->update("car_models", $data); 
     
      if($status) {
			return "success";
		}
	}

	public function getFleetCount($search_type){
		$count = 0;
		switch($search_type){
			case 1:
				$this->db->select("count(id) as count");
				$this->db->where("status", 1);
				$res = $this->db->get('fleet')->row();
				$count = $res->count;
				break;
			case 2:
				$this->db->select("count(id) as count");
				$this->db->where("status", 0);
				$res = $this->db->get('fleet')->row();
				$count = $res->count;
				break;
			case 3:
				$this->db->select("count(distinct driver_id) as count");
				$this->db->where("retured_at", NULL);
				$res = $this->db->get('fleet_history')->row();
				//echo $this->db->last_query();
				$count = $res->count;
				break;
		}

		return $count;
	}
	
}
