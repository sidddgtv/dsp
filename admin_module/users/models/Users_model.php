<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * AIO ADMIN
 *
 * @author      Mark Price
 * @copyright   Copyright (c) 2012
 * @license     MIT License
 * @link        http://aioadmin.com
 */

class Users_model extends MY_Model
{	
   public function __construct(){
		parent::__construct();
	}
	
	public function addUser($data) {
      $status=$this->db->insert("user", $data);
      return $this->db->insert_id();
	}
	
	public function editUser($id, $data) {
		$this->db->where("id",$id);
      $status=$this->db->update("user", $data); 
      if($status) {
			return "success";
		}
	}
	public function getActiveUsers($data = array()){
		$this->db->from("user u");
		$this->db->where("activated", 1);
		$this->db->where('user_group_id', 2);

		if (!empty($data['filter_search'])) {
			$this->db->where("
				u.name LIKE '%{$data['filter_search']}%'
				OR u.email LIKE '%{$data['filter_search']}%'
				"				
			);
		}


		$res = $this->db->get()->result();

		return $res;
	}
	public function getUsers($data = array(), $activated_status = 0){
		$this->db->select("*");
		$this->db->from("user u");
		//$this->db->join('user_group ug', 'ug.user_group_id = u.user_group_id');
		
		if (!empty($data['filter_search'])) {
			$this->db->where("
				u.name LIKE '%{$data['filter_search']}%'
				OR u.email LIKE '%{$data['filter_search']}%'
				"				
			);
		}

		if (isset($data['sort']) && $data['sort']) {
			//echo $data['sort'];
			if($data['sort'] == 4){
				//active not active
				$sort = 'u.activated';
			}else{
				$sort = $data['sort'];
			}
		} else {
			$sort = "u.name";
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

		//add activated status also
		switch($activated_status){
			case 1:
				$this->db->where("activated", 1);
				break;
			case 2:
				$this->db->where("activated", 0);
				break;
		}
		//$this->db->where("user_group_id",4);
		$this->db->where('user_group_id !=' , 1);
		$res = $this->db->get()->result();

		return $res;
	}
	public function getTotalUsers($data = array(), $activated_status = 0){
		$this->db->from("user u");
		//$this->db->join('user_group ug', 'ug.user_group_id = u.user_group_id');
		
		if (!empty($data['filter_search'])) {
			$this->db->where("
				u.name LIKE '%{$data['filter_search']}%'
				OR u.email LIKE '%{$data['filter_search']}%'
				"				
			);
		}
		//$this->db->where("user_group_id",4);
		$this->db->where('user_group_id !=' , 1);
		//add activated status also
		switch($activated_status){
			case 1:
				$this->db->where("activated", 1);
				break;
			case 2:
				$this->db->where("activated", 0);
				break;
		}
		$count = $this->db->count_all_results();

		return $count;
		
	}
	
	public function getUser($id){
		$this->db->where("id",$id);
		$res=$this->db->get('user')->row();
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
		$this->db->where('user_group_id !=' , 1);
		$query = $this->db->get('user');
		$User=$query->row();
		return $User;
	}
	
	
	public function deleteUser($id){
		$this->db->select("*");
		$this->db->from("user");
		$this->db->where_in("id", $id);
		$this->db->delete("user");
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
		$this->db->where("is_approved", 0);
		$res = $this->db->get()->result_array();
		//echo $this->db->last_query();
		return $res;	
	}

	public function addScorecard($data) {
		$status=$this->db->insert("scorecard", $data);
		//echo $this->db->last_query();
		return $this->db->insert_id();
	}

	public function noScorecardExists($driver_id, $week, $year){
		$this->db->where('driver_id', $driver_id);
		$this->db->where('week_number', $week);
		$this->db->where('year_number', $year);
		$this->db->from('scorecard');
		$count = $this->db->count_all_results();
		if($count == 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function getScorecard($driver_id, $week, $year){
		$this->db->from("scorecard");
		$this->db->where("driver_id", $driver_id);
		$this->db->where("week_number", $week);
		$this->db->where("year_number", $year);
		$res = $this->db->get()->row_array();
		//echo $this->db->last_query();
		return $res;	
	}

	public function getScorecardbyID($id){
		$this->db->from("scorecard");
		$this->db->where("id", $id);
		$res = $this->db->get()->row_array();
		//echo $this->db->last_query();
		return $res;	
	}

	public function getDriverbyFirstLastName($first_name, $last_name) {
		//$this->db->like('name', $first_name);
		//$this->db->like('name', $last_name);

		$this->db->where("name LIKE '$first_name%'");
		$this->db->where("name LIKE '%$last_name'");

		//SELECT * FROM `user` WHERE `name` LIKE 'ANDREW%' ESCAPE '!' AND `name` LIKE '%BARAJAS' ESCAPE '!' AND `user_group_id` != 1;

		$this->db->where('user_group_id !=', 1);
		$query = $this->db->get('user');
		$User = $query->row();
		//echo $this->db->last_query();
		return $User;
	}

	public function getActiveDriversCount() {
		$this->db->select('count(id) as total_count');
		$this->db->where('user_group_id', 2);
		$this->db->where('activated', 1);
		$this->db->from('user');
		$res = $this->db->get()->row_array();
		//echo $this->db->last_query();
		return $res['total_count'];
	}

	public function getAllDriversCount() {
		$this->db->select('count(id) as total_count');
		$this->db->where('user_group_id', 2);
		//$this->db->where('activated', 1);
		$this->db->from('user');
		$res = $this->db->get()->row_array();
		//echo $this->db->last_query();
		return $res['total_count'];
	}

	public function getMessages($from_id, $to_id){
		$this->db->select('*');
		$this->db->where(' (from_id = '.$from_id.' AND to_id = '.$to_id.') OR (from_id = '.$to_id.' AND to_id = '.$from_id.') ');
		$this->db->order_by('added_on' , 'ASC');
		$query = $this->db->get('messages');
		$Page = $query->result();
		return $Page;
	}

	public function getMessageUsers($user_id){
		$this->db->distinct();
		$this->db->select('u.id, u.name, u.image');
		$this->db->where('m.to_id', $user_id);
		$this->db->join('user u', 'm.from_id = u.id');
		$query = $this->db->get('messages m');
		$Page = $query->result();
		return $Page;
	}

	public function replyChat($data){
		$chat_data = array(
			"from_id"=>$data['from_id'],
			"to_id"=>$data['to_id'],
			"message_body"=>$data['message_body']
		);

		$this->db->insert("messages", $chat_data);
	}

	public function addTyping($data){
		$chat_data = array(
			"from_id"=>$data['from_id'],
			"to_id"=>$data['to_id']
		);

		$this->db->insert("typing", $chat_data);

		//update marker to refresh other side user
		$u_data = array("screen_update" => 1);
		$this->db->where("id", $data['to_id']);
		$this->db->update("user", $u_data);
	}

	public function removeTyping($data){
		$chat_data = array(
			"from_id"=>$data['from_id'],
			"to_id"=>$data['to_id']
		);

		$this->db->delete("typing", $chat_data);
	}

	public function checkTyping($data){
		$this->db->where('from_id', $data['from_id']);
		$this->db->where('to_id', $data['to_id']);

		$query = $this->db->get('typing');
		$count = $query->num_rows();

		return $count;
	}

	public function checkIfChatUpdateRequired($data){
		$this->db->where('id', $data['user_id']);

		$query = $this->db->get('user');
		$Page = $query->row_array();
		//print_r($Page);
		if($Page['screen_update'] == 1){
			//reset to 0
			$u_data = array("screen_update" => 0);
			$this->db->where("id", $data['user_id']);
			$this->db->update("user", $u_data);
			echo 1;
		}else{
			echo 0;
		}
	}

	public function broadcastMessage($message){
		//send message to every user
		$drivers = $this->getUsers();
		foreach($drivers as $d){
			$data = array(
				"from_id"=>1,
				"to_id"=>$d->id,
				"message_body"=>$message
			);
			$this->replyChat($data);
		}
	}

	public function getWeekGlanceCount($search_type, $week_number, $year_number){
		$count = 0;
		
		$this->db->select("count(id) as count");
		$this->db->where("overall_standing", $search_type);
		$this->db->where("week_number", $week_number);
		$this->db->where("year_number", $year_number);
		$res = $this->db->get('scorecard')->row();
		//echo $this->db->last_query();
		$count = $res->count;

		return $count;
	}

	public function overallFICORate($week_number, $year_number){
		$this->db->select("avg(fico) as rate");
		$this->db->where("week_number", $week_number);
		$this->db->where("year_number", $year_number);
		$res = $this->db->get('scorecard')->row();
		//echo $this->db->last_query();
		return $res->rate;
	}

	public function addTempDriver($full_name){
		$this->db->from('tmp_user');
		$this->db->where('full_name', $full_name);
		$query = $this->db->get();
	
		if ($query->num_rows() === 0) {
			// Record does not exist, insert it
			$data = array('full_name' => $full_name);
			$status = $this->db->insert('tmp_user', $data);
	
			if ($status) {
				return "Record inserted successfully.";
			} else {
				return "Error in inserting record.";
			}
		} else {
			// Record exists
			return "Record with this full name already exists.";
		}
	}

	public function getallTempDrivers(){
		$this->db->from("tmp_user");
		$res = $this->db->get()->result();

		return $res;
	}

	function emailAddressExists($email_id){
		$this->db->select('id');
		$this->db->from('user');
		$this->db->where('email', $email_id);
		return $this->db->count_all_results();
	}

	public function deleteTempUser($id){
		$this->db->select("*");
		$this->db->from("tmp_user");
		$this->db->where_in("id", $id);
		$this->db->delete("tmp_user");
	}

	public function bonusConditions(){
		$this->db->from('bonus_condition bc');
		$this->db->join('bonus_type bt', 'bt.id = bc.bonus_type_id');
		$this->db->join('bonus_amount ba', 'ba.id = bc.bonus_amount_id');
		return $this->db->get()->result();
	}

	public function checkBonusAmount($scorecard_id){
		//echo $scorecard_id.'-';
		if(empty($scorecard_id) || $scorecard_id <= 0){
			return array(
				'bonus' => 0,
				'tier' => 0,
				'breakdown' => ''
			);
		}
		$scorecard_data = $this->getScorecardbyID($scorecard_id);
		$bonus_data = $this->bonusConditions();

		$budget = 0;
		$tier = 0;
		$breakdown = '';

		$fico_sub_condition = TRUE;

		$key = array(
			1 => 'fico',
			2 => 'acceleration',
			3 => 'braking',
			4 => 'cornering',
			5 => 'distraction',
			6 => 'seatbelt_off_rate',
			7 => 'speeding',
			8 => 'speeding_event_rate',
			9 => 'distractions_rate',
			10 => 'looking_at_phone',
			11 => 'talking_on_phone',
			12 => 'looking_down',
			13 => 'following_distance_rate',
			14 => 'sign_signal_violations_rate',
			15 => 'stop_sign_violations',
			16 => 'stop_light_violations',
			17 => 'illegal_u_turns',
			18 => 'cdf',
			19 => 'dcr',
			20 => 'dsb',
			21 => 'swc_pod',
			22 => 'swc_cc',
			23 => 'swc_ad',
			24 => 'dnrs',
			25 => 'pod_opps',
			26 => 'cc_opps',
			27 => 'customer_escalation_defect',
			28 => 'customer_delivery_feedback',
			29 => 'shipments_zone_hour',
			30 => 'delivered_packages',
			31 => 'overall_quality_score'

		);

		$final_bonus = array();

		foreach($bonus_data as $b){
			$key_printable_text = strtoupper(str_replace("_", " ", $key[$b->bonus_type_id]));
			//check and create blank array
			if(!array_key_exists($b->bonus_type_id, $final_bonus)){
				$final_bonus[$b->bonus_type_id] = array();
			}
			
			//echo '<pre>';print_r($b);
			//print_r($key[$b->bonus_type_id]);die;
			/*
			stdClass Object
			(
				[id] => 1
				[bonus_type_id] => 1
				[bonus_amount_id] => 2
				[threshold_condition] => 2, 3
				[threshold_value] => 2
				[added_on] => 2024-01-09 22:36:24
				[name] => FICO
				[is_active] => 1
			)

			1 If Greater than (>)
			2 If Less than (<)
			3 If Equal than (=) 
			*/
			//$scorecard_data['fico']
			//read threshold first
			//echo $scorecard_data[$key[$b->bonus_type_id]] .'XX'. $b->threshold_value;
			
			$threshold_condition = explode(',', $b->threshold_condition);
			//print_r($threshold_condition);die;

			//echo in_array("1", $threshold_condition) && in_array("3", $threshold_condition);
			
			//die;
			//create logic
			if(in_array("1", $threshold_condition) && in_array("3", $threshold_condition)){
				$tmp_val = floatval($scorecard_data[$key[$b->bonus_type_id]]);
				$fico_sub_condition = $this->fico_sub_condition($fico_sub_condition, $b->bonus_type_id, $scorecard_data[$key[$b->bonus_type_id]]);
				if($key[$b->bonus_type_id] == 'cdf' || $key[$b->bonus_type_id] == 'swc_cc'){
					$tmp_val *= 100;
				}
				
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && $tmp_val >= floatval($b->threshold_value) && !empty($scorecard_data[$key[$b->bonus_type_id]])) {
					//$budget = $budget + $b->amount;
					//$tier = 1;
					//$breakdown .= '<tr><td>1'.$key_printable_text.'</td><td>>=</td><td>$'.$b->amount.'</td><td>1</td></tr>';
					$final_bonus[$b->bonus_type_id]['amount'] = $b->amount;
					$final_bonus[$b->bonus_type_id]['tier'] = $b->id;//1
					$final_bonus[$b->bonus_type_id]['breakdown'] = '<tr><td>'.$key_printable_text.'</td><td>>=</td><td>$'.$b->amount.'</td><td>'.$b->id.'</td></tr>';
				}
			}else if(in_array("2", $threshold_condition) && in_array("3", $threshold_condition)){
				$tmp_val = floatval($scorecard_data[$key[$b->bonus_type_id]]);
				$fico_sub_condition = $this->fico_sub_condition($fico_sub_condition, $b->bonus_type_id, $scorecard_data[$key[$b->bonus_type_id]]);
				if($key[$b->bonus_type_id] == 'cdf' || $key[$b->bonus_type_id] == 'swc_cc'){
					$tmp_val *= 100;
				}
				
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && $tmp_val <= floatval($b->threshold_value) && !empty($scorecard_data[$key[$b->bonus_type_id]])) {
					//$budget = $budget + $b->amount;
					//$tier = 2;
					//$breakdown .= '<tr><td>2'.$key_printable_text.'</td><td><=</td><td>$'.$b->amount.'</td><td>2</td></tr>';
					$final_bonus[$b->bonus_type_id]['amount'] = $b->amount;
					$final_bonus[$b->bonus_type_id]['tier'] = $b->id;//2;
					$final_bonus[$b->bonus_type_id]['breakdown'] = '<tr><td>'.$key_printable_text.'</td><td><=</td><td>$'.$b->amount.'</td><td>'.$b->id.'</td></tr>';
				}
			}else if(in_array("1", $threshold_condition)){
				//echo 1;
				$tmp_val = floatval($scorecard_data[$key[$b->bonus_type_id]]);
				$fico_sub_condition = $this->fico_sub_condition($fico_sub_condition, $b->bonus_type_id, $scorecard_data[$key[$b->bonus_type_id]]);
				if($key[$b->bonus_type_id] == 'cdf' || $key[$b->bonus_type_id] == 'swc_cc'){
					$tmp_val *= 100;
				}
				
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && $tmp_val > floatval($b->threshold_value) && !empty($scorecard_data[$key[$b->bonus_type_id]])) {
					//$budget = $budget + $b->amount;
					//$tier = 1;
					//$breakdown .= '<tr><td>3'.$key_printable_text.'</td><td>></td><td>$'.$b->amount.'</td><td>1</td></tr>';
					$final_bonus[$b->bonus_type_id]['amount'] = $b->amount;
					$final_bonus[$b->bonus_type_id]['tier'] = $b->id;//1;
					$final_bonus[$b->bonus_type_id]['breakdown'] = '<tr><td>'.$key_printable_text.'</td><td>></td><td>$'.$b->amount.'</td><td>'.$b->id.'</td></tr>';
				}
			}else if(in_array("2", $threshold_condition)){
				$tmp_val = floatval($scorecard_data[$key[$b->bonus_type_id]]);
				$fico_sub_condition = $this->fico_sub_condition($fico_sub_condition, $b->bonus_type_id, $scorecard_data[$key[$b->bonus_type_id]]);
				if($key[$b->bonus_type_id] == 'cdf' || $key[$b->bonus_type_id] == 'swc_cc'){
					$tmp_val *= 100;
				}
				
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && $tmp_val < floatval($b->threshold_value) && !empty($scorecard_data[$key[$b->bonus_type_id]])) {
					//$budget = $budget + $b->amount;
					//$tier = 2;
					//$breakdown .= '<tr><td>4'.$key_printable_text.'</td><td><</td><td>$'.$b->amount.'</td><td>2</td></tr>';
					$final_bonus[$b->bonus_type_id]['amount'] = $b->amount;
					$final_bonus[$b->bonus_type_id]['tier'] = $b->id;//2;
					$final_bonus[$b->bonus_type_id]['breakdown'] = '<tr><td>'.$key_printable_text.'</td><td><</td><td>$'.$b->amount.'</td><td>'.$b->id.'</td></tr>';
				}
			}else if(in_array("3", $threshold_condition)){
				$tmp_val = floatval($scorecard_data[$key[$b->bonus_type_id]]);
				$fico_sub_condition = $this->fico_sub_condition($fico_sub_condition, $b->bonus_type_id, $scorecard_data[$key[$b->bonus_type_id]]);
				if($key[$b->bonus_type_id] == 'cdf' || $key[$b->bonus_type_id] == 'swc_cc'){
					$tmp_val *= 100;
				}
				
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && $tmp_val == floatval($b->threshold_value) && !empty($scorecard_data[$key[$b->bonus_type_id]])) {
					//echo 1;
					//$budget = $budget + $b->amount;
					//$tier = 3;
					//$breakdown .= '<tr><td>5'.$key_printable_text.'</td><td>=</td><td>$'.$b->amount.'</td><td>3</td></tr>';
					$final_bonus[$b->bonus_type_id]['amount'] = $b->amount;
					$final_bonus[$b->bonus_type_id]['tier'] = $b->id;//3;
					$final_bonus[$b->bonus_type_id]['breakdown'] = '<tr><td>'.$key_printable_text.'</td><td>=</td><td>$'.$b->amount.'</td><td>'.$b->id.'</td></tr>';
				}
			}
			
		}

		//print_r($final_bonus);
		//caculate total
		if(!empty($final_bonus)){
			$fb_keys = array_keys($final_bonus);
			for($i=0;$i<count($fb_keys);$i++){
				if(!empty($final_bonus[$fb_keys[$i]])){
					$budget = $budget + $final_bonus[$fb_keys[$i]]['amount'];	
					$tier = $final_bonus[$fb_keys[$i]]['tier'];
					$breakdown = $breakdown . $final_bonus[$fb_keys[$i]]['breakdown'];
				}
			}
		}

		//first calcualte if all 4 are eligible
		//FICO>=$32CDF>=$32SWC CC>=$43SHIPMENTS ZONE HOUR>=$21 

		// Your target array
		$array = ["FICO", "CDF", "SWC CC", "SHIPMENTS ZONE HOUR"];

		// The texts to check for in the array
		$required_texts = $breakdown;//["FICO", "CDF", "SWC CC", "SHIPMENTS ZONE HOUR"];

		//$required_texts = explode("</td><td>", $required_texts_str);

		// Function to check if all required texts are in the array
		//var_dump($fico_sub_condition);

		// Check if all required texts are in the array
		// also check FICO sub checks
		if ($this->allTextsAvailable($array, $required_texts) && $fico_sub_condition) {
			//echo "All texts are available in the array.";
			return array(
				'bonus' => $budget,
				'tier' => $tier,
				'breakdown' => $breakdown
			);
		} else {
			//echo "Not all texts are available in the array.";
			return array(
				'bonus' => 0,
				'tier' => 0,
				'breakdown' => ''
			);
		}

		
	}

	private function allTextsAvailable($array, $string){
		//echo $texts;
		foreach ($array as $item) {
			// Use strpos to check if the item is in the string
			if (strpos($string, $item) === false) {
				return false; // As soon as one item is not found, return false
			}
		}
		return true; // All elements were found
	}

	private function fico_sub_condition($prev_condition, $field, $value){
		//echo $field.':'.$value.'<br/>';
		if($prev_condition == FALSE){
			return FALSE;
		}else if($field >= 2 && $field <=17 && ($value == 0 || empty($value))){
			return TRUE;
		}else if($field >= 2 && $field <=17 && $value !== 0){
			//echo $field.':'.$value.'\n';
			return FALSE;
		}else{
			return $prev_condition;
		}
	}

	public function getLastUpdatedWeekYear(){
		// Select the maximum week_number and year_number from the scorecard table
        $this->db->select_max('week_number', 'max_week_number');
        $this->db->select_max('year_number', 'max_year_number');
        $query = $this->db->get('scorecard');

        // Check if the query was successful
        if ($query->num_rows() > 0) {
            // Return the result as an array
            return $query->row_array();
        } else {
            // Return an empty array if no data found
            return array('max_week_number' => '0', 'max_year_number' => '0000');
        }
	}

	public function updateGasPin($driver_id, $gas_pin){
		$this->db->from("gas_pin");
		$this->db->where("driver_id", $driver_id);
		$this->db->delete("gas_pin");

		$this->db->reset_query();

		$data = array(
			'driver_id' => $driver_id,
			'gas_pin' => $gas_pin
		);
		$status=$this->db->insert("gas_pin", $data);
	}

	public function getGasPin($id){
		$this->db->where('driver_id',$id);
		$query = $this->db->get('gas_pin');
		$data = $query->row_array();

		if(empty($data)){
			return '';
		}else{
			return $data['gas_pin'];
		}
	}


}
