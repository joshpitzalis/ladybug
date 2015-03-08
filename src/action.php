<?php

//Turning off error reporting
error_reporting(0);
//error_reporting(E_ALL);

ignore_user_abort(true);

ob_start();

//Including files
include '../config/config.php';
include 'plugins/class.phpmailer.php';
include 'plugins/class.smtp.php';

//Getting the post "action"
switch ($_POST['action']) {
	//When download
	case 'download';

	require_once('plugins/pclzip.lib.php');

	//Get some info from the POST
	$download_id = mysqli_real_escape_string($mysqli, $_POST['download_id']);
	$secret_code = mysqli_real_escape_string($mysqli, $_POST['secret_code']);

	//Getting some other data
	$time = time();
	$ip_address = $_SERVER['REMOTE_ADDR'];

	$get_info = $mysqli->query("SELECT * FROM $table_uploads WHERE upload_id='$download_id' AND secret_code='$secret_code' AND status='ready'");
	$get_file_info = $mysqli->query("SELECT * FROM $table_files WHERE upload_id='$download_id' AND secret_code='$secret_code'");

	while($rows = $get_info->fetch_assoc()) {
		$tokens = array(
		    'email_from' => $rows['email_from'],
		    'size' => round($rows['size'] / 1048576, 2),
		    'site_name' => $site_name,
		    'upload_id' => $rows['upload_id'],
		    'message' => $rows['message'],
		    'total_files' => $rows['count'],
		);

		$pattern = '{%s}';

		$map = array();
		foreach($tokens as $var => $value)
		{
		    $map[sprintf($pattern, $var)] = $value;
		}

		$message_destruct = strtr($message_destruct, $map);

		if($rows['password'] != 'EMPTY') {
			$pwd = mysqli_real_escape_string($mysqli, md5($_POST['password']));
			if($rows['password'] == $pwd) {
				if($rows['count'] > 1) {
					//Creates the zip file
					$ziplocation = '../' . $upload_dir . 'tmp/' . $name_on_file . '-' . $download_id .'.zip';
					$zipname = $name_on_file . '-' . $download_id . '.zip';	

					$zip = new PclZip('../' . $upload_dir . 'tmp/' . $zipname);
					$mysqli->query("INSERT INTO $table_downloads (download_id, time, ip) VALUES ('$download_id','$time','$ip_address')");
					while($row = $get_file_info->fetch_assoc()) {
						$file_name = $row['file'];
						$secret = $row['secret_code'];
						$add_zip = $zip->add('../' . $upload_dir . $secret . '-' . $file_name, PCLZIP_OPT_REMOVE_PATH, '../' . $upload_dir);
					}

					//Downloads the zip file
					header('Content-Type: application/zip');
					header('Content-disposition: attachment; filename='.$zipname);
					readfile($ziplocation);
					
					//Remove zip file
					unlink($ziplocation);

					if($rows['destruct'] == 'YES') {
						//Set status to destroyed
						$mysqli->query("UPDATE $table_uploads SET status='destroyed' WHERE upload_id='$download_id' AND secret_code='$secret_code'");

						//Remove other files from files directory
						while($files = $get_file_info->fetch_assoc()) {
							$file = $files['file'];
							unlink('../' . $upload_dir . $secret_code . '-' . $file);
						}

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

						    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
						     
						    $mail->MsgHTML($body);
						     
						    $mail->AddAddress($rows['email_from'], 'Droppy User');

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

							mail($email_to,$destroyed_subject,$message_destruct,$headers);
						}
					}	
				}
				else
				{
					$get_file_info = $mysqli->query("SELECT * FROM $table_files WHERE upload_id='$download_id' AND secret_code='$secret_code'");
					$mysqli->query("INSERT INTO $table_downloads (download_id, time, ip) VALUES ('$download_id','$time','$ip_address')");
					while($row = $get_file_info->fetch_assoc()) {
						header('Content-Type: application/octet-stream');
						header('Content-disposition: attachment; filename='.$row['file']);
						header("Content-Transfer-Encoding: Binary");
						readfile('../' . $upload_dir . $row['secret_code'] . '-' . $row['file']);
						if($rows['destruct'] == 'YES') {
							ob_end_flush();
							unlink('../' . $upload_dir . $row['secret_code'] . '-' . $row['file']);
						}
					}
					if($rows['destruct'] == 'YES') {
						$mysqli->query("UPDATE $table_uploads SET status='destroyed' WHERE upload_id='$download_id' AND secret_code='$secret_code'");

						if($email_server == 'SMTP') {
						    //Sending the email to the sender of the file
						    $mail             = new PHPMailer();
						                         
						    $body             = eregi_replace("[\]",'',$message_destruct);

						    $mail->IsSMTP(); // telling the class to use SMTP
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

						    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
						     
						    $mail->MsgHTML($body);
						     
						    $mail->AddAddress($rows['email_from'], 'Droppy User');

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

							mail($email_to,$destroyed_subject,$message_destruct,$headers);
						}
					}	
				}
			}
			else
			{
				header("Location: ../" . $download_id . "?e=wrong");
			}
		}
		else
		{
			if($rows['count'] > 1) {
				//Creates the zip file
				$ziplocation = '../' . $upload_dir . 'tmp/' . $name_on_file . '-' . $download_id .'.zip';
				$zipname = $name_on_file . '-' . $download_id . '.zip';

				$zip = new PclZip('../' . $upload_dir . 'tmp/' .  $zipname);
				$get_info = $mysqli->query("SELECT * FROM $table_files WHERE upload_id='$download_id' AND secret_code='$secret_code'");
				$mysqli->query("INSERT INTO $table_downloads (download_id, time, ip) VALUES ('$download_id','$time','$ip_address')");
				while($row = $get_info->fetch_assoc()) {
					$file_name = $row['file'];
					$secret = $row['secret_code'];
					$add_zip = $zip->add('../' . $upload_dir . $secret . '-' . $file_name, PCLZIP_OPT_REMOVE_PATH, '../' . $upload_dir);
				}
				
				//Downloads the zip file
				header('Content-Type: application/zip');
				header('Content-disposition: attachment; filename='.$zipname);
				readfile($ziplocation);
				
				//Remove zip file
				unlink($ziplocation);

				if($rows['destruct'] == 'YES') {
					//Set status to destroyed
					$mysqli->query("UPDATE $table_uploads SET status='destroyed' WHERE upload_id='$download_id' AND secret_code='$secret_code'");

					//Remove other files from files directory
					while($files = $get_file_info->fetch_assoc()) {
						$file = $files['file'];
						unlink('../' . $upload_dir . $secret_code . '-' . $file);
					}
					if($email_server == 'SMTP') {
					    //Sending the email to the sender of the file
					    $mail             = new PHPMailer();
					                         
					    $body             = eregi_replace("[\]",'',$message_destruct);

					    $mail->IsSMTP(); // telling the class to use SMTP
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

					    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
					     
					    $mail->MsgHTML($body);
					     
					    $mail->AddAddress($rows['email_from'], 'Droppy User');

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

						mail($email_to,$destroyed_subject,$message_destruct,$headers);
					}
				}	
			}
			else
			{
				$mysqli->query("INSERT INTO $table_downloads (download_id, time, ip) VALUES ('$download_id','$time','$ip_address')");
				while($row = $get_file_info->fetch_assoc()) {
					header('Content-Type: application/zip');
					header('Content-disposition: attachment; filename='.$row['file']);
					header("Content-Transfer-Encoding: Binary");
					readfile('../' . $upload_dir . $row['secret_code'] . '-' . $row['file']);
					if($rows['destruct'] == 'YES') {
						ob_end_flush();
						unlink('../' . $upload_dir . $row['secret_code'] . '-' . $row['file']);
					}
				}
				if($rows['destruct'] == 'YES') {
					//Set status to destroyed
					$mysqli->query("UPDATE $table_uploads SET status='destroyed' WHERE upload_id='$download_id' AND secret_code='$secret_code'");

					if($email_server == 'SMTP') {
					    //Sending the email to the sender of the file
					    $mail             = new PHPMailer();
					                         
					    $body             = eregi_replace("[\]",'',$message_destruct);

					    $mail->IsSMTP(); // telling the class to use SMTP
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

					    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
					     
					    $mail->MsgHTML($body);
					     
					    $mail->AddAddress($rows['email_from'], 'Droppy User');

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

						mail($email_to,$destroyed_subject,$message,$headers);
					}
				}	
			}
		}	
	}
	break;
}
?>