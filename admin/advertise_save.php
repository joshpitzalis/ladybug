<?php
/********************      REQUIRD CORE FILES      ****************************/
    error_reporting(0);
    @ini_set( 'display_errors', 'off' );   
    session_start();
    define('DS', DIRECTORY_SEPARATOR);
    
    //include lang:
    require_once( "lang/lang_admin.php" );
    
    //include functions lib:
    require_once( "..".DS."code".DS."lib".DS."func.php" );
    
    //check page token:
    if ( !isset( $_POST['user_token'] ) ) die('die4');
    else $token = $_POST['user_token'];
    
    //set connection:
    require( "..".DS."code".DS."lib".DS."conndb.php" );
    
    //require password:
    require_once("password_protect.php");

    if (isset($uname)) {
        if($uname!="nouser") {
            // MAKE SURE SENDER what_save IS SET OR DIE:
            if(!isset( $_POST['what_save'] )) 
                die('die6'); 
            else 
                $who_send = $_POST['what_save'];
            
/**************************  EXECUTE PROCEDURE  *******************************/
            switch ( $who_send ) {
                
            //Save General Settings:
                case 'general_advertise':
                    if (isset($_POST['mainpage_include_type'])&& 
                        isset($_POST['downpage_include_type'])&& 
                        isset($_POST['emailrec_include'])&& 
                        isset($_POST['emailsender_include'])&&
                        isset($_POST['count_sent'])&&                                
                        isset($_POST['count_clicks'])&&
                        isset($_POST['user_adds'])&&
                        isset($_POST['guests_adds'])                               
                    ) {
                        //Parse input values:
                        if ( $_POST['mainpage_include_type'] == 'adsense' ) { $adsense_mainpage = 1; $banner_mainpage = 0; }
                            else { $adsense_mainpage = 0; $banner_mainpage = 1; }
                        if ( $_POST['downpage_include_type'] == 'adsense' ) { $adsense_downpage = 1; $banner_downpage = 0; }
                            else { $adsense_downpage = 0; $banner_downpage = 1; }
                        if ( $_POST['emailrec_include'] == 'on' ) { $emailrec_include = 1; } else { $emailrec_include = 0; }    
                        if ( $_POST['emailsender_include'] == 'on' ) { $emailsender_include = 1; } else { $emailsender_include = 0; }                                 
                        if ( $_POST['count_sent'] == 'on' ) { $count_sent = 1; } else { $count_sent = 0; }
                        if ( $_POST['count_clicks'] == 'on' ) { $count_clicks = 1; } else { $count_clicks = 0; }
                        if ( $_POST['user_adds'] == 'on' ) { $user_adds = 1; } else { $user_adds = 0; }
                        if ( $_POST['guests_adds'] == 'on' ) { $guests_adds = 1; } else { $guests_adds = 0; }
                        
                        //Save to DB:
                        $sql229 = "UPDATE `".$table8."` SET 
                                    `adsense_mainpage` = '".$adsense_mainpage."' 
                                    ,`banner_mainpage` = '".$banner_mainpage."' 
                                    ,`adsense_downpage` = '".$adsense_downpage."' 
                                    ,`banner_downpage` = '".$banner_downpage."' 
                                    ,`guests` = '".$guests_adds."' 
                                    ,`users` = '".$user_adds."' 
                                    ,`email_sender` = '".$emailsender_include."' 
                                    ,`email_rec` = '".$emailrec_include."' 
                                    ,`count_clicks` = '".$count_clicks."' 
                                    ,`count_sent` = '".$count_sent."' 
                                    WHERE `id`='1'"; 
                        $rs_result229 = mysqli_query ($linkos, $sql229) or die ("prob229"); 
                        echo "OK!";
                        exit;
     
                    }  else {
                            echo "prob2294!";
                            exit;
                    }
                    break; 
                    
            //Save Code add Settings:    
                case 'general_adsenseCode':
                    if (   isset($_POST['adsense_code']) 
                        && isset($_POST['adsense_code_head'])
                    ) {
                        $adsense_code =  mysqli_real_escape_string($linkos, $_POST['adsense_code']);
                        $adsense_head =  mysqli_real_escape_string($linkos, $_POST['adsense_code_head']);
                        $sql229 = "UPDATE `".$table8."` SET `adsense_code` = '".$adsense_code."', `adsense_head` = '".$adsense_head."' WHERE `id`='1'"; 
                        $rs_result229 = mysqli_query ($linkos, $sql229) or die ("prob2299"); 
                        echo "OK!";
                        exit;
                        
                    } else {
                            echo "prob22974!";
                            exit;
                    }
                    break; 
                    
            //Save and Add banner:        
                case 'general_addbanner':
                    if (isset($_POST['banners_file_name'])&& 
                        isset($_POST['banners_url'])&& 
                        isset($_POST['banners_alt_name'])                            
                    ) {
                    //Parse inputs:
                        if (isset($_POST['banners_users_exposure']))  
                            { $user = 1; } else { $user = 0; }
                        if (isset($_POST['banners_guests_exposure'])) 
                            { $guest = 1; } else { $guest = 0; }
                        if (isset($_POST['banners_allow_down']))      
                            { $downpage = 1; } else { $downpage = 0; } 
                        if (isset($_POST['banners_allow_main']))      
                            { $mainpage = 1; } else { $mainpage = 0; }                                 
                        if (isset($_POST['banners_allow_rec']))       
                            { $email_rec = 1; } else { $email_rec = 0; }
                        if (isset($_POST['banners_allow_sender']))    
                            { $email_sender = 1; } else { $email_sender = 0; } 
                        $banners_file_name  =  mysqli_real_escape_string($linkos, $_POST['banners_file_name']);
                        $banners_alt_name   =  mysqli_real_escape_string($linkos, $_POST['banners_alt_name']);
                        $banners_url   =  mysqli_real_escape_string($linkos, $_POST['banners_url']);
                    
                    //Save to DB:
                        $sqlstat= "INSERT INTO `".$table9."` (
                                         `banner_filename`
                                        ,`banner_altname`
                                        ,`url`
                                        ,`active`
                                        ,`guest`
                                        ,`user`
                                        ,`email_sender`
                                        ,`email_rec`
                                        ,`mainpage`
                                        ,`downpage`
                                        ,`created`  
                                        ) VALUES (
                                         '".$banners_file_name."'
                                        ,'".$banners_alt_name."'
                                        ,'".$banners_url."'
                                        ,'1'
                                        ,'".$guest."'
                                        ,'".$user."'
                                        ,'".$email_sender."'
                                        ,'".$email_rec."'
                                        ,'".$mainpage."'
                                        ,'".$downpage."'
                                        ,NOW()
                                        )";
                        if (!mysqli_real_query($linkos, $sqlstat)) { 
                            die('die868'); 
                        } else { 
                            echo "OK!"; 
                            exit;
                        }	
                    } 
                    break;
                    
            //Update banner:       
                case 'update_advertise':
                    if (
                        isset($_POST['ads_up_id'])&&
                        isset($_POST['banners_url_up'])&& 
                        isset($_POST['banners_alt_name_up'])                            
                    ) {
                        
                    //Parse inputs:
                        if (isset($_POST['banners_users_exposure_up'])) 
                            { $user = 1; } else { $user = 0; }
                        if (isset($_POST['banners_guests_exposure_up'])) 
                            { $guest = 1; } else { $guest = 0; }
                        if (isset($_POST['banners_allow_down_up']))      
                            { $downpage = 1; } else { $downpage = 0; } 
                        if (isset($_POST['banners_allow_main_up']))      
                            { $mainpage = 1; } else { $mainpage = 0; }                                 
                        if (isset($_POST['banners_allow_rec_up']))       
                            { $email_rec = 1; } else { $email_rec = 0; }
                        if (isset($_POST['banners_allow_sender_up']))    
                            { $email_sender = 1; } else { $email_sender = 0; } 
                        $ads_up_id          =  mysqli_real_escape_string($linkos, $_POST['ads_up_id']);
                        $banners_alt_name   =  mysqli_real_escape_string($linkos, $_POST['banners_alt_name_up']);
                        $banners_url        =  mysqli_real_escape_string($linkos, $_POST['banners_url_up']);
                    
                    //Save to DB:
                        $sqlstat= "UPDATE `".$table9."` SET 
                                      `banner_altname`  = '".$banners_alt_name."'
                                      ,`url`            = '".$banners_url."'
                                      ,`active`         = '1'
                                      ,`guest`          = '".$guest."'
                                      ,`user`           = '".$user."'
                                      ,`email_sender`   = '".$email_sender."'
                                      ,`email_rec`      = '".$email_rec."'
                                      ,`mainpage`       = '".$mainpage."'
                                      ,`downpage`       = '".$downpage."' 
                                   WHERE `id` = '".$ads_up_id."'";
                        if (!mysqli_real_query($linkos, $sqlstat)) { 
                            die('die68731'); 
                        } else { 
                            echo "OK!"; 
                            exit;
                        }	
                    }                             
                    break;
                    
            //Delete banner:
                case 'delete_advertise':
                    if (isset($_POST['ads_id_up'])) {
                        $ads_up_id =  mysqli_real_escape_string($linkos, $_POST['ads_id_up']);
                        $sqlstat = "DELETE FROM `".$table9."` WHERE `id` = '".$ads_up_id."' ";
                        if (!mysqli_real_query($linkos, $sqlstat)) { 
                            die('die65487'); 
                        } else { 
                            echo "OK!"; 
                            exit;
                        }	
                    }                               
                    break;
                
            //Reset banner counter:    
                case 'reset_counters':
                    if (isset($_POST['ads_id_up'])) {
                        $ads_up_id =  mysqli_real_escape_string($linkos, $_POST['ads_id_up']);
                        $sqlstat= "UPDATE `".$table9."` SET 
                                  `counter_clicks` = '0'
                                  ,`counter_sent`  = '0'
                                  WHERE `id` = '".$ads_up_id."'";
                        if (!mysqli_real_query($linkos, $sqlstat)) { 
                            die('die68731'); 
                        } else { 
                            echo "OK!"; 
                            exit;
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