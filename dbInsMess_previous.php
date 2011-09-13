<?php

//require_once('auth.php');
require_once('config.php');

$projectID=$_POST['project_id'];


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


// Il progetto dove lo usi????????
$query="SELECT * FROM `language`";
$result = mysql_query($query);
$vettore_risposta = array();

if ($result) {
	$count=0;
	while($row = mysql_fetch_array($result)){
		
		if ($count==0){
			$parent=NULL;
		}	
		if ($count==1){
			$parent=mysql_insert_id();
		}
		
		
		$query2="INSERT INTO `translation`.`messages` (`id`, `message`, `languageID`, `parent.mess.ID`) 
			VALUES (NULL, '', '".$row['id']."', '".$parent."')";
		$result2 = mysql_query($query);
		
		// count++?????
		$messaggi[$count++] = array( "lang_id" => $row['id'], "mess_id" => mysql_insert_id() );
		
		// count + 1???? ma quante volte lo fai?
		$count=$count+1;

	}
	
	//???? AVEVO detto JSON....
	//print_r($messaggi);
	//... da cui....
	echo json_encode($messaggi);
}
else 
	echo "-1";



// e questo cos'?
	
/*	if ($result) {
		echo mysql_insert_id();
	}
	else echo "-1";*/
	

mysql_close($link);



?>