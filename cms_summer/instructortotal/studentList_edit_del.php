<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./db_config.php");
	$institute_id = $_SESSION["institute_id"]; 

	// connect to the MySQL database server 
	$db = mysql_connect($dbhost, $dbuser, $dbpass) or die("Connection Error: " . mysql_error()); 
	 
	// select the database 
	mysql_select_db($dbname) or die("Error connecting to db."); 
	
		# If Operation on row is type of 'Edit'
		if(mysql_real_escape_string($_POST['oper'])=='edit'){
		    $std_id = mysql_real_escape_string($_POST["id"]);
			$student_name = mysql_real_escape_string($_POST["student_name"]);
			$roll_no = mysql_real_escape_string($_POST["roll_no"]);
			$id=$_GET['id1'];
			# if below three field are not empty
			if ($student_name!="" && $roll_no!="") {
				// the actual query for update data 
			    $SQL = "UPDATE student_m_details
			    		SET student_name = '$student_name',
						    roll_no = '$roll_no',
			                updated_at = '".date( 'Y-m-d H:i:s')."',
			                updated_by = '".$_SESSION["username"]."'
			    		WHERE student_id = '$std_id' AND institute_id ='$institute_id'
			    		"; 
			    $result = mysql_query($SQL) or die("Couldn't execute query.".mysql_error());
			}else{
				# If any one of three field is empty
				exit();
			}
		}		// 'Edit' operation ends	
		
		if(mysql_real_escape_string($_POST['oper'])=='del'){
		$std_id = $_POST['id'];
		$sql="DELETE FROM student_course WHERE student_id='$std_id' AND institute_id='$institute_id' AND course_id='$id'";
		$result = mysql_query($sql) or die("Couldn't execute query.".mysql_error());
		}
?>