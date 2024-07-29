<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

//require 'front_module/jobs/models/Jobs_model.php';

class Users_model extends CI_Model{	
	public function __construct(){
		parent::__construct();
	}

    public function getUser($id){
        //$this->db->select('*,id as user_id');
        $this->db->from('user');
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }


	public function loginUser($email_id, $password){
        //$this->db->select('*,id as user_id');
        $this->db->from('user');
        $this->db->where('email', $email_id);
        $this->db->where('password', md5($password));
        $this->db->where('status', 1);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;
    }

    public function emailAddressExists($email_id){
        $this->db->select('id as user_id');
        $this->db->from('user');
        $this->db->where('email', $email_id);
        return $this->db->count_all_results();
    }

    public function registerUser($data, $files){
        //$return = array();

        if (!filter_var(trim($data['email_id']), FILTER_VALIDATE_EMAIL)) {
            //$return['status'] = 0;
            //$return['message'] = "Invalid Email ID format.";
            return false;
        }

        /*$return = 0;
        if(!empty($data['email_id'])){
            $return = $this->emailAddressExists($data['email_id']);
        }

        if($return){
            $res['error'] = 1;
            $res['message'] = '<div class="text-danger"><i class="las la-exclamation-triangle"></i> Account with this Email address already exists</div>';
        }*/

        $driver_image = '';

        if ((isset($files['image']['name'])) && ($files['image']['name'] !== '')){
            $driver_image = time() . str_replace(' ', '_', $files['image']['name']);
            move_uploaded_file($files['image']['tmp_name'], 'storage/uploads/images/' . $driver_image);

            //$query_data['image'] = $driver_image;
        }

        $query_data = array(
            'user_group_id' => 2,
            'name' => trim($data['name']),
            'password' => md5(trim($_POST['password'])),
            'email' => trim($_POST['email_id']),
            'image' => $driver_image,
            /*'phone' => trim($_POST['phone_no']),
            'dl_file' => $dl_file,
            'ss_file' => $ss_file,
            'id_file' => $id_file,
            'vp_file' => $vp_file,
            'vr_file' => $vr_file*/
        );

        $this->db->insert('user', $query_data);
        $id = $this->db->insert_id();

        return TRUE;
    }

    public function forgotPassword($email_id){
        $this->db->select('id as user_id');
        $this->db->from('user');
        $this->db->where('email', $email_id);
        if($this->db->count_all_results()){
            //send email
            return TRUE;
        }else{
            return FALSE;
        }
    }

    
    public function editProfile($data, $driver_id, $files){

        $query_data = array(
            'name' => trim($data['name'])
        );

        if(array_key_exists('password', $data) && $data['password'] != NULL && strlen($data['password']) > 0){
            $query_data['password'] = md5($data['password']);
            $query_data['show_password'] = $data['password'];
        }

        if ((isset($files['image']['name'])) && ($files['image']['name'] !== '')){
            $driver_image = time() . str_replace(' ', '_', $files['image']['name']);
            move_uploaded_file($files['image']['tmp_name'], 'storage/uploads/images/' . $driver_image);

            //$query_data['image'] = $driver_image;
            $query_data['image'] = $driver_image;
        }

        

        $this->db->where('id', $driver_id);
        $this->db->update('user', $query_data);

        return TRUE;
    }

    public function getScorecard($driver_id, $week, $year){
        //$this->db->select('id as user_id');
        $this->db->from('scorecard');
        $this->db->where('driver_id', $driver_id);
        $this->db->where('week_number', $week);
        $this->db->where('year_number', $year);
        return $this->db->get()->row_array();
    }

    public function acknowledgeScorecard($driver_id, $scorecard_id){
        $query_data = array(
            'is_acknowledged' => 1
        );

        //$this->db->from('scorecard');
        $this->db->where('driver_id', $driver_id);
        $this->db->where('id', $scorecard_id);
        $this->db->update('scorecard', $query_data);
    }

    public function replyChat($from_id, $message){
		$chat_data = array(
			"from_id"=>$from_id,
			"to_id"=>1,
			"message_body"=>$message
		);

		$this->db->insert("messages", $chat_data);
	}

    public function getMessages($from_id, $to_id){
		$this->db->select('*');
		$this->db->where(' (from_id = '.$from_id.' AND to_id = '.$to_id.') OR (from_id = '.$to_id.' AND to_id = '.$from_id.') ');
		$this->db->order_by('added_on' , 'ASC');
		$query = $this->db->get('messages');
		$Page = $query->result();
		return $Page;
	}

    public function overallFICORate($week_number, $year_number){
		$this->db->select("avg(fico) as rate");
		$this->db->where("week_number", $week_number);
		$this->db->where("year_number", $year_number);
		$res = $this->db->get('scorecard')->row();
		//echo $this->db->last_query();
		return $res->rate;
	}

    public function getScorecardbyID($id){
		$this->db->from("scorecard");
		$this->db->where("id", $id);
		$res = $this->db->get()->row_array();
		//echo $this->db->last_query();
		return $res;	
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

			//echo in_array("1", $threshold_condition) && in_array("3", $threshold_condition);
			
			//die;
			//create logic
			if(in_array("1", $threshold_condition) && in_array("3", $threshold_condition)){
				$tmp_val = floatval($scorecard_data[$key[$b->bonus_type_id]]);
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
				$tmp_val = floatval($scorecard_data[$key[$b->bonus_type_id]]);
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
				if($key[$b->bonus_type_id] == 'cdf' || $key[$b->bonus_type_id] == 'swc_cc'){
					$tmp_val *= 100;
				}
				
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && $tmp_val == floatval($b->threshold_value) && !empty($scorecard_data[$key[$b->bonus_type_id]])) {
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
		

		// Check if all required texts are in the array
		if ($this->allTextsAvailable($array, $required_texts)) {
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

	public function checkBonusAmount_OLD($scorecard_id){
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

			//echo in_array("1", $threshold_condition) && in_array("3", $threshold_condition);
			
			//die;
			//create logic
			if(in_array("1", $threshold_condition) && in_array("3", $threshold_condition)){
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && floatval($scorecard_data[$key[$b->bonus_type_id]]) >= floatval($b->threshold_value) && !empty($scorecard_data[$key[$b->bonus_type_id]])) {
					//$budget = $budget + $b->amount;
					//$tier = 1;
					//$breakdown .= '<tr><td>1'.$key_printable_text.'</td><td>>=</td><td>$'.$b->amount.'</td><td>1</td></tr>';
					$final_bonus[$b->bonus_type_id]['amount'] = $b->amount;
					$final_bonus[$b->bonus_type_id]['tier'] = $b->id;//1
					$final_bonus[$b->bonus_type_id]['breakdown'] = '<tr><td>'.$key_printable_text.'</td><td>>=</td><td>$'.$b->amount.'</td><td>'.$b->id.'</td></tr>';
				}
			}else if(in_array("2", $threshold_condition) && in_array("3", $threshold_condition)){
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && floatval($scorecard_data[$key[$b->bonus_type_id]]) <= floatval($b->threshold_value) && !empty($scorecard_data[$key[$b->bonus_type_id]])) {
					//$budget = $budget + $b->amount;
					//$tier = 2;
					//$breakdown .= '<tr><td>2'.$key_printable_text.'</td><td><=</td><td>$'.$b->amount.'</td><td>2</td></tr>';
					$final_bonus[$b->bonus_type_id]['amount'] = $b->amount;
					$final_bonus[$b->bonus_type_id]['tier'] = $b->id;//2;
					$final_bonus[$b->bonus_type_id]['breakdown'] = '<tr><td>'.$key_printable_text.'</td><td><=</td><td>$'.$b->amount.'</td><td>'.$b->id.'</td></tr>';
				}
			}else if(in_array("1", $threshold_condition)){
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && floatval($scorecard_data[$key[$b->bonus_type_id]]) > floatval($b->threshold_value) && !empty($scorecard_data[$key[$b->bonus_type_id]])) {
					//$budget = $budget + $b->amount;
					//$tier = 1;
					//$breakdown .= '<tr><td>3'.$key_printable_text.'</td><td>></td><td>$'.$b->amount.'</td><td>1</td></tr>';
					$final_bonus[$b->bonus_type_id]['amount'] = $b->amount;
					$final_bonus[$b->bonus_type_id]['tier'] = $b->id;//1;
					$final_bonus[$b->bonus_type_id]['breakdown'] = '<tr><td>'.$key_printable_text.'</td><td>></td><td>$'.$b->amount.'</td><td>'.$b->id.'</td></tr>';
				}
			}else if(in_array("2", $threshold_condition)){
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && floatval($scorecard_data[$key[$b->bonus_type_id]]) < floatval($b->threshold_value) && !empty($scorecard_data[$key[$b->bonus_type_id]])) {
					//$budget = $budget + $b->amount;
					//$tier = 2;
					//$breakdown .= '<tr><td>4'.$key_printable_text.'</td><td><</td><td>$'.$b->amount.'</td><td>2</td></tr>';
					$final_bonus[$b->bonus_type_id]['amount'] = $b->amount;
					$final_bonus[$b->bonus_type_id]['tier'] = $b->id;//2;
					$final_bonus[$b->bonus_type_id]['breakdown'] = '<tr><td>'.$key_printable_text.'</td><td><</td><td>$'.$b->amount.'</td><td>'.$b->id.'</td></tr>';
				}
			}else if(in_array("3", $threshold_condition)){
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && floatval($scorecard_data[$key[$b->bonus_type_id]]) == floatval($b->threshold_value) && !empty($scorecard_data[$key[$b->bonus_type_id]])) {
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

		return array(
			'bonus' => $budget,
			'tier' => $tier,
			'breakdown' => $breakdown
		);
	}

	public function checkBonusAmountold($scorecard_id){
		$scorecard_data = $this->getScorecardbyID($scorecard_id);
		$bonus_data = $this->bonusConditions();

		$budget = 0;
		$tier = 0;

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

		foreach($bonus_data as $b){
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

			//echo in_array("1", $threshold_condition) && in_array("3", $threshold_condition);
			
			//die;
			//create logic
			if(in_array("1", $threshold_condition) && in_array("3", $threshold_condition)){
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && floatval($scorecard_data[$key[$b->bonus_type_id]]) >= floatval($b->threshold_value)) {				
					$budget = $budget + $b->amount;
					$tier = 1;
				}
			}else if(in_array("2", $threshold_condition) && in_array("3", $threshold_condition)){
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && floatval($scorecard_data[$key[$b->bonus_type_id]]) <= floatval($b->threshold_value)) {				
					$budget = $budget + $b->amount;
					$tier = 2;
				}
			}else if(in_array("1", $threshold_condition)){
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && floatval($scorecard_data[$key[$b->bonus_type_id]]) > floatval($b->threshold_value)) {				
					$budget = $budget + $b->amount;
					$tier = 1;
				}
			}else if(in_array("2", $threshold_condition)){
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && floatval($scorecard_data[$key[$b->bonus_type_id]]) < floatval($b->threshold_value)) {				
					$budget = $budget + $b->amount;
					$tier = 2;
				}
			}else if(in_array("3", $threshold_condition)){
				if(isset($key[$b->bonus_type_id]) && isset($scorecard_data[$key[$b->bonus_type_id]]) && floatval($scorecard_data[$key[$b->bonus_type_id]]) == floatval($b->threshold_value)) {				
					$budget = $budget + $b->amount;
					$tier = 3;
				}
			}
			
		}

		return array(
			'bonus' => $budget,
			'tier' => $tier
		);
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

	public function getGasPin($id){
		$this->db->where('driver_id',$id);
		$query = $this->db->get('gas_pin');
		$data = $query->row_array();

		if(empty($data)){
			return '-';
		}else{
			return $data['gas_pin'];
		}
	}

    
    
}