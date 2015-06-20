<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller{
	
	public function index() {
		//$loginUrl	=	base_url()."admin/login";
		//redirect($loginUrl);
		//echo 'TEST';
		$this->load->view('admin/login');
	}   			
}