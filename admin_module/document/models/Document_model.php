<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');


class Document_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function addDocument($data, $files) {
        $page_data = array(
            "doc_title" => $data['doc_title'],
            "doc_description" => $data['doc_description'],
            "uploadfile" => $uploadfile,
            "user" => $data['user']
        );

        
        $this->db->insert("document", $page_data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function editDocument($id, $data) {
        $page_data = array(
            "doc_title" => $data['doc_title'],
            "doc_description" => $data['doc_description'],
            "uploadfile" => $data['uploadfile'],
            "user" => $data['user']
        );

        $this->db->where("id", $id);
        $this->db->update("document", $page_data);
    }

    public function deleteDocument($selected) {
        $this->db->where_in("id",$selected);
        if($this->db->delete("document")){
            $this->db->where_in("id",$selected);
        }
    }

    public function signDocument($selected){
        $dt  = new DateTime();
        $dt = array('status' => 1, 'signed_on' => $dt->format('Y-m-d H:i:s'));
        $this->db->where_in("id", $selected);
        
        $this->db->update("document", $dt);
    }

    public function getDocuments($data = array()) {
        $this->db->select("*");
        $this->db->from("document");

        
        if($_SESSION['user_group_id'] == 2){
            $this->db->where("user",$_SESSION['a_user_id']);
            $this->db->where("is_approved",1);
        }
        else{
            //all doc for admin
        }



        if (!empty($data['filter_search'])) {
            $this->db->where("doc_title LIKE '%{$data['filter_search']}%'"
            );
        }
        if (isset($data['sort']) && $data['sort']) {
            $sort = $data['sort'];
        } else {
            $sort = "doc_title";
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

    public function getTotalDocument($data = array()) {
        $this->db->from("document");

        if (!empty($data['filter_search'])) {
            $this->db->where("
				doc_title LIKE '%{$data['filter_search']}%'"
            );
        }

        if($_SESSION['user_group_id'] == 2){
            $this->db->where("user",$_SESSION['a_user_id']);
            $this->db->where("is_approved",1);
        }
        else{
            //all doc for admin
        }

        $count = $this->db->count_all_results();
        return $count;
    }

    public function getDocument($id) {
        $this->db->select('*');
        $this->db->from('document');
        $this->db->where("id", $id);
        $result = $this->db->get()->row();
        return $result;
    }

    

}
