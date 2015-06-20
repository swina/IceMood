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
                                   Slots       
								</div>
                            </div>
								
                            <div class="block-content collapse in">
								<div class="span4">
    								<select id="select01" class="slot-select">
										<option value="">Select a slot ...</option>
										<?=$playlist_options?>
                                    </select>
									
								</div>
								<div class="span3">
									<input type="text" class="new-slot-name" value="">	
								</div>
								<div class="span3">
									<button class="btn btn-success btn-create-slot">Create Slot</button>
								</div>
								
							</div>	
							<div class="block-content collapse in">	
                                <div class="span12">
                                   <div class="table-toolbar">
								   		<h3><?=$playlist_selected?> </h3>	
								   	  <!--
                                      <div class="btn-group">
                                         <a href="#"><button class="btn btn-success">Add New <i class="icon-plus icon-white"></i></button></a>
                                      </div>
									  -->
									  <div class="btn-group pull-right">
                                         
                                         <button data-toggle="dropdown" class="btn dropdown-toggle">Tools <span class="caret"></span></button>
										<ul class="dropdown-menu">
											
											<li><a href="javascript:void(0)" class="btn-select-all-songs"><span class="icon-check"></span> Select all</a></li>
											<li><a href="javascript:void(0)" class="tools-remove-from-playlist"><span class="icon-share"></span>Remove from Playlist <?=$playlist_selected?></a></li>
											<li><a href="javascript:void(0)" class="tools-move-to-trash"><span class="icon-trash"></span> Move to trash </a></li>
											<li><a href="javascript:void(0)" class="tools-delete-files"><span class="icon-remove"></span> Delete </a></li>
											
										</ul>
                                      	</div>
                                   </div>
									<br>
									<!--- <input type="checkbox" class="select-all-songs"> Select all (page) --->
									<br>
									<br>
									<div style="padding:10px">
									 <table cellpadding="0" cellspacing="0" border="0" class="table table-striped slots" id="slots">
								    	<thead>
									        <th>Start Time</th>
											<th>End Time</th>
											<th>Playlist</th>
								        </thead>
										<tbody>
											<?=$table_output?>
									</tbody>
									</table> 
									</div>
									</div>
									<!--<?php //include FCPATH.'application/views/admin/table_slots.php'?>-->
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
					<select id="playlist-selected" class="slot-selected">
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

			

<?php 
	include FCPATH.'application/views/admin/footer.php';       //footer
?>