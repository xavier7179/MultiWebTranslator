<?php

//require_once('auth.php');
require_once('config.php');

if (isset($_POST['text'])) $message=$_POST['text'];
else $message='';

$id=$_POST['id'];



$myFile = "testFile.txt";
$fh = fopen($myFile, 'w') or die("can't open file");
$stringData = "Messaggio = ".$messaggio;
$stringID = "ID = ".$id;
fwrite($fh, $stringData);
fwrite($fh, $stringID);
fclose($fh);


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
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	//Sanitize the POST values
	$message = clean($message);
	$id = clean($id);

	//Input Validations
	if (($id == '')) {
		$errmsg_arr[] = 'My single project ERROR';
		$errflag = true;
	}
	
	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: error.php");
		exit();
	}

	$qry="UPDATE messages SET message=\"".$message."\" WHERE id=".$id;
	echo $qry;
	
	$result=mysql_query($qry);
	//echo $result;
	mysql_close($link);
	
	//echo "done";
?>