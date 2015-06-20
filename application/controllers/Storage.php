<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Storage extends CI_Controller {

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
	public function index()
	{
		
		//load model for dashboard functions
		$this->load->model('radio_model');
		
		//check if icecast is running
		$icecast = $this->radio_model->icecast_status();
		$icecastPID = $this->radio_model->icecast_PID();
		$server_status = '<span class="badge badge-important">Off</span>';
		
		//number of played songs
		$lastPlayedSongs = $this->radio_model->last_played();
		$this->template->set ( 'played' , $lastPlayedSongs['played'] ); 
		//if icecast is running
		if ( !empty ( $icecast ) ){
			
			$server_status = '<span class="badge badge-success">On</span>';
		}
		
		$this->template->set ( 'server_status' , $server_status );
		
		
		//playlists
		$playlists = $this->radio_model->playlists();		
		$name = '';
		foreach ( $playlists as $item ){
			$file = explode ( '/' , $item );
			$name = $name . $file [ count($file)-1 ] . ' - ';
		}
		$this->template->set ( 'playlists' , $name );
		
		//audio storage
		$playlist = $this->radio_model->audio_storage();
		
		//songs table
		$this->template->set ( 'audio_storage' , $playlist['songs'] );	
		
		//number of songs
		$this->template->set ( 'nr_of_songs' , $playlist['nr'] );
		
		//size of storage
		$size = $this->radio_model->storage();
		$perc = $size / 50000;
		$this->template->set ( 'storage_size' , number_format ( $size/1000 ,2 ) . ' MB of 5 GB ' . number_format ( $perc , 2 ) .'% ');
		$this->template->set ( 'storage_perc' , number_format ( $perc , 0 ) );
		
		
		
		
		$this->template->load ( 'admin/storage' , 'admin/storage' );
	}
	
	public function upload() {
	
		$config ['upload_path'] = $this->config->item ( 'audio_path' );
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
		
			echo $error;
			$this->template->load ( 'admin/storage' , 'admin/storage' );
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			 echo 'upload_success'.$data;
			 $this->template->load ( 'admin/storage' , 'admin/storage' );
		}
		
		/*
		if (!empty($_FILES)) {
			
			$tempFile = $_FILES['file']['tmp_name'];
			$fileName = $_FILES['file']['name'];
			$fileName = str_replace ( ' ' , '' , $fileName );
			$targetPath = $this->config->item('audio_path');
			
			$targetFile = $targetPath . $fileName ;
			
			if ( move_uploaded_file($tempFile, $targetFile) ){
				//$this->template->set('uploading_info' , 'Uploaded '.$targetFile );
			} else {
				//$this->template->set('uploading_info' , 'An error occured' );
			}
			
		}*/
	}
}