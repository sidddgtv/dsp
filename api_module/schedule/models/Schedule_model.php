<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

//require 'front_module/jobs/models/Jobs_model.php';

class Schedule_model extends CI_Model{	
	public function __construct(){
		parent::__construct();
	}

    public function getScheduleforMonth($driver_id, $month, $year){
        //$this->db->select('*');
        $this->db->from('schedule');
        $this->db->where('driver_id', $driver_id);
        $this->db->where('punch_in_time like "'.$year.'-'.$month.'%"');
        $this->db->order_by('punch_in_time', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getScheduleforDate($driver_id, $start_date, $end_date){
        //$this->db->select('*');
        $this->db->from('schedule');
        $this->db->where('driver_id', $driver_id);
        $this->db->where('punch_in_time >= "'.$start_date.'%"');
        $this->db->where('punch_in_time <= "'.$end_date.'%"');
        $this->db->order_by('punch_in_time', 'ASC');
        return $this->db->get()->result_array();
    }

    

}