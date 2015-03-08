<?php
/*
Title: Droppy installation

Thanks to riliwanrabo for design
*/

error_reporting(0);

ob_start();

include 'config/config.php';

if($_POST['action'] == 'dbsettings') {
	$mysqli_test = new mysqli($_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass'], $_POST['dbname']);

	if ($mysqli_test->connect_errno ) {
		header('Location: install.php?page=1&db=error');
	}
	else
	{
		$db_file = file_get_contents('config/db.php');
		$get_values = array(
			'#db_host#',
			'#db_user#',
			'#db_pass#',
			'#db_name#'
		);
		$change = array(
			$_POST['dbhost'],
			$_POST['dbuser'],
			$_POST['dbpass'],
			$_POST['dbname']
		);
		
		$db_config = str_replace($get_values, $change, $db_file);

		file_put_contents('config/db.php', $db_config);
		header('Location: install.php?action=inserttabledata');
	}
	$mysqli_test->close();
}
if($_GET['action'] == 'inserttabledata') {	
	$site = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);

	$mysqli->query("CREATE TABLE IF NOT EXISTS `$table_accounts` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `email` varchar(100) NOT NULL,
					  `password` varchar(100) NOT NULL,
					  `ip` varchar(100) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	$mysqli->query("CREATE TABLE IF NOT EXISTS `$table_downloads` (
					  `id` int(100) NOT NULL AUTO_INCREMENT,
					  `download_id` varchar(100) NOT NULL,
					  `time` int(100) NOT NULL,
					  `ip` varchar(100) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	$mysqli->query("CREATE TABLE IF NOT EXISTS `$table_files` (
					  `id` int(100) NOT NULL AUTO_INCREMENT,
					  `upload_id` varchar(500) NOT NULL,
					  `secret_code` varchar(500) NOT NULL,
					  `file` varchar(500) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	$mysqli->query("CREATE TABLE IF NOT EXISTS `$table_settings` (
					  `id` int(100) NOT NULL AUTO_INCREMENT,
					  `site_name` varchar(100) NOT NULL,
					  `site_title` varchar(100) NOT NULL,
					  `site_desc` varchar(200) NOT NULL,
					  `site_url` varchar(100) NOT NULL,
					  `max_size` int(100) NOT NULL,
					  `expire` int(100) NOT NULL,
					  `upload_dir` varchar(100) NOT NULL,
					  `favicon_path` varchar(100) NOT NULL,
					  `logo_path` varchar(100) NOT NULL,
					  `language` varchar(100) NOT NULL,
					  `background` varchar(100) NOT NULL,
					  `email_from_name` varchar(100) NOT NULL,
					  `email_from_email` varchar(100) NOT NULL,
					  `email_server` varchar(100) NOT NULL,
					  `smtp_host` varchar(100) NOT NULL,
					  `smtp_secure` varchar(100) NOT NULL,
					  `smtp_port` int(100) NOT NULL,
					  `smtp_username` varchar(100) NOT NULL,
					  `smtp_password` varchar(100) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	$mysqli->query("INSERT INTO `$table_settings` (`id`, `site_name`, `site_title`, `site_desc`, `site_url`, `max_size`, `expire`, `upload_dir`, `favicon_path`, `logo_path`, `language`, `background`, `email_from_name`, `email_from_email`, `email_server`, `smtp_host`, `smtp_secure`, `smtp_port`, `smtp_username`, `smtp_password`) VALUES
					(1, 'Droppy', 'Droppy - Online file sharing', 'Online file sharing, share large or small files with friends and family.', '$site', 20, 86400, 'uploads/', 'src/images/icon.png', 'src/images/logo.png', 'English.php', 'src/images/bg5.jpg', 'No-Reply Example', 'noreply@example.com', 'LOCAL', '', '', 25, '', '');");
	$mysqli->query("CREATE TABLE IF NOT EXISTS `$table_social` (
					  `id` int(100) NOT NULL AUTO_INCREMENT,
					  `facebook` varchar(100) NOT NULL,
					  `twitter` varchar(100) NOT NULL,
					  `google` varchar(100) NOT NULL,
					  `instagram` varchar(100) NOT NULL,
					  `github` varchar(100) NOT NULL,
					  `tumblr` varchar(100) NOT NULL,
					  `pinterest` varchar(100) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	$mysqli->query("INSERT INTO `$table_social` (`id`, `facebook`, `twitter`, `google`, `instagram`, `github`, `tumblr`, `pinterest`) VALUES
					(1, 'http://facebook.com', 'http://twitter.com', 'http://google.com', '', '', '', '');");
	$mysqli->query("CREATE TABLE IF NOT EXISTS `$table_templates` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `type` varchar(100) NOT NULL,
					  `msg` varchar(1000) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	$mysqli->query("INSERT INTO `$table_templates` (`id`, `type`, `msg`) VALUES
					(1, 'receiver', ''),
					(2, 'sender', ''),
					(3, 'destroyed', ''),
					(4, 'receiver_subject', 'You have received some files !'),
					(5, 'sender_subject', 'Your items have been sent !'),
					(6, 'destroyed_subject', 'Your items have been destroyed !');");
	$mysqli->query("CREATE TABLE IF NOT EXISTS `$table_uploads` (
					  `id` int(100) NOT NULL AUTO_INCREMENT,
					  `upload_id` varchar(200) NOT NULL,
					  `email_from` varchar(500) NOT NULL,
					  `message` varchar(5000) NOT NULL,
					  `secret_code` varchar(500) NOT NULL,
					  `password` varchar(100) NOT NULL,
					  `status` varchar(100) NOT NULL,
					  `size` varchar(100) NOT NULL,
					  `time` int(100) NOT NULL,
					  `ip` varchar(100) NOT NULL,
					  `count` int(100) NOT NULL,
					  `share` varchar(100) NOT NULL,
					  `destruct` varchar(100) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
	header('Location: install.php?page=2&db=ok');
}
if($_POST['action'] == 'createuser') {
	$email = mysqli_real_escape_string($mysqli, $_POST['email']);
	$password = md5(mysqli_real_escape_string($mysqli, $_POST['password']));
	$ip = $_SERVER['REMOTE_ADDR'];

	$mysqli->query("INSERT INTO $table_accounts (`email`, `password`, `ip`) VALUES ('$email','$password','$ip')");
	header('Location: install.php?page=3&user=ok');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<link href="src/css/bootstrap/bootstrap.css" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<!--<link href="../css/install.css" rel="stylesheet">-->
	<style>
		@import url(http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700);

		body { 
		  background: url('src/images/bg_install.jpg') no-repeat center center fixed; 
		  -webkit-background-size: cover;
		  -moz-background-size: cover;
		  -o-background-size: cover;
		  background-size: cover;
		}

		.board{
		    width: 75%;
			margin: 60px auto;
			height: 550px;
			background: #fff;
			/*box-shadow: 10px 10px #ccc,-10px 20px #ddd;*/
		}
		.board .nav-tabs {
		    position: relative;
		    /* border-bottom: 0; */
		    /* width: 80%; */
		    margin: 40px auto;
		    margin-bottom: 0;
		    box-sizing: border-box;

		}

		.board > div.board-inner{
		    background: #fafafa url(http://subtlepatterns.com/patterns/geometry2.png);
		    background-size: 30%;
		}

		p.narrow{
		    width: 60%;
		    margin: 10px auto;
		}

		.liner{
		    height: 2px;
		    background: #ddd;
		    position: absolute;
		    width: 50%;
		    margin: 0 auto;
		    left: 0;
		    right: 0;
		    top: 50%;
		    z-index: 1;
		}

		.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
		    color: #555555;
		    cursor: default;
		    /* background-color: #ffffff; */
		    border: 0;
		    border-bottom-color: transparent;
		}

		span.round-tabs{
		    width: 70px;
		    height: 70px;
		    line-height: 70px;
		    display: inline-block;
		    border-radius: 100px;
		    background: white;
		    z-index: 2;
		    position: absolute;
		    left: 0;
		    text-align: center;
		    font-size: 25px;
		}

		span.round-tabs.one{
		    color: rgb(34, 194, 34);border: 2px solid rgb(34, 194, 34);
		}

		li.active span.round-tabs.one{
		    background: #fff !important;
		    border: 2px solid #ddd;
		    color: rgb(34, 194, 34);
		}

		span.round-tabs.two{
		    color: #febe29;border: 2px solid #febe29;
		}

		li.active span.round-tabs.two{
		    background: #fff !important;
		    border: 2px solid #ddd;
		    color: #febe29;
		}

		span.round-tabs.three{
		    color: #3e5e9a;border: 2px solid #3e5e9a;
		}

		li.active span.round-tabs.three{
		    background: #fff !important;
		    border: 2px solid #ddd;
		    color: #3e5e9a;
		}

		span.round-tabs.four{
		    color: #f1685e;border: 2px solid #f1685e;
		}

		li.active span.round-tabs.four{
		    background: #fff !important;
		    border: 2px solid #ddd;
		    color: #f1685e;
		}

		span.round-tabs.five{
		    color: #999;border: 2px solid #999;
		}

		li.active span.round-tabs.five{
		    background: #fff !important;
		    border: 2px solid #ddd;
		    color: #999;
		}

		.nav-tabs > li.active > a span.round-tabs{
		    background: #fafafa;
		}
		.nav-tabs > li {
		    width: 20%;
		}
		/*li.active:before {
		    content: " ";
		    position: absolute;
		    left: 45%;
		    opacity:0;
		    margin: 0 auto;
		    bottom: -2px;
		    border: 10px solid transparent;
		    border-bottom-color: #fff;
		    z-index: 1;
		    transition:0.2s ease-in-out;
		}*/
		li:after {
		    content: " ";
		    position: absolute;
		    left: 45%;
		   opacity:0;
		    margin: 0 auto;
		    bottom: 0px;
		    border: 5px solid transparent;
		    border-bottom-color: #ddd;
		    transition:0.1s ease-in-out;
		    
		}
		li.active:after {
		    content: " ";
		    position: absolute;
		    left: 45%;
		   opacity:1;
		    margin: 0 auto;
		    bottom: 0px;
		    border: 10px solid transparent;
		    border-bottom-color: #ddd;
		    
		}
		.nav-tabs > li a{
		   width: 70px;
		   height: 70px;
		   margin: 20px auto;
		   border-radius: 100%;
		   padding: 0;
		}

		.nav-tabs > li a:hover{
		    background: transparent;
		}

		.tab-content{
		}
		.tab-pane{
		   position: relative;
			padding-top: 10px;
		}
		.tab-content .head{
		    font-family: 'Roboto Condensed', sans-serif;
		    font-size: 25px;
		    text-transform: uppercase;
		    padding-bottom: 10px;
		}
		.btn-outline-rounded{
		    padding: 10px 40px;
		    margin: 20px 0;
		    border: 2px solid transparent;
		    border-radius: 25px;
		}

		.btn.green{
		    background-color:#5cb85c;
		    /*border: 2px solid #5cb85c;*/
		    color: #ffffff;
		}



		@media( max-width : 585px ){
		    
		    .board {
		width: 90%;
		height:auto !important;
		}
		    span.round-tabs {
		        font-size:16px;
		width: 50px;
		height: 50px;
		line-height: 50px;
		    }
		    .tab-content .head{
		        font-size:20px;
		        }
		    .nav-tabs > li a {
		width: 50px;
		height: 50px;
		line-height:50px;
		}

		li.active:after {
		content: " ";
		position: absolute;
		left: 35%;
		}

		.btn-outline-rounded {
		    padding:12px 20px;
		    }
		}
	</style>
</head>
<body>
<section style="background-color: transparent;">
        <div class="container">
            <div class="row">
                <div class="board">
                    <!-- <h2>Welcome to IGHALO!<sup>™</sup></h2>-->
                    <div class="board-inner">
                    <ul class="nav nav-tabs" id="myTab" style="padding-left: 140px">
                    <div class="liner"></div>
                    <?php
                    if(!isset($_GET['page'])) {
                    	echo '<li class="active">';
                    }
                    else
                    {
                    	echo '<li>';
                    }
                    ?>
	                     <a title="Welcome">
	                      <span class="round-tabs one">
                                <i class="glyphicon glyphicon-home"></i>
	                      </span> 
	                 	 </a>
	             	 </li>

	             	<?php
	                if($_GET['page'] == '1') {
                    	echo '<li class="active">';
                    }
                    else
                    {
                    	echo '<li>';
                    }
                    ?>
	                  	<a title="Database settings">
	                     <span class="round-tabs two">
	                        <i class="fa fa-database"></i>
	                     </span> 
	           			</a>
	                 </li>
	                 <?php
	                if($_GET['page'] == '2') {
                    	echo '<li class="active">';
                    }
                    else
                    {
                    	echo '<li>';
                    }
                    ?>
	                 	<a title="Create admin user">
	                     <span class="round-tabs three">
	                          <i class="glyphicon glyphicon-user"></i>
	                     </span> 
	                    </a>
	                 </li>

	                 <?php
	                if($_GET['page'] == '43') {
                    	echo '<li class="active">';
                    }
                    else
                    {
                    	echo '<li>';
                    }
                    ?>
	                 	<a title="Success">
	                     <span class="round-tabs five">
	                          <i class="glyphicon glyphicon-ok"></i>
	                     </span> 
	                    </a>
	                 </li>
                     
                     </ul></div>

                     <div id="tab-content">
                      <div class="tab-pane" id="home">
                      <?php
                      	if(!isset($_GET['page'])) :
                      ?>
                  		<div style="padding-top: 60px;">
                          <h3 class="head text-center">Droppy installation</h3>
                          <p class="narrow text-center">
                              Thank you for purchasing our product, before you can use Droppy you need to follow these small steps.
                          </p>
                          
                          <p class="text-center">
                    		<a href="?page=1" class="btn btn-success btn-outline-rounded green"> Start the installation</a>
            			  </p>
                      	</div>
                      <?php
                      	endif;
                      	if($_GET['page'] == 1) :
                      		if($_GET['db'] == 'error') {
                  	  			echo '<div class="alert alert-danger" role="alert" style="margin-right: auto; margin-left: auto; width: 70%; text-align: center;">Droppy could not connect to the database please try again !</div>';
                  	  		}
                      ?>
                  		<h3 style="text-align: center;">Droppy database settings</h3>
                  		<form method="POST" action='install.php'>
                          <div class="narrow text-center" style="margin-left: auto; margin-right: auto; width: 70%; padding-top: 20px;">
 								<input type="hidden" name="action" value="dbsettings">
	                            <div class="input-group" style="padding-top: 10px;">
	                            	<div class="input-group-addon"><i class="fa fa-database"></i></div>
									<input type="text" class="form-control" name="dbhost" placeholder="Database host" required="required">
								</div>
								<div class="input-group" style="padding-top: 10px;">
									<div class="input-group-addon"><i class="fa fa-database"></i></div>
									<input type="text" class="form-control" name="dbuser" placeholder="Database username" required="required">
								</div>
								<div class="input-group" style="padding-top: 10px;">
									<div class="input-group-addon"><i class="fa fa-database"></i></div>
									<input type="password" class="form-control" name="dbpass" placeholder="Database password" required="required">
								</div>
								<div class="input-group" style="padding-top: 10px;">
									<div class="input-group-addon"><i class="fa fa-database"></i></div>
									<input type="text" class="form-control" name="dbname" placeholder="Database name" required="required">
								</div>
							
                          </div>
                          <p class="text-center">
                    		<input type="submit" class="btn btn-success btn-outline-rounded green" value="Submit">
            			  </p>
            			  </form>
                  	  <?php
                  	  	endif;
                  	  	if($_GET['page'] == 2) :
                  	  ?>
                  		<h3 style="text-align: center;">Create admin user</h3>
                  		<form method="POST" action='install.php'>
                          <div class="narrow text-center" style="margin-left: auto; margin-right: auto; width: 70%; padding-top: 20px;">
 								<input type="hidden" name="action" value="createuser">
	                            <div class="input-group" style="padding-top: 10px;">
	                            	<div class="input-group-addon"><i class="fa fa-user"></i></div>
									<input type="email" class="form-control" name="email" placeholder="Admin e-mail" required="required">
								</div>
								<div class="input-group" style="padding-top: 10px;">
									<div class="input-group-addon"><i class="fa fa-lock"></i></div>
									<input type="password" class="form-control" name="password" placeholder="Admin password" required="required">
								</div>
	                      </div>
	                      <p class="text-center">
	                		<input type="submit" class="btn btn-success btn-outline-rounded green" value="Create user">
	        			  </p>
	        			  </form>
                  	  <?php
                  	  	endif;
                  	  	if($_GET['page'] == 3) :
                  	  ?>
                  		<h3 style="text-align: center;">Completed !</h3>
                  		<div style="padding-top: 40px; text-align: center;">
                  			<p>The installation of droppy has been finished successfully !</p>
                  			<p>You can login to your admin panel <a href="admin/index.php">here</a>.</p>
                  			<p>Do not forget to delete this file (install.php) !</p>
                  		</div>
                  		<p class="text-center">
	                		<a href="index.php" class="btn btn-success btn-outline-rounded green"><i class="glyphicon glyphicon-home"></i> Go to home page</a>
	        			</p>
                  	  <?php
                  	  	endif;
                  	  ?>
					  </div>
<div class="clearfix"></div>
</div>

</div>
</div>
</div>
</section>
</body>

<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="src/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(function(){
$('a[title]').tooltip();
});

</script>