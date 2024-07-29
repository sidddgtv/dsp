<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

//require 'front_module/jobs/models/Jobs_model.php';

class Document_model extends CI_Model{	
	public function __construct(){
		parent::__construct();
	}

    public function getDocuments($driver_id){
        //$this->db->select('id as user_id');
        $this->db->from('document');
        $this->db->where('user', $driver_id);
        return $this->db->get()->result_array();
    }

    public function getDocumentsbyType($driver_id, $doc_type, $is_approved){
        $this->db->select('*, CONCAT("'.base_url('storage/uploads/files/').'", uploadfile) AS full_path');
        //$fleet_data['front_side_image'] = base_url('storage/uploads/images/'.$fleet_data['front_side_image']);

        $this->db->from('document');
        $this->db->where('user', $driver_id);
        $this->db->where('doc_type', $doc_type);
        $this->db->where('is_approved', $is_approved);
        return $this->db->get()->result_array();
    }

    public function acknowledgeDocument($driver_id, $document_id){
        $query_data = array(
            'is_approved' => 1,
            'status' => 1
        );

        //$this->db->from('scorecard');
        $this->db->where('user', $driver_id);
        $this->db->where('id', $document_id);
        $this->db->update('document', $query_data);
    }

    

    
    
}