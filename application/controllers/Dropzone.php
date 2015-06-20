<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Dropzone extends CI_Controller {
  
	public function __construct() {
	   parent::__construct();
	   $this->load->helper(array('url','html','form'));
	   //load model for dashboard functions
		$this->load->model('radio_model');
	}
	 
	public function index() {
		$this->template->load('admin/dashboard','admin/dropzone_view');
		//$this->load->view('admin/dropzone_view');
	}
	public function upload() {
		if (!empty($_FILES)) {
			
			$tempFile = $_FILES['file']['tmp_name'];
			$fileName = $_FILES['file']['name'];
			$fileName = str_replace(' ', '_', $fileName); // Replaces all spaces with hyphens.
   			$fileName = preg_replace('/[^A-Za-z0-9\-\.]/', '', $fileName); // Removes special chars.
			
			$targetPath = $this->config->item('mp3_path');
			
			if ( $this->session->userdata ( 'uploadfolder' ) ) {
				$targetPath = $this->session->userdata ( 'uploadfolder' ) .'/';
			} 
			
			$targetFile = $targetPath . $fileName ;
			
			move_uploaded_file($tempFile, $targetFile);
			//$res =$this->radio_model->default_playlist_create();
			//$this->template->set ( 'test' , $res );
		}
	}
	
	
	public function createThumbnail($origin,$path,$name){
		$config['image_library'] = 'gd2';
		$config['source_image']	= $origin;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['new_image'] = $path.'thumbs/'.$name;
		$config['width']	= 200;
		$this->load->library('image_lib',$config);
		$this->image_lib->resize();
	}
	
}
 
/* End of file dropzone.js */
/* Location: ./application/controllers/dropzone.php */