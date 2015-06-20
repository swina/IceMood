<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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

		if ( $this->session->userdata('validated') ){ 
		
			//load model for dashboard functions
			$this->load->model('radio_model');
			
			//check if icecast is running
			$icecast = $this->radio_model->icecast_status();
			$icecastPID = $this->radio_model->icecast_PID();
			$server_status_top = '<span class="badge badge-important">Off</span>';	
			$this->template->set ( 'server_status_switch' , '');
			$this->template->set ( 'autodj_status_switch' , '');
			$this->template->set ( 'autodj_status_text' , 'click to start AutoDJ' );
			$this->template->set ( 'autodj' , '' );
			//if icecast is running
			if ( !empty ( $icecast ) ){
				$server_status_top = '<span class="badge badge-success">On</span>';
			}
			$this->template->set ( 'server_status' , $server_status_top );	
			
			$playlist = $this->radio_model->audio_storage();
			//$this->template->set ( 'audio_storage' , '' );	
			$this->template->set ( 'audio_storage' , $playlist['songs'] );	
			$this->template->set ( 'nr_of_songs' , $playlist['nr'] );	
			
			$size = $this->radio_model->storage();
			$perc = $size / 50000;
			$this->template->set ( 'storage_size' , number_format ( $size/1000 ,2 ) . ' MB of 5 GB ' . number_format ( $perc , 2 ) .'% ');
			$this->template->set ( 'storage_perc' , number_format ( $perc , 0 ) );
			
			//last played songs
			$lastPlayedSongs = $this->radio_model->last_played();
			
			$this->template->set ( 'played' , $lastPlayedSongs['played'] ); 
			
			//recreate default playlist
			$this->radio_model->default_playlist_create();
		} else {
			redirect ( base_url() );
		}
	}
	
     

	 
	public function index()
	{
		$this->template->set('menu','');
		//load model for dashboard functions
		$this->load->model('radio_model');
	
		//size of storage
		$size = $this->radio_model->storage();
		$perc = $size / 50000;
		$this->template->set ( 'storage_size' , number_format ( $size/1000 ,2 ) . ' MB of 5 GB ' . number_format ( $perc , 2 ) .'% ');
		$this->template->set ( 'storage_perc' , number_format ( $perc , 0 ) );
		
		$pl = file_get_contents ( trim ( $this->config->item ( 'm3u_path' ) ) . 'autodj.dat' );
		$this->template->set ( 'currentPlaylist' , '(Playlist: ' . $pl . ')' );
		
		//last played songs
		$lastP = $this->radio_model->last_songs();
		$string = '';
		foreach ( $lastP as $lastSong ){
			$song = explode ( ":" , $lastSong );
			$song = end ( $song );
			$song = str_replace ( ' ' , '' , $song );
			if ( substr ( $song , 0 , 3 )  == "Now" ){
				$song = str_replace ( 'Nowplaying' , '' , $song );
				$string = $string . '<tr><td>' . $song . '</td></tr>';
			}
		}
		
		$this->template->set ( 'lastSongs' , $string ); 
		
		

		//check if icecast is running
		$icecast = $this->radio_model->icecast_status();
		$icecastPID = $this->radio_model->icecast_PID();
		
		//set icecast PID ( 0 = icecast is off )
		$this->template->set ( 'icecastpid' , $icecastPID );
		$this->template->set ( 'autodjpid' , '0' ); 
		
		//autodj off (default string)
		$autodj = '<span class="label label-important">Off</span>';
		
		//$this->template->set ( 'server_status' , '' );
		$this->template->set ( 'autodj_status' , '' );

		//if icecast is running
		if ( !empty ( $icecast ) ){
			$server_status = '<span class="badge badge-success">On</span>';
			//icecast status msg			
			$icecast_status = '<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<h4>Server is on!</h4>
                        		Your streaming server is running
								</div>';
			
			
			$this->template->set ( 'icecast_status' , $icecast_status );
			$this->template->set ( 'server_status_switch' , 'checked' );
			$this->template->set ( 'server_status_text' , '<small>Click to shutdown Icecast</small>' );
			
			//autodj (get status of autodj)	
			$autoDJ = $this->radio_model->autodj_status();
			$stringa = implode ( ' ' , $autoDJ );
			$array = explode ( ' ' , ltrim ( $stringa ) );
			
			$autodjPID = '';
			$this->template->set ( 'autodjpid' , 0 ); 
			
			//if autodj is on (icegenerator)
			if ( !empty($array[0]) ){
				$autodjPID = $array[0];
				$autodj = '<span class="label label-success">On</span>';
			}
			
			$this->template->set ( 'autodj' , $autodj ); 
			$autoDJPID = $this->radio_model->autodj_PID();
			if ( $autoDJPID != 0 ) {
				$this->template->set ( 'autodj_status_switch' , 'checked' );
				$this->template->set ( 'autodj_status_text' , '<small>Click to shutdown AutoDJ</small>' );
			} else {
				$this->template->set ( 'autodj_status_switch' , '' );
				$this->template->set ( 'autodj_status_text' , '<small>Click to start AutoDJ</small>' );
			}
			$this->template->set ( 'autodjpid' , $autoDJPID ); 
		} else {
			
			$icecast_status = '<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<h4>Server is off!</h4>
                        		Your streaming server is down</div>
								</div>';

			$this->template->set ( 'icecast_status' , $icecast_status );
			$this->template->set ( 'server_status_text' , '<small>Click to start AutoDJ</small>' );

		}
		
		
		
		$this->template->load ( 'admin/dashboard' , 'dashboard' );
	}
	
	
	
	public function storage(){
		$this->template->set ( 'test' , 'null' );
		
		
		$this->template->set('menu','storage');
		
		if ( $this->session->userdata ( 'uploadfolder' ) ){
			$this->template->set ( 'currentfolder' , $this->session->userdata ( 'uploadfolder' ) );
		}
		
		
		//size of storage
		$size = $this->radio_model->storage();
		$perc = $size / 50000;
		$this->template->set ( 'storage_size' , number_format ( $size/1000 ,2 ) . ' MB of 5 GB ' . number_format ( $perc , 2 ) .'% ');
		$this->template->set ( 'storage_perc' , number_format ( $perc , 0 ) );
		
		$this->template->set('uploading_info' , '' );
		
		//folders
		$path = $this->config->item('audio_path');
		
		//$folders[];
		$folders = $this->radio_model->read_file_lines ( $path.'folders.txt' );
		$options = '';
		$folder = '';
		$files = [];
		$indice = 0;
		$status = '';
		foreach($folders as $file) {
			if ( is_dir ( $file ) ){
				$thisFolder = str_replace ( $path , '' , $file );
				$status = $this->folder_option_status ( $thisFolder );
				$options = $options.'<option value="'.$file.'" '.$status.'>'.$thisFolder.'</option>';
			} else {
				$files [ $indice ] = $file;
			}
		}
		$this->template->set ( 'folders' , $options );
		
		//playlist list
		$pl = $this->radio_model->playlists();		
		$name = '';
		foreach ( $pl as $item ){
			$file = explode ( '/' , $item );
			$selected = '';
			if ( $this->uri->segment(3) ) {
				$param = $this->uri->segment(3).'m3u';
				if (  $param == $file [ count($file)-1 ] ) {
					$selected = 'selected';
				}
			}
			$thisPL = explode ( '.' , $file [ count($file)-1 ] );
			$name = $name . '<option value="'.$file [ count($file)-1 ].'" '.$selected.'>' .$thisPL[0]. '</option>';
		}
		$this->template->set ( 'playlist_options' , $name );
		
		//ID3 TAG EDITOR
		$this->template->set ( 'id3_form' , $this->radio_model->id3_form() );
		
		//if folder selected
		if ( $this->uri->segment(3) ){
			$folders = $this->uri->segments;
			$indice = 1;
			$folder = '';
			foreach ( $folders as $segment ){
				if ( $indice > 2 ){
					$folder .= $segment.'/';
				}
				$indice++;
			}
			/*
			$tags = [ 'id3_TIT2' , 'id3_TPE1' , 'id3_TPE2' , 'id3_TALB' , 'id3_TYER' , 'id3_TPUB' , 'id3_TCON' , 'id3_TRCK' , 'id3_TLEN' ];
			$tagsL = [ 'Title' , 'Artist' , 'Band' , 'Album' , 'Year' , 'Publisher' , 'Genre' , 'Track' , 'Length' ];
			$id3_form = '';
			$indice = 0;
			foreach ( $tags as $tag ){
				$id3_form = $id3_form . '<br>' .$tagsL[$indice] . '<br><input type="text" class="'.$tag.'" name="'.$tag.'">';
				if ( $tagsL[$indice] == "Genre" ){
					$g = 0;
					$id3_form = $id3_form . '<select class="genre_selection">';
					foreach ( $this->config->item ( 'id3_genre' ) as $genre ){
						$id3_form = $id3_form . '<option value="'.$g.'">'.$genre.'</option>';
						$g++;
					}
					$id3_form = $id3_form . '</select>';
				}
				$indice++;
			}
			$this->template->set ( 'id3_form' , $this->radio_model->id3_form() );
			*/
			
			$folder = trim($this->config->item ( 'audio_path' )).trim(urldecode ( $folder ));
			$this->session->set_userdata('uploadfolder' , $folder );
			$list = glob ( $folder.'*.mp3' );
			//exec ( "find $folder -name '*.mp3' | sort" , $list );
			$playlist = $this->radio_model->mp3_list ( $list );
			
			//songs table
			$this->template->set ( 'audio_storage' , $playlist['songs'] );
			
		} else {
			
			$this->session->set_userdata('uploadfolder' , trim ( $path ) );
			
			//audio storage
			$defaultPlaylist = $this->config->item( 'playlist' );
			$defaultPlaylist = explode ( '.' , $this->config->item( 'playlist' ) );
			$defaultPlaylist =  ( $defaultPlaylist [0] );
			
			$playlist = $this->radio_model->playlist( trim($defaultPlaylist) );
			
			//songs table
			$this->template->set ( 'audio_storage' , $playlist['songs'] );	
			
			//number of songs
			$this->template->set ( 'nr_of_songs' , $playlist['nr'] );
		}
		
		$this->template->set ('currentfolder' , $this->session->userdata ( 'uploadfolder' ) );
		
		$this->template->load ( 'admin/storage' , 'admin/storage' );
		
	}
	
	function uri_folder (){
		if ( $this->uri->segment(3) ){
			
			$folders = $this->uri->segments;
			$indice = 1;
			$folder = '';
			foreach ( $folders as $segment ){
				if ( $indice > 2 ){
					$folder .= urldecode ( $segment ).'/';
					}
				$indice++;
			}
			return $folder;
		} else {
			return '';
		}
		

	}
	
	function folder_option_status( $folderName ){
		$status = '';
		$folderName .= '/';
		$urifolder = $this->uri_folder();
		if ( $urifolder == $folderName ){
			$status = 'selected';
		}
		return $status;
	}
	
	public function playlists(){
		$this->template->set('menu','playlists');
		$defaultPlaylist = $this->config->item ( 'playlist' );
		//playlists
		$pl = $this->radio_model->playlists();		
		$name = '';
		foreach ( $pl as $item ){
			$file = explode ( '/' , $item );
			$selected = '';
			if ( $this->uri->segment(3) ) {
				$param = urldecode ( $this->uri->segment(3).'.m3u' );
				if (  $param == $file [ count($file)-1 ] ) {
					
					$selected = 'selected';
				}
			}
			$thisPL = explode ( '.' , $file [ count($file)-1 ] );
			$name = $name . '<option value="'.$file [ count($file)-1 ].'" '.$selected.'>' .$thisPL[0]. '</option>';
		}
		$this->template->set ( 'addFile' , '');
		$this->template->set ('playlist' , '');
		$this->template->set ( 'playlist_selected' , '' );
		$this->template->set ( 'playlist_options' , $name );
		
		$this->template->set ( 'id3_form' , $this->radio_model->id3_form() );
		
		if ( $this->uri->segment(3) ) {
			$defaultPlaylist = trim($this->uri->segment(3));
			
			$pl = $this->radio_model->playlist ( $defaultPlaylist );
			
			$this->template->set ( 'addFile' , '<a href="#" class="playlist-add-file" name="'.$this->uri->segment(3).'">Add File</a>');
			$this->template->set ('audio_storage' , $pl['songs']);
			$this->template->set ( 'playlist_selected' , urldecode ( $this->uri->segment(3) ) . ' <small><span class="badge badge-info">Duration => ' . $pl['duration'] . '</span></small>');

		} else {
			$defaultPlaylist = explode ( '.' , $defaultPlaylist );
			$defaultPlaylist = $defaultPlaylist[0];
			$pl = $this->radio_model->playlist ( $defaultPlaylist );
			$this->template->set ( 'addFile' , '<a href="#" class="playlist-add-file" name="'.$defaultPlaylist.'">Add File</a>');
			$this->template->set ('audio_storage' , $pl['songs']);
			$this->template->set ( 'playlist_selected' , urldecode ( $defaultPlaylist ) . ' <small><span class="badge badge-info">Duration => ' . $pl['duration'] . '</span></small>');
		}
		
		$this->template->load ( 'admin/playlists' , 'admin/playlists' );
	}
	
	public function slots(){
		$this->template->set('menu','slots');
		//playlist
		$pl = $this->radio_model->playlists();
		//slots
		$slots = $this->radio_model->slots();
		$name = '';
		foreach ( $slots as $item ){
			$file = explode ( '/' , $item );
			$selected = '';
			if ( $this->uri->segment(3) ) {
				$param = urldecode ( $this->uri->segment(3).'.slot' );
				if (  $param == $file [ count($file)-1 ] ) {
					
					$selected = 'selected';
				}
			}
			$thisPL = explode ( '.' , $file [ count($file)-1 ] );
			$name = $name . '<option value="'.$file [ count($file)-1 ].'" '.$selected.'>' .$thisPL[0]. '</option>';
		}
		
		$this->template->set ( 'addFile' , '');
		$this->template->set ('playlist' , '');
		$this->template->set ( 'playlist_selected' , '' );
		$this->template->set ( 'playlist_options' , $name );
		$this->template->set ('table_output' , '' );
		
		if ( $this->uri->segment(3) ) {
			$defaultPlaylist = trim($this->uri->segment(3));
			
			$mySlot = $this->radio_model->slot ( $defaultPlaylist );
			
			$this->template->set ( 'addFile' , '<a href="#" class="playlist-add-file" name="'.$this->uri->segment(3).'">Add File</a>');
			$output = $this->slot_render( $mySlot , $pl );
			$this->template->set ('table_output' , $output );
			$this->template->set ( 'playlist_selected' , urldecode ( $this->uri->segment(3) )  );

		}
		
		$this->template->load ( 'admin/slots' , 'admin/slots' );
	}
	
	function slot_render ( $array , $playlists ){
		$output = '';
		foreach ( $array as $slot ){
			if ( !empty ( $slot ) ){
				$line = explode ( '|' , $slot );
				$start = $line[0];
				$start = explode ( ':' , $start );
				$start = $start[0];
				$start = intval($start);
				
				$end = $line[2];
				$end = explode ( ':' , $end );
				$end = $end[0];
				$end = intval($end);
				
				$pl = $line[1];
				if ( $end < $start ){
					$end = $end + 24;
				}
				
				$hours = $end - $start;
				$n = 0;
				while ( $n < $hours ){ 
					$output = $output.'<tr>';
					
					$startTime = $start + $n;
					if ( $startTime > 24 ){
						$startTime = $startTime - 24;
					}
					$endTime = $startTime + 1;
					$option = '<select class="select-slot-playlist" name="'.$pl.'">';
					foreach ( $playlists as $playlist ){
						$myPL = explode ( '/' , $playlist );
						$myPL = end ( $myPL );
						$myPL = explode ( '.' , $myPL );
						$myPL = $myPL[0];
						if ( trim($myPL) == trim($pl) ){
							$option = $option.'<option value="'.str_pad($startTime,2,0,STR_PAD_LEFT).':00|'.$myPL.'|'.str_pad($endTime,2,0,STR_PAD_LEFT).':00" selected>'.$myPL.'</option>';
						} else {
							$option = $option.'<option value="'.str_pad($startTime,2,0,STR_PAD_LEFT).':00|'.$myPL.'|'.str_pad($endTime,2,0,STR_PAD_LEFT).':00">'.$myPL.'</option>';
						}
					}
					$option = $option.'</select>';
					$output = $output.
					'<td>'.($startTime).':00</td>
					<td>'.$endTime.':00</td>
					<td>'.$option.'</td>';
					$output = $output.'</tr>';
					$n++;
				}
			}
		}
		return $output;
	}
	
	public function planning(){
		$timestamp = time();
		date_default_timezone_set ( $this->config->item ( 'icegen_timezone' ) );
		$datum = date("Y-m-d (D) H:i:s",$timestamp);
		$this->template->set ( 'currTime' , $datum );
		$this->template->set ( 'menu' , 'planning' );
		
		//playlist
		
		$playlists = $this->radio_model->playlist_duration();
		$pl = '';
		foreach ( $playlists as $playlist ){
			$line = explode ( '|' , $playlist );
			$play = $line [0];
			//$play = str_replace ( '.m3u' , '' , $play );
			$t = $line[1];
			$t = gmdate ( "H:i:s" , $t );
			//$duration = sprintf('%02d:%02d', ($t/60%60), $t%60);
			$pl = $pl . ' <div class="external-event draggable" data-duration="' . $t. '" title="'. $t .'">'.$play.'</div>';
		}
		$this->template->set ( 'playlists' , $pl );
		
		/*$playlists = $this->radio_model->playlists();
		$pl = '';
		foreach ( $playlists as $playlist ){
			$play = explode ( '/' , $playlist );
			$play = end ( $play );
			$play = str_replace ( '.m3u' , '' , $play );
			$pl = $pl . ' <div class="external-event draggable" data-duration="03:00">'.$play. '</div>';
		}
		$this->template->set ( 'playlists' , $pl );
		*/
		
		
		$this->template->load ( 'admin/planning' , 'admin/planning' );
	}
	
	function autodjlog(){
		$this->template->set ( 'menu' , 'Logs' );
		$output = $this->radio_model->autodj_monitor();
		$this->template->set ( 'log' , $output );
		$this->template->load ( 'admin/logs' , 'admin/logs' );
	}
	
	function autodjplayed(){
		$this->template->set ( 'menu' , 'Logs' );
		$output = $this->radio_model->autodj_played();
		$this->template->set ( 'log' , $output );
		$this->template->load ( 'admin/logs' , 'admin/logs' );
	}

	public function upload() {
		
		if (!empty($_FILES)) {
			
			$tempFile = $_FILES['file']['tmp_name'];
			$fileName = $_FILES['file']['name'];
			$fileName = str_replace ( ' ' , '' , $fileName );
			
			$targetPath = $this->config->item('audio_path');
			
			if ( $this->session->userdata ( 'uploadfolder' ) ){
				$targetPath = $this->session->userdata ( 'uploadfolder' ).'/';
			}
			
			$targetFile = $targetPath.$_FILES['file']['name'] ;
			
			if ( move_uploaded_file( $tempFile, $targetFile) ){
				$this->template->set('uploading_info' , 'Uploaded '.$targetFile );
			} else {
				$this->template->set('uploading_info' , 'An error occured' );
			}
			
		}
		
	}
	
	
}