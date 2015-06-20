<?php

//this controller manage all javascript ajax requests from admin dashboard
// variables has to be passed as POST value
// example to put in javascriot
//

// $.post( _base_url_ /admin/ajax/function_name',
//      			{ 'parameter1 name': parameter1_value , other parameters },
//
//	      		// when the Web server responds to the request
//    	  		function(result) {
//	  				do something here ...
//	 			}
//			);
//

class Ajax extends CI_Controller {

	public function index()
	{
		//get the function to be called
		$ajaxf = $this->uri->segment(3);
		
	}
	
	public function autodj(){
		
		$flag = $this->input->post('switch');
		$pid = $this->input->Post('pid');
		if ( !$flag ) {
			//$cmd = '/usr/bin/sudo -u root kill -KILL '.$radioPID;
			//$res = shell_exec ( $cmd );
			return 'Radio is off';
		}
	} 