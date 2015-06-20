<div id="working" class="working"></div>
<div class="navbar navbar-fixed-top" id="topbar">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <a href="<?php echo base_url();?>dashboard" class="brand"><img src="<?php echo base_url()?>images/logo-icemood-topbar.png" style="max-height:20px"> <?=$server_status?></a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> <?=$this->session->userdata ( 'aname' );?><i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">Profile</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a tabindex="-1" href="<?php echo base_url()?>logout">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                         <!---<ul class="nav">
                            <li class="active">
                                <a href="<?php echo base_url();?>dashboard">Dashboard</a>
                            </li>
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Settings <b class="caret"></b></a>
                                <ul class="dropdown-menu" id="menu1">
                                    <li>
                                        <a href="<?php echo base_url();?>settings">Setup <i class="icon-cog"></i></a>
									</li>
									<li>
										<a href="<?php echo base_url();?>autodj">AutoDJ <i class="icon-cog"></i></a>
                                    </li>
                                </ul>
                            </li> 
                            
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Users <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a tabindex="-1" href="#">User List</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">Search</a>
                                    </li>
                                    <li>
                                        <a tabindex="-1" href="#">Permissions</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>--->
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3" id="sidebar">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse" id="mainmenu" style="margin-top:15px;">
						
                        <li id="menu_">
                            <a href="<?php echo base_url();?>dashboard"><i class="icon-chevron-right"></i> Dashboard</a>
                        </li>
                        <li id="menu_storage">
                            <a href="<?php echo base_url();?>dashboard/storage"><i class="icon-chevron-right"></i> Storage</a>
                        </li>
						<li id="menu_playlists">
                            <a href="<?php echo base_url();?>dashboard/playlists"><i class="icon-chevron-right"></i> Playlists</a>
                        </li>
						<li id="menu_planning">
                            <a href="<?php echo base_url();?>dashboard/planning"><i class="icon-chevron-right"></i> Planning</a>
                        </li>
						<li id="menu_settings">
                             <a href="<?php echo base_url();?>settings"><i class="icon-cog"></i> Setup</a>
                        </li>
						<li id="menu_autodj">
                           	<a href="<?php echo base_url();?>autodj"><i class="icon-cog"></i> AutoDJ</a>
                        </li>
						
                        <li>
                            <a href="#"><span class="badge badge-info pull-right"><?=$nr_of_songs?></span> Songs</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>dashboard/autodjplayed"><span class="badge badge-info pull-right"><?=$played?></span></span> Played</a>
                        </li>
						<li class="active">
							<a href="#"><audio controls id="audio" style="margin-top:5px;max-width:200px;"> <source src="<?=$this->config->item('streaming').$this->config->item('icegen_mount')?>" type="audio/mpeg"></audio></a>
						</li>
						<!--
                        <li>
                            <a href="#"><span class="badge badge-info pull-right">27</span> Clients</a>
                        </li>
                        <li>
                            <a href="#"><span class="badge badge-info pull-right">1,234</span> Users</a>
                        </li>
                        <li>
                            <a href="#"><span class="badge badge-info pull-right">2,221</span> Messages</a>
                        </li>
                        <li>
                            <a href="#"><span class="badge badge-info pull-right">11</span> Reports</a>
                        </li>
                        <li>
                            <a href="#"><span class="badge badge-important pull-right">83</span> Errors</a>
                        </li>
                        <li>
                            <a href="#"><span class="badge badge-warning pull-right">4,231</span> Logs</a>
                        </li>
						-->
                    </ul>
					
					
					
                </div>
				