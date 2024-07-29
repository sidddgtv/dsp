<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');


class Extra_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function addExtra($data, $files) {
        $file_name = time().'.pdf';//$_FILES['uploadfile']['name'];
        $file_tmp = $_FILES['uploadfile']['tmp_name'];
        move_uploaded_file($file_tmp,'storage/uploads/files/'.$file_name);

        $page_data = array(
            "extra_title" => $data['doc_title'],
            "extra_file" => $file_name
        );

        
        $this->db->insert("extra", $page_data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function editExtra($id, $data) {
        $page_data = array(
            "extra_title" => $data['doc_title'],
            //"extra_file" => $data['uploadfile']
        );

        $this->db->where("id", $id);
        $this->db->update("extra", $page_data);
    }

    public function deleteExtra($selected) {
        $this->db->where_in("id",$selected);
        if($this->db->delete("extra")){
            $this->db->where_in("id",$selected);
        }
    }

    public function signExtra($selected){
        $dt = array('status' => 1);
        $this->db->where_in("id", $selected);
        
        $this->db->update("extra", $dt);
    }

    public function getExtras($data = array()) {
        $this->db->select("*");
        $this->db->from("extra");




        if (!empty($data['filter_search'])) {
            $this->db->where("extra_title LIKE '%{$data['filter_search']}%'"
            );
        }
        if (isset($data['sort']) && $data['sort']) {
            $sort = $data['sort'];
        } else {
            $sort = "extra_title";
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
            $this->db->limit((int) $data['limit'], (int) $data['start']);
        }

        $res = $this->db->get()->result();

        return $res;
    }

    public function getTotalExtra($data = array()) {
        $this->db->from("extra");

        if (!empty($data['filter_search'])) {
            $this->db->where("
            extra_title LIKE '%{$data['filter_search']}%'"
            );
        }

        $count = $this->db->count_all_results();
        return $count;
    }

    public function getExtra($id) {
        $this->db->select('*');
        $this->db->from('extra');
        $this->db->where("id", $id);
        $result = $this->db->get()->row();
        return $result;
    }

    

}
