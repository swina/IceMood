<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller{
	
	public function __Construct() {
		parent::__Construct();
	}
	
	function index() {
		$this->session->set_userdata ( 'validated' , false );
		redirect ( base_url() );
        //$this->load->view('admin/login', 'admin/login' );
	}
	
}