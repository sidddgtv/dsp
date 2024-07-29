<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Document extends Admin_Controller {

    private $error = array();

    public function __construct() {
        parent::__construct();
        $this->load->model('document_model');
        $this->load->model('users/users_model');
        $this->load->model('extra/extra_model');
    }

    public function index() {
        $this->lang->load('document');
        $this->template->set_meta_title($this->lang->line('heading_title'));
        $this->getList();
    }

    public function add() {

        $this->lang->load('document');
        $this->template->set_meta_title($this->lang->line('heading_title'));
        if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->validateForm()) {

            $catid = $this->document_model->addDocument($this->input->post(), $_FILES);

            $this->session->set_flashdata('message', 'Document Saved Successfully.');
            redirect(ADMIN_PATH . '/document');
        }
        $this->getForm();
    }

    public function edit() {


        $this->lang->load('document');
        $this->template->set_meta_title($this->lang->line('heading_title'));

        if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->validateForm()) {
            $id = $this->uri->segment(4);



            $this->document_model->editDocument($id, $this->input->post());

            $this->session->set_flashdata('message', 'Document Updated Successfully.');

            redirect(ADMIN_PATH . '/document');
        }
        $this->getForm();
    }

    public function delete() {
        if ($this->input->post('selected')) {
            $selected = $this->input->post('selected');
        } else {
            $selected = (array) $this->uri->segment(4);
        }
        $this->document_model->deleteDocument($selected);
        $this->session->set_flashdata('message', 'Document deleted Successfully.');
        redirect(ADMIN_PATH . '/document');
    }

    public function sign() {
        if ($this->input->post('selected')) {
            $selected = $this->input->post('selected');
        } else {
            $selected = (array) $this->uri->segment(4);
        }
        /*$documentpdf='storage/TEST_EMPTY.pdf';
        $receipientmail="aditya.nspires@gmail.com";
        $receipientname="Aditya Ghosh";
        $envlope_id=createEnvelopeAndSavePDF($documentpdf,$receipientmail,$receipientname);
        echo $envlope_id;
        exit;*/
        $this->document_model->signDocument($selected);
        $this->session->set_flashdata('message', 'Document signed successfully.');
        redirect(ADMIN_PATH . '/document');
    }

    protected function getList() {

        //$this->template->add_package(array('datatable'), true);

        $data['add'] = admin_url('document/add');
        $data['delete'] = admin_url('document/delete');
        $data['datatable_url'] = admin_url('document/search');

        $data['heading_title'] = $this->lang->line('heading_title');
        $data['text_no_results'] = $this->lang->line('text_no_results');
        $data['text_confirm'] = $this->lang->line('text_confirm');

        if (isset($this->error['warning'])) {
            $data['error'] = $this->error['warning'];
        }

        if ($this->input->post('selected')) {
            $data['selected'] = (array) $this->input->post('selected');
        } else {
            $data['selected'] = array();
        }

        $this->template->view('document', $data);
    }

    public function search() {

        $requestData = $_REQUEST;
        $totalData = $this->document_model->getTotalDocument();
        $totalFiltered = $totalData;

        $filter_data =/* array();*/array(
            'filter_search' => $requestData['search']['value'],
            'order' => $requestData['order'][0]['dir'],
            'sort' => $requestData['order'][0]['column'],
            'start' => $requestData['start'],
            'limit' => $requestData['length']
        );
        $totalFiltered = $this->document_model->getTotalDocument($filter_data);

        $filteredData = $this->document_model->getDocuments($filter_data);

        $datatable = array();
        $count = 1;
        foreach ($filteredData as $result) {
            $action ='<div class="btn-group btn-group-sm pull-right">';
            $action .= '<a class="btn btn-sm btn-dark" title="Edit Document" href="'. admin_url('document/edit/' . $result->id) . '"><i class="la la-edit"></i></a>';
            $action .= '<a class="btn-sm btn btn-danger" title="Delete Document"  href="'. admin_url('document/delete/' . $result->id) . '" onclick="return confirm(\'Are you sure?\') ? true : false;"><i class="las la-trash"></i></a>';
            $action .= '</div>';
            //fetch user name
            $user_name = '<span class="text-danger">Not Assigned</span>';
            if($result->user > 0){
                $user_detail = $this->users_model->getUser($result->user);
                $user_name = $user_detail->name;
            }
            
            //decide btn text
            $btn_text = '';
            if($_SESSION['user_group_id'] == 1){
                //nothing
            }else{
                //user
                if($result->status == 1){
                    //signed
                    $btn_text = '<div class="text-success"><i class="las la-check-circle"></i> Signed</div>';
                }else{
                    //btn
                    //$btn_text = '<a class="btn btn-sm btn-dark" title="Sign Document" href="'. admin_url('document/sign/' . $result->id) . '" onclick="return confirm(\'Are you sure?\') ? true : false;"><i class="las la-marker"></i> Sign</a>';
                    $btn_text = '<a class="btn btn-sm btn-dark" title="Sign Document" href="'. admin_url('document/docusign/' . $result->id) . '" onclick="return confirm(\'Are you sure?\') ? true : false;"><i class="las la-marker"></i> Sign</a>';
                }
            }

            //get template
            /*$this->db->select('t.*');
            $this->db->where('u.id', $_SESSION['a_user_id']);
            $this->db->join('templates t', 't.id = u.template_file');
            $this->db->from('user u');
            $res = $this->db->get()->row_array();*/
            //echo $this->db->last_query();
            
            $datatable[] = array(
                $count++,
                $result->doc_title,
                '<a href="'.base_url('storage/uploads/files/'.$result->uploadfile).'" class="btn btn-danger btn-sm"><i class="las la-file-pdf"></i> Download</a>',
                //'<a href="'.base_url('storage/uploads/files/'.$res['template_file']).'" class="btn btn-danger btn-sm"><i class="las la-file-pdf"></i> Download</a>',
                //$user_name,
                ($_SESSION['user_group_id'] == 1 ? '' : $btn_text)
            );
        }
        $json_data = array(
            "draw" => isset($requestData['draw']) ? intval($requestData['draw']) : 1,
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $datatable
        );

        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($json_data));  // send data as json format
    }

    public function newhire(){
        $data = array();
        if(!empty($_POST)){
            //print_r($_POST);
            $page_data = array(
                "newhire" => 1
            );
    
            $this->db->where("id", $_SESSION['a_user_id']);
            $this->db->update("user", $page_data);
        }
        //get new hire value
        $this->db->where('id', $_SESSION['a_user_id']);
        $this->db->from("user");
        $dt = $this->db->get()->row_array();
        $data['is_read'] = $dt['newhire'];
        $this->template->view('newhire', $data);
    }

    public function extra(){
        $data = array();
        $data['datatable_url'] = '';
        $data['delete'] = '';
        $data['extras'] = $this->extra_model->getExtras();
        $this->template->view('extra', $data);
    }

    public function docusign(){
        $data = array();

        if($this->uri->segment(4) > 0){
            $_SESSION['document_id'] = $this->uri->segment(4);
            //fetch document
            $option_info = $this->document_model->getDocument($this->uri->segment(4));
            $_SESSION['file_path'] = getcwd().'/storage/uploads/files/'.$option_info->uploadfile;
        }
          

        //Array ( [status] => success [event] => signing_complete ) 

        require_once getcwd().'/docusign/ds_config.php';
        require_once getcwd().'/docusign/src/DocuSignController.php';
        $docuSign = new DocuSignController();

        if(!empty($_POST) && array_key_exists('docusign_connect', $_POST)){
            $docuSign->connect();
        }
        if(!empty($_POST) && array_key_exists('docusign_sign', $_POST)){

            $docuSign->signDocument();
        }
        
        
        if(@$_GET['code'] && ( !array_key_exists('authData', $_SESSION) || property_exists($_SESSION['authData'],'error') )){
            $docuSign->callback();
        }

        if(@$_GET['status'] == 'success' && @$_GET['event'] == 'signing_complete'){
            //$docuSign->callback();
            //echo 111;
            redirect(admin_url('document/sign/' . $_SESSION['document_id']));

        }
        
        $this->template->view('docusign', $data);
    }

    protected function getForm() {
        $this->template->add_package(array('ckeditor','tablednd','colorbox','datepicker'),true);

        //printr($_SESSION);
        $_SESSION['isLoggedIn'] = true;

        $data['heading_title'] = $this->lang->line('heading_title');
        $data['text_form'] = $this->uri->segment(4) ? "Document Edit" : "Document Add";
        //$data['text_image'] = $this->lang->line('text_image');
        //$data['text_none'] = $this->lang->line('text_none');
        $data['text_clear'] = $this->lang->line('text_clear');
        $data['cancel'] = admin_url('document');

        if (isset($this->error['warning'])) {
            $data['error'] = $this->error['warning'];
        }

        if ($this->uri->segment(4) && ($this->input->server('REQUEST_METHOD') != 'POST')) {
            $option_info = $this->document_model->getDocument($this->uri->segment(4));
        }
        //printr($category_info);exit;

        if ($this->input->post('doc_title')) {
            $data['doc_title'] = $this->input->post('doc_title');
        } elseif (!empty($option_info)) {
            $data['doc_title'] = $option_info->doc_title;
        } else {
            $data['doc_title'] = '';
        }

        if ($this->input->post('doc_description')) {
            $data['doc_description'] = $this->input->post('doc_description');
        } elseif (!empty($option_info)) {
            $data['doc_description'] = $option_info->doc_description;
        } else {
            $data['doc_description'] = '';
        }

        if ($this->input->post('uploadfile')) {
            $data['uploadfile'] = $this->input->post('uploadfile');
        } elseif (!empty($option_info)) {
            $data['uploadfile'] = $option_info->uploadfile;
        } else {
            $data['uploadfile'] = '';
        }

        if ($this->input->post('user')) {
            $data['user'] = $this->input->post('user');
        } elseif (!empty($option_info)) {
            $data['user'] = $option_info->user;
        } else {
            $data['user'] = '';
        }

        $data['all_users'] = $this->users_model->getUsers();

    


       

        $this->template->view('documentForm', $data);
    }

    protected function validateForm() {
        $rules = array(
            'doc_title' => array(
                'field' => 'doc_title',
                'label' => 'document Name',
                'rules' => 'trim|required|max_length[100]'
            )
        );

        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == TRUE) {
            return true;
        } else {
            $this->error['warning'] = "Warning: Please check the form carefully for errors!";
            return false;
        }
        return !$this->error;
    }
}

/* End of file hmvc.php */
/* Student: ./application/widgets/hmvc/controllers/hmvc.php */