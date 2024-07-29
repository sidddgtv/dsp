<?php (defined('BASEPATH')) OR exit('No direct script access allowed');
/**
 * AIO ADMIN
 *
 * @author      Mark Price
 * @copyright   Copyright (c) 2012
 * @license     MIT License
 * @link        http://aioadmin.com
 */

class Sheet_model extends MY_Model
{	
   public function __construct(){
		parent::__construct();
	}

	public function addSheet($data){
		$status=$this->db->insert("sheet", $data);
		//echo $this->db->last_query();die;
		return $this->db->insert_id();
	}

	public function updateSheet($id, $data){
		$this->db->where("id", $id);
		$status = $this->db->update("sheet", $data); 
		if($status){
				return "success";
		}
	}

	public function noSheetExists($driver_id, $week, $year, $for_date){
		$this->db->where('driver_id', $driver_id);
		$this->db->where('week_number', $week);
		$this->db->where('year_number', $year);
		$this->db->where('for_date', $for_date);
		$this->db->from('sheet');
		//echo $this->db->last_query();die;
		$count = $this->db->count_all_results();
		if($count == 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function getPunchData($driver_id, $week, $year, $date){

		//select min(punch_in_time), max(punch_out_time) from sheet where driver_id = 22 and week_number = 45 and punch_in_time like '%11-07%';
		//$this->db->select('min(sheetd_punch_in_time) as in_time, max(sheetd_punch_out_time) as out_time, sheet_code_id, notes');
		$this->db->where('driver_id', $driver_id);
		$this->db->where('week_number', $week);
		$this->db->where('year_number', $year);
		$this->db->where('for_date', $date);
		//$this->db->from('sheet');
		$query = $this->db->get('sheet');
		$User = $query->row();
		//echo $this->db->last_query();die;
		return $User;
	}

	public function getSinglePunchData($driver_id, $date, $week, $year){

		//select min(punch_in_time), max(punch_out_time) from sheet where driver_id = 22 and week_number = 45 and punch_in_time like '%11-07%';
		//$this->db->select('min(punch_in_time) as in_time, max(punch_out_time) as out_time');
		$this->db->where('driver_id', $driver_id);
		$this->db->where('week_number', $week);
		$this->db->where('year_number', $year);
		$this->db->where('for_date', $date);
		//$this->db->like('punch_in_time', $date);
		//$this->db->from('sheet');
		$query = $this->db->get('sheet');
		$data = $query->row();
		//echo $this->db->last_query();
		return $data;
	}

	public function getSheetStatusCodeforText($status_text){
		$this->db->where("short_code", $status_text);
		$query = $this->db->get('sheet_codes');
		$data = $query->row();
		if(!empty($data)){
			return $data->id;
		}else{
			return 0;
		}
	}

	public function getCodeText($code_id){
		$this->db->where("id", $code_id);
		$query = $this->db->get('sheet_codes');
		$data = $query->row();
		if(!empty($data)){
			return $data->description;
		}else{
			return '';
		}
	}

	public function getShortCodeText($code_id){
		$this->db->where("id", $code_id);
		$query = $this->db->get('sheet_codes');
		$data = $query->row();
		if(!empty($data)){
			return $data->short_code;
		}else{
			return '';
		}
	}

	public function getSheetCodes(){
		$query = $this->db->get('sheet_codes');
		$data = $query->result();
		return $data;
	}

	public function updateSheetCode($code_id, $sheet_id, $driver_id, $dt, $week, $year){
		$dt = date("Y-m-d",$_POST['dt']);
		if($sheet_id == 0){
			//add new sheet
			$data = array(
				'driver_id' => $driver_id,
				'week_number' => $week,
				'year_number' => $year,
				'sheet_code_id' => $code_id
			);
			$this->addSheet($data);
		}else{
			//update sheet
			$data = array(
				'sheet_code_id' => $code_id
			);
			$this->updateSheet($sheet_id, $data);
		}
	}

	public function updateSheetNote($notes, $sheet_id, $driver_id, $dt, $week, $year){
		$dt = date("Y-m-d",$_POST['dt']);
		if($sheet_id == 0){
			//add new sheet
			$data = array(
				'driver_id' => $driver_id,
				'week_number' => $week,
				'year_number' => $year,
				'notes' => $notes
			);
			$this->addSheet($data);
		}else{
			//update sheet
			$data = array(
				'notes' => $notes
			);
			$this->updateSheet($sheet_id, $data);
		}
	}

	public function publishSheet($week, $year){
		$data = array(
			'is_published' => 1
		);
		$this->db->where("week_number", $week);
		$this->db->where("year_number", $year);
		$status = $this->db->update("sheet", $data);
		echo $status;
	}

	
	

}
