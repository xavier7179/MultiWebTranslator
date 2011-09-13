<?php

//require_once('auth.php');
require_once('config.php');

$message=$_POST['new_project_name'];


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

	$query="INSERT INTO `project` (`id`, `parent.message.ID`, `name`) VALUES (NULL, '', '".$message."')";
	$result = mysql_query($query);
	
	if ($result) {
		echo mysql_insert_id();
	}
	else echo "-1";
	

mysql_close($link);



?>