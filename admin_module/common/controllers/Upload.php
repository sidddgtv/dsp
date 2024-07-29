<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Upload extends Admin_Controller {
	private $error = array();
	
	function __construct(){
      
		parent::__construct();
		$this->load->model('kcfinder_model');
	}
	public function index(){
		
		$data=array();
		$this->template->view('common/error',$data);
	}
	
	public function bulkuploader() {
		if($this->input->method(1)=='POST'){
			
			$this->uploadr();
			return;
		}
		$this->load->view('bulkuploader');
	}
	
	protected function uploadr() {
		$json = array();
		
	    $upload_url = site_url('storage/uploads/images/');
		//echo $upload_url;
		$default = [
			'allowed_types' => 'gif|jpg|png|jpeg',
			//'allowed_types' => '*',
			'max_size'      => '',
			'max_width'     => '',
			'max_height'    => '',
			//'upload_path'   => './uploads/user/',
			'upload_path'   => DIR_UPLOAD.'images/',
			'required'      => false,
			'encrypt_name'      => false,
		];

		$this->load->library('upload', $default);

		
		
		if ( ! $this->upload->do_upload('files')) {
            $json['error'] = $this->upload->display_errors();
        } else {
			
            $json['success'] = 'File uploaded successfully.';
            //$json['file_info'] = $this->upload->data();
			$imagesize = getimagesize(UPLOAD_PATH.$this->upload->data('file_name'));
			$file = UPLOAD_PATH.$this->upload->data('file_name');
            $json['file'] = resize('/images/'.$this->upload->data('file_name'),500,500);
            $json['file_url'] = site_url(UPLOAD_URL.$this->upload->data('file_name'));
            $json['file_name'] = UPLOAD_IMAGE_PATH.$this->upload->data('file_name');

            //add to db -rakesh 8sept2018
            $stat = stat($file);
            if ($stat === false) {  return; }
            $name = basename($file);
            $filepath = "../../../storage/uploads/".$json['file_name'];
            $data = [
				'dir' => 'images',
				'filename' => stripcslashes($name),
				'filepath' => trim($filepath),
				'date_added' => $stat['ctime'],
				'date_modified' => $stat['mtime'],
			];

			$this->kcfinder_model->save(NULL,$data);
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($json));
	}
}
/* End of file hmvc.php */
/* Location: ./application/widgets/hmvc/controllers/hmvc.php */