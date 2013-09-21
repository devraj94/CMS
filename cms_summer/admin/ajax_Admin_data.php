<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$institute_id = $_SESSION["institute_id"];
	$username = $_SESSION["username"];
	$result_admin = "";
	$result_admin_2 = "";
	if (isset($_POST["submit"])) {
		$condition=mysql_real_escape_string($_POST["condition"]);
		$email_id=mysql_real_escape_string($_POST["email_id"]);
		$user_id = "";
		if ($condition=="new" || $condition=="old") {
			$name = mysql_real_escape_string($_POST["name"]);
			$role_id = mysql_real_escape_string($_POST["type"]);
			$designation = mysql_real_escape_string($_POST["designation"]);
			$status = mysql_real_escape_string($_POST["permission_status"]);
			
			if ($condition=="new") {
				$pass = rand_chars("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890", 5,FALSE); // Genrating string

				# sql for inserting into 'users' table
				$sql_user_result = insert_into_users($email_id,$pass,$institute_id,$username);
				if ($sql_user_result) {
					$user_id = get_column_from_table("user_id","users","username='$email_id'");
					$insert_role = insert_into_users_role($user_id,$role_id,$username);
					if ($insert_role) {
						$result_admin = insert_into_admin($name,$email_id,$designation,$status,$user_id,$institute_id,$username);
						if ($result_admin) {
							message("Congratulation!","New Admin added successfully.");
						}else{
							delete_row_in_table("users", "user_id='$user_id'");
							message("ERROR!","Could not insert data admin table.");
						}
					}else{ 
						delete_row_in_table("users", "user_id='$user_id'"); 
						message("ERROR!","Could not insert data for role.");
					}
				}else{
					message("ERROR!","Could not create user.");
				}

			}elseif ($condition=="old") {
				$user_id = mysql_real_escape_string($_POST["tab"]);
				# 
				$role_result = insert_into_users_role($user_id,$role_id,$username);
				if ($role_result) {
					$result_admin = insert_into_admin($name,$email_id,$designation,$status,$user_id,$institute_id,$username);
					if ($result_admin) {
						message("Congratulation!","New Admin added successfully.");
					}else{
						delete_row_in_table("users_role", "user_id='$user_id' AND role_id='$role_id'");
						message("ERROR!","Could not insert data in admin table.");
					}
				}else{ message("ERROR!","Could not insert data in role table."); }
			}
		}
	}else{
		# Data through 'GET'
		$email_id=mysql_real_escape_string($_POST["email"]);
		$cat="";
		$user_id="";
		$name = "";
		$sql = "SELECT t2.user_id,t2.role_id FROM users t1 INNER JOIN users_role t2 
				ON (t1.user_id=t2.user_id AND t1.username='".$email_id."')";
		$result = mysql_query($sql) or die("Couldn't execute query.<br><br>".mysql_error()."<br><br>".$query);
		if ($result) {
			while ($row=mysql_fetch_array($result)) {
				$cat.=",".$row["role_id"];
				$user_id=$row["user_id"];
			}

			if (strpos($cat,"2")!==FALSE || strpos($cat,"3")!==FALSE) {
				echo "Exist*administrator";
			}elseif (strpos($cat, "4")!==FALSE) {
				$name = get_column_from_table("instructor_name","instructor_m_details","user_id='$user_id'");
				echo $name."*".$user_id;
			}elseif (strpos($cat, "5")!==FALSE) {
				$name = get_column_from_table("ta_name","ta_m_details","user_id='$user_id'");
				echo $name."*".$user_id;
			}elseif (strpos($cat, "6")!==FALSE) {
				$name = get_column_from_table("student_name","student_m_details","user_id='$user_id'");
				echo $name."*".$user_id;
			}else{
				echo " * ";
			}
		}
	}
?>
