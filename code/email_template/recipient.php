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
/**************************** Template For Recipient ***************************
 *
 * $leech_image - must be included some where in this template!
 *                its a 1px that is programaticaly served to the mail server and 
 *                will trigger in most case the Email read notification & log.
 * 
 * 
*******************************************************************************/

$message_join = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
 <head>
  <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
  <title>TakeThat File Shring system</title>
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
  <style>
    .banner_style_mainpage {
        border:1px solid #6E6E6E;
        border-radius:4px;
        width:385px;
        height:87px;
        margin:0;
        padding:0;
    }
    div.wrapper_banner_click {
        position:relative;
        width:387px;
        height:89px;
        margin:0;
        padding:0;
    }
    a.force_flash{
        position:absolute;
        top:0px;
        left:0px;
        background-color:transparent;
        width:387px;
        height:89px;
        margin:0;
        padding:0;
        z-index:5;
    }
  </style>
</head>
<body style='margin: 0; padding: 0;'>
  ".$leech_image."
 <table border='0' cellpadding='0' cellspacing='0' width='100%'>
  <tr>
   <td colspan='2' style='background-color:#F2F2F2; padding:35px; border:1px solid #585858;' >
        <a href='".$link."/' style='border:0;' ><img src='".$link."/img/takethatlogo.png' /></a>
   </td>
  </tr>";

if( $ads !== false ) {  
    $message_join .= $ads['banner_include'];
}

$message_join .= "
   <tr>
   <td  style='background-color:white; padding:15px; width:50%; vertical-align:top; '>
    <div style='background-color:#F2F2F2; border-radius:5px; padding:10px; font-family:arial; font-size:14px;' >
        Hi, <br /><strong style='color:blue;'>".$from_user."</strong> sent you a file(s) he want to 
        share with you. <br /><br />
        ".$message_define."
    </div>
   </td>
   <td  style='background-color:white; padding:15px; width:50%; vertical-align:top;'>
    <div style='background-color:#F2F2F2; border-radius:5px; padding:10px; font-family:arial; font-size:14px' >
        <strong>Here is your download link:</strong>
        <br/><br/>
        <a href='".$link."/?get=".$secret."' style='display:block; text-align:center; padding-top:7px; padding-bottom:7px; background-color:#348eda; color:white; font-weight:bold; border-radius:10px; text-decoration: none;' >
            ".$file_only_name."
        </a>
        <br/><br/>";
        if ($message_user2!='') {
                $message_join .= "<strong>Note From Sender:</strong><br/>\"&nbsp;".$message_user2."&nbsp;\"";
        }
        
$message_join .= "
    </div>
   </td>
  </tr>
  <tr>
   <td colspan='2' style='background-color:white; height:30px; '>
   </td>
  </tr>
  <tr>
   <td colspan='2' style='background-color:#F2F2F2; border:1px solid #585858; height:20px; '>
   </td>
  </tr>
 </table>
</body>
</html>
";