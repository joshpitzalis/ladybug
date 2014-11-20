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
    $max_key = count($banners_arr);
    if ( $max_key > 0 ) {
        $generate_random_key = rand(0,$max_key-1);

        $type = explode('.',$banners_arr[$generate_random_key]['banner_filename']);
        $type = strtolower($type[count($type)-1]);
        $link = $banners_arr[$generate_random_key]['url'];
        if ( $link == "" ) $link = '#'; 

        //If Flash (include with iframe) Set overlay:
        if ( $type == "swf" ) {
            echo "<tr>
                    <td colspan='3'>
                        <div class='wrapper_banner_click'>
                            <a id='banner_click' class='force_flash' rel='nofollow' bannerId='".$banners_arr[$generate_random_key]['id']."' href='".$link."' target='_blank' style='border:0;' alt='".$banners_arr[$generate_random_key]['banner_altname']."' title='".$banners_arr[$generate_random_key]['banner_altname']."'></a>
                            <iframe class='banner_style_mainpage effect6' frameborder='0' scrolling='no' src='banners/".$banners_arr[$generate_random_key]['banner_filename']."'></iframe>
                        </div>
                    </td>
                </tr>";
            echo "<tr><td colspan='3'><div class='border_div2'></div></td></tr>";                
        } else {
        //If Image (jpg,png,gif):
            echo "<tr>
                    <td colspan='3'>
                        <a id='banner_click' rel='nofollow' bannerId='".$banners_arr[$generate_random_key]['id']."' href='".$link."' target='_blank' style='border:0;'>
                            <img class='banner_style_mainpage effect6' src='banners/".$banners_arr[$generate_random_key]['banner_filename']."' alt='".$banners_arr[$generate_random_key]['banner_altname']."' title='".$banners_arr[$generate_random_key]['banner_altname']."' />
                        </a>
                    </td>
                </tr>";
            echo "<tr><td colspan='3'><div class='border_div2'></div></td></tr>";
        }
    }  
}