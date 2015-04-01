<?php
/*
Title: Droppy installation

Thanks to riliwanrabo for design
*/

error_reporting(0);

ob_start();

include 'config/config.php';

if($_GET['action'] == 'updatetables') {	
	$mysqli->query("ALTER TABLE $table_settings ADD COLUMN smtp_auth varchar(1000) AFTER smtp_host");
	$mysqli->query("ALTER TABLE $table_uploads ADD COLUMN flag varchar(1000) AFTER destruct");
	$mysqli->query("CREATE TABLE IF NOT EXISTS `$table_receivers` (
					  `id` int(100) NOT NULL AUTO_INCREMENT,
					  `upload_id` varchar(100) NOT NULL,
					  `email` varchar(100) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1");
	$mysqli->query("ALTER TABLE $table_downloads ADD COLUMN email varchar(1000) AFTER ip");
	$mysqli->query("INSERT INTO $table_templates (type,msg) VALUES ('downloaded','No template have been set, see the Droppy demo for examples')");
	$mysqli->query("INSERT INTO $table_templates (type,msg) VALUES ('downloaded_subject','No template have been set, see the Droppy demo for examples')");

	header('Location: update.php?update=success');
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
				<div id="tab-content">
					<div class="tab-pane" id="home">
						<?php
						if(!isset($_GET['update'])) :
						?>
						<div style="padding-top: 60px;">
						<h3 class="head text-center">Droppy update</h3>
						<p class="narrow text-center">
						Update of Droppy to version 1.0.4<br><br>
						<a href="?action=updatetables" class="btn btn-info">Update Droppy</a>
						</p>
						</div>
						<?php
						endif;
						if($_GET['update'] == 'success') :
						?>
						<div style="padding-top: 60px;">
						<h3 class="head text-center">Droppy update</h3>
						<p class="narrow text-center">
						Your tables have been successfully updated !<br>
						You can now close this window
						</p>
						</div>
						<?php
						endif;
						?>
					</div>
				</div>
				<div class="clearfix"></div>
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