<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$institute_id = $_SESSION["institute_id"];
	$username = $_SESSION["username"];

	if (isset($_POST["check_course_code_from_add"])) {
		$course_code=mysql_real_escape_string($_POST["c_code"]);
		$result = get_column_from_table("course_id","course_m_details","institute_id = '$institute_id' AND course_code = '".$course_code."'");
		if($result){
			echo "0"; exit();
		}else{
			echo "1"; exit();
		}
	}elseif (isset($_POST["check_course_code_from_edit"])) {
		$course_id = mysql_real_escape_string($_POST["c_id"]);
		$course_code = mysql_real_escape_string($_POST["c_code"]);
		$result = get_column_from_table("course_id","course_m_details","institute_id = '$institute_id' AND course_code = '".$course_code."'");
		if($result){
			if ($result==$course_id) {
				echo "2";
			}else{
				echo "0"; 
				exit();
			}
			
		}else{
			echo "1"; exit();
		}
	}
?>