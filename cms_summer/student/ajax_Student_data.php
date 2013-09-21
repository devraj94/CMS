<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
    include(dirname(dirname(__FILE__))."./function.php");

    $username = $_SESSION["username"];
    $institute_id = $_SESSION["institute_id"];

    # When user enter the student 'Roll_no' in registration form
    if (isset($_POST["condition"])) {
    	$stdRollNo = mysql_real_escape_string($_POST["stdRollNo"]);
    	//
    	$student_id = get_column_from_table("student_id","student_m_details","roll_no='$stdRollNo' AND institute_id='$institute_id'");
    	if ($student_id) {// if student exist with the 'roll no'
    		# SQL QUERY
            $result_std_SQL = get_row_from_table("student_t_details","student_id='$student_id' AND institute_id='$institute_id'");
    		if (mysql_num_rows($result_std_SQL) > 0) {
    			$array = mysql_fetch_array($result_std_SQL);

    			# for department details
	    		$result_dep = get_row_from_table("department_m_details","department_id='".$array['department_id']."'");
	    		$dep = mysql_fetch_array($result_dep);
	    		//$dep_str = "<option value='".$dep["department_id"]."'>".$dep["department_name"]." (".$dep["department_code"].")</option>";
                $dep_str = $dep["department_id"]."&&&".$dep["department_name"]." (".$dep["department_code"].")";

	    		# for program details
	    		$result_prog = get_row_from_table("program_m_details","program_id='".$array['program_id']."'");
	    		$prog = mysql_fetch_array($result_prog);
	    		//$prog_str = "<option value='".$prog["program_id"]."'>".$prog["program_name"]." (".$prog["program_code"].")</option>";
                $prog_str = $prog["program_id"]."&&&".$prog["program_name"]." (".$prog["program_code"].")";

                $data = get_row_from_table("student_m_details","student_id='$student_id'");
                if ($data) {
                    if (mysql_num_rows($data)>0) {
                        $row = mysql_fetch_array($data);

                        echo "1*".$array["student_id"]."*".$row["student_name"]."*".$row["email_id"]."*".$prog_str."*".$dep_str;
                    }else{
                        echo "0*";
                    }
                }
	    	}else{
	    		echo "0*";
	    	}
    	}else{
    		echo "2*"; // user don't exist with the 'email_id'
    		exit();
    	}
    }elseif (isset($_POST["check_Email"])) {  // Checking 'Emial_id'
    	$email_id = mysql_real_escape_string($_POST["email_id"]);
    	$user_id = get_column_from_table("user_id","users","username='$email_id'");
    	if ($user_id) {
    		if (row_exist("users_role","user_id='$user_id' AND role_id='6'")) {
    			echo "0*";
    		}else{
    			if (row_exist("users_role","user_id='$user_id' AND role_id='5'")) {
    				echo "1*".get_column_from_table("ta_name","ta_m_details","user_id='$user_id'");
    			}elseif (row_exist("users_role","user_id='$user_id' AND role_id='4'")) {
    				echo "1*".get_column_from_table("instructor_name","instructor_m_details","user_id='$user_id'");
    			}elseif (row_exist("users_role","user_id='$user_id' AND role_id='3'")) {
    				echo "1*".get_column_from_table("admin_name","admin_m_details","user_id='$user_id'");
    			}elseif (row_exist("users_role","user_id='$user_id' AND role_id='2'")) {
    				echo "1*".get_column_from_table("admin_name","admin_m_details","user_id='$user_id'");
    			}
    		}
    	}else{
    		echo "2*";
    	}
    }elseif (isset($_POST["change"])) { // If user change the 'program' then this will execute
    	$str = "---*----**";
    	$prog_id = mysql_real_escape_string($_POST["progID"]);
    	$sql = "SELECT t1.department_id,t1.department_code,t1.department_name FROM department_m_details t1 INNER JOIN program_department t2
    			ON (t1.department_id=t2.department_id AND t2.program_id='$prog_id')";
    	$result = mysql_query($sql) or die(mysql_error()."<br><br>".$sql);
    	if ($result) {
    		while ($row = mysql_fetch_array($result)) {
	    		$str.=$row["department_id"]."*".$row["department_name"]." (".$row["department_code"].")**";
	    	}
	    	echo $str;
    	}
    }elseif (isset($_POST["get_Program"])) { // to get proram detail
    	$str="---*----**";
    	$result = get_row_from_table("program_m_details","institute_id='$institute_id'");
		if (mysql_num_rows($result)>0) {
			while ($row=mysql_fetch_array($result)) {
				$str.=$row['program_id']."*".$row['program_name']." (".$row['program_code'].")**";
			}
			echo $str;
		}
    }elseif (isset($_POST["get_course"])) { // to get course details
    	$sem = mysql_real_escape_string($_POST["semester"]);
    	$acyr = get_academic_year();
    	$session = get_session();
    	$sql = "SELECT t1.course_id,t1.course_code,t1.course_title FROM course_m_details t1 INNER JOIN course_instructor t2
    			ON (t1.course_id=t2.course_id AND t2.academic_year='$acyr' AND t2.session='$session' AND t2.semester='$sem' 
    				AND t1.institute_id='$institute_id')";
		$result = mysql_query($sql) or die(mysql_error()."<br><br>".$sql);
		if ($result) {
			$str = "---*----**";
			while ($row=mysql_fetch_array($result)) {
				$str.=$row['course_id']."*".$row['course_title']." (".$row['course_code'].")**";
			}
			echo $str;
		}
    }
?>