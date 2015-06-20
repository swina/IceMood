<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Plan extends CI_Controller {

	public function __Construct() {
		
		parent::__Construct();
		$this->load->model ( 'radio_model' );
		
	}
	
	public function index(){
	    $path = $this->config->item ( 'm3u_path' );
		$file = trim($path).'planning.dat';
		$lines = $this->radio_model->read_file_lines ( trim($file) );
		$currDate = date ( 'Ymd' );
		$currTime = date ( 'Hi' );
		$found = false;
		
		$indice = 0;
		$events = [];
		
		foreach ( $lines as $line ){
			if ( $line != '' ){
				$array = explode ( '|' , $line );
				$events[$indice]['start'] = $array[0];
				$events[$indice]['title'] = $array[1];
				$events[$indice]['end'] = trim($array[2]);
				$events[$indice]['allDay'] = false;
				$indice++;
			}
		}
		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		echo json_encode ( $events );
		//set the 3rd param to true to make it return data 
		//$theHTMLResponse    = $this->load->view('/admin/ajax.php', null, true);

		//$this->output->set_content_type('application/json');
		//$this->output->set_output(json_encode(array('events'=> $theHTMLResponse)));
	}
}
