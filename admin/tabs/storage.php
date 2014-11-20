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
    
    //Scan Files directory:
        $scanned_directory = array_diff(scandir($files_path), array('..', '.'));
                    
        $total_files                        = array();
        $total_files['total_files_all']     = count($scanned_directory);
        $total_files['total_files_size']    = 1;
                    
        foreach($scanned_directory as $key => $value ) {
        
            // file type
            $type = explode('.', $value);
            $type = strtolower($type[count($type)-1]);
            
            // file size
            $size = filesize($files_path.'/'.$value);
                        
            if (isset($total_files[$type])) { 
                $total_files[$type]['count']++; 
                $total_files[$type]['size'] += $size;
            
            } else { 
            
                $total_files[$type] = array(
                     'count' => 0
                    ,'size'  => 0
                ); 
                
                $total_files[$type]['count']++; 
                $total_files[$type]['size'] += $size; 
            }		
            
            $total_files['total_files_size'] += $size;
            
        }
        
    //Render Tab Html:
?>                           
                
    <p class='admin_head2'><?php echo $lang[$lang['set']]['type_storageTab_cleanup_title']; ?></p>
    <!--Clean Up-->
    <div class='error_catcher2' id='errorMessageOfCleanUp' style='display:none'>
        <div class='closeMessageVal2'></div>
        <?php echo $lang[$lang['set']]['type_storageTab_cleanup_error']; ?>
    </div>
    <div id='cleanUpSetParams' style='margin:0'>
        <table border="0" class='table_inner_tab_con'>
            <tr>
                <td>
                    <p style='margin:0;'><?php echo $lang[$lang['set']]['type_storageTab_cleanup_input_label']; ?></p>
                </td>
                <td>
                    <select id="selectWeeksInterval" class="selectBoxNew smaller_selectBoxNew">
                        <option value='1'><?php echo $lang[$lang['set']]['type_storageTab_cleanup_1week']; ?></option>
                        <option value='2'><?php echo $lang[$lang['set']]['type_storageTab_cleanup_2week']; ?></option>
                        <option value='3'><?php echo $lang[$lang['set']]['type_storageTab_cleanup_3week']; ?></option>
                        <option value='4'><?php echo $lang[$lang['set']]['type_storageTab_cleanup_4week']; ?></option>
                    </select>
                </td>
                <td>
                    <div class="css3button cleanUpButton" id="but_cleanUp" ><?php echo $lang[$lang['set']]['type_button_runCleanup_title']; ?></div>                            
                </td>
            </tr>
        </table>
    </div>
    <div id='runningCleanUp' style='text-align:center; display:none'>
        <span class='progressClean'><?php echo $lang[$lang['set']]['type_storageTab_cleanup_processing']; ?></span>
        <br />
        <img src='../img/bar.gif' />
    </div>                    
    <!--END Clean Up-->  
    
    <!--Storage Summary -->
    <p class='admin_head2'>
        <img src='../img/refresh.png' class='refresh_tab' posRe='6' style='width:10px; height:11px; cursor:pointer;' alt='<?php echo $lang[$lang['set']]['type_button_refresh_title']; ?>' title='<?php echo $lang[$lang['set']]['type_button_refresh_title']; ?>' />
        &nbsp;<?php echo $lang[$lang['set']]['type_storageTab_summary_title']; ?>
    </p>
    <table class='storage_table1'>
        <tr>
            <td class='table_head1' style='text-align: center;'><?php echo $lang[$lang['set']]['type_storageTab_summary_totFilesCount']; ?></td>
            <td class='table_head1' style='text-align: center;'><?php echo $lang[$lang['set']]['type_storageTab_summary_totFilesSize']; ?></td>
        </tr>
        <tr>
            <td style='text-align: center;' ><?php echo $total_files['total_files_all']; ?></td>
            <td style='text-align: center;'><?php echo humanFileSize($total_files['total_files_size']); ?></td>
        </tr>
    </table>
    <!--END Storage Summary -->
    
    <!--Storage Plot -->
    <p class='admin_head2'>
        <img src='../img/refresh.png' class='refresh_tab' posRe='6' style='width:10px; height:11px; cursor:pointer;' alt='<?php echo $lang[$lang['set']]['type_button_refresh_title']; ?>' title='<?php echo $lang[$lang['set']]['type_button_refresh_title']; ?>' />
        &nbsp;<?php echo $lang[$lang['set']]['type_storageTab_lastweek_title']; ?>
    </p>
    <div id='plot2_storage' style='width:523px; height:180px; margin:0 auto;'><canvas></canvas></div>
    <!--END Storage Plot -->
    
    <!--Files Details and groups-->
    <p class='admin_head2'>
        <img src='../img/refresh.png' class='refresh_tab' posRe='6' style='width:10px; height:11px; cursor:pointer;' alt='<?php echo $lang[$lang['set']]['type_button_refresh_title']; ?>' title='<?php echo $lang[$lang['set']]['type_button_refresh_title']; ?>' />
        &nbsp;<?php echo $lang[$lang['set']]['type_storageTab_typessize_title']; ?>
    </p>
    <table class='storage_table2'>
        <tr>
            <td class='table_head1' style='text-align: center;'><?php echo $lang[$lang['set']]['type_storageTab_disTable_fileType']; ?></td>
            <td class='table_head1' style='text-align: center;'><?php echo $lang[$lang['set']]['type_storageTab_disTable_fileCount']; ?></td>
            <td class='table_head1' style='text-align: center;'><?php echo $lang[$lang['set']]['type_storageTab_disTable_fileSize']; ?></td>
            <td class='table_head1' style='text-align: center;'><?php echo $lang[$lang['set']]['type_storageTab_disTable_filePerc']; ?></td>
        </tr>
    <?php    
        foreach ($total_files as $key => $value) {
            if ($key!='total_files_all' && $key!='total_files_size') {
                echo "<tr><td style='text-align: center;'>".$key."</td><td style='text-align: center;'>".$value['count']."</td><td style='text-align: center;'>".
                     humanFileSize($value['size'])."</td><td style='text-align: center;'>".
                     round(($value['size']/$total_files['total_files_size']*100), 1).
                     "%</td></tr>";
            }
        }
    ?>   
    </table>

<?php
} else {
    exit;
}