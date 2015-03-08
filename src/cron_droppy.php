<?php
/*
Droppy cron job file

Should run around every 1 to 5 minutes
*/

//Turning off error reporting
error_reporting(0);

//Including files
include '../config/config.php';
include 'plugins/class.phpmailer.php';
include 'plugins/class.smtp.php';

$current_time = time();

$get_uploads = $mysqli->query("SELECT * FROM $table_uploads WHERE status='ready'");
while($uploads = $get_uploads->fetch_assoc()) {
	if($current_time == $uploads['time'] + $expire || $current_time > $uploads['time'] + $expire) {
		$upload_id = $uploads['upload_id'];
		$get_files = $mysqli->query("SELECT * FROM $table_files WHERE upload_id='$upload_id'");
		while($files = $get_files->fetch_assoc()) {
			unlink('../' . $upload_dir . $files['secret_code'] . '-' . $files['file']);
			$mysqli->query("DELETE FROM $table_files WHERE upload_id='$upload_id'");
		}
		$mysqli->query("UPDATE $table_uploads SET status='destroyed' WHERE upload_id='$upload_id'");

		$tokens = array(
		    'email_from' => $uploads['email_from'],
		    'size' => round($uploads['size'] / 1048576, 2),
		    'site_name' => $site_name,
		    'upload_id' => $uploads['upload_id'],
		    'message' => $uploads['message'],
		    'total_files' => $uploads['count'],
		);

		$pattern = '{%s}';

		$map = array();
		foreach($tokens as $var => $value)
		{
		    $map[sprintf($pattern, $var)] = $value;
		}

		$message_destruct = strtr($message_destruct, $map);

		//Email user
		if($email_server == 'SMTP') {
		    //Sending the email to the sender of the file
		    $mail             = new PHPMailer();

		    $body             = eregi_replace("[\]",'',$message_destruct);

		    $mail->Host       = $smtp_host;
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = $smtp_secure;                       
            $mail->Port       = $smtp_port;
            $mail->Username   = $smtp_username;  
            $mail->Password   = $smtp_password; 

		    $mail->From = $email_from_email;
		    $mail->FromName = $email_from_name;

		    $mail->AddReplyTo($email_from_email, $email_from_name);

		    $mail->Subject    = $destroyed_subject;

		    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
		     
		    $mail->MsgHTML($body);
		     
		    $mail->AddAddress($uploads['email_from'], 'Droppy User');

		    if(!$mail->Send()) {
		        //Error
		    }
		    else 
		    {
		        //Sent
		    }
		}
		else
		{
			$headers = "From: $email_from_email\r\n";
			$headers .= "Reply-To: $email_from_email\r\n";
			$headers .= "Content-Type: text/html";	

			mail($uploads['email_from'],$destroyed_subject,$message_destruct,$headers);
		}
	}
}
//This will deletes uploads from the database that are older then 1 month to spare some storage on your server and reduce slowness in your database set it to NO in the config file to disable it
if($delete_old_data == 'YES') {
	$get_old_data = $mysqli->query("SELECT * FROM $table_uploads");
	while($row = $get_old_data->fetch_assoc()) {
		if($current_time == $row['time'] + 2628000 || $current_time > $row['time'] + 2628000) {
			$mysqli->query("DELETE FROM $table_uploads WHERE upload_id='$upload_id'");
			$mysqli->query("DELETE FROM $table_downloads WHERE download_id='$upload_id'");
		}
	}
}
?>