<?php

/*******************************************************************
* icecast.class.php
* Version: 0.1
* Author: Tyler Winfield
* Copyright (C) 2009, Tyler Winfield
* twinfield@rionet.ca
* http://rionet.ca/
*
* Simple PHP object class for allowing simple communication with
* Icecast stream servers. Currently this class only supports single
* stream servers, if multiple streams are running data provided will
* be that of the first stream returned in the stats XML
*
*     EXAMPLE
*
* $i = new IceCast();
* $i->host = 'http://streamipordomain.com/';
* $i->port = '8000'; //port stream is broadcast on
* $i->passwd = 'adminPa$$'; //streams admin password for stats access
* 
* if($i->openstats()) {
*    if($i->getStreamStatus()) {
*       //stream is online and information loaded
*    } else {
*       //stream is offline
*    }
* } else {
*    //server could not be connected to or is offline
* }
*
*******************************************************************
This program is free software; you can redistribute it and/or modify it
under the terms of the GNU General Public License as published by the
Free Software Foundation; either version 2 of the License, or (at your
option) any later version.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
*******************************************************************/

class IceCast {
   // Public
   var $host;
   var $port;
   var $usernm;
   var $passwd;
   
   //Private
   var $_xml;
   var $_error;
   
   function openstats() {
      $fp = fopen("http://admin:".$this->passwd."@".$this->host.":".$this->port."/admin/stats", "r");
      if (!$fp) {
         $this->_error = "$errstr ($errno)";
         return(0);
      } else {
          while (!feof($fp)) {
               $this->_xml .= fgets($fp, 512);
          }
          fclose($fp);

         if(!isset($this->_xml)) {
            $this->_error = "Bad login";
            return(0);
         }
         
         $xmlparser = xml_parser_create();
         if (!xml_parse_into_struct($xmlparser, $this->_xml, $this->_values, $this->_indexes)) {
            $this->_error = "Unparsable XML";
            return(0);
         }
   
         xml_parser_free($xmlparser);

         return(1);
      }
   }
   
   function getCurrentListenersCount() {
      return($this->_values[$this->_indexes["LISTENERS"][0]]["value"]);
   }

   function getPeakListenersCount() {
      return($this->_values[$this->_indexes["LISTENER_PEAK"][0]]["value"]);
   }

   function getMaxListenersCount() {
      return($this->_values[$this->_indexes["MAX_LISTENERS"][0]]["value"]);
   }
   
   function getServerGenre() {
      return($this->_values[$this->_indexes["GENRE"][0]]["value"]);
   }
   
   function getServerURL() {
      return($this->_values[$this->_indexes["SERVER_URL"][0]]["value"]);
   }
   
   function getServerTitle() {
      return($this->_values[$this->_indexes["SERVER_NAME"][0]]["value"]);
   }
   
   function getCurrentSongTitle() {
      return($this->_values[$this->_indexes["TITLE"][0]]["value"]);
   }
      
   function getStreamHitsCount() {
      return($this->_values[$this->_indexes["CLIENT_CONNECTIONS"][0]]["value"]);
   }
   
   function getStreamStatus() {
      return($this->_values[$this->_indexes["STREAM_START"][0]]["value"]);
   }
   
   function getBitRate() {
      return($this->_values[$this->_indexes["BITRATE"][0]]["value"]);
   }
   
   function getSongHistory() {
      for($i=1;$i<sizeof($this->_indexes['TITLE']);$i++) {
         $arrhistory[$i-1] = array(
                           "playedat"=>$this->_values[$this->_indexes['PLAYEDAT'][$i]]['value'],
                           "title"=>$this->_values[$this->_indexes['TITLE'][$i]]['value']
                        );
      }

      return($arrhistory);
   }
   
   function geterror() { return($this->_error); }
}

?>