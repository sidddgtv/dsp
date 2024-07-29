<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

//require 'front_module/jobs/models/Jobs_model.php';

class Fleet_model extends CI_Model{	
	public function __construct(){
		parent::__construct();
	}

    public function getFleetDetails($fleet_id, $fleet_history_id){
        //$this->db->select('*,id as user_id');
        $this->db->from('fleet f');
        
        $this->db->where('f.id', $fleet_id);
        if($fleet_history_id > 0){
            $this->db->join('fleet_history fh', 'fh.fleet_id = f.id');//, 'LEFT'
            $this->db->where('fh.id', $fleet_history_id);
            $this->db->order_by('fh.id', 'DESC');
        }
        //$this->db->where('fh.retured_at', NULL);
        
        $query = $this->db->get();
        $result = $query->row_array();
        //echo $this->db->last_query();
        return $result;
    }

    public function issueFleet($driver_id, $fleet_id, $post, $files){
        $data = array();
        if(isset($files['front_side_image']['name'])){
            //$file_name = time().'_1.pdf';
            $file_name = time() . '_1_'.$driver_id.'_' . str_replace(" ", "", $files['front_side_image']['name']);
            $file_tmp = $files['front_side_image']['tmp_name'];
            move_uploaded_file($file_tmp,'storage/uploads/images/'.$file_name);
            $data['front_side_image'] = $file_name;
        }
        $data['front_side_comment'] = $post['front_side_comment'];

        if(isset($files['left_side_image']['name'])){
            //$file_name = time().'_2.pdf';
            $file_name = time() . '_2_'.$driver_id.'_' . str_replace(" ", "", $files['left_side_image']['name']);
            $file_tmp = $files['left_side_image']['tmp_name'];
            move_uploaded_file($file_tmp,'storage/uploads/images/'.$file_name);
            $data['left_side_image'] = $file_name;
        }
        $data['left_side_comment'] = $post['left_side_comment'];

        if(isset($files['back_side_image']['name'])){
            //$file_name = time().'_3.pdf';
            $file_name = time() . '_3_'.$driver_id.'_' . str_replace(" ", "", $files['back_side_image']['name']);
            $file_tmp = $files['back_side_image']['tmp_name'];
            move_uploaded_file($file_tmp,'storage/uploads/images/'.$file_name);
            $data['back_side_image'] = $file_name;
        }
        $data['back_side_comment'] = $post['back_side_comment'];

        if(isset($files['right_side_image']['name'])){
            //$file_name = time().'_4.pdf';
            $file_name = time() . '_4_'.$driver_id.'_' . str_replace(" ", "", $files['right_side_image']['name']);
            $file_tmp = $files['right_side_image']['tmp_name'];
            move_uploaded_file($file_tmp,'storage/uploads/images/'.$file_name);
            $data['right_side_image'] = $file_name;
        }
        $data['right_side_comment'] = $post['right_side_comment'];

        if(isset($files['odometer_image']['name'])){
            //$file_name = time().'_5.pdf';
            $file_name = time() . '_5_'.$driver_id.'_' . str_replace(" ", "", $files['odometer_image']['name']);
            $file_tmp = $files['odometer_image']['tmp_name'];
            move_uploaded_file($file_tmp,'storage/uploads/images/'.$file_name);
            $data['odometer_image'] = $file_name;
        }
        $data['odometer_comment'] = $post['odometer_comment'];

        $data['driver_id'] = $driver_id;
        $data['fleet_id'] = $fleet_id;

        $this->db->insert("fleet_history", $data);

        //$this->db->select('*,id as user_id');
        /*$this->db->from('fleet');
        $this->db->where('id', $fleet_id);
        $query = $this->db->get();
        $result = $query->row_array();
        return $result;*/
    }

    public function returnFleet($driver_id, $fleet_id){
        $dt = new DateTime();
        $query_data = array(
            'retured_at' => $dt->format('Y-m-d H:i:s')
        );

        //$this->db->from('scorecard');
        $this->db->where('driver_id', $driver_id);
        $this->db->where('fleet_id', $fleet_id);
        $this->db->update('fleet_history', $query_data);
    }

    public function getActiveFleetsIssuedtoDriver($driver_id){
        $this->db->select("f.*,fh.*,fh.id as fleet_history_id");
        $this->db->from("fleet f");
		$this->db->join('fleet_history fh', 'fh.fleet_id = f.id');
        $this->db->where('fh.driver_id', $driver_id);
        $this->db->where("fh.retured_at", NULL);

        $res = $this->db->get()->result_array();
        //echo $this->db->last_query();
        //SELECT * FROM fleet WHERE id in 
        //(select GROUP_CONCAT(fleet_id) from fleet_history where driver_id = 2 and retured_at IS NULL;);
        //SELECT * FROM fleet WHERE id in (select GROUP_CONCAT(fleet_id) from fleet_history where driver_id = 2 and retured_at IS NULL)
        return $res;
    }

    public function allIssuedFleet($driver_id){
        $this->db->select("f.*,fh.*,fh.id as fleet_history_id");
        $this->db->from("fleet f");
		$this->db->join('fleet_history fh', 'fh.fleet_id = f.id');
        $this->db->where('fh.driver_id', $driver_id);
        $this->db->where("fh.retured_at IS NOT NULL");
        $res = $this->db->get()->result_array();
        //echo $this->db->last_query();
        return $res;
    }

    

    /*public function acknowledgeScorecard($driver_id, $scorecard_id){
        $query_data = array(
            'is_acknowledged' => 1
        );

        //$this->db->from('scorecard');
        $this->db->where('driver_id', $driver_id);
        $this->db->where('id', $scorecard_id);
        $this->db->update('scorecard', $query_data);
    }*/

    

    
    
}