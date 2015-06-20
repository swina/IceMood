<!DOCTYPE html>
<html>
  <head>
    <title>Admin Login</title>
    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url();?>bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url();?>assets/styles.css" rel="stylesheet" media="screen">
     <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="<?php echo base_url();?>vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
  </head>
  <body id="login">
    <div class="container center">

      <div class="form-signin">
        <img src="<?php echo base_url();?>images/logo-icemood-small.png">
		<h4 class="form-signin-heading">Please sign in</h4>
        <input type="text" name="user_email" id="user_email" class="input-block-level user_email" placeholder="Email address">
        <input type="password" name="user_pass" id="user_pass" class="input-block-level user_pass" placeholder="Password">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-large btn-primary btn-login">Sign in</button>
		<p>
		<span class="error_msg"></span>
		<br>
		
		<small>&copy; <?php echo date ( "Y" );?> - IceMood is a product by MoodGiver</small>
		</p>
      </div>
		
    </div> <!-- /container -->
    <script src="<?php echo base_url();?>vendors/jquery-1.9.1.min.js"></script>
    <script src="<?php echo base_url();?>bootstrap/js/bootstrap.min.js"></script>
	
	<script>
	$(document).ready ( function(){
		$('.btn-login').click ( function(){
			
			$.post ( 'ajax/login' ,
				{
					user_email: $('.user_email').val(),
					user_pass: $('.user_pass').val()
				},
				function ( result ){
					if ( !result ){
						$('.error_msg').html ( "Wrong user or password" );
					} else {
						document.location = result; 
					}
				}
			);
		});
	});
	</script>
  </body>
</html>