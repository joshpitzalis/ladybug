<?php
/*******************************************************************************
 * Created by: shlomo hassid.
 * Release Version : 3.0
 * Creation Date: 14/08/2013
 * Updated To V.2.X : 05/01/2014
 * Updated To V.3.0 : 14/08/2014
 * Mail: Shlomohassid@gmail.com
 * require: jquery latest ( best: 10.1 ) version SQL 4+ PHP 5.3+ .	
 * Copyright 2014, shlomo hassid.
*******************************************************************************/
/*************************** requird core files *******************************/

    error_reporting(0);
    @ini_set('display_errors', 'off');
    session_start();
    define('DS', DIRECTORY_SEPARATOR);
    
    //include lang:
    require_once( "lang/lang_admin.php" );
    
    //include functions lib:
    require_once("..".DS."code".DS."lib".DS."func.php");
    
    //token check:
    if (!isset($_POST['user_token'])) 
        die('die4');
    else 
        $token = $_POST['user_token'];
    
    //set connection:
    require("..".DS."code".DS."lib".DS."conndb.php");
    
    //require password:
    require_once("password_protect.php");

    if (isset($uname)) {
        if($uname!="nouser") {
            
/**************************  EXECUTE PROCEDURE  *******************************/
            
            if (isset($_POST['what_do'])) {
                switch ($_POST['what_do']) {
                
                    case "e_file_sent":
                        //reset log:
                            $sql1= "UPDATE `".$table10."` SET"
                                   ." `counter_files`= '0'"
                                   .", `counter_files_user`= '0'"
                                   ." WHERE `id`='1'";
                            if(!mysqli_real_query($linkos, $sql1)) { die('dieE1'.mysqli_error($linkos)); }
                    break;
                    
                    case "e_file_size":
                        //reset log:
                            $sql1= "UPDATE `".$table10."` SET"
                                   ." `counter_size`= '0'"
                                   .", `counter_size_user`= '0'"
                                   ." WHERE `id`='1'";
                            if(!mysqli_real_query($linkos, $sql1)) { die('dieE2'.mysqli_error($linkos)); }                    
                    break;
                    
                    case "e_share_tot":
                        //reset log:
                            $sql1= "UPDATE `".$table10."` SET"
                                   ." `counter_sent`= '0'"
                                   .", `last_sent`= '0000-00-00 00:00:00'"
                                   ." WHERE `id`='1'";
                            if(!mysqli_real_query($linkos, $sql1)) { die('dieE3'.mysqli_error($linkos)); }                          
                    break;
                    
                    case "e_share_user":
                        //reset log:
                            $sql1= "UPDATE `".$table10."` SET"
                                   ." `counter_sent_user`= '0'"
                                   .", `last_sent_user`= '0000-00-00 00:00:00'"
                                   ." WHERE `id`='1'";
                            if(!mysqli_real_query($linkos, $sql1)) { die('dieE4'.mysqli_error($linkos)); }                       
                    break;
                    
                    case "e_files_deliv":
                        //reset log:
                            $sql1= "UPDATE `".$table10."` SET"
                                   ." `counter_deliv`= '0'"
                                   .", `last_deliv`= '0000-00-00 00:00:00'"
                                   ." WHERE `id`='1'";
                            if(!mysqli_real_query($linkos, $sql1)) { die('dieE5'.mysqli_error($linkos)); }                          
                    break;
                    
                    case "e_notify_deliv":
                        //reset log:
                            $sql1= "UPDATE `".$table10."` SET"
                                   ." `counter_notify_deliv`= '0'"
                                   .", `last_notify_deliv`= '0000-00-00 00:00:00'"
                                   ." WHERE `id`='1'";
                            if(!mysqli_real_query($linkos, $sql1)) { die('dieE6'.mysqli_error($linkos)); }                          
                    break;
                    
                    case "e_notify_read":
                        //reset log:
                            $sql1= "UPDATE `".$table10."` SET"
                                   ." `counter_notify_read`= '0'"
                                   .", `last_notify_read`= '0000-00-00 00:00:00'"
                                   ." WHERE `id`='1'";
                            if(!mysqli_real_query($linkos, $sql1)) { die('dieE7'.mysqli_error($linkos)); }                      
                    break;
                    
                    case "e_mes_attach":
                        //reset log:
                            $sql1= "UPDATE `".$table10."` SET"
                                   ." `counter_attached_mes`= '0'"
                                   .", `last_attached_mes`= '0000-00-00 00:00:00'"
                                   ." WHERE `id`='1'";
                            if(!mysqli_real_query($linkos, $sql1)) { die('dieE8'.mysqli_error($linkos)); }                      
                    break;
                    
                    case "e_copies":
                        //reset log:
                            $sql1= "UPDATE `".$table10."` SET"
                                   ." `counter_copy`= '0'"
                                   ." WHERE `id`='1'";
                            if(!mysqli_real_query($linkos, $sql1)) { die('dieE9'.mysqli_error($linkos)); }                       
                    break;
                    
                    case "e_admin":
                        //reset log:
                            $sql1= "UPDATE `".$table10."` SET"
                                   ." `last_admin_login`= '0000-00-00 00:00:00'"
                                   ." WHERE `id`='1'";
                            if(!mysqli_real_query($linkos, $sql1)) { die('dieE10'.mysqli_error($linkos)); }                      
                    break;
                    
                    case "e_logins":
                        //reset log:
                            $sql1= "UPDATE `".$table10."` SET"
                                   ." `counter_login_user`= '0'"
                                   .", `last_user_login`= '0000-00-00 00:00:00'"
                                   ." WHERE `id`='1'";
                            if(!mysqli_real_query($linkos, $sql1)) { die('dieE11'.mysqli_error($linkos)); }                      
                    break;
                    
                    case "e_mpage":
                        //reset log:
                            $sql1= "UPDATE `".$table10."` SET"
                                   ." `counter_visit_main`= '0'"
                                   .", `last_visit_main`= '0000-00-00 00:00:00'"
                                   ." WHERE `id`='1'";
                            if(!mysqli_real_query($linkos, $sql1)) { die('dieE12'.mysqli_error($linkos)); }                       
                    break;
                    
                    case "e_dpage":
                        //reset log:
                            $sql1= "UPDATE `".$table10."` SET"
                                   ." `counter_visit_down`= '0'"
                                   .", `last_visit_down`= '0000-00-00 00:00:00'"
                                   ." WHERE `id`='1'";
                            if(!mysqli_real_query($linkos, $sql1)) { die('dieE13'.mysqli_error($linkos)); }                     
                    break;
                    
                    case "e_clean":
                        //reset log:
                            $sql1= "UPDATE `".$table10."` SET"
                                   ." `counter_last_cleanup_files`= '0'"
                                   .", `last_clean_up`= '0000-00-00 00:00:00'"
                                   ." WHERE `id`='1'";
                            if(!mysqli_real_query($linkos, $sql1)) { die('dieE14'.mysqli_error($linkos)); }                     
                    break; 
                    
                    default: die('die12'); break;
                    
                }
                
                echo "OK";
                exit;
                
            } else { die('die6'); }
        } else { die('die5'); }
    } else { die('die5'); }

    