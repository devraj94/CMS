<?php
	include(dirname(dirname(__FILE__))."./db_config.php");
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

	###########################################################################################################################
	################################################## Functions for INSERT ###################################################
	###########################################################################################################################

	# function to insert new row in 'users' table
	function insert_into_users($user_username,$user_pass,$institute_id,$person)
	{
		$sql = "INSERT INTO users(username, password,institute_id,created_at,created_by,updated_at,updated_by)
				VALUES ('$user_username','$user_pass','$institute_id',
					'".date( 'Y-m-d H:i:s')."','$person','".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}
	
	# function to insert new row in 'users_role' table
	function insert_into_users_role($userid,$cat,$person)
	{
		$sql = "INSERT INTO users_role(user_id, role_id,created_at,created_by,updated_at,updated_by)
				VALUES ('$userid','$cat',
					'".date( 'Y-m-d H:i:s')."','$person','".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute queryqw.".mysql_error()); //inserted
	}

	# function to insert new row in 'administrator' table
	function insert_into_admin($adminName,$adminEmail,$designation,$user_id,$inst_id,$person)
	{
		$sql = "INSERT INTO administrator (name, email_id,user_id,institute_No,admin_designation,
						admin_permission_status,created_at,created_by,updated_at,updated_by)
			VALUES ('$adminName','$adminEmail','$user_id','$inst_id','$designation','1',
				'".date( 'Y-m-d H:i:s')."','$person','".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}

	# function to insert new row in 'institute' table
	function insert_into_institute($instName,$instEmail,$instURL,$adminName,$address,$cityName,$pincode,$state,$phone,$fax,$person)
	{
		$sql = "INSERT INTO institute (name, email_id,url,instAdmin,institute_address,city,pin_code,
						state,institute_phone,institute_fax,status,created_at,created_by,updated_at,updated_by) 
			VALUES ('$instName','$instEmail','$instURL','$adminName','$address','$cityName','$pincode',
				'$state','$phone','$fax','inactive',
				'".date( 'Y-m-d H:i:s')."','$person','".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}

	# function to insert new row in 'instructor' table
	function insert_into_instructor($name,$address,$instEmail,$contactNo,$institute_No,$user_id,$person)
	{
		$sql = "INSERT INTO instructor (name,address,email_id,contactNo,status, 
											institute_No,user_id,created_at,created_by,updated_at,updated_by)
				VALUES('$name','$address','$instEmail','$contactNo','1','$institute_No','$user_id',
					'".date( 'Y-m-d H:i:s')."','$person','".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}

	# function to insert new row in 'T.A.' table
	function insert_into_TA_m_details($ta_name,$ta_address,$taEmail,$ta_contactNo,$institute_id,$user_id,$person)
	{
		$sql = "INSERT INTO ta_m_details (ta_name,address,email_id,contactNo,status, 
											institute_id,user_id,created_at,created_by,updated_at,updated_by)
								VALUES('$ta_name','$ta_address','$taEmail','$ta_contactNo',
								'0','$institute_id','$user_id','".date( 'Y-m-d H:i:s')."',
								'$username','".date( 'Y-m-d H:i:s')."','$username')"; 
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}

	# function to insert new row in 'student' table
	function insert_into_student_m_details($stdRollNo,$stdName,$stdEmail,$father,$mother,$address,$pin,$mobile,$blood,$user_id,$institute_No,$person)
	{
		$sql = "INSERT INTO student_m_details(roll_no,student_name,email_id,father_name,mother_name,address,pin_code,mobile_no,blood_group,status,user_id,institute_id,
	    					updated_at,updated_by,created_at,created_by)
				VALUES ('$stdRollNo','$stdName','$stdEmail','$father','$mother','$address','pin','$mobile','$blood','1','$user_id','$institute_No',
							'".date( 'Y-m-d H:i:s')."','$person','".date( 'Y-m-d H:i:s')."','$person')";
		return mysql_query($sql) or die("Couldn't execute querysd.".mysql_error()); //inserted
	}

    # function to insert new row in 'student_m_details' table
	function insert_into_student_T($stdID,$dep,$prog_id,$institute_id,$person)
	{
		$sql = "INSERT INTO student_t_details(student_id,department_id,program_id,institute_id,created_at,created_by)
				VALUES ('$stdID','$dep','$prog_id','$institute_id','".date( 'Y-m-d H:i:s')."','$person')";
		return mysql_query($sql) or die("Couldn't execute query.<br><br>".mysql_error()."<br><br>".$sql); //inserted
	}
    # function to insert new row in 'student_course' table
	function insert_into_student_course($stdID,$courseID,$institute_id,$academic_yr,$session,$sem,$person)
	{
		$sql = "INSERT INTO student_course (student_id,course_id,institute_id,academic_year,session,semester,created_at,created_by)
				VALUES ('$stdID','$courseID','$institute_id','$academic_yr','$session','$sem','".date( 'Y-m-d H:i:s')."','$person')";
		return mysql_query($sql) or die("Couldn't execute queryss.<br><br>".mysql_error()."<br><br>".$sql); //inserted
	}
	# function to insert new row in 'program' table
	function insert_into_program($progCode,$progName,$institute_No,$person)
	{
		$sql = "INSERT INTO program (program_code,program_name,institute_No,created_at,created_by,updated_at,updated_by)
				VALUES('$progCode','$progName','$institute_No',
					'".date( 'Y-m-d H:i:s')."','$person','".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}

	# function to insert new row in 'course' table
	function insert_into_course($progCode,$progName,$institute_No,$person)
	{
		$sql = "INSERT INTO course (program_code,program_name,institute_No,created_at,created_by,updated_at,updated_by)
				VALUES('$progCode','$progName','$institute_No',
					'".date( 'Y-m-d H:i:s')."','$person','".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}
	
	# function to insert new row in 'course-instructor' table
	function insert_into_course_instructor($courseid,$instructor_id,$academicyear,$sem,$session,$institute_No,$person)
	{
		$sql = "INSERT INTO course_instructor (course_id,instructor_id,academic_year,semester,session,institute_No,created_at,created_by,updated_at,updated_by)
						VALUES('$courseid','$instructor_id','$academicyear','$sem','$session','$institute_No',
							'".date( 'Y-m-d H:i:s')."','$person','".date( 'Y-m-d H:i:s')."','$person')";
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}

	# function to insert new row in 'department' table
	function insert_into_department($depatment_id,$department_code,$department_name,$status,$program_id,$institute_No)
	{
		$sql = "INSERT INTO department (department_id,department_code,department_name,status,program_id,institute_No,created_at,created_by,updated_at,updated_by)
				VALUES('$depatment_id','$department_code','$department_name','$status','$program_id','$institute_No',
					'".date( 'Y-m-d H:i:s')."','$person','".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}
	#insert into ta_instructor
	function insert_into_ta_instructor_course($taid,$insid,$instituteid,$courseid,$sem,$session,$ac_year,$person)
	{
		$sql = "INSERT INTO ta_instructor_course (ta_id,instructor_id,institute_id,course_id,semester,session,status,
						academic_year,created_at,created_by,updated_at,updated_by)
			VALUES ('$taid','$insid','$instituteid','$courseid','$sem','$session',1,'$ac_year',
				'".date( 'Y-m-d H:i:s')."','$person','".date( 'Y-m-d H:i:s')."','$person')"; 
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}
	function insert_into_group_m_details($institute_No,$courseid,$instructor_id,$groupname,$description,$totalgroups,$studno,$acyear,$session,$person)
	{
		$sql2 = "INSERT INTO group_m_details (institute_id,course_id,instructor_id,group_name,description,Total_groups,student_no,Academic_year,Session,created_at,created_by,updated_at,updated_by)
	         VALUES ('$institute_No','$courseid','$instructor_id','$groupname','$description','$totalgroups','$studno','$acyear','$session','".date( 'Y-m-d H:i:s')."','$person','".date( 'Y-m-d H:i:s')."','$person')";
		   return  mysql_query($sql2) or die("Couldn't execute queryw.".mysql_error());
	}

	function insert_into_group_t_details($institute_No,$group_id,$group_name,$roll_no,$acyear,$session,$sem,$person)
	{
       
       $sql_user = "INSERT INTO group_t_details (institute_id,group_id,group_name,student_id,academic_year,session,semester,created_at,created_by,updated_at,updated_by)
					VALUES('$institute_No','$group_id','$group_name','$roll_no','$acyear','$session','$sem','".date( 'Y-m-d H:i:s')."','$person','".date( 'Y-m-d H:i:s')."','$person')";
		   return mysql_query($sql_user)or die("Couldn't execute query.".mysql_error());
	}
	


	###########################################################################################################################
	################################################## Function for count ####################################################
	###########################################################################################################################

	function get_count($table,$where)
	{
      $sql="SELECT COUNT(*) AS count FROM $table WHERE $where";
									return	mysql_query($sql); 
										
	}

	###########################################################################################################################
	################################################## Function for UPDATE ####################################################
	###########################################################################################################################

	# function to update 'users' table
	function update_a_column_of_table($table,$column,$value,$where,$person)
	{
		$sql = "UPDATE $table 
		         SET $column='$value',
				 updated_at = '".date( 'Y-m-d H:i:s')."',
				 updated_by = '$person'
				 WHERE $where";
		return mysql_query($sql) or die("Couldn't execute query.".mysql_error()); //inserted
	}
	
	###########################################################################################################################
	################################################## Function for DELETE ####################################################
	###########################################################################################################################

	function delete_row_in_table($table, $condition)
	{
		$sql = "DELETE FROM $table WHERE $condition";
		return mysql_query($sql);
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
?>