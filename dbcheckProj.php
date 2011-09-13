<?php

//require_once('auth.php');
require_once('config.php');

$user_id=$_POST['user_id'];
$stato=$_POST['state'];
$proj_id=$_POST['proj_id'];

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

if ($stato==0){
	$query="DELETE FROM `assign` WHERE `membersID` = '".$user_id."' AND `projectID` = ".$proj_id;
	$result = mysql_query($query);
	
	
}else{
	$query="INSERT INTO `assign` ( `id` , `membersID` ,`projectID` , `languageID` , `name` )
	VALUES ( NULL , '".$user_id."', '".$proj_id."', '0', '')";
	$result = mysql_query($query);
}




mysql_close($link);



?>