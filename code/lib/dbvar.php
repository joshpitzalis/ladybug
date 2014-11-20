<?php
if ($_SERVER["HTTP_HOST"] === 'useladybug.com') {
    $database='ladybug';
	$host='ladybug.useladybug.com';
	$data_username='ladybugdb';
	$data_password='My9wUe5twyn';
} else if ($_SERVER["HTTP_HOST"] === 'localhost') {
    $user_name = "root";
    $password = "root";
    $database = "takethat";
    $server = "localhost";
}
?>