<?php
/***********************************************************
* Class:       ID3
* Version:     1.0
* Date:        Janeiro 2004
* Author:      Tadeu F. Oliveira
* Contact:     tadeu_fo@yahoo.com.br
* Use:         Extract ID3 Tag information from mp3 files
***********************************************************
Exemple

    require('error.inc.php');
    $nome_arq  = 'Blind Guardian - Bright Eyes.mp3';
	 $myId3 = new ID3($nome_arq);
	 if ($myId3->getInfo()){
         echo('<HTML>');
         echo('<a href= "'.$nome_arq.'">Clique para baixar: </a><br>');
         echo('<table border=1>
               <tr>
                  <td><strong>Artista</strong></td>
                  <td><strong>Titulo</strong></font></div></td>
                  <td><strong>Trilha</strong></font></div></td>
                  <td><strong>Album/Ano</strong></font></div></td>
                  <td><strong>G&ecirc;nero</strong></font></div></td>
                  <td><strong>Coment&aacute;rios</strong></font></div></td>
               </tr>
               <tr>
                  <td>'. $myId3->getArtist() . '&nbsp</td>
                  <td>'. $myId3->getTitle()  . '&nbsp</td>
                  <td>'. $myId3->getTrack()  . '&nbsp</td>
                  <td>'. $myId3->getAlbum()  . '/'.$myId3->getYear().'&nbsp</td>
                  <td>'. $myId3->getGender() . '&nbsp</td>
                  <td>'. $myId3->tags['COMM']. '&nbsp</td>
               </tr>
            </table>');
         echo('</HTML>');
   	}else{
    	echo($errors[$myId3->last_error_num]);
   }

*/


class ID3{

   var $file_name=''; //full path to the file
   					  //the sugestion is that this path should be a
                      //relative path
   var $tags;   //array with ID3 tags extracted from the file
   var $last_error_num=0; //keep the number of the last error ocurred
   var $tags_count = 0; // the number of elements at the tags array
   /*********************/
   /**private functions**/
   /*********************/

   function hex2bin($data) {
   //thankz for the one who wrote this function
   //If iknew your name I would say it here
      $len = strlen($data);
      for($i=0;$i<$len;$i+=2) {
         $newdata .= pack("C",hexdec(substr($data,$i,2)));
      }
   return $newdata;
   }
   
   function get_frame_size($fourBytes){
      $tamanho[0] = str_pad(base_convert(substr($fourBytes,0,2),16,2),7,0,STR_PAD_LEFT);
      $tamanho[1] = str_pad(base_convert(substr($fourBytes,2,2),16,2),7,0,STR_PAD_LEFT);
      $tamanho[2] = str_pad(base_convert(substr($fourBytes,4,2),16,2),7,0,STR_PAD_LEFT);
      $tamanho[3] = str_pad(base_convert(substr($fourBytes,6,2),16,2),7,0,STR_PAD_LEFT);
      $total =    $tamanho[0].$tamanho[1].$tamanho[2].$tamanho[3];
      $tamanho[0] = substr($total,0,8);
      $tamanho[1] = substr($total,8,8);
      $tamanho[2] = substr($total,16,8);
      $tamanho[3] = substr($total,24,8);
      $total =    $tamanho[0].$tamanho[1].$tamanho[2].$tamanho[3];
		$total = base_convert($total,2,10);
   	return $total;
	}
	
   function extractTags($text,&$tags){
      $size = -1;//inicializando diferente de zero para não sair do while
   	while ((strlen($text) != 0) and ($size != 0)){
      //while there are tags to read and they have a meaning
   	//while existem tags a serem tratadas e essas tags tem conteudo
			$ID    = substr($text,0,4);
      	$aux   = substr($text,4,4);
         $aux   = bin2hex($aux);
         $size  = $this->get_frame_size($aux);
         $flags = substr($text,8,2);
         $info  = substr($text,11,$size-1);
         if ($size != 0){
            $tags[$ID] = $info;
            $this->tags_count++;
         }
         $text = substr($text,10+$size,strlen($text));
   	}
   }
   
   /********************/
   /**public functions**/
   /********************/
   /**Constructor**/

   function ID3($file_name){
      $this->file_name = $file_name;
      $this->last_error_num = 0;
   }
   
   /**Read the file and put the TAGS
   content on $this->tags array**/
   function getInfo(){
		if ($this->file_name != ''){
			$mp3 = @fopen($this->file_name,"r");
       	$header = @fread($mp3,10);
         if (!$header) {
         	$this->last_error_num = 2;
            return false;
            die();
         }
       	if (substr($header,0,3) != "ID3"){
         	$this->last_error_num = 3;
            return false;
          	die();
       	}
       	$header = bin2hex($header);
   		$version = base_convert(substr($header,6,2),16,10).".".base_convert(substr($header,8,2),16,10);
   		$flags = base_convert(substr($header,10,2),16,2);
   		$flags = str_pad($flags,8,0,STR_PAD_LEFT);
   		if ($flags[7] == 1){
   			//echo('with Unsynchronisation<br>');
   		}
   		if ($flags[6] == 1){
   			//echo('with Extended header<br>');
   		}
   		if ($flags[5] == 1){//Esperimental tag
            $this->last_error_num = 4;
            return false;
          	die();
   		}
   		$total = $this->get_frame_size(substr($header,12,8));
         $text = @fread($mp3,$total);
   		fclose($mp3);
         $this->extractTags($text,$this->tags);
      }
      else{
         $this->last_error_num = 1;//file not set
         return false;
      	die();
      }
   	return true;
   }
   
   /*************
   *   PUBLIC
   * Functions to get information
   * from the ID3 tag
   **************/
   function getArtist(){
      if (array_key_exists('TPE1',$this->tags)){
      	return $this->tags['TPE1'];
      }else{
      	$this->last_error_num = 5;
         return false;
      }
   }
   
   function getTrack(){
      if (array_key_exists('TRCK',$this->tags)){
      	return $this->tags['TRCK'];
      }else{
      	$this->last_error_num = 5;
         return false;
      }
   }
   
   function getTitle(){
      if (array_key_exists('TIT2',$this->tags)){
      	return $this->tags['TIT2'];
      }else{
      	$this->last_error_num = 5;
         return false;
      }
   }
   
   function getAlbum(){
      if (array_key_exists('TALB',$this->tags)){
      	return $this->tags['TALB'];
      }else{
      	$this->last_error_num = 5;
         return false;
      }
   }
   
   function getYear(){
      if (array_key_exists('TYER',$this->tags)){
      	return $this->tags['TYER'];
      }else{
      	$this->last_error_num = 5;
         return false;
      }
   }
   
   function getGender(){
      if (array_key_exists('TCON',$this->tags)){
      	return $this->tags['TCON'];
      }else{
      	$this->last_error_num = 5;
         return false;
      }
   }
   
}
?>
