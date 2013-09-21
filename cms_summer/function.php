<?php
	include("db_config.php");
	# Connecting to database
	$connection = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
	mysql_select_db($dbname , $connection);

	###########################################################################################################################
	################################################## Functions for SELECT ###################################################
	###########################################################################################################################

	# function to get a complete row from a table with given condition
	function get_row_from_table($table,$condition)
	{
		$sql = "SELECT * FROM $table WHERE $condition";
		return mysql_query($sql);
	}

	# function to get a particular column from a row in users table
	function get_column_from_table($column,$table,$condition) // this for single result
	{
		$sql = "SELECT $column FROM $table WHERE $condition LIMIT 1";
		//echo $sql;
		$result = mysql_query($sql) or die(mysql_error()."<br><br> Couldn't execute query<br><br>".$sql."<br><br>");
		if (mysql_num_rows($result) >0) {
			$array = mysql_fetch_array($result);
			return $array[$column];
		}else return FALSE;
	}

	# To get multiple result for a single column
	function get_all_from_column($column,$table,$condition)
	{
		$sql = "SELECT $column FROM $table WHERE $condition";
		return mysql_query($sql) or die(mysql_error());
	}

	# function to get multiple rows
	function get_rows($table,$condition)
	{
		$sql = "SELECT * FROM $table WHERE $condition";
		return mysql_query($sql) or die(mysql_error());
	}

	function get_count($table,$condition)
	{
		$sql = "SELECT COUNT(*) AS count FROM ".$table." WHERE ".$condition;
		$result = mysql_query($sql) or die(mysql_error());
		if ($result) {
			$row = mysql_fetch_array($result);
			return $row["count"];
		}else{
			return 0;
		}
	}

	###########################################################################################################################
	################################################## Functions for INSERT ###################################################
	###########################################################################################################################

	# function to insert new row in 'users' table
	function insert_into_users($username,$user_pass,$institute_id,$person)
	{
		$sql = "INSERT INTO users(username, password,institute_id,created_at,created_by)
				VALUES ('$username','$user_pass','$institute_id','".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.<br><br>".mysql_error()."<br><br>".$sql); //inserted
	}

	# function to insert new row in 'users_role' table
	function insert_into_users_role($user_id,$role_id,$person)
	{
		$sql = "INSERT INTO users_role(user_id, role_id,created_at,created_by)
				VALUES ('$user_id','$role_id','".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.<br><br>".mysql_error()."<br><br>".$sql); //inserted
	}

	# function to insert new row in 'administrator' table
	function insert_into_admin($name,$email,$designation,$status,$user_id,$inst_id,$person)
	{
		$sql = "INSERT INTO ADMIN_M_DETAILS (admin_name, email_id,admin_designation,status,user_id,institute_id,created_at,created_by)
				VALUES ('$name','$email','$designation','$status','$user_id','$inst_id',
					'".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.<br><br>".mysql_error()."<br><br>".$sql); //inserted
	}

	# function to insert new row in 'institute' table
	function insert_into_institute($instName,$instSrtName,$address,$city,$pin,$state,$phone,$URL,$Email,$fax,$status,$adminName,$person,$logo)
	{
		$sql = "INSERT INTO institute_m_details (institute_name, institute_short_name,institute_address,city,pin_code,state,landline_no,
						institute_domain,email_id,institute_fax,status,admin_name,created_at,created_by,institute_logo) 
				VALUES ('$instName','$instSrtName','$address','$city','$pin','$state','$phone','$URL','$Email',
						'$fax','$status','$adminName','".date( 'Y-m-d H:i:s')."','$person','$logo')"; 
		return mysql_query($sql) or die("Couldn't execute query.<br><br>".mysql_error()."<br><br>".$sql); //inserted
	}

	# function to insert new row in 'instructor' table
	function insert_into_instructor($name,$address,$instEmail,$contactNo,$status,$institute_id,$user_id,$person)
	{
		$sql = "INSERT INTO instructor_m_details (instructor_name,address,email_id,contactNo,status, 
											institute_id,user_id,created_at,created_by)
				VALUES('$name','$address','$instEmail','$contactNo','$status','$institute_id','$user_id',
					'".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.<br><br>".mysql_error()."<br><br>".$sql); //inserted
	}

	# function to insert new row in 'T.A.' table
	function insert_into_TA($name,$address,$email_id,$contactNo,$institute_id,$user_id,$person)
	{
		$sql = "INSERT INTO ta_m_details (name,address,email_id,contactNo,status,institute_id,user_id,created_at,created_by,updated_at,updated_by)
				VALUES('$name','$address','$email_id','$contactNo','1','$institute_id','$user_id',
					'".date( 'Y-m-d H:i:s')."','$person','".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.<br><br>".mysql_error()."<br><br>".$sql); //inserted
	}

	# function to insert new row in 'student_m_details' table
	function insert_into_student_T($stdID,$dep,$prog_id,$institute_id,$person)
	{
		$sql = "INSERT INTO student_t_details(student_id,department_id,program_id,institute_id,created_at,created_by)
				VALUES ('$stdID','$dep','$prog_id','$institute_id','".date( 'Y-m-d H:i:s')."','$person')";
		return mysql_query($sql) or die("Couldn't execute query.<br><br>".mysql_error()."<br><br>".$sql); //inserted
	}

	# function to insert new row in 'student_t_details' table
	function insert_into_student_M($rollN,$name,$email,$status,$user_id,$institute_id,$person)
	{
		$sql = "INSERT INTO student_m_details(roll_no,student_name,email_id,status,user_id,institute_id,created_at,created_by)
				VALUES ('$rollN','$name','$email','$status','$user_id','$institute_id','".date( 'Y-m-d H:i:s')."','$person')";
		return mysql_query($sql) or die("Couldn't execute query.<br><br>".mysql_error()."<br><br>".$sql); //inserted
	}

	# function to insert new row in 'student_course' table
	function insert_into_student_course($stdID,$courseID,$institute_id,$academic_yr,$session,$sem,$person)
	{
		$sql = "INSERT INTO student_course (student_id,course_id,institute_id,academic_year,session,semester,created_at,created_by)
				VALUES ('$stdID','$courseID','$institute_id','$academic_yr','$session','$sem','".date( 'Y-m-d H:i:s')."','$person')";
		return mysql_query($sql) or die("Couldn't execute query.<br><br>".mysql_error()."<br><br>".$sql); //inserted
	}

	# function to insert new row in 'program' table
	function insert_into_program($progCode,$progName,$status,$institute_id,$person)
	{
		$sql = "INSERT INTO program_m_details (program_code,program_name,status,institute_id,created_at,created_by)
				VALUES('$progCode','$progName','$status','$institute_id',
					'".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}

	# function to insert new row in 'course' table
	function insert_into_course($course_id,$name,$des,$path,$institute_id,$status,$person)
	{
		$sql = "INSERT INTO course_m_details (course_code,course_title,description,description_file_path,status,institute_id,created_at,created_by)
				VALUES('$course_id','$name','$des','$path','$status','$institute_id','".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}
	
	# function to insert new row in 'course-instructor' table
	function insert_into_course_instructor($c_id,$prog_id,$dep_id,$ins_id,$Ayear,$sem,$session,$institute_id,$person)
	{
		$sql = "INSERT INTO course_instructor (course_id,program_id,department_id,instructor_id,academic_year,semester,session,institute_id,created_at,created_by)
						VALUES('$c_id','$prog_id','$dep_id','$ins_id','$Ayear','$sem','$session','$institute_id',
							'".date( 'Y-m-d H:i:s')."','$person')";
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}

	# function to insert new row in 'department' table
	function insert_into_department($department_code,$department_name,$status,$institute_id,$person)
	{
		$sql = "INSERT INTO department_m_details (department_code,department_name,status,institute_id,created_at,created_by)
				VALUES('$department_code','$department_name','$status','$institute_id',
					'".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}

	# function to insert new row in 'department' table
	function insert_into_prog_dep($department_id,$program_id,$institute_id,$person)
	{
		$sql = "INSERT INTO program_department (department_id,program_id,institute_id,created_at,created_by)
				VALUES('$department_id','$program_id','$institute_id','".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}

	#insert into ta_instructor
	function insert_into_ta_instructor($taid,$insid,$instituteNo,$sem,$session,$ac_year,$person)
	{
		$sql = "INSERT INTO ta_instructor (ta_id,instructor_id,institute_id,semester,session,
						academic_year,created_at,created_by,updated_at,updated_by)
			VALUES ('$taid','$insid','$instituteNo','$sem','$session','$ac_year',
				'".date( 'Y-m-d H:i:s')."','$person','".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}

	#
	function insert_into_groups($institute_id,$courseid,$instructor_id,$groupname,$description,$totalgroups,$studno,$acyear,$session)
	{
		$sql2 = "INSERT INTO groups (institute_id,course_id,instructor_id,group_name,description,no_of_groups,student_no,Academic_year,Session)
	         VALUES ('$institute_id','$courseid','$instructor_id','$groupname','$description','$totalgroups','$studno','$acyear','$session')";
		   return  mysql_query($sql2) or die("Couldn't execute queryw.".mysql_error());
	}

	#
	function insert_into_studentgroups($institute_id,$instructor_id,$courseid,$student_id,$group_id,$groupno,$group_name,$description,$acyear,$session)
	{
       
       $sql_user = "INSERT INTO studentgroups (institute_id,instructor_id,course_id,student_id,group_id,group_No,group_name,description,academic_year,session)
					VALUES('$institute_id','$instructor_id','$courseid','$student_id','$group_id','$groupno','$group_name','$description','$acyear','$session')";
		   return mysql_query($sql_user)or die("Couldn't execute query.".mysql_error());
	}
	

	###########################################################################################################################
	################################################## Function for UPDATE ####################################################
	###########################################################################################################################

	# function to update 'admin' table
	# for update single column
	function update_a_column_of_table($table,$column,$value,$condition,$person)
	{
		$sql = "UPDATE $table 
				SET $column='$value',
					updated_by ='$person'
				WHERE $condition";
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //updated
	}
	
	###########################################################################################################################
	################################################## Function for DELETE ####################################################
	###########################################################################################################################

	function delete_row_in_table($table, $condition)
	{
		$sql = "DELETE FROM $table WHERE $condition";
		mysql_query($sql) or die("Couldn't execute query.".mysql_error());
	}

	###############################################################################################################################

	# Function for generating random sting of charactors..
	# Where -
	# string $c is the string of characters to use.
	# integer $l is how long you want the string to be. 
	# boolean $u is whether or not a character can appear beside itself.
	function rand_chars($c, $l, $u) { 
		if (!$u) 
			for ($s = '', $i = 0, $z = strlen($c)-1; $i < $l; $x = rand(0,$z), $s .= $c{$x}, $i++); 
		else for ($i = 0, $z = strlen($c)-1, $s = $c{rand(0,$z)}, $i = 1; $i != $l; $x = rand(0,$z), $s .= $c{$x}, $s = ($s{$i} == $s{$i-1} ? substr($s,0,-1) : $s), $i=strlen($s)); 
		return $s; 
	} // Function end here...

	# Function to get academic_year
	function get_academic_year()
	{
		$m = explode("-", date("Y-m-d"));
		$month = intval($m[1]);
		$year = intval($m[0]);
		if ($month > 6 && $month <= 12) {
			$academic_year = $year."-".(($year%100)+1);
		}elseif ($month > 0 && $month <= 6) {
			$academic_year = ($year-1)."-".($year%100);
		}
		return $academic_year;
	}

	function get_session()
	{
		$m = explode("-", date("Y-m-d"));
		$month = intval($m[1]);
		if ($month > 6 && $month <= 12) {
			return 1;
		}elseif ($month > 0 && $month <= 6) {
			return 2;
		}
	}

	# Function to get admin type : 2(Primary Admin) or 3(Secondary Admin)
	function get_admin_type($admin_id)
	{
		$sql = "SELECT type FROM administrator WHERE admin_id='$admin_id'";
		$result = mysql_query($sql) or die("Couldn't execute query.".mysql_error());
		if (mysql_num_rows($result)>0) {
			$array = mysql_fetch_array($result);
			return $array["type"];
		}else{
			return "error";
		}
	}

	#
	function row_exist($table,$condition)
	{
		$sql = "SELECT * FROM $table WHERE $condition";
		if (mysql_num_rows(mysql_query($sql)) > 0) {
			return TRUE;
		}else{
			return FALSE;
		}
	}

	function message($title,$data)
	{
		?>
			<script type="text/javascript">
				window.parent.$("#cong").dialog('option', 'title', '<?php echo $title; ?>');
				window.parent.$("#cong").html("<?php echo $data; ?>");
				window.parent.$('#cong').dialog("open");
			</script>
		<?php
		exit();
	}

	function message_box($title,$data,$reloadGrid,$x)
	{
		?>
			<script type="text/javascript">
				window.parent.showDialog('<?php echo $title ?>','<?php echo $data ?>',<?php echo $reloadGrid ?>,<?php echo $x ?>);
			</script>
		<?php
	}

	function recursiveRemove($dir) {
		$structure = glob(rtrim($dir, "/").'/*');
	    if (is_array($structure)) {
	        foreach($structure as $file) {
	            if (is_dir($file)) recursiveRemove($file);
	            elseif (is_file($file)) unlink($file);
	        }
	    }
	    rmdir($dir);
	}
?>