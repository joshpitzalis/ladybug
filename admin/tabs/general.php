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

/*********************  LOAD CURRENT GENERAL SETTINGS  ************************/                   
//current settings
    $sqlstatus2 = "SELECT * FROM `".$table1."` WHERE `id`='1'";
    $rs_result2 = mysqli_query($linkos, $sqlstatus2) or die ();
    while ( $idr = mysqli_fetch_array($rs_result2) ) {
        $id_ge          = $idr['id'];
        $user_ge        = $idr['db_user'];
        $pass_ge        = $idr['db_password'];
        $max_files_ge   = $idr['maxfiles'];
        $max_size_ge    = $idr['maxfile_size'];
        $max_rec_ge     = $idr['maxrecipients'];
        $brand_ge       = $idr['brand_name'];
        $types_ge       = $idr['accept_types'];
        $mail_ge        = $idr['server_mail'];
        $folder_ge      = $idr['files_folder'];
        $title_rec_ge   = $idr['e_auto_title'];
        $body_rec_ge    = $idr['e_auto_body'];
        $title_copy_ge  = $idr['e_auto_title_copy'];
        $body_copy_ge   = $idr['e_auto_body_copy'];
        $users_mode     = $idr['users_mode'];
        $theme_use      = $idr['theme'];
        $include_miles  = $idr['include_miles'];
    }   
    
//which file types groups are set?		
    $fileTypes_check = array(
        'Text'          =>'',
        'Data'          =>'',
        'Audio'         =>'',
        'Video'         =>'',
        'eBook'         =>'',
        'image3d'       =>'',
        'Raster'        =>'',
        'Vector'        =>'',
        'Camera'        =>'',
        'Layout'        =>'',
        'Spreadsheet'   =>'',
        'Database'      =>'',
        'Executable'    =>'',
        'Game'          =>'',
        'CAD'           =>'',
        'GIS'           =>'',
        'Web'           =>'',
        'Plugin'        =>'',
        'Font'          =>'',
        'System'        =>'',
        'Settings'      =>'',
        'Encoded'       =>'',
        'Compressed'    =>'',
        'Disk'          =>'',
        'Developer'     =>'',
        'Backup'        =>'',
        'Misc'		    =>''
    );		

    $fileset = explode(',', $types_ge);

//filter groups:
    foreach ($fileset as $key => $value) { 
        foreach ($fileTypes as $types_r => $values_r) {
            if (in_array($value,$values_r)) 
                $fileTypes_check[$types_r] = 'CHECKED';
        }
    }

//Render Tab Html:
?>    
    <p class='admin_head2'>
        <?php echo $lang[$lang['set']]['type_settingsGen_main_title']; ?>
    </p>                       
    <table class='storage_table3'>
        
    <!-- Theme Select -->
        <tr>
            <td colspan='2' class='table_head1'>
                <?php echo $lang[$lang['set']]['type_settingsGen_appTheme_title']; ?>
                <div class='button_save_ge' id='theme_s'><?php echo $lang[$lang['set']]['type_settingsGen_inline_save']; ?></div>
            </td>
        </tr>
        <tr>
            <td>
                <select id='theme_select' class='selectBoxNew larger_selectBoxNew'>
                    <option value='silverStyle' <?php if ($theme_use == "silver") echo " selected"; ?>>Silver</option>
                    <option value='custom' <?php if ($theme_use == "custom") echo " selected"; ?>>Custom</option>
                </select>
                <br />
                <div class='error_page_ge' style='color:red; font-size:0.8em; display:none;'>
                    &nbsp;&nbsp;>&nbsp;<?php echo $lang[$lang['set']]['type_settingsGen_valError1']; ?>
                </div>
            </td>
            <td class='help_td_ge'></td>
        </tr>
        
    <!-- Admin Set -->
        <tr>
            <td colspan='2' class='table_head1'>
                <?php echo $lang[$lang['set']]['type_settingsGen_admin_title']; ?>
                <div class='button_save_ge' id='admin_change'>
                    <?php echo $lang[$lang['set']]['type_settingsGen_inline_save']; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <label  for="general_userName">
                    <?php echo $lang[$lang['set']]['type_settingsGen_username_input_title']; ?>
                    <span style='color:blue; font-size:0.8em; font-weight:bold;'>
                        <?php echo $lang[$lang['set']]['type_settingsGen_username_input_maxChars']; ?>
                    </span>
                </label>
                <input id='general_userName' type='text' value='<?php echo $user_ge; ?>' placeholder='<?php echo $lang[$lang['set']]['type_settingsGen_username_input_placeholder']; ?>' />
            </td>

            <td>
                <label  for="general_userPass">
                    <?php echo $lang[$lang['set']]['type_settingsGen_password_input_title']; ?>
                    <span style='color:blue; font-size:0.8em; font-weight:bold;'>
                        <?php echo $lang[$lang['set']]['type_settingsGen_password_input_maxChars']; ?>
                    </span>
                </label>
                <input id='general_userPass' type='password' value='' placeholder='<?php echo $lang[$lang['set']]['type_settingsGen_password_input_placeholder']; ?>' />
            </td>                       
        </tr>
        <tr>
            <td colspan='2'>
                <div class='error_page_ge' style='color:red; font-size:0.8em; display:none;'>
                    &nbsp;&nbsp;>&nbsp;<?php echo $lang[$lang['set']]['type_settingsGen_valError2']; ?>
                </div>
            </td>
        </tr>
        
    <!-- Barnd Set -->
        <tr>
            <td colspan='2' class='table_head1'>
                <?php echo $lang[$lang['set']]['type_settingsGen_brand_title']; ?>
                <div class='button_save_ge' id='brand_s'>
                    <?php echo $lang[$lang['set']]['type_settingsGen_inline_save']; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <input id='general_brand' type='text' value='<?php echo $brand_ge; ?>' />
                <br />
                <div class='error_page_ge' style='color:red; font-size:0.8em; display:none;'>
                    &nbsp;&nbsp;>&nbsp;<?php echo $lang[$lang['set']]['type_settingsGen_valError1']; ?>
                </div>
            </td>
            <td class='help_td_ge'></td>
        </tr>
        
    <!-- soFar Set -->
        <tr>
            <td colspan='2' class='table_head1'>
                <?php echo $lang[$lang['set']]['type_settingsGen_soFar_title']; ?>
                <div class='button_save_ge' id='sofar_s'>
                    <?php echo $lang[$lang['set']]['type_settingsGen_inline_save']; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <select id='sofar_select' class='selectBoxNew larger_selectBoxNew'>
                    <option value='1' <?php if ($include_miles) echo " selected"; ?>><?php echo $lang[$lang['set']]['type_button_enable_text']; ?></option>
                    <option value='0' <?php if (!$include_miles) echo " selected"; ?>><?php echo $lang[$lang['set']]['type_button_disable_text']; ?></option>
                </select>
                <br />
                <div class='error_page_ge' style='color:red; font-size:0.8em; display:none;'>
                    &nbsp;&nbsp;>&nbsp;<?php echo $lang[$lang['set']]['type_settingsGen_valError2']; ?>
                </div>
            </td>
            <td class='help_td_ge'></td>
        </tr>  
        
    <!-- Max Files Set -->
        <tr>
            <td colspan='2' class='table_head1'>
                <?php echo $lang[$lang['set']]['type_settingsGen_maxFiles_title']; ?>
                <div class='button_save_ge' id='max_files_s'>
                    <?php echo $lang[$lang['set']]['type_settingsGen_inline_save']; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <input id='general_max_files' type='text' value='<?php echo $max_files_ge; ?>' />
                <div class='error_page_ge' style='color:red; font-size:0.8em; display:none;'>
                    &nbsp;&nbsp;>&nbsp;<?php echo $lang[$lang['set']]['type_settingsGen_valError1']; ?>
                </div>
            </td>
            <td class='help_td_ge'>
                <?php echo $lang[$lang['set']]['type_settingsGen_maxFiles_serverRestrict'].SYS_MAX_UPLOADS; ?>
            </td>
        </tr>
        
    <!-- Max Files Size Set -->
        <tr>
            <td colspan='2' class='table_head1'>
                <?php echo $lang[$lang['set']]['type_settingsGen_maxSize_title']; ?>
                <div class='button_save_ge' id='max_size_s'>
                    <?php echo $lang[$lang['set']]['type_settingsGen_inline_save']; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <input id='general_max_file_size' type='text' value='<?php echo $max_size_ge; ?>' />
                <div class='error_page_ge' style='color:red; font-size:0.8em; display:none;'>
                    &nbsp;&nbsp;>&nbsp;<?php echo $lang[$lang['set']]['type_settingsGen_valError1']; ?>
                </div>
            </td>
            <td class='help_td_ge'>
                <?php echo $lang[$lang['set']]['type_settingsGen_maxSize_serverRestrict_single'].SYS_MAX_FILESIZE; ?>
                <br/>
                <?php echo $lang[$lang['set']]['type_settingsGen_maxSize_serverRestrict_post'].SYS_MAX_POST_SIZE; ?>
                <br />
                <?php echo $lang[$lang['set']]['type_settingsGen_maxSize_serverRestrict_time'].SYS_MAX_INPUT_TIME.' sec'; ?>
            </td>
        </tr>
        
    <!-- Files Types Set -->
        <tr>
            <td colspan='2' class='table_head1'>
                <?php echo $lang[$lang['set']]['type_settingsGen_types_title']; ?>
                <div class='button_save_ge' id='types_s'>
                    <?php echo $lang[$lang['set']]['type_settingsGen_inline_save']; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan='2'>
                <div class='error_page_ge' style='color:red; font-size:0.8em; display:none;'>
                    &nbsp;&nbsp;>&nbsp;<?php echo $lang[$lang['set']]['type_settingsGen_valError1']; ?>
                </div>										
                <table class='file_type_table' cellpadding='0' cellspacing='0'>
                    <tr>
                        <td><input class='allowed_type_files css-checkbox' id='1' type='checkbox' value='Text' <?php echo $fileTypes_check['Text']; ?>><label for="1" class="css-label dec_font" title='doc,docx,log,msg,odt,pages,rtf,tex,txt,wpd,wps'>Text</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='2' type='checkbox' value='Data' <?php echo $fileTypes_check['Data']; ?>><label for="2" class="css-label dec_font" title='csv,dat,gbr,ged,ibooks,key,keychain,pps,ppt,pptx,sdf,tar,tax2012,vcf,xml'>Data</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='3' type='checkbox' value='Audio' <?php echo $fileTypes_check['Audio']; ?>><label for="3" class="css-label dec_font" title='aif,iff,m3u,m4a,mid,mp3,mpa,ra,wav,wma'>Audio</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='4' type='checkbox' value='Video' <?php echo $fileTypes_check['Video']; ?>><label for="4" class="css-label dec_font" title='3g2,3gp,asf,asx,avi,flv,m4v,mov,mp4,mpg,rm,srt,swf,vob,wmv'>Video</label></td>
                    </tr>
                    <tr>
                        <td><input class='allowed_type_files css-checkbox' id='5' type='checkbox' value='eBook' <?php echo $fileTypes_check['eBook']; ?>><label for="5" class="css-label dec_font" title='acsm,aep,apnx,ava,azw,azw1,azw3,azw4,bkk,bpnueb,cbc,ceb,dnl,ebk,edn,epub,etd,fb2,html0,htmlz,htxt,htz4,htz5,koob,lit,lrf,lrs,lrx,mart,mbp,mobi,ncx,oeb,opf,pef,phl,pml,pmlz,pobi,prc,qmk,rzb,rzs,tcr,tk3,tpz,tr,tr3,vbk,webz,ybk'>eBook</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='6' type='checkbox' value='image3d' <?php echo $fileTypes_check['image3d']; ?>><label for="6" class="css-label dec_font" title='3dm,3ds,max,obj'>3D Image</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='7' type='checkbox' value='Raster' <?php echo $fileTypes_check['Raster']; ?>><label for="7" class="css-label dec_font" title='bmp,dds,gif,jpg,png,psd,pspimage,tga,thm,tif,tiff,yuv'>Raster Image</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='8' type='checkbox' value='Vector' <?php echo $fileTypes_check['Vector']; ?>><label for="8" class="css-label dec_font" title='ai,eps,ps,svg'>Vector Image</label></td>
                    </tr>
                    <tr>
                        <td><input class='allowed_type_files css-checkbox' id='9' type='checkbox' value='Camera' <?php echo $fileTypes_check['Camera']; ?>><label for="9" class="css-label dec_font" title='3fr,ari,arw,bay,cr2,crw,dcr,dng,eip,erf,fff,iiq,k25,kdc,mef,mos,mrw,nef,nrw,orf,pef,raf,raw,rw2,rwl,rwz,sr2,srf,srw,x3f'>Camera Raw</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='10' type='checkbox' value='Layout' <?php echo $fileTypes_check['Layout']; ?>><label for="10" class="css-label dec_font" title='indd,pct,pdf'>Page Layout</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='11' type='checkbox' value='Spreadsheet' <?php echo $fileTypes_check['Spreadsheet']; ?>><label for="11" class="css-label dec_font" title='xlr,xls,xlsx'>Spreadsheet</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='12' type='checkbox' value='Database' <?php echo $fileTypes_check['Database']; ?>><label for="12" class="css-label dec_font" title='accdb,db,dbf,mdb,pdb,sql'>Database</label></td>
                    </tr>
                    <tr>
                        <td><input class='allowed_type_files css-checkbox' id='13' type='checkbox' value='Executable' <?php echo $fileTypes_check['Executable']; ?>><label for="13" class="css-label dec_font" title='apk,app,bat,cgi,com,exe,gadget,jar,pif,vb,wsf'>Executable</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='14' type='checkbox' value='Game' <?php echo $fileTypes_check['Game']; ?>><label for="14" class="css-label dec_font" title='dem,gam,nes,rom,sav'>Game</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='15' type='checkbox' value='CAD' <?php echo $fileTypes_check['CAD']; ?>><label for="15" class="css-label dec_font" title='dwg,dxf'>CAD</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='16' type='checkbox' value='GIS' <?php echo $fileTypes_check['GIS']; ?>><label for="16" class="css-label dec_font" title='gpx,kml,kmz'>GIS</label></td>
                    </tr>
                    <tr>
                        <td><input class='allowed_type_files css-checkbox' id='17' type='checkbox' value='Web' <?php echo $fileTypes_check['Web']; ?>><label for="17" class="css-label dec_font" title='asp,aspx,cer,cfm,csr,css,htm,html,js,jsp,php,rss,xhtml'>Web</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='18' type='checkbox' value='Plugin' <?php echo $fileTypes_check['Plugin']; ?>><label for="18" class="css-label dec_font" title='crx,plugin'>Plugin</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='19' type='checkbox' value='Font' <?php echo $fileTypes_check['Font']; ?>><label for="19" class="css-label dec_font" title='fnt,fon,otf,ttf'>Font</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='20' type='checkbox' value='System' <?php echo $fileTypes_check['System']; ?>><label for="20" class="css-label dec_font" title='cab,cpl,cur,deskthemepack,dll,dmp,drv,icns,ico,lnk,sys'>System</label></td>
                    </tr>
                    <tr>
                        <td><input class='allowed_type_files css-checkbox' id='21' type='checkbox' value='Settings' <?php echo $fileTypes_check['Settings']; ?>><label for="21" class="css-label dec_font" title='cfg,ini,prf'>Settings</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='22' type='checkbox' value='Encoded' <?php echo $fileTypes_check['Encoded']; ?>><label for="22" class="css-label dec_font" title='hqx,mim,uue'>Encoded</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='23' type='checkbox' value='Compressed' <?php echo $fileTypes_check['Compressed']; ?>><label for="23" class="css-label dec_font"  title='7z,cbr,deb,gz,pkg,rar,rpm,sitx,tar,gz,zip,zipx'>Compressed</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='24' type='checkbox' value='Disk' <?php echo $fileTypes_check['Disk']; ?>><label for="24" class="css-label dec_font" title='bin,cue,dmg,iso,mdf,toast,vcd'>Disk Image</label></td>
                    </tr>
                    <tr>
                        <td><input class='allowed_type_files css-checkbox' id='25' type='checkbox' value='Developer' <?php echo $fileTypes_check['Developer']; ?>><label for="25" class="css-label dec_font" title='c,class,cpp,cs,dtd,fla,h,java,lua,m,pl,py,sh,sln,vcxproj,xcodeproj'>Developer</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='26' type='checkbox' value='Backup' <?php echo $fileTypes_check['Backup']; ?>><label for="26" class="css-label dec_font" title='bak,tmp'>Backup</label></td>
                        <td><input class='allowed_type_files css-checkbox' id='27' type='checkbox' value='Misc' <?php echo $fileTypes_check['Misc']; ?>><label for="27" class="css-label dec_font" title='crdownload,ics,msi,part,torrent'>Misc</label></td>
                        <td></td>
                    </tr>														
                </table>
            </td>
        </tr>
        
    <!-- Max recipients Set -->        
        <tr>
            <td colspan='2' class='table_head1'>
                <?php echo $lang[$lang['set']]['type_settingsGen_maxRec_title']; ?>
                <div class='button_save_ge' id='max_rec_s'>
                    <?php echo $lang[$lang['set']]['type_settingsGen_inline_save']; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <input id='general_max_rec' type='text' value='<?php echo $max_rec_ge; ?>' />
                <div class='error_page_ge' style='color:red; font-size:0.8em; display:none;'>
                    &nbsp;&nbsp;>&nbsp;<?php echo $lang[$lang['set']]['type_settingsGen_valError1']; ?>
                </div>
            </td>
            <td class='help_td_ge'>
                <?php echo $lang[$lang['set']]['type_settingsGen_maxRec_serverRestrict'].(SYS_MAX_INPUT_VARS-SYS_MAX_UPLOADS-6); ?>
            </td>
        </tr>
        
    <!-- Server Mail Address Set --> 
        <tr>
            <td colspan='2' class='table_head1'>
                <?php echo $lang[$lang['set']]['type_settingsGen_serverMail_title']; ?>
                <div class='button_save_ge' id='max_email_s'>
                    <?php echo $lang[$lang['set']]['type_settingsGen_inline_save']; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <input id='general_email' type='text' value='<?php echo $mail_ge; ?>' />
                <div class='error_page_ge' style='color:red; font-size:0.8em; display:none;'>
                    &nbsp;&nbsp;>&nbsp;<?php echo $lang[$lang['set']]['type_settingsGen_valError1']; ?>
                </div>
            </td>
            <td class='help_td_ge'>
                <?php echo $lang[$lang['set']]['type_settingsGen_folder_serverEmail_title'].SERVERHOST; ?>
            </td>
        </tr>

    <!-- Server Folder Path Set -->         
        <tr>
            <td colspan='2' class='table_head1'>
                <?php echo $lang[$lang['set']]['type_settingsGen_folder_title']; ?>
                <div class='button_save_ge' id='folder_s'>
                    <?php echo $lang[$lang['set']]['type_settingsGen_inline_save']; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <input id='general_folder' type='text' value='<?php echo $folder_ge; ?>' />
                <div class='error_page_ge' style='color:red; font-size:0.8em; display:none;'>
                    &nbsp;&nbsp;>&nbsp;<?php echo $lang[$lang['set']]['type_settingsGen_valError1']; ?>
                </div>
            </td>
            <td class='help_td_ge'>
                <?php echo $lang[$lang['set']]['type_settingsGen_folder_sidehelp_note']; ?>
            </td>
        </tr>
        
    <!-- Message Struct rec -->
        <tr>
            <td colspan='2' class='table_head1'>
                <?php echo $lang[$lang['set']]['type_settingsGen_mesRec_title']; ?>
                <div class='button_save_ge' id='mes_rec_s'>
                    <?php echo $lang[$lang['set']]['type_settingsGen_inline_save']; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <input id='general_mes_rec_title' type='text' value='<?php echo $title_rec_ge; ?>' />
                <br/>
                <textarea class='css-textarea' id='general_mes_rec_body'><?php echo $body_rec_ge; ?></textarea>
                <div class='error_page_ge' style='color:red; font-size:0.8em; display:none;'>
                    &nbsp;&nbsp;>&nbsp;<?php echo $lang[$lang['set']]['type_settingsGen_valError2']; ?>
                </div>
            </td>
            <td class='help_td_ge'>
                <?php echo $lang[$lang['set']]['type_settingsGen_Email_head_title']; ?>
                <br /><br />
                <?php echo $lang[$lang['set']]['type_settingsGen_Email_body_title']; ?>
            </td>
        </tr>

    <!-- Message Struct sender -->
        <tr>
            <td colspan='2' class='table_head1'>
                <?php echo $lang[$lang['set']]['type_settingsGen_mesSender_title']; ?>
                <div class='button_save_ge' id='mes_cop_s'>
                    <?php echo $lang[$lang['set']]['type_settingsGen_inline_save']; ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <input id='general_mes_cop_title' type='text' value='<?php echo $title_copy_ge; ?>' />
                <br/>
                <textarea class='css-textarea' id='general_mes_cop_body'><?php echo $body_copy_ge; ?></textarea>
                <div class='error_page_ge' style='color:red; font-size:0.8em; display:none;'>
                    &nbsp;&nbsp;>&nbsp;<?php echo $lang[$lang['set']]['type_settingsGen_valError2']; ?>
                </div>
            </td>
            <td class='help_td_ge'>
                <?php echo $lang[$lang['set']]['type_settingsGen_Email_head_title']; ?>
                <br /><br />
                <?php echo $lang[$lang['set']]['type_settingsGen_Email_body_title']; ?>
            </td>
        </tr>
    </table>
                
<?php
} else {
    exit;
}