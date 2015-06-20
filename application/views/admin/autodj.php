<?php 
	include FCPATH.'application/views/admin/header.php';       //header
	include FCPATH.'application/views/admin/navbar.php';		// navbar
?>
               
                <div class="span9" id="content">
                    
						<div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">AutoDJ Configuration</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <form class="form-horizontal" method="post" action="<?=$this->config->item('base_url')?>ajax/autodjsave">
                                      <fieldset>
                                        
										<legend>Server</legend>
																				
                                        <div class="control-group">
                                          <label class="control-label" for="typeahead">IP </label>
                                          <div class="controls">
                                            <input type="text" class="span6 required" name="icegen_ip" value="<?=$this->config->item ( 'icegen_ip' )?>">
											<span class="icon-question-sign btn-help" name="server_ip"></span>
                                            <p class="help-block hide h_server_ip"><small><?=$this->config->item('help_server_ip')?></small></p>
                                          </div>
                                        </div>
										<div class="control-group">
                                          <label class="control-label" for="typeahead">Port</label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="icegen_port" value="<?=$this->config->item('icegen_port')?>">
											<span class="icon-question-sign btn-help" name="server_port"></span>
                                            <p class="help-block hide h_server_port"><small><?=$this->config->item('help_server_port')?></small></p>
                                          </div>
                                        </div>
										<div class="control-group">
                                          <label class="control-label" for="typeahead">Mount</label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="icegen_mount" value="<?=$this->config->item('icegen_mount')?>">
											<span class="icon-question-sign btn-help" name="server_mount"></span>
                                            <p class="help-block hide h_server_mount"><small><?=$this->config->item('help_server_mount')?></small></p>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <label class="control-label" for="typeahead">Timezone </label>
                                          <div class="controls">
										  	<?= $timezones ?>
											(Server time: <?php echo date ( 'Y-m-d H:i' );?>)
											<span class="icon-question-sign btn-help" name="server_timezone"></span>
                                            <p class="help-block hide h_server_mount"><small><?=$this->config->item('help_server_mount')?></small></p>
                                          </div>
                                        </div>
										
										<legend>User</legend>
										
										<div class="control-group">
                                          <label class="control-label" for="typeahead">Icecast username </label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="icegen_user" value="<?=$this->config->item('icegen_user')?>">
											<span class="icon-question-sign btn-help" name="icecast_user"></span>
                                            <p class="help-block hide h_icecast_user"><small><?=$this->config->item('help_icecast_user')?></small></p>
				                          </div>
                                        </div>
										<div class="control-group">
                                          <label class="control-label" for="typeahead">Icecast password</label>
                                          <div class="controls">
                                            <input type="password" class="span6" name="icegen_pwd" value="<?=$this->config->item('icegen_password')?>">
                                            <span class="icon-question-sign btn-help" name="icecast_password"></span>
                                            <p class="help-block hide h_icecast_password"><small><?=$this->config->item('help_icecast_password')?></small></p>
                                          </div>
                                        </div>
										
										
										
										
										
										<legend>Information</legend>										
										
										<div class="control-group">
                                          <label class="control-label" for="typeahead">Name</label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="icegen_name" value="<?=$this->config->item('icegen_name')?>">
                                            <span class="icon-question-sign btn-help" name="info_name"></span>
										  	<p class="help-block hide h_info_name">
											<small><?=$this->config->item('help_info_name')?></small>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <label class="control-label" for="typeahead">Genre</label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="icegen_genre" value="<?=$this->config->item('icegen_genre')?>">
                                             <span class="icon-question-sign btn-help" name="info_genre"></span>
										  	<p class="help-block hide h_info_genre">
											<small><?=$this->config->item('help_info_genre')?></small>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <label class="control-label" for="typeahead">Description</label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="icegen_description" value="<?=$this->config->item('icegen_description')?>">
                                             <span class="icon-question-sign btn-help" name="info_description"></span>
										  	<p class="help-block hide h_info_description">
											<small><?=$this->config->item('help_info_description')?></small>
                                          </div>
                                        </div>
										
										
										
                                        <div class="form-actions">
                                          <button type="submit" class="btn btn-primary btn-setup-saves">Save changes</button>
                                          <button type="reset" class="btn">Cancel</button>
										
                                        </div>
                                      </fieldset>
                                    </form>
									  <?=$saved_info?>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                        
                        
                    
                </div>
            </div>
            <hr>

<?php 
	include FCPATH.'application/views/admin/footer.php';       //footer
?>