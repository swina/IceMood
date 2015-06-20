<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Autodj extends CI_Controller {

	public function __Construct() {
		
		parent::__Construct();
		
		$this->template->set('menu','autodj');
		
		//load model for dashboard functions
		$this->load->model('radio_model');
		//check if icecast is installed
		$icecast = $this->radio_model->whereis_icecast();
		$this->template->set ( 'icecast_is' , '<span class="badge badge-important">Icecast Path</span>' );
		$this->template->set ( 'icegenerator_is' , '<span class="badge badge-important">Icegenerator Path</span>' );
		$this->template->set ( 'icecast_alert' , '<div class="alert alert-error alert-block">
										<a class="close" data-dismiss="alert" href="#">׼/a>
										<h4 class="alert-heading">Icecast not found!</h4>
										System didn\'t find Icecast installation. Icecast is required in order to run settings
									</div>' );
		$this->template->set ( 'icegenerator_alert' , '<div class="alert alert-error alert-block">
										<a class="close" data-dismiss="alert" href="#">׼/a>
										<h4 class="alert-heading">Icegenerator not found!</h4>
										System didn\'t find Icegenerator installation. Icegenerator is required in order to run settings
									</div>' );
		if ( $this->session->userdata ( 'icecast' ) ){
			$this->template->set ( 'icecast_alert' , '' );
			$this->template->set ( 'icecast_is' , '<span class="badge badge-success">Icecast Path</span>' );
			if ( $this->session->userdata ( 'icegenerator' ) ){
				$this->template->set ( 'icegenerator_alert' , '' );
				$this->template->set ( 'icegenerator_is' , '<span class="badge badge-success">Icegenerator Path</span>' );
			}
		}
		
		//check if icecast is running
		$icecast = $this->radio_model->icecast_status();
		$icecastPID = $this->radio_model->icecast_PID();
		$server_status = '<span class="badge badge-important">Off</span>';	
		//if icecast is running
		if ( !empty ( $icecast ) ){
			$server_status = '<span class="badge badge-success">On</span>';
		}
		$this->template->set ( 'server_status' , $server_status );	
		
		$playlist = $this->radio_model->audio_storage();
		$this->template->set ( 'audio_storage' , $playlist['songs'] );	
		$this->template->set ( 'nr_of_songs' , $playlist['nr'] );	
		
		$size = $this->radio_model->storage();
		$perc = $size / 50000;
		$this->template->set ( 'storage_size' , number_format ( $size/1000 ,2 ) . ' MB of 5 GB ' . number_format ( $perc , 2 ) .'% ');
		$this->template->set ( 'storage_perc' , number_format ( $perc , 0 ) );
		
		//last played songs
		$lastPlayedSongs = $this->radio_model->last_played();
		$this->template->set ( 'played' , $lastPlayedSongs['played'] ); 
		$this->template->set ( 'saved_info' , '' );
	}
	
	public function index(){
		$timezones = DateTimeZone::listIdentifiers();
		$options = '<select name="icegen_timezone"><option value="">....</option>';
		//for ( $i = 0 ; $i < count ( $timezone_identifiers ) ; $i++ ){
		foreach ( $timezones as $tz  ){
			if ( $this->config->item ( 'icegen_timezone' ) == $tz ){
				$options = $options . '<option value="' . $tz . '" selected>' . $tz . '</option>';
			} else {
				$options = $options . '<option value="' . $tz . '">' . $tz . '</option>';
			}
			
		}
		$options = $options.'</select>';
		echo ( $options ); 
		$this->template->set ( 'timezones' , $options );
		$this->template->load ( 'admin/autodj' , 'admin/autodj' );
		//print_r ( $this->session->userdata );
	}
	
	
	public function saved(){
		
		$this->template->set ( 'saved_info' , '<div class="alert alert-success alert-block">
										<a class="close" data-dismiss="alert" href="#">׼/a>
										<h5 class="alert-heading">Saved successfully!</h5>
									</div>' );
		$this->template->load ( 'admin/autodj' , 'admin/autodj' );
	}
}