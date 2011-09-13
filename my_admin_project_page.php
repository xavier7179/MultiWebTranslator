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

if ((isset($_GET['meta']))&&($_GET['meta']=="edit") ){
	$projects=$_POST['projects'];
	$commento=$_POST['commento'];

$query = "INSERT INTO `translation`.`messages` (`id` , `message` , `languageID` , `parent.mess.ID` ) VALUES ( NULL , '".$commento."', '1', NULL);";
mysql_query($query);
$result=mysql_insert_id();
echo $result;
$query = "INSERT INTO `translation`.`messages` (`id` , `message` , `languageID` , `parent.mess.ID` ) VALUES ( NULL , '', '2', ".$result.");";
mysql_query($query);
$query = "INSERT INTO `translation`.`messages` (`id` , `message` , `languageID` , `parent.mess.ID` ) VALUES ( NULL , '', '3', ".$result.");";	
mysql_query($query);
$query ="INSERT INTO `translation`.`projectAssoc` ( `projID` , `parent.message.ID` ) VALUES ( '".$projects."', '".$result."' );";
mysql_query($query);
}
?>



<div id="new_project" class="form">

<form id="new_project_form" method="post">
<fieldset>
	<legend>Crea un nuovo progetto</legend>
	<div id="new_project_fields">
		<label>Nome:&nbsp;</label>
		<input id="new_project_name" name="new_project_name" value="Inserire Nome Progetto" class="overlaytext" />
		<input id="new_project_submit" type="submit" value="Aggiungi" disabled="true" />
	</div>
</fieldset>
</form>

</div>

<div id="del_project" class="form">

<form id="del_project_form" method="post">
<fieldset>
	<legend>Rimuovi progetto</legend>
	<div id="del_project_fields">
		<label>Seleziona:&nbsp;</label>
		<select id="project_id" name="project_id">
		<option value="-1" selected=""> - </option>
<?php
$query = mysql_query("SELECT * FROM `project` ORDER BY `name` ASC");
while($badge = mysql_fetch_array($query))
	{
	echo('<option id="prj_'.$badge["id"].'" value="'.$badge["id"].'">'.$badge["name"].'</option>');
	}
?>
		</select>
		<input id="del_project_submit" type="submit" value="Rimuovi" disabled="true" />
	</div>
	</fieldset>
</form>
</div>

<!-- RIMOSSSO TEMPORANEAMENTE IN ATTESA DI SEZIONE AD-HOC -->
<!--<form method="post" action="http://localhost/zzz/PHP-Login/index.php?page=SupAdm&sub=project&meta=edit">


<select name="projects" id="projects" >
<?php
/*$query = mysql_query("SELECT * FROM `project` ORDER BY `name` ASC");
while($badge = mysql_fetch_array($query))
	{
	echo('<option value="'.$badge["id"].'">'.$badge["name"].'</option>');
	}*/
?>
</select> </label>
<br><br>

Frase:<br>
<textarea name="commento" rows="5" cols="30"></textarea>
<input type="submit" name="invia" value="Invia i dati">

</form>-->