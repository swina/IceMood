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
                                <div class="muted pull-left"><span class="badge badge-info">Radio Log</span></div>
                                
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
									<textarea class="view-log span10" style="height:500px"><?=$log?></textarea>						
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                </div>
           


<?php 
	include FCPATH.'application/views/admin/footer.php';       //footer
?>


