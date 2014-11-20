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
    
?>  
<!-- update overlay: -->
    <div class='ads_update_overlay' expose='false'>
        <div class='conn_up_ads'>
            <p class='close_updater_ads'>&#10006;</p>
            <p><?php echo $lang[$lang['set']]['type_advertise_updateBannerOverlay_main_title']; ?></p>
            <form id="ads_form_update">
                <input type="hidden" value="" id="ads_up_id" name="ads_up_id" />
                <table>
                    <tr>
                        <td colspan='2' style='padding-top: 10px; padding-bottom: 10px; text-align: center;' id='display_banner_up'></td>
                    </tr>
                    <tr>
                        <td><?php echo $lang[$lang['set']]['type_advertise_updateBannerOverlay_name']; ?></td>
                        <td><input type='text' name='banners_alt_name_up' id='banners_alt_name_up' placeholder='<?php echo $lang[$lang['set']]['type_advertise_updateBannerOverlay_name_placeholder']; ?>' /></td>
                    </tr>
                    <tr>
                        <td><?php echo $lang[$lang['set']]['type_advertise_updateBannerOverlay_userExposure']; ?></td>
                        <td>
                            <input class='css-checkbox' type='checkbox' name='banners_users_exposure_up' id='banners_users_exposure_up' />
                            <label class='css-label' for='banners_users_exposure_up'></label>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $lang[$lang['set']]['type_advertise_updateBannerOverlay_guestExposure']; ?></td>
                        <td>
                            <input class='css-checkbox' type='checkbox' name='banners_guests_exposure_up' id='banners_guests_exposure_up' />
                            <label class='css-label' for='banners_guests_exposure_up'></label>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $lang[$lang['set']]['type_advertise_updateBannerOverlay_allowMain']; ?></td>
                        <td>
                            <input class='css-checkbox' type='checkbox' name='banners_allow_main_up' id='banners_allow_main_up' />
                            <label class='css-label' for='banners_allow_main_up'></label>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $lang[$lang['set']]['type_advertise_updateBannerOverlay_allowDown']; ?></td>
                        <td>
                            <input class='css-checkbox' type='checkbox' name='banners_allow_down_up' id='banners_allow_down_up' />
                            <label class='css-label' for='banners_allow_down_up'></label>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $lang[$lang['set']]['type_advertise_updateBannerOverlay_allowEmailRec']; ?></td>
                        <td>
                            <input class='css-checkbox' type='checkbox' name='banners_allow_rec_up' id='banners_allow_rec_up' />
                            <label class='css-label' for='banners_allow_rec_up'></label>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $lang[$lang['set']]['type_advertise_updateBannerOverlay_allowEmailSender']; ?></td>
                        <td>
                            <input class='css-checkbox' type='checkbox' name='banners_allow_sender_up' id='banners_allow_sender_up' />
                            <label class='css-label' for='banners_allow_sender_up'></label>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $lang[$lang['set']]['type_advertise_updateBannerOverlay_url']; ?></td>
                        <td>
                            <input type='text' name='banners_url_up' id='banners_url_up' placeholder='<?php echo $lang[$lang['set']]['type_advertise_updateBannerOverlay_url_placeholder']; ?>' />
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' style='text-align:center; padding-top:10px;'>
                            <div class='css3button' id='submit_ads_update'>
                                <?php echo $lang[$lang['set']]['type_button_updateBannerSet_text']; ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
<?php
} else {
    exit;
}
