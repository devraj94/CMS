<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");
	$institute_id = $_SESSION["institute_id"]; 
	$username = $_SESSION["username"]; 

	# If Operation on row is type of 'Edit'
	if(isset($_POST["submit"])){
		
	}elseif (mysql_real_escape_string($_POST['oper'])=='del') {

		$IDs = mysql_real_escape_string($_POST['id']);
		$id = explode(",", $IDs);
		for ($i=0; $i < sizeof($id); $i++) { 
			$filepath = get_column_from_table("description_file_path","course_m_details","course_id='$id[$i]'");
			if ($filepath) {
				if (!is_null($filepath) && $filepath!="" && $filepath!=" ") {
					if (file_exists("../".$filepath)) {
						$dir ="/".get_column_from_table("institute_name","institute_m_details","institute_id='$institute_id' ");
						$dir.="/".get_column_from_table("course_code","course_m_details","course_id='$id[$i]'");
						$dir = "../files/course_description".$dir;
						recursiveRemove($dir);
					}
				}
			}
			$del_result = delete_row_in_table("course_m_details", "course_id='$id[$i]' AND institute_id='$institute_id'");
		}// FOR Loop ends
	}
	
?>