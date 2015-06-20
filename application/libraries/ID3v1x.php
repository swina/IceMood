<?php
/*
  This Class was made by Fatih Hood.
  v1.0 :: 28 - December - 2003
  May the FORCE be with us!
  www.zeb.biz : www.zebwars.org
  Email: zw@NOSPAM.zeb.biz
*/

//--- ID3v1.x Read/Write Class ---/
class ID3v1x {
  var $file_name;

  //--- Tag Vars.
  var $tag;
  var $title;
  var $artist;
  var $album;
  var $year;
  var $comm;
  var $track;
  var $genre;

  function ID3v1x($inputfile) {
    $this->file_name = $inputfile;
  }

  //--- ID3v1.x Read Tag Function
  function read_tag() {
    $file = fopen($this->file_name, "rb");
    if($file == false) {
      return false;
    }
    else {
      fseek($file, -128, SEEK_END);
      $this->tag = fgets($file, 4);
      if($this->tag == 'TAG') {
        $this->title = fgets($file, 31);
        $this->artist = fgets($file, 31);
        $this->album = fgets($file, 31);
        $this->year = fgets($file, 5);
        $this->comm = fgets($file, 29);
        $this->temp = fgets($file, 2);
        $this->track = fgets($file, 2);
        $this->track = hexdec(bin2hex($this->track));
        $this->genre = fgets($file, 2);
        $this->genre = hexdec(bin2hex($this->genre));
        $genre_list = array("Blues","ClassicRock","Country","Dance","Disco","Funk","Grunge","HipHop","Jazz",
          "Metal","NewAge","Oldies","Other","Pop","R&B","Rap","Reggae","Rock","Techno",
          "Industrial","Alternative","Ska","DeathMetal","Pranks","Soundtrack","Euro-Techno",
          "Ambient","TripHop","Vocal","Jazz-Funk","Fusion","Trance","Classical","Instrumental",
          "Acid", "House", "Game", "SoundClip", "Gospel", "Noise", "Alt.Rock", "Bass", "Soul", "Punk",
          "Space", "Meditative", "InstrumentalPop", "InstrumentalRock", "Ethnic", "Gothic", "Darkwave",
          "Techno-Industrial", "Electronic", "Pop/Folk", "Eurodance", "Dream", "SouthernRock", "Comedy",
          "Cult", "GangstaRap", "Top40", "ChristianRap", "Pop/Funk", "Jungle", "NativeAmerican", "Cabaret",
          "NewWave", "Psychedelic", "Rave", "Showtunes", "Trailer", "Lo-fi", "Tribal", "AcidPunk",
          "AcidJazz", "Polka", "Retro", "Musical", "Rock'n'Roll", "HardRock", "Folk", "Folk/Rock",
          "NationalFolk","Swing", "FastFusion", "Bebob", "Latin", "Revival", "Celtic", "BlueGrass",
          "AvantGarde", "GothicRock", "ProgressiveRock", "PsychedelicRock", "SymphonicRock",
          "SlowRock", "BigBand", "Chorus", "EasyListening", "Acoustic", "Humour", "Speech", "Chanson",
          "Opera", "ChamberMusic", "Sonata", "Symphony", "BootyBass", "Primus", "PornGroove", "Satire",
          "SlowJam", "Club", "Tango", "Samba", "Folklore", "Ballad", "PowerBallad", "RhythmicSoul",
          "Freestyle", "Duet", "PunkRock", "DrumSolo", "Euro-House", "DanceHall", "Goa", "Drum&Bass",
          "Club-House", "Hardcore", "Terror", "Indie", "BritPop", "Negerpunk", "PolskPunk", "Beat",
          "ChristianGangstaRap", "HeavyMetal", "BlackMetal", "Crossover", "ContemporaryChristian",
          "ChristianRock", "Merengue", "Salsa", "ThrashMetal","Anime","JPop","SynthPop");
        $this->genre = @$genre_list[$this->genre];
        return true;
      }
      else {
        $this->tag = 'Not found tag informations!';
        return true;
      }
    }
    fclose($file);
  }
  //--- End : ID3v1.x Read Tag Function

  //--- ID3v1.x Write Tag Function
  function write_tag($tip=1, $wtitle, $wartist, $walbum, $wyear, $wcomm, $wtrack, $wgenre) {
    $file = fopen($this->file_name, "r+b");
    if($file == false) {
      return false;
    }
    else {
      if($tip == 1) {
        fseek($file, -128, SEEK_END);
        fputs($file, 'TAG', 3);
        fputs($file, str_pad($wtitle, 30), 30);
        fputs($file, str_pad($wartist, 30), 30);
        fputs($file, str_pad($walbum, 30), 30);
        fputs($file, str_pad($wyear, 4), 4);
        fputs($file, str_pad($wcomm, 28), 28);
        fputs($file, str_pad(chr('null'), 1), 1);
        fputs($file, str_pad(chr($wtrack), 1), 1);
        fputs($file, str_pad(chr($wgenre), 1), 1);
        return true;
      }
      else if($tip == 2) {
        fseek($file, -128, SEEK_END);
        $empty = chr('null') . chr('null') . chr('null');
        fputs($file, $empty, 3);
        return true;
      }
    }
    fclose($file);
  }
  //--- End : ID3v1.x Write Tag Function
}

//--- ID3v1.x Read/Write Class ---/

//--- Example ---//

$mp3_file = "Baris Manco - Hal Hal.mp3";

$ID3 = new ID3v1x($mp3_file);

if($ID3->write_tag(1, "Title Test", "Artist Test", "Album Test", "2003", "Fatih Hood Test", "2", "13") == true) {
  echo "Successful!";
}
else {
  echo "Error!";
}

echo "<hr size=\"1\">";

if($ID3->read_tag() == true) {
  echo "-] : File : $mp3_file<br>";
  echo "-] : ----------------------------------<br>";
  echo "-] : ID3v1 : $ID3->tag<br>";
  echo "-] : Title : $ID3->title<br>";
  echo "-] : Artist : $ID3->artist<br>";
  echo "-] : Album : $ID3->album<br>";
  echo "-] : Year : $ID3->year<br>";
  echo "-] : Comment : $ID3->comm<br>";
  echo "-] : Track : $ID3->track<br>";
  echo "-] : Genre : $ID3->genre<br>";
  echo "-] : ----------------------------------<br>";
}
else {
  echo "Error!";
}

//--- Example ---//
?>
