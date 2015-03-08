<?php
//Turning off error reporting
error_reporting(0);

$mysql = array(
	/*
	|----------------------------------------------------------------------
	| Your MySql host address Eg: example.com or you can use localhost
	|----------------------------------------------------------------------
	*/
	"host" => "#db_host#",
	
	/*
	|----------------------------------------------------------------------
	| Your MySql username to login to your MySql database
	|----------------------------------------------------------------------
	*/
	"user" => "#db_user#",
	
	/*
	|----------------------------------------------------------------------
	| Your MySql password to login to your MySql database
	|----------------------------------------------------------------------
	*/
	"pass" => "#db_pass#", 
	
	/*
	|----------------------------------------------------------------------
	| Your MySql database (You need to create a database by hand the installation only creates tables IN the database)
	|----------------------------------------------------------------------
	*/
	"db" => "#db_name#",
);

/*
!! Do NOT change anything below this line if you don't know what you're doing !!
*/
$mysqli = new mysqli($mysql['host'], $mysql['user'], $mysql['pass'], $mysql['db']);
?>