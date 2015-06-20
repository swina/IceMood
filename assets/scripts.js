location.origin = location.protocol + "//" + location.host;
var host = location.origin;
var current_menu = $('.current_menu').val();
$('#menu_' + current_menu).addClass ( 'active' );

var timerSave;

function reloadPage(){
	location.reload();
}

//clear saved info and stops timer timerSave
	function clearSaved (){
		$('.saved').html ('');
		window.clearInterval ( timerSave );		
	}


	//--- planning save data
	function planner_save_events(){
		var events = $('#calendar').fullCalendar('clientEvents') ;
		events = events.sort();
		var planning = new Array(1);
		$('#working').show();
		for ( var i=0 ; i < events.length ; i++ ){
			
			//console.log ( events[i]['title'] );
			var dstart  = new Date ( events[i]['start'] );
			var d = ISO8601 ( dstart , '-' , ':' );
			var startDate = d['date'];
			var start = d['date'] + 'T' + d['time'] ;
			
			d = new Date ( events[i]['end'] - 60000 ); //important subtract 1 minute from end time
			
			var anno = d.getFullYear() ;
			
			if ( anno == 1970 ){
				var newDate = new Date ( dstart.getHours() + 2 );
				var h = dstart.getHours() + 2;
				if ( h < 10 ){
					h = '0' + h;
				}
				
				var m = dstart.getMinutes();
				if ( m < 59 ){
					if ( m < 29 ){
						m = 29;
					} else {
						m = 59;
					}
				}
				
				if ( m < 10 ){
					m = '0' + m;
				}
				
				var end = startDate + 'T' + h + ':' + m ;
			} else {
							
				//console.log ( d.getMinutes() );
				d = ISO8601 ( d , '-' , ':' );
				var nm = d['time'].split (':');
				var hm = nm[0];
				var nm = nm[1];
				if ( nm < 59 ){
					if ( nm < 29 ){
						nm = 29;
					} else {
						nm = 59;
					}
				}
				d['time'] = hm + ':' + nm;
				var end = d['date'] + 'T' + d['time'];
				
			}
			planning[i] = start + '|' + events[i]['title'] + '|' + end;
			//console.log ( start + '|' + events[i]['title'] + '|' + end );
		}
		//save planning	
			
		$.post ( host + 'ajax/plannersave' ,
			{
				planning: planning.sort()		
			},
			function ( result ) {
				$('#working').hide();
				$('.saved').html ( '<span class="badge badge-success">Planning saved!</span> ' );
				timerSave = setInterval(function () {clearSaved()}, 2000);
			}
		);
	}
	//--- /planning save data 
	
	// ISO8601
	// param: d = date , sepd = date separator , sept = time separator
	// return an ISO8601 date format 
	function ISO8601( d , sepd , sept ){
		var year = d.getFullYear();
		var month = d.getMonth();
		var day = d.getDate();
		var hours =  d.getHours();
		var mins = d.getMinutes();
		month = parseInt ( month ) + 1;
		if ( month < 10 ){
			month = '0' + month;
		}
		if ( day < 10 ){
			day = '0' + day;
		}
		if ( hours < 10 ){
			hours = '0' + hours;
		}
		if ( mins < 10 ){
			mins = '0' + mins;
		}
		var string = year + sepd + month + sepd + day + hours + sept + mins;
		var a = new Array(1);
		a['date'] = year + sepd + month + sepd + day;
		a['time'] = hours + sept + mins;
		return a;
	}
	//--- / ISO8601 

$(function() {

	

    // Side Bar Toggle
    $('.hide-sidebar').click(function() {
	  $('#sidebar').hide('fast', function() {
	  	$('#content').removeClass('span9');
	  	$('#content').addClass('span12');
	  	$('.hide-sidebar').hide();
	  	$('.show-sidebar').show();
	  });
	});

	$('.show-sidebar').click(function() {
		$('#content').removeClass('span12');
	   	$('#content').addClass('span9');
	   	$('.show-sidebar').hide();
	   	$('.hide-sidebar').show();
	  	$('#sidebar').show('fast');
	});
	
	
	$('.btn-icecast-off').click ( function() {
		$.post ( host + 'ajax/icecast',
					{ 	
						switch	: 0	,
						pid		: $(this).attr('name')
					},
				function result(result){
					
					location.reload();
					
				}
		);
	});
	
	$('.btn-icecast-off-cancel').click ( function(){
		$('.server-swtich').bootstrapSwitch('state', true, true);
	});
	
	$('.btn-icecast-on').click ( function() {
		$.post ( host + 'ajax/icecast',
					{ 	
						switch	: 1	,
						pid		: $(this).attr('name')
					},
				function result(result){
					location.reload();
					
				}
		);
	});
	
	$('.btn-icecast-on-autodj').click ( function() {
		$.post ( host + 'ajax/icecast',
					{ 	
						switch	: 1	,
						pid		: $(this).attr('name')
					},
				function result(result){
					autoDJ();				
				}
		);
	});

	function autoDJ (){
		$.post ( host + 'ajax/autodj',
					{ 	
						switch	: 1	,
						pid		: 0
					},
				function result(result){
					console.log ( result );
					location.reload();
					
				}
		);
	}
	
	$('.btn-autodj-off').click ( function() {
		$.post ( host + 'ajax/autodj',
					{ 	
						switch	: 0	,
						pid		: $(this).attr('name')
					},
				function result(result){
					console.log ( result );
					location.reload();
					
				}
		);
	});
	
	$('.btn-autodj-on').click ( function() {
		$.post ( host + 'ajax/autodj',
					{ 	
						switch	: 1	,
						pid		: $(this).attr('name')
					},
				function result(result){
					console.log ( result );
					location.reload();
					
				}
		);
	});
	
		$('.server-switch').bootstrapSwitch({
		onColor: 'success'	,
		offColor: 'danger'
		}
	);
	
	$('.server-switch').on('switchChange.bootstrapSwitch', function(event, state) {
		
		$status = 1;
		$pid = 0;
		if ( !state ) {
			$status = 0;
			$pid = $('.icecast-pid').val();
		} 
		$.post ( host + 'ajax/icecast',
					{ 	
						switch	: $status	,
						pid		: $pid
					},
				function result(result){
					autoDJ();				
				}
		);
	});
	
	$('.autodj-switch').on('switchChange.bootstrapSwitch', function(event, state) {
		console.log(this); // DOM element
  		console.log(event); // jQuery event
  		console.log(state); // true | false
		$status = 1;
		$pid = 0;
		if ( !state ) {
			$status = 0;
			$pid = $('.autodj-pid').val();
		} 
		
		$.post ( host + 'ajax/autodj',
					{ 	
						switch	: $status	,
						pid		: $pid
					},
				function result(result){
					console.log ( result );
					location.reload();				
				}
		);
		
	});

	$('.autodj-switch').bootstrapSwitch({
			onColor: 'success',
			offColor: 'danger'
		}
	);
	
	/*
	$('.check-select-all-songs').click(function(event) { 
		
    	if($(this).is ( ':checked' )) {
	       	// Iterate each checkbox
       	 	$('#example2 input[type="checkbox"]').each(function() {
            	this.checked = true;                        
        	});

    	} else {
			$('#example2 input[type="checkbox"]').each(function() {
            	this.checked = false;                        
        	});
		}
	});
	/*
	$('.select-all-songs').change ( function(){
		if($(this).checked) {
	       	// Iterate each checkbox
       	 	$('#example2 input[type="checkbox"]').each(function() {
            	this.checked = true;                        
        	});

    	} else {
			$('#example2 input[type="checkbox"]').each(function() {
            	this.checked = false;                        
        	});
		}
	});
	*/
	$('.btn-select-all-songs').click(function(event) { 
		var status; 
    	if($('.check-select-all-songs').is ( ':checked' )) {
			$('#example2 input[type="checkbox"]').each(function() {
            	this.checked = false;                        
        	});
			status = false;			
    	} else {
			status = true;			
	       	// Iterate each checkbox
       	 	$('#example2 input[type="checkbox"]').each(function() {
            	this.checked = true;                        
        	});
		}
		$('.check-select-all-songs').prop ( 'checked' , status );

	});
	
	$('.playlist-select').change ( function(){
		var file = $(this).val();
		file = file.split ('.');
		document.location = host + 'dashboard/playlists/' + decodeURI(file[0]);
	});
	
	$('.slot-select').change ( function(){
		var file = $(this).val();
		file = file.split ('.');
		document.location = host + 'dashboard/slots/' + decodeURI(file[0]);
	});
	
	$('.slot-save').click ( function(){
		save_current_slot();
	});
	
	$('.select-slot-playlist').change ( function() {
		save_current_slot($(this));
		
	});
	
	function save_current_slot(obj){
		var options = $('.select-slot-playlist option:selected');
		var values = $.map(options ,function(option) {
    		return option.value;
		});
		var slot = $('.slot-select').val();
		$('.working').show();
		$.post ( host + 'ajax/slotsave' ,
				{
					slot : slot,
					slots: values
				},
				function ( result ){
					$('.working').hide();
					if ( result != 'OK' ){
						alert ( result );
						obj.prop('selectedIndex', 0);
						save_current_slot();
					}
				}
		);
	}
		
	$('.btn-create-slot').click ( function(){
		var slot = $('.new-slot-name').val();
		
		$.post ( host + 'ajax/slotcreate' ,
				{
					slot: slot
				},
				function ( result ){
					$('.working').hide();
					alert ( result );
				}
		);
	});
	
	$('.folder-select').change ( function(){
		$('.currentfolder').html ( $('.folders').val() );
		var folder = $('.folder-select option:selected').text();
		document.location = host + 'dashboard/storage/' + folder ;
		
	});
	
	$('.btn-setup-save').click ( function() {
		$.ajax
			({ type: "POST",  
    		url:host + "ajax/setupsave",  
		    data:{
				sudo :	$('.sudo').val(),
				icecast_path: $('.icecast_path').val(),
				icecast_xml: $('.icecast_xml').val(),
				icecast_log: $('.icecast_log').val(),
				icegen_path: $('.icegenerator_path').val(),
				icegen_cfg: $('.icegen_cfg').val(),
				icegen_log: $('.icegen_log').val(),
				audio_path: $('.storage_path').val(),
				playlist: $('.playlist').val(),
				streaming: $('.streaming').val()
				},
		    dataType:'json',

		    beforeSend: function()
		    {
			},
		    success: function(resp)
    		{  
		        alert(resp);

    		}, 
		    complete: function()
		    {		
		    },
		    error: function(e)
		    {  
        		alert('Error: ' + e); 
		    }  
		
		});
	});
	
	//--- 
	//storage functions
	//---
	
	//--- view upload panel (dropzone)
	$('.btn-view-upload').click ( function() {
		$('#upload-panel').removeClass ( 'hide' );
	});
	//--- /view upload panel
	
	//--- add files 
	$('.btn-add-files').click ( function () {
		$('#previews').removeClass('hide');
	});
	//--- /add files
	
	//--- select folder 
	$('.btn-whichfolder').click ( function() {
		$('.currentfolder').html ( $('.folders').val() );
		$.post ( host + 'ajax/uploadfolder' ,
			{
				folder: $('.folders').val()
			}
		);
	});
	//--- /select folder
	
	//--- create folder
	$('.btn-folder-create').click ( function(){
		var newFolder = $('.folders').val() 
		if ( newFolder == '' ){ 
			newFolder =  $('.newfolder').val(); 
		} else {
			newFolder =  newFolder + '/' + $('.newfolder').val(); 
		}
		$('.currentfolder').html ( $('.folders').val() );
		alert ( newFolder );
		
		$.post ( host + 'ajax/createfolder' ,
			{
				folder: newFolder
			},
			function (result){
				$('.folder-has-been-created').html ( result );
				$('#reloadPage').modal ( 'show' );
			}
		);
		
	});
	//--- /create folder
	
	//--- move to trash tools menu selection
	$('.tools-move-to-trash').click ( function () {
		var checkedValues = $('input:checkbox:checked').map(function() {
    		return this.name;
		}).get();
		if ( checkedValues.length > 0 ){
			$.post ( host + 'ajax/delete_files' ,
				{
					action: 'trash',
					file: checkedValues
				} ,
				function result ( result ) {
					$('.files-have-been-deleted').html ( result );
					$('#reloadPage').modal ( 'show' );
				}
			);
		} else {
			alert ( "Any file has been selected. Nothing to move to trash" );
		}
	});
	//--- /move to trash tools menu selection
	
	
	//--- edit id3 tag 
	$('.btn-set-id3tag').click ( function(){
		var a = $(this).attr ( 'name' ).split(';');
		var mp3 = a[0];
		var m = a[1];
		var f = mp3.split('/');
		f = f[f.length-1];
		$('.mp3_file').html ( f );
		$('.mp3_file_path').val ( mp3 );
		$.post ( host + 'ajax/id3read' ,
			{
				mp3: mp3
			},
			function ( result ){
				if ( result != '0' ){
					var jsonData = JSON.parse(result);
					$('.id3_TIT2').val ( jsonData['TIT2'] );
					$('.id3_TALB').val ( jsonData['TALB'] );
					$('.id3_TPE1').val ( jsonData['TPE1'] );
					$('.id3_TPE2').val ( jsonData['TPE2'] );
					$('.id3_TYER').val ( jsonData['TYER'] );
					$('.id3_TRCK').val ( jsonData['TRCK'] );
					$('.id3_TPUB').val ( jsonData['TPUB'] );
					$('.id3_TCON').val ( jsonData['TCON'] );
				}
				$('.id3_TLEN').val ( m );
			}
		);	
		$('#id3tag').modal ( 'show' );
	});
	//--- /edit i3 tag
	
	//--- save id3 tag 
	$('.btn-save-id3tag').click ( function(){
		var checkedValues = $('input:checkbox:checked').map(function() {
    		return this.name;
		}).get();
		$.post ( host + 'ajax/id3save' ,
			{
				title: $('.id3_TIT2').val (),
				album: $('.id3_TALB').val (),
				artist:$('.id3_TPE1').val (),
				band: $('.id3_TPE2').val (),
				year: $('.id3_TYER').val (),
				track: $('.id3_TRCK').val (),
				publisher: $('.id3_TPUB').val (),
				genre: $('.id3_TCON').val (),
				duration: $('.id3_TLEN').val (),
				mp3: $('.mp3_file_path').val (),
				mp3a : checkedValues
			},
			function ( result ){
				console.log ( result );
			}
		);
		$('#id3tag').modal ( 'hide' );
		$('#reloadPage').modal ( 'show' );
	});
	//--- /save i3 tag
	
	
	//--- create playlist and add files to playlist
	$('.btn-create-playlist').click ( function() {
		var myplaylist = $('.newPlaylist').val ( );
		var checkedValues = $('input:checkbox:checked').map(function() {
    		return this.name;
		}).get();
		if ( myplaylist != '' ){
			$.post ( host + 'ajax/createplaylist' ,
				{
					playlist: myplaylist
				} ,
				function result ( result ) {
					addToPlayList ( myplaylist , checkedValues );
				}
			);
		}
	});
	//--- create playlist
	
	$('.btn-create-only-playlist').click ( function() {
		var myplaylist = $('.new-playlist-name').val ( );
		var checkedValues = $('input:checkbox:checked').map(function() {
    		return this.name;
		}).get();
		if ( myplaylist != '' ){
			$.post ( host + 'ajax/createplaylist' ,
				{
					playlist: myplaylist
				} ,
				function result ( result ) {
					$('.generic-msg').html ( 'Playlist ' + myplaylist + ' has been created' );
					$('#reloadPage').modal ( 'show' );
					
				}
			);
		}
	});
	
	function addToPlayList ( playlist , aFiles ){
		if ( aFiles.length > 0 ){
			$.post ( host + 'ajax/playlistaddfiles' ,
				{
					playlist: playlist + '.m3u' ,
					songs: aFiles
				},
				function ( result ){
					$('.files-added-to-playlist').html ( 'File/s added to Playlist ' + playlist );
					$('#reloadPage').modal ( 'show' );
				}
			);
		} else {
			alert ( "Any file has been selected. Nothing to add to Playlist" );
		}
	}
	
	
	$('.tools-add-to-playlist').click ( function() {
		$('#whichPlaylist').modal ( 'show' );
	});
	
	$('.btn-which-playlist').click ( function() {
		var playlist = $('.playlist-selected').val();
		var checkedValues = $('input:checkbox:checked').map(function() {
    		return this.name;
		}).get();
		if ( checkedValues.length > 0 ){
			$.post ( host + 'ajax/playlistaddfiles' ,
				{
					playlist: playlist ,
					songs: checkedValues
				},
				function ( result ){
					$('.files-added-to-playlist').html ( 'File/s added to Playlist ' + playlist );
					$('.btn-goto-playlist').attr ( 'name' , playlist );
					$('#openPlaylist').modal ( 'show' );
				}
			);
		} else {
			alert ( "Any file has been selected. Nothing to add to Playlist" );
		}
		
	});
	
	
	
	//--- goto playlist after adding files
	$('.btn-goto-playlist').click ( function(){
		var pl = $(this).attr ( 'name' );
		pl = pl.split ( '.' );
		pl = pl[0];
		document.location = host + 'dashboard/playlists/' + pl;
	});
	
	
	//--- show confirm delete file	
	$('.tools-delete-files').click ( function () {
		$('#confirmDelete').modal ( 'show' );
	});
	//--- /show confirm delete file
	
	//delete confirmation button clic
	$('.btn-file-delete-confirm').click ( function () {
		var checkedValues = $('input:checkbox:checked').map(function() {
    		return this.name;
		}).get();
		if ( checkedValues.length > 0 ){
			$.post ( host + 'ajax/delete_files' ,
				{
					action: 'delete',
					file: checkedValues
				} ,
				function result ( result ) {
					$('.files-have-been-deleted').html ( result );
					$('#reloadPage').modal ( 'show' );
				}
			);
		} else {
			alert ( "Any file has been selected. Nothing to delete" );
		}
	});
	//--- /delete confirmation button click
	
	//----------- /storage functions ---------------------------
	
	
	//------------ playlist functions --------------------------
	//
	
	//--- remove from playlist
	$('.tools-remove-from-playlist').click ( function() {
		var playlist = $('.playlist-select').val();
		var checkedValues = $('input:checkbox:unchecked').map(function() {
    		return this.name;
		}).get();
		if ( checkedValues.length > 0 ){
			$.post ( host + 'ajax/playlistremovefiles' ,
				{
					playlist: playlist,
					files: checkedValues
				},
				function ( result ){
					$('.files-have-been-deleted').html ( result );
					$('#reloadPage').modal ( 'show' );
				}
			);
		} else {
			alert ( "Any file has been selected. Nothing to remove" );
		}
	});
	//--- /remove from playlist
	
	
	$('.tools-play-playlist').click ( function () {
		var myPlaylist = $('.current-playlist').val();
		if ( myPlaylist != '' ){
			$.post ( host + 'ajax/playplaylist' ,
				{
					playlist: myPlaylist
				},
				function (result ){
					alert ( result );
				}
			);
		}
	});
	
	
	
	// Planning functions 
	//----------------------------------------------------------
	//--- planning save button
	$('.btn-view-events').click ( function() {
		planner_save_events();
	});
	//--- /planning save button
	
	
	
	//---- /planning functions ------------------------
	
	
	// General functions 
	//-------------------------------------------------
	
	//--- reload page
	$('.btn-reloadPage').click ( function(){
		location.reload();
	});
	//--- /reload page
	
	
	
	
	
	
	//set knob in dashboard ( switch off / on )
	$('.dial-small').knob({
		width: '55',
		height: '70',
		lineCap: 'round'
	});
	
	$('.dial').knob({
		width: '120',
		height: '150',
		lineCap: 'round'
	});
	
	
	// play audio button	
	// load and play in the audio object
	$('.btn-play-audio').click ( function(){
		var mp3 = $(this).attr ( 'name' );
		var song = $(this).attr ( 'song' );
		$('.current-song').html ( song );
		player = $('#audio');
		if ( player.attr ( 'src' ) != mp3 ){
			player.attr ( 'src' , mp3 );
			player.load();
		}

		if ( $(this).html () == '<span class="icon-pause"></span>' ){
			$('.btn-play-audio').html ( '<span class="icon-play"></span>' );
			player.trigger ( "pause" );
		} else {
			$('.btn-play-audio').html ( '<span class="icon-play"></span>' );
			$(this).html ( '<span class="icon-pause"></span>' );
			player.trigger ( "play" );
		}
		
	});
	
	//shows help tips
	//help tips are saved in the help.php configuration file and attached to the button name property with leading h_(name of help)
	$('.btn-help').click ( function(){
		if ( $('.h_' + $(this).attr('name')).css ( 'display' ) == 'none' ){
			$('.h_' + $(this).attr('name')).show ( );
		} else {
			$('.h_' + $(this).attr('name')).hide ( );
		}
	});
	
});
