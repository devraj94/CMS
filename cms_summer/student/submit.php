<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
    include(dirname(dirname(__FILE__))."./function.php");

    $username = $_SESSION["username"];
    $institute_id = $_SESSION["institute_id"];

	$std_course = FALSE;

	if(isset($_POST["submit"])){ // if data is posted for adding new student
    	# Get POSTED Data
    	$stdName = mysql_real_escape_string($_POST["stdName"]);
	    $stdRollNo = mysql_real_escape_string($_POST["stdRoll_No"]);
	    $stdEmail = mysql_real_escape_string($_POST["stdEmail"]);
	    $program_id = mysql_real_escape_string($_POST["program"]);
	    $department_id = mysql_real_escape_string($_POST["department"]);
	    $student_id = mysql_real_escape_string($_POST["student_id"]);
	    $course_id = mysql_real_escape_string($_POST["course"]);
	    $semester = mysql_real_escape_string($_POST["sem"]);
	    $old_new = mysql_real_escape_string($_POST["old_new"]);
	    $ta = mysql_real_escape_string($_POST["ta"]);
	    # Get academic year
	   	$academic_yr = get_academic_year();
	   	# Get session
	   	$session = get_session();
	    
	    if ($old_new=="new") {
	    	if ($ta=="yes") { // if he is a exist user but not a student
	    		# get user_id of the user
	    		$user_id = get_column_from_table("user_id","users","username='$stdEmail'");
	    		if ($user_id) {
	    			# add a role as student for this user
	    			$role_result = insert_into_users_role($user_id,6,$username); // Inserted
	    			if ($role_result) {
	    				# Now we have to insert main details of the student
	    				$std_result = insert_into_student_M($stdRollNo,$stdName,$stdEmail,1,$user_id,$institute_id,$username);
	    				if ($std_result) {
	    					# Get student_id
	    					$stdID = get_column_from_table("student_id","student_m_details","user_id='$user_id' AND institute_id='$institute_id'");
	    					if ($stdID) {
	    						# Now insert into student_t_details
	    						$std_t_result = insert_into_student_T($stdID,$department_id,$program_id,$institute_id,$username);
	    						if ($std_t_result) {
	    							$std_course = insert_into_student_course($stdID,$course_id,$institute_id,$academic_yr,$session,$semester,$username);
	    							if ($std_course) {
	    								# code...
	    							}else{
	    								delete_row_in_table("student_m_details", "student_id='$stdID'");
	    								delete_row_in_table("users_role", "user_id='$user_id' AND role_id='6'");
	    							}
	    						}else{
	    							delete_row_in_table("student_m_details", "student_id='$stdID'");
	    							delete_row_in_table("users_role", "user_id='$user_id' AND role_id='6'");
	    						}
	    					}else{
	    						delete_row_in_table("student_m_details", "user_id='$user_id' AND institute_id='$institute_id'");
	    						delete_row_in_table("users_role", "user_id='$user_id' AND role_id='6'");
	    					}
	    				}else{
	    					delete_row_in_table("users_role", "user_id='$user_id' AND role_id='6'");
	    				}
	    			}else{
	    				# couldn't insert into 'users_role'
	    			}
	    		}else{
	    			# couldn't get 'user_id' of the 'user' from 'users' table
	    		}
	    		# code...
	    	}elseif ($ta=="") { 
	    		# First we have to create new user with username and password
		    	$pass = rand_chars("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890", 5,FALSE); // Genrating string
		    	# INSERT into 'users' table
		    	$result_user = insert_into_users($stdEmail,$pass,$institute_id,$username); // inserted
		    	if ($result_user) {
		    		# Get 'user_id' for above inserted new user
			    	$user_id = get_column_from_table("user_id","users","username='$stdEmail'");
			    	if ($user_id) {
			    		# Insert into 'users_role'
			    		$role_result = insert_into_users_role($user_id,6,$username); // Inserted
			    		if ($role_result) {
			    			# Now we have to insert main details of the student
		    				$std_result = insert_into_student_M($stdRollNo,$stdName,$stdEmail,1,$user_id,$institute_id,$username);
		    				if ($std_result) {
		    					# Get student_id
		    					$stdID = get_column_from_table("student_id","student_m_details","user_id='$user_id' AND institute_id='$institute_id'");
		    					if ($stdID) {
		    						# Now insert into student_t_details
		    						$std_t_result = insert_into_student_T($stdID,$department_id,$program_id,$institute_id,$username);
		    						if ($std_t_result) {
		    							$std_course = insert_into_student_course($stdID,$course_id,$institute_id,$academic_yr,$session,$semester,$username);
		    							if ($std_course) {
		    								# code...
		    							}else delete_row_in_table("users", "user_id='$user_id'");
		    						}else delete_row_in_table("users", "user_id='$user_id'");
		    					}else delete_row_in_table("users", "user_id='$user_id'");
		    				}else delete_row_in_table("users", "user_id='$user_id'");
			    		}else delete_row_in_table("users", "user_id='$user_id'");
			    	}else delete_row_in_table("users", "username='$stdEmail'");
			    }else{
			    	# nothing inserted...
			    }
	    	}
	    }elseif ($old_new=="old") {
	    	# Insert into 'student_course' table
	    	$std_course = insert_into_student_course($student_id,$course_id,$institute_id,$academic_yr,$session,$semester,$username);// inserted
	  
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
			if ($std_course) {
				?>
					<p>Student successfully registered. <br>Redirecting back to Student-Registration Form...</p>
				<?php
				header( "refresh:3;url=new_student_form.php" );
			}else{
				?>
					<div id="warning" class="alert alert-block">
						<strong>Error!</strong> Student couldn't registered.
					</div>
					<button id="close" class="btn btn-danger">Close</button>
				<?php
			}
		?>
	</body>
</html>