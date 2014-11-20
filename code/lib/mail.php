<?php

error_reporting(0);
@ini_set('display_errors', 'off');
session_start();
define('DS',DIRECTORY_SEPARATOR);

//include functions -> after:
require_once("lang.php");
require_once("func.php");

if (isset($_GET['req'])) {

//set connection & include DB variables:
    require_once("dbvar.php");

    //tables:
    $table1 = "install_manager";
    $table4 = "approval_log";
    $table10 = "files_mileage";

    //connect:
    $linkos = @mysqli_connect($host, $data_username, $data_password);
    if(!$linkos) die();

    //using utf8 data
    mysqli_query($linkos, "SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
    mysqli_set_charset($linkos, "utf8_general_ci");
    if(!mysqli_select_db($linkos, $database)) die();

//get settings: 
    $sqlstatus = "SELECT * FROM `".$table1."` WHERE id='1' ";
    $rs_result = mysqli_query($linkos, $sqlstatus) or die ();      
    while ( $idr = mysqli_fetch_array($rs_result) ) {
        $brand 	    = $idr['brand_name'];
        $files_path	= $idr['files_folder'];
        $servermail = $idr['server_mail'];
    }

//get secret:
    $parsed_secret = mysqli_real_escape_string($linkos, $_GET['req']);

//find target file:
    $sqlstatus1 = "SELECT * FROM `".$table4."` WHERE `secret`='".$parsed_secret."' ";
    $rs_result1 = mysqli_query($linkos, $sqlstatus1) or die (); 
    while ( $idr1 = mysqli_fetch_array($rs_result1) ) {
        $id_file 	        = $idr1['id'];
        $file_name 	        = $idr1['file_name'];
        $notify_to 	        = $idr1['notify_to'];
        $do_notify 	        = $idr1['do_notify'];
        $status_notify      = $idr1['status_notify'];
        $when_notify        = $idr1['when_notify'];
        $do_notify_read	    = $idr1['do_notify_read'];
        $status_notify_read = $idr1['status_notify_read'];
        $when_notify_read   = $idr1['when_notify_read'];                
        $who_down 	        = $idr1['who'];
    }    
    if (isset($do_notify_read)) {
        //log query
        $sqlstat= "UPDATE `".$table4."` SET `status_notify_read`='1', `when_notify_read`=NOW() WHERE `id`='".$id_file."' ";
        if ($do_notify_read) {
            if (!$status_notify_read) {
                //need to log + send Email to sender:
                if(!sendMailTakeThatNotificationApproveRead($notify_to,$who_down,$file_name,$servermail,$brand,$parsed_secret."-r",$linkos,$lang)) {  
                } else {
                    //log read notify:
                    $sql1= "UPDATE ".$table10." SET `counter_notify_read`=(`counter_notify_read` + 1), `last_notify_read`=NOW() WHERE id='1'";
                    if(!mysqli_real_query($linkos, $sql1)) { }
                    //Update file approval status:
                    if(!mysqli_real_query($linkos, $sqlstat)) die(); 
                }                
            }
        } else {
            //only log:
            if(!mysqli_real_query($linkos, $sqlstat)) die(); 
        }
    }
    mysqli_close($linkos);	
}
//serv image:
serv_file();
