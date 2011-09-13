<?php

//require_once('auth.php');
require_once('config.php');

$message=$_POST['project_id'];

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

$sql="SELECT * FROM assign WHERE projectID = '".$message."'";
$result = mysql_query($sql);

$sql="SELECT * FROM members";
$result = mysql_query($sql);

?>
		<input type="hidden" id="actual_project_id" name="actual_project_id" value="<?php echo $message; ?>" />
<?php 

echo "<table> 
<tr>
<th>Nome</th>
<th>Aggiunto</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
	$sql2="SELECT * FROM assign WHERE membersID = '".$row['member_id']."'AND projectID='".$message."'";
	$result2 = mysql_query($sql2);
	$row2 = mysql_fetch_array($result2);
	
	
  echo "<tr>\n";
  echo "<td>" . $row['login'] . "</td>";
  echo "<td><input id=\"usr_".$row['member_id']."\" type=\"checkbox\" name=\"user_id\" value=\"".$row['member_id'] ."\" "; 
	if ($row2==TRUE) {echo "checked=\"checked\" "; }
  echo "/> </td>\n";
  echo "</tr>\n";
  }
echo "</table>";

mysql_close($link);



?>