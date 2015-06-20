<?php 
	include FCPATH.'application/views/admin/header.php';       //header
	include FCPATH.'application/views/admin/navbar.php';		// navbar
?>


        
                


<div class="span9">
	<!-- row -->	
	<div class="row-fluid">
	
		<div class="block">
			<!-- span -->
			<div class="span12" style="text-align:center;">
				<div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">IceMood Dashboard</div>
								<div class="pull-right"><span class="icon-question-sign btn-help-storage"></span></div>
							</div>
				</div>
			</div>
			<div class="span4" style="text-align:center;">	
				<div class="block" style="min-height:180px">
					<div class="navbar navbar-inner navbar-primary block-header">
		           		<div class="muted pull-left">Icecast Server</div>
					</div>
					<p>
					<br>
					<br>
					<input type="checkbox" class="server-switch bootstrap-switch-success" name="my-checkbox" <?=$server_status_switch?> data-on-text="ON" data-off-text="OFF" data-handle-width="50">
					<input type="hidden" class="icecast-pid" value="<?=$icecastpid?>"><br>
									
					<?=$server_status_text?>
					</p>
				</div>	
			</div>
			<!-- /span -->
			
			<div class="span4" style="text-align:center;">	
				<div class="block" style="min-height:180px">
					<div class="navbar navbar-inner navbar-primary block-header">
		            	<div class="muted pull-left">Auto DJ</div>
					</div>
					<p>
					<br>
					<br>
					<input type="checkbox" class="autodj-switch bootstrap-switch-success" name="my-checkbox" <?=$autodj_status_switch?> data-on-text="ON" data-off-text="OFF" data-handle-width="50">
					<input type="hidden" class="autodj-pid" value="<?=$autodjpid?>">
					<br>
					<?=$autodj_status_text?>
					</p>								
				</div>
			</div>
			<!-- /span -->
							
			<div class="span3" style="text-align:center;">	
				<div class="block" style="min-height:180px;max-height:180px">
					<div class="navbar navbar-inner navbar-primary block-header">
		            	<div class="muted pull-left">Storage</div>
					</div>
					<p>
					<br>
					<input type="text" value="<?=$storage_perc?>" class="dial-small" readonly>
					</p>
					<p>
					<?=$storage_size?>
					</p>
				</div>
			</div>
		</div>
		
		<div class="block">
			<div class="span12">
				<!-- block -->
	            <div class="block">
	            	<div class="navbar navbar-inner block-header">
	                	<div class="muted pull-left">Radio (Icegenerator AutoDJ)  <?=$autodj?> <?=$currentPlaylist?>
						
						</div>
	                   	<div class="pull-right"><!--- <audio controls id="audio" style="margin-top:-3px"> <source src="http://stream.italianmood.net:8080/radio" type="audio/mpeg"></audio> ---></div>
					</div>
	                <div class="block-content collapse in">
						<table class="table table-striped">
	                    	<thead>
	                        	<tr>
	                            	<th><?=$lastplayedtitle?></th>
								</tr>
							</thead>
							<tbody>
								<?=$lastSongs?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- /block -->
			</div>
		<!-- /span -->
	</div>
</div>	
	

				
	
<hr>

<?php 
	include FCPATH.'application/views/admin/footer.php';       //footer
?>
