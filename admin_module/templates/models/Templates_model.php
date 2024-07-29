<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');


class Templates_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function addTemplates($data, $files) {
        $file_name = time().'.pdf';//$_FILES['uploadfile']['name'];
        $file_tmp = $_FILES['uploadfile']['tmp_name'];
        move_uploaded_file($file_tmp,'storage/uploads/files/'.$file_name);

        $page_data = array(
            "template_title" => $data['doc_title'],
            "template_file" => $file_name
        );

        
        $this->db->insert("templates", $page_data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function editTemplates($id, $data) {
        $page_data = array(
            "template_title" => $data['doc_title'],
            //"template_file" => $data['uploadfile']
        );

        $this->db->where("id", $id);
        $this->db->update("templates", $page_data);
    }

    public function deleteTemplates($selected) {
        $this->db->where_in("id",$selected);
        if($this->db->delete("templates")){
            $this->db->where_in("id",$selected);
        }
    }

    public function signTemplates($selected){
        $dt = array('status' => 1);
        $this->db->where_in("id", $selected);
        
        $this->db->update("templates", $dt);
    }

    public function getTemplatess($data = array()) {
        $this->db->select("*");
        $this->db->from("templates");

        
        if($_SESSION['user_group_id'] == 2){
            $this->db->where("user",$_SESSION['a_user_id']);
            //$this->db->where("is_approved",1);
        }
        else{
            //all doc for admin
        }



        if (!empty($data['filter_search'])) {
            $this->db->where("template_title LIKE '%{$data['filter_search']}%'"
            );
        }
        if (isset($data['sort']) && $data['sort']) {
            $sort = $data['sort'];
        } else {
            $sort = "template_title";
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

    public function getTotalTemplates($data = array()) {
        $this->db->from("templates");

        if (!empty($data['filter_search'])) {
            $this->db->where("
            template_title LIKE '%{$data['filter_search']}%'"
            );
        }

        if($_SESSION['user_group_id'] == 2){
            $this->db->where("user",$_SESSION['a_user_id']);
            //$this->db->where("is_approved",1);
        }
        else{
            //all doc for admin
        }

        $count = $this->db->count_all_results();
        return $count;
    }

    public function getTemplates($id) {
        $this->db->select('*');
        $this->db->from('templates');
        $this->db->where("id", $id);
        $result = $this->db->get()->row();
        return $result;
    }

    

}
