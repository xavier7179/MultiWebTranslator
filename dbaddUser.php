<?php
require_once('config.php');

if ( isset($_POST['firstname']) && 
	isset($_POST['lastname']) && 
	isset($_POST['login']) && 
	isset($_POST['passwd']) && 
	isset($_POST['level']) && 
	isset($_POST['language']) ){

	$firstname=$_POST['firstname'];
	$lastname=$_POST['lastname'];
	$login=$_POST['login'];
	$passwd=$_POST['passwd'];
	$level=$_POST['level'];
	$language=$_POST['language'];

	$qry="INSERT INTO  `translation`.`members` ( `member_id`, `firstname`, `lastname`, `login`, `passwd`, `level`, `language` )
			VALUES ( NULL ,  '$firstname',  '$lastname',  '$login',  '".md5($passwd)."',  '$level',  '$language' )";
	$result=mysql_query($qry);
	
	//echo $qry;
	
	
	if ($result) echo mysql_insert_id();
	else echo "-1";

} else {
	
	echo "-1";
	
}


?>