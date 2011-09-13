<?php

//require_once('auth.php');
require_once('config.php');

$message=$_POST['project_id'];


//Connect to mysql server
$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if(!$link) {
	die('Failed to connect to server: ' . mysql_error());
}

//Select database
$db = mysql_select_db(DB_DATABASE);
if(!$db) {
	die("Unable to select database");
}

	$query="DELETE FROM `project` WHERE `id` = ".$message;	
	$result = mysql_query($query);
	
	//echo query;
	

mysql_close($link);



?>