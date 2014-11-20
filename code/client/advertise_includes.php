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

if ( isset($linkos) ) {

    $sqlstatus = "SELECT * FROM `".$table8."` WHERE `id`='1'";
    $rs_result = mysqli_query($linkos, $sqlstatus) or die ( $lang[$lang['set']]['type_db_error']."5682" ); 
        while ( $idr = mysqli_fetch_array( $rs_result ) ) {
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
            $adsense_head       = $idr['adsense_head'];
        }     

    $banners_arr = array();
    $sqlstatus   = "SELECT * FROM `".$table9."` WHERE `active` = '1' AND `mainpage` = '1' AND `user` = '1' ";
    $rs_result   = mysqli_query( $linkos, $sqlstatus ) or die ( $lang[$lang['set']]['type_db_error']."765" ); 
    $id_count    = 0;
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
}