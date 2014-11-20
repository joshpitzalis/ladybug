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
    
    //Get senders:
        $senders = array();
        $sqlstatus3 = "SELECT `sender` FROM `".$table2."` GROUP BY `sender` LIMIT 1000";
        $rs_result3 = mysqli_query($linkos, $sqlstatus3) or die (); 
            while ( $idr = mysqli_fetch_array($rs_result3) ) {
                $senders[] = $idr['sender'];
            }
        echo "<script> $(document).ready(function(){".
             "var senders = $.parseJSON('".json_encode($senders)."');".
             "$( \"#search_mail_input\" ).autocomplete({source:senders});".
             "}); </script>";
        
    //Render Tab Html:
?>                           
    <p class='admin_head2'><?php echo $lang[$lang['set']]['type_searchEmail_main_title']; ?></p>
    <table class='storage_table2'>
        <tr>
            <td><input type='text' id='search_mail_input' placeholder='<?php echo $lang[$lang['set']]['type_searchEmail_input_placeholder']; ?>' /></td>
            <td style='text-align:center;' align='center'>
                <div class='search_but css3button' id='search_user'><?php echo $lang[$lang['set']]['type_button_searchEmail_text']; ?></div>
            </td>
        </tr>
    </table>
    <div id='search_page_error' style='color:red; font-size:0.8em; display:none;'>
        &nbsp;&nbsp;>&nbsp;<?php echo $lang[$lang['set']]['type_searchEmail_error_email']; ?>
    </div>
    <div id='search_page_res_conn' style='position:absolute; display:none; width:100%;' ></div>

<?php
} else {
    exit;
}