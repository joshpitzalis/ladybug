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
/********************      REQUIRD CORE FILES      ****************************/
    
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
    
        // MAKE SURE SENDER WHAT IS SET OR DIE:
        if(!isset($_POST['what_save'])) 
            die('die6'); 
        else 
            $who_send = $_POST['what_save'];

/**************************  EXECUTE PROCEDURE  *******************************/

        switch ($who_send) {
            
            //Set user mode:
            case 'users_mode':
                if (isset($_POST['users_mode'])) 
                {
                    $users_mode = mysqli_real_escape_string($linkos, $_POST['users_mode']);
                    $sql229 = "UPDATE `".$table1."` SET 
                                        `users_mode`  = '".$users_mode."'
                                        WHERE `id`='1'"; 
                    $rs_result229 = mysqli_query ($linkos, $sql229) or die ("prob229"); 
                        echo "OK!";
                        exit;
                }  else {
                        echo "prob229!";
                        exit;
                }
            break;   
            
            //Update guest account settings:
            case 'update_guest':
                if (isset($_POST['update_guest_maxSize']) &&
                    isset($_POST['update_guest_maxFiles']) &&
                    isset($_POST['update_guest_maxRec'])
                ) {
                    $update_guest_maxSize  =  mysqli_real_escape_string($linkos, $_POST['update_guest_maxSize']);
                    $update_guest_maxFiles =  mysqli_real_escape_string($linkos, $_POST['update_guest_maxFiles']);
                    $update_guest_maxRec   =  mysqli_real_escape_string($linkos, $_POST['update_guest_maxRec']);
                    $sql219 = "UPDATE `".$table7."` SET 
                                        `maxfiles`  = '".$update_guest_maxFiles."',
                                        `maxsize`   = '".$update_guest_maxSize."',
                                        `maxrec`    = '".$update_guest_maxRec."'
                                        WHERE `id`='1'"; 
                    $rs_result219 = mysqli_query ($linkos, $sql219) or die ("prob219"); 
                        echo "OK!";
                        exit;
                }  else {
                        echo "prob291!";
                        exit;
                }
            break; 
            
            //Delete user account:
            case 'delete_user':
                if (isset($_POST['rowId'])) 
                {
                    $idDelete =  mysqli_real_escape_string($linkos, $_POST['rowId']);
                    $sql29  = "DELETE FROM `".$table6."` WHERE `id`='$idDelete'"; 
                    $rs_result29 = mysqli_query ($linkos, $sql29) or die ("prob29"); 

                        echo "OK!";
                        exit;
                }  else {
                        echo "prob291!";
                        exit;
                }
            break;  
            
            //Add new user account:
            case 'add_user_new':
                if (isset($_POST['new_userName'])&& 
                    isset($_POST['new_userPassword'])&& 
                    isset($_POST['new_fullName'])&& 
                    isset($_POST['new_userMail'])&&
                    isset($_POST['new_maxSize'])&&                                
                    isset($_POST['new_maxFiles'])&&
                    isset($_POST['new_maxRec'])                               
                ) {
                    $new_userName       =  mysqli_real_escape_string($linkos, $_POST['new_userName']);
                    $new_userPassword   =  mysqli_real_escape_string($linkos, md5($_POST['new_userPassword']));
                    $new_fullName       =  mysqli_real_escape_string($linkos, $_POST['new_fullName']);
                    $new_userMail       =  mysqli_real_escape_string($linkos, $_POST['new_userMail']);
                    $new_maxSize        =  mysqli_real_escape_string($linkos, $_POST['new_maxSize']);
                    $new_maxFiles       =  mysqli_real_escape_string($linkos, $_POST['new_maxFiles']);
                    $new_maxRec         =  mysqli_real_escape_string($linkos, $_POST['new_maxRec']);

                    $users_data = array();

                    $sql9 = "SELECT `username` FROM `".$table6."` "; 
                    $rs_result9 = mysqli_query ($linkos, $sql9) or die ("prob1"); 
                    while ( $idr_check_users = mysqli_fetch_array($rs_result9) ) {
                        $users_data[] = $idr_check_users['username'];
                    }
                    if (!in_array($new_userName, $users_data)) {
                        $sqlstat= "INSERT INTO `".$table6."` (".
                                   "`username`,`password`,`fullname`,".
                                   "`maxfiles`,`maxsize`,`maxrec`,`usermail`,".
                                   "`added`,`active`".
                                   ") VALUES (".
                                        "'".$new_userName."',".
                                        "'".$new_userPassword."',".
                                        "'".$new_fullName."',".
                                        "'".$new_maxFiles."',".
                                        "'".$new_maxSize."',".
                                        "'".$new_maxRec."',".
                                        "'".$new_userMail."',".
                                        "NOW(),".
                                        "'yes')";
                        if (!mysqli_real_query($linkos, $sqlstat)) { 
                            die('die8'); 
                        } else { 
                            echo "OK!"; 
                            exit;
                        }	
                    } else {
                        echo "Taken!";
                        exit;
                    }
                }
            break;
            
            //Update user account:
            case 'update_user':
                    if (isset($_POST['rowId'])&& 
                        isset($_POST['update_userName'])&& 
                        isset($_POST['update_userPassword'])&& 
                        isset($_POST['update_fullName'])&&
                        isset($_POST['update_userMail'])&&                                
                        isset($_POST['update_maxSize'])&&                                
                        isset($_POST['update_maxFiles'])&&                                
                        isset($_POST['update_maxRec'])&&
                        isset($_POST['update_active'])
                    ) {
                        $rowId =  mysqli_real_escape_string($linkos, $_POST['rowId']);
                        if ($_POST['update_userPassword'] != '')
                            $update_userPassword =  mysqli_real_escape_string($linkos, md5($_POST['update_userPassword']));
                        else 
                            $update_userPassword = '';

                        $update_userName  = mysqli_real_escape_string($linkos, $_POST['update_userName']);
                        $update_fullName  = mysqli_real_escape_string($linkos, $_POST['update_fullName']);
                        $update_userMail  = mysqli_real_escape_string($linkos, $_POST['update_userMail']);
                        $update_maxSize   = mysqli_real_escape_string($linkos, $_POST['update_maxSize']);
                        $update_maxFiles  = mysqli_real_escape_string($linkos, $_POST['update_maxFiles']);
                        $update_maxRec    = mysqli_real_escape_string($linkos, $_POST['update_maxRec']);
                        $update_active    = mysqli_real_escape_string($linkos, $_POST['update_active']);

                        $users_data = array();

                        $sql9 = "SELECT `id`,`username`,`password` FROM `".$table6."` "; 
                        $rs_result9 = mysqli_query ($linkos, $sql9) or die ("prob1"); 
                        while ($idr_check_users = mysqli_fetch_array($rs_result9)) {
                            $users_data[$idr_check_users['id']] = $idr_check_users['username'];
                            $users_pass[$idr_check_users['id']] = $idr_check_users['password'];
                        }

                        if ($users_data[$rowId] == $update_userName && $update_userPassword == '') {
                            $sqlstat= "UPDATE `".$table6."` SET 
                                            `fullname`  = '".$update_fullName."',
                                            `maxfiles`  = '".$update_maxFiles."',
                                            `maxsize`   = '".$update_maxSize."',
                                            `maxrec`    = '".$update_maxRec."',
                                            `usermail`  = '".$update_userMail."',
                                            `added`     = NOW(),
                                            `active`    = '".$update_active."'
                                      WHERE `id`='".$rowId."'";
                            if (!mysqli_real_query($linkos, $sqlstat)) { 
                                die('die8'); 
                            } else { 
                                echo "OK!"; 
                                exit; 
                            }	
                        } else if ($users_data[$rowId] == $update_userName && $update_userPassword != '') {
                            $sqlstat= "UPDATE `".$table6."` SET 
                                            `password`  = '".$update_userPassword."',
                                            `fullname`  = '".$update_fullName."',
                                            `maxfiles`  = '".$update_maxFiles."',
                                            `maxsize`   = '".$update_maxSize."',
                                            `maxrec`    = '".$update_maxRec."',
                                            `usermail`  = '".$update_userMail."',
                                            `added`     = NOW(),
                                            `active`    = '".$update_active."'
                                      WHERE `id`='".$rowId."'";
                            if (!mysqli_real_query($linkos, $sqlstat)) { 
                                die('die8'); 
                            } else { 
                                echo "OK!"; 
                                exit; 
                            }

                        } else if ($users_data[$rowId] != $update_userName && $update_userPassword == '') {
                            unset($users_data[$rowId]);
                            if (!in_array($update_userName, $users_data)) {
                                $sqlstat= "UPDATE `".$table6."` SET 
                                                `username`  = '".$update_userName."',
                                                `fullname`  = '".$update_fullName."',
                                                `maxfiles`  = '".$update_maxFiles."',
                                                `maxsize`   = '".$update_maxSize."',
                                                `maxrec`    = '".$update_maxRec."',
                                                `usermail`  = '".$update_userMail."',
                                                `added`     = NOW(),
                                                `active`    = '".$update_active."'
                                          WHERE `id`='".$rowId."'";
                                if (!mysqli_real_query($linkos, $sqlstat)) { 
                                    die('die8'); 
                                } else { 
                                    echo "OK!"; 
                                    exit; 
                                }
                            } else {
                                echo "Taken!";
                                exit;
                            }
                        } else if ($users_data[$rowId] != $update_userName && $update_userPassword != '') {
                            unset($users_data[$rowId]);
                            if (!in_array($update_userName, $users_data)) {
                                $sqlstat= "UPDATE `".$table6."` SET 
                                                `username`  = '".$update_userName."',
                                                `password`  = '".$update_userPassword."',
                                                `fullname`  = '".$update_fullName."',
                                                `maxfiles`  = '".$update_maxFiles."',
                                                `maxsize`   = '".$update_maxSize."',
                                                `maxrec`    = '".$update_maxRec."',
                                                `usermail`  = '".$update_userMail."',
                                                `added`     = NOW(),
                                                `active`    = '".$update_active."'
                                          WHERE `id`='".$rowId."'";
                                if (!mysqli_real_query($linkos, $sqlstat)) { 
                                    die('die8'); 
                                } else { 
                                    echo "OK!"; 
                                    exit; 
                                }
                            } else {
                                echo "Taken!";
                                exit;
                            }                                
                        }
                        else {
                            die('no action');
                        }
                }
                break;

            default: break;
        }

    } else {
        die('die5');
    }
 
    } else {
      die('die5');   
    }