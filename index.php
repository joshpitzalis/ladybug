<?php

//Inlcude translation file
include 'config/config.php';
include 'config/language/' . $language;

ob_start();

//Turning off error reporting
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $site_desc; ?>">

    <title><?php echo $site_title; ?></title>
	
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/png" href="<?php echo $favicon_path; ?>"/>

	<!-- Loading Bootstrap -->
    <link href="src/css/bootstrap/bootstrap.min.css" rel="stylesheet">
	
	<!-- Loading some custom styles -->
	<link href="src/css/droppy.css" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	<style>
		html { 
		  background: url(<?php echo $background; ?>) no-repeat center center fixed; 
		  -webkit-background-size: cover;
		  -moz-background-size: cover;
		  -o-background-size: cover;
		  background-size: cover;
		}
	</style>
</head>

<?php
$download_id = mysqli_real_escape_string($mysqli, $_GET['download']);
$get_info = $mysqli->query("SELECT * FROM $table_uploads WHERE upload_id='$download_id' AND status='ready'");
?>

<body>
<div class="MainOuter">
	<div class="MainMiddle">
		<div id="errorDiv" style="width: 88%;">
			<?php
			if($_GET['e'] == 'wrong') {
				echo '<div class="alert alert-danger" role="alert">Invalid password !</div>';
			}
			?>
		</div>
			<div class="MainContent">
				<?php
				$check_id = $get_info->num_rows;
				if(isset($_GET['download'])) :
					if($check_id == 1) :	
						while($rows = $get_info->fetch_assoc()) {
							if($rows['password'] != 'EMPTY') :
							?>				
								<div class="main" id="downloadDiv">
									<a href="index.php"><img src="<?php echo $logo_path; ?>" class="logo" alt="Logo"></a><hr>
									<div style="width: 70%; margin-left: auto; margin-right: auto; text-align:center;">
										<div id="downloadLogo"><i class="fa fa-lock fa-5x" style="padding-top: 35px;"></i></div>
										<p id="statusDownload" style="padding-top: 30px;"><?php echo $text['fill_password']; ?>:</p>
										<form id="downloadPassword" action="src/action.php" method="post">
											<div class="form-group">
												<input type="hidden" name="action" id="action" value="download">
												<input type="hidden" name="secret_code" id="secret_code" value="<?php echo $rows['secret_code']; ?>">
												<input type="hidden" name="download_id" id="download_id" value="<?php echo $download_id; ?>">
												<input type="password" class="form-control" id="password" name="password" placeholder="<?php echo $text['password']; ?>" required="required">
											</div>
											<?php
											if($rows['destruct'] == 'YES') :
											?>
											<input type="submit" class="btn btn-default btn-block" id="submitdownload" value="<?php echo $text['download']; ?> & <?php echo $text['destruct']; ?>">
											<?php
											else :
											?>
											<input type="submit" class="btn btn-default btn-block" id="submitdownload" value="<?php echo $text['download']; ?>">
											<?php
											endif;
											?>
										</form>
									</div>
								</div>
							<?php
							else :
							?>
								<div class="main" id="downloadDiv">
									<img src="src/images/logo.png" class="logo" alt="Logo"><hr>
									<div style="width: 70%; margin-left: auto; margin-right: auto;" id="downloadForm">
										<form id="downloadItems" action="src/action.php" method="post">
											<input type="hidden" name="action" id="action" value="download">
											<input type="hidden" name="secret_code" id="secret_code" value="<?php echo $rows['secret_code']; ?>">
											<input type="hidden" name="download_id" id="download_id" value="<?php echo $download_id; ?>">
											<div style="text-align:center;"><i class="fa fa-cloud-download fa-5x"></i></div>
											<div style="padding-top: 5px;">
												<table>
													<tr>
														<td><b><?php echo $text['total_size']; ?>:</b></td>
														<td class="td_2"><?php echo round($rows['size'] / 1048576, 2); ?> MB</td>
													</tr>
													<tr>
														<td><b><?php echo $text['total_files']; ?>:</b></td>
														<td class="td_2"><?php echo $rows['count']; ?></td>
													</tr>
													<tr>
														<td><b><?php echo $text['download_id']; ?>:</b></td>
														<td class="td_2"><?php echo $download_id; ?></td>
													</tr>
												</table>
												<b><?php echo $text['files']; ?>:</b>
												<div style="height: 60px; overflow-x: hidden;">
												<ul>
												<?php
												$get_files = $mysqli->query("SELECT * FROM $table_files WHERE upload_id='$download_id'");
												while($row = $get_files->fetch_assoc()) {
													echo '<li>' . $row['file'] . '</li>';
												}
												?>
												</ul>
												</div>
												<?php
												if(!empty($rows['message'])) :
												?>
												<b><?php echo $text['message']; ?>:</b>
												<div style="height: 70px; overflow: auto;">
												<?php echo $rows['message']; ?>
												</div>
												<?php endif; ?>
											</div>
											<div class="buttonSection" style="width: 70%;">
												<?php
												if($rows['destruct'] == 'YES') :
												?>
												<input type="submit" class="btn btn-default btn-block" id="submitpassword" value="<?php echo $text['download']; ?> & <?php echo $text['destruct']; ?>">
												<?php
												else :
												?>
												<input type="submit" class="btn btn-default btn-block" id="submitpassword" value="<?php echo $text['download']; ?>">
												<?php
												endif;
												?>
											</div>
										</form>
									</div>
									<div id="downloadSuccess" style="width: 70%; margin-left: auto; margin-right: auto; display: none;">
										<div style="text-align:center; padding-top: 25px;"><i class="fa fa-check-circle-o fa-5x"></i></div>
										<div style="padding-top: 15px;">
											<p><?php echo $text['download_started']; ?></p>
										</div>
										<div class="buttonSection" style="width: 70%;">
											<a class="btn btn-info btn-block" href="index.php"><?php echo $text['ok']; ?></a>
										</div>
									</div>
								</div>
							<?php
							endif;
						}
					else :
					?>
					<div class="main" id="downloadDiv">
						<div id="downloadError" style="width: 70%; margin-left: auto; margin-right: auto;">
							<div style="text-align:center; padding-top: 150px;"><i class="fa fa-exclamation-triangle fa-5x"></i></div>
							<div style="padding-top: 15px;">
								<p><?php echo $text['upload_not_found']; ?></p>
							</div>
							<div class="buttonSection" style="width: 70%;">
								<a class="btn btn-info btn-block" href="index.php"><?php echo $text['ok']; ?></a>
							</div>
						</div>
					</div>
					<?php
					endif;
				//Normal home page
				else :
				?>
				<form enctype="multipart/form-data" id="uploadForm">
				<div class="bounceInLeft animated">
					<!-- Normal view div -->
					<div class="main" id="uploadDiv">			
						<img src="src/images/logo.png" class="logo" alt="Logo">
						<hr>
						<div class="FormContent">
							<div class="upload_section">
								<div class="input-group">
									<span class="input-group-btn">
										<span class="btn btn-primary btn-file">
											<?php echo $text['select_files']; ?> <input type="file" name="files[]" id="files" multiple="true" required="required">
										</span>
									</span>
									<input type="text" class="form-control" disabled>
								</div>
							</div>
							<div style="float: right; height: 15px;">
								<p style="font-size: 13px;"><i>Max. <?php echo $max_size; ?> MB</i></p>
							</div><br>
							<div class="EmailToSection" id="EmailToSection">
								<div class="form-group" id="receivers">
									<div id="receiverHiddenList"></div>
									<div id="receiverList" class="receiverList" style="display: none;"></div>
									<input type="email" class="form-control" id="emailTo" name="email_to[]" placeholder="<?php echo $text['enter_email']; ?>" required="required">
									<div style="padding-top: 5px;"><a onclick="addReceiver()" class="btn btn-default btn-xs" style="width: 100%;"><?php echo $text['add_more']; ?></a></div>
								</div>							
							</div>
							<div class="EmailFromSection" id="EmailFromSection">
								<div class="form-group">
									<input type="email" class="form-control" id="emailFrom" name="email_from" placeholder="<?php echo $text['enter_own_email']; ?>" required="required">
								</div>
							</div>
							<div class="MessageSection">
								<div class="form-group">
									<textarea class="form-control" rows="3" style="resize: none;" name="message" id="message" placeholder="<?php echo $text['message_receiver']; ?>" maxlength="1000"></textarea>
								</div>
							</div>
							<div class="buttonSection">
								<div style="width: 72%; float: left;">
									<button type="button" class="btn btn-info btn-block" id="submit_upload"><?php echo $text['share_files']; ?></button>
								</div>
								<div style="float: left; padding-left: 16px;">
									<button type="button" class="btn btn-success" id="settingsButton" onclick="openSettings();"><i class="fa fa-cog"></i></button>
								</div>
							</div>
						</div>
					</div>
					<!-- End normal view div -->
					<!-- Social buttons div -->
					<div class="social" id="uploadDivSocial">
						<?php
						if(!empty($social_facebook)) :
						?>
						<a href="<?php echo $social_facebook; ?>" class="btn btn-social-icon btn-facebook btn-lg"><i class="fa fa-question-circle"></i></a>
						<?php
						endif;
						if(!empty($social_twitter)) :
						?>
						<a href="<?php echo $social_twitter; ?>" class="btn btn-social-icon btn-twitter btn-lg"><i class="fa fa-twitter"></i></a>
						<?php
						endif;
						if(!empty($social_tumblr)) :
						?>
						<a href="<?php echo $social_tumblr; ?>" class="btn btn-social-icon btn-tumblr btn-lg"><i class="fa fa-tumblr"></i></a>
						<?php
						endif;
						if(!empty($social_google)) :
						?>
						<a href="<?php echo $social_google; ?>" class="btn btn-social-icon btn-google-plus btn-lg"><i class="fa fa-google"></i></a>
						<?php
						endif;
						if(!empty($social_instagram)) :
						?>
						<a href="<?php echo $social_instagram; ?>" class="btn btn-social-icon btn-instagram btn-lg"><i class="fa fa-instagram"></i></a>
						<?php
						endif;
						if(!empty($social_github)) :
						?>
						<a href="<?php echo $social_github; ?>" class="btn btn-social-icon btn-github btn-lg"><i class="fa fa-github"></i></a>
						<?php
						endif;
						if(!empty($social_pinterest)) :
						?>
						<a href="<?php echo $social_pinterest; ?>" class="btn btn-social-icon btn-google-plus btn-lg"><i class="fa fa-pinterest"></i></a>
						<?php
						endif;
						?>
					</div>
					<!-- End social buttons div -->
					<!-- Upload settings div -->
					<div class="uploadSettings" id="uploadSettings" style="display: none;">
						<div class="settingsContent">
							<div style="float: left;" class="form-group">
				        		<p>Select how to share:</p>	        		
				        		<div class="btn-group" data-toggle="buttons">
								  <label class="btn btn-primary active">
								    <input type="radio" name="options" id="option1" autocomplete="off" onchange="shareEmail();" checked> <?php echo $text['email']; ?>
								  </label>
								  <label class="btn btn-primary">
								    <input type="radio" name="options" id="option2" autocomplete="off" onchange="shareLink();"> <?php echo $text['link']; ?>
								  </label>
								  <input type="hidden" name="share" id="share" value="mail">
								</div>
							</div>
							<div style="float: right; width: 170px;" class="form-group">
								<p style=""><?php echo $text['add_password']; ?>:</p>
								<input type="password" name="password" id="password" class="form-control" placeholder="<?php echo $text['password']; ?>">
							</div>
							<div style="bottom: 0; float: left; clear: both;">
  								<span class="button-checkbox">
							        <button type="button" class="btn btn-sm" data-color="primary"><?php echo $text['enable_destuct']; ?></button>
							        <input type="checkbox" class="hidden" name="destruct" value="yes" checked />
							    </span>
							</div>
							<div style="float: right; padding-top: 1px;">
								<a onclick="closeSettings();" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> <?php echo $text['close']; ?></a>
							</div>
			        	</div>
					</div>
					<!-- End upload settings div -->
				</div>
				</form>
				<!-- Progress and succes div -->
				<div class="main" id="uploadingDiv" style="display: none;">
					<div id="uploadProcess" class="progressround">			
						<input type="text" value="" class="progressCircle" id="progresscircle">
						<div id="progressMb" style="padding-top: 20px;"></div>
					</div>
					<div id="loadingMessage" style="display: none; width: 100%; padding-top: 180px; text-align: center;">
						<i class="fa fa-cog fa-spin fa-5x"></i>
						<p><?php echo $text['processing_files']; ?></p>
					</div>
					<div id="uploadSuccess" class="progresssuccess" style="display: none;">
						<img src="src/images/loader.gif" width="250" height="250">
						<h2 align="center"><?php echo $text['success']; ?></h2>
						<div id="linkMessage" style="display: none">
							<p><?php echo $text['success_link']; ?></p>
							<div id="downloadLink"></div>
						</div>
						<div id="emailMessage" style="display: none">
							<p><?php echo $text['success_email']; ?></p>
						</div>
						<div class="buttonSection" style="bottom: -65px;">
							<a type="button" href="index.php" class="btn btn-success btn-block"><?php echo $text['ok']; ?></a>
						</div>
					</div>
				</div>
				<!-- End progress and succes div -->
				<div class="social" id="uploadingDivSocial" style="display: none;">
					<a href="http://twitter.com" class="btn btn-social-icon btn-twitter btn-lg"><i class="fa fa-twitter"></i></a>
					<a href="http://tumblr.com" class="btn btn-social-icon btn-tumblr btn-lg"><i class="fa fa-tumblr"></i></a>
					<a href="http://facebook.nl" class="btn btn-social-icon btn-facebook btn-lg"><i class="fa fa-facebook"></i></a>
				</div>
				<?php
				endif;
				?>
			</div>
	</div>
</div>
</body>

<!-- Loading jQuery -->
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>

<!-- Loading Bootstrap -->
<script src="src/js/bootstrap.min.js"></script>

<!-- Loading custom js -->
<script src="src/js/droppy.js"></script>
<script src="src/js/jquery.knob.min.js"></script>

<!-- Translating some variables from php to javascript -->
<script type="text/javascript">
var maxSize = <?php echo $max_size; ?>;
var siteUrl = "<?php echo $site_url; ?>";
var msg_download_started = "<?php echo $text['download_started']; ?>";
var msg_fill_fields = "<?php echo $text['fill_fields']; ?>";
var msg_upload_error = "<?php echo $text['upload_error']; ?>";
var msg_file_to_large = "<?php echo $text['file_to_large']; ?>";
var msg_wrong_pass = "<?php echo $text['wrong_pass']; ?>";
</script>
</html>