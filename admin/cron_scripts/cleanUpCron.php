<?php
    error_reporting(0);
    @ini_set('display_errors', 'off');   
    define('DS', DIRECTORY_SEPARATOR);
/*******************************   DEFINE   ***********************************/

//Weeks interval => older then [1, 2, 3, 4] weeks  
$intervalweeks = 1;

//Write to log?
$write_to_log = true; 

/******************************************************************************/

/******************************     FUNCTIONS      ****************************/
    // CHECK THAT FILES IS WRITEABLE:
    function write_to_log_success($deleted) {    
        if (file_exists("clean_up_log.txt")
            &&is_writable("clean_up_log.txt")
        ) {
                $f = fopen("clean_up_log.txt", "a");
                $msg = utf8_encode(date("Y-m-d H:i:s")." --> Cronjob Done! deleted ".
                        $deleted." files from server. \r\n");
                fwrite($f, $msg);
                fclose($f);
        }
    }
    function write_to_log_Error($error_message) {    
        if (file_exists("clean_up_log.txt")
            &&is_writable("clean_up_log.txt")
        ) {
                $f = fopen("clean_up_log.txt", "a");
                $msg = utf8_encode(date("Y-m-d H:i:s")." --> ".
                        $error_message.". \r\n");
                fwrite($f, $msg);
                fclose($f);
        }
    }
    
/****************  connection to db with protection  **************************/

    require_once("..".DS."..".DS."code".DS."lib".DS."dbvar.php");

    $table1 = "install_manager";
    $table2 = "files_log";
    $table3 = "blocked_users";
    $table4 = "approval_log";
    $table5 = "exclude_users";
    $table6 = "users_manager";
    $table7 = "def_account";
        
    $linkos = @mysqli_connect($host, $data_username, $data_password);
    if (!$linkos) {
        if ($write_to_log) {
            write_to_log_Error("No DB connection - installation is required! Code: dbcon12");
            exit;
        } else {
            exit;
        }  
    }
        
    //Using utf-8 (utf8_general_ci) charset
    mysqli_query($linkos, "SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
    mysqli_set_charset($linkos, "utf8_general_ci");
    if (!mysqli_select_db($linkos, $database)) {
        if ($write_to_log) {
            write_to_log_Error("No DB connection - installation is required! Code: dbset13");
            exit;
        } else {
            exit;
        }  
    }
        
/******************************************************************************/

/*****************************    PROCEDURE        ****************************/
    if (isset($intervalweeks)
        && is_numeric($intervalweeks)
        && $intervalweeks > 0
    ) {
            
        //Files to clean:
        $sqlstat = "SELECT * FROM `".$table2."` WHERE ".
                   "`when_sent` < NOW() - INTERVAL ".$intervalweeks." WEEK";
        $rs_result = mysqli_query($linkos, $sqlstat); 
        if (!$rs_result) {
            if ($write_to_log) {
                write_to_log_Error("Can't Search File logs!  Code: dblog14");
                exit;
            } else {
                exit;
            }
        } 
        
        $logids = array();
        while ($idr = mysqli_fetch_array($rs_result)) {
            $logids[]             = $idr['id'];
            $who_sent[]           = $idr['sender'];
            $to_sent[]            = $idr['to'];
            $file_server_name[]   = $idr['filename'];
        }
                
        //Folder path:
        $sqlstatus = "SELECT * FROM `".$table1."` WHERE `id`='1'";
        $rs_result = mysqli_query($linkos, $sqlstatus); 

        if (!$rs_result) {
            if ($write_to_log) {
                write_to_log_Error("Can't find files folder!  Code: dbpath15");
                exit;
            } else {
                exit;
            }
        } else { 
        
            while ($idr = mysqli_fetch_array($rs_result)) {
                $files_path = $idr['files_folder'];
            }
            
            //Procedure -> clean log,approval,folder files:
            $count_removed = 0;
            foreach ($logids as $keys => $idss) {  
                            
                //Delete from files log:
                $sqlstat1 = "DELETE FROM `".$table2."` WHERE `id`='".$idss."'";
                
                if (!mysqli_real_query($linkos, $sqlstat1)) { 
                    if ($write_to_log) {
                        write_to_log_Error("Can't Delete from file log table! file name: ".$file_server_name[$keys]);
                    }
                }
                                
                //Delete from approval log:
                $sqlstat2 = "DELETE FROM `".$table4."` WHERE 
                            `file_name`='".mysqli_real_escape_string($linkos, $file_server_name[$keys])."' 
                            AND `notify_to`='".mysqli_real_escape_string($linkos, $who_sent[$keys])."' 
                            AND `who`='".mysqli_real_escape_string($linkos, $to_sent[$keys])."'
                            ";
                if(!mysqli_real_query($linkos, $sqlstat2)) { 
                    if ($write_to_log) {
                        write_to_log_Error("Can't Delete from aproval log table! file name: ".$file_server_name[$keys]);
                    }
                } 
                                
                //Delete files:
                if(isset($files_path)) {
                    if (@unlink($files_path.$file_server_name[$keys])) 
                    {  
                        $count_removed ++; 
                    }
                }
                
            }
            
            //Log results:
            if ($write_to_log) {
                write_to_log_success($count_removed);
            } 
            
            //Log to DB stats:
            $sql1= "UPDATE `".$table10."` SET `counter_last_cleanup_files`='".$count_removed."', `last_clean_up`=NOW() WHERE `id`='1'";
            if(!mysqli_real_query($linkos, $sql1)) { }
            
            exit;
        }
    } else {
    
        if ($write_to_log) {
            write_to_log_Error("No weeks interval Set! Code: intset11");
            exit;
        }  
        
    }