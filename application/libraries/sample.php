<?php
    require('error.inc.php');
    require('id3.class.php');
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
?>
