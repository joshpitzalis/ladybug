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
if ( isset($uname) ) {
    //Render Tab Html:
?>       
    <div class='tab_select' id='general'    tabNum='1'><?php    echo $lang[$lang['set']]['type_tabGeneral_name_text'];     ?></div>
    <div class='tab_select' id='logfiles'   tabNum='2'><?php    echo $lang[$lang['set']]['type_tabLog_name_text'];         ?></div>
    <div class='tab_select' id='searchfile' tabNum='3'><?php    echo $lang[$lang['set']]['type_tabSearch_name_text'];      ?></div>
    <div class='tab_select' id='exclude'    tabNum='4'><?php    echo $lang[$lang['set']]['type_tabExclude_name_text'];     ?></div>
    <br />
    <div class='tab_select' id='blocked'    tabNum='5'><?php    echo $lang[$lang['set']]['type_tabBlocked_name_text'];     ?></div>
    <div class='tab_select' id='storage'    tabNum='6'><?php    echo $lang[$lang['set']]['type_tabStorage_name_text'];     ?></div>
    <div class='tab_select' id='users'      tabNum='7'><?php    echo $lang[$lang['set']]['type_tabUsers_name_text'];       ?></div>
    <div class='tab_select' id='advertise'  tabNum='8'><?php    echo $lang[$lang['set']]['type_tabAdvertise_name_text'];   ?></div>
    <br />
    <div class='tab_select' id='stat'       tabNum='9'><?php    echo $lang[$lang['set']]['type_tabStats_name_text'];       ?></div>

<?php
} else {
    exit;
}