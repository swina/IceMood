<?php 
	include FCPATH.'application/views/admin/header.php';       //header
	include FCPATH.'application/views/admin/navbar.php';		// navbar
?>
                
                <!--/span-->
                <div class="span9" id="content">
                    <div class="row-fluid">
						
                        <!-- block -->
                        <div class="block">
                        	<div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">
                                   <span class="label label-info">Playlist</span>
								</div>
                            </div>
							<!--- 	
                            <div class="block-content collapse in">
								<div class="span4">
    								<select id="select01" class="playlist-select">
										<option value="">Select a playlist ...</option>
										<?=$playlist_options?>
                                    </select>
									
								</div>
								<div class="span2">
									<input type="text" class="new-playlist-name" value="">
								</div>
								<div class="span4">
									<button class="btn btn-success btn-create-only-playlist">Create Playlist</button>
								</div>
								<div class="table-toolbar">
									<div class="btn-group pull-right">
                                         <input type="hidden" class="current-playlist" value="<?=$playlist_selected?>">
                                         <button data-toggle="dropdown" class="btn dropdown-toggle">Tools <span class="caret"></span></button>
										<ul class="dropdown-menu">
											
											<li><a href="javascript:void(0)" class="btn-select-all-songs"><span class="icon-check"></span> Select all</a></li>
											<li><a href="javascript:void(0)" class="tools-remove-from-playlist"><span class="icon-share"></span>Remove from Playlist <?=$playlist_selected?></a></li>
											<li><a href="javascript:void(0)" class="tools-play-playlist"><span class="icon-music"></span> Play now! </a></li>
											<li><a href="javascript:void(0)" class="tools-move-to-trash"><span class="icon-trash"></span> Move to trash </a></li>
											<li><a href="javascript:void(0)" class="tools-delete-files"><span class="icon-remove"></span> Delete </a></li>
											
										</ul>
                                    </div>
								</div>
							</div>	 --->
							<div class="block-content collapse in">	
                                <div class="span12">
                                   <div class="table-toolbar">
								   			
										<div class="span6">
    									<select id="select01" class="playlist-select">
											<option value="">Select a playlist ...</option>
											<?=$playlist_options?>
                                    	</select>
										<span style="font-size:20px"><?=$playlist_selected?></span>
										</div>
										<div class="span2">
											<input type="text" class="new-playlist-name" value="">
										</div>
										<div class="span2">
											<button class="btn btn-success btn-create-only-playlist">Create Playlist</button>
										</div>		
								   	  <!--
                                      <div class="btn-group">
                                         <a href="#"><button class="btn btn-success">Add New <i class="icon-plus icon-white"></i></button></a>
                                      </div>
									  -->
									  <div class="span2">
									  <div class="btn-group pull-right">
                                         <input type="hidden" class="current-playlist" value="<?=$playlist_selected?>">
                                         <button data-toggle="dropdown" class="btn dropdown-toggle">Tools <span class="caret"></span></button>
										<ul class="dropdown-menu">
											
											<li><a href="javascript:void(0)" class="btn-select-all-songs"><span class="icon-check"></span> Select all</a></li>
											<li><a href="javascript:void(0)" class="tools-remove-from-playlist"><span class="icon-share"></span>Remove from Playlist <?=$playlist_selected?></a></li>
											<li><a href="javascript:void(0)" class="tools-play-playlist"><span class="icon-music"></span> Play now! </a></li>
											<li><a href="javascript:void(0)" class="tools-move-to-trash"><span class="icon-trash"></span> Move to trash </a></li>
											<li><a href="javascript:void(0)" class="tools-delete-files"><span class="icon-remove"></span> Delete </a></li>
											
										</ul>
                                      </div>
									  </div>
                                   </div>
									<br>
									<!--- <input type="checkbox" class="select-all-songs"> Select all (page) --->
									<br>
									<br>
									
									<?php include FCPATH.'application/views/admin/table.php'?>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                </div>
            </div>
            <hr>
			
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
					<p class="generic-msg"></p>
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

<?php 
	include FCPATH.'application/views/admin/footer.php';       //footer
?>