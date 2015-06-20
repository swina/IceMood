<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __Construct() {
		
		parent::__Construct();
		
		$this->template->set('menu','settings');
		
		//load model for dashboard functions
		$this->load->model('radio_model');
		//check if icecast is installed
		$icecast = $this->radio_model->whereis_icecast();
		$this->template->set ( 'icecast_is' , '<span class="badge badge-important">Icecast Path</span>' );
		$this->template->set ( 'icegenerator_is' , '<span class="badge badge-important">Icegenerator Path</span>' );
		$this->template->set ( 'icecast_alert' , '<div class="alert alert-error alert-block">
										<a class="close" data-dismiss="alert" href="#">×</a>
										<h4 class="alert-heading">Icecast not found!</h4>
										System didn\'t find Icecast installation. Icecast is required in order to run settings
									</div>' );
		$this->template->set ( 'icegenerator_alert' , '<div class="alert alert-error alert-block">
										<a class="close" data-dismiss="alert" href="#">×</a>
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
		$this->template->load ( 'admin/settings' , 'admin/settings' );
		//print_r ( $this->session->userdata );
	}
	
	public function autosetup(){
		$this->template->load ( 'admin/autosetup' , 'admin/autosetup' );
	}
	
	public function saved(){
		
		$this->template->set ( 'saved_info' , '<div class="alert alert-success alert-block">
										<a class="close" data-dismiss="alert" href="#">×</a>
										<h5 class="alert-heading">Saved successfully!</h5>
									</div>' );
		$this->template->load ( 'admin/settings' , 'admin/settings' );
	}
}