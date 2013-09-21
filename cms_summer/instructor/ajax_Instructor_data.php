<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$institute_id = $_SESSION["institute_id"];
	$username = $_SESSION["username"];

	# Data through 'POST'
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
				$name = get_column_from_table("admin_name","admin_m_details","user_id='$user_id'");
				echo $name."*".$user_id;
			}elseif (strpos($cat, "4")!==FALSE) {
				echo "Exist*administrator";
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

?>
	
