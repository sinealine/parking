<?php
ob_start();

date_default_timezone_set('Africa/Kigali');

//PDO Connection 
$db = new PDO('mysql:host=remotemysql.com;dbname=OSXY8nAU20;charset=utf8', 'OSXY8nAU20', 'ZCpHE6SYaZ');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->query('SET SESSION SQL_BIG_SELECTS=1');

//2and PDO CONNECTION

$db_username = 'OSXY8nAU20';
$db_password = 'ZCpHE6SYaZ';
$conn = new PDO('mysql:host=remotemysql.com;dbname=OSXY8nAU20', $db_username, $db_password);
if (!$conn) {
	die("Fatal Error: Connection Failed!");
}

ob_end_flush();