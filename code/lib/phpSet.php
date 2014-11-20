<?php
/******************************************************************************/
// Created by: shlomo hassid.
// Release Version : 3.0
// Creation Date: 14/08/2013
// Updated To V.2.X : 05/01/2014
// Updated To V.3.0 : 14/08/2014
// Mail: Shlomohassid@gmail.com
// require: jquery latest ( best: 10.1 ) version SQL 4+ PHP 5.3+ .	
// Copyright 2014, shlomo hassid.
/******************************************************************************/

//Configuration file for long execution time of large file uploading.
//may not work! depends if server accepts ini_set commands.
//set try to parse to `true` to enable or to `false` to disable

$tryToParse = false;

if($tryToParse) {
    @ini_set('max_execution_time', 900); //seconds
    @ini_set('session.gc_maxlifetime', 900); //seconds
    @ini_set('session.cookie_lifetime', 900); //seconds
    @ini_set('session.cache_expire', 900); //seconds
    @ini_set('memory_limit', '1G'); //G , M 
}
