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

//connection to db with protection:
 
    //Token check:
    checktoken($token);
    
    //Include DB variables:
    require_once("dbvar.php");
    
    //Tables (do not modify):
    $table1 = "install_manager";
    $table2 = "files_log";
    $table3 = "blocked_users";
    $table4 = "approval_log";
    $table5 = "exclude_users";
    $table6 = "users_manager";
    $table7 = "def_account";
    $table8 = "ads_types_use";   
    $table9 = "ads_manager";
    $table10 = "files_mileage";
    
    //Connect:
    $linkos = @mysqli_connect($host, $data_username, $data_password);
    if(!$linkos) die("<h3>".$lang[$lang['set']]['type_installation_needed']."</h3>");
        
    //Using utf-8 ( utf8_general_ci ) charset:
    mysqli_query($linkos, "SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
    mysqli_set_charset($linkos, "utf8_general_ci");
    if(!mysqli_select_db($linkos, $database)) die("<h3>".$lang[$lang['set']]['type_installation_needed']."</h3>"); 