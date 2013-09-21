<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");
	$institute_id = $_SESSION["institute_id"]; 

	# If Operation on row is type of 'Edit'
	if(mysql_real_escape_string($_POST['oper'])=='edit'){
		//...........
	}elseif (mysql_real_escape_string($_POST['oper'])=='del') {
		$IDs = mysql_real_escape_string($_POST['id']);
		$id = explode(",", $IDs);
		for ($i=0; $i < sizeof($id); $i++) { 
			$del_result = delete_row_in_table("course_instructor", "tblid='$id[$i]' AND institute_id='$institute_id'");
		}// FOR Loop ends
	}
	
?>