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
    
    //Get stats:
        $sqlstatus = "SELECT * FROM `".$table10."` WHERE `id`='1'";
        $rs_result = mysqli_query($linkos, $sqlstatus) or die ( $lang[$lang['set']]['type_db_error']."4568734333" ); 
            while ($idr=mysqli_fetch_array($rs_result)) {
                $counter_files          = $idr['counter_files'];
                $counter_files_user     = $idr['counter_files_user'];
                $counter_size           = $idr['counter_size'];
                $counter_size_user      = $idr['counter_size_user'];
                $counter_deliv          = $idr['counter_deliv'];
                $counter_copy           = $idr['counter_copy'];
                $counter_notify_deliv   = $idr['counter_notify_deliv'];
                $counter_notify_read    = $idr['counter_notify_read'];
                $counter_visit_main     = $idr['counter_visit_main'];
                $counter_visit_down     = $idr['counter_visit_down'];
                $counter_login_user     = $idr['counter_login_user'];
                $counter_attached_mes   = $idr['counter_attached_mes'];
                $last_attached_mes      = $idr['last_attached_mes']; 
                $last_sent              = $idr['last_sent'];  
                $last_sent_user         = $idr['last_sent_user'];  
                $last_deliv             = $idr['last_deliv'];  
                $last_user_login        = $idr['last_user_login'];  
                $last_notify_deliv      = $idr['last_notify_deliv'];  
                $last_notify_read       = $idr['last_notify_read'];  
                $last_admin_login       = $idr['last_admin_login'];  
                $last_clean_up          = $idr['last_clean_up'];  
                $last_visit_main        = $idr['last_visit_main'];  
                $last_visit_down        = $idr['last_visit_down'];  
                $counter_last_cleanup_files = $idr['counter_last_cleanup_files'];  
                $counter_sent           = $idr['counter_sent'];  
                $counter_sent_user      = $idr['counter_sent_user'];  
            } 
    //Render Tab Html:
?>                                           
    <p class='admin_head2'>
        <img src='../img/refresh.png' class='refresh_tab' posRe='9' style='width:10px; height:11px; cursor:pointer;' alt='<?php echo $lang[$lang['set']]['type_button_refresh_title']; ?>' title='<?php echo $lang[$lang['set']]['type_button_refresh_title']; ?>' />
        &nbsp;<?php echo $lang[$lang['set']]['type_stats_allstat_title']; ?>
    </p>             
    <div class='advertise_general add_table_style' style='display:table;'>
        <div style='display:table-row'>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_file_sent' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat1_totSent']; ?></div> 
            <div class='cell' style='display:table-cell'><?php echo $counter_files; ?></div>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_file_sent' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat2_totUserSent']; ?></div>
            <div class='cell' style='display:table-cell'><?php echo $counter_files_user; ?></div>
        </div>
        <div style='display:table-row'>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_file_sent' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat3_totGuestSent']; ?></div> 
            <div class='cell' style='display:table-cell'><?php echo ($counter_files - $counter_files_user); ?></div>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_file_size' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat4_totSize']; ?></div>
            <div class='cell' style='display:table-cell'><?php echo humanFileSize($counter_size,false); ?></div>
        </div>
        <div style='display:table-row'>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_file_size' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat5_totSizeGuest']; ?></div> 
            <div class='cell' style='display:table-cell'><?php echo humanFileSize(($counter_size - $counter_size_user),false); ?></div>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_file_size' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat6_totSizeUsers']; ?></div>
            <div class='cell' style='display:table-cell'><?php echo humanFileSize($counter_size_user,false); ?></div>
        </div>
        <div style='display:table-row'>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_share_tot' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat7_totSharing']; ?></div> 
            <div class='cell' style='display:table-cell'><?php echo $counter_sent; ?></div>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_share_tot' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat8_lastSharing']; ?></div>
            <div class='cell' style='display:table-cell'><?php echo $last_sent; ?></div>
        </div>
        <div style='display:table-row'>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_share_user' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat9_totSharingUser']; ?></div> 
            <div class='cell' style='display:table-cell'><?php echo $counter_sent_user; ?></div>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_share_user' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat10_lastSharingUser']; ?></div>
            <div class='cell' style='display:table-cell'><?php echo $last_sent_user; ?></div>
        </div>                              
        <div style='display:table-row'>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_files_deliv' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat11_filesDeliver']; ?></div> 
            <div class='cell' style='display:table-cell'><?php echo $counter_deliv; ?></div>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_files_deliv' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat12_lastDeliver']; ?></div>
            <div class='cell' style='display:table-cell'><?php echo $last_deliv; ?></div>
        </div>
        <div style='display:table-row'>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_notify_deliv' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat13_notifiedDeliver']; ?></div> 
            <div class='cell' style='display:table-cell'><?php echo $counter_notify_deliv; ?></div>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_notify_deliv' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat14_lastNotifiedDeliver']; ?></div>
            <div class='cell' style='display:table-cell'><?php echo $last_notify_deliv; ?></div>
        </div>
        <div style='display:table-row'>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_notify_read' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat15_notifiedRead']; ?></div> 
            <div class='cell' style='display:table-cell'><?php echo $counter_notify_read; ?></div>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_notify_read' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat16_lastNotifiedRead']; ?></div>
            <div class='cell' style='display:table-cell'><?php echo $last_notify_read; ?></div>
        </div>
        <div style='display:table-row'>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_mes_attach' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat17_mesAttachCount']; ?></div> 
            <div class='cell' style='display:table-cell'><?php echo $counter_attached_mes; ?></div>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_mes_attach' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat18_lastMesAttach']; ?></div>
            <div class='cell' style='display:table-cell'><?php echo $last_attached_mes; ?></div>
        </div>
        <div style='display:table-row'>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_copies' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat19_totCopies']; ?></div> 
            <div class='cell' style='display:table-cell'><?php echo $counter_copy; ?></div>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_admin' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat20_lastAdminLogin']; ?></div>
            <div class='cell' style='display:table-cell'><?php echo $last_admin_login; ?></div>
        </div>
        <div style='display:table-row'>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_logins' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat21_totUsersLogin']; ?></div> 
            <div class='cell' style='display:table-cell'><?php echo $counter_login_user; ?></div>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_logins' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat22_lastUserLogin']; ?></div>
            <div class='cell' style='display:table-cell'><?php echo $last_user_login; ?></div>
        </div>                                
        <div style='display:table-row'>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_mpage' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat23_mainPageVisits']; ?></div> 
            <div class='cell' style='display:table-cell'><?php echo $counter_visit_main; ?></div>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_mpage' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat24_lastMainVisit']; ?></div>
            <div class='cell' style='display:table-cell'><?php echo $last_visit_main; ?></div>
        </div> 
        <div style='display:table-row'>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_dpage' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat25_downPageVisits']; ?></div> 
            <div class='cell' style='display:table-cell'><?php echo $counter_visit_down; ?></div>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_dpage' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat26_lastDownVisit']; ?></div>
            <div class='cell' style='display:table-cell'><?php echo $last_visit_down; ?></div>
        </div> 
        <div style='display:table-row'>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_clean' style='width:10px; height:11px; cursor:pointer;' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat27_filesEarasedLast']; ?></div> 
            <div class='cell' style='display:table-cell'><?php echo $counter_last_cleanup_files; ?></div>
            <div class='cell desc' style='display:table-cell'><img src='../img/empty.png' class='reset_stat' id='e_clean' style='width:10px; height:11px; cursor:pointer; ' />&nbsp;<?php echo $lang[$lang['set']]['type_stats_stat28_lastCleanup']; ?></div>
            <div class='cell' style='display:table-cell'><?php echo $last_clean_up; ?></div>
        </div>                                 
    </div>
    <br />
    <p class='admin_head2'>
        <img src='../img/refresh.png' class='refresh_tab' posRe='9' style='width:10px; height:11px; cursor:pointer;' alt='<?php echo $lang[$lang['set']]['type_button_refresh_title']; ?>' title='<?php echo $lang[$lang['set']]['type_button_refresh_title']; ?>' />
        &nbsp;<?php echo $lang[$lang['set']]['type_stats_chart_title']; ?>
    </p>
    <div id='plot1_stat' style='width:523px; height:180px; margin:0 auto;'><canvas></canvas></div>

<?php
} else {
    exit;
}