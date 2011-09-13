<h2> My Projects - <?php echo $projName; ?></h2>



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
	$projid = clean($projid);
	$langu = clean($langu);
	
	//Input Validations
	if (($projid == '') || ($projName == '') || ($langu == '')) {
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
	?>

	<?php

	$qry="SELECT * FROM language ORDER BY id";
	$result=mysql_query($qry);
	$n=0;
	while($VAR_Languages=mysql_fetch_array($result)) {
		$languages[$n++] = array("id" => $VAR_Languages['id'], "lingua" => $VAR_Languages['language']);
	}
	
	
	//Create query
	$qry="SELECT * FROM projectAssoc WHERE projID='$projid'";
	$result=mysql_query($qry);

	$messaggi = array();
	$conto = 0;	
	while($row=mysql_fetch_array($result)) {
	   	$qry2="SELECT * FROM messages WHERE id=".$row['parent.message.ID'];
		$result2=mysql_query($qry2);
		$row2=mysql_fetch_array($result2);
		$messaggi[$conto++] = array("id" => $row2['id'], "message" => $row2['message']);
		
		$qry3="SELECT * FROM `messages` WHERE `parent.mess.ID`=".$row2['id']." ORDER BY languageID ASC";
		$result3=mysql_query($qry3);
		//Check whether the query was successful or not
		if($result3) {
		   	while($row3=mysql_fetch_array($result3)) {		
				$messaggi[$conto++] = array("id" => $row3['id'], "message" => $row3['message']);
			}			
		}else {
			die("Query failed");
		}	
	}
	
	$numero_messaggi=count($messaggi);
	$numero_lingue = count($languages);
	$messaggi_x_lingua = $numero_messaggi/$numero_lingue;

// ######################################################
/*echo "Queste stampe si potranno rimuovere dopo il test";
echo "<hr>";	
print_r($languages);
echo "<hr>";
print_r($messaggi);
echo "<br>Array size with count: ".count($messaggi);*/

// ######################################################

// ######################################################
// P A R T E   D I   S T A M P A
?>
<input type="hidden" id="project_id" value="<? echo $projid ?>" />
<div id="languageWrapper">
<?php 
	$count=0; 
	
	foreach ($languages as $lingua){  ?>	
	<div id="lang_<?php echo $lingua['id']; ?>" class="lang_column">
		<h3 class="centered_thing"><?php echo $lingua['lingua']; ?></h3>
		<?php for ($itera = 0; $itera < $messaggi_x_lingua; $itera++) {  ?>
			<div id="msg_<?php echo $messaggi[$count+($itera*$numero_lingue)]['id']; ?>" class="lang_single_msg editable"><?php echo $messaggi[$count+($itera*$numero_lingue)]['message']; ?></div>
		<?php 
			} 
			// SE LA LINGUA E' QUELLA MADRE SERVE IL BOTTONE DI AGGIUNTA
			if ($count == 0) { ?>
				<div id="addMsgWrapper">
					<a href="#" class="centered_thing">Aggiungi Messaggio</a>
				</div>
			<?php
			}
		?>		
	</div>
<?php $count++; } ?>
</div>