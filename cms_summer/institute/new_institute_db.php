<?php
	
	session_start();
	include(dirname(dirname(__FILE__))."./function.php");	
	
	# Getting post data
	$instName = mysql_real_escape_string($_POST["instName"]);

	$tar = NULL;
	if($_FILES['file']['error'] >0){
		//echo "error uploading!!". $_FILES["file"]["error"] . "<br>";
	}else{
		if ($_FILES["file"]["type"] == "image/jpg" || $_FILES["file"]["type"] == "image/gif" || $_FILES["file"]["type"] == "image/jpeg" ||
			$_FILES["file"]["type"] == "image/pjpeg" || $_FILES["file"]["type"] == "image/png" || $_FILES["file"]["type"] == "image/x-png") {

			if (!file_exists('../files/institute_logo/')) mkdir('../files/institute_logo/');
			$dir="/".$instName;
	        if (!file_exists('../files/institute_logo/'.$dir)) mkdir('../files/institute_logo/'.$dir);

	        $filename=$_FILES["file"]["name"];
	        # So the final DIRECTORY will be
	        # files/institute_logo/institute_Name/fileName.pdf
	        $target="C:/xampp/htdocs/cms_summer/files/institute_logo/".$dir."/".$filename;

	        if (!file_exists("../files/institute_logo/".$dir."/".$filename)) {
	        	move_uploaded_file($_FILES['file']['tmp_name'],$target);
	        	$tar="files/institute_logo/".$dir."/".$filename;
	        }
		}
	} // file upload finish

	# Recieving POST data
	$instShrotName = mysql_real_escape_string($_POST["instShortName"]);
	$Email = mysql_real_escape_string($_POST["instEmail"]);
	$URL = mysql_real_escape_string($_POST["instURL"]);
	$adminName = mysql_real_escape_string($_POST["adminName"]);
	$adminEmail = mysql_real_escape_string($_POST["adminEmail"]);
	$adminPass = isset($_POST["adminPass"]) ? mysql_real_escape_string($_POST["adminPass"]) : '';
	$address = isset($_POST["address"]) ? mysql_real_escape_string($_POST["address"]) : NULL;
	$city = isset($_POST["cityName"]) ? mysql_real_escape_string($_POST["cityName"]) : NULL;
	$pin = isset($_POST["pincode"]) ? mysql_real_escape_string($_POST["pincode"]) : 0;
	$state = isset($_POST["state"]) ? mysql_real_escape_string($_POST["state"]) : NULL;
	$phone = isset($_POST["phone"]) ? mysql_real_escape_string($_POST["phone"]) : 0;
	$fax = isset($_POST["fax"]) ? mysql_real_escape_string($_POST["fax"]) : 0;
	$designation = isset($_POST["designation"]) ? mysql_real_escape_string($_POST["designation"]) : NULL;

	$inst_id = ""; // Institute id for administrator Table
	$user_id = ""; // Admin ID
	$found_username = FALSE;

	
	if (isset($_SESSION["username"])) {
		$username = $_SESSION["username"];
	}else{
		$username = $adminEmail;
	}

	$user_result = FALSE;
	$result1 = FALSE;
	$result2 = FALSE;
	$admin_result = FALSE;
	
		$status = 0;
		$user_records = mysql_result(mysql_query('SELECT COUNT(*) FROM users'), 0);
		if (!$user_records) { // if there are no institute or no user in database
			$status = 1;
		}
		# Inserting data into table
		$institute_result = insert_into_institute($instName,$instShrotName,$address,$city,$pin,$state,$phone,$URL,$Email,$fax,$status,$adminName,$username,$tar);
		if ($institute_result) {
			# Getting Institute id for above inserted entry
			$institute_id = get_column_from_table("institute_id","institute_m_details","institute_name='$instName'");

			if ($adminPass=="") {
				$adminPass = rand_chars("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890", 5,FALSE); // Genrating string
			}

			#insert into users table
			$user_result = insert_into_users($adminEmail,$adminPass,$institute_id,$username); // user created
			# Get 'user_id' from table 'users'
			$user_id = get_column_from_table("user_id","users","username='$adminEmail'"); 

			if ($user_records) {
				$result1 = insert_into_users_role($user_id,2,$username); // assign a role as admin
			}else{
				$result1 = insert_into_users_role($user_id,1,$username); // assign a role as master
				$result2 = insert_into_users_role($user_id,2,$username); // assign a role as admin
			}

			if (($user_result && $user_records && $result1) || ($user_result && !$user_records && $result1 && $result2)) {
				$admin_result = insert_into_admin($adminName,$adminEmail,$designation,1,$user_id,$institute_id,$username);
				if ($admin_result) {
					?>
						<script type="text/javascript">
							window.parent.$('#wait').dialog("open");
						</script>
					<?php
				}
			}
		}
	
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
				//
				$("#back").click(function(){
					window.location.href = 'new_institute_form.php';
				});

				//
				$("#close").click(function(){
					window.parent.$('#reg_modal').modal('hide');
				});
			});
		</script>
	</head>

	<body>
		<?php if ($admin_result) {
			?>
				<div id="success" class="alert alert-success">
					Institute successfully registered.
				</div>
			<?php
		}else{
			?>
				<div id="warning" class="alert alert-block">
					<strong>Warning!</strong>Could not register your institute.
				</div>
			<?php
		} ?>
		
		<button id="back" class="btn btn-primary">Back to Registration Page</button>&nbsp; or &nbsp; <button id="close" class="btn btn-danger">Close Window</button>

	</body>
		
</html>
