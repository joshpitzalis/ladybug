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
/*************************** Typography & text  *******************************/

//Set Language
$lang['set'] = "en";
$lang['en']  = array();


//en - general:
    $lang['en']['type_title_join_to_brand']     = " - Admin Pannel ";
    $lang['en']['type_installation_needed']     = "Installation needed!";
    $lang['en']['type_general_critical_error']  = "Something went terribly wrong, contact Admin ~ Code: ";
    $lang['en']['type_general_error']           = "That's embarrassing... something went wrong!";
    $lang['en']['type_send_error_header']       = "Something went wrong: ";
    $lang['en']['type_error_admin_footer']      = "Please contact website administrator with this error.";
    $lang['en']['type_db_error']                = "DB ERROR ~ code: ";
    $lang['en']['type_admin_page_main_title']   = "Administration panel:";


//en - Login Form:
    $lang['en']['type_login_page_main_title']           = "Administration panel:";
    $lang['en']['type_login_page_user_name_input_label']= "User name:";
    $lang['en']['type_login_page_password_input_label'] = "Password:";
    $lang['en']['type_login_page_submit_button']        = "Log In";

//en - Buttons text:
    $lang['en']['type_button_logout_text']          = "Log Out";
    $lang['en']['type_button_save_text']            = "Save";
    $lang['en']['type_button_add_text']             = "Add";
    $lang['en']['type_button_enable_text']          = "Enable";
    $lang['en']['type_button_disable_text']         = "Disable";
    $lang['en']['type_button_code_type_text']       = "Code Embed";
    $lang['en']['type_button_banners_type_text']    = "Banners";
    $lang['en']['type_button_exclude_text']         = "Exclude";
    $lang['en']['type_button_searchLog_text']       = "Search Log";
    $lang['en']['type_button_searchEmail_text']     = "Search Email";
    $lang['en']['type_button_refresh_title']        = "Refresh";
    $lang['en']['type_button_runCleanup_title']     = "Start CleanUp";
    $lang['en']['type_button_updateMode_text']      = "Update Mode";
    $lang['en']['type_button_updateGuest_text']     = "Update Guest";
    $lang['en']['type_button_addUser_text']         = "Add User";
    $lang['en']['type_button_updateUser_text']      = "Update";
    $lang['en']['type_button_updateUser_butt_text'] = "Update user";
    $lang['en']['type_button_deleteUser_text']      = "Delete";
    $lang['en']['type_button_updateBannerSet_text'] = "Update Settings";
    
//en - Tab names:
    $lang['en']['type_tabGeneral_name_text']   = "General";
    $lang['en']['type_tabLog_name_text']       = "Log";
    $lang['en']['type_tabSearch_name_text']    = "Search";
    $lang['en']['type_tabExclude_name_text']   = "Exclude";
    $lang['en']['type_tabBlocked_name_text']   = "Blocked";
    $lang['en']['type_tabStorage_name_text']   = "Storage";
    $lang['en']['type_tabUsers_name_text']     = "Users";
    $lang['en']['type_tabAdvertise_name_text'] = "Advertise";
    $lang['en']['type_tabStats_name_text']     = "Stats";
    
//en - TAB general Settings:
    //General:
    $lang['en']['type_settingsGen_main_title'] = "General settings";
    $lang['en']['type_settingsGen_inline_save']= "save";
    
    //subtitles (sections):
    $lang['en']['type_settingsGen_appTheme_title']  = "App theme:";
    $lang['en']['type_settingsGen_admin_title']     = "Admin User:";
    $lang['en']['type_settingsGen_brand_title']     = "Your Brand Name:";
    $lang['en']['type_settingsGen_soFar_title']     = "Include \"so far\" on main page:";
    $lang['en']['type_settingsGen_maxFiles_title']  = "Maximum files allowed:";
    $lang['en']['type_settingsGen_maxSize_title']   = "Maximum file size:";
    $lang['en']['type_settingsGen_types_title']     = "File types allowed:";
    $lang['en']['type_settingsGen_maxRec_title']    = "Maximum recipients:";
    $lang['en']['type_settingsGen_serverMail_title']= "Server E-mail address:";
    $lang['en']['type_settingsGen_folder_title']    = "Files folder URL:";
    $lang['en']['type_settingsGen_mesRec_title']    = "Message Construct - recipient:";
    $lang['en']['type_settingsGen_mesSender_title'] = "Message Construct - Copy to sender:";
    
    //Validation Errors:
    $lang['en']['type_settingsGen_valError1']  = "Your Input is not correct or violates server restrictions.";
    $lang['en']['type_settingsGen_valError2']  = "Your Input is not correct.";
    $lang['en']['type_settingsGen_valError3']  = "App theme:";
    
    //Section admin username & password:
    $lang['en']['type_settingsGen_username_input_title']        = "User Name: ";
    $lang['en']['type_settingsGen_username_input_maxChars']     = " ( min 5 chars ) ";
    $lang['en']['type_settingsGen_username_input_placeholder']  = "user name min 5 chars";
    $lang['en']['type_settingsGen_password_input_title']        = "Admin Password: ";
    $lang['en']['type_settingsGen_password_input_maxChars']     = " ( min 6 chars ) ";
    $lang['en']['type_settingsGen_password_input_placeholder']  = "Reset password min 6 chars";
    
    //Section max files set:
    $lang['en']['type_settingsGen_maxFiles_serverRestrict']     = "Server restriction: ";
    
    //Section max size files set:
    $lang['en']['type_settingsGen_maxSize_serverRestrict_single']= "Server restriction size single file: ";    
    $lang['en']['type_settingsGen_maxSize_serverRestrict_post']  = "Server restriction POST size: ";
    $lang['en']['type_settingsGen_maxSize_serverRestrict_time']  = "Server restriction POST time: ";
    
    //Section max recipients set:
    $lang['en']['type_settingsGen_maxRec_serverRestrict']  = "Server restriction: ";

    //Section Server Email set:
    $lang['en']['type_settingsGen_folder_serverEmail_title'] = "Server Host: ";
    
    //Section Folder set:
    $lang['en']['type_settingsGen_folder_sidehelp_note'] = "include full path.";

    //Section Email Struct set:
    $lang['en']['type_settingsGen_Email_head_title']  = "title";
    $lang['en']['type_settingsGen_Email_body_title']  = "custom body";  

//en - TAB Log activity:
    //General:
    $lang['en']['type_log_main_title'] = "Files log:";
    
    //Display table:
    $lang['en']['type_log_from_input_title'] = "From:";
    $lang['en']['type_log_to_input_title']   = "To:";
    
    //Validation
    $lang['en']['type_log_error_dates'] = "Your Input is not correct Check carefully the dates format (yyyy-mm-dd)";
    
    //Dynamic Results:
    $lang['en']['type_log_results_counter']         = "Results: ";
     $lang['en']['type_log_results_noResult']       = "No Results.";
    $lang['en']['type_log_results_thead_sender']    = "Sender";
    $lang['en']['type_log_results_thead_to']        = "Sent To";
    $lang['en']['type_log_results_thead_filename']  = "File Name";
    $lang['en']['type_log_results_thead_date']      = "Date";
    $lang['en']['type_log_results_thead_actions']   = "Actions";
    
    $lang['en']['type_log_results_actions_details_alt'] = "Expand Details";
    $lang['en']['type_log_results_actions_delete_alt']  = "Delete this row";
    
    $lang['en']['type_log_results_details_filename']            = "File name:";
    $lang['en']['type_log_results_actions_filename_onserver']   = "File name on server:";
    $lang['en']['type_log_results_actions_filetype']            = "File type:";
    $lang['en']['type_log_results_actions_filesize']            = "File size:";
    $lang['en']['type_log_results_actions_notificationRequest'] = "Notification request:";
    $lang['en']['type_log_results_actions_notificationStatus']  = "Notification status:";
    $lang['en']['type_log_results_actions_notificationRecieved']= "Notification recieved:";
    $lang['en']['type_log_results_actions_copyRequest']         = "Copy request:";
    $lang['en']['type_log_results_actions_userMessage']         = "User message:";
    
//en - TAB Search Email activity:
    //General:
    $lang['en']['type_searchEmail_main_title'] = "Search by E-mail (sender):";
    
    //Display table:
    $lang['en']['type_searchEmail_input_placeholder'] = "example@mail.com";
    
    //Validation
    $lang['en']['type_searchEmail_error_email'] = "Your Input is not correct Check carefully the Email format.";
        
//en - TAB Advertisement:
    //General:
    $lang['en']['type_advertise_manager_setting_title']         = "Advertise Manager:";
    $lang['en']['type_advertise_manager_codeEmbed_title']       = "Code Embed setup: (Adsense, custom flash etc)";
    $lang['en']['type_advertise_manager_addBanner_title']       = "Local Banners & Flash:";
    $lang['en']['type_advertise_manager_savedBanner_title']     = "Saved Local Banners & Flash:";
    
    //Main settings:
    $lang['en']['type_advertise_setting_active_on_main_page']   = "Active on main page: ";
    $lang['en']['type_advertise_setting_active_on_down_page']   = "Active on download page: ";
    $lang['en']['type_advertise_setting_include_email_rec']     = "Include banners on email to recipients: ";
    $lang['en']['type_advertise_setting_include_email_sender']  = "Include banners on email to senders:";
    $lang['en']['type_advertise_setting_count_sent']            = "Count banners sent:";
    $lang['en']['type_advertise_setting_count_click']           = "Count banners click:";
    $lang['en']['type_advertise_setting_guests_adds']           = "Guests adds:";
    $lang['en']['type_advertise_setting_users_adds']            = "Users adds:";
    
    //Add code:
    $lang['en']['type_advertise_code_head_subtitle']     = "Code Embed - Place in HEAD:";
    $lang['en']['type_advertise_code_body_subtitle']     = "Code Embed - BODY  (set width:385px height:87px ):";
    
    //Add Banner
    $lang['en']['type_advertise_bannerSave_filename_title']         = "Banner file name:";
    $lang['en']['type_advertise_bannerSave_filename_placeholder']   = "example.jpg";
    $lang['en']['type_advertise_bannerSave_altname_title']          = "Banner alt name:";
    $lang['en']['type_advertise_bannerSave_altname_placeholder']    = "banner name";
    $lang['en']['type_advertise_bannerSave_userExposure_title']     = "Users exposure:";
    $lang['en']['type_advertise_bannerSave_guestExposure_title']    = "Guest exposure:";
    $lang['en']['type_advertise_bannerSave_allowMain_title']        = "Allow on main page:";
    $lang['en']['type_advertise_bannerSave_allowDown_title']        = "Allow on down page:";
    $lang['en']['type_advertise_bannerSave_allowEmailRec_title']    = "Allow in emails (rec):";
    $lang['en']['type_advertise_bannerSave_allowEmailSender_title'] = "Allow in emails (sender):";
    $lang['en']['type_advertise_bannerSave_url_title']              = "Banner url redirect:";
    $lang['en']['type_advertise_bannerSave_url_placeholder']        = "http://example.com/";
    
    //Saved Banner display:
    $lang['en']['type_advertise_savedTable_banner_title']       = "Banner";
    $lang['en']['type_advertise_savedTable_bannerClicks_title'] = "Clicks";
    $lang['en']['type_advertise_savedTable_bannerSent_title']   = "Sent";
    $lang['en']['type_advertise_savedTable_bannerActions_title']= "Actions";
    $lang['en']['type_advertise_savedTable_buttonAlt_reset']    = "Reset Counters";
    $lang['en']['type_advertise_savedTable_buttonAlt_setting']  = "Update Settings";
    $lang['en']['type_advertise_savedTable_buttonAlt_delete']   = "Delete Banner";
    
    //update overlay:
    $lang['en']['type_advertise_updateBannerOverlay_main_title']        = "Banner Settings:";
    $lang['en']['type_advertise_updateBannerOverlay_name']              = "Banner alt name:";
    $lang['en']['type_advertise_updateBannerOverlay_name_placeholder']  = "banner name:";
    $lang['en']['type_advertise_updateBannerOverlay_userExposure']      = "Expose to users:";
    $lang['en']['type_advertise_updateBannerOverlay_guestExposure']     = "Expose to guests:";
    $lang['en']['type_advertise_updateBannerOverlay_allowMain']         = "Allow on main page:";
    $lang['en']['type_advertise_updateBannerOverlay_allowDown']         = "Allow on download page:";
    $lang['en']['type_advertise_updateBannerOverlay_allowEmailRec']     = "Allow in E-mails (rec):";
    $lang['en']['type_advertise_updateBannerOverlay_allowEmailSender']  = "Allow in E-mails (senders):";
    $lang['en']['type_advertise_updateBannerOverlay_url']               = "Banner URL redirect:";
    $lang['en']['type_advertise_updateBannerOverlay_url_placeholder']   = "http://example.com/";

    
//en - TAB Blocked users:
    //General:
    $lang['en']['type_blocked_main_title'] = "Blocked users:";
    
    //Display table:
    $lang['en']['type_blocked_tableHeader_userIP']      = "IP blocked";
    $lang['en']['type_blocked_tableHeader_userAgent']   = "User Agent";
    $lang['en']['type_blocked_tableHeader_blockingDate']= "Blocking date";
    $lang['en']['type_blocked_tableHeader_remove']      = "Remove";
    
//en - TAB Exclude users:
    //General:
    $lang['en']['type_exclude_addUser_title'] = "Exclude a user:";
    $lang['en']['type_exclude_display_title'] = "Excluded users:";
    
    //Add user inputs:
    $lang['en']['type_exclude_addUser_email']               = "User E-mail";
    $lang['en']['type_exclude_addUser_email_placeholder']   = "example@mail.com";
    $lang['en']['type_exclude_addUser_note']                = "Admin note";
    $lang['en']['type_exclude_addUser_note_placeholder']    = "write the reason";
    $lang['en']['type_exclude_addUser_submit_text']         = "Submit";
    
    //Validation:
    $lang['en']['type_exclude_error_userEmail'] = "Your Input is not correct Check carefully the Email format.";
    
    //Display table:
    $lang['en']['type_exclude_tableHeader_userAddress'] = "User excluded";
    $lang['en']['type_exclude_tableHeader_adminNote']   = "Admin note";
    $lang['en']['type_exclude_tableHeader_excludedDate']= "Excluded date";
    $lang['en']['type_exclude_tableHeader_remove']      = "Remove";

//en - TAB storage view:
    //General:
    $lang['en']['type_storageTab_cleanup_title']   = "CleanUp Task:";
    $lang['en']['type_storageTab_summary_title']   = "Storage summary:";
    $lang['en']['type_storageTab_lastweek_title']  = "Last week files sent - storage:";
    $lang['en']['type_storageTab_typessize_title'] = "Files types & sizes:";   
    
    //cleanup:
    $lang['en']['type_storageTab_cleanup_1week']        = "1 week old"; 
    $lang['en']['type_storageTab_cleanup_2week']        = "2 week old"; 
    $lang['en']['type_storageTab_cleanup_3week']        = "3 week old"; 
    $lang['en']['type_storageTab_cleanup_4week']        = "1 month old"; 
    $lang['en']['type_storageTab_cleanup_input_label']  = "Delete files & records older then:"; 
    $lang['en']['type_storageTab_cleanup_processing']   = "processing..."; 
    
    //Validation:
    $lang['en']['type_storageTab_cleanup_error'] = "Can't Run CleanUp Something went wrong!";
    
    //Display summary table:
    $lang['en']['type_storageTab_summary_totFilesCount'] = "Total files count";
    $lang['en']['type_storageTab_summary_totFilesSize']  = "Total files size";
    
    //Display files table:
    $lang['en']['type_storageTab_disTable_fileType']  = "File type";
    $lang['en']['type_storageTab_disTable_fileCount'] = "Files count";
    $lang['en']['type_storageTab_disTable_fileSize']  = "Files size";
    $lang['en']['type_storageTab_disTable_filePerc']  = "Storage Percentage";  
    
//en - TAB users:
    //General:
    $lang['en']['type_usersTab_mode_title']         = "Users Mode:";
    $lang['en']['type_usersTab_guest_title']        = "Guest Account:";
    $lang['en']['type_usersTab_userCreate_title']   = "Create Users:";
    $lang['en']['type_usersTab_usersDisplay_title'] = "Manage Users:";  
    
    //User mode section:
    $lang['en']['type_usersTab_mode_input_label']   = "&nbsp;&nbsp;Select Mode:";
    $lang['en']['type_usersTab_mode_guestOnly']     = "Guests Only";
    $lang['en']['type_usersTab_mode_userOnly']      = "Users Only";
    $lang['en']['type_usersTab_mode_userNguests']   = "Users & Guests";
    
    //Guest settings section:
    $lang['en']['type_usersTab_guestSet_maxSize']   = "&nbsp;&nbsp;Max file size: ";
    $lang['en']['type_usersTab_guestSet_maxFiles']  = "Max files: ";
    $lang['en']['type_usersTab_guestSet_maxRec']    = "&nbsp;&nbsp;Max recipients: ";
    $lang['en']['type_usersTab_guestSet_maxRec_placeholder'] = "Max recipients";
    
    //Create User section:
    $lang['en']['type_usersTab_createUser_userName']             = "&nbsp;&nbsp;User Name:";
    $lang['en']['type_usersTab_createUser_userName_placeholder'] = "&nbsp;&nbsp;user name -> Min 5 chars";
    $lang['en']['type_usersTab_createUser_password']             = "&nbsp;&nbsp;Password:";
    $lang['en']['type_usersTab_createUser_password_placeholder'] = "&nbsp;&nbsp;user password -> Min 5 chars";
    $lang['en']['type_usersTab_createUser_fullName']             = "&nbsp;&nbsp;Full name:";
    $lang['en']['type_usersTab_createUser_fullName_placeholder'] = "&nbsp;&nbsp;User full name";
    $lang['en']['type_usersTab_createUser_userMail']             = "&nbsp;&nbsp;User mail:";
    $lang['en']['type_usersTab_createUser_userMail_placeholder'] = "&nbsp;&nbsp;Valid user Email";
    $lang['en']['type_usersTab_createUser_maxSize']              = "&nbsp;&nbsp;Max file size:";
    $lang['en']['type_usersTab_createUser_maxFiles']             = "&nbsp;&nbsp;Max files:";
    $lang['en']['type_usersTab_createUser_maxRec']               = "&nbsp;&nbsp;Max recipients:";
    $lang['en']['type_usersTab_createUser_maxRec_placeholder']   = "&nbsp;&nbsp;Max recipients";
    
    //Manage Users section:
    $lang['en']['type_usersTab_manageUser_userName'] = "User name";
    $lang['en']['type_usersTab_manageUser_fullName'] = "Full name";
    $lang['en']['type_usersTab_manageUser_email']    = "E-mail";
    $lang['en']['type_usersTab_manageUser_actions']  = "Actions";
    
    $lang['en']['type_usersTab_manageUser_activation']          = "Activation mode";
    $lang['en']['type_usersTab_manageUser_activation_select']   = "Activation:";
    $lang['en']['type_usersTab_manageUser_activation_active']   = "Active";
    $lang['en']['type_usersTab_manageUser_activation_inactive'] = "Inactive";
    
//en - TAB Stats:
    //General:
    $lang['en']['type_stats_allstat_title'] = "All stats:";
    $lang['en']['type_stats_chart_title']   = "Last week files sent:";
    
    //Stats sections:
    $lang['en']['type_stats_stat1_totSent']              = "Files sent (total):";
    $lang['en']['type_stats_stat2_totUserSent']          = "Files sent (users):";
    $lang['en']['type_stats_stat3_totGuestSent']         = "Files sent (guests):";
    $lang['en']['type_stats_stat4_totSize']              = "Files Size (total):";
    $lang['en']['type_stats_stat5_totSizeGuest']         = "Files Size (guests):";
    $lang['en']['type_stats_stat6_totSizeUsers']         = "Files Size (users):";
    $lang['en']['type_stats_stat7_totSharing']           = "Sharing operations (total):";
    $lang['en']['type_stats_stat8_lastSharing']          = "Last sharing operation:";
    $lang['en']['type_stats_stat9_totSharingUser']       = "Sharing operations (user):";
    $lang['en']['type_stats_stat10_lastSharingUser']     = "Last sharing operation (user):";
    $lang['en']['type_stats_stat11_filesDeliver']        = "Files Delivered:";
    $lang['en']['type_stats_stat12_lastDeliver']         = "Last delivery:";
    $lang['en']['type_stats_stat13_notifiedDeliver']     = "Notified deliveries:";
    $lang['en']['type_stats_stat14_lastNotifiedDeliver'] = "Last Notified delivery:";
    $lang['en']['type_stats_stat15_notifiedRead']        = "Notified Email read:";
    $lang['en']['type_stats_stat16_lastNotifiedRead']    = "Last Notified read:";
    $lang['en']['type_stats_stat17_mesAttachCount']      = "Message attached:";
    $lang['en']['type_stats_stat18_lastMesAttach']       = "Last message attached:";
    $lang['en']['type_stats_stat19_totCopies']           = "Copies sent:";
    $lang['en']['type_stats_stat20_lastAdminLogin']      = "Last admin login:";
    $lang['en']['type_stats_stat21_totUsersLogin']       = "Users logins:";
    $lang['en']['type_stats_stat22_lastUserLogin']       = "Last user login:";
    $lang['en']['type_stats_stat23_mainPageVisits']      = "Main Page visits:";
    $lang['en']['type_stats_stat24_lastMainVisit']       = "Last main visit:";
    $lang['en']['type_stats_stat25_downPageVisits']      = "Download page visits:";
    $lang['en']['type_stats_stat26_lastDownVisit']       = "Last download visit:";
    $lang['en']['type_stats_stat27_filesEarasedLast']    = "Files earased last cleanup:";
    $lang['en']['type_stats_stat28_lastCleanup']         = "Last cleanup:";

//en - Dynamic JS responses: avoid ' " and back slashes \
    //General:
    $lang['en']['type_js_general_error_contact_admin'] = "Something went wrong please contact administrator!";
    
    //User mode update:
    $lang['en']['type_js_user_mode_update_success']    = "users mode updated successfully!";
    
    //Guest account settings:
    $lang['en']['type_js_guestAccount_invalid_recLimit'] = 'Please select a valid recipients limit of minimum 1.';
    $lang['en']['type_js_guestAccount_updated']          = "Guest account successfully updated!";
    
    //User create / update:
    $lang['en']['type_js_addUser_validation_userName_invalid'] = "Please select a valid user of minimum 5 chars.";
    $lang['en']['type_js_addUser_validation_password_invalid'] = "Please select a valid password of minimum 5 chars.";
    $lang['en']['type_js_addUser_validation_recLimit_invalid'] = "Please select a valid recipients limit of minimum 1.";
    $lang['en']['type_js_addUser_validation_email_invalid']    = "Please enter a valid email address for this account.";
    $lang['en']['type_js_addUser_success_created1']            = "User: "; //User name will be added.
    $lang['en']['type_js_addUser_success_created2']            = " successfully added!";
    $lang['en']['type_js_addUser_userName_taken1']             = "Username: ";//User name will be added.
    $lang['en']['type_js_addUser_userName_taken2']             = " is not available!";
    $lang['en']['type_js_updateUser_success_created1']         = "User: "; //User name will be added.
    $lang['en']['type_js_updateUser_success_created2']         = " successfully updated!";
    $lang['en']['type_js_updateUser_userName_taken1']          = "New user name ( ";//User name will be added.
    $lang['en']['type_js_updateUser_userName_taken2']          = " ) is taken - operation aborted!";
    
    //User Delete:
    $lang['en']['type_js_addUser_success_del1']   = "User: "; //User name will be added.
    $lang['en']['type_js_addUser_success_del2']   = " successfully deleted!";
    
    //CleanUp weeks interval invalid:
    $lang['en']['type_js_cleanUp_weeks_interval_invalid']   = "Please select a valid weeks interval.";
    
    //Advertise:
    $lang['en']['type_js_advertise_saved_success']              = "General settings for advertisements saved successfully.";
    $lang['en']['type_js_advertise_adsense_saved_success']      = "Adsense code saved successfully.";
    $lang['en']['type_js_advertise_addBanner_saved_success']    = "New Banner saved successfully.";
    $lang['en']['type_js_advertise_updateBanner_saved_success'] = "Banner changes saved successfully.";
    $lang['en']['type_js_advertise_resetCounter_confirm']       = "Are you sure you want to reset counters of this banner?";
    $lang['en']['type_js_advertise_resetCounter_success']       = "Banner counters reset successfully.";
    $lang['en']['type_js_advertise_delBanner_confirm']          = "Are you sure you want to delete this banner?";
    $lang['en']['type_js_advertise_delBanner_success']          = "Banner deleted successfully.";
    
    //Stats:
    $lang['en']['type_js_stat_reset_confirm'] = "Confirm this stat reset. May affect other stats values and main page stats (so far).";