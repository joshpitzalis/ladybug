<?php
error_reporting(0);

require '../config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin login">
    <meta name="keyword" content="">

    <title><?php echo $site_name; ?> | Login</title>

	<!-- Bootstrap core CSS -->
    <link href="../src/css/bootstrap/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../src/plugins/lineicons/style.css">   
    
    <!-- Custom styles for this template -->
    <link href="../src/css/admin.css" rel="stylesheet">
    <link href="../src/css/admin-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	<div id="login-page">
	  	<div class="container">
		    <form class="form-login" id="login_form_admin">
			    <h2 class="form-login-heading">Sign in now</h2>
			    <div class="login-wrap">
		            <input type="text" id="email" class="form-control" placeholder="E-Mail" autofocus>
		            <br>
		            <input type="password" id="password" class="form-control" placeholder="Password">
		            <br>
		            <button class="btn btn-theme btn-block" id="submit"><i class="fa fa-lock"></i> SIGN IN</button>	
		        </div>			
	      	</form>	
	      	<div id="errorDiv" style="width: 330px; text-align:center; margin-left: auto; margin-right: auto; padding-top: 10px;"></div> 	 		  
	  	</div>
	</div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="../src/js/admin/jquery.js"></script>
    <script src="../src/js/admin/bootstrap.min.js"></script>

    <script>
    	$('body').on('click', '#submit', function()
		{
			var email=$("#email").val();
			var password=$("#password").val();
			var formAction = 'login';
			var dataString = 'action='+formAction+'&email='+email+'&password='+password;
			
			if (password==null || password=="" || email==null || email=="")
			{
				document.getElementById("errorDiv").innerHTML = '<div class="alert alert-danger" role="alert">Fill in all the fields !</div>';
			}else{
				$.ajax({
					type: "POST",
					url: 'action.php',
					data: dataString,
					cache: false,
					success: function(data){
						if(data == 'true')
						{
							window.location = 'index.php';
						}
						if(data == 'false')
						{
							document.getElementById("errorDiv").innerHTML = '<div class="alert alert-danger" role="alert">Invalid login details !</div>';
						}
					}
				});
			}
			return false;
		});
    </script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="../src/js/admin/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("../src/images/bg-admin.jpg", {speed: 500});
    </script>


  </body>
</html>
