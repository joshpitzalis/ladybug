<?php

//Configuration file for long execution time of large file uploading.
//may not work! depends if server accepts ini_set commands.
//set try to parse to `true` to enable or to `false` to disable

$tryToParse = true;

if($tryToParse) {
    @ini_set('max_execution_time', 900); //seconds
    @ini_set('session.gc_maxlifetime', 900); //seconds
    @ini_set('session.cookie_lifetime', 900); //seconds
    @ini_set('session.cache_expire', 900); //seconds
    @ini_set('memory_limit', '1G'); //G , M 
}
