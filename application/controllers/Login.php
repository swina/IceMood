<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller{
	
	public function __Construct() {
		parent::__Construct();
	}
	
	function index($msg='') {
		if ( $this->session->userdata ( 'validated' ) ){
			redirect ( 'dashboard' );
		} else {
			$this->load->view('admin/login','admin/login');
		}
	}
	
	public function validate(){
        // Load the model
        //$this->load->model('login_model');
        $this->load->model('admin_model');
        // Validate the user can login
        $result = $this->admin_model->validate();
		//echo "Login: ".$result;
        // Now we verify the result
		/*
        if( $result != '1'){
            // If user did not validate, then show them login page again
			$msg = '<font color="red">Invalid username and/or password.</font><br />';
            $this->index ( $msg );
        }else{
            // If user did validate, 
            // Send them to dashboard
			$this->index ( );
			
        } 
		*/
		
    }   	
}