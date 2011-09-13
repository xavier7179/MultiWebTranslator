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

<div class="form">
	<h3>Inserimento Nuovo Utente</h3>
	<div id="add_users" class="form_box">
		<form id="add_users_form" method="post">
	
		<fieldset>
			<legend>Dati Utente</legend>
			<div id="add_users_fields">
				<dl>
					<dd><label>Nome:</label>&nbsp;<input type="text" id="firstname" name="firstname" size="30"/></dd>

					<dd><label>Cognome:</label>&nbsp;<input type="text" id="lastname" name="lastname" size="30" /></dd>
	
					<dd><label>UserId:</label>&nbsp;<input type="text" id="login" name="login" size="30" /></dd>

					<dd><label>Password:</label>&nbsp;<input type="password" name="passwd" size="30" /></dd>
	
					<dd><label>Livello:</label>&nbsp;<select name="level" id="level">
						<option value="0">Base</option>
						<option value="1">Intermedio</option>
						<option value="2">Amministratore</option>
						</select></dd>

						<dd><label>Lingua:</label>&nbsp;<select name="language" id="language">
							<option value="0"> ALL </option>
				<?php
					$query = mysql_query("SELECT * FROM `language` ORDER BY `id` ASC");
					while($badge = mysql_fetch_array($query)) {
						echo('<option id="prj_'.$badge["id"].'" value="'.$badge["id"].'">'.$badge["language"].'</option>\n');
					}
				?>
						</select></dd>
					<dl>
				<input type="submit" name="Submit" value="Registra" />
				<input type="reset" name="Reset" value="Cancella" />
			</div>
		</fieldset> 
		</form>
	</div>


</div>

<div class="form" id="delete_users">
	<h3>Lista Utenti:</h3> 
	<table id="users_table" class="fancy_table">
		<thead>
			<tr>
				<td>Nome</td>
				<td>Cognome</td>
				<td>UserID</td>
				<td>Livello</td>
				<td>Rimuovi</td>
			</tr>
		</thead>
		<?php
		$query = mysql_query("SELECT firstname, member_id, lastname, login, level FROM `members` ORDER BY `lastname` ASC");
		while($badge = mysql_fetch_array($query)) { ?>
			<tr id="user_<?php echo $badge["member_id"]; ?>">
				<td><?php echo $badge["firstname"];?></td>
				<td><?php echo $badge["lastname"];?></td>
				<td><?php echo $badge["login"];?></td>
				<td><?php
						switch($badge["level"]) {
							case 0: echo "Base"; break;
							case 1: echo "Intermedio"; break;
							case 2: echo "Amministratore"; break;
						}
					?></td>
				<td><a href="#" alt="Cancella Utente"><img src="./img/delete.png" /></a></td>
			</tr>
		<?php
		}
		?>
	</table>
	
</div>

<?php

if(0){
	
	$qry="INSERT INTO  `translation`.`members` ( `member_id`, `firstname`, `lastname`, `login`, `passwd`, `level`, `language` )
			VALUES ( NULL ,  '$firstname',  '$lastname',  '$login',  '".md5($passwd)."',  '$level',  '$language' )";
	$result=mysql_query($qry);
	

	$qry="DELETE FROM `translation`.`members` WHERE `members`.`member_id` = '".$member_id."' LIMIT 1";	
	$result=mysql_query($qry);

}


?>
