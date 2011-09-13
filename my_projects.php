<h2> I Miei Progetti</h2>
<?php
require_once('auth.php');
require_once('config.php');


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
	$sessid = clean($sessid);
	
	//Input Validations
	if($sessid == '') {
		$errmsg_arr[] = 'Login ID missing';
		$errflag = true;
	}
	
	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: error.php");
		exit();
	}
	
	//Create query
	$qry="SELECT * FROM assign WHERE membersID='$sessid'";
	$result=mysql_query($qry);
	
	//Check whether the query was successful or not
	if($result) {
			//QUERY SUCCESS
		?> 
		<div id="projects">
		<ol id="project_list">
		
		<?php
		   while($row=mysql_fetch_array($result)) {
			
			$qry2="SELECT * FROM `project` WHERE `id` = ".$row['projectID'];
			$result2=mysql_query($qry2);
			$row2=mysql_fetch_array($result2);
			
		       echo "<li><a href=\"index.php?page=Manage&projID=".$row['projectID']."&namePr=".$row2['name']."&langu=".$row['languageID']."\">".$row2['name']." </a></li>";
		   }
		 ?>
		</ol>
		</div>
		<?php
		
	
	}else {
		die("Query failed");
	}
?>