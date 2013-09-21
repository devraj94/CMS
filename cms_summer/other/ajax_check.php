<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$username = $_SESSION["username"];
	$institute_id = $_SESSION["institute_id"];
	if (isset($_POST["prog"])) {
		$code = mysql_real_escape_string($_POST["code"]);
		$result = get_column_from_table("program_code","program_m_details","institute_id='$institute_id' AND program_code='$code'");
		if ($result) {
			echo "0";
			exit();
		}else{ // now we can insert data to table
			echo "1";exit();
		}
	}elseif (isset($_POST["condition"])) {
		$code = mysql_real_escape_string($_POST["progCode"]);
		$name = mysql_real_escape_string($_POST["progName"]);
		$insert_result = insert_into_program($code,$name,1,$institute_id,$username);
		if ($insert_result) {
			header("Location: add_program.php?done=1");
		}else{
			message_box("ERROR!","Some error occured while quering.",0,0);
		}
	}elseif (isset($_POST["dep"])) {
		$code = mysql_real_escape_string($_POST["department_code"]);
		$result = get_column_from_table("department_code","department_m_details","institute_id='$institute_id' AND department_code='$code'");
		if ($result) {
			echo "0";
			exit();
		}else{ // now we can insert data to table
			echo "1";
			exit();
		}
	}elseif (isset($_POST["condition_dep"])) {
		$d_code = mysql_real_escape_string($_POST["dcode"]);
		$d_name = mysql_real_escape_string($_POST["dname"]);

		$insert_dep = insert_into_department($d_code,$d_name,1,$institute_id,$username);
		if ($insert_dep) {
			$dep_id = get_column_from_table("department_id","department_m_details","institute_id='$institute_id' AND department_code='$d_code'");
			if ($dep_id) {
				$result_insert = insert_into_prog_dep($dep_id,mysql_real_escape_string($_POST["prog_id"]),$institute_id,$username);
				if ($result_insert) {
					message_box("SUCCESS!","Department successfully added.",0,1);
				}else{
					delete_row_in_table("department_m_details", "department_id='$dep_id'");
					message_box("ERROR!","Some error occured while quering.",0,1);
				}
			}else{
				delete_row_in_table("department_m_details", "department_code='$d_code' AND institute_id='$institute_id'");
				message_box("ERROR!","Some error occured while quering.",0,1);
			}
		}else{
			message_box("ERROR!","Some error occured while quering.",0,1);
		}
	}
?>
