<?php
	include(dirname(dirname(__FILE__))."./../user_session.php");
	include(dirname(dirname(__FILE__))."./../db_config.php");
    include(dirname(dirname(__FILE__))."./function.php");
	$institute_No = $_SESSION["institute_id"]; 

	// connect to the MySQL database server 
	$db = mysql_connect($dbhost, $dbuser, $dbpass) or die("Connection Error: " . mysql_error()); 
	 
	// select the database 
	mysql_select_db($dbname) or die("Error connecting to db."); 
	
	$username = $_SESSION["username"];
       
	$userid=get_column_from_table("user_id","users","username='$username'");
	
	
	
	$instructorid=get_column_from_table("instructor_id","instructor_m_details","user_id=".$userid."");
	$_SESSION['instructor_id']=$instructorid;
	
		# If Operation on row is type of 'Edit'
		if(mysql_real_escape_string($_POST['oper'])=='edit'){
		    $ta_id = mysql_real_escape_string($_POST["ta_id"]);
			$ta_name = mysql_real_escape_string($_POST["name"]);
			$ta_address = mysql_real_escape_string($_POST["address"]);
			$contact = mysql_real_escape_string($_POST["contactNo"]);
			# if below three field are not empty
			if ($ta_name!="" && $ta_address!="" && $contact!="") {
				// the actual query for update data 
			    $SQL = "UPDATE ta_m_details
			    		SET name = '$ta_name',
						    address = '$ta_address',
							contactNo = '$contact',
			                updated_at = '".date( 'Y-m-d H:i:s')."',
			                updated_by = '".$_SESSION["username"]."'
			    		WHERE ta_id = '$ta_id' AND institute_id ='$institute_No'
			    		"; 
			}else{
				# If any one of three field is empty
				exit();
			}
		}		// 'Edit' operation ends	
		
		if(mysql_real_escape_string($_POST['oper'])=='del'){
		$ta_id = $_POST['id'];
		$result =delete_row_in_table("ta_instructor_course","ta_id='$ta_id' AND institute_id='$institute_No' AND instructor_id='$instructorid'");
		$resulta=get_row_from_table("ta_instructor_course","ta_id='$ta_id' AND institute_id='$institute_No'");
			if(mysql_num_rows($resulta)==0){
			$result_select = get_row_from_table("ta_m_details","email_id ='$taEmail' AND institute_id='$institute_No' LIMIT 1");

					while ($row = mysql_fetch_array($result_select)) {
						$user_id = $row["user_id"];
					}

					
					$select_result = get_row_from_table("users_role","user_id='$user_id'");

					while ($row = mysql_fetch_array($select_result)) {
						$cat = $row["role_id"];
					}
					$e="";
					$category=explode(',',$cat);
					$i=sizeof($category);
					for($u=0;$u<$i-1;$u++){
					 if($category[$u]!="5"){
					 $e=$e.$category[$i].",";
					 }
					}
					 if($category[$i-1]!="5"){
					   $e=$e.$category[$i-1];
					 }
					$sql = "UPDATE users_role
						SET role_id = '$e',
							updated_at = '".date( 'Y-m-d H:i:s')."',
							updated_by = '$username'
						WHERE user_id = '$user_id'";
				mysql_query($sql, $db) or die(mysql_error());
					
			}
		}
?>