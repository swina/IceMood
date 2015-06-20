<?php 
	include FCPATH.'application/views/admin/header.php';       //header
	include FCPATH.'application/views/admin/navbar.php';		// navbar
?>
				
                <!--/span-->
                <div class="span9" id="content">
                    <!-- row -->
					<div class="row-fluid">
                        <!-- block -->
                        <div class="block hide">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Audio Storage</div>
								<div class="pull-right"><span class="icon-question-sign btn-help-storage"></span></div>
							</div>
							
							<div class="block-content collapse in">
								<div class="span12" style="text-align:center">
									<input type="text" value="<?=$storage_perc?>" class="dial" readonly><br>
									<br>
									
									<small><?=$storage_size?></small>
								</div>
								
							</div>
						</div>
						<!-- /block -->
					
						<!-- block -->	
						<div class="block">
						
							<div class="navbar navbar-inner block-header">
    	                    	<div class="muted pull-left">Files</div>
								<div class="pull-right"><span class="icon-question-sign btn-help-storage"></span></div>
							</div>
							<div class="block-content">
								<!--<div class="span12">
									<p>
									<input type="hidden" class="audio_path" value="<?=$this->config->item ( 'audio_path' )?>">
								    Current folder: <span class="currentfolder"><?=$currentfolder?></span>  <a href="#whichFolder" data-toggle="modal"><button class="btn btn-success btn-add-files">Change <i class="icon-folder-open icon-white"></i></button></a>
									<br>
									
									</p>
								</div>
								-->
							</div>
							
							<!-- block -->
						<div class="block-content">
							<div class="span12">
								<input type="hidden" class="audio_path" value="<?=$this->config->item ( 'audio_path' )?>">
								Folder <select class="span6 folder-select" name="folders" id="folders">
									<?=$folders?>
								</select>
							</div>
						</div>
						<!-- /block -->
						
						<!-- block -->
						<div class="block-content">
							
							<div class="span12">
								<!--- <input type="checkbox" class="check-select-all-songs hide" name="check-select" id="check-select"> ---> 
								<button class="btn btn-select-all-songs"><span class="icon-check"></span> Select all</button>
								<button class="btn btn-view-upload">Files <span class="icon-plus"></span></button>
								<button class="btn btn-create-folder" data-toggle="modal" data-target="#whichFolder">Folder <span class="icon-plus"></span></button>
								<button class="btn tools-add-to-playlist"><span class="icon-music"></span> + Playlist</button>
								<button class="btn tools-move-to-trash"><span class="icon-trash"></span> Trash </button>
								<button class="btn tools-delete-files"><span class="icon-remove"></span> Delete</button>
							</div>
							<!---<div class="span2" style="padding-right:10px">
								 <audio controls id="audio" class="pull-right"> <source src=""  type="audio/mpeg"></source></audio> 
							</div>--->
						</div>	
						<div class="block">
							<div class="span10">
								<small class="current-song"></small>
							</div>
							
						</div>
							
						<div id="upload-panel" class="block-content hide" style="margin:10px;margin-top:20px;border-radius:20px;min-height:200px;background:#fafafa;padding:10px;border:4px dashed #888">
							<h4>Upload</h4>
							<small>Drag your files here or click Add Files</small>
							<div class="block-content">	
								
					
								<div id="actions">
						
									<div class="span6">
										<!-- The fileinput-button span is used to style the file input field as button -->
										<span class="btn btn-success fileinput-button">
										<i class="glyphicon glyphicon-plus"></i>
										<span>Add files...</span>
										</span>
										<button type="submit" class="btn btn-primary start">
										<i class="glyphicon glyphicon-upload"></i>
										<span>Start upload</span>
										</button>
										<button type="reset" class="btn btn-warning cancel">
										<i class="glyphicon glyphicon-ban-circle"></i>
										<span>Cancel upload</span>
										</button>
									</div>
		
							      	<div class="span6">
										<!-- The global file processing state -->
									    <span class="fileupload-process">
									    	<div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
									    		<div class="bar progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
									    	</div>
										</span>
									</div>
								</div>
								
								<!-- /actions -->
							</div>	
							
							<!-- DROPZONE Template -->
							<div class="table table-striped" class="files" id="previews">
								<div id="template" class="file-row row">
									<!-- This is used as the file preview template -->
									<div>
										<span class="preview"><img data-dz-thumbnail /></span>
									</div>
									<div class="span4">
										<p class="name" data-dz-name></p>
									    <strong class="error text-danger" data-dz-errormessage></strong>
									</div>
									<div class="span1">
										<p class="size" data-dz-size></p>
									</div>
									<div class="span2">
										<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
									    	<div class="bar progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
										</div>
									</div>
									<div id="actions" class="span4">
									<button class="btn btn-primary start">
										<i class="glyphicon glyphicon-upload"></i>
									    <span>Start</span>
									</button>
									<button data-dz-remove class="btn btn-warning cancel">
										<i class="glyphicon glyphicon-ban-circle"></i>
										<span>Cancel</span>
									</button>
									<button data-dz-remove class="btn btn-danger delete">
										<i class="glyphicon glyphicon-trash"></i>
									    <span>Delete</span>
									</button>
									<span class="icon-ok hide"></span>
									</div>
								</div>
							</div>
							<!-- /DROPZONE Template -->		
						
						<!-- /block -->	  
						</div>
						
						<br><br>
						<div class="block-content">
							<?php include FCPATH.'application/views/admin/table.php'?>
						</div>
                        <!-- /block -->
                    </div>
				</div>
                <!-- /row -->
				
				
			<div id="whichFolder" class="modal hide" aria-hidden="true" style="display: none;">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button">׼</button>
					<h3>Select a folder</h3>
				</div>
				<div class="modal-body">
					<p>Select a destination folder or create a new one</p>
					<select class="folders" name="folders" id="folders">
						<?=$folders?>
					</select>
					<br>
					Create a new folder<br>
					<input type="text" class="newfolder" name="newfolder">
				</div>
				<div class="modal-footer">
					<a data-dismiss="modal" class="btn btn-success btn-whichfolder">Select</a>
					<a data-dismiss="modal" class="btn btn-primary btn-folder-create">Create</a>
					<a data-dismiss="modal" class="btn" href="#">Cancel</a>
				</div>
			</div>
			
			<div id="whichPlaylist" class="modal hide" aria-hidden="true" style="display: none;">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button">׼</button>
					<h3>Add to Playlist</h3>
				</div>
				<div class="modal-body">
					<p>Select a Playlist</p>
					<select id="playlist-selected" class="playlist-selected">
						<option value="">Select ...</option>
							<?=$playlist_options?>
                        </select>
					<br>
					Create a new Playlist<br>
					<input type="text" class="newPlaylist" name="newPlaylist">
				</div>
				<div class="modal-footer">
					<a data-dismiss="modal" class="btn btn-success btn-which-playlist">Add</a>
					<a data-dismiss="modal" class="btn btn-primary btn-create-playlist">Create</a>
					<a data-dismiss="modal" class="btn" href="#">Cancel</a>
				</div>
			</div>

			<div id="confirmDelete" class="modal hide" aria-hidden="true">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button">׼</button>
					<h3>Delete file/s</h3>
				</div>
				<div class="modal-body">
					<p>Do you confirm to delete files you selected?</p>
				</div>
				<div class="modal-footer">
					<a data-dismiss="modal" class="btn btn-success btn-file-delete-confirm">Yes, delete</a>
					<a data-dismiss="modal" class="btn" href="#">Cancel</a>
				</div>
			</div>	
				
			<div id="reloadPage" class="modal hide" aria-hidden="true">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button">׼</button>
					<h3>Audio Storage</h3>
				</div>
				<div class="modal-body">
					<p class="folder-has-been-created"></p>
					<p class="files-have-been-deleted"></p>
					<p class="files-added-to-playlist"></p>
					<p>
					
					Song list has changed. Do you want to refresh the content?</p>
				</div>
				<div class="modal-footer">
					<a data-dismiss="modal" class="btn btn-success btn-reloadPage">Yes</a>
					<a data-dismiss="modal" class="btn" href="#">Cancel</a>
				</div>
			</div>
			
			<div id="openPlaylist" class="modal hide" aria-hidden="true">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button">׼</button>
					<h3>Audio Storage</h3>
				</div>
				<div class="modal-body">
					<p class="folder-has-been-created"></p>
					<p class="files-have-been-deleted"></p>
					<p class="files-added-to-playlist"></p>
					<p>
					
					Playlist has changed. Do you want to check the content?</p>
				</div>
				<div class="modal-footer">
					<a data-dismiss="modal" class="btn btn-success btn-goto-playlist" name="">Yes</a>
					<a data-dismiss="modal" class="btn" href="#">Cancel</a>
				</div>
			</div>
			
			<div id="id3tag" class="modal hide" aria-hidden="true" style="display: none;">
				<div class="modal-header">
					<button data-dismiss="modal" class="close" type="button">׼</button>
					<h5>Set ID3 Tag (v2) <span class="mp3_file"></span></h5>
					<input class="mp3_file_path" type="hidden">
				</div>
				<div class="modal-body">
					<small>
					<?=$id3_form?>
					</small>
				</div>
				<div class="modal-footer">
					<a class="btn btn-primary btn-save-id3tag">Save</a>
					<a data-dismiss="modal" class="btn" href="#">Cancel</a>
				</div>
			</div>
			
		</div>
	</div>
    <hr>
	<?=$test?>
	
<?php 
	include FCPATH.'application/views/admin/footer.php';       //footer
?>


<script>
$(document).ready(function(){

// Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
var previewNode = document.querySelector("#template");
previewNode.id = "";
var previewTemplate = previewNode.parentNode.innerHTML;
previewNode.parentNode.removeChild(previewNode);
 
var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
  url: "/dropzone/upload", // Set the url
  //thumbnailWidth: 80,
  //thumbnailHeight: 80,
  parallelUploads: 20,
  previewTemplate: previewTemplate,
  autoQueue: false, // Make sure the files aren't queued until manually added
  previewsContainer: "#previews", // Define the container to display the previews
  clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
});
 
myDropzone.on("addedfile", function(file) {
  // Hookup the start button
  file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
});
 
// Update the total progress bar
myDropzone.on("totaluploadprogress", function(progress) {
  	document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
  	
});
 
myDropzone.on("sending", function(file) {
  // Show the total progress bar when upload starts
  document.querySelector("#total-progress .progress-bar").style.opacity = "1";
  // And disable the start button
  file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
});

 
// Hide the total progress bar when nothing's uploading anymore
myDropzone.on("queuecomplete", function(progress) {
  	document.querySelector("#total-progress").style.opacity = "0";
  	$('#reloadPage').modal ( 'show' );
});
 
// Setup the buttons for all transfers
// The "add files" button doesn't need to be setup because the config
// `clickable` has already been specified.
$("#actions .start").click ( function() {
  myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
});
document.querySelector("#actions .cancel").onclick = function() {
  myDropzone.removeAllFiles(true);
};
});
</script>