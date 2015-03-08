<?php
error_reporting(0);

/*
Turning off error reporting
error_reporting(0);
*/

//Getting config file
require '../config/config.php';

session_start();
ob_start();

switch ($_POST['action']) {
	case 'login':
		$email = mysqli_real_escape_string($mysqli, $_POST['email']);
		$password = md5(mysqli_real_escape_string($mysqli, $_POST['password']));

		$result = $mysqli->query("SELECT * FROM $table_accounts WHERE email='$email' and password='$password'");
		$count = $result->num_rows;
		if($count == 1) {
			$_SESSION['droppy_admin'] = $email;
			echo 'true';
		}
		else
		{
			echo 'false';
		}
	break;
	case 'settings_general':
		$site_name_new = mysqli_real_escape_string($mysqli, $_POST['site_name']);
		$site_title_new = mysqli_real_escape_string($mysqli, $_POST['site_title']);
		$site_desc_new = mysqli_real_escape_string($mysqli, $_POST['site_desc']);
		$expire_new = mysqli_real_escape_string($mysqli, $_POST['expire']);
		$logo_path_new = mysqli_real_escape_string($mysqli, $_POST['logo_path']);
		$favicon_path_new = mysqli_real_escape_string($mysqli, $_POST['favicon_path']);
		$background_new = mysqli_real_escape_string($mysqli, $_POST['background']);
		$lang_new = mysqli_real_escape_string($mysqli, $_POST['lang']);
		$max_upload = mysqli_real_escape_string($mysqli, $_POST['max_upload']);
		$upload_dir_new = mysqli_real_escape_string($mysqli, $_POST['upload_dir']);

		$mysqli->query("UPDATE $table_settings SET site_name='$site_name_new', site_title='$site_title_new', site_desc='$site_desc_new', max_size='$max_upload', expire='$expire_new', upload_dir='$upload_dir_new', favicon_path='$favicon_path_new', logo_path='$logo_path_new', language='$lang_new', background='$background_new'");
		header('Location: index.php?page=settings_general&change=OK');
	break;
	case 'settings_mail':
		$email_from_name_n = mysqli_real_escape_string($mysqli, $_POST['email_from_name']);
		$email_from_email_n = mysqli_real_escape_string($mysqli, $_POST['email_from_email']);
		$email_server_n = mysqli_real_escape_string($mysqli, $_POST['email_server']);
		$smtp_host_n = mysqli_real_escape_string($mysqli, $_POST['smtp_host']);
		$smtp_port_n = mysqli_real_escape_string($mysqli, $_POST['smtp_port']);
		$smtp_secure_n = mysqli_real_escape_string($mysqli, $_POST['smtp_secure']);
		$smtp_username_n = mysqli_real_escape_string($mysqli, $_POST['smtp_username']);

		if(empty($_POST['smtp_password'])) {
			$smtp_password_n = $smtp_password;
		}
		else
		{
			$smtp_password_n = mysqli_real_escape_string($mysqli, $_POST['smtp_password']);
		}

		$mysqli->query("UPDATE $table_settings SET email_from_name='$email_from_name_n', email_from_email='$email_from_email_n', email_server='$email_server_n', smtp_host='$smtp_host_n', smtp_port='$smtp_port_n', smtp_secure='$smtp_secure_n', smtp_username='$smtp_username_n', smtp_password='$smtp_password_n'");
		header('Location: index.php?page=settings_mail&change=OK');
	break;
	case 'settings_template':
		$receiver = mysqli_real_escape_string($mysqli, $_POST['temp_receiver']);
		$sender = mysqli_real_escape_string($mysqli, $_POST['temp_sender']);
		$destroyed = mysqli_real_escape_string($mysqli, $_POST['temp_destroyed']);
		$subject_receiver = mysqli_real_escape_string($mysqli, $_POST['receiver_subject']);
		$subject_sender = mysqli_real_escape_string($mysqli, $_POST['sender_subject']);
		$subject_destroyed = mysqli_real_escape_string($mysqli, $_POST['destroyed_subject']);

		$mysqli->query("UPDATE $table_templates SET msg='$receiver' WHERE type='receiver'");
		$mysqli->query("UPDATE $table_templates SET msg='$sender' WHERE type='sender'");
		$mysqli->query("UPDATE $table_templates SET msg='$destroyed' WHERE type='destroyed'");
		$mysqli->query("UPDATE $table_templates SET msg='$subject_receiver' WHERE type='receiver_subject'");
		$mysqli->query("UPDATE $table_templates SET msg='$subject_sender' WHERE type='sender_subject'");
		$mysqli->query("UPDATE $table_templates SET msg='$subject_destroyed' WHERE type='destroyed_subject'");

		header('Location: index.php?page=settings_templates&change=OK');
	break;
	case 'settings_social' :
		$social_facebook_new = mysqli_real_escape_string($mysqli, $_POST['facebook']);
		$social_twitter_new = mysqli_real_escape_string($mysqli, $_POST['twitter']);
		$social_google_new = mysqli_real_escape_string($mysqli, $_POST['google']);
		$social_instagram_new = mysqli_real_escape_string($mysqli, $_POST['instagram']);
		$social_github_new = mysqli_real_escape_string($mysqli, $_POST['github']);
		$social_tumblr_new = mysqli_real_escape_string($mysqli, $_POST['tumblr']);
		$social_pinterest_new = mysqli_real_escape_string($mysqli, $_POST['pinterest']);

		$mysqli->query("UPDATE $table_social SET facebook='$social_facebook_new', twitter='$social_twitter_new', google='$social_google_new', instagram='$social_instagram_new', github='$social_github_new', tumblr='$social_tumblr_new', pinterest='$social_pinterest_new'");
		header('Location: index.php?page=settings_social&change=OK');
	break;
}
switch ($_GET['action']) {
	case 'logout':
		session_destroy();
		header('Location: login.php');
	break;
	case 'delete_upload':
		$id = $_GET['id'];
		$mysqli->query("UPDATE $table_uploads SET status='destroyed' WHERE upload_id='$id'");
		$get_files = $mysqli->query("SELECT * FROM $table_files WHERE upload_id='$id'");
		while($row = $get_files->fetch_assoc()) {
			unlink('../' . $upload_dir . $row['secret_code'] . '-' . $row['file']);
		}
		header('Location: index.php?page=uploads&msg=destroyed');
	break;
	case 'cleardb':
		$mysqli->query("TRUNCATE TABLE $table_uploads");
		$mysqli->query("TRUNCATE TABLE $table_downloads");
		$mysqli->query("TRUNCATE TABLE $table_files");

		header('Location: index.php?page=uploads&msg=dbcleared');
	break;
}
?>