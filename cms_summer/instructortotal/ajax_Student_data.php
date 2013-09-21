<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
    include(dirname(dirname(__FILE__))."./instructortotal/function.php");

    $username = $_SESSION["username"];
    $institute_id = $_SESSION["institute_id"];
    $rest=NULL;
	$stdID="";
	$course_id="";
    # When user enter the student 'Roll_no' in registration form
	if(isset($_POST["condition"]) && $_POST['condition']=="2"){
	$email=mysql_real_escape_string($_POST["email_id"]);
	    $user_id = get_column_from_table("user_id","users","username='$email'");
		if($user_id){
		echo "0*";
		}else{
		echo "1*";
		}
	}
    if (isset($_POST["condition"]) && $_POST['condition']=="1") {
    	$stdRollNo = mysql_real_escape_string($_POST["stdRollNo"]);
    	$studentid=get_column_from_table("student_id","student_m_details","roll_no='$stdRollNo' AND institute_id='$institute_id'");
		$courseid=mysql_real_escape_string($_POST["courseid"]);
    	# SQL QUERY
    	$result_std_SQL = get_row_from_table("student_m_details","student_id='$studentid' AND institute_id='$institute_id'");
        $result_std_SQLi = get_row_from_table("student_course","student_id='$studentid' AND institute_id='$institute_id' AND course_id='$courseid'");
		if(mysql_num_rows($result_std_SQLi)>0){
		echo "0*";
		}elseif (mysql_num_rows($result_std_SQL) > 0) { // user exist with the 'email_id'
    		$array = mysql_fetch_array($result_std_SQL);
    		echo "1*".$array["student_id"]."*".$array["student_name"]."*".$array["email_id"]."*".$array['father_name']."*".$array['mother_name']."*".$array['address']."*".$array['pin_code']."*".$array['mobile_no']."*".$array['blood_group'];
    	}else{ 
    		echo "2*"; // user don't exist with the 'email_id'
    		exit();
    	}
    }elseif(isset($_POST["submit"])){ // if data is posted for adding new student
    	# Get POSTED Data
    	$stdName = mysql_real_escape_string($_POST["stdName"]);
	    $stdRollNo = mysql_real_escape_string($_POST["stdRoll_No"]);
	    $stdEmail = mysql_real_escape_string($_POST["stdEmail"]);
	    $program_id = mysql_real_escape_string($_POST["program"]);
	    $department_id = mysql_real_escape_string($_POST["department"]);
	    $student_id = mysql_real_escape_string($_POST["user_id"]);
	    $course_id = mysql_real_escape_string($_POST["course"]);
	    $semester = mysql_real_escape_string($_POST["sem"]);
	    $old_new = mysql_real_escape_string($_POST["old_new"]);
		$father = mysql_real_escape_string($_POST["father"]);
		$mother = mysql_real_escape_string($_POST["mother"]);
		$pin = mysql_real_escape_string($_POST["pin"]);
		$address = mysql_real_escape_string($_POST["address"]);
		$mobile = mysql_real_escape_string($_POST["mobile"]);
		$blood = mysql_real_escape_string($_POST["blood"]);
	    # Get academic year
	   	$academic_yr = get_academic_year();
	   	# Get session
	   	$session = get_session();
	    
	    if ($old_new=="new") {
	    	# First we have to create new user with username and password
	    	$user_pass = rand_chars("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890", 5,FALSE); // Genrating string
	    	# INSERT into 'users' table
	    	$result_user = insert_into_users($stdEmail,$user_pass,$institute_id,$username); // inserted
	    	if ($result_user) {
	    		# Get 'user_id' for above inserted new user
		    	$user_id = get_column_from_table("user_id","users","username='$stdEmail' AND password='$user_pass'");
			$redf=insert_into_users_role($user_id,"6",$username);
		    	# Insert into 'student' table
		    	$result_std = insert_into_student_m_details($stdRollNo,$stdName,$stdEmail,$father,$mother,$address,$pin,$mobile,$blood,$user_id,$institute_id,$username); // inserted
		    	if ($result_std) {
		    		# Get 'student_id' for above inserted new student
		    		$stdID = get_column_from_table("student_id","student_m_details","roll_no='$stdRollNo' AND institute_id='$institute_id'");
			    	# Insert into 'student_reg' table
			    	$result_std_t = insert_into_student_T($stdID,$department_id,$program_id,$institute_id,$username); // inserted
		    		if ($result_std_t) {
		    			$rest=insert_into_student_course($stdID,$course_id,$institute_id,$academic_yr,$session,$semester,$username);
		    		}else{ 
		    			# If data not inserted in 'student_reg' table
		    			delete_row_in_table("student_m_details","student_id='$stdID' AND institute_id='institute_id'");
						delete_row_in_table("users_role","user_id='$user_id'");
		    			delete_row_in_table("users","user_id='$user_id'");
		    		}
		    	}else{ // If data not inserted in 'student' table
		    		delete_row_in_table("users_role","user_id='$user_id'");
					delete_row_in_table("users","user_id='$user_id'");
		    	}
	    	}
	    }elseif ($old_new=="old") {
	    	# Insert into 'student_reg' table
			$refd=get_row_from_table("student_t_details","student_id='$student_id' AND department_id='$department_id' AND program_id='$program_id'");
			if(mysql_num_rows($refd)>0){
			   $rest=insert_into_student_course($student_id,$course_id,$institute_id,$academic_yr,$session,$semester,$username);
			}else{
	    	$result_std_t = insert_into_student_T($student_id,$department_id,$program_id,$institute_id,$username); // inserted
		    		if ($result_std_t) {
		    			$rest=insert_into_student_course($student_id,$course_id,$institute_id,$academic_yr,$session,$semester,$username);
		    		}else{ 
		    			# If data not inserted in 'student_reg' table
						delete_row_in_table("student_t_details","student_id='$stdID' AND institute_id='$institute_id' AND program_id='$program_id'");
		    		}
			}
	    }// elseif ends
		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<script src="../jquery_ui_lib/jquery_1.10.1.min.js"></script>
		<script src="../jquery_ui_lib/jquery_ui_1.10.3.min.js"></script>
		<script src="../bootstrap/js/bootstrap.js"></script>
		<link href="../css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
			$(function(){
				$("#close").click(function(){
					window.parent.$('#my_modal').modal('hide');
				});
			});
		</script>
	</head>
	<body>
		<?php
			if ($rest && !isset($_POST["condition"])) {
				?>
					<p>Student successfully registered.</p>
				<?php
			}elseif(!isset($_POST["condition"])){
				?>
					<div id="warning" class="alert alert-block">
						<strong>Error!</strong> Student couldn't registered.
					</div>
					<button id="close" class="btn btn-danger">Close</button>
				<?php
						delete_row_in_table("student_t_details","student_id='$stdID' AND institute_id='$institute_id' AND program_id='$program_id'");
			}
		?>
	</body>
</html>