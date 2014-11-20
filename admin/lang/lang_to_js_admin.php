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
/*************************** HOOKS FOR JS TEXT  *******************************/
/******************* DO NOT EDIT - ONLY ADD IF NEEDED *************************/
echo "
    var type_js_general_error_contact_admin         = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_general_error_contact_admin'])."\";
    var type_js_user_mode_update_success            = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_user_mode_update_success'])."\";
    var type_js_guestAccount_invalid_recLimit       = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_guestAccount_invalid_recLimit'])."\";
    var type_js_guestAccount_updated                = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_guestAccount_updated'])."\";
    var type_js_addUser_validation_userName_invalid = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_addUser_validation_userName_invalid'])."\";
    var type_js_addUser_validation_password_invalid = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_addUser_validation_password_invalid'])."\";
    var type_js_addUser_validation_recLimit_invalid = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_addUser_validation_recLimit_invalid'])."\";
    var type_js_addUser_validation_email_invalid    = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_addUser_validation_email_invalid'])."\";
    var type_js_addUser_success_created1            = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_addUser_success_created1'])."\";
    var type_js_addUser_success_created2            = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_addUser_success_created2'])."\";
    var type_js_addUser_userName_taken1             = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_addUser_userName_taken1'])."\";
    var type_js_addUser_userName_taken2             = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_addUser_userName_taken2'])."\";
    var type_js_updateUser_success_created1         = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_updateUser_success_created1'])."\";
    var type_js_updateUser_success_created2         = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_updateUser_success_created2'])."\";
    var type_js_updateUser_userName_taken1          = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_updateUser_userName_taken1'])."\";
    var type_js_updateUser_userName_taken2          = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_updateUser_userName_taken2'])."\";
    var type_js_addUser_success_del1                = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_addUser_success_del1'])."\";
    var type_js_addUser_success_del2                = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_addUser_success_del2'])."\";
    var type_js_cleanUp_weeks_interval_invalid      = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_cleanUp_weeks_interval_invalid'])."\";
    var type_js_advertise_saved_success             = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_advertise_saved_success'])."\";
    var type_js_advertise_adsense_saved_success     = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_advertise_adsense_saved_success'])."\";
    var type_js_advertise_addBanner_saved_success   = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_advertise_addBanner_saved_success'])."\";
    var type_js_advertise_updateBanner_saved_success= \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_advertise_updateBanner_saved_success'])."\";   
    var type_js_advertise_resetCounter_confirm      = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_advertise_resetCounter_confirm'])."\";
    var type_js_advertise_resetCounter_success      = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_advertise_resetCounter_success'])."\";  
    var type_js_advertise_delBanner_confirm         = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_advertise_delBanner_confirm'])."\";
    var type_js_advertise_delBanner_success         = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_advertise_delBanner_success'])."\"; 
    var type_js_stat_reset_confirm                  = \"".str_replace(array('\'', '"','\''), '', $lang[$lang['set']]['type_js_stat_reset_confirm'])."\"; 
";