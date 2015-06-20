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
	
	public function __Construct() {
		
		parent::__Construct();
		//load model for dashboard functions
		$this->load->model('radio_model');
	}
	
	public function index()
	{
		//get the function to be called
		$ajaxf = $this->uri->segment(3);
		
	}
	
	// login
	public function login(){
		$username = $this->input->post('user_email');
        $password = $this->input->post('user_pass');
		if ( $username == trim($this->config->item ( 'admin')) ){
			if ( $password == trim($this->config->item ( 'admin_pw')) ) {
				$data = array(
                    'adminid' => 1,
                    'aname' => $username,
                    'aemail' => $this->config->item ( 'admin_email' ),                   
                    'validated' => true
                    );
				$this->session->set_userdata($data);
				echo  base_url() . 'dashboard';
				
			} 
		} 
		//echo "User or password are wrong!";
	}
	
	// start/stop icecast
	public function icecast(){
		
		$flag = $this->input->post('switch');
		$pid = $this->input->post('pid');
		
		if ( $pid != '0' ) {
			// stop icecast
			$cmd = $this->config->item ( 'sudo' ).' kill -KILL '.$pid;
			$res = shell_exec ( $cmd );
			echo '';
		} else {
			// start icecast
			$command = $this->config->item ( 'sudo' ).' '.$this->config->item ('icecast_path').' -c '.$this->config->item('icecast_xml'). ' -b 2>&1 & echo $!';
			$log = $this->config->item ( 'icecast_log' );
			$PID=shell_exec($command );
			echo '';
		}
	} 
	
	// start/stop autodj
	public function autodj(){
		
		$flag = $this->input->post('switch');
		$pid = $this->input->post('pid');
		
		if ( $pid != '0' ) {
			$cmd = $this->config->item ( 'sudo' ).' kill -KILL '.$pid;
			$res = shell_exec ( $cmd );
			echo '';
		} else {
			$cmd = $this->config->item ( 'sudo' ).' '.$this->config->item ( 'icegen_path' ).' -f '. trim ( $this->config->item ( 'icegen_cfg' ) );
			$res = shell_exec ( $cmd );	
			echo $cmd;
		}
	} 
	
	// create default m3u playlist based on all mp3 found in the audio storage path
	public function audio_storage(){
		$cmd = $this->config->item ( 'sudo' ) . ' find ' . $this->config->item ( 'audio_path' ) . ' | grep .mp3 |sort > ' . $this->config->item ( 'playlist' );
		$res = shell_exec ( $cmd );
	}
	
	// create icemood config file
	public function setupsave(){
		//icemood custom config file
		$file = FCPATH.'application/config/icemood.php';
		
		//icemood configs
		$data = '<?php'."\n".'$config["streaming"] = "'.$this->input->post ( 'streaming' ) .'";';
		$data = $data."\n".'$config["streaming_json"] = "status-json.xsl";';
		$data = $data."\n".'$config["icecast_path"] = "'.$this->input->post ( 'icecast_path' ) .'";';
		$data = $data."\n".'$config["icecast_xml"] = "'.$this->input->post ( 'icecast_xml' ) .'";';
		$data = $data."\n".'$config["icecast_log"] = "'.$this->input->post ( 'icecast_log' ) .'";';
		$data = $data."\n".'$config["icegenerator"] = "1";';
		$data = $data."\n".'$config["icegen_path"] = "'.$this->input->post ( 'icegen_path' ) .'";';
		$data = $data."\n".'$config["icegen_cfg"] = "'.$this->input->post ( 'icegen_cfg' ) .'";';
		$data = $data."\n".'$config["icegen_log"] = "'.$this->input->post ( 'icegen_log' ) .'";';
		$data = $data."\n".'$config["sudo"] = "'.$this->input->post ( 'sudo' ) .'";';
		$data = $data."\n".'$config["audio_path"] = "'.$this->input->post ( 'storage_path' ) .'";';
		$data = $data."\n".'$config["playlist"] = "'.$this->input->post ( 'playlist' ) .'";';
		
		//save configs
		file_put_contents($file,$data);
		
		redirect ( 'settings/saved' , 'refresh' );
	}
	
	// create icegenerator config file
	public function autodjsave(){
		//icegenerator custom config file
		$file = FCPATH.'application/config/icegenerator.php';
		
		//icegenerator general configs
		$data = '<?php'."\n";
		$data = $data."\n".'$config["icegen_ip"] = "'.$this->input->post ( 'icegen_ip' ) .'";';
		$data = $data."\n".'$config["icegen_port"] = "'.$this->input->post ( 'icegen_port' ) .'";';
		$data = $data."\n".'$config["icegen_mount"] = "'.$this->input->post ( 'icegen_mount' ) .'";';
		$data = $data."\n".'$config["icegen_user"] = "'.$this->input->post ( 'icegen_user' ) .'";';
		$data = $data."\n".'$config["icegen_password"] = "'.$this->input->post ( 'icegen_pwd' ) .'";';
		$data = $data."\n".'$config["icegen_format"] = "'.$this->input->post ( 'icegen_format' ) .'";';
		$data = $data."\n".'$config["icegen_type"] = "'.$this->input->post ( 'icegen_type' ) .'";';
		$data = $data."\n".'$config["icegen_name"] = "'.$this->input->post ( 'icegen_name' ) .'";';
		$data = $data."\n".'$config["icegen_genre"] = "'.$this->input->post ( 'icegen_genre' ) .'";';
		$data = $data."\n".'$config["icegen_description"] = "'.$this->input->post ( 'icegen_description' ) .'";';
		
		//save configs
		file_put_contents($file,$data);
		
		redirect ( 'autodj/saved' , 'refresh' );
	}
	
	// create a session variable for current audio storage path
	public function uploadfolder(){
		$data["uploadfolder"] = $this->input->post ( 'folder' );
		$this->session->set_userdata ( $data );
	}
	
	// create a new folder relative to audio storage path 
	public function createfolder(){
		$data["uploadfolder"] = $this->input->post ( 'folder' );
		$this->session->set_userdata ( $data );
		mkdir ( $this->input->post ( 'folder' ) );
		//exec ( "mkdir ".$this->input->post ( 'folder' ) );
		echo "Folder has been created";
	}
	
	// ** not used **
	public function currentplaylist(){
		$data["currentplaylist"] = $this->input->post ( 'playlist' );
		$this->session->set_userdata ( $data );
	}
	
	// ** not used **
	public function addToPlaylist(){
		$playlist = $this->session->userdata ( 'currentplaylist' );
		 
	}
	
	// create a new folder relative to audio storage path 
	public function createplaylist(){
		$playlist = $this->input->post ( 'playlist' );
		//$playlist = str_replace(' ', '_', $playlist); // Replaces all spaces with hyphens.
   		//$playlist = preg_replace('/[^A-Za-z0-9\-\.]/', '', $playlist); // Removes special chars.
		$content = "";
		$fp = fopen($this->config->item ( 'm3u_path') . $playlist . ".m3u","wb");
		fwrite($fp,$content);
		fclose($fp);
		
		//create cfg file for icegenerator
		$data = "NAME=" .$this->config->item ( 'icegen_name' );
		$data = $data. "\n" . "IP=" . $this->config->item ( 'icegen_ip' );
		$data = $data. "\n" . "PORT=" . $this->config->item ( 'icegen_port' );
		$data = $data. "\n" . "SERVER=2";
		$data = $data. "\n" . "SOURCE=" . $this->config->item ( 'icegen_user' );
		$data = $data. "\n" . "PASSWORD=" . $this->config->item ( 'icegen_password' );
		$data = $data. "\n" . "FORMAT=" . $this->config->item ( 'icegen_format' );
		$data = $data. "\n" . "RECURSIVE=1";
		$data = $data. "\n" . "DUMPFILE=";
		$data = $data. "\n" . "LOOP=1";
		$data = $data. "\n" . "SHUFFLE=1";
		$data = $data. "\n" . "BITRATE=44100";
		$data = $data. "\n" . "PUBLIC=0";
		$data = $data. "\n" . "METAUPDATE=5";
		$data = $data. "\n" . "LOG=2";
		$data = $data. "\n" . "LOGPATH=" . $this->config->item ( 'icegen_log' );
		$data = $data. "\n" . "DATAPORT=8697";
		$data = $data. "\n" . "MOUNT=" . $this->config->item ( 'icegen_mount' );
		$data = $data. "\n" . "MP3PATH=" . $this->config->item ( 'icegen_type' ) . $this->config->item ( 'm3u_path') . $playlist . '.m3u';
		$data = $data. "\n" . "GENRE=" . $this->config->item ( 'icegen_genre' );
		$data = $data. "\n" . "DESCRIPTION=" . $this->config->item ( 'icegen_description' );
		$data = $data. "\n" . "URL=" . $this->config->item ( 'streaming' ) . $this->config->item ( 'icegen_mount' );
		
		$fp = fopen($this->config->item ( 'm3u_path') . $playlist . ".cfg","wb");
		fwrite($fp,$data);
		fclose($fp);
		
		//exec ( "mkdir ".$this->input->post ( 'folder' ) );
		echo "Playlist has been created";
	}
	
	// add files to a playlist
	public function playlistaddfiles (){
		//playlist name
		$playlist = $this->input->post ( 'playlist' );
		// array of files to add
		$songs = $this->input->post ( 'songs' );
		// playlist m3u file
		$file = $this->config->item ( 'm3u_path' ) . $playlist;
		
		//create lines
		$lines = "";
		foreach ( $songs as $song ){
			$song = $this->config->item('mp3_path').$song;
			$lines = $lines.$song."\n";
		}
		// read current m3u content
		$current = file_get_contents($file);
		// concatenate current and new lines
		if ( $current != '' ){
			$data = $current. "\n" . $lines;
		} else {
			$data = $current . $lines;
		}
		$str = preg_replace('/^\n+|^[\t\s]*\n+/m', '', $data);
		//update playlist
		file_put_contents( $file , $str );
		
		echo 'done';
	}
	
	// remove files from a playlist
	public function playlistremovefiles(){
		//playlist
		$playlist = $this->input->post ( 'playlist' );
		//files to remove array
		$songs = $this->input->post ( 'files' );
		// playlist m3u file
		$file = $this->config->item ( 'm3u_path' ) . $playlist;
		$lines = "";
		foreach ( $songs as $song ){
			$song = $this->config->item ( 'mp3_path' ) . $song;
			$lines = $lines . $song . "\n" ;
		}
		$str = preg_replace('/^\n+|^[\t\s]*\n+/m', '', $lines);
		$myfile = fopen( $file , "w") or die("Unable to open file!");
		fwrite($myfile, $str);
		fclose($myfile);
		echo 'Files have been removed from playlist';
	}
	
	public function playplaylist (){
		$icegen_PID = $this->radio_model->autoDJ_PID();
		$cmd = $this->config->item ( 'sudo' ).' kill -KILL '.$icegen_PID;
		$res = shell_exec ( $cmd );
		$path = trim(FCPATH).'audio/playlists/'.$this->input->post( 'playlist' ).'.cfg';
		$cmd = $this->config->item ( 'sudo' ).' '.$this->config->item ( 'icegen_path' ).' -f '.trim($path);
		$res = shell_exec ( $cmd );
		echo $path."\n".$res;	
	}
	
	public function slotsave(){
		$file = trim($this->config->item ( 'm3u_path') ) . $this->input->post ( 'slot' );
		$data = $this->input->post ( 'slots' );
		$lines = '';
		foreach ( $data as $slot ){
			$lines = $lines . $slot . "\n";
		}
		$fp = fopen( trim($file) ,"w") or die("Unable to create file!");
		fwrite ( $fp , $lines );
		fclose ( $fp );
		$res = "OK";
		foreach ( $data as $slot ){
			$playlist = explode ( '|' , $slot );
			$pl = $playlist[1];
			
			$content = file_get_contents ( trim ( $this->config->item ( 'm3u_path' ) ) . $pl . '.m3u' );
			if ( '' == $content ){
				$res = $pl." is empty\nYou can't set an empty playlist";
			}
		}
		echo $res;
	}
	
	public function slotcreate(){
		$slot = $this->input->post ( 'slot' );
		$txt = "00:00|songlist|24:00\n";
		$fp = fopen( trim($this->config->item ( 'm3u_path') ) . $slot . ".slot","wb") or die("Unable to create file!");
		fwrite($fp,$txt);
		fclose($fp);
		echo $slot . ' slot has been created';
	}
	
	public function id3read (){
		$file = trim ( $this->input->post ( 'mp3' ) );
		$this->load->model ( 'mp3_model' );	
		$data = $this->mp3_model->mp3_tag_read ( $file );
		//echo $data['TCON'];
		//$genre = $this->config->item ( 'id3_genre' );
		if ( array_key_exists ( 'TIT2' , $data ) ){
			echo json_encode ( $data );
		} else {
			echo "0";
		}
	}
	
	public function id3genre ($n){
		$id = str_replace ( '(' , '' , $n );
		$id = str_replace ( ')' , '' , $id );
		$genre = $this->config->item ( 'id3_genre' );
		return $genre[ intval ( $id ) ];
		
	}
	
	public function id3save (){
		$this->load->model ( 'mp3_model' );	
		
		$file = trim ( $this->input->post ( 'mp3' ) );
		
		$tags['title'] = $this->input->post ( 'title' );
		$tags['album'] = $this->input->post ( 'album' );
		$tags['artist'] = $this->input->post ( 'artist' );
		$tags['band'] = $this->input->post ( 'band' );
		$tags['year'] = $this->input->post ( 'year' );
		$tags['track'] = $this->input->post ( 'track' );
		$tags['genre'] = $this->input->post ( 'genre' );
		$tags['publisher'] = $this->input->post ( 'publisher' );
		$tags['duration'] = $this->input->post ( 'duration' );
		
		if ( is_array( $this->input->post ( 'mp3a' ) ) ){
			$files = $this->input->post ( 'mp3a' );
			$indice = 0;
			foreach ( $files as $mp3 ){
				$file = $mp3;
				if ( $indice > 0 ){
					$tags['title'] = '';
					$tags['duration'] = '';
					$tags['track'] = $indice + 2;
				}
				
				$res = $this->mp3_model->mp3_tag_write (  trim($this->config->item ( 'mp3_path' )) .$mp3 , $tags );
				echo $res;
				$indice++;
			}
		} else {
			$res = $this->mp3_model->mp3_tag_write ( $file , $tags );
			echo $res;
		}
	}
	
	public function plannersave(){
		$plans = $this->input->post ( 'planning' );
		$txt = '';
		foreach ( $plans as $plan ) {
			$txt = $txt . $plan . "\n";
		}
		$fp = fopen( trim($this->config->item ( 'm3u_path') ) . "planning.dat","wb") or die("Unable to create file!");
		fwrite($fp,$txt);
		fclose($fp);
		//echo $slot . ' slot has been created';
		echo '';
	}
	
	
	
	public function delete_files(){
		// action => 'trash' or 'delete'
		$flag = $this->input->post ( 'action' );
		
		//array of files to be deleted
		$data = $this->input->post ( 'file' );
		
		foreach ( $data as $source ){

			//complete source file path ** not used **
			$sourceFile  = $this->config->item('mp3_path').$source;
			
			//get File name ** not used **
			$source = $this->config->item('mp3_path').''.$source;
			$filenameA = explode ( '/' , $source );
			$filename = end ( $filenameA );
			
			
			//trash destination path ** not used **
			$targetFile = $this->config->item('mp3_trash').$filename;
			clearstatcache();
			
			//** not used **
			$srcDir = $this->config->item ( 'mp3_path' ) ;
			$destDir = $this->config->item ( 'mp3_trash' );
			
			//move to trash to be done
			if ( $flag == 'trash' ){
				$msg = "";
				$msg = "Files have been moved to trash\n";
				$target = $this->config->item('mp3_trash').$filename;
				rename ( trim($source) , trim($target));
				
			}
			
			//delete file
			if ( $flag == 'delete' ){
				$msg = "Files have been deleted\n";
				unlink ( trim ( $source ) );
				
				//shell exec rm command
				//$msg = $msg. exec ( "rm ".$source ." 2>&1");
			}
		}
		echo $msg;
	}

}