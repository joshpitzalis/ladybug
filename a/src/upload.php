<?php

//Turning off error reporting
error_reporting(0);

//Including files
include '../config/config.php';
include '../config/language/' . $language;
include 'plugins/class.phpmailer.php';
include 'plugins/class.smtp.php';
include 'plugins/timeconvert.php';

//Get and count max file size
$max_file_size = $max_size * 1048576;

//Creating a new array
$response_array = array();

$path = "../uploads/"; // Upload directory
$hash = md5(time()); //Secret code

//Contact information
$email_from = mysqli_real_escape_string($mysqli, $_POST['email_from']);
$email_to = mysqli_real_escape_string($mysqli, $_POST['email_to']);
$destruct_post = mysqli_real_escape_string($mysqli, $_POST['destruct']);
if($destruct_post == 'yes') {
    $destruct = 'YES';
}
else
{
    $destruct = 'NO';
}
$msg = mysqli_real_escape_string($mysqli, $_POST['message']);
$share = mysqli_real_escape_string($mysqli, $_POST['share']);
$response_array['upload_type'] = $share;
$password = mysqli_real_escape_string($mysqli, $_POST['password']);
if($password == null || $password == '') {
    $pwd = 'EMPTY';
} else {
    $pwd = md5($password);
}
$time = time();
$ip = $_SERVER['REMOTE_ADDR'];
$max_upload_files = 0;

//Creates upload id
$upload_id = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 7);
$response_array['upload_id'] = $upload_id;

$count = 0;

//Get size and transfer from Bytes to MB
$total_size = array_sum($_FILES['files']['size']);
$total_size_mb = round($total_size / 1048576, 2);
$total_files = count($_FILES['files']['tmp_name']);

$total_illegal = 0;
foreach($_FILES['files']['type'] as $filetype) {
    if(in_array($filetype, $blocked_types)) {
        $total_illegal++;
    }
}

if($total_illegal == 0) {
    if($total_files == $max_upload_files || $total_files < $max_upload_files || $max_upload_files == 0) {
        if($total_size < $max_file_size) {
            if($share == 'mail') {
                if(empty($email_from)) {
                    $response_array['fields'] = 'false'; 
                }
                else
                {
                    $mysqli->query("INSERT INTO $table_uploads (upload_id, email_from, message, secret_code, password, status, size, time, ip, count, share, destruct) VALUES ('$upload_id', '$email_from', '$msg', '$hash', '$pwd', 'processing', '$total_size', '$time', '$ip', '$total_files', '$share', '$destruct')");
                    foreach ($_FILES['files']['name'] as $f => $name) {
                        if ($_FILES['files']['error'][$f] == 4) {
                            $response_array['upload_error'] = 'true'; 
                        }
                        if ($_FILES['files']['error'][$f] == 0) {              
                            // No error found! Move uploaded files 
                            $mysqli->query("INSERT INTO $table_files (upload_id, secret_code, file) VALUES ('$upload_id','$hash','$name')");
                            if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], '../' . $upload_dir . $hash.'-'.$name)) {
                                $mysqli->query("UPDATE $table_uploads SET status='ready' WHERE upload_id='$upload_id'");
                            }
                            $count++; // Number of successfully uploaded files
                        }
                    }

                    //Sending email
                    if ($_FILES['files']['error'][$f] == 0) {
                        if(!empty($_POST['email_to'])) {
                            foreach($_POST['email_to'] as $emails_to) {
                                if($emails_to != '' || $emails_to != null) {
                                   $mysqli->query("INSERT INTO $table_receivers (upload_id, email) VALUES ('$upload_id','$emails_to')");
                                }
                                $message_receiver = '
                                <html xmlns="http://www.w3.org/1999/xhtml">
                                <head>
                                    <link href="' . $site_url . 'src/css/email.css" rel="stylesheet">
                                    <meta charset="utf-8"> 
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

                                $tokens = array(
                                    'email_to' => $emails_to,
                                    'email_from' => $email_from,
                                    'size' => round($total_size / 1048576, 2),
                                    'site_name' => $site_name,
                                    'upload_id' => $upload_id,
                                    'message' => nl2br($_POST['message']),
                                    'total_files' => $total_files,
                                    'expire_time' => secs_to_h($expire),
                                    'password' => $password,
                               		'download_btn' => '<a href="' . $site_url . $upload_id . '&m=' . $emails_to . '" class="btn-primary">' . $text['download'] . '</a>',
                                    'download_url' => $site_url . $upload_id . '&m=' . $emails_to,
                                );

                                $pattern = '{%s}';
                                
                                $map = array();
                                foreach($tokens as $var => $value)
                                {
                                    $map[sprintf($pattern, $var)] = $value;
                                }

                                $message_receiver = strtr($message_receiver, $map);

                                if($email_server == 'SMTP') {
                                    //Sending the email to the receivers of the file
                                    $mail             = new PHPMailer();

                                    $body             = eregi_replace("[\]",'',$message_receiver);

                                    $mail->IsSMTP(); // telling the class to use SMTP
                                    $mail->Host       = $smtp_host;
                                    $mail->SMTPAuth   = $smtp_auth;
                                    $mail->SMTPSecure = $smtp_secure;                       
                                    $mail->Port       = $smtp_port;                   
                                    $mail->Username   = $smtp_username;  
                                    $mail->Password   = $smtp_password;           

                                    $mail->From = $email_from_email;
                                    $mail->FromName = $email_from_name;

                                    $mail->AddReplyTo($email_from_email, $email_from_name);

                                    $mail->Subject    = $receiver_subject;

                                    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                                     
                                    $mail->MsgHTML($body);
                                     
                                    $mail->AddAddress($emails_to, 'Droppy User');

                                    if(!$mail->Send()) {
                                        //Error
                                    } 
                                    else 
                                    {
                                        if($share == 'link') {
                                            $response_array['upload_id'] = $upload_id;
                                        }
                                    }
                                }
                                else
                                {
                                    $headers = "From: $email_from_email\r\n";
                                    $headers .= "Reply-To: $email_from_email\r\n";
                                    $headers .= "Content-Type: text/html";  

                                    mail($emails_to,$receiver_subject,$message_receiver,$headers);
                                }
                                unset($tokens);
                            }

                            //Sending the email to the sender of the file
                            
                            $tokens = array(
                                'email_from' => $email_from,
                                'size' => round($total_size / 1048576, 2),
                                'site_name' => $site_name,
                                'upload_id' => $upload_id,
                                'message' => nl2br($_POST['message']),
                                'total_files' => $total_files,
                                'expire_time' => secs_to_h($expire),
                                'password' => $password,
                            );

                            $pattern = '{%s}';
                            
                            $map = array();
                            foreach($tokens as $var => $value)
                            {
                                $map[sprintf($pattern, $var)] = $value;
                            }

                            $message_sender = strtr($message_sender, $map);

                            if($email_server == 'SMTP') {
                                $mail             = new PHPMailer();

                                $body             = eregi_replace("[\]",'',$message_sender);

                                $mail->IsSMTP(); // telling the class to use SMTP
                                $mail->Host       = $smtp_host;
                                $mail->SMTPAuth   = $smtp_auth;
                                $mail->SMTPSecure = $smtp_secure;                       
                                $mail->Port       = $smtp_port;                   
                                $mail->Username   = $smtp_username;  
                                $mail->Password   = $smtp_password;           

                                $mail->From = $email_from_email;
                                $mail->FromName = $email_from_name;

                                $mail->AddReplyTo($email_from_email, $email_from_name);

                                $mail->Subject    = $sender_subject;

                                $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
                                 
                                $mail->MsgHTML($body);
                                 
                                $mail->AddAddress($email_from, 'Droppy User');

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

                                mail($email_from,$sender_subject,$message_sender,$headers);
                            }
                        }
                    }
                }
            }
            elseif($share == 'link') {
                $mysqli->query("INSERT INTO $table_uploads (upload_id, email_from, message, secret_code, password, status, size, time, ip, count, share, destruct) VALUES ('$upload_id','$email_from', '$msg', '$hash', '$pwd', 'processing', '$total_size', '$time', '$ip', '$total_files', '$share', '$destruct')");
                foreach ($_FILES['files']['name'] as $f => $name) {
                    if ($_FILES['files']['error'][$f] == 4) {
                        $response_array['upload_error'] = 'true'; 
                    }          
                    if ($_FILES['files']['error'][$f] == 0) {              
                        // No error found! Move uploaded files 
                        $mysqli->query("INSERT INTO $table_files (upload_id, secret_code, file) VALUES ('$upload_id','$hash','$name')");
                        if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], '../' . $upload_dir . $hash.'-'.$name)) {
                            $mysqli->query("UPDATE $table_uploads SET status='ready' WHERE upload_id='$upload_id'");
                        }
                        $count++; // Number of successfully uploaded files
                    }
                }
            }
        }
        else
        {
            $response_array['size_error'] = 'true';  
        }
    }
    else
    {
       $response_array['max_files'] = 'true'; 
    }
}
else
{
    $response_array['type_error'] = 'true';  
}
echo json_encode($response_array);
?>