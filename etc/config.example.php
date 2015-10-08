<?php

$ip=$_SERVER['REMOTE_ADDR'];
$localhost = ($ip == '::1') ? true : false;

if (!$localhost) {
	$client_id = 'google api client id';
	$client_secret = 'google api secret key';
	$redirect_uri = 'redirect uri';
} else {
	$client_id = 'google api client id';
	$client_secret = 'google api secret key';
	$redirect_uri = 'redirect uri';
}

if (!$localhost) {
	$conn = mysqli_connect('hostname', 'db user id', 'db user password', 'db name');
} else {
	$conn = mysqli_connect('hostname', 'db user id', 'db user password', 'db name'); 
}

$adminEmail = 'admin email';
$adminPassword = 'or admin password';

?>