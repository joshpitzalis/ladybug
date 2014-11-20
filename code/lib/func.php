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
/****************************** SYSTEM VARIBLES *******************************/
    if(defined(__DIR__))                                                                define('DIRPATH', __DIR__);                                         else            define('DIRPATH',dirname(__FILE__));
    if(isset($_SERVER['HTTP_REFERER']))                                                 define('REF',$_SERVER['HTTP_REFERER']);                             else            define('REF',false);
    if(isset($_SERVER['DOCUMENT_ROOT']))                                                define('DOCROOT', $_SERVER['DOCUMENT_ROOT']);                       else            define('DOCROOT',false);
    if(isset($_SERVER['SERVER_NAME']))                                                  define('SERVERNAME', $_SERVER['SERVER_NAME']);                      else            define('SERVERNAME',false);
    if(isset($_SERVER['HTTP_HOST']))                                                    define('SERVERHOST', $_SERVER['HTTP_HOST']);                        else            define('SERVERHOST',false);
    if(isset($_SERVER['REMOTE_ADDR']))                                                  define('SERVERREMOTE', $_SERVER['REMOTE_ADDR']);                    else            define('SERVERREMOTE',false);
    if(isset($_SERVER['HTTP_USER_AGENT']))                                              define('USERAGENT', $_SERVER['HTTP_USER_AGENT']);                   else            define('USERAGENT',false);
    if(ini_get('max_file_uploads')!==false&&ini_get('max_file_uploads')!=null)          define('SYS_MAX_UPLOADS',ini_get('max_file_uploads'));              else            define('SYS_MAX_UPLOADS',false);
    if(ini_get('upload_max_filesize')!==false&&ini_get('upload_max_filesize')!=null)    define('SYS_MAX_FILESIZE',ini_get('upload_max_filesize'));          else            define('SYS_MAX_FILESIZE',false);
    if(ini_get('post_max_size')!==false&&ini_get('post_max_size')!=null)                define('SYS_MAX_POST_SIZE',ini_get('post_max_size'));               else            define('SYS_MAX_POST_SIZE',false);
    if(ini_get('max_input_time')!==false&&ini_get('max_input_time')!=null)              define('SYS_MAX_INPUT_TIME',ini_get('max_input_time'));             else            define('SYS_MAX_INPUT_TIME',false);
    if(ini_get('max_input_vars')!==false&&ini_get('max_input_vars')!=null)              define('SYS_MAX_INPUT_VARS',ini_get('max_input_vars'));             else            define('SYS_MAX_INPUT_VARS',false);

/***************************** PASSWORD PROTECT: ******************************/
    //Should we validate user name?
    define('USE_USERNAME', true);
    //Cookie expire after:
    define('TIMEOUT_MINUTES', 30);

/**************************** TOCKENIZE FUNCTIONS *****************************/
    if (!function_exists('gettoken')) { 
        function gettoken() {
            // only create new ID for browser - to support multi tab browsers!.
            if(!isset($_SESSION['user_token'])) $_SESSION['user_token'] = uniqid(); 
        }
    }
    if (!function_exists('checktoken')) { 
        function checktoken($token) {
            if (!isset($_SESSION['user_token'])) { 
                    die ("die2");             
            } else { 
                if ($token!=md5($_SESSION['user_token'])) {  
                    die ("die3"); 
                } 
            }								
        }
    }
    if (!function_exists('gettokenfield')) { 
        function gettokenfield() {
            return ("<input type='hidden' name='get' id='get' value='"
                    .md5($_SESSION['user_token'])."' />"
            );
        }
    }
    if (!function_exists('destroytoken')) { 
        function destroytoken() {
            unset ($_SESSION['user_token']);
        }
    }
    
/***************************** For debugging **********************************/    
    function debug_ini_settings() {
        echo 'max_execution_time :  '.ini_get('max_execution_time') ."\n";
        echo 'max_input_time :  '.ini_get('max_input_time') ."\n";
        echo 'session.gc_maxlifetime :  '.ini_get('session.gc_maxlifetime') ."\n";
        echo 'session.cookie_lifetime :  '.ini_get('session.cookie_lifetime') ."\n";
        echo 'session.cache_expire :  '.ini_get('session.cache_expire') ."\n";
        echo 'memory_limit :  '.ini_get('memory_limit') ."\n";
        echo 'upload_max_filesize :  '.ini_get('upload_max_filesize') ."\n";
        echo 'post_max_size :  '.ini_get('post_max_size') ."\n";
        echo "\n\n";
        print_r($_POST);
        echo "\n\n";
        print_r($_FILES);
        echo "\n\n";
    }
    
/******************************* GENERAL **************************************/    
//Validate Email address:    
    function check_email_address($email) {
        if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
            return false;
        }
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++) {
            $patt_mail = "/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-]".
                         "[A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,".
                         "63})|(\"[^(\\|\")]{0,62}\"))$/";
                         
            if (!preg_match($patt_mail, $local_array[$i])) {
                return false;
            }
        }
        if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) {
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                return false;
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                $patt_mail2 = "/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}".
                              "[A-Za-z0-9])|([A-Za-z0-9]+))$/";
                if (!preg_match($patt_mail2, $domain_array[$i])) {
                    return false;
                }
            }
        }
        return true;
    }
//Send Mail to rec:
    function sendMailTakeThatStyleTorecipient($to_user, $from_user, $subject, $message_define, $message_user2, $filename, $secret, $files_path, $servermail, $brand, $linkos, $lang) {
        
        $link = explode('?', REF);
        $link = trim($link[0],'/');
        if ( substr(trim($link), -9) == "index.php" ) $link = trim(substr($link, 0, -9),'/');
        
        //Message
        $file_only_name = explode('_', $filename);
        unset($file_only_name[0], $file_only_name[1]);
        $file_only_name = implode('_', $file_only_name);
        
        //Leech:
        $leech_image = "<img src='".$link."/code/lib/mail.php?req=".$secret."' />";
        
        //Advertise banner include:
        $ads = getBanner_name_url( 'rec', $linkos, $link, $lang);
        
        //Parse user message:
        $message_user2 = nl2br ($message_user2);
        
        //Email template include:
        include ("..".DS."email_template".DS."recipient.php");
        
        //Additional headers:
        $header_to = explode('@',$to_user);
        $headers  = "MIME-Version: 1.0" . "\r\n" .
                    "Content-type: text/html; charset=utf-8" . "\r\n" .
                    "From: ".ucfirst($brand)." <".$servermail.">" . "\r\n" .
                    "X-Mailer: PHP/".phpversion();
        
        //Mail it
        if (@mail($to_user, $subject, $message_join, $headers)) { 
            return true;  
        } else { 
            return false;
        }	
    }  
//Send Mail to copy (sender):
    function sendMailTakeThatStyleTocopy($to_users, $from_user, $subject_copy, $message_define_copy, $files, $group, $files_path, $servermail, $brand, $linkos, $lang) {
        //To users string:
        $users_string = "<ul><li>".implode("</li><li>", $to_users)."</li></ul>";
        
        //Prepare link path:
        $link = REF;
        $link = explode('?', $link);
        $link = trim($link[0],'/');
        if (substr(trim($link), -9) == "index.php") $link = trim(substr($link, 0, -9),'/');
        
        //Link file string:
        $link_file = "<ul>";
        foreach ($files as $key => $value) {
            $file_only_name = explode('_', $value[0]);
            unset($file_only_name[0], $file_only_name[1]);
            $file_only_name  = implode('_', $file_only_name);
            $link_file 		.= "<li><a href='".$link."/?gr=".$group."&copy=1'>".
                               $file_only_name." - Size: ".
                               humanFileSize($value[1])."</a></li>"; 
        }
        $link_file .= "</ul>";

        //Advertise banner include:
        $ads = getBanner_name_url( 'sender', $linkos, $link, $lang);
        
        //Email template include:
        include ("..".DS."email_template".DS."sender_copy.php");
        
        //Additional headers			
        $header_to 	= explode('@', $from_user);
        $headers  	= "MIME-Version: 1.0"."\r\n".
                            "Content-type: text/html; charset=utf-8" . "\r\n" .
                            "From: ".ucfirst($brand)." <".$servermail.">" . "\r\n" .
                            "X-Mailer: PHP/".phpversion();
        //Mail it
        if (@mail($from_user, $subject_copy, $message_join, $headers)) { 
            return true;  
        } else { 
            return false; 
        }	
    }    
//Send Mail to sender - aproval Download:    
    function sendMailTakeThatNotificationApprove($to_user, $from_user, $filename, $servermail, $brand, $confirm, $linkos, $lang) {
        //Set subject:
        $subject  = $lang[$lang['set']]['type_file_downloaded_notify_subject'];
                        
        //File name:
        $filename = explode('_', $filename);
        unset($filename[0], $filename[1]);
        $filename = implode('_', $filename);
        
        //Link:
        $link = 'http'.(!empty($_SERVER['HTTPS']) ? 's' : '').'://'.
        $_SERVER['SERVER_NAME'].
        substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/'))
        .'/';
            
        //Advertise banner include:
        $ads = getBanner_name_url( 'sender', $linkos, $link, $lang);
        
        //Email template include:
        include ("code".DS."email_template".DS."sender_notify_download.php");

        // Additional headers			
        $header_to = explode('@', $to_user);
        $headers  = 'MIME-Version: 1.0' . "\r\n" .
                    'Content-type: text/html; charset=utf-8' . "\r\n" .
                    'From: '.ucfirst($brand).' <'.$servermail.'>' . "\r\n" .
                    'X-Mailer: PHP/'.phpversion();
        // Mail it
        if (@mail($to_user, $subject, $message_join, $headers)) { 
            return true;  
        } else { 
            return false; 
        }	
    }
//Send Mail to sender - aproval Read:
    function sendMailTakeThatNotificationApproveRead($to_user, $from_user, $filename, $servermail, $brand, $confirm, $linkos, $lang) {
        //Set subject:
        $subject  = $lang[$lang['set']]['type_email_read_notify_subject'];
                        
        //File name:
        $filename = explode('_', $filename);
        unset($filename[0], $filename[1]);
        $filename = implode('_', $filename);
        
        //Link:
        $link = 'http'.(!empty($_SERVER['HTTPS']) ? 's' : '').'://'.
        $_SERVER['SERVER_NAME'].
        substr($_SERVER['PHP_SELF'], 0, strrpos_count($_SERVER['PHP_SELF'], '/', 3)).'/';

        //Advertise banner include:
        $ads = getBanner_name_url( 'sender', $linkos, $link, $lang);
        
        //Email template include:
        include ("..".DS."email_template".DS."sender_notify_read.php");

        // Additional headers			
        $header_to = explode('@', $to_user);
        $headers  = 'MIME-Version: 1.0' . "\r\n" .
                    'Content-type: text/html; charset=utf-8' . "\r\n" .
                    'From: '.ucfirst($brand).' <'.$servermail.'>' . "\r\n" .
                    'X-Mailer: PHP/'.phpversion();
        // Mail it
        if (@mail($to_user, $subject, $message_join, $headers)) { 
            return true;  
        } else { 
            return false; 
        }	
    }
//URL - trim positions:
    function strrpos_count($haystack, $needle, $count) {
        if($count <= 0)
            return false;
        $len = strlen($haystack);
        $pos = $len;
        for($i = 0; $i < $count && $pos; $i++)
            $pos = strrpos($haystack, $needle, $pos - $len - 1);
        return $pos;
    }
//Return banner ellement for emails:
    function getBanner_name_url($type, $linkos, $link, $lang) {
    
        //Advertise Settings:
        $sqlstatus = "SELECT * FROM `ads_types_use` WHERE `id`='1'";
        $rs_result = mysqli_query($linkos, $sqlstatus) or die ( $lang[$lang['set']]['type_db_error']."1782" ); 
            while ($idr = mysqli_fetch_array($rs_result)) {
                $adsense_mainpage   = $idr['adsense_mainpage'];
                $banner_mainpage    = $idr['banner_mainpage'];
                $adsense_downpage   = $idr['adsense_downpage'];
                $banner_downpage    = $idr['banner_downpage'];
                $guests             = $idr['guests'];
                $users              = $idr['users'];
                $email_sender       = $idr['email_sender'];
                $email_rec          = $idr['email_rec'];
                $count_clicks       = $idr['count_clicks'];
                $count_sent         = $idr['count_sent'];
                $adsense_code       = $idr['adsense_code'];
            }     
        
       //Make sure we need to include banners in emails:
       if ($email_sender == '0' && $email_rec == '0') return false;
       
        $banners_arr = array();
        
        //Prepare query according to settings:
        if ( $type == 'rec' && $email_rec == '1')
            $sqlstatus = "SELECT * FROM `ads_manager` WHERE `active` = '1' AND `email_rec` = '1' ";
        elseif  ( $type == 'sender' && $email_sender == '1')
            $sqlstatus = "SELECT * FROM `ads_manager` WHERE `active` = '1' AND `email_sender` = '1' ";
        else return false;
        
        //Get available banners:
        $rs_result = mysqli_query( $linkos, $sqlstatus ) or die ( $lang[$lang['set']]['type_db_error']."165" ); 
        $id_count = 0;
            while ( $idr = mysqli_fetch_array( $rs_result ) ) {
                $banners_arr[$id_count]['id']                = $idr['id'];
                $banners_arr[$id_count]['banner_filename']   = $idr['banner_filename'];
                $banners_arr[$id_count]['banner_altname']    = $idr['banner_altname'];
                $banners_arr[$id_count]['url']               = $idr['url'];
                $banners_arr[$id_count]['active']            = $idr['active'];
                $banners_arr[$id_count]['guest']             = $idr['guest'];
                $banners_arr[$id_count]['user']              = $idr['user'];
                $banners_arr[$id_count]['email_sender']      = $idr['email_sender'];
                $banners_arr[$id_count]['email_rec']         = $idr['email_rec'];
                $banners_arr[$id_count]['mainpage']          = $idr['mainpage'];
                $banners_arr[$id_count]['downpage']          = $idr['downpage'];
                $banners_arr[$id_count]['created']           = $idr['created'];
                $banners_arr[$id_count]['counter_clicks']    = $idr['counter_clicks'];
                $banners_arr[$id_count]['counter_sent']      = $idr['counter_sent'];
                $id_count++;
            }
        if ( $id_count < 1 ) return false;
        
        //Random choice:
        $generate_random_key = rand(0,count($banners_arr)-1);
        
        //Log count if needed:
        if ( $count_sent == '1' ) {
            $banner_code =  mysqli_real_escape_string($linkos, $banners_arr[$generate_random_key]['id']);
            $sql229 = "UPDATE `ads_manager` SET `counter_sent` = `counter_sent` + 1 WHERE `id`='".$banner_code."'"; 
            $rs_result229 = mysqli_query($linkos, $sql229) or die ($lang[$lang['set']]['type_db_error']."2148"); 
        }
        
        //Build html:
            $type = explode('.',$banners_arr[$generate_random_key]['banner_filename']);
            $type = strtolower($type[count($type)-1]);
            $href = $banners_arr[$generate_random_key]['url'];
            if ($href == "") $href = '#'; 
            
            //If Flash (include with iframe) Set overlay:
            if ( $type == "swf" ) {
                
                $ads_html = "<tr>
                                <td colspan='2' style='background-color:transparent; text-align:center; padding:20px;'>
                                    <div class='wrapper_banner_click'>
                                        <a class='force_flash' rel='nofollow' href='".$href."' target='_blank' style='border:0;' alt='".$banners_arr[$generate_random_key]['banner_altname']."' title='".$banners_arr[$generate_random_key]['banner_altname']."'></a>
                                        <iframe class='banner_style_mainpage effect6' frameborder='0' scrolling='no' src='".$link."/banners/".$banners_arr[$generate_random_key]['banner_filename']."'></iframe>
                                    </div>
                                </td>
                            </tr>";
                
            } else {
                
            //If Image (jpg,png,gif):
                $ads_html = "<tr>
                                <td colspan='2' style='background-color:transparent; text-align:center; padding:20px;' >
                                    <a rel='nofollow' href='".$href."' target='_blank' style='border:0;'>
                                        <img class='banner_style_mainpage' src='".$link."/banners/".$banners_arr[$generate_random_key]['banner_filename']."' alt='".$banners_arr[$generate_random_key]['banner_altname']."' title='".$banners_arr[$generate_random_key]['banner_altname']."' />
                                    </a>
                                </td>
                            </tr>";
            }
        //Return banner selected:
        return array('banner_include' => $ads_html, 'url' => $href);
    }
//Calc Size from bytes convert:
    function humanFileSize($size, $unit = "") {
      if (!is_int($size)) $size = intval($size);
      if( (!$unit && $size >= 1<<30) || $unit == "GB")
        return number_format($size/(1<<30),2)."GB";
      if( (!$unit && $size >= 1<<20) || $unit == "MB")
        return number_format($size/(1<<20),2)."MB";
      if( (!$unit && $size >= 1<<10) || $unit == "KB")
        return number_format($size/(1<<10),2)."KB";
      return number_format($size)." bytes";
    }    
//Create Url From Absolute Path:
    function createUrlFromAbsolutePath($ab_path){

        //Check for matching path to file system: 
        if (strpos(DOCROOT,DS)=== false) { 
            if (DS=='/') { 
                $server_root = str_replace('\\', DS, DOCROOT); 
            } else { 
                $server_root = str_replace('/', DS, DOCROOT); 
            } 
        } else { 
            $server_root = DOCROOT; 
        }  
        if (substr($server_root, -1)!=DS) { 
            $server_root.=DS; 
        }
        
        //Delete unneeded trail of root:
        $files_root = substr($ab_path, strlen($server_root)-1);
        
        //Parse to Url compabillity:
        $files_dir_url = str_replace('\\', '/', SERVERNAME.$files_root);
        
        return ($files_dir_url);

    }
//Serv file:
    function serv_file(){
        $name = 'detect.jpg';
        $fp = fopen($name, 'rb');
        header("Content-Type: image/png");
        header("Content-Length: " . filesize($name));
        fpassthru($fp);
        exit;
    }
//Convert to bytes:
    function return_bytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        switch($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        return $val;
    }
//Validate date:
    function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    } 
//Function: file type groups check:
    function returnStringTypes($group) {
            $fileTypes_string_group = array(
                'Text'		=>'.doc,.docx,.log,.msg,.odt,.pages,.rtf,.tex,.txt,.wpd,.wps',
                'Data'		=>'.csv,.dat,.gbr,.ged,.ibooks,.key,.keychain,.pps,.ppt,.pptx,.sdf,.tar,.tax2012,.vcf,.xml',
                'Audio'		=>'.aif,.iff,.m3u,.m4a,.mid,.mp3,.mpa,.ra,.wav,.wma',
                'Video'		=>'.3g2,.3gp,.asf,.asx,.avi,.flv,.m4v,.mov,.mp4,.mpg,.rm,.srt,.swf,.vob,.wmv',
                'eBook'		=>'.acsm,.aep,.apnx,.ava,.azw,.azw1,.azw3,.azw4,.bkk,.bpnueb,.cbc,.ceb'.
                              ',.dnl,.ebk,.edn,.epub,.etd,.fb2,.html0,.htmlz,.htxt,.htz4,.htz5,.koob,.lit,.lrf,.lrs,.lrx,.mart,.mbp,.mobi,.ncx,.oeb,.opf,.pef,.phl,.pml,.pmlz,.pobi,.prc,.qmk'.
                              ',.rzb,.rzs,.tcr,.tk3,.tpz,.tr,.tr3,.vbk,.webz,.ybk',
                'image3d'	=>'.3dm,.3ds,.max,.obj',
                'Raster'	=>'.bmp,.dds,.gif,.jpg,.jpeg,.png,.psd,.pspimage,.tga,.thm,.tif,.tiff,.yuv',
                'Vector'	=>'.ai,.eps,.ps,.svg',			
                'Camera'	=>'.3fr,.ari,.arw,.bay,.cr2,.crw,.dcr'.
                              ',.dng,.eip,.erf,.fff,.iiq,.k25,.kdc'.
                              ',.mef,.mos,.mrw,.nef,.nrw,.orf,.pef'.
                              ',.raf,.raw,.rw2,.rwl,.rwz,.sr2,.srf'.
                              ',.srw,.x3f',
                'Layout'	 =>'.indd,.pct,.pdf',	
                'Spreadsheet'=>'.xlr,.xls,.xlsx',		
                'Database'	 =>'.accdb,.db,.dbf,.mdb,.pdb,.sql',		
                'Executable' =>'.apk,.app,.bat,.cgi,.com,.exe'.
                               ',.gadget,.jar,.pif,.vb,.wsf',	
                'Game'		=>'.dem,.gam,.nes,.rom,.sav',	
                'CAD'		=>'.dwg,.dxf',	
                'GIS'		=>'.gpx,.kml,.kmz',
                'Web'		=>'.asp,.aspx,.cer,.cfm,.csr,.css'.
                              ',.htm,.html,.js,.jsp,.php,.rss,.xhtml',	
                'Plugin'	=>'.crx,.plugin',
                'Font'		=>'.fnt,.fon,.otf,.ttf',
                'System'	=>'.cab,.cpl,.cur,.deskthemepack,.dll'.
                              ',.dmp,.drv,.icns,.ico,.lnk,.sys',
                'Settings'	=>'.cfg,.ini,.prf',		
                'Encoded'	=>'.hqx,.mim,.uue',	
                'Compressed'=>'.7z,.cbr,.deb,.gz,.pkg,.rar,.rpm'.
                              ',.sitx,.tar,.gz,.zip,.zipx',	
                'Disk'		=>'.bin,.cue,.dmg,.iso,.mdf,.toast,.vcd',	
                'Developer'	=>'.c,.class,.cpp,.cs,.dtd,.fla,.h'.
                              ',.java,.lua,.m,.pl,.py,.sh,.sln'.
                              ',.vcxproj,.xcodeproj',
                'Backup'	=>'.bak,.tmp',
                'Misc'		=>'.crdownload,.ics,.msi,.part,.torrent'
            );

            if (array_key_exists($group, $fileTypes_string_group)) { 
                return $fileTypes_string_group[$group]; 
            } else { 
                return ""; 
            }
    }    
//Count Fast sofar sent:
    function soFarFilesCount($linkos) {
        $sqlstatus  = "SELECT `counter_files` AS count FROM `files_mileage` WHERE id='1' ";
        $rs_result  = mysqli_query($linkos, $sqlstatus) or die(); 
        $num        = mysqli_fetch_array($rs_result);
        return $num["count"];          
    }
//Size Fast sofar sent:
    function soFarFilesSize($linkos) {
        $sqlstatus  = "SELECT `counter_size` AS size FROM `files_mileage` WHERE id='1' ";
        $rs_result  = mysqli_query($linkos, $sqlstatus) or die(); 
        $num        = mysqli_fetch_array($rs_result);
        return $num["size"];          
    }
