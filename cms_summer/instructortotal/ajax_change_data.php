<?php 
    include(dirname(dirname(__FILE__))."./user_session.php");
    include(dirname(dirname(__FILE__))."./instructortotal/function.php");

    $username = $_SESSION["username"];
    
	if ($_POST["table"]=="ta_instructor") {
    	$id = $_POST["row_id"];
    	$status = $_POST["status"];
		$instituteno=$_POST["instituteno"];
		$courseid=$_POST["courseid"];
    	$result = update_a_column_of_table("ta_instructor","status","$status","ta_id='$id' AND institute_id='$instituteno'",$username);
    	if ($result) {
    		echo "success";
    	}
    }
	if ($_POST["table"]=="student_m_details") { //used in Students
    	$id = $_POST["row_id"];
    	$status = $_POST["status"];
		$instituteno=$_POST["instituteno"];
    	$result = update_a_column_of_table("student_m_details","status","$status","student_id='$id' AND institute_id='$instituteno'",$username);
    	if ($result) {
    		echo "success";
    	}
    }
	
	if ($_POST["table"]=="course") {
    	$id = $_POST["row_id"];
    	$status = $_POST["status"];
		$instituteno=$_POST["instituteno"];
    	$result = update_a_column_of_table("course","status","$status","course_No='$id' AND institute_No='$instituteno'",$username);
    	if ($result) {
    		echo "success";
    	}
    }
?>