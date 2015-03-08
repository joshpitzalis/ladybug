<?php
/*
Name: Droppy - Online file sharing
Author: Proxibolt
File: config.php
Support: http://support.proxibolt.com
*/

//Turning off error reporting
error_reporting(0);

//Including database information
include 'db.php';

//Name on zip file (Eg: droppy-EgUA8FA)
$name_on_file = 'droppy';

//Delete data in the upload table older then 1 month
$delete_old_data = 'YES';

//Table settings (Change before installing Droppy)
$table_uploads = 'droppy_uploads';
$table_files = 'droppy_files';
$table_downloads = 'droppy_downloads';
$table_settings = 'droppy_settings';
$table_accounts = 'droppy_accounts';
$table_templates = 'droppy_templates';
$table_social = 'droppy_social';

/*_________________________________________Don't change anything below if you don't know what you're doing_________________________________________*/

$select_general = $mysqli->query("SELECT * FROM $table_settings");

if(!$select_general) {
    //No data found
}
else
{
    while($row = $select_general->fetch_assoc()) {
    	//General settings
    	$site_name = $row['site_name'];
    	$site_desc = $row['site_desc'];
    	$site_url = $row['site_url'];
    	$upload_dir = $row['upload_dir'];
    	$language = $row['language'];
    	$background = $row['background'];
    	$logo_path = $row['logo_path'];
    	$favicon_path = $row['favicon_path'];
    	$max_size = $row['max_size'];
    	$site_title = $row['site_title'];
    	$expire = $row['expire'];

    	//Mail settings
    	$email_server = $row['email_server'];
    	$email_from_email = $row['email_from_email'];
    	$email_from_name = $row['email_from_name'];
    	$smtp_host = $row['smtp_host'];
    	$smtp_secure = $row['smtp_secure'];
    	$smtp_port = $row['smtp_port'];
    	$smtp_username = $row['smtp_username'];
    	$smtp_password = $row['smtp_password'];
    }

    $select_social = $mysqli->query("SELECT * FROM $table_social");
    while($row = $select_social->fetch_assoc()) {
    	$social_facebook = $row['facebook'];
    	$social_twitter = $row['twitter'];
    	$social_google = $row['google'];
    	$social_instagram = $row['instagram'];
    	$social_github = $row['github'];
    	$social_tumblr = $row['tumblr'];
    	$social_pinterest = $row['pinterest'];
    }

    //Template settings
    $select_receiver = $mysqli->query("SELECT * FROM $table_templates WHERE type='receiver'");
    while($row = $select_receiver->fetch_assoc()) {
    	$temp_receiver = $row['msg'];
    }
    $select_sender= $mysqli->query("SELECT * FROM $table_templates WHERE type='sender'");
    while($row = $select_sender->fetch_assoc()) {
    	$temp_sender = $row['msg'];
    }
    $select_destroyed = $mysqli->query("SELECT * FROM $table_templates WHERE type='destroyed'");
    while($row = $select_destroyed->fetch_assoc()) {
    	$temp_destroyed = $row['msg'];
    }
    //Subject settings
    $select_receiver_subject = $mysqli->query("SELECT * FROM $table_templates WHERE type='receiver_subject'");
    while($row = $select_receiver_subject->fetch_assoc()) {
    	$receiver_subject = $row['msg'];
    }
    $select_sender_subject = $mysqli->query("SELECT * FROM $table_templates WHERE type='sender_subject'");
    while($row = $select_sender_subject->fetch_assoc()) {
    	$sender_subject = $row['msg'];
    }
    $select_destroyed_subject = $mysqli->query("SELECT * FROM $table_templates WHERE type='destroyed_subject'");
    while($row = $select_destroyed_subject->fetch_assoc()) {
    	$destroyed_subject = $row['msg'];
    }
}

/*
____________E-Mail messages__________ 

You can edit the text in the admin area
*/
$message_destruct = '
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link href="' . $site_url . 'src/css/email.css" rel="stylesheet">
    </head>
    <body bgcolor="#f6f6f6">
        <table class="body-wrap">
            <tr>
                <td class="container" bgcolor="#FFFFFF">
                    <!-- content -->
                    <div class="content">
                    <table>
                        <tr>
                            <td>
                                <div class="content">' . nl2br($temp_destroyed) . '</div>
                            </td>
                        </tr>
                    </table>
                    </div>
                    <!-- /content -->
                    
                </td>
            </tr>
        </table>
    </body>
</html>';

$message_sender = '
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link href="' . $site_url . 'src/css/email.css" rel="stylesheet">
</head>
<body>
<!-- body -->
<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">

            <!-- content -->
            <div class="content">
            <table>
                <tr>
                    <td>
                        <div class="content">' . nl2br($temp_sender) . '</div>
                    </td>
                </tr>
            </table>
            </div>
            <!-- /content -->
            
        </td>
        <td></td>
    </tr>
</table>
</body>
</html>';

$message_receiver = '
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <link href="' . $site_url . 'src/css/email.css" rel="stylesheet">
</head>
<body>
<!-- body -->
<table class="body-wrap">
    <tr>
        <td></td>
        <td class="container" bgcolor="#FFFFFF">

            <!-- content -->
            <div class="content">
            <table>
                <tr>
                    <td>
                        <div class="content">' . nl2br($temp_receiver) . '</div>
                    </td>
                </tr>
            </table>
            </div>
            <!-- /content -->
            
        </td>
        <td></td>
    </tr>
</table>
</body>
</html>';
?>