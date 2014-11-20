<?php
    error_reporting(0);
    ini_set('display_errors', 'off');
    define('DS', DIRECTORY_SEPARATOR);
    require_once("code".DS."lib".DS."phpSet.php");
    session_start();
    require_once("code".DS."lib".DS."lang.php");
    require_once("code".DS."lib".DS."func.php");

    //Tokenize the page:
    gettoken();
    $token = md5($_SESSION['user_token']);
    
    //DB connection:
    require("code".DS."lib".DS."conndb.php");
    
    //Get settings: 
    $sqlstatus  = "SELECT * FROM `".$table1."` WHERE `id`='1' ";
    $rs_result  = mysqli_query($linkos, $sqlstatus) or die ("<h3>".$lang[$lang['set']]['type_installation_needed']."</h3>"); 
    $users_mode = '';        
        while ( $idr = mysqli_fetch_array($rs_result) ) {
            $brand          = $idr['brand_name'];
            $accept_types   = $idr['accept_types'];
            $files_path     = $idr['files_folder'];
            $servermail     = $idr['server_mail'];
            $users_mode     = $idr['users_mode'];
            $themeUse       = $idr['theme'];
            $include_miles  = $idr['include_miles'];
        }
            

    if ( isset($brand) && isset($accept_types) ) {
        if ( !isset($_GET["get"]) && !isset($_GET["gr"]) ) {
            
            //Log visit main page:
            $sql1= "UPDATE `".$table10."` SET `counter_visit_main`=(`counter_visit_main` + 1), `last_visit_main`=NOW() WHERE `id`='1'";
            if(!mysqli_real_query($linkos, $sql1)) { }
            
            //Load pages:
            switch($users_mode) {
                
                //Main -> users & guests:
                case "users-guests":
                    include("code".DS."client".DS."usersNguests.php");   
                break;
                
                //Main -> guests:
                case "guests":
                    include("code".DS."client".DS."GuestsOnlyPage.php");
                break;
                
                //Main -> users:
                case "users":
                    require("code".DS."client".DS."password_protect_users.php");
                    include("code".DS."client".DS."usersOnlyPage.php");
                break;
                
                //Default Main -> users & guests:
                default:  echo "<h3>".$lang[$lang['set']]['type_installation_needed']."</h3>";            
            }
            
        } else {
            
            //Log visit download:
            $sql1= "UPDATE `".$table10."` SET `counter_visit_down`=(`counter_visit_down` + 1), `last_visit_down`=NOW() WHERE `id`='1'";
            if(!mysqli_real_query($linkos, $sql1)) { echo $lang[$lang['set']]['type_db_error']."8976125"; }
            
            //Include download page:
            include("code".DS."client".DS."downloadFile.php");
        }

    } else {
        // Output a installation needed
        echo "<h3>".$lang[$lang['set']]['type_installation_needed']."</h3>";
    }

mysqli_close($linkos);