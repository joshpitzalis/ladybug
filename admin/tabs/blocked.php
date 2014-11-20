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

    //Get Blocked:
        $sqlstatus4 = "SELECT * FROM `".$table3."` ORDER BY `when_blocked` DESC";
        $rs_result4 = mysqli_query($linkos, $sqlstatus4) or die (); 
        while ($idr = mysqli_fetch_array($rs_result4)) {
            $id_block[]     = $idr['id'];
            $ip_block[]     = $idr['ip_user'];
            $ua_block[]     = $idr['user_agent'];
            $time_block[]   = $idr['when_blocked'];
        }

    //Render Tab Html:
?>                           
    <p class='admin_head2'>
        <img src='../img/refresh.png' class='refresh_tab' posRe='5' style='width:10px; height:11px; cursor:pointer;' alt='<?php echo $lang[$lang['set']]['type_button_refresh_title']; ?>' title='<?php echo $lang[$lang['set']]['type_button_refresh_title']; ?>' />
        &nbsp;<?php echo $lang[$lang['set']]['type_blocked_main_title']; ?>
    </p>
    <table class='storage_table2'>
        <tr>
            <td class='table_head1'><?php echo $lang[$lang['set']]['type_blocked_tableHeader_userIP']; ?></td>
            <td class='table_head1'><?php echo $lang[$lang['set']]['type_blocked_tableHeader_userAgent']; ?></td>
            <td class='table_head1'><?php echo $lang[$lang['set']]['type_blocked_tableHeader_blockingDate']; ?></td>
            <td class='table_head1' style='text-align:center;'><?php echo $lang[$lang['set']]['type_blocked_tableHeader_remove']; ?></td>
        </tr>
    <?php    
        if (isset($id_block)) {
            foreach ($id_block as $key => $value) {
                echo "<tr><td>".$ip_block[$key]."</td><td><span alt='".
                     $ua_block[$key]."' title='".$ua_block[$key]."'>".
                     substr($ua_block[$key],0,30)."<span></td><td>".
                     $time_block[$key]."</td><td style='text-align:center;' align='".
                     "center'><div class='remove_but remove_block_but' id='remove_bl".
                     "ocked'><img src='../img/glyphicons/png/glyphicons_207_remove_2".
                     ".png' /></div><input type='hidden' id='id_block' value='".
                     $value."' /></td></tr>";
            }
        }
    ?>    
    </table>
    
<?php
} else {
    exit;
}