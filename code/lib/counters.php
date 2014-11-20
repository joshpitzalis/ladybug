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
error_reporting(0);
@ini_set('display_errors', 'off');   
session_start();
define('DS', DIRECTORY_SEPARATOR);

    //Requird core files */
    require_once("func.php");
    
    //Tokenize Page:
    if (!isset($_POST['user_token'])) 
        die('die4');
    else 
        $token = $_POST['user_token'];
    
    // MAKE SURE TOKEN IS VALID OR DIE:
    require("conndb.php");
    
    // MAKE SURE SENDER WHAT IS SET OR DIE:
    if(!isset($_POST['what'])) die('die6'); 
        else $what = $_POST['what'];
    
    // EXECUTE:				
    switch ($what) {
        case 'counter_banner_click':
            if (isset($_POST['banner_id'])) {
                $banner_code =  mysqli_real_escape_string($linkos, $_POST['banner_id']);
                $sql229 = "UPDATE `".$table9."` SET `counter_clicks` = `counter_clicks` + 1 WHERE `id`='".$banner_code."'"; 
                $rs_result229 = mysqli_query ($linkos, $sql229) or die ("prob2148"); 
                echo "OK!";
            } else {
                echo "prob148974!";
            }
        break;
        default: break;
    }
    exit;