<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Check extends CI_Controller {

	public function __Construct() {
		
		parent::__Construct();
		$this->load->model ( 'radio_model' );
		$this->load->model ( 'mp3_model' );	
	}
	
	public function index(){
		$icecast_pid = exec ( $this->config->item ( 'sudo' ) . ' pidof icecast');
		$icegen_pid = exec ( $this->config->item ( 'sudo' ) . ' pidof icegenerator');
		if ( $icecast_pid ) {
			if ( !$icegen_pid ){
				$cmd = $this->config->item ( 'sudo' ).' '.$this->config->item ( 'icegen_path' ).' -f '.$this->config->item ( 'icegen_cfg' );
				$res = shell_exec ( $cmd );	
				$msg = "AutoDJ was off. Restarted!";
				mail ( $this->config->item ( 'icemood_email' ) , $this->config->item ( 'icegen_name' ) . " AutoDJ Restarted" , $msg );
			} else {
				echo "OK";
			}
		} else {
			$cmd = $this->config->item ( 'sudo' ).' '.$this->config->item ('icecast_path').' -c '.$this->config->item('icecast_xml'). ' -b 2>&1 & echo $!';
			$log = $this->config->item ( 'icecast_log' );
			$res = shell_exec( $cmd );
			
			$cmd = $this->config->item ( 'sudo' ).' '.$this->config->item ( 'icegen_path' ).' -f '.$this->config->item ( 'icegen_cfg' );
			$res = shell_exec ( $cmd );	
			
			$msg = "Icecast streaming server was off. Restarted with AutoDJ features!";
				
			mail ( $this->config->item ( 'icemood_email' ) , $this->config->item ( 'icegen_name' ) . " Icecast and AUTODJ Restarted" , $msg );
		}
		
		//$data = $this->mp3_model->mp3_tag_read ( '/home/admin/public_html/igniter/audio/mp3/Indie/Elsiane/Elsiane - Mechanics of Emotion/Elsiane - Mechanics of Emotion - 09 Time for Us.mp3');
		//print_r ( $data );
	}
	
	
}
