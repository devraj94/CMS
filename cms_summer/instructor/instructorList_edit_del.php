<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");
	$institute_id = $_SESSION["institute_id"]; 

	# If Operation on row is type of 'Edit'
	if(mysql_real_escape_string($_POST['oper'])=='edit'){
		$id = mysql_real_escape_string($_POST["id"]);
		$name = mysql_real_escape_string($_POST["instructor_name"]);
		$address = mysql_real_escape_string($_POST["address"]);
		$contactNo = mysql_real_escape_string($_POST["contactNo"]);
		# if below three field are not empty
		// the actual query for update data 
		    $SQL = "UPDATE instructor_m_details
		    		SET instructor_name = '$name',
		    			address = '$address',
		    			contactNo = '$contactNo',
		                updated_at = '".date( 'Y-m-d H:i:s')."',
		                updated_by = '".$_SESSION["username"]."'
		    		WHERE instructor_id = '$id'
	    		"; 
		$result = mysql_query($SQL) or die("Couldn't execute query.".mysql_error());
		if ($result) {
			echo "string";
		}
		// 'Edit' operation ends	
	}elseif (mysql_real_escape_string($_POST['oper'])=='del') {
		$IDs = mysql_real_escape_string($_POST["id"]);
		$id = explode(",", $IDs);
		$role_id_value = ""; // 2 or 3 for primary and secondary
		for ($i=0; $i < sizeof($id); $i++) { 
			$user_id = get_column_from_table("user_id","instructor_m_details","instructor_id='$id[$i]'");
			$count=0;
			$sql = "SELECT role_id FROM users_role WHERE user_id='$user_id'";
			$result = mysql_query($sql);
			if ($result) {
				while ($row=mysql_fetch_array($result)) {
					if ($row["role_id"]!=4) {
						$count++;
					}
				}
				if ($count==0) {
					delete_row_in_table("users", "user_id='$user_id'");
				}else{
					delete_row_in_table("users_role","user_id='$user_id' AND role_id='4'");
				}
			}
		}// FOR Loop ends
	}
?>