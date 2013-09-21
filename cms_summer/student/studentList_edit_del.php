<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");
	$institute_No = $_SESSION["institute_id"]; 
	$username = $_SESSION["username"];

	if ($_POST["oper"]=="edit") {
		$id = mysql_real_escape_string($_POST["id"]);
		$std_Name = mysql_real_escape_string($_POST["student_name"]);
		$program_id = mysql_real_escape_string($_POST["program_id"]);
		$department_id = mysql_real_escape_string($_POST["department_id"]);
				$SQL = "UPDATE student
			    		SET student_name = '$std_Name',
			    			program_id = '$program_id',
			    			department_id = '$department_id',
			    			updated_at = '".date( 'Y-m-d H:i:s')."',
			                updated_by = '$username'
			    		WHERE std_id = '$id'
			    		"; 
			    $result = mysql_query($SQL) or die("Couldn't execute query.".mysql_error());

		$del_result = delete_row_in_table("student_reg", "student_id='$id'");
	}elseif ($_POST["oper"]=="del") {
		$IDs = mysql_real_escape_string($_POST["id"]);
		$id = explode(",", $IDs);
		for ($i=0; $i < sizeof($id); $i++) { 
			// Deleting 'registraion-record' in course
			$user_id = get_column_from_table("user_id","student","std_id='$id[$i]' AND institute_No='$institute_No'");
			if ($user_id && !is_null($user_id)) {
				// Delete record from 'student' table
				$del_result1 = delete_row_in_table("student", "std_id='$id[$i]' AND institute_No='$institute_No'");
				if ($del_result1) {
					$data = get_category($user_id);
					$condition = explode("*", $data);
					if ($condition[0]=="0") {
						// Simply delete user
						$del_user = delete_row_in_table("users","user_id='$user_id'");
					}elseif ($condition[0]=="1") {
						// update user
						$update_user = update_category($user_id,$condition[1],"6",$username);
					}
				}
			}
		}// FOR Loop ends
	}
?>