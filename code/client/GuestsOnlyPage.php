<?php

    //Get user settings: 
    $sqlstatus = "SELECT * FROM `".$table7."` WHERE `id`='1'";
    $rs_result = mysqli_query($linkos, $sqlstatus) 
        or 
            die ( $lang[$lang['set']]['type_general_critical_error']."230983" ); 
    while ( $idr = mysqli_fetch_array($rs_result) ) {
        $maxfiles 	= $idr['maxfiles'];
        $maxrecipients 	= $idr['maxrec'];
        $maxsize	= $idr['maxsize'];
    }
            
    //Get advertise settings:
    include('advertise_includes.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Pragma" CONTENT="no-cache" />
    <meta http-equiv="Expires" CONTENT="-1" />
    <meta http-equiv="X-UA-Compatible" content="chrome=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title> <?php echo $brand.$lang[$lang['set']]['type_title_join_to_brand']; ?></title>
    <!-- INCLUDE JS -->
    <script language="javascript" src="https://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script language="javascript" src="js/jquery.browser.min.js" type="text/javascript"></script>	
    <script type="text/javascript">
        var maxfiles            =  <?php  echo $maxfiles;        ?>;
        var maxrecipients       =  <?php  echo $maxrecipients;   ?>;
        var accept_file_types   = "<?php  echo $accept_types;    ?>";
        var maxSize             =  <?php  echo $maxsize;         ?>;

        //Typography (edit in lang.php):
        <?php include_once('lang_to_js.php');?>      
    </script>
    <script language="javascript" src="js/mainjs.js" type="text/javascript"></script>  
    <!-- INCLUDE STYLE-SHEETS -->
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/buttons.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/<?php echo $themeUse; ?>.css" type="text/css" media="screen" />
    <!--[if IE 9]>
        <style type="text/css">  
            div {
               filter: none;
            }
            input[type="text"],
            input[type="password"],
            .css-textarea{ background-color: #FAFAFA !important; filter: none; }
            .css3button,.css4button { filter: none; }
        </style>
    <![endif]-->
    <?php
        //Advertise code head:
        if ( $guests === '1' ) {
            if ( $adsense_mainpage == '1' ) {
                echo $adsense_head;
            }
        }
    ?>
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
<form method="post" action="code/client/filesend.php" enctype="multipart/form-data" accept-charset="UTF-8" id='takethatform'>
<input type='hidden' name='modeEQ' id='modeEQ' value='<?php echo $users_mode; ?>' />
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxsize; ?>" />
<?php echo gettokenfield(); ?>
<div class="outerContainer"  grab="top2-" >
<table border='0' class='graber' grab="top2-">
    <tr>
        <td colspan='3'>
            <table border='0' class='quickStat'>
                <tr>
                    <td class='soFarSent'>
                        <?php 
                            if ($include_miles) { 
                                echo $lang[$lang['set']]['type_sofar_counter'];
                        ?>
                        <span>
                            <?php echo soFarFilesCount($linkos); ?> ~ <?php echo humanFileSize(soFarFilesSize($linkos),false); ?>
                        </span><?php } ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php 
    if ( $maxfiles == 1 || $maxfiles == "1" )           { $files_title = $lang[$lang['set']]['type_file_sec_title_single']; } else { $files_title = $lang[$lang['set']]['type_file_sec_title_multi']; }
    if ( $maxrecipients == 1 || $maxrecipients == "1" ) { $rec_title = $lang[$lang['set']]['type_recipient_sec_title_single']; } else { $rec_title = $lang[$lang['set']]['type_recipient_sec_title_multi']; }
?>
    <tr>
        <td colspan='3'><span class='sizeclac smaller' id='sizeclac'></span></td>
    </tr>
    <tr>
        <td>
            <input class='file' type='file' name='file1' id='file1' accept='<?php echo $accept_types; ?>' style='display:none;' />
            <table border='0' cellpadding='0' cellspacing='0' style='border:0; padding:0; margin:0;'>
                <tr>
                    <td style="width: 80px;">
                        <a href='#' class='hoverfile button facebook' grab='top1-' ><?php echo $lang[$lang['set']]['type_browse_button']; ?></a>
                    </td>
                    <td style='padding-right:5px;'>
                        <input class='tempShowfiler' type='text' name='tempShowfiler' id='tempShowfiler' placeholder="<?php echo $lang[$lang['set']]['type_file_field_placeholder']; ?>" readonly />
                    </td>
                </tr>
            </table>
        </td>
        <td width='30px'>
            <div class='clear_file' id='clear_file'>&#10006;</div>
        </td>
        <td  width='40px'>
            <div id='showerror1' class='showerror' style='display:none;'>
                <img src='img/glyphicons/png/1error.png' />
            </div>
        </td>
    </tr>
    <?php  if ( $maxfiles !== 1 && $maxfiles !== "1" ) { ?>
    <tr>
        <td colspan='3' style='position:relative;'>
            <div class='add_file' id='add_file' style="display:inline-block;">&#43;</div>
            <div style="position:relative; display:inline-block; left:20%;">
                <div class='maximum_reach' style='display:none;'><?php echo $lang[$lang['set']]['type_limit_files_reached']; ?></div>
            </div>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan='3'>
            <div class='border_div2'></div>
        </td>
    </tr>
    <tr>
        <td>
            <input class='recipients' type='text' name='sendto1' id='sendto1' placeholder="<?php echo $lang[$lang['set']]['type_recipient_field_placeholder']; ?>" />
        </td>
        <td>
            <div class='clear_to' id='clear_to'>&#10006;</div>
        </td>
        <td>
            <div id='showerror_to1' class='showerror' style='display:none;'>
                <img src='img/glyphicons/png/1error.png' />
            </div>
        </td>
    </tr>
    <?php  if ( $maxrecipients !== 1 && $maxrecipients !== "1" ) { ?>
    <tr>
        <td colspan='3' style='position:relative;'>
            <div class='add_to' id='add_to' style="display:inline-block;">&#43;</div>
            <div style="position:relative; display:inline-block; left:10%;">
                <div class='maximum_reach' style='display:none;'><?php echo $lang[$lang['set']]['type_limit_recipients_reached']; ?></div>
            </div>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan='3'>
            <div class='border_div2'></div>
        </td>
    </tr>
    <tr>
        <td>
            <input class='' type='text' name='fromsend' id='fromsend' placeholder="<?php echo $lang[$lang['set']]['type_from_field_placeholder']; ?>" />
        </td>
        <td width='30px'></td>
        <td>
            <div id='showerrorfromsend' class='showerror' style='display:none;'>
                <img src='img/glyphicons/png/1error.png' />
            </div>
        </td>
    </tr>
    <tr>
        <td colspan='3'>
            <div class='border_div2'></div>
        </td>
    </tr>
    <tr>
        <td>
            <p class='sec_form'><?php echo $lang[$lang['set']]['type_notify_me_deliv']; ?></p>
        </td>
        <td colspan='2' style='padding:0px 0px 4px 7px;'>
            <input class="css-checkbox" type='checkbox' name='checkbox_notify' id='checkbox_notify' CHECKED />
            <label for="checkbox_notify" class="css-label"></label>
        </td>
    </tr>
    <tr>
        <td>
            <p class='sec_form'><?php echo $lang[$lang['set']]['type_notify_me_open']; ?></p>
        </td>
        <td colspan='2' style='padding:0px 0px 4px 7px;'>
            <input class="css-checkbox" type='checkbox' name='checkbox_readEmail' id='checkbox_readEmail' CHECKED />
            <label for="checkbox_readEmail" class="css-label"></label>
        </td>
    </tr>
    <tr>
        <td>
            <p class='sec_form'><?php echo $lang[$lang['set']]['type_send_me_copy']; ?></p>
        </td>
        <td colspan='2' style='padding:0px 0px 4px 7px;'>
            <input  class="css-checkbox" type='checkbox' name='checkbox_copy' id='checkbox_copy' CHECKED />
            <label for="checkbox_copy" class="css-label"></label>
        </td>
    </tr>
    <tr>
        <td colspan='3'>
            <div class='border_div2'></div>
        </td>
    </tr>
    <tr>
        <td colspan='3'>
            <p class='sec_form'><?php echo $lang[$lang['set']]['type_text_message_title']; ?></p>
        </td>
    </tr>
    <tr>
        <td colspan='3'>
            <textarea class='css-textarea' name='message' id='message' placeholder="<?php echo $lang[$lang['set']]['type_text_message_placeholder']; ?>"></textarea>
        </td>
    </tr>
    <tr>
        <td colspan='3' id='prog_mes'>
            <div class='gradient' id='conMessageReturn' style='display:none;'></div>
            <div class='gradient' id='conMessageDone' style='display:none;'></div>
        </td>
    </tr>
    <tr>
        <td colspan='3'>
            <a class='button facebook' id='but1sub' grab='top3-' ><?php echo $lang[$lang['set']]['type_sent_button']; ?></a>
        </td>
    </tr>
</table>
</div>
</form>
	<div class="lowerStuff" >
		<div class="lowerContainer" >
			<div class="lowerContent" >
					<div class="lowerlogo" >
						<a href="index.php"><img src="img/ladybug-logo.png"></a>
					</div>
					<h2>Email your files with ladybug</h2>
			</div>
		</div>
		<div class="lowerText" >
			<a href="/about/">Learn More</a>
		</div>
	</div>
</body>
</html>