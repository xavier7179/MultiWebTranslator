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

// Seleziono prima il db lingue e le ciclo
$query="SELECT * FROM `language`";
$result = mysql_query($query);
$vettore_risposta = array();

if ($result) {
	$count=0;
	while($row = mysql_fetch_array($result)){
		
		if ($count==0)
			$parent=NULL;

		if ($count==1){
			$parent=mysql_insert_id();
			
			// Inserisco anche l'associazione col progetto dopo aver ottenuto il primo ID di messaggio
			$query3="INSERT INTO  `translation`.`projectAssoc` ( `projID` , `parent.message.ID` )
				VALUES ( '".$projectID."',  '".$parent."');";
			$result3 = mysql_query($query3);

		}
		
		$query2="INSERT INTO `translation`.`messages` (`id`, `message`, `languageID`, `parent.mess.ID`) 
			VALUES (NULL, '', '".$row['id']."', '".$parent."')";
			
		// Controllo per la stampa del NULL al parent
		if ($parent==NULL)
			$query2="INSERT INTO `translation`.`messages` (`id`, `message`, `languageID`, `parent.mess.ID`) 
				VALUES (NULL, '', '".$row['id']."', NULL)";	
		else
			$query2="INSERT INTO `translation`.`messages` (`id`, `message`, `languageID`, `parent.mess.ID`) 
				VALUES (NULL, '', '".$row['id']."', '".$parent."')";	
			
		//echo $query2;
			
		$result2 = mysql_query($query2);

		$messaggi[$count++] = array( "lang_id" => $row['id'], "mess_id" => mysql_insert_id() );

	}
	echo json_encode($messaggi);
}
else 
	echo "-1";

mysql_close($link);



?>