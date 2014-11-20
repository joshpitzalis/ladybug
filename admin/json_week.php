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
            if (isset($_POST['what_do'])) {
                
 /***************************     Procedure     *******************************/ 
                
                //create fill object:
                $logDates = array();
                $return = array();
                for ( $i = 0; $i < 7; $i++ ) {
                    $date = date("m.d", strtotime(date("m.d")." -".$i." day"));
                    $logDates[$date] = 0;
                }
                //files past week:
                $sqlstat = "SELECT * FROM `".$table2."` WHERE ".
                           "`when_sent` > DATE_SUB( NOW() , INTERVAL 1 WEEK )";
                $rs_result = mysqli_query($linkos, $sqlstat); 
                if (!$rs_result) die('die7');
                
                switch ($_POST['what_do']) {
                
                    case "json_sent_counts":
                    
                        //Count:
                        while ($idr = mysqli_fetch_array($rs_result)) {
                            $date = date("m.d",strtotime($idr['when_sent']));
                            if (isset($logDates[$date]))  $logDates[$date]++;
                        }                
                        
                        //Parse to array:
                        foreach ($logDates as $key => $data)
                            $return[] = array( "date" => $key, "count" => $data );

                        echo "OK".json_encode($return);
                        
                    break;
                    
                    case "json_file_sizes":
                        
                        //Count:
                        while ($idr = mysqli_fetch_array($rs_result)) {
                            $date = date("m.d",strtotime($idr['when_sent']));
                            if (isset($logDates[$date]))  
                                $logDates[$date]+=  
                                    floatval(preg_replace("/[^0-9.]/","",humanFileSize($idr['file_size'],"MB")));
                        }                
                        
                        //Parse to array:
                        foreach ($logDates as $key => $data)
                            $return[] = array( "date" => $key, "count" => $data );

                        echo "OK".json_encode($return);                    
                    
                    break;
                    
                    default: die('12'); break;
                    
                }
                
            } else { die('die6'); }
        } else { die('die5'); }
    } else { die('die5'); }