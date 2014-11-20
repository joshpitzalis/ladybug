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
if (isset($uname)) {

    //Get current settings:
    $sqlstatus = "SELECT * FROM `".$table8."` WHERE `id`='1'";
    $rs_result = mysqli_query($linkos, $sqlstatus) or die ( $lang[$lang['set']]['type_db_error']."1782" ); 
        while ( $idr = mysqli_fetch_array($rs_result) ) {
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
    $sqlstatus   = "SELECT * FROM `".$table9."` ";
    $rs_result   = mysqli_query($linkos, $sqlstatus) or die ( $lang[$lang['set']]['type_db_error']."165" ); 
        while ( $idr = mysqli_fetch_array($rs_result) ) {
            $banners_arr[$idr['id']]['banner_filename']  = $idr['banner_filename'];
            $banners_arr[$idr['id']]['banner_altname']   = $idr['banner_altname'];
            $banners_arr[$idr['id']]['url']              = $idr['url'];
            $banners_arr[$idr['id']]['active']           = $idr['active'];
            $banners_arr[$idr['id']]['guest']            = $idr['guest'];
            $banners_arr[$idr['id']]['user']             = $idr['user'];
            $banners_arr[$idr['id']]['email_sender']     = $idr['email_sender'];
            $banners_arr[$idr['id']]['email_rec']        = $idr['email_rec'];
            $banners_arr[$idr['id']]['mainpage']         = $idr['mainpage'];
            $banners_arr[$idr['id']]['downpage']         = $idr['downpage'];
            $banners_arr[$idr['id']]['created']          = $idr['created'];
            $banners_arr[$idr['id']]['counter_clicks']   = $idr['counter_clicks'];
            $banners_arr[$idr['id']]['counter_sent']     = $idr['counter_sent'];
        }   
                        
    //Render Tab Html:
?>                           
<p class='admin_head2'><?php echo $lang[$lang['set']]['type_advertise_manager_setting_title']; ?></p>        
    <form id='advertise_general_form' >
        <div class='advertise_general' style='display:table;'>
            <div style='display:table-row'>
                <div style='display:table-cell'><?php echo $lang[$lang['set']]['type_advertise_setting_active_on_main_page']; ?></div>
                <div style='display:table-cell'><input type='radio' name='mainpage_include_type' value='adsense' <?php if($adsense_mainpage === '1') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_code_type_text']; ?></div>
                <div style='display:table-cell'><input type='radio' name='mainpage_include_type' value='banners' <?php if($banner_mainpage === '1') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_banners_type_text']; ?></div>
            </div>
            <div style='display:table-row'>
                <div style='display:table-cell'><?php echo $lang[$lang['set']]['type_advertise_setting_active_on_down_page']; ?></div>
                <div style='display:table-cell'><input type='radio' name='downpage_include_type' value='adsense' <?php if($adsense_downpage === '1') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_code_type_text']; ?></div>
                <div style='display:table-cell'><input type='radio' name='downpage_include_type' value='banners' <?php if($banner_downpage === '1') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_banners_type_text']; ?></div>
            </div>
            <div style='display:table-row'>
                <div style='display:table-cell'><?php echo $lang[$lang['set']]['type_advertise_setting_include_email_rec']; ?></div>
                <div style='display:table-cell'><input type='radio' name='emailrec_include' value='on' <?php if($email_rec === '1') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_enable_text']; ?></div>
                <div style='display:table-cell'><input type='radio' name='emailrec_include' value='off' <?php if($email_rec === '0') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_disable_text']; ?></div>
            </div>
            <div style='display:table-row'>
                <div style='display:table-cell'><?php echo $lang[$lang['set']]['type_advertise_setting_include_email_sender']; ?></div>
                <div style='display:table-cell'><input type='radio' name='emailsender_include' value='on' <?php if($email_sender === '1') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_enable_text']; ?></div>
                <div style='display:table-cell'><input type='radio' name='emailsender_include' value='off' <?php if($email_sender === '0') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_disable_text']; ?></div>
            </div>                     
            <div style='display:table-row'>
                <div style='display:table-cell'><?php echo $lang[$lang['set']]['type_advertise_setting_count_sent']; ?></div>
                <div style='display:table-cell'><input type='radio' name='count_sent' value='on' <?php if($count_sent === '1') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_enable_text']; ?></div>
                <div style='display:table-cell'><input type='radio' name='count_sent' value='off' <?php if($count_sent === '0') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_disable_text']; ?></div>
            </div>
            <div style='display:table-row'>
                <div style='display:table-cell'><?php echo $lang[$lang['set']]['type_advertise_setting_count_click']; ?></div>
                <div style='display:table-cell'><input type='radio' name='count_clicks' value='on' <?php if($count_clicks === '1') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_enable_text']; ?></div>
                <div style='display:table-cell'><input type='radio' name='count_clicks' value='off' <?php if($count_clicks === '0') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_disable_text']; ?></div>
            </div> 
            <div style='display:table-row'>
                <div style='display:table-cell'><?php echo $lang[$lang['set']]['type_advertise_setting_guests_adds']; ?></div>
                <div style='display:table-cell'><input type='radio' name='guests_adds' value='on' <?php if($guests === '1') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_enable_text']; ?></div>
                <div style='display:table-cell'><input type='radio' name='guests_adds' value='off' <?php if($guests === '0') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_disable_text']; ?></div>
            </div>      
            <div style='display:table-row'>
                <div style='display:table-cell'><?php echo $lang[$lang['set']]['type_advertise_setting_users_adds']; ?></div>
                <div style='display:table-cell'><input type='radio' name='user_adds' value='on' <?php if($users === '1') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_enable_text']; ?></div>
                <div style='display:table-cell'><input type='radio' name='user_adds' value='off' <?php if($users === '0') echo "CHECKED"; ?> /><?php echo $lang[$lang['set']]['type_button_disable_text']; ?></div>
            </div>                              
        </div>
        <div class='advertise_general' style='display:table;'>
            <div style='display:table-row'>
                <div style='display:table-cell; text-align:right;'>
                    <div class='css3button add_up' id='but_advertise_general'><?php echo $lang[$lang['set']]['type_button_save_text']; ?></div>
                </div>
            </div>
        </div>
    </form>

<p class='admin_head2'><?php echo $lang[$lang['set']]['type_advertise_manager_codeEmbed_title']; ?></p>
    <form id='advertise_adsenseCode_form'>
        <div class='advertise_general' style='display:table;'>
            <div style='display:table-row'>
                <div style='display:table-cell;'>
                    <?php echo $lang[$lang['set']]['type_advertise_code_head_subtitle']; ?>
                </div>
            </div>
            <div style='display:table-row'>
                <div style='display:table-cell;'>
                    <textarea name='adsense_code_head' class='textare_code_adsense'><?php echo $adsense_head; ?></textarea>
                </div>
            </div>                               
            <div style='display:table-row'>
                <div style='display:table-cell;'>
                    <?php echo $lang[$lang['set']]['type_advertise_code_body_subtitle']; ?>
                </div>
            </div>
            <div style='display:table-row'>
                <div style='display:table-cell;'>
                    <textarea name='adsense_code' class='textare_code_adsense'><?php echo $adsense_code; ?></textarea>
                </div>
            </div>                             
            <div style='display:table-row'>
                <div style='display:table-cell; text-align:right;'>
                    <div class='css3button add_up' id='but_adsense_code'><?php echo $lang[$lang['set']]['type_button_save_text']; ?></div>
                </div>
            </div>
        </div>  
    </form>

<p class='admin_head2'><?php echo $lang[$lang['set']]['type_advertise_manager_addBanner_title']; ?></p>
    <form id='advertise_addbanner_form'>
        <div class='advertise_general' style='display:table;'>
            <div style='display:table-row'>
                <div style='display:table-cell;'><?php echo $lang[$lang['set']]['type_advertise_bannerSave_filename_title']; ?></div>
                <div style='display:table-cell;'><?php echo $lang[$lang['set']]['type_advertise_bannerSave_altname_title']; ?></div>
                <div style='display:table-cell;'><?php echo $lang[$lang['set']]['type_advertise_bannerSave_userExposure_title']; ?></div>
                <div style='display:table-cell;'><?php echo $lang[$lang['set']]['type_advertise_bannerSave_guestExposure_title']; ?></div>
            </div>
            <div style='display:table-row'>
                <div style='display:table-cell;'><input type='text' name='banners_file_name' placeholder='<?php echo $lang[$lang['set']]['type_advertise_bannerSave_filename_placeholder']; ?>' /></div>
                <div style='display:table-cell;'><input type='text' name='banners_alt_name' placeholder='<?php echo $lang[$lang['set']]['type_advertise_bannerSave_altname_placeholder']; ?>' /></div>
                <div style='display:table-cell; text-align:center;'>
                    <input class='css-checkbox' type='checkbox' name='banners_users_exposure' id='banners_users_exposure' CHECKED />
                    <label class='css-label' for='banners_users_exposure'></label>
                </div>
                <div style='display:table-cell; text-align:center;'>
                    <input class='css-checkbox' type='checkbox' name='banners_guests_exposure' id='banners_guests_exposure' CHECKED />
                    <label class='css-label' for='banners_guests_exposure'></label>
                </div>
            </div>    
            <div style='display:table-row'>
                <div style='display:table-cell;'><?php echo $lang[$lang['set']]['type_advertise_bannerSave_allowMain_title']; ?></div>
                <div style='display:table-cell;'><?php echo $lang[$lang['set']]['type_advertise_bannerSave_allowDown_title']; ?></div>
                <div style='display:table-cell;'><?php echo $lang[$lang['set']]['type_advertise_bannerSave_allowEmailRec_title']; ?></div>
                <div style='display:table-cell;'><?php echo $lang[$lang['set']]['type_advertise_bannerSave_allowEmailSender_title']; ?></div>
            </div> 
            <div style='display:table-row'>
                <div style='display:table-cell; text-align:center;'>
                    <input class='css-checkbox' type='checkbox' name='banners_allow_main' id='banners_allow_main' CHECKED />
                    <label class='css-label' for='banners_allow_main'></label>
                </div>
                <div style='display:table-cell; text-align:center;'>
                    <input class='css-checkbox' type='checkbox' name='banners_allow_down' id='banners_allow_down' CHECKED />
                    <label class='css-label' for='banners_allow_down'></label>
                </div>
                <div style='display:table-cell; text-align:center;'>
                    <input class='css-checkbox' type='checkbox' name='banners_allow_rec' id='banners_allow_rec' CHECKED />
                    <label class='css-label' for='banners_allow_rec'></label>
                </div>
                <div style='display:table-cell; text-align:center;'>
                    <input class='css-checkbox' type='checkbox' name='banners_allow_sender' id='banners_allow_sender' CHECKED />
                    <label class='css-label' for='banners_allow_sender'></label>
                </div>
            </div>                                
        </div>
        <div class='advertise_general' style='display:table;'>
            <div style='display:table-row'>
                <div style='display:table-cell;'><?php echo $lang[$lang['set']]['type_advertise_bannerSave_url_title']; ?></div>
            </div>
            <div style='display:table-row'>
                <div style='display:table-cell;'><input type='text' name='banners_url' placeholder='<?php echo $lang[$lang['set']]['type_advertise_bannerSave_url_placeholder']; ?>' /></div>
            </div>
        </div>
        <div class='advertise_general' style='display:table;'>
            <div style='display:table-row'>
                <div style='display:table-cell; text-align:right;'>
                    <div class='css3button add_up' id='but_advertise_bannerAdd'><?php echo $lang[$lang['set']]['type_button_add_text']; ?></div>
                </div>
            </div>
        </div> 
    </form>

    <p class='admin_head2'><?php echo $lang[$lang['set']]['type_advertise_manager_savedBanner_title']; ?></p>     
        <div class='advertise_general marginTop1' style='display:table;'>
            <div style='display:table-row'>
                <div style='display:table-cell;' class='tableHead_admin'><?php echo $lang[$lang['set']]['type_advertise_savedTable_banner_title']; ?></div>
                <div style='display:table-cell;' class='tableHead_admin'><?php echo $lang[$lang['set']]['type_advertise_savedTable_bannerClicks_title']; ?></div>
                <div style='display:table-cell;' class='tableHead_admin'><?php echo $lang[$lang['set']]['type_advertise_savedTable_bannerSent_title']; ?></div>
                <div style='display:table-cell;' class='tableHead_admin'><?php echo $lang[$lang['set']]['type_advertise_savedTable_bannerActions_title']; ?></div>
            </div>
            <?php
                foreach ( $banners_arr as $key => $data ) {
                    $type = explode('.',$data['banner_filename']);
                    $type = strtolower($type[count($type)-1]);
                    $bannerType_set = "image";
                    if ( $type == "swf" ) {
                        $bannerType_set = "iframe";
                        echo "<div style='display:table-row'><div style='display:table-cell;' class='tableHead_cell'><iframe src='../banners/".$data['banner_filename']."' frameborder='0' scrolling='no' alt='".$data['banner_altname']." title='".$data['banner_altname']."' style='width:200px; height:45px;'></iframe></div>";                                        
                    } else {
                        echo "<div style='display:table-row'><div style='display:table-cell;' class='tableHead_cell'><img src='../banners/".$data['banner_filename']."' alt='".$data['banner_altname']." title='".$data['banner_altname']."' style='width:200px; height:45px;'/></div>";
                    }                   
                    echo "<div style='display:table-cell;' class='tableHead_cell'>".$data['counter_clicks']."</div>
                                <div style='display:table-cell;' class='tableHead_cell'>".$data['counter_sent']."</div>
                                <div style='display:table-cell;' class='tableHead_cell'>
                                    <input type='hidden' class='json_info_ads' value='".json_encode($data)."' />
                                    <img class='ads_act reset_counters_ads' alt='".$lang[$lang['set']]['type_advertise_savedTable_buttonAlt_reset']."' title='".$lang[$lang['set']]['type_advertise_savedTable_buttonAlt_reset']."' src='../img/empty.png' bannerId='".$key."' bannerType='".$bannerType_set."' />&nbsp;
                                        <img class='ads_act update_ads' alt='".$lang[$lang['set']]['type_advertise_savedTable_buttonAlt_setting']."' title='".$lang[$lang['set']]['type_advertise_savedTable_buttonAlt_setting']."' src='../img/updateset.png' bannerId='".$key."' bannerType='".$bannerType_set."' />&nbsp;
                                            <img class='ads_act del_banner_ads' alt='".$lang[$lang['set']]['type_advertise_savedTable_buttonAlt_delete']."' title='".$lang[$lang['set']]['type_advertise_savedTable_buttonAlt_delete']."' src='../img/reset.png' bannerId='".$key."' bannerType='".$bannerType_set."' />
                                </div>
                            </div>";
                }
            ?>
        </div>

<?php
} else {
    exit;
}