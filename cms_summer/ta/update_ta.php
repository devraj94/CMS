<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./db_config.php");

	# Connecting to database
	$connection = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
	mysql_select_db($dbname , $connection);

	$sql_ta = "UPDATE ta
			SET 
				name = '".mysql_real_escape_string($_POST['taName'])."',
				email_id = '".mysql_real_escape_string($_POST['taEmail'])."',
				address = '".mysql_real_escape_string($_POST['taAddress'])."',
				contactNo = '".mysql_real_escape_string($_POST['tacontactNo'])."',
				updated_at = '".date( 'Y-m-d H:i:s')."',
				updated_by = '".$_SESSION["username"]."'
			WHERE 
				ta_id = '".mysql_real_escape_string($_POST['ta_id'])."'	
			";
	$result_ta = mysql_query($sql_ta);


	
	//$result_inst = mysql_query($sql_inst);
	if ($sql_ta) {
		header("Location: ta_profile.php");
		exit;
	}
?>