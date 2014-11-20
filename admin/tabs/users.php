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
    //Render Tab Html:
?>
<!-- User Mode -->
    <p class='admin_head2 row_backcolor1'>
        <?php echo $lang[$lang['set']]['type_usersTab_mode_title']; ?>
        <img src='../img/glyphicons_136_cogwheel2.png' class='expand_users_action_display' />
    </p>
    <div style='display:none'>
        <table border='0' cellspacing='10px'>                    
            <tr>
                <td><p style='margin:0;'><?php echo $lang[$lang['set']]['type_usersTab_mode_input_label']; ?></p></td>
                <td>
                    <select id='users_mode_select' class='selectBoxNew larger_selectBoxNew'>
                        <option value='guests' <?php if ($users_mode=='guests') echo " SELECTED"; ?>>
                            <?php echo $lang[$lang['set']]['type_usersTab_mode_guestOnly']; ?>
                        </option>
                        <option value='users' <?php if ($users_mode=='users') echo " SELECTED"; ?>>
                            <?php echo $lang[$lang['set']]['type_usersTab_mode_userOnly']; ?>
                        </option>
                        <option value='users-guests' <?php if ($users_mode=='users-guests') echo " SELECTED"; ?>>
                            <?php echo $lang[$lang['set']]['type_usersTab_mode_userNguests']; ?>
                        </option>
                    </select>
                </td>
                <td align='right' style='text-align:right;'>
                    <div class='css3button guestsMode' id='but_submit_users_mode' style='margin:0px 0px 0px 0px;'>
                        <?php echo $lang[$lang['set']]['type_button_updateMode_text']; ?>
                    </div>
                </td>                            
            </tr>                           
        </table>
    </div>
    
<!-- Guest Account -->
    <p class='admin_head2 row_backcolor1'>
        <?php echo $lang[$lang['set']]['type_usersTab_guest_title']; ?>
        <img src='../img/glyphicons_136_cogwheel2.png' class='expand_users_action_display' />
    </p>
    <div style='display:none;'>
        <div class='error_catcher' id='valid_of_guest_user' style='display:none;'>
            <div class='closeMessageVal'></div>
        </div>  
        <?php
            $sqlstatus199 = "SELECT * FROM `".$table7."` LIMIT 1";
            $rs_result199 = mysqli_query($linkos, $sqlstatus199) or die (); 
                while ($idr = mysqli_fetch_array($rs_result199)) {
                    $guest_id[]             = $idr['id'];
                    $guest_maxfiles[]       = $idr['maxfiles'];
                    $guest_maxsize[]        = $idr['maxsize'];
                    $guest_maxrec[]         = $idr['maxrec'];
                }
        ?>                      
        <table border='0' cellspacing='10px'>                      
            <tr>
                <td><p style='margin:0;'><?php echo $lang[$lang['set']]['type_usersTab_guestSet_maxSize']; ?></p></td>
                <td>
                    <select id='guest_MaxFsize_new' class='selectBoxNew'>
                    <?php
                            $devider = 0.1;
                            for ($i = 0; $i<10; $i++) {
                                $byte_size = round( $max_size_ge * $devider );
                                $devider  += 0.1;
                                if ($guest_maxsize[0] == $byte_size) $selected = "selected"; else $selected = "";
                                echo "<option value='".$byte_size."' ".$selected.">".humanFileSize($byte_size)."</option>";
                            }
                    ?>
                    </select>                            
                </td>
                <td><p style='margin:0;'><?php echo $lang[$lang['set']]['type_usersTab_guestSet_maxFiles']; ?></p></td>
                <td>
                    <select id='guest_MaxFnum_new' class='selectBoxNew'> 
                    <?php
                        for ($i = 0; $i<$max_files_ge; $i++) {
                            if ($guest_maxfiles[0] == $i+1) $selected = "selected"; else $selected = "";
                            echo "<option value='".($i+1)."' ".$selected.">".($i+1)."</option>";
                        }
                    ?>
                    </select>
                </td>                            
            </tr>   
            <tr>
                <td><p style='margin:0;'><?php echo $lang[$lang['set']]['type_usersTab_guestSet_maxRec']; ?></p></td>
                <td>
                    <input id='guest_MaxRec_new' type='text' value='<?php  echo $guest_maxrec[0];  ?>' class='new_user_add' placeholder='<?php echo $lang[$lang['set']]['type_usersTab_guestSet_maxRec_placeholder']; ?>' />
                </td>
                <td colspan='2' align='right'  style='text-align:right;'>
                    <div class='css3button moveright' id='but_submit_guest' style='margin:0px 0px 0px 0px;'>
                        <?php echo $lang[$lang['set']]['type_button_updateGuest_text']; ?>
                    </div>
                </td>                            
            </tr>                           
        </table>
    </div>
    
<!-- Create Users -->
    <p class='admin_head2 row_backcolor1'>
        <?php echo $lang[$lang['set']]['type_usersTab_userCreate_title']; ?>
        <img src='../img/glyphicons_136_cogwheel2.png' class='expand_users_action_display' />
    </p>
    <div style='display:none;'>
        <div class='error_catcher' id='valid_of_new_user' style='display:none;'>
            <div class='closeMessageVal'></div>
        </div>             
        <table border='0' cellspacing='10px'>
            <tr>
                <td><p style='margin:0;'><?php echo $lang[$lang['set']]['type_usersTab_createUser_userName']; ?></p></td>
                <td><input id='user_name_new' type='text' value='' class='new_user_add' placeholder='<?php echo $lang[$lang['set']]['type_usersTab_createUser_userName_placeholder']; ?>' /></td>
                <td><p style='margin:0;'><?php echo $lang[$lang['set']]['type_usersTab_createUser_password']; ?></p></td>
                <td><input id='user_pass_new' type='text' value='' class='new_user_add' placeholder='<?php echo $lang[$lang['set']]['type_usersTab_createUser_password_placeholder']; ?>' /></td>                            
            </tr>
            <tr>
                <td><p style='margin:0;'><?php echo $lang[$lang['set']]['type_usersTab_createUser_fullName']; ?></p></td>
                <td><input id='user_Fname_new' type='text' value='' class='new_user_add' placeholder='<?php echo $lang[$lang['set']]['type_usersTab_createUser_fullName_placeholder']; ?>' /></td>
                <td><p style='margin:0;'><?php echo $lang[$lang['set']]['type_usersTab_createUser_userMail']; ?></p></td>
                <td><input id='user_Email_new' type='text' value='' class='new_user_add' placeholder='<?php echo $lang[$lang['set']]['type_usersTab_createUser_userMail_placeholder']; ?>' /></td>                            
            </tr>                          
            <tr>
                <td><p style='margin:0;'><?php echo $lang[$lang['set']]['type_usersTab_createUser_maxSize']; ?></p></td>
                <td><select id='user_MaxFsize_new' class='selectBoxNew'>
                    <?php

                            $devider = 0.1;
                            for ($i = 0; $i<10; $i++) {
                                $byte_size = round($max_size_ge*$devider);
                                $devider  += 0.1;
                                echo "<option value='".$byte_size."'>".humanFileSize($byte_size)."</option>";
                            }
                    ?>
                    </select>                            
                </td>
                <td><p style='margin:0;'><?php echo $lang[$lang['set']]['type_usersTab_createUser_maxFiles']; ?></p></td>
                <td><select id='user_MaxFnum_new' class='selectBoxNew'> 
                    <?php
                        for ($i = 0; $i<$max_files_ge; $i++) {
                            echo "<option value='".($i+1)."'>".($i+1)."</option>";
                        }
                    ?>
                    </select>
                </td>                            
            </tr>   
            <tr>
                <td><p style='margin:0;'><?php echo $lang[$lang['set']]['type_usersTab_createUser_maxRec']; ?></p></td>
                <td><input id='user_MaxRec_new' type='text' value='' class='new_user_add' placeholder='<?php echo $lang[$lang['set']]['type_usersTab_createUser_maxRec_placeholder']; ?>' /></td>
                <td colspan='2' align='right'  style='text-align:right;'>
                    <div class='css3button' id='but_submit_new_user' style='margin:0px 0px 0px 0px;'>
                        <?php echo $lang[$lang['set']]['type_button_addUser_text']; ?>
                    </div>
                </td>                            
            </tr>                           
        </table>
    </div>
    
<!-- Manage Users -->
    <p class='admin_head2 row_backcolor1'>
        <?php echo $lang[$lang['set']]['type_usersTab_usersDisplay_title']; ?>
    </p>
    <?php
        $sqlstatus99 = "SELECT * FROM `".$table6."` ORDER BY `username` ASC";
        $rs_result99 = mysqli_query($linkos, $sqlstatus99) or die (); 
        $users_id = array();
            while ($idr = mysqli_fetch_array($rs_result99)) {
                $users_id[]             = $idr['id'];
                $users_username[]       = $idr['username'];
                $users_password[]       = $idr['password'];
                $users_fullname[]       = $idr['fullname'];
                $users_maxfiles[]       = $idr['maxfiles'];
                $users_maxsize[]        = $idr['maxsize'];
                $users_maxrec[]         = $idr['maxrec'];
                $users_usermail[]       = $idr['usermail'];
                $users_added[]          = $idr['added'];
                $users_active[]         = $idr['active'];
            }
    ?>  
    <table class='storage_table3' border='0' cellpadding='0' cellspacing='0' style='border:0;'>
        <tr>
            <td class='table_head1' style='text-align:center;'><?php echo $lang[$lang['set']]['type_usersTab_manageUser_userName']; ?></td>
            <td class='table_head1' style='text-align:center;'><?php echo $lang[$lang['set']]['type_usersTab_manageUser_fullName']; ?></td>
            <td class='table_head1' style='text-align:center;'><?php echo $lang[$lang['set']]['type_usersTab_manageUser_email']; ?></td>
            <td class='table_head1' style='text-align:center;'><?php echo $lang[$lang['set']]['type_usersTab_manageUser_actions']; ?></td>
        </tr>
    <?php
        foreach ($users_id as $key => $value) {

            if($users_active[$key] == 'yes') $pic_active = 'active.png'; else $pic_active = 'inactive.png';
        echo "<tr>";
            echo "<td style='position:relative'><img src='../img/".$pic_active."' width='15px' height='15px' style='position:relative; top:3px;' alt='".$lang[$lang['set']]['type_usersTab_manageUser_activation']."' title='".$lang[$lang['set']]['type_usersTab_manageUser_activation']."' />&nbsp;&nbsp;".$users_username[$key]."</td>";
            echo "<td class='center_text'>".$users_fullname[$key]."</td>";
            echo "<td class='center_text'>".$users_usermail[$key]."</td>";
            echo "<td width='124px'><div class='wrap_buttons_users'><div class='update_row_user'>".$lang[$lang['set']]['type_button_updateUser_text']."</div><div class='delete_row_user' rowId='".$users_id[$key]."' >".$lang[$lang['set']]['type_button_deleteUser_text']."</div></div></td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td colspan='4' style='padding:2px 5px 2px 5px; border:0; border-bottom:1px solid rgb(216, 216, 216) !important;'>";
                echo "<div class='row_info_users' style='display:none'>
                        <table border='0' cellspacing='5px' width='90%'>
                            <tr>
                                <td><p style='margin:0;'>".$lang[$lang['set']]['type_usersTab_createUser_userName']."</p></td>
                                <td><input id='user_name_update' type='text' value='".$users_username[$key]."' class='new_user_add' placeholder='".$lang[$lang['set']]['type_usersTab_createUser_userName_placeholder']."' /></td>
                                <td><p style='margin:0;'>".$lang[$lang['set']]['type_usersTab_createUser_password']."</p></td>
                                <td><input id='user_pass_update' type='text' value='' class='new_user_add' placeholder='".$lang[$lang['set']]['type_usersTab_createUser_password_placeholder']."' /></td>                            
                            </tr>
                            <tr>
                                <td><p style='margin:0;'>".$lang[$lang['set']]['type_usersTab_createUser_fullName']."</p></td>
                                <td><input id='user_Fname_update' type='text' value='".$users_fullname[$key]."' class='new_user_add' placeholder='".$lang[$lang['set']]['type_usersTab_createUser_fullName_placeholder']."' /></td>
                                <td><p style='margin:0;'>".$lang[$lang['set']]['type_usersTab_createUser_userMail']."</p></td>
                                <td><input id='user_Email_update' type='text' value='".$users_usermail[$key]."' class='new_user_add' placeholder='".$lang[$lang['set']]['type_usersTab_createUser_userMail_placeholder']."' /></td>                            
                            </tr>                          
                            <tr>
                                <td><p style='margin:0;'>".$lang[$lang['set']]['type_usersTab_createUser_maxSize']."</p></td>
                                <td><select id='user_MaxFsize_update' class='selectBoxNew'>";
                                            $devider = 0.1;
                                            for ($i = 0; $i<10; $i++) {
                                                $byte_size = round($max_size_ge*$devider);
                                                $devider += 0.1;
                                                if ($users_maxsize[$key] == $byte_size) $selected = "selected"; else $selected = "";
                                                echo "<option value='".$byte_size."' ".$selected.">".humanFileSize($byte_size)."</option>";
                                            }
                          echo "</select>                            
                                </td>
                                <td><p style='margin:0;'>".$lang[$lang['set']]['type_usersTab_createUser_maxFiles']."</p></td>
                                <td><select id='user_MaxFnum_update' class='selectBoxNew'>";
                                        for ($i = 0; $i<$max_files_ge; $i++) {
                                            if ($users_maxfiles[$key] == $i+1) $selected = "selected"; else $selected = "";
                                            echo "<option value='".($i+1)."' ".$selected.">".($i+1)."</option>";
                                        }
                              echo "</select>
                                </td>                            
                            </tr>   
                            <tr>";
                                if ($users_active[$key] == 'yes') { $activate_yes = "selected"; $activate_no = ""; } else { $activate_yes = ""; $activate_no = "selected"; }
                            echo "<td><p style='margin:0;'>".$lang[$lang['set']]['type_usersTab_createUser_maxRec']."</p></td>
                                <td><input id='user_MaxRec_update' type='text' value='".$users_maxrec[$key]."' class='new_user_add' placeholder='Max recipients' /></td>
                                <td><p style='margin:0;'>".$lang[$lang['set']]['type_usersTab_manageUser_activation_select']."</p></td>
                                <td>
                                    <select id='user_activate_status' class='selectBoxNew'>
                                        <option value='yes' ".$activate_yes.">".$lang[$lang['set']]['type_usersTab_manageUser_activation_active']."</option>
                                        <option value='no' ".$activate_no.">".$lang[$lang['set']]['type_usersTab_manageUser_activation_inactive']."</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='4' class='center_button'>
                                    <div class='css3button but_submit_update_user' id='but_submit_update_user' rowId='".$users_id[$key]."' style='margin:0px 0px 0px 0px;'>
                                        ".$lang[$lang['set']]['type_button_updateUser_butt_text']."
                                    </div>
                                </td>                            
                            </tr>                           
                        </table>                                
                      </div>";
            echo "</td>";
        echo "</tr>";

        }
    ?>
    </table>

<?php
} else {
    exit;
}