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
    
    //Get excluded:
        $sqlstatus3 = "SELECT * FROM `".$table5."` ORDER BY `when_added` DESC";
        $rs_result3 = mysqli_query($linkos, $sqlstatus3) or die (); 
            while ($idr = mysqli_fetch_array($rs_result3)) {
                $id_ex[]    = $idr['id'];
                $email_ex[] = $idr['email_address'];
                $com_ex[]   = $idr['comment'];
                $time_ex[]  = $idr['when_added'];
            }
            
    //Render Tab Html:
?>    
    <p class='admin_head2'><?php echo $lang[$lang['set']]['type_exclude_addUser_title']; ?></p>
    <table class='storage_table2'>
        <tr>
            <td class='table_head1'><?php echo $lang[$lang['set']]['type_exclude_addUser_email']; ?></td>
            <td class='table_head1'><?php echo $lang[$lang['set']]['type_exclude_addUser_note']; ?></td>
            <td class='table_head1' style='text-align:center;'><?php echo $lang[$lang['set']]['type_exclude_addUser_submit_text']; ?></td>
        </tr>
        <tr>
            <td><input type='text' id='email_ex_input' placeholder='<?php echo $lang[$lang['set']]['type_exclude_addUser_email_placeholder']; ?>' /></td>
            <td><input type='text' id='com_ex_input' placeholder='<?php echo $lang[$lang['set']]['type_exclude_addUser_note_placeholder']; ?>' /></td>
            <td style='text-align:center;' align='center'>
                <div class='css3button remove_but' id='add_ex'>
                    <?php echo $lang[$lang['set']]['type_button_exclude_text']; ?>
                </div>
            </td>
        </tr>
    </table>
    
    <div id='ex_page_error' style='color:red; font-size:0.8em; display:none;'>
        &nbsp;&nbsp;>&nbsp;
        <?php echo $lang[$lang['set']]['type_exclude_error_userEmail']; ?>
    </div>
    
    <p class='admin_head2'>
        <img src='../img/refresh.png' class='refresh_tab' posRe='4' style='width:10px; height:11px; cursor:pointer;' alt='<?php echo $lang[$lang['set']]['type_button_refresh_title']; ?>' title='<?php echo $lang[$lang['set']]['type_button_refresh_title']; ?>' />
        &nbsp;<?php echo $lang[$lang['set']]['type_exclude_display_title']; ?>
    </p>
    <table class='storage_table2'>
        <tr>
            <td class='table_head1'><?php echo $lang[$lang['set']]['type_exclude_tableHeader_userAddress']; ?></td>
            <td class='table_head1'><?php echo $lang[$lang['set']]['type_exclude_tableHeader_adminNote']; ?></td>
            <td class='table_head1'><?php echo $lang[$lang['set']]['type_exclude_tableHeader_excludedDate']; ?></td>
            <td class='table_head1 center_text'><?php echo $lang[$lang['set']]['type_exclude_tableHeader_remove']; ?></td>
        </tr>
        <?php                     
            if (isset($id_ex)) {
                foreach ($id_ex as $key => $value) {
                    echo "<tr><td>".$email_ex[$key]."</td><td>".$com_ex[$key].
                         "</td><td>".$time_ex[$key]."</td><td style='text-align".
                         ":center;' align='center'><div class='remove_but remove_ex_but' ".
                         "id='remove_ex'><img src='../img/glyphicons/png/glyphicons_207".
                         "_remove_2.png' /></div><input type='hidden' id='id_ex' value='".
                         $value."' /></td></tr>";
                }
            }
        ?>   
    </table>
    
<?php
} else {
    exit;
}