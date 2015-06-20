 <?php

class Mp3_Model extends CI_Model {
	
	function __construct(){
	 	parent::__construct();
	   	$this->load->library('zend');
		$this->zend->load('Zend/Media/Id3v2');
	}
	
	function mp3_tag_read ( $file ){
		$id3 = new Zend_Media_Id3v2( trim($file ) );
		$id3info = array();
		foreach ($id3->getFramesByIdentifier("T*") as $frame)
			$id3info[$frame->identifier] = $frame->text;
		return $id3info;
	}
	
	function mp3_tag_write ( $file , $tag ){
		$id3 = new Zend_Media_Id3v2( trim ( $file ) );
		$id3->tit2->text = $tag['title'];
		$id3->talb->text = $tag['album'];
		$id3->tyer->text = $tag['year'];
		$id3->tpub->text = $tag['publisher'];
		$id3->tpe1->text = $tag['artist'];
		$id3->tpe2->text = $tag['band'];
		$id3->tcon->text = $tag['genre'];
		$id3->trck->text = $tag['track'];
		$id3->tlen->text = $tag['duration'];
		$id3->write(null);
		return true;
	}
}
