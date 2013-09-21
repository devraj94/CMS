<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./db_config.php");

	# Connecting to database
	$connection = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
	mysql_select_db($dbname , $connection);
	$ins_id = mysql_real_escape_string($_POST['instructor_id']);
	$intitute_No = $_SESSION["institute_id"];
	$username = $_SESSION["username"];
	$ins_Name = mysql_real_escape_string($_POST['instructorName']);
	$ins_email = mysql_real_escape_string($_POST['instructorEmail']);
	$address = mysql_real_escape_string($_POST['address']);
	$contact = mysql_real_escape_string($_POST['contact']);
	$sql_ins = "UPDATE instructor_m_details
			SET 
				instructor_name = '$ins_Name',
				email_id = '$ins_email',
				address='$address',
				contactNo='$contact',
				updated_at = '".date('Y-m-d H:i:s')."',
				updated_by = '$username'
			WHERE 
				instructor_id='$ins_id'";
	$result_ins = mysql_query($sql_ins);

	if ($result_ins) {
		header("Location: instructor_profile.php");
		exit();
	}
?>