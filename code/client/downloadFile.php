<?php
?>
<!DOCTYPE html>
<html lang='en' xmlns='http://www.w3.org/1999/xhtml'>
<head>
    <meta http-equiv="Pragma" CONTENT="no-cache" />
    <meta http-equiv="Expires" CONTENT="-1" />
    <meta http-equiv="X-UA-Compatible" content="chrome=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $brand.$lang[$lang['set']]['type_title_join_to_brand']; ?></title>
    <!-- INCLUDE - JS -->
    <script language="javascript" src="https://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script language="javascript" src="js/jquery.browser.min.js" type="text/javascript"></script>	
    <script language="javascript" src="js/mainjs.js" type="text/javascript"></script>
    <!-- INCLUDE STYLE-SHEETS -->
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/buttons.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/<?php echo $themeUse; ?>.css" type="text/css" media="screen" />
    <?php
    //Get advertise settings:
    include( 'advertise_includes.php' );
    if ( $guests === '1' ) {
        if ( $adsense_downpage == '1' ) {
            echo $adsense_head;
        }
    }
    ?>
    <!--[if IE 9]>
    <style type="text/css">  
        div { filter: none; }
        input[type="text"],
        input[type="password"],
        .css-textarea{ background-color: #FAFAFA !important; filter: none; }
        .css3button,.css4button { filter: none; }
    </style>
    <![endif]-->
</head>
<body>
<?php include_once("analyticstracking.php") ?>
<?php
    //Add Banner / Code if needed:
    if ( $guests === '1' ) {
        if ( $adsense_mainpage == '1' ) {
            //Include adsense or any other script / code:
            include('ads_parse_code.php');
        } else {
            //Include banners:
            include('ads_parse_banner.php');
        }
    }
?>
<form method="post" action="code/client/filesend.php" enctype="multipart/form-data" id='takethatform'>
<input type='hidden' name='modeEQ' id='modeEQ' value='<?php echo $users_mode; ?>' />
<?php echo gettokenfield(); ?>
<div class="outerContainer"  grab="top2-" >
	<div class="upperContent" >
					<div class="upperlogo" >
						<a href="index.php"><img src="img/ladybug-logo.png"></a>
					</div>
					<h2>Someone has shared <br/>this file with you:</h2>
	</div>
<table border='0'>
    <tr>
        <td colspan='3'><div class='border_div'></div></td>
    </tr>
<?php
    //Download pannel
    //Prepare link:
    if ( isset($_GET['get']) ) {

        $secret_file = mysqli_real_escape_string($linkos,$_GET['get']);
        $sqlstatus1  = "SELECT * FROM `".$table4."` WHERE `secret`='".$secret_file."'";
        $rs_result1  = mysqli_query($linkos, $sqlstatus1) 
            or die ( $lang[$lang['set']]['type_general_error'] ); 
            while ( $idr1 = mysqli_fetch_array($rs_result1) ) {
                $id_file            = $idr1['id'];
                $file_name          = $idr1['file_name'];
                $notify_to 	    = $idr1['notify_to'];
                $do_notify 	    = $idr1['do_notify'];
                $status_notify 	    = $idr1['status_notify'];
                $status_first_down  = $idr1['status_first_down'];
                $when_notify 	    = $idr1['when_notify'];
                $who_down 	    = $idr1['who'];
            }
        if ( isset($id_file) ) {

            //File name:
            $file_only_name = explode('_', $file_name);
            unset($file_only_name[0], $file_only_name[1]);
            $file_only_name = implode('_', $file_only_name);

            //Files path:
            $files_path1 = createUrlFromAbsolutePath($files_path);

            //Link to file:
            $link_file = "<a class='link_tofile' href='http://".
                         $files_path1.$file_name."' download='".
                         $file_name."' ><img src='img/glyphicons".
                         "/png/1down.png' class='down111' />".
                         $file_only_name." - ".$lang[$lang['set']]['type_file_size_download']." ".
                         humanFileSize(filesize($files_path.$file_name)).
                         "</a>"; 

            //Output
            echo "<tr><td colspan='3'>";
            echo $link_file;				
            echo "</td></tr>";
            echo "<tr><td colspan='3'><div class='border_div'></div>";
            echo "</td></tr>";
            echo "<tr><td colspan='3' style='text-align:center; height:32px;'>".
                 "<a class='button facebook' href='index.php' id='but1home' style='cursor:pointer; width:70%;'>".$lang[$lang['set']]['type_home_button']."</a>".
                 "</td></tr>";

            //Send notification if its requested and mark as notified:
            if ( $do_notify ) {
                if ( !$status_notify ) {
                    if ( !sendMailTakeThatNotificationApprove($notify_to,
                        $who_down,$file_name,$servermail,$brand,
                        $secret_file, $linkos, $lang
                    )) {  } else {

                        //Log notify deliv:
                        $sql1 = "UPDATE `".$table10."` SET `counter_notify_deliv`=(`counter_notify_deliv` + 1), `last_notify_deliv`=NOW() WHERE `id`='1'";
                        if ( !mysqli_real_query($linkos, $sql1) ) { }

                        //Update confirmation sent:
                        $sqlstat = "UPDATE `".$table4."` SET ".
                                   "`status_notify`='1',`when_notify`=NOW() ".
                                   "WHERE `id`='".$id_file."'";
                        if ( !mysqli_real_query($linkos, $sqlstat) ) die();
                    }
                }
            }

            //Log deliver and update first download:
            if ( !$status_first_down ) {
                //First Download:
                $sql1= "UPDATE `".$table4."` SET `status_first_down`='1' WHERE `id`='".$id_file."'";
                if(!mysqli_real_query($linkos, $sql1)) die();
                //Log stat:
                $sql2= "UPDATE `".$table10."` SET `counter_deliv`=(`counter_deliv` + 1), `last_deliv`=NOW() WHERE `id`='1'";
                if(!mysqli_real_query($linkos, $sql2)) { }
            }

        } else {

            //No file:
            echo "<tr><td colspan='3'>";
            echo "<p class='no_file'><img src='img/glyphicons/png/1error.".
                 "png' class='down111' />".$lang[$lang['set']]['type_file_downloaded_not_ava']."</p>";			
            echo "</td></tr>";
            echo "<tr><td colspan='3'><div class='border_div'></div></td></tr>";
            echo "<tr><td colspan='3' style='text-align:center; height:32px;'>".
                 "<a class='button facebook' href='index.php' id='but1home' style='cursor:pointer; width:70%;'>".$lang[$lang['set']]['type_home_button']."</a>".
                 "</td></tr>";		
        }
    } elseif ( isset($_GET['gr']) ) { 
        //Sender view:
        $group_file = mysqli_real_escape_string($linkos,$_GET['gr']);
        $sqlstatus2 = "SELECT `id`,`file_size`,`filename` FROM `".$table2."` WHERE `group`='".$group_file."' GROUP BY `filename`";
        $rs_result2 = mysqli_query($linkos, $sqlstatus2) 
            or 
                die ( $lang['en']['type_db_error']."87632149" ); 
        while ( $idr2 = mysqli_fetch_array($rs_result2) ) {
            $id[]        = $idr2['id'];
            $file_name[] = $idr2['filename'];
            $file_size[] = $idr2['file_size'];
        }
        //Files path:
        $files_path1 = createUrlFromAbsolutePath($files_path);

        if ( isset($id) ) {	
            $fileList = '<ul class="links_group">';
            foreach ( $file_name as $key => $value ) {
                $file_only_name = explode('_', $value);
                unset($file_only_name[0], $file_only_name[1]);
                $file_only_name = implode('_',$file_only_name);				
                $fileList .= "<li><a href='http://".$files_path1.$value.
                             "' download='".$value."' >".$file_only_name.
                             " - Size: ".humanFileSize($file_size[$key]).
                             "</a></li>";	
            }
            $fileList .= '</ul>';

            echo "<tr><td colspan='3'>";
            echo $fileList;				
            echo "</td></tr>";
            echo "<tr><td colspan='3'><div class='border_div'></div></td></tr>";
            echo "<tr><td colspan='3' style='text-align:center; height:32px;'>".
                 "<a class='button facebook' href='index.php' id='but1home' style='cursor:pointer; width:70%;'>".
                 $lang[$lang['set']]['type_home_button']."</a></td></tr>";
            
        } else {
            
            echo "<tr><td colspan='3'>";
            echo "<p class='no_file'><img src='img/glyphicons/png/1erro".
                 "r.png' width='18px' height='18px' />".$lang[$lang['set']]['type_file_downloaded_not_ava']."</p>";			
            echo "</td></tr>";
            echo "<tr><td colspan='3'><div class='border_div'></div>".
                 "</td></tr>";
            echo "<tr><td colspan='3' style='text-align:center; height:32px;'>".
                 "<a class='button facebook' href='index.php' id='but1home' style='cursor:pointer; width:70%;'".$lang[$lang['set']]['type_home_button']."</a>".
                 "</td></tr>";					
    }
} else {
    echo "<tr><td colspan='3'>";
    echo "<p class='no_file'><img src='img/glyphicons/png/1error.png' ". 
         "width='18px' height='18px' />".$lang[$lang['set']]['type_file_downloaded_not_ava']."</p>";			
    echo "</td></tr>";		
    echo "<tr><td colspan='3'><div class='border_div'></div></td></tr>";
    echo "<tr><td colspan='3' style='text-align:center; height:32px;'>".
         "<a class='button facebook' href='index.php' id='but1home' style='cursor:pointer; width:70%;'>".$lang[$lang['set']]['type_home_button']."</a>".
         "</td></tr>";
}
?>

</table>
</div>
</form>
</body>
</html>