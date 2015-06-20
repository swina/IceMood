<?php 
	include FCPATH.'application/views/admin/header.php';       //header
	include FCPATH.'application/views/admin/navbar.php';		// navbar
?>

<!--/span-->	<div style="position:fixed; bottom:30px; left:10px"><span class="saved"></span></div>
                <div class="span9" id="content">
                    <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left"><span class="badge badge-info">Planning</span> <?=$currTime?></div>
                                <div class="pull-right"><span class="saved"></span><button class="btn-primary btn-view-events">Save</button>

                                </div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span2">
									<div id='external-events'>
                                    <h4>Playlists</h4>
									<?=$playlists?>
                                   <!---  <div class='external-event'>My Event 1</div>
                                    <div class='external-event'>My Event 2</div>
                                    <div class='external-event'>My Event 3</div>
                                    <div class='external-event'>My Event 4</div>
                                    <div class='external-event'>My Event 5</div>
                                    <div class='external-event'>My Event 6</div>
                                    <div class='external-event'>My Event 7</div>
                                    <div class='external-event'>My Event 8</div>
                                    <div class='external-event'>My Event 9</div>
                                    <div class='external-event'>My Event 10</div>
                                    <div class='external-event'>My Event 11</div>
                                    <div class='external-event'>My Event 12</div>
                                    <div class='external-event'>My Event 13</div>
                                    <div class='external-event'>My Event 14</div>
                                    <div class='external-event'>My Event 15</div> --->
                                    <p>
                                    <input type='checkbox' id='drop-remove' /> <label for='drop-remove'><small>remove after drop</small></label>
                                    </p>
                                    </div>
                                </div>
                                <div class="span10">
                                    <div id='calendar'></div>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                </div>
            </div>
            <hr>
          
        </div>
        <style>
        #external-events {
            float: left;
            width: 150px;
            padding: 0 10px;
            border: 1px solid #ccc;
            background: #eee;
            text-align: left;
            }
            
        #external-events h4 {
            font-size: 16px;
            margin-top: 0;
            padding-top: 1em;
            }
            
        .external-event { /* try to mimick the look of a real event */
            margin: 10px 0;
            padding: 2px 4px;
            background: #3366CC;
            color: #fff;
            font-size: .85em;
            cursor: pointer;
            z-index: 99999999;
            }
            
        #external-events p {
            margin: 1.5em 0;
            font-size: 11px;
            color: #666;
            }
            
        #external-events p input {
            margin: 0;
            vertical-align: middle;
            }

        </style>
        <!--/.fluid-container-->
	

<?php 
	include FCPATH.'application/views/admin/footer.php';       //footer
?>


