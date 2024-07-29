<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Extra extends Admin_Controller {

    private $error = array();

    public function __construct() {
        parent::__construct();
        $this->load->model('extra_model');
        $this->load->model('users/users_model');
    }

    public function index() {
        $this->lang->load('extra');
        $this->template->set_meta_title($this->lang->line('heading_title'));
        $this->getList();
    }

    public function add() {

        $this->lang->load('extra');
        $this->template->set_meta_title($this->lang->line('heading_title'));
        if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->validateForm()) {

            $catid = $this->extra_model->addExtra($this->input->post(), $_FILES);

            $this->session->set_flashdata('message', 'Extra Saved Successfully.');
            redirect(ADMIN_PATH . '/extra');
        }
        $this->getForm();
    }

    public function edit() {


        $this->lang->load('extra');
        $this->template->set_meta_title($this->lang->line('heading_title'));

        if ($this->input->server('REQUEST_METHOD') === 'POST' && $this->validateForm()) {
            $id = $this->uri->segment(4);



            $this->extra_model->editExtra($id, $this->input->post());

            $this->session->set_flashdata('message', 'Extra Updated Successfully.');

            redirect(ADMIN_PATH . '/extra');
        }
        $this->getForm();
    }

    public function delete() {
        if ($this->input->post('selected')) {
            $selected = $this->input->post('selected');
        } else {
            $selected = (array) $this->uri->segment(4);
        }
        $this->extra_model->deleteExtra($selected);
        $this->session->set_flashdata('message', 'Extra deleted Successfully.');
        redirect(ADMIN_PATH . '/extra');
    }

    public function sign() {
        if ($this->input->post('selected')) {
            $selected = $this->input->post('selected');
        } else {
            $selected = (array) $this->uri->segment(4);
        }
        $this->extra_model->signExtra($selected);
        $this->session->set_flashdata('message', 'Extra signed successfully.');
        redirect(ADMIN_PATH . '/extra');
    }

    protected function getList() {

        //$this->template->add_package(array('datatable'), true);

        $data['add'] = admin_url('extra/add');
        $data['delete'] = admin_url('extra/delete');
        $data['datatable_url'] = admin_url('extra/search');

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

        $this->template->view('extra', $data);
    }

    public function search() {

        $requestData = $_REQUEST;
        $totalData = $this->extra_model->getTotalExtra();
        $totalFiltered = $totalData;

        $filter_data = array(
            'filter_search' => $requestData['search']['value'],
            'order' => $requestData['order'][0]['dir'],
            'sort' => $requestData['order'][0]['column'],
            'start' => $requestData['start'],
            'limit' => $requestData['length']
        );
        $totalFiltered = $this->extra_model->getTotalExtra($filter_data);

        $filteredData = $this->extra_model->getExtras($filter_data);

        $datatable = array();
        $count = 1;
        foreach ($filteredData as $result) {
            $action ='<div class="btn-group btn-group-sm pull-right">';
            //$action .= '<a class="btn btn-sm btn-dark" title="Edit Extra" href="'. admin_url('extra/edit/' . $result->id) . '"><i class="la la-edit"></i></a>';
            $action .= '<a class="btn-sm btn btn-danger" title="Delete Extra"  href="'. admin_url('extra/delete/' . $result->id) . '" onclick="return confirm(\'Are you sure?\') ? true : false;"><i class="las la-trash"></i></a>';
            $action .= '</div>';
            
            
            $datatable[] = array(
                $count++,
                $result->extra_title,
                '<a href="'.base_url('storage/uploads/files/'.$result->extra_file).'" class="btn btn-danger btn-sm"><i class="las la-file-pdf"></i> Download</a>',
                $action
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

    protected function getForm() {
        $this->template->add_package(array('ckeditor','colorbox','datepicker'),true);

        //printr($_SESSION);
        $_SESSION['isLoggedIn'] = true;

        $data['heading_title'] = $this->lang->line('heading_title');
        $data['text_form'] = $this->uri->segment(4) ? "Extra Edit" : "Extra Add";
        //$data['text_image'] = $this->lang->line('text_image');
        //$data['text_none'] = $this->lang->line('text_none');
        $data['text_clear'] = $this->lang->line('text_clear');
        $data['cancel'] = admin_url('extra');

        if (isset($this->error['warning'])) {
            $data['error'] = $this->error['warning'];
        }

        if ($this->uri->segment(4) && ($this->input->server('REQUEST_METHOD') != 'POST')) {
            $option_info = $this->extra_model->getExtra($this->uri->segment(4));
        }
        //printr($category_info);exit;

        if ($this->input->post('doc_title')) {
            $data['doc_title'] = $this->input->post('doc_title');
        } elseif (!empty($option_info)) {
            $data['doc_title'] = $option_info->doc_title;
        } else {
            $data['doc_title'] = '';
        }

        if ($this->input->post('uploadfile')) {
            $data['uploadfile'] = $this->input->post('uploadfile');
        } elseif (!empty($option_info)) {
            $data['uploadfile'] = $option_info->uploadfile;
        } else {
            $data['uploadfile'] = '';
        }


        $this->template->view('extraForm', $data);
    }

    protected function validateForm() {
        $rules = array(
            'doc_title' => array(
                'field' => 'doc_title',
                'label' => 'extra Name',
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