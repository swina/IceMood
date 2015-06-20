<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	
	public function __Construct()
	{
	   	parent::__Construct();
	   	$this->check_isvalidated();
	}	
	public function index()
	{
		if ( !$this->session->userdata("lingua") ){
				$this->load->model('init_model');		
		}
		$data = '';
		$this->viewForm($data);
	}	
	
	private function check_isvalidated(){
        if(! $this->session->userdata('validated')){
            redirect('admin/login');
        }
    }	
		
	private function viewForm($data=''){	
		
		//$this->load->model('Language_model');
		
		
		$this->load->view('admin/dashboard');
		//$this->load->view('admin/dashboard-info');	
		//$this->load->view('admin/header');		
		//$this->load->view('admin/sidebar');		
		//$this->load->view('admin/home', $data);		
		//$this->load->view('admin/footer');				
	}
	
}

?>