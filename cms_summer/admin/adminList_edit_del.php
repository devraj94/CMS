<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");
	$institute_id = $_SESSION["institute_id"]; 
	$username = $_SESSION["username"];

	# If Operation on row is type of 'Edit'
	if($_POST["oper"]=="edit"){
		$admin_id = mysql_real_escape_string($_POST["id"]);
		$admin_Name = mysql_real_escape_string($_POST["admin_name"]);
		$designation = mysql_real_escape_string($_POST["admin_designation"]);
		$role_id = mysql_real_escape_string($_POST["type"]);
		$old_role_id="";
		# if below three field are not empty
		if ($admin_id!="" && $admin_Name!="" && $role_id!="") {
			$user_id = get_column_from_table("user_id","admin_m_details","admin_id = '$admin_id'");
			// get old value of role_id
			$query = "SELECT role_id FROM users_role WHERE user_id='$user_id'";
			$my_result = mysql_query($query);
			if ($my_result) {
				while ($data = mysql_fetch_array($my_result)) {
					if ($data["role_id"]=="2") { $old_role_id = 2; break; }
					if ($data["role_id"]=="3") { $old_role_id = 3; break; }
				}

				// the actual query for update data 
			    $SQL = "UPDATE admin_m_details
			    		SET admin_name = '$admin_Name',
			    			admin_designation = '$designation',
			    			updated_by = '".$username."'
			    		WHERE admin_id = '$admin_id'
			    		"; 
			    $result = mysql_query($SQL) or die("Couldn't execute query.".mysql_error());

			    if ($result) {
			    	$update = update_a_column_of_table("users_role","role_id",$role_id,"user_id='$user_id' AND role_id='$old_role_id'",$username);
			    	if ($update) {
			    		echo "Admin succesfully updated.";
			    	}
			    }else{
			    	echo "Admin role couldn't change.";
			    }
			}
		}
	}elseif ($_POST["oper"]=="del") {
		$IDs = mysql_real_escape_string($_POST["id"]);
		$id = explode(",", $IDs);
		$role_id_value = ""; // 2 or 3 for primary and secondary
		for ($i=0; $i < sizeof($id); $i++) { 
			$user_id = get_column_from_table("user_id","admin_m_details","admin_id='$id[$i]'");
			$count=0;
			$sql = "SELECT role_id FROM users_role WHERE user_id='$user_id'";
			$result = mysql_query($sql);
			if ($result) {
				while ($row=mysql_fetch_array($result)) {
					if ($row["role_id"]!=2 && $row["role_id"]!=3) {
						$count++;
					}
				}
				if ($count==0) {
					delete_row_in_table("users", "user_id='$user_id'");
				}else{
					delete_row_in_table("users_role","user_id='$user_id' AND role_id='2'");
					delete_row_in_table("users_role","user_id='$user_id' AND role_id='3'");
				}
			}
		}// FOR Loop ends
	}
?>