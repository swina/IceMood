<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller{
	
	function index($msg='') {
		$data['msg'] = $msg;
        $this->load->view('admin/login',$data);
	}
	
    public function process(){
        // Load the model
        //$this->load->model('login_model');
        $this->load->model('admin/admin_model');
        // Validate the user can login
        $result = $this->admin_model->validate();
        // Now we verify the result
        if(! $result){
            // If user did not validate, then show them login page again
			$msg = '<font color=red>Invalid username and/or password.</font><br />';
            $this->index($msg);
        }else{
			//echo "Loading...";
            // If user did validate, 
            // Send them to members area
            redirect(base_url().'admin/home');
        }        
    }    
}