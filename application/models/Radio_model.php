 <?php

class Radio_Model extends CI_Model {
	
	function __construct(){
		parent::__construct();
		require ( FCPATH.'application/libraries/id3.class.php' );
		require ( FCPATH.'application/libraries/mp3.class.php' );
	}
	
	function whereis_icecast (){
		$icecast_found = false;
		$icegenerator_found = false;
		$icecast_path = '';
		$icegenerator_path = '';
		exec ( $this->config->item ( 'sudo' ) . ' whereis icecast' , $icecast );
		if ( !empty ( $icecast ) ){
			$icecast_found = true;
			$icecast_path = $icecast[0];
			$icecast_path = explode ( ':' , $icecast_path );
			$icecast_path = $icecast_path[1];
			$icecast_path = explode ( ' ' , $icecast_path );
			$icecast_path = $icecast_path[1];
			
			exec ( $this->config->item ( 'sudo' ) . ' whereis icegenerator' , $icegenerator );
			if ( !empty ( $icegenerator ) ) {
				$icegenerator_found = true;
				$icegenerator_path = $icegenerator[0];
				$icegenerator_path = explode ( ':' , $icegenerator_path );
				$icegenerator_path = $icegenerator_path[1];
				$icegenerator_path = explode ( ' ' , $icegenerator_path );
				$icegenerator_path = $icegenerator_path[1];
				
			} 
		}
		$data = array(
                 'icecast' => $icecast_found,
                 'icegenerator' => $icegenerator_found,
                 'icecast_path' => $icecast_path,                   
                 'icegenerator_path' =>$icegenerator_path
 		);
		$this->session->set_userdata($data);
		return true;
	}
	
	function icecast_status(){
		exec("ps -G icecast | grep icecast" , $output);
		return $output;
	}
	
	function icecast_PID(){
		exec("ps -G icecast | grep icecast" , $output);
		$stringa = implode(" ",$output);
		$array = explode ( " " , ltrim($stringa));
		$indice = 0;
		if ( !empty ( $array[0] ) ){
			foreach ( $array as $item ){
				$indice++;
			}
			return $array[0];
		} else {
			return 0;
		}
	}
	
	function autodj_status(){
		exec( 'ps -C icegenerator | grep icegenerator' , $autodj );
		return $autodj;
	}
	
	function autodj_PID(){
		exec( 'ps -C icegenerator | grep icegenerator' , $autoDJ );
		$stringa = implode ( ' ' , $autoDJ );
		$array = explode ( ' ' , ltrim ( $stringa ) );
		if ( !empty($array[0]) ){
			return $array[0];
		} else {
			return 0;
		}
	}
	
	function radio_log(){
		
		$lastPlayed = [];
		$indice = 0;
		$file_handle = fopen($this->config->item('icegen_log'), "rb");

		while (!feof($file_handle) ) {

			$line_of_text = fgets($file_handle);
			echo $line_of_text .'<br>';
		}
	}
	
	function autodj_monitor(){
		//$file = $this->config->item ( 'icegen_log' );
		$file = trim ( $this->config->item ( 'm3u_path' ) ) . 'autodj.log';
		$handle = fopen( trim( $file ) , "r") or die("Couldn't get handle");
		$output = '';
		if ($handle) {
    		while (!feof($handle)) {
		        $buffer = fgets($handle, 4096);
				$lines = explode ( "\n" , $buffer );
				foreach ( $lines as $line ){
					$output = $output .  $line . "\n";
				}
			}
	    }
    	fclose($handle);
		return $output;
	}
	
	function autodj_played(){
		$file = $this->config->item ( 'icegen_log' );
		$handle = fopen( trim( $file ) , "r") or die("Couldn't get handle");
		$output = '';
		if ($handle) {
    		while (!feof($handle)) {
		        $buffer = fgets($handle, 4096);
				$lines = explode ( "\n" , $buffer );
				foreach ( $lines as $line ){
					$output = $output .  $line . "\n";
				}
			}
	    }
    	fclose($handle);
		return $output;
	}
	
	
	function last_played(){
		//check if icecast is running
 		//exec("ps -G icecast | grep icecast" , $output);
		
		$lastPlayed = [];
		$indice = 0;
		$file_handle = fopen($this->config->item('icegen_log'), "rb");
		$played = 0;
		while (!feof($file_handle) ) {

			$line_of_text = fgets($file_handle);
			$parts = explode(':', $line_of_text);
			
			if ( count ( $parts ) > 1 ){
				$check = substr ( $parts[3] , 0 , 4 );
				
				if ( str_replace(' ','',$check) == "Now" ){
					$played++;
					$song = str_replace ( 'Now playing ' , '' , $parts[3] );
					
					$lastPlayed [$indice] = $song .'<br>';
					$indice++;
				}
			}
			
		}
		fclose($file_handle);
		$data['played'] = $played;
		$data['songs'] = $lastPlayed;
		return $data;
		//return $string;
	}
	
	function last_songs(){
		$data = array_slice(file(trim($this->config->item('icegen_log'))),-10);
		return $data;
	}
	
	function find_file($dirs,$filename,$exact=false){
 
	    $dir = @scandir($dirs);
	    if(is_array($dir) AND !empty($dir)){
	    	foreach($dir as $file){
	    		if(($file !== '.') AND ($file!=='..')){
	    			if (is_file($dirs.'/'.$file)){
	        			$filepath =  realpath($dirs.'/'.$file);
					        if(!$exact){
					            $pos = strpos($file,$filename);
					            if($pos === false) {
					            }
					            else {
	                				if(file_exists($filepath) AND is_file($filepath)){
						                echo str_replace($filename,'<span style="color:red;font-weight:bold">'.$filename.'</span>',$filepath).' ('.round(filesize($filepath)/1024).'kb)<br />';
				                }
	            			}
			        }
	       			elseif(($file == $filename)){
	 					if(file_exists($filepath) AND is_file($filepath)){
	                		echo str_replace($filename,'<span style="color:red;font-weight:bold">'.$filename.'</span>',$filepath).' ('.round(filesize($filepath)/1024).'kb)<br />';
	            		}
	        		}
			    }
	    		else{
	        		find_file($dirs.'/'.$file,$filename,$exact);
			    }
	    		}
	    	}
	    }
	}
	
	function read_file_lines ( $file , $sort=false ){
		$array = explode("\n", file_get_contents($file));
		if ( $sort ){
			$array = asort ( $array );
		}
		return $array;
	}
	
	//get list of all audio (mp3)
	function audio_storage(){
		$this->default_playlist_create();
		$pl = $this->config->item ( 'm3u_path' ).$this->config->item( 'playlist' );
		$data = '';
		if ( $pl )
		{
			
			$file_handle = fopen( $pl , "rb");
			$mySongs = '';
			$riga = 1;
			while (!feof($file_handle) ) {
	
				$line_of_text = fgets($file_handle);
				$parts = explode('/', $line_of_text);
				if ( !empty ( $parts[count($parts)-1] ) ){
					
					$myFile = str_replace ( $this->config->item ( 'mp3_path' ) , '' , $line_of_text );
					$myMP3 = new MP3File ( trim ( $line_of_text ) );
					$duration = $myMP3->getDurationEstimate();
					$t = round($duration);
					$duration = sprintf('%02d:%02d', ($t/60%60), $t%60);

					$myId3 = new ID3(trim($line_of_text));
						$id3Info = $parts[count($parts)-1];
						$id3['title'] =  "";
						$id3['artist'] =  "";
						$id3['genre'] =  "";
						$id3['album'] =  "";
						$album = '';
						if ( $myId3->getInfo() ){
							$id3['title'] =  preg_replace('/[^A-Za-z0-9\-\.\ ]/', '', $myId3->getTitle() );
							$id3['artist'] =  preg_replace('/[^A-Za-z0-9\-\.\ ]/', '', $myId3->getArtist() );
							$id3['genre'] =  preg_replace('/[^A-Za-z0-9\-\.\ ]/', '', $myId3->getGender() );
							$id3['album'] =  preg_replace('/[^A-Za-z0-9\-\.\ ]/', '', $myId3->getAlbum() );
							$id3Info = $id3['artist'] .' - '. $id3['title'] .' ('. $id3['genre'] .')';
						}
						
						$mySongs =  $mySongs.'<tr id="row_'.$line_of_text.'">
						<td>
							<input type="checkbox" name="'.$myFile.'" class="check-song">
						
						</td>
					
						<td>' . $riga. '</td>
						<td>
						<button name="'.base_url().trim($this->config->item('mp3_url')).'/'.trim($myFile).'" class="btn btn-play-audio" song="'.$id3['artist'].' - '. $id3['title'].'"><span class="icon-play"></span></button>
						<img src="'. base_url() .'images/id3logo.png" class="btn-set-id3tag" name="'.$line_of_text.';'.$duration.';'.$riga.'">
						</td>
						<td><small>' .$parts[ count($parts)-2] .'<br>'.$parts[count($parts)-1].'</small></td>
						<td><small>' . $id3['album']. '</small></td>
						<td><small>'. $id3['artist'].' - '. $id3['title'] .'</small></td>
						<td><small>'.$duration.'</small></td>
						<td><small>'. $id3['genre'] .'</small></td>
						</tr>';
					$riga++;
				}
			}
			$data['nr'] = $riga-1;
			$data['songs'] = $mySongs;
			fclose($file_handle);
			
		}
		return $data;
	}
	
	function storage(){
		$f = $this->config->item ( 'audio_path' );
    	$io = popen ( '/usr/bin/du -sk ' . $f, 'r' );
    	$size = fgets ( $io, 4096);
    	$size = substr ( $size, 0, strpos ( $size, "\t" ) );
    	pclose ( $io );
		return $size;
    	//echo 'Directory: ' . $f . ' => Size: ' . $size;
	}
	
	function playlists(){
		$files = glob( $this->config->item ( 'm3u_path'). '*.m3u');
		return $files;
	}
	
	function playlist($file){
		
		$file_to_open = trim( $this->config->item('m3u_path').$file.'.m3u' );
		$file_to_open = urldecode ( $file_to_open );
		if ( $file_to_open ){
		
			$file_handle = fopen( $file_to_open , "rb");
			$mySongs = '';
			$riga = 1;
			$totalDuration = 0;
			while (!feof($file_handle) ) {
				
				$line_of_text = fgets($file_handle);
				if ( trim ( $line_of_text ) != ''  ){
					$parts = explode('/', $line_of_text);
					if ( !empty ( $parts[count($parts)-1] ) ){
						
						$myFile = str_replace ( $this->config->item ( 'mp3_path' ) , '' , $line_of_text );
						$myMP3 = new MP3File ( trim($line_of_text) );
						$duration = $myMP3->getDurationEstimate();
						$t = round($duration);
	  					$duration = sprintf('%02d:%02d', ($t/60%60), $t%60);
						$myId3 = new ID3(trim($line_of_text));
						
							$id3Info = $parts[count($parts)-1];
							$id3['title'] =  "";
							$id3['artist'] =  "";
							$id3['genre'] =  "";
							$id3['album'] =  "";
							$album = '';
							if ( $myId3->getInfo() ){
								$id3['title'] =  preg_replace('/[^A-Za-z0-9\-\.\ ]/', '', $myId3->getTitle() );
								$id3['artist'] =  preg_replace('/[^A-Za-z0-9\-\.\ ]/', '', $myId3->getArtist() );
								$id3['genre'] =  preg_replace('/[^A-Za-z0-9\-\.\ ]/', '', $myId3->getGender() );
								$id3['album'] =  preg_replace('/[^A-Za-z0-9\-\.\ ]/', '', $myId3->getAlbum() );
								$id3Info = $id3['artist'] .' - '. $id3['title'] .' ('. $id3['genre'] .')';
							}
							
							$mySongURL = base_url().trim ( $this->config->item('mp3_url') ).'/'.trim($myFile);
							$mySongs =  $mySongs.'<tr id="row_'.$line_of_text.'">
							<td>
								<input type="checkbox" name="'.$myFile.'" class="check-song">
							
							</td>
						
							<td>' . $riga. '</td>
							<td>
							<button name="'.$mySongURL.'" class="btn btn-play-audio" song="'.$id3['artist'].' - '. $id3['title'].'"><span class="icon-play"></span></button>
							<img src="'. base_url() .'images/id3logo.png" class="btn-set-id3tag" name="'.$line_of_text.';'.$duration.';'.$riga.'">
							</td>
							<td><small>' .$parts[ count($parts)-2] .'<br>'.$parts[count($parts)-1].'</small></td>
							<td><small>' . $id3['album']. '</small></td>
							<td><small>'. $id3['artist'].' - '. $id3['title'] .'</small></td>
							<td><small>'.$duration.'</small></td>
							<td><small>'. $id3['genre'] .'</small></td>
							</tr>';
							$time = explode ( ':' , $duration );
							$m = $time[0];
							$s = $time[1];
							$duration =  ( $m*60 ) + $s;
						$totalDuration = $totalDuration + $duration;	
						$riga++;
					}
				}
			}
			$durationSeconds = $totalDuration;
			if ( $totalDuration < 3600 ){
				$totalDuration = gmdate ( "i' s" , $totalDuration ) .'s'; 
			} else {
				$totalDuration = gmdate ( "H i' s" , $totalDuration ). 's';
			}
			$data['nr'] = $riga-1;
			$data['songs'] = $mySongs;
			$data['duration'] = $totalDuration;
			fclose($file_handle);
			
			 
			$lines = $this->read_file_lines ( trim ( $this->config->item ( 'm3u_path' ) ) . 'duration.dat' );
			$updateLines = '';
			foreach ( $lines as $line ){
				
					$check = explode ( '|' , $line );
					$check = $check[0];
					
					if ( trim ( $check ) != trim ( $file ) ){
						$updateLines = $updateLines . $line . "\n";
					}
				
			}
			//echo $updateLines;
			$updateLines = $updateLines . $file . '|' . $durationSeconds;
			$file_handle = fopen ( trim ( $this->config->item ( 'm3u_path' ) ) . 'duration.dat' , "wb" ) ;
			fwrite ( $file_handle , $updateLines );
			fclose ( $file_handle );
		}
		return $data;
	}
	
	function playlist_duration (){
		$lines = $this->read_file_lines ( trim ( $this->config->item ( 'm3u_path' ) ) . 'duration.dat' );
		return $lines;
	}
	
	function mp3_list ( $array ){
		$mySongs = '';
		$riga = 0;
		foreach ( $array as $line ){
			$line_of_text = $line;
			$parts = explode('/', $line_of_text);
			if ( !empty ( $parts[count($parts)-1] ) ){
				
				$myFile = str_replace ( $this->config->item ( 'mp3_path' ) , '' , $line_of_text );
				$myMP3 = new MP3File ( trim ( $line_of_text ) );
				$duration = $myMP3->getDurationEstimate();
				$t = round($duration);
				$duration = sprintf('%02d:%02d', ($t/60%60), $t%60);
				$myId3 = new ID3(trim($line_of_text));
					$id3Info = $parts[count($parts)-1];
					$id3['title'] =  "";
					$id3['artist'] =  "";
					$id3['genre'] =  "";
					$id3['album'] =  "";
					$album = '';
					if ( $myId3->getInfo() ){
						$id3['title'] =  preg_replace('/[^A-Za-z0-9\-\.\ ]/', '', $myId3->getTitle() );
						$id3['artist'] =  preg_replace('/[^A-Za-z0-9\-\.\ ]/', '', $myId3->getArtist() );
						$id3['genre'] =  preg_replace('/[^A-Za-z0-9\-\.\ ]/', '', $myId3->getGender() );
						$id3['album'] =  preg_replace('/[^A-Za-z0-9\-\.\ ]/', '', $myId3->getAlbum() );
						$id3Info = $id3['artist'] .' - '. $id3['title'] .' ('. $id3['genre'] .')';
					}
					
					$mySongURL = base_url().trim ( $this->config->item('mp3_url') ).'/'.trim($myFile);
					$mySongs =  $mySongs.'<tr id="row_'.$line_of_text.'">
					<td>
						<input type="checkbox" name="'.$myFile.'" class="check-song">
					
					</td>
				
					<td>' . $riga. '</td>
					<td><button name="'.$mySongURL.'" class="btn btn-play-audio" song="'.$id3['artist'].' - '. $id3['title'].'" title="Listen now"><span class="icon-play"></span></button> <button class="btn btn-set-id3tag" name="'.$line_of_text.';'.$duration.';'.$riga.'" title="Set ID3 Tag"><img src="'.base_url().'images/id3logo.png" width="18"></button></td>
					<td><small>' .$parts[ count($parts)-2] .'<br>'.$parts[count($parts)-1].'</small></td>
					<td><small class"album_'.$riga.'">' . $id3['album']. '</small></td>
					<td><small class="song_'.$riga.'">'. $id3['artist'].' - '. $id3['title'] .'</small></td>
					<td><small>'.$duration.'</small></td>
					<td><small>'. $id3['genre'] .'</small></td>
					</tr>';
				$riga++;
			}
		}
		$data['nr'] = $riga-1;
		$data['songs'] = $mySongs;
		return $data;
	}

	function default_playlist_create(){
		$path = $this->config->item('audio_path');
		$m3u_path = $this->config->item ( 'm3u_path' );
		$m3u = $this->config->item('playlist');
		$results = exec ( "find $path -type d | sort > ".$path."folders.txt" );
		$results = exec ( "rm $m3u_path$m3u" );
		$results = exec ( "find $path -name '*.mp3' | sort > $m3u_path$m3u" );
		$file = explode ( '.' , $m3u );
		//$updateTable = $this->playlist($file[0]);
		//return $updateTable;
	}

	function id3_form (){
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
		return $id3_form;
	}
	
	function slots(){
		$files = glob( $this->config->item ( 'm3u_path'). '*.slot');
		return $files;
	}
	
	function slot ( $file ){
		$lines = [];
		$file_to_open = trim( $this->config->item('m3u_path').$file.'.slot' );
		$file_to_open = urldecode ( $file_to_open );
		if ( $file_to_open ){
		
			$file_handle = fopen( $file_to_open , "rb");
			$mySongs = '';
			$riga = 0;
			while (!feof($file_handle) ) {
				$line_of_text = fgets($file_handle);
				if ( substr ( $line_of_text , 0 , 1 ) != '#' ){
					$lines[$riga] = $line_of_text;
					$riga++;
				}
			}
		}
		return $lines;
	}
}