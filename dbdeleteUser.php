<?php
require_once('config.php');


if ( isset( $_POST['user_id']) ){

	$member_id=$_POST['user_id'];

	$qry="DELETE FROM `translation`.`members` WHERE `members`.`member_id` = '".$member_id."' LIMIT 1";	
	$result=mysql_query($qry);
	
	echo "0";

} else {
	
	echo "-1";
	
}


?>