<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * AIO ADMIN
 *
 * @author      Mark Price
 * @copyright   Copyright (c) 2012
 * @license     MIT License
 * @link        http://aioadmin.com
 */

class Schedule_model extends MY_Model
{	
   public function __construct(){
		parent::__construct();
	}

	public function addSchedule($data){
		$status=$this->db->insert("schedule", $data);
		//echo $this->db->last_query();die;
		return $this->db->insert_id();
	}

	public function updateSchedule($id, $data){
		$this->db->where("id", $id);
		$status = $this->db->update("schedule", $data); 
		if($status){
				return "success";
		}
	}

	public function noScheduleExists($driver_id, $week, $year, $in_time, $out_time){
		$this->db->where('driver_id', $driver_id);
		$this->db->where('week_number', $week);
		$this->db->where('year_number', $year);
		$this->db->where('scheduled_punch_in_time', $in_time);
		$this->db->where('scheduled_punch_out_time', $out_time);
		$this->db->from('schedule');
		//echo $this->db->last_query();die;
		$count = $this->db->count_all_results();
		if($count == 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function getPunchData($driver_id, $week, $year, $date){

		//select min(punch_in_time), max(punch_out_time) from schedule where driver_id = 22 and week_number = 45 and punch_in_time like '%11-07%';
		$this->db->select('min(scheduled_punch_in_time) as in_time, max(scheduled_punch_out_time) as out_time, schedule_code_id, notes');
		$this->db->where('driver_id', $driver_id);
		$this->db->where('week_number', $week);
		$this->db->where('year_number', $year);
		//$this->db->like('punch_in_time', $date);
		$this->db->where("scheduled_punch_in_time LIKE '%$date%'");
		//$this->db->from('schedule');
		$query = $this->db->get('schedule');
		$User = $query->row();
		//echo $this->db->last_query();die;
		return $User;
	}

	public function getSinglePunchData($driver_id, $date, $week, $year){

		//select min(punch_in_time), max(punch_out_time) from schedule where driver_id = 22 and week_number = 45 and punch_in_time like '%11-07%';
		//$this->db->select('min(punch_in_time) as in_time, max(punch_out_time) as out_time');
		$this->db->where('driver_id', $driver_id);
		$this->db->where('week_number', $week);
		$this->db->where('year_number', $year);
		//$this->db->like('punch_in_time', $date);
		$this->db->where("scheduled_punch_in_time LIKE '%".date('m-d', $date)."%'");
		//$this->db->from('schedule');
		$query = $this->db->get('schedule');
		$data = $query->row();
		//echo $this->db->last_query();
		return $data;
	}

	public function getScheduleStatusCodeforText($status_text){
		$this->db->where("short_code", $status_text);
		$query = $this->db->get('schedule_codes');
		$data = $query->row();
		if(!empty($data)){
			return $data->id;
		}else{
			return 0;
		}
	}

	public function getCodeText($code_id){
		$this->db->where("id", $code_id);
		$query = $this->db->get('schedule_codes');
		$data = $query->row();
		if(!empty($data)){
			return $data->description;
		}else{
			return '';
		}
	}

	public function getShortCodeText($code_id){
		$this->db->where("id", $code_id);
		$query = $this->db->get('schedule_codes');
		$data = $query->row();
		if(!empty($data)){
			return $data->short_code;
		}else{
			return '';
		}
	}

	public function getScheduleCodes(){
		$query = $this->db->get('schedule_codes');
		$data = $query->result();
		return $data;
	}

	public function updateScheduleCode($code_id, $schedule_id, $driver_id, $dt, $week, $year){
		$dt = date("Y-m-d",$_POST['dt']);
		if($schedule_id == 0){
			//add new schedule
			$data = array(
				'driver_id' => $driver_id,
				'week_number' => $week,
				'year_number' => $year,
				'scheduled_punch_in_time' => $dt.' 7:05AM',
				'scheduled_punch_out_time' => $dt.' 5:35PM',
				'schedule_code_id' => $code_id
			);
			$this->addSchedule($data);
		}else{
			//update schedule
			$data = array(
				'schedule_code_id' => $code_id
			);
			$this->updateSchedule($schedule_id, $data);
		}
	}

	public function updateScheduleNote($notes, $schedule_id, $driver_id, $dt, $week, $year){
		$dt = date("Y-m-d",$_POST['dt']);
		if($schedule_id == 0){
			//add new schedule
			$data = array(
				'driver_id' => $driver_id,
				'week_number' => $week,
				'year_number' => $year,
				'scheduled_punch_in_time' => $dt.' 7:05AM',
				'scheduled_punch_out_time' => $dt.' 5:35PM',
				'notes' => $notes
			);
			$this->addSchedule($data);
		}else{
			//update schedule
			$data = array(
				'notes' => $notes
			);
			$this->updateSchedule($schedule_id, $data);
		}
	}

	public function publishSchedule($week, $year){
		$data = array(
			'is_published' => 1
		);
		$this->db->where("week_number", $week);
		$this->db->where("year_number", $year);
		$status = $this->db->update("schedule", $data);
		echo $status;
	}

	public function getScheduledforDay($date){
		$this->db->select('count(id) as total');
		$this->db->where("scheduled_punch_in_time LIKE '%$date%'");
		$this->db->where("schedule_code_id", 1);

		$query = $this->db->get('schedule');
		$data = $query->row();
		if(!empty($data)){
			return $data->total;
		}else{
			return 0;
		}
	}

	public function getSummaryItemforDay($item, $date){
		$this->db->where("summary_title", $item);
		$this->db->where("for_date", $date);

		$query = $this->db->get('schedule_summary');
		$data = $query->row();
		if(!empty($data)){
			return $data->summary_value;
		}else{
			return '';
		}
	}

	public function addScheduleSummary($data){
		$status=$this->db->insert("schedule_summary", $data);
		//echo $this->db->last_query();die;
		return $this->db->insert_id();
	}

	
	

}
