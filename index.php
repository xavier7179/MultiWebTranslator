<?php
require_once('auth.php');

?>

	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Member Index</title>
	<link href="./css/base.css" rel="stylesheet" type="text/css" />
	
	<!-- MOOTOOLS -->
	<script type="text/javascript" src="./javascript/mootools/mootools-core-1.3.1-full-nocompat.js"></script>
	<script type="text/javascript" src="./javascript/mootools/mootools-more-1.3.1.1.js"></script>
	
	<!-- E X T R A    C S S  &  J S  -->
	<script type="text/javascript" src="./javascript/tbela99-InPlaceEditor-a12cb5b/Source/InPlaceEditor.js"></script>
	
	<link  href="./javascript/arian-MooDialog-418792d/Source/css/MooDialog.css" rel="stylesheet" type="text/css" media="screen" />
	<script src="./javascript/arian-MooDialog-418792d/Source/Overlay.js" type="text/javascript"></script>
	<script src="./javascript/arian-MooDialog-418792d/Source/MooDialog.js" type="text/javascript"></script>
	<script src="./javascript/arian-MooDialog-418792d/Source/MooDialog.Fx.js" type="text/javascript"></script>
	<script src="./javascript/arian-MooDialog-418792d/Source/MooDialog.Alert.js" type="text/javascript"></script>
	<script src="./javascript/arian-MooDialog-418792d/Source/MooDialog.Confirm.js" type="text/javascript"></script>
	<script src="./javascript/arian-MooDialog-418792d/Source/MooDialog.Error.js" type="text/javascript"></script>

	<script type="text/javascript" src="./javascript/ajaxRequest.js"></script>
	<script type="text/javascript" src="./javascript/init.js"></script>
	
	</head>

	<body>

	<div id="header">
		<h1>Benvenuto <?php echo $_SESSION['SESS_FIRST_NAME'];?></h1>
	</div>
	
	<div id="main_menu" class="menu clearfix">
		<div id="menu_sx">
			<a href="index.php?page=Projects">Progetti</a>
			<?php $sesslevel = $_SESSION['SESS_LEVEL']; if($sesslevel==2){ ?> | <a href="index.php?page=SupAdm&sub=project">Area Super Admin</a> <?php } ?>
		</div>
		<div id="menu_dx">
			<a href="logout.php">Logout</a>
		</div>
	</div>
	

	<?php 
	
	$page = $_GET['page'];
	$sessid = $_SESSION['SESS_MEMBER_ID'];
	

	if  ($page == "Projects") { 
		include 'my_projects.php'; 
	}
	if  ($page == "Manage") { 
		$projid=$_GET['projID'];
		$projName=$_GET['namePr'];
		$langu=$_GET['langu'];
		include 'my_single_project.php';
	}
	if  ($page == "SupAdm") { 
		$sub = $_GET['sub'];
		?>
			<div id="sub_menu" class="menu">
				<a href="index.php?page=SupAdm&sub=users">Utenti</a> | 
				<a href="index.php?page=SupAdm&sub=project">Progetti</a> | 
				<a href="index.php?page=SupAdm&sub=assign">Assegnazione Traduzioni</a>
			</div>
	
		<?php
		
		switch($sub){
			case "users":
				echo "<h2>Amministrazione Utenti</h2>";
				include 'my_admin_users_page.php';
			break;
			
			case "project": 
				echo "<h2>Amministrazione Progetti</h2>";
				include 'my_admin_project_page.php';
			break;
			
			case "assign": 
				echo "<h2>Assegnazione Traduzioni</h2>";
				include 'my_admin_assign_page.php';
			break;
			
		}

	}

	
	?>


	</body>
	</html>