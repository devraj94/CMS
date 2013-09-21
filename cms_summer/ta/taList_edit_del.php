<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./db_config.php");
	$institute_No = $_SESSION["institute_id"]; 

	// connect to the MySQL database server 
	$db = mysql_connect($dbhost, $dbuser, $dbpass) or die("Connection Error: " . mysql_error()); 
	 
	// select the database 
	mysql_select_db($dbname) or die("Error connecting to db."); 
	
		# If Operation on row is type of 'Edit'
		if(mysql_real_escape_string($_POST['oper'])=='edit'){
		    $ta_id = mysql_real_escape_string($_POST["ta_id"]);
			$ta_name = mysql_real_escape_string($_POST["name"]);
			$ta_address = mysql_real_escape_string($_POST["address"]);
			$contact = mysql_real_escape_string($_POST["contactNo"]);
			# if below three field are not empty
			if ($ta_name!="" && $ta_address!="" && $contact!="") {
				// the actual query for update data 
			    $SQL = "UPDATE ta
			    		SET name = '$ta_name',
						    address = '$ta_address',
							contactNo = '$contact',
			                updated_at = '".date( 'Y-m-d H:i:s')."',
			                updated_by = '".$_SESSION["username"]."'
			    		WHERE ta_id = '$ta_id' AND institute_no ='$institute_No'
			    		"; 
			    $result = mysql_query($SQL) or die("Connection Error: " . mysql_error());
			}else{
				# If any one of three field is empty
				exit();
			}
		}		// 'Edit' operation ends	
		
		if(mysql_real_escape_string($_POST['oper'])=='del'){
			$IDs = $_POST['id'];
			$ta_id = explode(",", $IDs);
			for ($i=0; $i < sizeof($ta_id); $i++) { 
				if (strpos($_SESSION["cat"], "2")!==false || strpos($_SESSION["cat"], "3")!==false) { 
					# If user is a Primary or Secondary Admin
					$result =delete_row_in_table("ta","ta_id='$ta_id' AND institute_No='$institute_No'");
				}else{
					$result =delete_row_in_table("ta_instructor","ta_id='$ta_id' AND institute_No='$institute_No'");
				}
			}
		}
?>