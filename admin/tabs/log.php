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
    
    $now_date = new DateTime();
    $last_week = new DateTime();
    $last_week->modify('-1 week');
?>                           
    <p class='admin_head2'><?php echo $lang[$lang['set']]['type_log_main_title']; ?></p>
    <table class='storage_table2'>                   
        <tr>
            <td>
                <?php echo $lang[$lang['set']]['type_log_from_input_title']; ?>&nbsp;
                <input type='text' id='search_start_date' value='<?php echo $last_week->format('Y-m-d'); ?>' />
            </td>
            <td>
                &nbsp;&nbsp;<?php echo $lang[$lang['set']]['type_log_to_input_title']; ?>&nbsp;
                <input type='text' id='search_end_date' value='<?php echo $now_date->format('Y-m-d'); ?>' />
            </td>
            <td style='text-align:center;' align='center'>
                <div class='search_but css3button' id='search_log'><?php echo $lang[$lang['set']]['type_button_searchLog_text']; ?></div>
            </td>
        </tr>                    
    </table>
    <div id='log_page_error' style='color:red; font-size:0.8em; display:none;'>
        &nbsp;&nbsp;>&nbsp;<?php echo $lang[$lang['set']]['type_log_error_dates']; ?>
    </div>
    <div id='log_page_res_conn' style='position:absolute; display:none; width:100%;' ></div>

<?php
} else {
    exit;
}