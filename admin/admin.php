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
/**************************** REQUIRD CORE FILES ******************************/
    error_reporting(0);
    @ini_set('display_errors', 'off');
    session_start();
    define('DS', DIRECTORY_SEPARATOR);
       
    //include lang:
    require_once( "lang/lang_admin.php" );
    
    //include functions lib:
    require("..".DS."code".DS."lib".DS."func.php");
    
    //check / set page token:
    gettoken();
    $token = md5($_SESSION['user_token']);
    
    //connect to DB:
    require("..".DS."code".DS."lib".DS."conndb.php");
    
    //check and act - passwoerd required:
    require("password_protect.php");

/****************************   ADMIN SETTINGS   ******************************/

    $sqlstatus = "SELECT * FROM `".$table1."` WHERE `id`='1'";
    $rs_result = mysqli_query($linkos, $sqlstatus) or die ($lang[$lang['set']]['type_db_error']."97861243"); 
    while ( $idr = mysqli_fetch_array($rs_result) ) {
        $brand          = $idr['brand_name'];
        $accept_types   = $idr['accept_types'];
        $maxfiles       = $idr['maxfiles'];
        $maxrecipients  = $idr['maxrecipients'];
        $files_path     = $idr['files_folder'];
        $servermail     = $idr['server_mail'];
        $themeUse       = $idr['theme'];
    }

/****************************  FILE TYPES ARRAY  ******************************/

    $fileTypes = array(
         'Text'       =>array('.doc','.docx','.log','.msg','.odt','.pages','.rtf','.tex','.txt','.wpd','.wps')
        ,'Data'       =>array('.csv','.dat','.gbr','.ged','.ibooks','.key','.keychain','.pps','.ppt','.pptx','.sdf','.tar','.tax2012','.vcf','.xml')
        ,'Audio'      =>array('.aif','.iff','.m3u','.m4a','.mid','.mp3','.mpa','.ra','.wav','.wma')
        ,'Video'      =>array('.3g2','.3gp','.asf','.asx','.avi','.flv','.m4v','.mov','.mp4','.mpg','.rm','.srt','.swf','.vob','.wmv')
        ,'eBook'      =>array('.acsm','.aep','.apnx','.ava','.azw','.azw1','.azw3','.azw4','.bkk','.bpnueb','.cbc','.ceb','.dnl','.ebk','.edn','.epub','.etd','.fb2','.html0','.htmlz','.htxt',
                             '.htz4','.htz5','.koob','.lit','.lrf','.lrs','.lrx','.mart','.mbp','.mobi','.ncx','.oeb','.opf','.pef','.phl','.pml','.pmlz','.pobi','.prc','.qmk','.rzb','.rzs',
                             '.tcr','.tk3','.tpz','.tr','.tr3','.vbk','.webz','.ybk')
        ,'image3d'    =>array('.3dm','.3ds','.max','.obj')
        ,'Raster'     =>array('.bmp','.dds','.gif','.jpg','.png','.psd','.pspimage','.tga','.thm','.tif','.tiff','.yuv','jpeg')
        ,'Vector'     =>array('.ai','.eps','.ps','.svg')		
        ,'Camera'     =>array('.3fr','.ari','.arw','.bay','.cr2','.crw','.dcr','.dng','.eip','.erf','.fff','.iiq','.k25','.kdc','.mef','.mos',
                             '.mrw','.nef','.nrw','.orf','.pef','.raf','.raw','.rw2','.rwl','.rwz','.sr2','.srf','.srw','.x3f')
        ,'Layout'     =>array('.indd','.pct','.pdf')
        ,'Spreadsheet'=>array('.xlr','.xls','.xlsx')
        ,'Database'   =>array('.accdb','.db','.dbf','.mdb','.pdb','.sql')
        ,'Executable' =>array('.apk','.app','.bat','.cgi','.com','.exe','.gadget','.jar','.pif','.vb','.wsf')
        ,'Game'       =>array('.dem','.gam','.nes','.rom','.sav')
        ,'CAD'        =>array('.dwg','.dxf')
        ,'GIS'        =>array('.gpx','.kml','.kmz')
        ,'Web'        =>array('.asp','.aspx','.cer','.cfm','.csr','.css','.htm','.html','.js','.jsp','.php','.rss','.xhtml')
        ,'Plugin'     =>array('.crx','.plugin')
        ,'Font'       =>array('.fnt','.fon','.otf','.ttf')
        ,'System'     =>array('.cab','.cpl','.cur','.deskthemepack','.dll','.dmp','.drv','.icns','.ico','.lnk','.sys')
        ,'Settings'   =>array('.cfg','.ini','.prf')
        ,'Encoded'    =>array('.hqx','.mim','.uue')
        ,'Compressed' =>array('.7z','.cbr','.deb','.gz','.pkg','.rar','.rpm','.sitx','.tar','.gz','.zip','.zipx')
        ,'Disk'       =>array('.bin','.cue','.dmg','.iso','.mdf','.toast','.vcd')
        ,'Developer'  =>array('.c','.class','.cpp','.cs','.dtd','.fla','.h','.java','.lua','.m','.pl','.py','.sh','.sln','.vcxproj','.xcodeproj')
        ,'Backup'     =>array('.bak','.tmp')
        ,'Misc'       =>array('.crdownload','.ics','.msi','.part','.torrent')
    );
    
?>
<!DOCTYPE html>
<html lang='en' xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <!-- Page Meta -->
    <meta http-equiv="Pragma" CONTENT="no-cache" />
    <meta http-equiv="Expires" CONTENT="-1">
    <meta http-equiv="X-UA-Compatible" content="chrome=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <title><?php echo $brand.$lang[$lang['set']]['type_title_join_to_brand']; ?></title>
    
    <!-- Import CSS -->
    <link rel="stylesheet" href="../js/dist/jquery.jqplot.css" type="text/css" />        
    <link href='http://fonts.googleapis.com/css?family=Prosto+One' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="css/admin.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="js/jqueryui/jquery-ui.structure.min.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="js/jqueryui/jquery-ui.theme.min.css" type="text/css" media="screen" />
    <!-- Import JS -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="../js/jquery.browser.min.js"></script>
    <script type="text/javascript"> 
        //typography (edit in lang.php):
        <?php include_once('lang/lang_to_js_admin.php'); ?>  
    </script>
    <script type="text/javascript" src="js/parseUrl.js"></script>	
    <script type="text/javascript" src="js/script2.js"></script>
    <script type="text/javascript" src="js/jqueryui/jquery-ui.min.js"></script>
    <!--<script type="text/javascript" src="js/jqueryui/timepicker.js"></script>
    <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../js/dist/excanvas.min.js"></script><![endif]-->
    <script type="text/javascript" src="../js/dist/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="../js/dist/plugins/jqplot.pieRenderer.min.js"></script>
    <script type="text/javascript" src="../js/dist/plugins/jqplot.canvasTextRenderer.min.js"></script>
    <script type="text/javascript" src="../js/dist/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
    <script type="text/javascript" src="../js/dist/plugins/jqplot.barRenderer.min.js"></script>
    <script type="text/javascript" src="../js/dist/plugins/jqplot.categoryAxisRenderer.min.js"></script>
    <script type="text/javascript" src="../js/dist/plugins/jqplot.pointLabels.min.js"></script>     
	
<script type="text/javascript">
$(document).ready(function(){

    var fileTypes = {
         Text:       ['.doc','.docx','.log','.msg','.odt','.pages','.rtf','.tex','.txt','.wpd','.wps']
        ,Data:       ['.csv','.dat','.gbr','.ged','.ibooks','.key','.keychain','.pps','.ppt','.pptx','.sdf','.tar','.tax2012','.vcf','.xml']
        ,Audio:      ['.aif','.iff','.m3u','.m4a','.mid','.mp3','.mpa','.ra','.wav','.wma']
        ,Video:      ['.3g2','.3gp','.asf','.asx','.avi','.flv','.m4v','.mov','.mp4','.mpg','.rm','.srt','.swf','.vob','.wmv']
        ,eBook:      ['.acsm','.aep','.apnx','.ava','.azw','.azw1','.azw3','.azw4','.bkk','.bpnueb','.cbc','.ceb','.dnl','.ebk','.edn','.epub','.etd','.fb2','.html0','.htmlz','.htxt','.htz4','.htz5','.koob','.lit','.lrf','.lrs','.lrx','.mart','.mbp','.mobi','.ncx','.oeb','.opf','.pef','.phl','.pml','.pmlz','.pobi','.prc','.qmk','.rzb','.rzs','.tcr','.tk3','.tpz','.tr','.tr3','.vbk','.webz','.ybk']
        ,image3d:    ['.3dm','.3ds','.max','.obj']
        ,Raster:     ['.bmp','.dds','.gif','.jpg','.jpeg','.png','.psd','.pspimage','.tga','.thm','.tif','.tiff','.yuv']
        ,Vector:     ['.ai','.eps','.ps','.svg']
        ,Camera:     ['.3fr','.ari','.arw','.bay','.cr2','.crw','.dcr','.dng','.eip','.erf','.fff','.iiq','.k25','.kdc','.mef','.mos','.mrw','.nef','.nrw','.orf','.pef','.raf','.raw','.rw2','.rwl','.rwz','.sr2','.srf','.srw','.x3f']
        ,Layout:     ['.indd','.pct','.pdf']
        ,Spreadsheet:['.xlr','.xls','.xlsx']
        ,Database:   ['.accdb','.db','.dbf','.mdb','.pdb','.sql']
        ,Executable: ['.apk','.app','.bat','.cgi','.com','.exe','.gadget','.jar','.pif','.vb','.wsf']
        ,Game:       ['.dem','.gam','.nes','.rom','.sav']
        ,CAD:        ['.dwg','.dxf']
        ,GIS:        ['.gpx','.kml','.kmz']
        ,Web:        ['.asp','.aspx','.cer','.cfm','.csr','.css','.htm','.html','.js','.jsp','.php','.rss','.xhtml']
        ,Plugin:     ['.crx','.plugin']
        ,Font:       ['.fnt','.fon','.otf','.ttf']
        ,System:     ['.cab','.cpl','.cur','.deskthemepack','.dll','.dmp','.drv','.icns','.ico','.lnk','.sys']
        ,Settings:   ['.cfg','.ini','.prf']
        ,Encoded:    ['.hqx','.mim','.uue']
        ,Compressed: ['.7z','.cbr','.deb','.gz','.pkg','.rar','.rpm','.sitx','.tar','.gz','.zip','.zipx']
        ,Disk:       ['.bin','.cue','.dmg','.iso','.mdf','.toast','.vcd']
        ,Developer:  ['.c','.class','.cpp','.cs','.dtd','.fla','.h','.java','.lua','.m','.pl','.py','.sh','.sln','.vcxproj','.xcodeproj']
        ,Backup:     ['.bak','.tmp']
        ,Misc:       ['.crdownload','.ics','.msi','.part','.torrent']
    };

    //set current page:
    var page_load_first = <?php if(isset($_GET['pager'])&&is_numeric($_GET['pager'])) echo $_GET['pager']; else echo 1; ?>;
    switch(page_load_first){
        case 1: $('#page_general').css({'z-index':'4'}); break;
        case 2: $('#page_logfiles').css({'z-index':'4'}); break;
        case 3: $('#page_searchfile').css({'z-index':'4'}); break;
        case 4: $('#page_exclude').css({'z-index':'4'}); break;
        case 5: $('#page_blocked').css({'z-index':'4'}); break;
        case 6: $('#page_storage').css({'z-index':'4'}); break;
        case 7: $('#page_users').css({'z-index':'4'}); break;
        case 8: $('#page_advertise').css({'z-index':'4'}); break;
        case 9: $('#page_stat').css({'z-index':'4'}); break;
        default: $('#page_general').css({'z-index':'4'});
    }
    
    //Set Date pickers:
    $('#search_start_date').datepicker({ dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true });
    $('#search_end_date').datepicker({ dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true });

});

</script>
<!--[if IE 9]>
  <style type="text/css">
    div {
       filter: none;
    }
  </style>
<![endif]-->	
</head>
<body>
<?php
if (isset($uname)) {
        if($uname!="nouser") {
            echo gettokenfield();
?>
<div class='outerConatainer'  style="" >
<table class='table_remove' border='0'>
    <tr>
        <td colspan='3'>
            <div class='logoTakeThat'>
                <img src='../img/takethatlogo.png' />
            </div>
            <div class='logoBrand'>
                <span class='Brand' id='Brand'><?php echo $brand; ?></span>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan='3'>
            <div class='border_div'></div>
        </td>
    </tr>
    <tr>
        <td colspan='3'>
            <p class='admin_head1'><?php echo $lang[$lang['set']]['type_admin_page_main_title'];  ?></p>
        </td>
    </tr>
    <tr>
        <td colspan='3' valign='top'>
        
        <!-- Admin Panel Tabs -->
            <div class='tabs_admin'>
                <?php include("tabs/tabs_menu.php"); ?>
            </div>
            <div class='tab_content_con' style='position:relative;'>
                
                <div class='tab_page' id='page_general' tabNum='1' >
                    <?php include("tabs/general.php"); ?>
                </div>
                
                <div class='tab_page' id='page_users' tabNum='7' style='overflow-y:scroll;'>
                    <?php include("tabs/users.php"); ?>
                </div>            
                            
                <div class='tab_page' id='page_logfiles' tabNum='2' >
                    <?php include("tabs/log.php"); ?>
                </div>

                <div class='tab_page' id='page_searchfile' tabNum='3' >
                    <?php include("tabs/search.php"); ?>
                </div>

                <div class='tab_page' id='page_exclude' tabNum='4' >
                    <?php include("tabs/exclude.php"); ?>
                </div>

                <div class='tab_page' id='page_blocked' tabNum='5' >
                    <?php include("tabs/blocked.php"); ?>
                </div>

                <div class='tab_page' id='page_storage' tabNum='6' >
                    <?php include("tabs/storage.php"); ?>
                </div>

                <div class='tab_page' id='page_advertise' tabNum='8' >
                    <?php include("tabs/advertise.php"); ?>
                </div>

                <div class='tab_page' id='page_stat' tabNum='9' >
                    <?php include("tabs/stats.php"); ?>
                </div>            
                
                <!-- updater for advertise: -->
                <?php include("tabs/update_overlay.php"); ?>  
                
        <!--END Admin Panel Tabs -->
        </td>
    </tr>
    <tr>
        <td colspan='3' class='button_td'>
            <div class='button_td'>
                <input class='css3button' type='button' id='but1out' value='<?php echo $lang[$lang['set']]['type_button_logout_text'];  ?>'  style='line-height:30px; margin-top:8px; height:auto;' />
            </div>
        </td>
    </tr>
</table>
</div>
</body>
</html>
<?php
            exit;
        } else {
            //REQUIRE LOGIN:
            require('login_form.php');
            exit;			
        }
    } else { 
            //REQUIRE LOGIN:
            require('login_form.php');
            exit;
    }
//Close DB conn
mysqli_close($linkos);	

