<?php
/******************************************************************************/
// Created by: shlomo hassid.
// Release Version : 3.0
// Creation Date: 14/08/2013
// Updated To V.2.X : 05/01/2014
// Updated To V.3.0 : 14/08/2014
// Mail: Shlomohassid@gmail.com
// require: jquery latest ( best: 10.1 ) version SQL 4+ PHP 5.3+ .	
// Copyright 2014, shlomo hassid.
/******************************************************************************/
/*************************** Require Core Files *******************************/
    header("Content-Type: text/html; charset=utf-8"); 
    error_reporting(0);
    ini_set('display_errors', 'off');
    define('DS',DIRECTORY_SEPARATOR);
    
    //Include phpSet:
    require("..".DS."lib".DS."phpSet.php");
    session_start();
    
    //Include lang pack:
    require_once("..".DS."lib".DS."lang.php");
    
    //Include functions lib:
    require_once("..".DS."lib".DS."func.php");
    
    //Debuging or Execute:
    if (!isset($_POST['get'])) { 
        debug_ini_settings();
        exit;
    } else {
        $token = $_POST['get'];
    }
    
    //Connection with token protection init! <-- will die if bad token
    require_once('..'.DS.'lib'.DS.'conndb.php');
    
    //Get Settings:
    $sqlstatus = "SELECT * FROM `".$table1."` WHERE `id`='1'";
    $rs_result = mysqli_query($linkos, $sqlstatus) or die ("die1"); 
    while ($idr = mysqli_fetch_array($rs_result)) {
            $brand          = $idr['brand_name'];
            $accept_types   = $idr['accept_types'];
            $maxfiles       = $idr['maxfiles'];
            $maxfile_size   = $idr['maxfile_size'];
            $maxrecipients  = $idr['maxrecipients'];
            $e_auto_title   = $idr['e_auto_title'];
            $e_auto_body    = $idr['e_auto_body'];
            $e_auto_title_copy = $idr['e_auto_title_copy'];
            $e_auto_body_copy  = $idr['e_auto_body_copy'];
            $files_path     = $idr['files_folder'];
            $servermail     = $idr['server_mail'];
            $users_mode     = $idr['users_mode'];
    }
    
/************************** SET LIMITATIONS ***********************************/

    switch($users_mode) {
        case "users":
            if (isset($_COOKIE['user_login'])) {
                //Get user:
                $userName = explode("%",$_COOKIE['user_login']);
                if (isset($userName[0])) {
                    $userName = $userName[0];
                } else {
                    echo('log1');
                    exit;                            
                }

                $userName = mysqli_real_escape_string($linkos, $userName); 
                //Get user settings: 
                $sqlstatus = "SELECT * FROM `".$table6."` WHERE `username`='".$userName."'";
                $rs_result = mysqli_query($linkos, $sqlstatus) 
                    or 
                        die ( "Some thing went terribly wrong contact Admin ~ Code: 230983" ); 
                    while ( $idr = mysqli_fetch_array($rs_result) ) {
                        $maxfiles       = $idr['maxfiles'];
                        $maxrecipients  = $idr['maxrec'];
                        $maxfile_size   = $idr['maxsize'];
                        $userEmail      = $idr['usermail'];
                        $userFullName   = $idr['fullname'];
                        $DbUserName     = $idr['username'];
                        $DbUserPass     = $idr['password'];
                    }
                //Check user cookie:
                if ( $_COOKIE['user_login'] != $DbUserName.'%'.$DbUserPass ) {
                    echo('log2');
                    exit;                                
                }    
            } else {
                echo('log3');
                exit;
            }
            break;
        case "guests":
            //Get guests default settings: 
            $sqlstatus = "SELECT * FROM `".$table7."` WHERE `id`=1";
            $rs_result = mysqli_query($linkos, $sqlstatus) 
                or 
                    die ( "Some thing went terribly wrong contact Admin ~ Code: 230983" ); 
                while ( $idr = mysqli_fetch_array($rs_result) ) {
                    $maxfiles       = $idr['maxfiles'];
                    $maxrecipients  = $idr['maxrec'];
                    $maxfile_size   = $idr['maxsize'];
                }
            break;
        case "users-guests":
            if (!isset($_POST['fromsend'])) { //User:
                if (isset($_COOKIE['user_login'])) {
                    //Get user:
                    $userName = explode("%",$_COOKIE['user_login']);
                    if (isset($userName[0])) {
                        $userName = $userName[0];
                    } else {
                        echo('log1');
                        exit;                            
                    }
                    $userName = mysqli_real_escape_string($linkos, $userName); 
                    //Get user settings: 
                    $sqlstatus = "SELECT * FROM `".$table6."` WHERE `username`='".$userName."'";
                    $rs_result = mysqli_query($linkos, $sqlstatus) 
                        or 
                            die ( "Some thing went terribly wrong contact Admin ~ Code: 230983" ); 
                        while ( $idr = mysqli_fetch_array($rs_result) ) {
                            $maxfiles       = $idr['maxfiles'];
                            $maxrecipients  = $idr['maxrec'];
                            $maxfile_size   = $idr['maxsize'];
                            $userEmail      = $idr['usermail'];
                            $userFullName   = $idr['fullname'];
                            $DbUserName     = $idr['username'];
                            $DbUserPass     = $idr['password'];
                        }
                    //Check user cookie:
                    if ($_COOKIE['user_login'] != $DbUserName.'%'.$DbUserPass) {
                        echo('log2');
                        exit;                                
                    }                            
                } else { //Login is requierd
                    echo('log4');
                    exit;
                }                        
            } else { //Guest:

                //get guests default settings: 
                $sqlstatus = "SELECT * FROM `".$table7."` WHERE `id`=1";
                $rs_result = mysqli_query($linkos, $sqlstatus) 
                    or 
                        die ( "Some thing went terribly wrong contact Admin ~ Code: 230983" ); 
                    while ($idr=mysqli_fetch_array($rs_result)) {
                        $maxfiles       = $idr['maxfiles'];
                        $maxrecipients 	= $idr['maxrec'];
                        $maxfile_size   = $idr['maxsize'];
                    }      
            }
            break;
        default: die('shlomi1');
    }

/************************** PROCCESS VARIABLES ********************************/

    $validator_catch_errors = array();
    $recipients             = array();
    $fromsend               = "";
    $messsage_head_recip    = $e_auto_title;
    $messsage_body_recip    = $e_auto_body;
    $messsage_head_copy     = $e_auto_title_copy;
    $messsage_body_copy     = $e_auto_body_copy;
    $messsage_user          = "";
    $messsage_user2         = "";
    $filetypes              = $accept_types;
    $filesizes              = (int)$maxfile_size;
    $sum_filesizes_mileage  = 0;
    $sum_filescount_mileage = 0;

/************************** PROCEDURE BEGINS HERE *****************************/


// VALIDATE EXCLUDES AND BOT PROTECTION:

    // If first attempt > set a timestamp:
    $excludes = array();

    if (defined('SERVERREMOTE')) 
        $user_ip = mysqli_real_escape_string($linkos, SERVERREMOTE);
    else 
        $user_ip = false;
        
    if (defined('USERAGENT')) 
        $user_agent = mysqli_real_escape_string($linkos, USERAGENT); 
    else 
        $user_agent = false;
            
    if ( !isset($_SESSION['time']) ) { 
    
        $_SESSION['time']  = time(); 
        $flag_time_protect = false; 
    
    } else { 
    
        $flag_time_protect = true; 
    }
    
    if ( !isset($_SESSION['timetries'] )) 
        $_SESSION['timetries'] = 1;
        
    if ( $flag_time_protect === true ) { 
        $user_rate = ( time() - $_SESSION['time'] );
        $_SESSION['time'] = time(); 
    } 
                                    
    //Get Email address:
    switch($users_mode) {
    
        case "users":
                $user_email = mysqli_real_escape_string($linkos, $userEmail);
        break;
        case "guests":
                if ( isset($_POST["fromsend"]) ) 
                    $user_email = mysqli_real_escape_string($linkos, trim($_POST["fromsend"])); 
                else 
                    $user_email = false;        
            break;
        case "users-guests":
                if (isset($userEmail)) {
                    $user_email = mysqli_real_escape_string($linkos, $userEmail);
                } else {
                    if (isset($_POST["fromsend"])) 
                        $user_email = mysqli_real_escape_string($linkos, trim($_POST["fromsend"])); 
                    else 
                        $user_email = false;                   
                }
            break;
        default: die('shlomi1');
    }

    //Check conditions:
        // check for basic variables needed:
        if (!$user_ip || !$user_agent) { 
            $excludes[] = 'nothuman1'; 
        }
                
    //Check for time rate ( smaller 3sec ) that is human!
        if ( isset($user_rate) && $user_rate < 3 ) { 
            $_SESSION['timetries']++; 
        }
    
    //If Block is needed - execute:
        if ( isset($_SESSION['timetries']) && $_SESSION['timetries'] > 5 ) { 
            $excludes[] = 'nothuman2'; 
            //Insert Blocked user list:
            $sqlstat3 = "INSERT INTO `".$table3."` (`ip_user`,`user_agent`,".
                        "`when_blocked`) VALUES ('".$user_ip."','".$user_agent."',NOW())";
            if (!mysqli_real_query($linkos, $sqlstat3)) { }																				
        }
        
    //Check `Excluded` list Or `Blocked`:
        if ( count($excludes) < 1 ) {
            //Check in the DB excluded and blocked users:
            $sqlstatus4 = "SELECT * FROM `".$table3."` WHERE `ip_user`='".$user_ip."'";
            $stmt = mysqli_prepare($linkos, $sqlstatus4); 
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt); 
            $rows_blocked = mysqli_stmt_num_rows($stmt);
            mysqli_stmt_close($stmt);
                        
            $sqlstatus5 = "SELECT * FROM `".$table5."` WHERE `email_address`='".$user_email."'";
            $stmt = mysqli_prepare($linkos, $sqlstatus5); 
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt); 
            $rows_exclude = mysqli_stmt_num_rows($stmt);
            mysqli_stmt_close($stmt);
                    
            if ( $rows_blocked > 0 || $rows_exclude > 0 ) $excludes[] = 'unauthorized';
        }

    //Show blocking if its found:
        if ( count($excludes) > 0 ) {  
            echo "blo".json_encode($excludes); 
            exit;  
        }
                
// VALIDATE FILES:
    if ( !isset($_FILES) ) { 
        $validator_catch_errors[] = 'File1'; 
    } else {
        //Make sure we process only accepted amount of files:
        //_FILE <- maybe hacked by user via js so kill it here!
        if ( count($_FILES) > $maxfiles ) { 
            array_slice($_FILES, 0, $maxfiles); 
        }
        //Search for not empty input fields:
        $flag = 0;
        for ( $i = 0; $i < count($_FILES); $i++ ) { 
            if ( strip_tags($_FILES['file'.($i+1)]['name']) == '' ) { 
                $flag++; 
            } 
        }
        if ( $flag == count($_FILES) ) { 
            $validator_catch_errors[] = 'File1'; 
        }
    }
         
// VALIDATE MAIL RECIPIENTS ADDRESS: RECIPIENTS:
    $flag_recipients = 0;
    foreach ( $_POST as $key => $values ) {
        if ( substr($key, 0, 6) == 'sendto' && $values != "" ) {
            if ( check_email_address(trim($values)) ) {
                $recipients[] = mysqli_real_escape_string($linkos, trim($values));
            } else {
                $validator_catch_errors[] = 'tosendem-'.$key;
                $flag_recipients++;
            }
        }
    }
    
    //Make sure there are recipients sent
    if ( count( $recipients ) < 1 ) {
        if ( $flag_recipients < 1 )
            $validator_catch_errors[] = 'tosend1'; 
    } else {
        // Make sure we proccess only accepted amount of recipients 
        // Recipients <- mybe hacked by user via js so kill it here!
        if ( count( $recipients ) > $maxrecipients )
            array_slice( $recipients, 0, $maxrecipients ); 
    }
    
    //Remove duplicate recipients:
    $recipients = array_unique($recipients);
        

// VALIDATE MAIL SENDER ADDRESS:
    if ( !$user_email ) { 
        $validator_catch_errors[] = 'fromsend1'; 
    } else { 
        $fromsend = $user_email; //ecaped early  
    }
    if ( !in_array("fromsend1", $validator_catch_errors) ) {
        if ( !check_email_address($fromsend) ) { 
            $validator_catch_errors[] = 'fromsend2'; 
        }
    }
    
// VALIDATE FILE TYPES:
    if ( !in_array("File1", $validator_catch_errors) ) {
        $filetypes = explode(",", $filetypes);
        foreach ( $_FILES as $key => $file ) {
            if ( $file["name"] != null ) {
                $type = explode('.', $file["name"]);
                $type = strtolower($type[count($type)-1]);
                if ( !in_array(".".$type,$filetypes) ) { 
                    $validator_catch_errors[] = 'filetype-'.$key; 
                }
            }
        }	
    }

// VALIDATE FILE SIZES:
    if ( !in_array("File1", $validator_catch_errors) ) {
        foreach ( $_FILES as $key => $file ) {
            if ( $file["size"] != null ) {
                if ( $file["size"] > $filesizes ) {
                    $validator_catch_errors[] = 'filesize-'.$key; 
                } else {
                    //Add to sum: 
                    $sum_filesizes_mileage += (int)$file["size"];
                    $sum_filescount_mileage++;
                }
            }
        }
    }
    
// CLEAN MESSAGE FROM TAGS:
    if ( isset($_POST["message"]) && $_POST["message"] != "" ) {
        //For DB:
        $messsage_user = mysqli_real_escape_string(
                        $linkos, strip_tags($_POST["message"])
                        ); 
        //For Mail:
        $messsage_user2 = strip_tags($_POST["message"]);
    }
        
// IF EVERYTHING IS OK PROCCESS FILES AND EXECUTE:
if ( count( $validator_catch_errors ) < 1 ) { // No validating errors	
    
    // CHECK FOR USER BEHAVIOR BEFORE STARTING!:
    if ( isset($_POST['be']) ) {
        $user_behavior_log = $_POST['be'];
        $user_behavior_log = explode('-', $user_behavior_log);
        $user_behavior_log = array_filter($user_behavior_log);
        $user_behavior_log = array_unique($user_behavior_log);
                                
        if (   !in_array('top1',$user_behavior_log ) 
            || !in_array('top2', $user_behavior_log)
            || !in_array('top3',$user_behavior_log )
        ) {
            echo "hum"; 
            exit;
        }
    } else { 
        echo "hum"; 
        exit; 
    }
    
    //File list and debuger:
    $file_list  = array();
    $debug_list = array();
    
    //For file - unique name:
    $username   = explode('@', $fromsend);
                        
    for ( $i = 0; $i < count($_FILES); $i++ ) {
        $file_name_fixed = str_replace(' ', '_', preg_replace("/[^0-9a-zA-Z_.\-\s]/", "", strip_tags($_FILES['file'.($i+1)]['name'])));
        if ( $file_name_fixed != '' ) { 
            $prefix     = uniqid();
            $file_type  = explode('.',strip_tags($_FILES['file'.($i+1)]['name']));
            $file_type  = $file_type[count($file_type)-1];
            
            if ( @move_uploaded_file(strip_tags($_FILES['file'.($i+1)]['tmp_name']), 
                 $files_path.$username[0]."_".$prefix."_".$file_name_fixed)
            ) {
                $file_list[] = array(
                    $username[0]."_".$prefix."_".$file_name_fixed,
                    $_FILES['file'.($i+1)]['size'],
                    $file_type,
                    strip_tags($_FILES['file'.($i+1)]['name'])
                );
            } else {
                $debug_list[] = 'upload'.($i+1); // Debuger catch;
            }
        }
    } 
                        
    //Step1: store to log & approval log
    $log_group_for_copy_send = uniqid($username[0]);
    $log_group 	= mysqli_real_escape_string($linkos, $log_group_for_copy_send);
    $log_sender =  $fromsend; // allready escaped
    
    //Notify download:
    if ( isset($_POST['checkbox_notify']) 
         && $_POST['checkbox_notify'] == 'on'
    ) $log_notify = true; else $log_notify = false;

    //Notify read:
    if ( isset($_POST['checkbox_readEmail']) 
         && $_POST['checkbox_readEmail'] == 'on'
    ) $log_notify_read = true; else $log_notify_read = false;

    //Request copy:
    if ( isset($_POST['checkbox_copy']) 
         && $_POST['checkbox_copy'] == 'on'
    ) $log_copy = true; else $log_copy = false; 

    //User loging:
    if ( defined('SERVERREMOTE') ) 
        $log_user_ip = mysqli_real_escape_string($linkos, SERVERREMOTE); 
    else 
        $log_user_ip = 'False!';

    if ( defined('USERAGENT') ) 
        $log_user_agent = mysqli_real_escape_string($linkos, USERAGENT); 
    else 
        $log_user_agent = 'False!';
    

    //Variables to insert:
    $log_message    = $messsage_user;       // Allready escaped
    $timestamp      = date('Y-m-d G:i:s');  //MySQL basic `datetime` format
    $log_filename   = "";
    $log_filetype   = "";
    $log_filesize   = "";
    $log_to         = "";
    
    //Build list and send the mails:
    foreach ( $file_list as $key => $value ) {
        
        $filename_for_delete_if_needed = $value[0];
        $log_filename   = mysqli_real_escape_string($linkos, $value[0]);
        $log_filetype   = mysqli_real_escape_string($linkos, $value[2]);
        $log_filesize   = mysqli_real_escape_string($linkos, $value[1]);
        
        //Loop through all recipients:
        foreach ( $recipients as $index => $to_send ) {
            $to_send_name   = explode('@', $to_send);
            $secret         = uniqid($to_send_name[0]);
            $log_secret     = mysqli_real_escape_string($linkos, $secret);									
            $flag_sent_recip= true;
            
            //Send to Rec:
            if (sendMailTakeThatStyleTorecipient(
                $to_send,
                $log_sender,
                $messsage_head_recip,
                $messsage_body_recip,
                $messsage_user2,
                $log_filename,
                $secret,
                $files_path,
                $servermail,
                $brand,
                $linkos, 
                $lang
                )
            ) {
                //Success!
            } else {
                //Failed!
                $flag_sent_recip = false; 
            }

            if ( $flag_sent_recip ) { 
                //If succeded sending the mail:
                //Store to LOG files
                $log_to = $to_send; //Allready escaped.
                $sqlstat= "INSERT INTO `".$table2."` (
                           `group`,`filename`,`sender`,`to`,`notify`,`notify_read`,
                           `copy`,`user_ip`,`user_agent`,`message`,`when_sent`,
                           `file_type`,`file_size`) VALUES (
                           '".$log_group."','".$log_filename."','".$log_sender."',
                           '".$log_to."','".$log_notify."','".$log_notify_read."',
                           '".$log_copy."','".$log_user_ip."','".$log_user_agent."',
                           '".$log_message."','".$timestamp."','".$log_filetype."',
                           '".$log_filesize."')";
                
                if ( !mysqli_real_query($linkos, $sqlstat) ) { 
                    $debug_list[] = 'logfil'.($index+1); // Debuger catch; 
                }

                //Store to LOG approval					
                $sqlstat = "INSERT INTO `".$table4."` (`file_name`,`notify_to`,
                            `who`,`secret`,`do_notify`,`status_notify`,`when_notify`,
                            `do_notify_read`,`status_notify_read`,`when_notify_read`                                                    
                            ) VALUES ('".$log_filename."','".$log_sender."',
                            '".$log_to."','".$log_secret."','".$log_notify."','0',
                            '".$timestamp."','".$log_notify_read."','0','".$timestamp."')";
                                                    
                if ( !mysqli_real_query($linkos, $sqlstat) ) { 
                    $debug_list[] = 'logapp'.($index+1);  // Debuger catch;
                }
                
            } else { //Can't send Email so drop all.
                //Remove the bad file:
                if (file_exists($files_path.$filename_for_delete_if_needed)) {
                    unlink($files_path.$filename_for_delete_if_needed);
                }
                $debug_list[] = 'mailre'.($index+1); // Debuger catch;
            }
        }						
    }
                            
    //Send copy to user if requested:
    if ( $log_copy ) { 
        if ( sendMailTakeThatStyleTocopy(
            $recipients,
            $fromsend,
            $messsage_head_copy,
            $messsage_body_copy,
            $file_list,
            $log_group_for_copy_send,
            $files_path, 
            $servermail,
            $brand, 
            $linkos,
            $lang )
        ) {
            //Success!
        } else {
            //Failed!
            $debug_list[] = 'mailco';  // Debuger catch;
        } 
    }
                            
    //Output debuger:
    if ( count( $debug_list ) > 0 ) { 
        echo "deb".json_encode($debug_list); 
    } else {
        
        //Log stats mileage:
        if ( $log_copy ) { $log_copy_query = ", `counter_copy`=(`counter_copy` + 1)"; } else { $log_copy_query = ""; }
        if ( $log_message != "" ) { $log_message_query = ", `counter_attached_mes`=(`counter_attached_mes` + ".count($recipients)."), `last_attached_mes`=NOW()"; } else { $log_message_query = ""; }
        $sum_filesizes_mileage = mysqli_real_escape_string($linkos, $sum_filesizes_mileage);
        $sql2 = "UPDATE `".$table10."` SET `counter_sent`=(`counter_sent` + 1), `counter_files`=(`counter_files`+".$sum_filescount_mileage."), `counter_size`=(`counter_size`+".$sum_filesizes_mileage."), `last_sent`=NOW()".$log_copy_query.$log_message_query." WHERE `id`='1'";
        if ( !mysqli_real_query($linkos, $sql2) ) { /*Success!*/ }  
        
        //Log stat for users:
        if ( isset($userName) ) {
            $sql2 = "UPDATE `".$table10."` SET `counter_sent_user`=(`counter_sent_user` + 1), `counter_files_user`=(`counter_files_user`+".$sum_filescount_mileage."), `counter_size_user`=(`counter_size_user`+".$sum_filesizes_mileage."), `last_sent_user`=NOW() WHERE `id`='1'";
            if ( !mysqli_real_query($linkos, $sql2) ) { /*Success!*/ }
        }
        
        //Finish All echo OK:
        echo "ok[";  
    } 
} else {
    //There are validation issues - return json:
    echo "val".json_encode($validator_catch_errors); 
} 
    //close db connection:
    mysqli_close($linkos);
    exit;
