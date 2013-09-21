<?php
	include(dirname(dirname(__FILE__))."./../user_session.php");
	include(dirname(dirname(__FILE__))."./../db_config.php");
    include(dirname(dirname(__FILE__))."./function.php");
	$institute_id = $_SESSION["institute_id"];
	$username = $_SESSION["username"];
       
	$userid=get_column_from_table("user_id","users","username='$username'");
	
	
	
	$instructorid=get_column_from_table("instructor_id","instructor_m_details","user_id=".$userid."");
	$_SESSION['instructor_id']=$instructorid;
	# Function for generating random sting of charactors..
	# Where -
	# string $c is the string of characters to use.
	# integer $l is how long you want the string to be. 
	# boolean $u is whether or not a character can appear beside itself. 
	#
	

	// connect to the MySQL database server 
    $db = mysql_connect($dbhost, $dbuser, $dbpass) or die("Connection Error: " . mysql_error()); 
     
    // select the database 
    mysql_select_db($dbname) or die("Error connecting to db.");

    $result_ta_sql = NULL;
    $result_taa_sql = NULL;

	if (isset($_POST["condition"])){

		$condition=mysql_real_escape_string($_POST["condition"]);
		$taEmail=mysql_real_escape_string($_POST["taEmail"]);
		$user_id = "";

			$ta_name = mysql_real_escape_string($_POST["name"]);
			$ta_address = mysql_real_escape_string($_POST["taAddress"]);
			$ta_contactNo = mysql_real_escape_string($_POST["contactNo"]);
			if ($condition=="new") {
			
				$taPassword = rand_chars("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890", 5,FALSE); // Genrating random string for password
				
                              $cat=5;
				$rt=insert_into_users($taEmail,$taPassword,$institute_id,$username);
				if($rt){
					$userid=get_column_from_table("user_id","users","username='$taEmail' AND institute_id='$institute_id'");
					$se=insert_into_users_role($userid,$cat,$username);
					if($se){
						# get 'user_id' of newly added user
						$result = get_row_from_table("users","username = '$taEmail' AND institute_id='$institute_id' LIMIT 1");

						while ($row = mysql_fetch_array($result)) {
							$user_id = $row["user_id"];
						}

						
						$result_taa_sql = insert_into_TA_m_details($ta_name,$ta_address,$taEmail,$ta_contactNo,$institute_id,$user_id,$username);
					}else{
					      delete_row_in_table("users","user_id='$user_id'");
					}
				}

			}elseif ($condition=="old") {
				$cat = ""; // To store category for a user 

				$table_name=mysql_real_escape_string($_POST["type"]); // Getting table name via post

				# now we have get 'user_id' from the table where 'user' exist with given 'email_id'
				$result_select = get_row_from_table($table_name,"email_id ='$taEmail' AND institute_id='$institute_id' LIMIT 1");

				while (mysql_num_rows($result_select)>0) {
				$row = mysql_fetch_array($result_select);
					$user_id = $row["user_id"];
				}

				
				$select_result = get_row_from_table("users_role","user_id='$user_id'");

				while ($row = mysql_fetch_array($select_result)) {
					$cat = $row["role_id"];
				}
				$cat = $cat.",5";

				# now we have to update the column('cat') for the existing 'user'
				$sql = "UPDATE users_role
						SET role_id = '$cat',
							updated_at = '".date( 'Y-m-d H:i:s')."',
							updated_by = '$username'
						WHERE user_id = '$user_id'";
				mysql_query($sql, $db) or die(mysql_error());

			}
			
			if ($condition=="new" || $condition=="old" || $condition=="ins") {
				$ta_name = mysql_real_escape_string($_POST["name"]);
	            $username = $_SESSION["username"];
                $tasem=mysql_real_escape_string($_POST["sem"]);
            $courseid=mysql_real_escape_string($_POST["course"]);
				$insid=$_SESSION['instructor_id'];
		        $ta_result = get_row_from_table("ta_m_details","institute_id = '$institute_id' AND email_id = '".$taEmail."'");
				$array = mysql_fetch_array($ta_result);
				$taid=$array['ta_id'];
				$acyear=get_academic_year();
				$session=get_session();
				$result_ta_sql=insert_into_ta_instructor_course($taid,$insid,$institute_id,$courseid,$tasem,$session,$acyear,$username);
	        }

	}else{
		# Data through 'POST'
		$email_id=mysql_real_escape_string($_POST["email"]);

		# SQL Query for searching in 'Administrator' table
		$admin_result = get_row_from_table("admin_m_details","institute_id = '$institute_id' AND email_id = '".$email_id."' LIMIT 1");
		
		# SQL Query for searching in 'ta_instructorr' table
		        $ta_result =get_row_from_table("ta_m_details","institute_id = '$institute_id' AND email_id = '".$email_id."'");
				$array = mysql_fetch_array($ta_result);
				$taid=$array['ta_id'];
		$tains_result = get_row_from_table("ta_instructor_course","institute_id = '$institute_id' AND ta_id = '".$taid."' AND instructor_id='".$instructorid."'");

		# SQL Query for searching in 'Instructor' table
		$ta_result = get_row_from_table("ta_m_details","institute_id = '$institute_id' AND email_id = '".$email_id."'
							LIMIT 1");

		# SQL Query for searching in 'Student' table
		$student_result = get_row_from_table("student_m_details","institute_id = '$institute_id' AND email_id = '".$email_id."' LIMIT 1");

		if(mysql_num_rows($ta_result) > 0){
		   $array = mysql_fetch_array($ta_result);
			$name = $array["ta_name"];
			$address = $array["address"];
			$contactno=$array["contactNo"];
			if(isset($_GET['ins'])){
					if(mysql_num_rows($tains_result)>0){
					        echo "Exist*no*".$name."*".$address."*".$contactno;
					}else{
					        echo "Exist*yes*".$name."*".$address."*".$contactno;
					}
			}else{
			echo "Exist*no*".$name."*".$address."*".$contactno;
			}
			
		}elseif (mysql_num_rows($admin_result) > 0) {
			$array = mysql_fetch_array($admin_result);
			$name = $array["name"];
			echo $name."*admin_m_details* ";
		}elseif (mysql_num_rows($student_result) > 0) {
			$array = mysql_fetch_array($student_result);
			$name = $array["student_name"];
			$address = $array["address"];
			echo $name."*student*".$address;
		}else{
			echo " * ";
		}
	}// else end
	mysql_close($db);
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
			if ($result_ta_sql || $result_taa_sql) {
				?>
					<p>TA successfully registered. <br>Redirecting back to TA-Registration Form...</p>
				<?php
				header( "refresh:3;url=new_ta_form.php?ins=1" );
			}else{
				?>
					<div id="warning" class="alert alert-block">
						<strong>Error!</strong> TA couldn't registered.
					</div>
					<button id="close" class="btn btn-danger">Close</button>
				<?php
					}
		?>
	</body>
</html>
