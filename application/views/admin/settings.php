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
                                <div class="muted pull-left">Settings</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                    <form class="form-horizontal" method="post" action="<?=$this->config->item('base_url')?>ajax/setupsave">
                                      <fieldset>
                                        <legend>Setup</legend>
										
										<div class="control-group">
                                          <label class="control-label" for="typeahead"><span class="badge badge-success">Linux User</span> </label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="sudo" value="<?=$this->config->item('sudo')?>">
                                            <p class="help-block"><small>example: <?=$this->config->item('sudo');?>. Authorized user to start/stop service (Icecast/Icegenerator)</small></p>
                                          </div>
                                        </div>										
                                        <div class="control-group">
											<?=$icecast_alert?>
                                          <label class="control-label" for="typeahead"><?=$icecast_is?> </label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="icecast_path" value="<?=$this->session->userdata('icecast_path')?>">
                                            <p class="help-block"><small>example: <?=$this->config->item('icecast_path')?></small></p>
                                          </div>
                                        </div>
										<div class="control-group">
                                          <label class="control-label" for="typeahead">Icecast Config file </label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="icecast_xml" value="<?=$this->config->item('icecast_xml')?>">
                                            <p class="help-block"><small>example: <?=$this->config->item('icecast_xml')?></small></p>
                                          </div>
                                        </div>
										<div class="control-group">
                                          <label class="control-label" for="typeahead">Icecast Log file </label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="icecast_log" value="<?=$this->config->item('icecast_log')?>">
                                            <p class="help-block"><small>example: <?=$this->config->item('icecast_log')?></small></p>
                                          </div>
                                        </div>
										<div class="control-group">
											<?=$icegenerator_alert?>
                                          <label class="control-label" for="typeahead"><?=$icegenerator_is?> </label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="icegen_path" value="<?=$this->session->userdata('icegenerator_path')?>">
                                            <p class="help-block"><small>example: /usr/bin/icegenerator</small></p>
                                          </div>
                                        </div>
										<div class="control-group">
                                          <label class="control-label" for="typeahead">Icegenerator Config file </label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="icegen_cfg" value="<?=$this->config->item('icegen_cfg')?>">
                                            <p class="help-block"><small>example: <?=$this->config->item('icegen_cfg')?></small></p>
                                          </div>
                                        </div>
										<div class="control-group">
                                          <label class="control-label" for="typeahead">Icegenerator Log file </label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="icegen_log" value="<?=$this->config->item('icegen_log')?>">
                                            <p class="help-block"><small>example: <?=$this->config->item('icegen_log')?></small></p>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <label class="control-label" for="typeahead"><span class="badge badge-success">Storage Path</span> </label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="storage_path" value="<?=$this->config->item('audio_path')?>">
                                            <p class="help-block"><small>example: <?=$this->config->item('audio_path')?></small></p>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <label class="control-label" for="typeahead"><span class="badge badge-success">Default playlist</span> </label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="playlist" value="<?=$this->config->item('playlist')?>">
                                            <p class="help-block"><small>example: <?=$this->config->item('playlist')?> : playlist autogenerated of all uploaded audio</small></p>
                                          </div>
                                        </div>
										
										<div class="control-group">
                                          <label class="control-label" for="typeahead"><span class="badge badge-success">Streaming URL</span> </label>
                                          <div class="controls">
                                            <input type="text" class="span6" name="streaming" value="<?=$this->config->item('streaming')?>">
                                            <p class="help-block"><small>example: <?=$this->config->item('streaming')?></small></p>
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