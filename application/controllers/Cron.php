<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	public function __Construct() {
		
		parent::__Construct();
		$this->load->model ( 'radio_model' );
		
	}
	
	public function index(){
	    $path = $this->config->item ( 'm3u_path' );
		$file = trim($path).'autodj.dat';
		$lines = $this->radio_model->read_file_lines ( trim($file) );
		$currPlaylist = $lines[0];
		$plan = $this->readPlan();
		echo $currPlaylist;
		if ( $plan != '' ){
			if ( trim($plan) != trim($currPlaylist) ){
				//echo "Switching playlist to " .$plan;
				$this->updateIgeneratorCfg ( $plan );
				
				//echo $currPlaylist . ' => ' . $plan;
				$pid = $this->radio_model->autodj_PID();
				$cmd = $this->config->item ( 'sudo' ).' kill -KILL '.$pid;
				$res = shell_exec ( $cmd );
				$msg =  "shutting down autodj (" . $pid . ")\n";
				$cfg = trim ( $this->config->item ( 'icegen_cfg' ) );
				$cmd = $this->config->item ( 'sudo' ).' '.$this->config->item ( 'icegen_path' ).' -f '.$cfg;
				$msg = $msg. "restarting autodj ... ( " . $cmd . " Playlist: " . $plan . ")";
				$res = shell_exec ( $cmd );	
				//mail ( 'swina.allen@gmail.com' , 'Icemood Cron Job Run' , $msg );	
			} else {
				//mail ( 'swina.allen@gmail.com' , 'Icemood Info' , "Cron job run" );
			}
			
		} else {
			
		}
		$this->autodj_log ( $plan );
	}
	
	public function readPlan(){
		$file = $this->config->item ( 'm3u_path' ) . 'planning.dat';
		//create current date and time following timezone settings (icegen_timezone)
		date_default_timezone_set ( $this->config->item ( 'icegen_timezone' ) );
		$currDate = date ( 'Y-m-d' );
		$currTime = date ( 'H:i' );
		echo $currDate . ' ' . $currTime . '<hr>';
		//create date time string to compare (ISO8601 format) YYYY-MM-DDTHH:MM
		$checkTime = $currDate . 'T' . $currTime;

		$lines = $this->radio_model->read_file_lines ( trim($file) , false );
		$indice = 0;
		$myPL = '';
		foreach ( $lines as $line ){
			if ( trim ( $line ) != '' ){
				$myTime = explode ( '|' , $line );
				$myTime = $myTime[2];
				$myDate = explode ( 'T' , $myTime );
				$myDate = $myDate[0];
				echo $checkTime . '=>' . $myTime . ' => ' . $line . '<br>';
				if ( trim ( $checkTime) < trim ( $myTime )  ){
					//echo $checkTime . '=>' . $myTime . ' => ' . $line . '<br>';
					$thisLine = $line;
					if ( $indice > 0 ){
						if ( $currDate < $myDate ){
							//echo $currDate . '=>' . $myDate . '<br>';
							$thisLine = $lines [ $indice-1 ]; 
						}
					} else {
						$thisLine = $lines [0];
					}
					$myPL = explode ( '|' , $thisLine ) ;
					$myPL = $myPL[1];
					
					//echo $line . '<br>' . $lines [ $indice-1 ] .'<hr>';
					return $myPL;
					exit;
				}
			}
			$indice++;
		}
		//print_r ( $alines );
		//return $currTime;
	}
	
	public function updateIgeneratorCfg ($pl){
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
		$data = $data. "\n" . "MP3PATH=" . $this->config->item ( 'icegen_type' ) . $this->config->item ( 'm3u_path') . $pl . '.m3u';
		$data = $data. "\n" . "GENRE=" . $this->config->item ( 'icegen_genre' );
		$data = $data. "\n" . "DESCRIPTION=" . $this->config->item ( 'icegen_description' );
		$data = $data. "\n" . "URL=" . $this->config->item ( 'streaming' ) . $this->config->item ( 'icegen_mount' );
		
		//$fp = fopen($this->config->item ( 'm3u_path') . "autodj.cfg","wb");
		$fp = fopen($this->config->item ( 'icegen_cfg') ,"wb");
		fwrite($fp,$data);
		fclose($fp);
		echo $this->config->item ( 'icegen_cfg');
		$fp = fopen($this->config->item ( 'm3u_path') . "autodj.dat","wb");
		fwrite ( $fp , $pl );
		fclose ( $fp );
	}
	
	public function readSlot ( $file ){
		$slots = $this->radio_model->read_file_lines ( trim ( $this->config->item ( 'm3u_path' ) ) . trim($file) );
		$currTime = date ( 'Hi' );
		//echo '<br>';
		foreach ( $slots as $slot ){
			$array = explode ( '|' , $slot );
			$startTime = $array[0];
			$playlist = $array[1];
			$endTime = $array[2];
			$endTime = str_replace ( ':' , '' , $endTime );
			//echo intval ( $currTime ) . '=>' . intval ( $endTime ) . '<br>';
			if ( $currTime < $endTime ){
				return $playlist;
				//echo '<hr>Play : ' . $playlist . '<br>';
			}
		}
	}
	
	public function autodj_log ( $pl ){
		//create current date and time;
		$currDate = date ( 'Y-m-d' );
		$currTime = date ( 'H:i' );
		//create date time string to compare (ISO8601 format) YYYY-MM-DDTHH:MM
		$checkTime = $currDate . 'T' . $currTime;
		$currentLog = file_get_contents ( trim ( $this->config->item ( 'm3u_path' ) ) . 'autodj.log' );
		file_put_contents ( trim ( $this->config->item ( 'm3u_path' ) ) . 'autodj.log' ,  $currentLog . "\n" . $checkTime . '=>' . $pl  );
		
	}
	
	public function update_autodj ( $array , $playlist ){
		$n = 0;
		$data = '';
		foreach ( $array as $line ){
		    if ( !empty ($line) ){
				$currDate = date ( 'Ymd' );
				$a = explode ( '|' , $line );
				//print_r ( $a );
				$dt = $a[0];
				$slot = $a[1] ;
				if ( $currDate == $dt ){
					$array [ $n ] = $currDate . '|' . $slot . '|' . $playlist; 
				}
				$data = $data . $array[ $n ] . "\n"; 
				$n++;
			}
		}
		file_put_contents ( trim ( $this->config->item ( 'm3u_path' ) ) . 'autodj.dat' , $data );
		
	}
}