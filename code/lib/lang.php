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
/*************************** Typography & text  *******************************/

//Set Language
$lang['set'] = "en";
$lang['en']  = array();

//en - general:
    $lang['en']['type_installation_needed']         = "Installation needed!";
    $lang['en']['type_general_critical_error']      = "Something went terribly wrong, contact Admin ~ Code: ";
    $lang['en']['type_general_error']               = "That's embarrassing... something went wrong!";
    $lang['en']['type_send_error_header']           = "Something went wrong: ";
    $lang['en']['type_error_admin_footer']          = "Please contact website administrator with this error.";
    $lang['en']['type_db_error']                    = "DB ERROR ~ code: ";
    
    $lang['en']['type_title_join_to_brand']         = " - File Sharing system ";
    $lang['en']['type_sofar_counter']               = "Files delivered so far: ";
    $lang['en']['type_file_sec_title_single']       = "File:";
    $lang['en']['type_file_sec_title_multi']        = "File/s:";
    $lang['en']['type_recipient_sec_title_single']  = "Recipient:";
    $lang['en']['type_recipient_sec_title_multi']   = "Recipient/s:";
    $lang['en']['type_from_sec_title']              = "From:";
    $lang['en']['type_browse_button']               = "Browse";
    $lang['en']['type_file_field_placeholder']      = "select a file";
    $lang['en']['type_recipient_field_placeholder'] = "friend's e-mail address";
    $lang['en']['type_limit_files_reached']         = "That's the maximum files allowed.";
    $lang['en']['type_limit_recipients_reached']    = "That's the maximum recipients allowed.";
    $lang['en']['type_notify_me_deliv']             = "Notify me when delivered:";
    $lang['en']['type_notify_me_open']              = "Notify me when Email opened:";
    $lang['en']['type_send_me_copy']                = "Send me a copy:";
    $lang['en']['type_text_message_title']          = "Text message:"; 
    $lang['en']['type_text_message_placeholder']    = "text message"; 
    $lang['en']['type_sent_button']                 = "Send";
    
//en - guest mode:
    $lang['en']['type_from_field_placeholder']      = "your e-mail address";
    
//en - user mode:
    $lang['en']['type_login_form_title']            = "Please Login";
    $lang['en']['type_username_field_title']        = "User name:";
    $lang['en']['type_password_field_title']        = "Password:";
    $lang['en']['type_login_button']                = "Log In";
    $lang['en']['type_logout_button']               = "Log Out";
    $lang['en']['type_from_address_title']          = "Email:";
    $lang['en']['type_from_name_title']             = "Name:";
    
//en - dynamic messages (js): avoid ' " and back slashes \
    $lang['en']['progress_bar_fallback']            = "Sending your file please wait...";
    $lang['en']['validation_mis_file_select']       = "Please select a file to send.";
    $lang['en']['validation_mis_recipient_select']  = "Please type the destination E-mail in the Recipients field.";
    $lang['en']['validation_mis_sender_select']     = "Please type your E-mail address in the From field.";
    $lang['en']['validation_invalid_recipient']     = "Please type a valid E-mail address in the Recipients field.";
    $lang['en']['validation_invalid_sender']        = "Please type a valid E-mail address in the From field.";
    $lang['en']['validation_unauthorized_file_type']= "Unauthorized file type.";
    $lang['en']['validation_unauthorized_file_size']= "File size exceeded the maximum size permitted.";
    $lang['en']['validation_human_detection_behavior'] = "You are missing something please take a second look.";
    $lang['en']['validation_file_sent_done']        = "File/s sent successfully!";
    $lang['en']['validation_server_file_cant_send1']= "File number "; //File number will be added.
    $lang['en']['validation_server_file_cant_send2']= " could not be sent.";
    $lang['en']['validation_server_rec_not_send1']  = "Recipient number "; //Recipient number will be added.
    $lang['en']['validation_server_rec_not_send2']  = " did not get the e-mail.";
    $lang['en']['error_copy_send']                  = "Could not send a copy to your e-mail";
    $lang['en']['error_critical_cookies']           = "That's embarrassing... something went wrong! it may be you cookies please enable them.";
    $lang['en']['error_blocked_user']               = "You are not authorized to use this website any more! <br /> Contact admin for additional help.";
    $lang['en']['old_browser_notice']               = "Your browser is too old... please update and try again.";
    $lang['en']['validation_sender_notgood']        = "Your address is invalid.";
    $lang['en']['validation_recipient_notgood_1']   = "Recipient";
    $lang['en']['validation_recipient_notgood_2']   = "is invalid.";
    $lang['en']['validation_recipient_forgot']      = "Forgot to type a friend's address.";
    $lang['en']['validation_sender_forgot']         = "Forgot to type your Email address.";
    $lang['en']['validation_file_notgood_1']        = "File";
    $lang['en']['validation_file_notgood_2']        = "size is not allowed - limit is";
    $lang['en']['validation_file_notgood_3']        = "type is not allowed / unknown.";
    $lang['en']['validation_file_forgot']           = "Forgot to select a file.";

//en - More Emails text:
    $lang['en']['type_file_downloaded_notify_subject']  = "Your file has been downloaded.";
    $lang['en']['type_email_read_notify_subject']       = "A friend has opened the email you sent.";
    
//en - Download page:
    $lang['en']['type_file_size_download']          = "Size:";
    $lang['en']['type_home_button']                 = "Home";
    $lang['en']['type_file_downloaded_not_ava']     = "The requested file\s is not available.";
    $lang['en']['type_file_downloaded_notify_subject'] = "Your file has been downloaded.";
    $lang['en']['type_file_downloaded_notify_subject'] = "Your file has been downloaded.";