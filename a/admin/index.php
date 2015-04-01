<?php
include '../config/config.php';

//Turning off error reporting
error_reporting(0);

ob_start();

session_start();

if(!isset($_SESSION['droppy_admin'])) {
  header('Location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Droppy - Admin panel">
    <meta name="author" content="Proxibolt">
    <meta name="keyword" content="">

    <title><?php echo $site_name; ?> - Admin Panel</title>

    <link rel="shortcut icon" type="image/png" href="../<?php echo $favicon_path; ?>"/>

    <!-- Bootstrap core CSS -->
    <link href="../src/css/bootstrap/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../src/plugins/lineicons/style.css">   
    
    <!-- Custom styles for this template -->
    <link href="../src/css/admin.css" rel="stylesheet">
    <link href="../src/css/admin-responsive.css" rel="stylesheet">

    <script src="../src/plugins/chart-master/Chart.js"></script>
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="index.html" class="logo"><b><?php echo $site_name; ?> | Admin</b></a>
            <!--logo end-->
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="action.php?action=logout">Logout</a></li>
            	</ul>
            </div>
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
                  <li class="mt">
                      <a href="index.php">
                          <i class="fa fa-dashboard"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-cogs"></i>
                          <span>Settings</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="?page=settings_general">General settings</a></li>
                          <li><a  href="?page=settings_mail">Email settings</a></li>
                          <li><a  href="?page=settings_templates">Email templates</a></li>
                          <li><a  href="?page=settings_social">Social settings</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="?page=uploads">
                          <i class="fa fa-cloud-upload"></i>
                          <span>Uploads</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a href="?page=downloads">
                          <i class="fa fa-cloud-download"></i>
                          <span>Downloads</span>
                      </a>
                  </li>
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content"> 
      <?php
      switch ($_GET['page']) {
          default:
            $size = array();
            $count_disk = $mysqli->query("SELECT * FROM $table_uploads WHERE status='ready'");
            while($row = $count_disk->fetch_assoc()) {
              $size[] = $row['size'];
            }
            $total_size = round(array_sum($size) / 1048576, 2);
      ?>
          <section class="wrapper">

          <div class="row">
            <div class="col-lg-11 main-chart">
              <?php
              if(file_exists("../install.php")) {
                echo '<div class="alert alert-warning" role="alert" style="text-align: center;">Please delete the <b>install.php</b> file from the home directory of Droppy !</div>';
              }
              if(file_exists("../update.php")) {
                echo '<div class="alert alert-danger" role="alert" style="text-align: center;">Please delete the <b>update.php</b> file from the home directory of Droppy !</div>';
              }
              $permission = substr(sprintf("%o",fileperms("../uploads/")),-4);
              if($permission != '0777') {
                echo '<div class="alert alert-info" role="alert" style="text-align: center;">Please change the permssion of the <b>uploads</b> directory to 777 (See documentation)</div>';
              }
              ?>
            	<div class="row mtbox">
                <?php
                $get_all_uploads = $mysqli->query("SELECT * FROM $table_uploads");
                $get_all_active_uploads = $mysqli->query("SELECT * FROM $table_uploads WHERE status='ready'");
                $get_all_downloads = $mysqli->query("SELECT * FROM $table_downloads");
                $get_all_destroyed = $mysqli->query("SELECT * FROM $table_uploads WHERE status='destroyed'");
                ?>
            		<div class="col-md-2 col-sm-2 col-md-offset-2 box0">
            			<div class="box1">
		  			        <i class="fa fa-cloud-upload fa-5x"></i>
		  			        <h3><?php echo $get_all_uploads->num_rows; ?></h3>
            			</div>
		  			      <p>A total of <?php echo $get_all_uploads->num_rows; ?> uploads have been processed </p>
            		</div>
            		<div class="col-md-2 col-sm-2 box0">
            			<div class="box1">
  					  			<i class="fa fa-cloud fa-5x"></i>
  					  			<h3><?php echo $get_all_active_uploads->num_rows; ?></h3>
            			</div>
					  			<p><?php echo $get_all_active_uploads->num_rows; ?> active files are ready for download.</p>
            		</div>
            		<div class="col-md-2 col-sm-2 box0">
            			<div class="box1">
  					  			<i class="fa fa-cloud-download fa-5x"></i>
  					  			<h3><?php echo $get_all_downloads->num_rows; ?></h3>
                    			</div>
  					  			<p><?php echo $get_all_downloads->num_rows; ?> downloads have been made.</p>
            		</div>
            		<div class="col-md-2 col-sm-2 box0">
            			<div class="box1">
  					  			<i class="fa fa-trash fa-5x"></i>
  					  			<h3><?php echo $get_all_destroyed->num_rows; ?></h3>
                  </div>
  					  		<p><?php echo $get_all_destroyed->num_rows; ?> items have been destroyed</p>
            		</div>                	
            	</div><!-- /row mt -->	
                  
                      
          <div class="row mt">                                      
          	<div class="col-md-4 col-sm-4 mb">
          		<div class="white-panel pn">
          			<div class="white-header">
  			           <h5>MOST DOWNLOADED</h5>
          			</div>
            		<div class="centered" style="padding-top: 20px;">
                <?php
                $get_most_downloaded = $mysqli->query("
                SELECT download_id, COUNT(*) AS magnitude 
                FROM $table_downloads 
                GROUP BY download_id 
                ORDER BY magnitude DESC
                LIMIT 1");
                while($row_downloads = $get_most_downloaded->fetch_assoc()) {
                  $download_id = $row_downloads['download_id'];
									echo '<p><i style="font-wheight: bold;">ID:</i> <a href="' . $site_url . $download_id . '">' . $download_id . '</a></p>';
                  echo '<p><i style="font-wheight: bold;">Downloads:</i>' . $row_downloads['magnitude'] . '</p>';
                }
                ?>
                </div>
          		</div>
          	</div><!-- /col-md-4 -->
            
            <!-- SERVER STATUS PANELS -->
            <div class="col-md-4 mb">
             <div class="white-panel pn">
                <div class="white-header">
                   <h5>DISK STATICS</h5>
                </div>
                <div style="text-align: center; padding-top: 20px;">
                  <i class="fa fa-server fa-5x" style="font-size: 70px;"></i>
                  <h2><?php echo $total_size; ?> MB used</h2>
                </div>  
              </div><!-- /white panel -->
            </div><!-- /col-md-4 -->

						<div class="col-md-4 mb">
							<!-- WHITE PANEL - TOP USER -->
							<div class="white-panel pn">
								<div class="white-header">
									<h5>LATEST UPLOAD</h5>
								</div>
								<?php
                $get_latest_upload = $mysqli->query("SELECT * FROM $table_uploads ORDER BY time DESC LIMIT 1");
                while($row = $get_latest_upload->fetch_assoc()) {
                  $upload_id = $row['upload_id'];
                ?>
                <div style="padding-top: 20px; text-align: left;">
                  <p><i style="font-wheight: bold;">ID:</i> <a href="<?php echo $site_url . $upload_id; ?>"><?php echo $upload_id; ?></a></p>
                  <p><i style="font-wheight: bold;">Time:</i> <?php echo date("F j, Y, g:i a", $row['time']); ?></p>
                  <p><i style="font-wheight: bold;">Size:</i> <?php echo round(array_sum($row['size']) / 1048576, 2); ?></p>
                  <p><i style="font-wheight: bold;">Password:</i> <?php if($row['password' == 'EMPTY']) { echo 'No'; } else { echo 'Yes'; } ?></p>
                  <p><i style="font-wheight: bold;">Deleted:</i> <?php if($row['status'] == 'destroyed') { echo 'Yes'; } else { echo 'No'; } ?></p>
                </div>
                <?php
                }
                ?>
							</div>
						</div><!-- /col-md-4 -->
          </div><!-- /row -->                                				
        </div><!-- /col-lg-9 END SECTION MIDDLE -->
                  
                  
      <!-- **********************************************************************************************************************************************************
      RIGHT SIDEBAR CONTENT
      *********************************************************************************************************************************************************** -->                  
              </div><! --/row -->
          </section>
      </section>
      <?php
      break;
      case 'settings_general':
      ?>
      <section class="wrapper">
        <div class="row mt">
                <div class="col-lg-12">
                    <div class="form-panel" style="overflow:hidden;">
                        <h4 class="mb"><i class="fa fa-angle-right"></i> General Settings</h4>
                        <form class="form-horizontal style-form" method="post" action="action.php">
                          <input type="hidden" name="action" value="settings_general">
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Site name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="site_name" class="form-control" value="<?php echo $site_name; ?>">
                                    <i>Your site name, Eg: Droppy</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Site title</label>
                                <div class="col-sm-10">
                                    <input type="text" name="site_title" class="form-control" value="<?php echo $site_title; ?>">
                                    <i>Your site title, Eg: Droppy - Online file sharing (This will be shown in a browser tab)</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Site description (Search engines)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="site_desc" class="form-control" value="<?php echo $site_desc; ?>">
                                    <i>Description of your website</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Site url</label>
                                <div class="col-sm-10">
                                    <input type="text" name="site_url" class="form-control" value="<?php echo $site_url; ?>">
                                    <i>The url of your website</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Logo path</label>
                                <div class="col-sm-10">
                                    <input type="text" name="logo_path" class="form-control" value="<?php echo $logo_path; ?>">
                                    <i>Path to your logo image</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Favicon path</label>
                                <div class="col-sm-10">
                                    <input type="text" name="favicon_path" class="form-control" value="<?php echo $favicon_path; ?>">
                                    <i>Path to your favicon image</i>
                                </div>
                            </div>
                            <div class="form-group" id="backgrounds">
                                <label class="col-sm-2 col-sm-2 control-label">Background</label>
                                <div class="col-sm-10">
                                    <?php
                                    $get_backgrounds = $mysqli->query("SELECT * FROM $table_backgrounds");
                                    if($get_backgrounds->num_rows == 0) :
                                    ?>
                                    <input type="text" name="background[]" class="form-control" placeholder="Background path"><br>
                                    <input type="text" name="background_url[]" class="form-control" placeholder="Background href (Leave empty for nothing)"><hr>
                                    <div id="extraBG"></div>
                                    <?php
                                    else :
                                    ?>
                                    <div id="extraBG">
                                    <?php
                                    while($rows = $get_backgrounds->fetch_assoc()){
                                      echo '<div style="padding-top: 30px;"><input type="text" name="background[]" class="form-control" value="' . $rows['src'] . '" disabled><br>';
                                      echo '<input type="text" name="background_url[]" class="form-control" value="' . $rows['url'] . '" disabled>
                                      <div style="float: right; padding-right: 5px;"><a href="action.php?action=rm_bg&id=' . $rows['id'] . '" class="btn btn-danger btn-sm">Delete</a></div><br></div>';
                                    }
                                    ?>
                                    </div>
                                    <?php
                                    endif;
                                    ?>
                                    <div style="float: right; padding-right: 5px; padding-top: 20px; clear: both;">
                                      <button type="button" onclick="add_bg_section()" class="btn btn-primary btn-sm">Add background input</button>
                                    </div>
                                    <i>Path to your background images</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Slide timer</label>
                                <div class="col-sm-10">
                                    <input type="text" name="bg_timer" class="form-control" value="<?php echo $bg_timer; ?>">
                                    <i>The time between every background image (Seconds) input 0 to disable this function</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Language</label>
                                <div class="col-sm-10">
                                    <input type="text" name="lang" class="form-control" value="<?php echo $language; ?>">
                                    <i>Only language file name not path !</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Expire time</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="expire">
                                        <optgroup label="Hours">
                                          <option value="3600" <?php if($expire == '3600') { echo 'selected'; } ?>>1 Hour</option>
                                          <option value="10800" <?php if($expire == '10800') { echo 'selected'; } ?>>3 Hours</option>
                                          <option value="18000" <?php if($expire == '18000') { echo 'selected'; } ?>>5 Hours</option>
                                          <option value="28800" <?php if($expire == '28800') { echo 'selected'; } ?>>8 Hours</option>
                                          <option value="36000" <?php if($expire == '36000') { echo 'selected'; } ?>>10 Hours</option>
                                          <option value="43200" <?php if($expire == '43200') { echo 'selected'; } ?>>12 Hours</option>
                                          <option value="50400" <?php if($expire == '50400') { echo 'selected'; } ?>>14 Hours</option>
                                          <option value="57600" <?php if($expire == '57600') { echo 'selected'; } ?>>16 Hours</option>
                                          <option value="64800" <?php if($expire == '64800') { echo 'selected'; } ?>>18 Hours</option>
                                          <option value="72000" <?php if($expire == '72000') { echo 'selected'; } ?>>20 Hours</option>
                                          <option value="79200" <?php if($expire == '79200') { echo 'selected'; } ?>>22 Hours</option>
                                        </optgroup>
                                        <optgroup label="Days">
                                          <option value="86400" <?php if($expire == '86400') { echo 'selected'; } ?>>1 Day</option>
                                          <option value="172800" <?php if($expire == '172800') { echo 'selected'; } ?>>2 Days</option>
                                          <option value="259200" <?php if($expire == '259200') { echo 'selected'; } ?>>3 Days</option>
                                          <option value="345600" <?php if($expire == '345600') { echo 'selected'; } ?>>4 Days</option>
                                          <option value="432000" <?php if($expire == '432000') { echo 'selected'; } ?>>5 Days</option>
                                          <option value="518400" <?php if($expire == '518400') { echo 'selected'; } ?>>6 Days</option>
                                        </optgroup>
                                        <optgroup label="Weeks">
                                          <option value="604800" <?php if($expire == '604800') { echo 'selected'; } ?>>1 Week</option>
                                          <option value="1209600" <?php if($expire == '1209600') { echo 'selected'; } ?>>2 Weeks</option>
                                        </optgroup>
                                    </select>
                                    <p><i>Time till a file gets destroyed</i></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Max upload size <b>(MB)</b></label>
                                <div class="col-sm-10">
                                    <input type="number" name="max_upload" class="form-control" value="<?php echo $max_size; ?>">
                                    <i>Maximum upload size in MB</i>
                                </div>
                            </div>
                            <!--<div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Max allowed files</label>
                                <div class="col-sm-10">
                                    <input type="number" name="max_files" class="form-control" value="">
                                    <i>How many files a user may select for a upload (Set 0 for unlimited)</i>
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Blocked file types</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="blocked_types" style="width: 100%; height: 100px;"><?php echo $disallowed_types; ?></textarea>
                                    <i>Choose which file type(s) have to be blocked. (Split values with  a comma ',' and without any space between them, All file types can be found <a href="http://www.iana.org/assignments/media-types/media-types.xhtml">here</a>)</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Upload directory</label>
                                <div class="col-sm-10">
                                    <input type="text" name="upload_dir" class="form-control" value="<?php echo $upload_dir; ?>">
                                    <i>Do not forget to add a "/" at the end</i>
                                </div>
                            </div>
                            <div style="float: right; padding-right: 5px;">
                              <button type="submit" class="btn btn-success" ><i class="fa fa-floppy-o"></i> Save</button>
                            </div>
                      </form>
                  </div>
              </div><!-- col-lg-12-->       
          </div><!-- /row -->
      </section>
      <?php
      break;
      case 'settings_mail':
      ?>
      <section class="wrapper">
        <div class="row mt">
                <div class="col-lg-12">
                    <div class="form-panel" style="overflow:hidden ;">
                        <h4 class="mb"><i class="fa fa-angle-right"></i> E-Mail Settings</h4>
                        <form class="form-horizontal style-form" method="post" action="action.php">
                          <input type="hidden" name="action" value="settings_mail">
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Email from (Name)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="email_from_name" class="form-control" value="<?php echo $email_from_name; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Email from (E-Mail)</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email_from_email" class="form-control" value="<?php echo $email_from_email; ?>">
                                </div>
                            </div>                          
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Email Server</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="email_server" id="email_server" onchange="emailServer()">
                                        <option value="<?php echo $email_server; ?>" selected style="display:none;"><?php echo $email_server; ?></option>
                                        <option value="LOCAL">Local</option>
                                        <option value="SMTP">SMTP</option>
                                    </select>
                                </div>
                            </div>
                            <div id="smtpSection" <?php if($email_server == 'LOCAL') { echo 'style="display: none;"'; } ?>>                           
                              <div class="form-group">
                                  <label class="col-sm-2 col-sm-2 control-label">SMTP Host</label>
                                  <div class="col-sm-10">
                                      <input type="text" name="smtp_host" class="form-control" value="<?php echo $smtp_host; ?>">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-2 col-sm-2 control-label">SMTP Auth</label>
                                  <div class="col-sm-10">
                                      <select class="form-control" name="smtp_auth">
                                          <option value="true" <?php if($smtp_auth == 'true') { echo 'selected'; } ?>>On</option>
                                          <option value="false" <?php if($smtp_auth == 'false') { echo 'selected'; } ?>>Off</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-2 col-sm-2 control-label">SMTP Port</label>
                                  <div class="col-sm-10">
                                      <input type="text" name="smtp_port" class="form-control" value="<?php echo $smtp_port; ?>">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-2 col-sm-2 control-label">SMTP Secure</label>
                                  <div class="col-sm-10">
                                      <select class="form-control" name="smtp_secure">
                                          <option value="tls" <?php if($smtp_secure == 'tls') { echo 'selected'; } ?>>TLS</option>
                                          <option value="ssl" <?php if($smtp_secure == 'ssl') { echo 'selected'; } ?>>SSL</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-2 col-sm-2 control-label">SMTP Username</label>
                                  <div class="col-sm-10">
                                      <input type="text" name="smtp_username" class="form-control" value="<?php echo $smtp_username; ?>">
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="col-sm-2 col-sm-2 control-label">SMTP Password</label>
                                  <div class="col-sm-10">
                                      <input type="password" name="smtp_password" class="form-control" placeholder="SMTP Password (Leave empty if you do not want to change it)">
                                  </div>
                              </div>
                            </div>
                            <div id="localSection" <?php if($email_server == 'SMTP') { echo 'style="display: none;"'; } ?>>
                              <div class="form-group">
                                <h4 style="text-align: center;">You have selected "Local server" there are no more options when Local server has been selected</h4>
                              </div>
                            </div>
                            <div style="float: right; padding-right: 5px;">
                              <button type="submit" class="btn btn-success" ><i class="fa fa-floppy-o"></i> Save</button>
                            </div>
                      </form>
                  </div>
              </div><!-- col-lg-12-->       
          </div><!-- /row -->
      </section>
      <?php
      break;
      case 'settings_templates':
      ?>
      <section class="wrapper">
        <div class="row mt">
                <div class="col-lg-12">
                    <div class="form-panel" style="overflow:hidden;">
                        <h4 class="mb"><i class="fa fa-angle-right"></i> E-Mail Templates</h4>
                        <form class="form-horizontal style-form" method="post" action="action.php">
                          <input type="hidden" name="action" value="settings_template">
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">E-Mail - Receivers</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="receiver_subject" placeholder="Receiver email subject" value="<?php echo $receiver_subject; ?>"><br>
                                    <textarea name="temp_receiver" class="form-control" style="width: 100%; height: 200px;"><?php echo $temp_receiver; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">E-Mail - Sender</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="sender_subject" placeholder="Sender email subject" value="<?php echo $sender_subject; ?>"><br>
                                    <textarea name="temp_sender" class="form-control" style="width: 100%; height: 200px;"><?php echo $temp_sender; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">E-Mail - Destroyed</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="destroyed_subject" placeholder="Receiver email subject" value="<?php echo $destroyed_subject; ?>"><br>
                                    <textarea name="temp_destroyed" class="form-control" style="width: 100%; height: 200px;"><?php echo $temp_destroyed; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">E-Mail - Downloaded</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="downloaded_subject" placeholder="Downloaded email subject" value="<?php echo $downloaded_subject; ?>"><br>
                                    <textarea name="temp_downloaded" class="form-control" style="width: 100%; height: 200px;"><?php echo $temp_downloaded; ?></textarea>
                                </div>
                            </div>
                            <div style="float: right; padding-right: 5px;">             
                              <button type="submit" class="btn btn-success" ><i class="fa fa-floppy-o"></i> Save</button>
                            </div>
                      </form>
                  </div>
              </div><!-- col-lg-12-->       
          </div><!-- /row -->
      </section>
      <?php
      break;
      case 'settings_social' :
      ?>
      <section class="wrapper">
        <div class="row mt">
                <div class="col-lg-12">
                    <div class="form-panel" style="overflow:hidden;">
                        <h4 class="mb"><i class="fa fa-angle-right"></i> Social settings</h4>
                        <form class="form-horizontal style-form" method="post" action="action.php">
                          <input type="hidden" name="action" value="settings_social">
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Facebook</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="facebook" placeholder="Facebook url" value="<?php echo $social_facebook; ?>">
                                    <p><i>Leave empty to disable it</i></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Twitter</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="twitter" placeholder="Twitter plus url" value="<?php echo $social_twitter; ?>">
                                    <p><i>Leave empty to disable it</i></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Google plus</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="google" placeholder="Google plus url" value="<?php echo $social_google; ?>">
                                    <p><i>Leave empty to disable it</i></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Instagram</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="instagram" placeholder="Instagram url" value="<?php echo $social_instagram; ?>">
                                    <p><i>Leave empty to disable it</i></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">GitHub</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="github" placeholder="GitHub url" value="<?php echo $social_github; ?>">
                                    <p><i>Leave empty to disable it</i></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Tumblr</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tumblr" placeholder="Tumblr url" value="<?php echo $social_tumblr; ?>">
                                    <p><i>Leave empty to disable it</i></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Pinterest</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="pinterest" placeholder="Pinterest url" value="<?php echo $social_pinterest; ?>">
                                    <p><i>Leave empty to disable it</i></p>
                                </div>
                            </div>
                            <div style="float: right; padding-right: 5px;">             
                              <button type="submit" class="btn btn-success" ><i class="fa fa-floppy-o"></i> Save</button>
                            </div>
                      </form>
                  </div>
              </div><!-- col-lg-12-->       
          </div><!-- /row -->
      </section>
      <?php
      break;
      case 'uploads':
      $get_files = $mysqli->query("SELECT * FROM $table_uploads");
      $count_uploads = $get_files->num_rows;
      ?>
      <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> Uploads
            <div style="float: right;"><button type="button" data-toggle="modal" data-target="#modalCleardb" class="btn btn-danger"><li class="fa fa-trash"></li> Clear DB</a></div></h3>
          <div class="row mt">
            <div class="col-lg-12">
                      <?php
                      if($_GET['msg'] == 'dbcleared') {
                        echo '<div class="alert alert-success" role="alert">Database has been cleared !</div>';
                      } 
                      if($_GET['msg'] == 'destroyed') {
                        echo '<div class="alert alert-success" role="alert">Upload has been destroyed</div>';
                      }
                      ?>
                      <div class="content-panel">
                          <section id="unseen" style="overflow:auto;">
                          <?php
                          if($count_uploads == 0) :
                          ?>
                          <h4>No uploads have been found</h4>
                          <?php
                          else:
                          ?>
                            <table class="table table-bordered table-striped table-condensed">
                              <thead>
                                <tr>
                                    <th>Flag</th>
                                    <th>ID</th>
                                    <th>Owner</th>
                                    <th>Upload date</th>
                                    <th>Files count</th>                               
                                    <th>Status</th>
                                    <th>Share type</th>
                                    <th>Password</th>
                                    <th class="numeric">Size (MB)</th>
                                    <th>IP</th>
                                    <th>Destruct</th>
                                    <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php
                                //Get table page
                                $rows_per_page = 20;
                                if(isset($_GET['table'])) {
                                  $table_page = $_GET['table'];
                                }
                                else
                                {
                                  $table_page = 0;
                                }                              
                                $current_table = $table_page * $rows_per_page;

                                $get_uploads = $mysqli->query("SELECT * FROM $table_uploads ORDER BY time DESC LIMIT $current_table, $rows_per_page"); 

                                //Echo table content
                                while($row = $get_uploads->fetch_assoc()) {
                                  echo '<tr>';
                                  if($row['flag'] == 'yes') {
                                    echo '<td><a onclick="rmFlag(\'' . $row['upload_id'] . '\')" alt="Remove flag" id="flag_' . $row['upload_id'] . '"><i class="fa fa-flag"></i></a></td>';
                                  }
                                  else
                                  {
                                    echo '<td></td>';
                                  }                          
                                  echo '<td><a href="../' . $row['upload_id'] . '">' . $row['upload_id'] . '</a></td>';
                                  if(empty($row['email_from'])) {
                                    echo '<td>Link (No Email)</td>';
                                  }
                                  else
                                  {
                                    echo '<td>' . $row['email_from'] . '</td>';
                                  }
                                  echo '<td>' . date("F j, Y, g:i a", $row['time']) . '</td>';
                                  echo '<td class="numeric">' . $row['count'] . '</td>';
                                  if($row['status'] == 'ready') {
                                    echo '<td ><i class="fa fa-check"></i> Ready</td>';
                                  }
                                  if($row['status'] == 'destroyed') {
                                    echo '<td><i class="fa fa-times"></i> Destroyed</td>';
                                  }
                                  if($row['share'] == 'mail') {
                                    echo '<td>Email</td>';
                                  }
                                  if($row['share'] == 'link') {
                                    echo '<td>Link</td>';
                                  }
                                  if($row['password'] == 'EMPTY') {
                                    echo '<td>No</td>';
                                  }
                                  else
                                  {
                                    echo '<td>Yes</td>';
                                  }
                                  echo '<td>' . round($row['size'] / 1048576, 2) . ' MB</td>';
                                  echo '<td>' . $row['ip'] . '</td>';
                                  if($row['destruct'] == 'YES') {
                                    echo '<td>Yes</td>';
                                  }
                                  elseif($row['destruct'] == 'NO') {
                                    echo '<td>No</td>';
                                  }
                                  if($row['status'] == 'ready') {
                                    echo '<td><a href="action.php?action=delete_upload&id=' . $row['upload_id'] . '"><i class="fa fa-trash"></i> Destroy</a></td>';
                                  }
                                  if($row['status'] == 'destroyed') {
                                    echo '<td></td>';
                                  }
                                  echo '</tr>';
                                }
                              ?>                          
                            </tbody>
                        </table>
                        <?php
                        //Pagination script
                        $get_all = $mysqli->query("SELECT * FROM $table_uploads");
                        $count_rows = $get_all->num_rows;
                        $total_pages = round($count_rows / $rows_per_page);
                        $page_up = $table_page + 1;
                        $page_down = $table_page - 1;
                        ?>
                        <div style="float: right; padding-right: 10px;">
                        <?php
                        if($table_page > 0):
                        ?>
                          <a href="?page=uploads&table=<?php echo $page_down; ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Prev</a>
                        <?php
                        endif;
                        if($total_pages > $table_page + 1) :
                        ?>
                          <a href="?page=uploads&table=<?php echo $page_up; ?>" class="btn btn-success">Next <i class="fa fa-arrow-right"></i></a>
                        <?php
                        endif;
                        ?>
                        </div>
                        <?php
                        endif;
                        ?>
                      </section>
                  </div><!-- /content-panel -->
               </div><!-- /col-lg-4 -->     
        </div><!-- /row -->
      </section><! --/wrapper -->
      <?php
      break;
      case 'downloads':
      $get_downloads = $mysqli->query("SELECT * FROM $table_downloads");
      $count_downloads = $get_downloads->num_rows;
      ?>
      <section class="wrapper">
            <h3><i class="fa fa-angle-right"></i> Downloads
            <div style="float: right;"><button type="button" data-toggle="modal" data-target="#modalCleardb" class="btn btn-danger"><li class="fa fa-trash"></li> Clear DB</a></div></h3>
          <div class="row mt">
            <div class="col-lg-12">
                      <?php
                      if($_GET['msg'] == 'dbcleared') {
                        echo '<div class="alert alert-success" role="alert">Database has been cleared !</div>';
                      } 
                      if($_GET['msg'] == 'destroyed') {
                        echo '<div class="alert alert-success" role="alert">Upload has been destroyed</div>';
                      }
                      ?>
                      <div class="content-panel">
                          <section id="unseen" style="overflow:auto;">
                          <?php
                          if($count_downloads == 0) :
                          ?>
                          <h4>No downloads have been found</h4>
                          <?php
                          else:
                          ?>
                            <table class="table table-bordered table-striped table-condensed">
                              <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Time</th>
                                    <th>IP</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php
                                //Get table page
                                $rows_per_page = 20;
                                if(isset($_GET['table'])) {
                                  $table_page = $_GET['table'];
                                }
                                else
                                {
                                  $table_page = 0;
                                }                              
                                $current_table = $table_page * $rows_per_page;

                                $get_uploads = $mysqli->query("SELECT * FROM $table_downloads ORDER BY time DESC LIMIT $current_table, $rows_per_page"); 

                                //Echo table content
                                while($row = $get_uploads->fetch_assoc()) {
                                  echo '<tr>';                                
                                  echo '<td><a href="../' . $row['download_id'] . '">' . $row['download_id'] . '</a></td>';
                                  echo '<td>' . date("F j, Y, g:i a", $row['time']) . '</td>';
                                  echo '<td>' . $row['ip'] . '</td>';
                                  echo '</tr>';
                                }
                              ?>                          
                            </tbody>
                        </table>
                        <?php
                        //Pagination script
                        $get_all = $mysqli->query("SELECT * FROM $table_downloads");
                        $count_rows = $get_all->num_rows;
                        $total_pages = round($count_rows / $rows_per_page);
                        $page_up = $table_page + 1;
                        $page_down = $table_page - 1;
                        ?>
                        <div style="float: right; padding-right: 10px;">
                        <?php
                        if($table_page > 0):
                        ?>
                          <a href="?page=downloads&table=<?php echo $page_down; ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Prev</a>
                        <?php
                        endif;
                        if($total_pages > $table_page + 1) :
                        ?>
                          <a href="?page=downloads&table=<?php echo $page_up; ?>" class="btn btn-success">Next <i class="fa fa-arrow-right"></i></a>
                        <?php
                        endif;
                        ?>
                        </div>
                        <?php
                        endif;
                        ?>
                      </section>
                  </div><!-- /content-panel -->
               </div><!-- /col-lg-4 -->     
        </div><!-- /row -->
      </section><! --/wrapper -->
      <?php
      break;
      }
      ?>
      <!--main content end-->
  </section>

  <div class="modal fade" id="modalCleardb" tabindex="-1" role="dialog" aria-labelledby="modalCleardbLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalCleardbLabel">Clear database</h4>
      </div>
      <div class="modal-body" style="text-align: center;">
        <li class="fa fa-exclamation-triangle fa-5x"></li>
        <p style="padding-top: 10px;">Are you sure you want to delete all the data from your database ? This will include Upload, files and Download data.</p>
        <p><b>Warning !</b> This will not delete any uploaded files on your server</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a type="button" href="action.php?action=cleardb" class="btn btn-primary">Clear DB</a>
      </div>
    </div>
  </div>
</div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="../src/js/admin/jquery.js"></script>
    <script src="../src/js/admin/jquery-1.8.3.min.js"></script>
    <script src="../src/js/admin/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="../src/js/admin/jquery.dcjqaccordion.2.7.js"></script>
    <script src="../src/js/admin/jquery.scrollTo.min.js"></script>
    <script src="../src/js/admin/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="../src/js/admin/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="../src/js/admin/common-scripts.js"></script>

    <!--script for this page-->
    <script src="../src/js/admin/sparkline-chart.js"></script>    
	<script src="../src/js/admin/zabuto_calendar.js"></script>	
	
	<script type="application/javascript">
        $(document).ready(function () {
            $("#date-popover").popover({html: true, trigger: "manual"});
            $("#date-popover").hide();
            $("#date-popover").click(function (e) {
                $(this).hide();
            });
        
            $("#my-calendar").zabuto_calendar({
                action: function () {
                    return myDateFunction(this.id, false);
                },
                action_nav: function () {
                    return myNavFunction(this.id);
                },
                ajax: {
                    url: "show_data.php?action=1",
                    modal: true
                },
                legend: [
                    {type: "text", label: "Special event", badge: "00"},
                    {type: "block", label: "Regular event", }
                ]
            });
        });
        
        function emailServer() {
          var X = document.getElementById("email_server").value;
          if(X == 'LOCAL') {
            document.getElementById('smtpSection').style.display = "none";
            document.getElementById('localSection').style.display = "block";
          }
          if(X == 'SMTP') {
            document.getElementById('smtpSection').style.display = "block";
            document.getElementById('localSection').style.display = "none";
          }
        }
        
        function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }

        function add_bg_section() {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = '<div style="padding-top: 30px;"><input type="text" name="background[]" class="form-control" placeholder="Background path"><br><input type="text" name="background_url[]" class="form-control" placeholder="Background href (Leave empty for nothing)"></div>';
          document.getElementById('extraBG').appendChild(newdiv);
        }

        function rmFlag(id) {
          var dataString = 'action=rmflag&id='+id;
          $.ajax({
            type: "POST",
            url: 'action.php',
            data: dataString,
            cache: false,
            success: function(){}
          });
          document.getElementById('flag_'+id+'').remove();
        }
    </script>
  

  </body>
</html>
