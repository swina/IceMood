<?php
$config["streaming"] = "http://your_icecast_streaming_url:port";
$config["streaming_json"] = "status-json.xsl";

$config["sudo"] = "/usr/bin/sudo -u root";
$config["mp3_url"] = "audio/mp3";
$config["audio_path"] = FCPATH."audio/mp3/"; 
$config["m3u_path"] = FCPATH."audio/playlists/";
$config["playlist"] = "songlist.m3u";
$config["mp3_path"] = FCPATH."audio/mp3/";
$config["mp3_trash"] = FCPATH."audio/trash/";

//icegenerator general settings for icegenerator .cfg files
$config["icecast_path"] = "/usr/bin/icecast";
$config["icecast_xml"] = "/etc/icecast2/icecast.xml";
$config["icecast_log"] = "/usr/var/log/icecast/actions.log";
$config["icegenerator"] = "1";
$config["icegen_path"] = "/usr/local/bin/icegenerator";
$config["icegen_cfg"] = "/root/icegenerator/autodj.cfg";
$config["icegen_log"] = "/root/icegenerator/radio.log";

//email settings
$config["icemood_email"] = "your email";
