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
?>

<div id="man_project" class="form">
	<form id="man_project_form" method="post">
	<fieldset>
	<legend>Selezionare un progetto</legend>
	<label>Progetto:</label>
	<!-- <select name="project" id="project" onchange=InviaDatiSelectProj(this.value)>-->
	<select name="project_id" id="project_id">
	<option value="-1"> - </option>
	<?php
		$query = mysql_query("SELECT * FROM `project` ORDER BY `name` ASC");
		while($badge = mysql_fetch_array($query)) {
			echo('<option id="prj_'.$badge["id"].'" value="'.$badge["id"].'">'.$badge["name"].'</option>\n');
		}
	?>
	</select>
	</fieldset>
	</form>
</div>

<div id="user_project" class="form">
	<div id="user_list">
		<strong>Seleziona un progetto per continuare</strong>
	</div>
</div>
