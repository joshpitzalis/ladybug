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
/**************************** Template For Sender Copy **************************/                        
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
        Hi, <br /> This is a copy of the file(s) you sent. <br /><br />
        ".$message_define_copy."
        <br />
    </div>
   </td>
   <td  style='background-color:white; padding:15px; width:50%; vertical-align:top;'>
    <div style='background-color:#F2F2F2; border-radius:5px; padding:10px; font-family:arial; font-size:14px' >
        <strong>Here are your download link(s):</strong>
        <br/><br/>".$link_file."<br />
        <strong>That you sent to:</strong><br />".$users_string."";
        
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