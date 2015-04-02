<?php

//Turning off error reporting
error_reporting(0);

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

	//Get some info from the POST
	$download_id = mysqli_real_escape_string($mysqli, $_POST['download_id']);
	$secret_code = mysqli_real_escape_string($mysqli, $_POST['secret_code']);
	$download_email = mysqli_real_escape_string($mysqli, $_POST['download_email']); 

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
		    'download_email' => $download_email,
		);

		$pattern = '{%s}';

		$map = array();
		foreach($tokens as $var => $value)
		{
		    $map[sprintf($pattern, $var)] = $value;
		}

		$message_destruct = strtr($message_destruct, $map);
		$message_downloaded = strtr($message_downloaded, $map);

		if($rows['password'] != 'EMPTY') {
			$pwd = mysqli_real_escape_string($mysqli, md5($_POST['password']));
			if($rows['password'] == $pwd) {
				if($rows['count'] > 1) {
					//Creates the zip file
					$ziplocation = '../' . $upload_dir . 'tmp/' . $name_on_file . '-' . $download_id .'.zip';
					$zipname = $name_on_file . '-' . $download_id . '.zip';	

					$zip = new ZipArchive();
					$zip->open($ziplocation, ZipArchive::OVERWRITE);
					while($row = $get_file_info->fetch_assoc()) {
						$file_name = $row['file'];
						$secret = $row['secret_code'];
						$zip->addFile('../' . $upload_dir . $secret . '-' . $file_name, $file_name);
					}

					$zip->close();

					//Downloads the zip file
					header('Content-Description: File Transfer');
				    header('Content-Type: application/octet-stream');
				    header('Content-Disposition: attachment; filename="'.$zipname.'"');
				    header('Content-Transfer-Encoding: binary');
				    header('Expires: 0');
				    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				    header('Pragma: public');
				    header('Content-Length: ' . $rows['size']);
					ob_clean();
					readfile($ziplocation);
					
					//Remove zip file
					unlink($ziplocation);

					$check_download = $mysqli->query("SELECT * FROM $table_downloads WHERE download_id='$download_id' AND email='$download_email'");
					if($check_download->num_rows == 0) {
						if($email_server == 'SMTP') {
						    //Sending the email to the sender of the file
						    $mail             = new PHPMailer();

						    $body             = eregi_replace("[\]",'',$message_downloaded);

						    $mail->Host       = $smtp_host;
	                        $mail->SMTPAuth   = $smtp_auth;
	                        $mail->SMTPSecure = $smtp_secure;                       
	                        $mail->Port       = $smtp_port;                   
	                        $mail->Username   = $smtp_username;  
	                        $mail->Password   = $smtp_password; 

						    $mail->From = $email_from_email;
						    $mail->FromName = $email_from_name;

						    $mail->AddReplyTo($email_from_email, $email_from_name);

						    $mail->Subject    = $downloaded_subject;

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

							mail($rows['email_from'],$downloaded_subject,$message_downloaded,$headers);
						}
					}

					$mysqli->query("INSERT INTO $table_downloads (download_id, time, ip, email) VALUES ('$download_id','$time','$ip_address','$download_email')");

					if($rows['destruct'] == 'YES') {
						if($rows['share'] == 'mail') {
							$get_downloads_info = $mysqli->query("SELECT * FROM $table_downloads WHERE download_id='$download_id'");
							$get_receivers_info = $mysqli->query("SELECT * FROM $table_receivers WHERE upload_id='$download_id'");
							if($get_downloads_info->num_rows == $get_receivers_info->num_rows) {
								if($email_server == 'SMTP') {
								    //Sending the email to the sender of the file
								    $mail             = new PHPMailer();

								    $body             = eregi_replace("[\]",'',$message_destruct);

								    $mail->Host       = $smtp_host;
			                        $mail->SMTPAuth   = $smtp_auth;
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

									mail($rows['email_from'],$destroyed_subject,$message_destruct,$headers);
								}

								//Remove other files from files directory
								$get_files = $mysqli->query("SELECT * FROM $table_files WHERE upload_id='$download_id' AND secret_code='$secret_code'");
								while($files = $get_files->fetch_assoc()) {
									$path = '../' . $upload_dir . $files['secret_code'] . '-' . $files['file'];
									unlink($path);
								}

								//Set status to destroyed
								$mysqli->query("UPDATE $table_uploads SET status='destroyed' WHERE upload_id='$download_id' AND secret_code='$secret_code'");
							}
						}
						else
						{
							$get_files = $mysqli->query("SELECT * FROM $table_files WHERE upload_id='$download_id' AND secret_code='$secret_code'");
							while($files = $get_files->fetch_assoc()) {
								$path = '../' . $upload_dir . $files['secret_code'] . '-' . $files['file'];
								unlink($path);
							}

							//Set status to destroyed
							$mysqli->query("UPDATE $table_uploads SET status='destroyed' WHERE upload_id='$download_id' AND secret_code='$secret_code'");
						}
					}	
				}
				else
				{
					$get_file_info = $mysqli->query("SELECT * FROM $table_files WHERE upload_id='$download_id' AND secret_code='$secret_code'");
					while($row = $get_file_info->fetch_assoc()) {
						header('Content-Description: File Transfer');
					    header('Content-Type: application/octet-stream');
					    header('Content-Disposition: attachment; filename="'.$row['file'].'"');
					    header('Content-Transfer-Encoding: binary');
					    header('Expires: 0');
					    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					    header('Pragma: public');
					    header('Content-Length: ' . $rows['size']);
						ob_clean();
						readfile('../' . $upload_dir . $row['secret_code'] . '-' . $row['file']);

						$check_download = $mysqli->query("SELECT * FROM $table_downloads WHERE download_id='$download_id' AND email='$download_email'");
						if($check_download->num_rows == 0 && $rows['share'] == 'mail') {
							if($email_server == 'SMTP') {
							    //Sending the email to the sender of the file
							    $mail             = new PHPMailer();

							    $body             = eregi_replace("[\]",'',$message_downloaded);

							    $mail->Host       = $smtp_host;
		                        $mail->SMTPAuth   = $smtp_auth;
		                        $mail->SMTPSecure = $smtp_secure;                       
		                        $mail->Port       = $smtp_port;                   
		                        $mail->Username   = $smtp_username;  
		                        $mail->Password   = $smtp_password; 

							    $mail->From = $email_from_email;
							    $mail->FromName = $email_from_name;

							    $mail->AddReplyTo($email_from_email, $email_from_name);

							    $mail->Subject    = $downloaded_subject;

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

								mail($rows['email_from'],$downloaded_subject,$message_downloaded,$headers);
							}
						}

						$mysqli->query("INSERT INTO $table_downloads (download_id, time, ip, email) VALUES ('$download_id','$time','$ip_address','$download_email')");

						if($rows['destruct'] == 'YES') {
							if($rows['share'] == 'mail') {
								$get_downloads_info = $mysqli->query("SELECT * FROM $table_downloads WHERE download_id='$download_id'");
								$get_receivers_info = $mysqli->query("SELECT * FROM $table_receivers WHERE upload_id='$download_id'");
								if($get_downloads_info->num_rows == $get_receivers_info->num_rows) {
									//Set status to destroyed
									$mysqli->query("UPDATE $table_uploads SET status='destroyed' WHERE upload_id='$download_id' AND secret_code='$secret_code'");

									//Remove other files from files directory
									unlink('../' . $upload_dir . $row['secret_code'] . '-' . $row['file']);

									if($email_server == 'SMTP') {
									    //Sending the email to the sender of the file
									    $mail             = new PHPMailer();

									    $body             = eregi_replace("[\]",'',$message_destruct);

									    $mail->Host       = $smtp_host;
				                        $mail->SMTPAuth   = $smtp_auth;
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

										mail($rows['email_from'],$destroyed_subject,$message_destruct,$headers);
									}
								}
							}
							else
							{
								//Set status to destroyed
								$mysqli->query("UPDATE $table_uploads SET status='destroyed' WHERE upload_id='$download_id' AND secret_code='$secret_code'");

								unlink('../' . $upload_dir . $row['secret_code'] . '-' . $row['file']);
							}
						}
					}
				}
			}
			else
			{
				if(isset($download_email)) {
					header("Location: ../" . $download_id . "&m=" . $download_email . "&e=wrong");
				}
				else
				{
					header("Location: ../" . $download_id . "&e=wrong");
				}
			}
		}
		else
		{
			if($rows['count'] > 1) {
				//Creates the zip file
				$ziplocation = '../' . $upload_dir . 'tmp/' . $name_on_file . '-' . $download_id .'.zip';
				$zipname = $name_on_file . '-' . $download_id . '.zip';

				$zip = new ZipArchive();
				$zip->open($ziplocation, ZipArchive::CREATE);
				while($row = $get_file_info->fetch_assoc()) {
					$file_name = $row['file'];
					$secret = $row['secret_code'];
					$zip->addFile('../' . $upload_dir . $secret . '-' . $file_name, $file_name);
				}

				$zip->close();

				
				//Downloads the zip file
				header('Content-Description: File Transfer');
			    header('Content-Type: application/octet-stream');
			    header('Content-Disposition: attachment; filename="'.$zipname.'"');
			    header('Content-Transfer-Encoding: binary');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			    header('Pragma: public');
			    header('Content-Length: ' . $rows['size']);
				ob_clean();
				readfile($ziplocation);
				
				//Remove zip file
				unlink($ziplocation);

				$check_download = $mysqli->query("SELECT * FROM $table_downloads WHERE download_id='$download_id' AND email='$download_email'");
				if($check_download->num_rows == 0 && $rows['share'] == 'mail') {
					if($email_server == 'SMTP') {
					    //Sending the email to the sender of the file
					    $mail             = new PHPMailer();

					    $body             = eregi_replace("[\]",'',$message_downloaded);

					    $mail->Host       = $smtp_host;
                        $mail->SMTPAuth   = $smtp_auth;
                        $mail->SMTPSecure = $smtp_secure;                       
                        $mail->Port       = $smtp_port;                   
                        $mail->Username   = $smtp_username;  
                        $mail->Password   = $smtp_password; 

					    $mail->From = $email_from_email;
					    $mail->FromName = $email_from_name;

					    $mail->AddReplyTo($email_from_email, $email_from_name);

					    $mail->Subject    = $downloaded_subject;

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

						mail($rows['email_from'],$downloaded_subject,$message_downloaded,$headers);
					}
				}

				$mysqli->query("INSERT INTO $table_downloads (download_id, time, ip, email) VALUES ('$download_id','$time','$ip_address','$download_email')");

				if($rows['destruct'] == 'YES') {
					if($rows['share'] == 'mail') {
						$get_downloads_info = $mysqli->query("SELECT * FROM $table_downloads WHERE download_id='$download_id'");
						$get_receivers_info = $mysqli->query("SELECT * FROM $table_receivers WHERE upload_id='$download_id'");
						if($get_downloads_info->num_rows == $get_receivers_info->num_rows) {
							//Set status to destroyed
							$mysqli->query("UPDATE $table_uploads SET status='destroyed' WHERE upload_id='$download_id' AND secret_code='$secret_code'");

							$get_files = $mysqli->query("SELECT * FROM $table_files WHERE upload_id='$download_id' AND secret_code='$secret_code'");
							while($files = $get_files->fetch_assoc()) {
								$path = '../' . $upload_dir . $files['secret_code'] . '-' . $files['file'];
								unlink($path);
							}

							if($email_server == 'SMTP') {
							    //Sending the email to the sender of the file
							    $mail             = new PHPMailer();

							    $body             = eregi_replace("[\]",'',$message_destruct);

							    $mail->Host       = $smtp_host;
		                        $mail->SMTPAuth   = $smtp_auth;
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

								mail($rows['email_from'],$destroyed_subject,$message_destruct,$headers);
							}
						}
					}
					else
					{
						//Set status to destroyed
						$mysqli->query("UPDATE $table_uploads SET status='destroyed' WHERE upload_id='$download_id' AND secret_code='$secret_code'");

						//Remove other files from files directory
						$get_files = $mysqli->query("SELECT * FROM $table_files WHERE upload_id='$download_id' AND secret_code='$secret_code'");
						while($files = $get_files->fetch_assoc()) {
							$path = '../' . $upload_dir . $files['secret_code'] . '-' . $files['file'];
							unlink($path);
						}
					}
				}
			}
			else
			{
				while($row = $get_file_info->fetch_assoc()) {
					header('Content-Description: File Transfer');
				    header('Content-Type: application/octet-stream');
				    header('Content-Disposition: attachment; filename="'.$row['file'].'"');
				    header('Content-Transfer-Encoding: binary');
				    header('Expires: 0');
				    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				    header('Pragma: public');
				    header('Content-Length: ' . $rows['size']);
					ob_clean();
					readfile('../' . $upload_dir . $row['secret_code'] . '-' . $row['file']);

					$check_download = $mysqli->query("SELECT * FROM $table_downloads WHERE download_id='$download_id' AND email='$download_email'");
					if($check_download->num_rows == 0 && $rows['share'] == 'mail') {
						if($email_server == 'SMTP') {
						    //Sending the email to the sender of the file
						    $mail             = new PHPMailer();

						    $body             = eregi_replace("[\]",'',$message_downloaded);

						    $mail->Host       = $smtp_host;
	                        $mail->SMTPAuth   = $smtp_auth;
	                        $mail->SMTPSecure = $smtp_secure;                       
	                        $mail->Port       = $smtp_port;                   
	                        $mail->Username   = $smtp_username;  
	                        $mail->Password   = $smtp_password; 

						    $mail->From = $email_from_email;
						    $mail->FromName = $email_from_name;

						    $mail->AddReplyTo($email_from_email, $email_from_name);

						    $mail->Subject    = $downloaded_subject;

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

							mail($rows['email_from'],$downloaded_subject,$message_downloaded,$headers);
						}
					}

					$mysqli->query("INSERT INTO $table_downloads (download_id, time, ip, email) VALUES ('$download_id','$time','$ip_address','$download_email')");

					if($rows['destruct'] == 'YES') {
						if($rows['share'] == 'mail') {
							$get_downloads_info = $mysqli->query("SELECT * FROM $table_downloads WHERE download_id='$download_id'");
							$get_receivers_info = $mysqli->query("SELECT * FROM $table_receivers WHERE upload_id='$download_id'");
							if($get_downloads_info->num_rows == $get_receivers_info->num_rows) {
								//Set status to destroyed
								$mysqli->query("UPDATE $table_uploads SET status='destroyed' WHERE upload_id='$download_id' AND secret_code='$secret_code'");

								//Remove other files from files directory
								unlink('../' . $upload_dir . $row['secret_code'] . '-' . $row['file']);

								if($email_server == 'SMTP') {
								    //Sending the email to the sender of the file
								    $mail             = new PHPMailer();

								    $body             = eregi_replace("[\]",'',$message_destruct);

								    $mail->Host       = $smtp_host;
			                        $mail->SMTPAuth   = $smtp_auth;
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

									mail($rows['email_from'],$destroyed_subject,$message_destruct,$headers);
								}
							}
						}
						else
						{
							//Set status to destroyed
							$mysqli->query("UPDATE $table_uploads SET status='destroyed' WHERE upload_id='$download_id' AND secret_code='$secret_code'");
							//Remove other files from files directory
							unlink('../' . $upload_dir . $row['secret_code'] . '-' . $row['file']);
						}
					}	
				}
			}
		}	
	}
	break;
	case 'report':
		$id = mysqli_real_escape_string($mysqli, $_POST['id']);
		$mysqli->query("UPDATE $table_uploads SET flag='yes' WHERE upload_id='$id'");
		header('Location: ../' . $id . '?msg=reported');
	break;
	case 'terms':
		setcookie("terms", "accepted");
		header('Location: ../' . $_POST['id']);
	break;
}
?>