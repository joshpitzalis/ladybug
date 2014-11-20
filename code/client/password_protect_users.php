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

    $LOGIN_INFORMATION = array();
    $user_id    = array();
    $user_data  = array();
    
    //Get users array:
    $sql = "SELECT * FROM `".$table6."` WHERE `active`='yes'"; 
    $rs_result = mysqli_query ($linkos, $sql) or die ("prob1"); 
    while ($idr_check = mysqli_fetch_array($rs_result)) {
        $LOGIN_INFORMATION[$idr_check['username']] = $idr_check['password'];
    }
    unset($sql);
    unset($rs_result);
    unset($idr_check);			

    //Cookie timeout in seconds - set in func.php
    $timeout = (TIMEOUT_MINUTES == 0 ? 0 : time() + TIMEOUT_MINUTES * 60);

    if (isset($_GET['logout'])) {
        setcookie("user_login", "", time()-38600, "/");
        usleep(300);
        $uname='nouser';
    } else {
        //User provided password - login from form:
        if (isset($_POST['access_user_password'])&&isset($_POST['access_user_name'])
        ) {
            $login = isset($_POST['access_user_name']) ? 
                           $_POST['access_user_name'] : '';
            $pass = md5($_POST['access_user_password']);
            
            if (!USE_USERNAME 
                && !in_array($pass, $LOGIN_INFORMATION) 
                || (USE_USERNAME 
                && (!array_key_exists($login, $LOGIN_INFORMATION)
                || $LOGIN_INFORMATION[$login] != $pass))
            ) {	
               //No match!				
               usleep(300);
            } else {
               //Log user login:
               $sql1= "UPDATE ".$table10." SET `counter_login_user`=(`counter_login_user` + 1), `last_user_login`=NOW() WHERE id='1'";
               if(!mysqli_real_query($linkos, $sql1)) { }
               //Set cookie if password was validated
               setcookie("user_login", $login.'%'.$pass, $timeout, '/');
               flush;
               usleep(300);
               unset($_POST['access_user_name']);
               unset($_POST['access_user_password']);
               usleep(300);
               flush;
               header('Location:index.php');
               exit;
            }
        }
        //Check if password cookie is set
        if (isset($_COOKIE['user_login'])) {
            $found = false;
            //Check if cookie is good
            foreach ($LOGIN_INFORMATION as $key=>$val) {
                $lp = (USE_USERNAME ? $key : '') .'%'.$val;
                if ($_COOKIE['user_login'] == $lp) {
                    $found = true;
                    $uname=$key;
                    setcookie("user_login", $lp, $timeout, '/');
                    usleep(300);
                    break;
                } else {
                    setcookie("user_login", $lp, time()-3600, '/');
                }
            }
            if ($found==false) { $uname="nouser"; }
        } else {
                $uname="nouser";
        }
    }
