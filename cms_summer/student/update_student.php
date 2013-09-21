<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$institute_No = $_SESSION["institute_id"];
	$username = $_SESSION["username"];

	if (isset($_POST["submit"])) {
		$std_Name = mysql_real_escape_string($_POST["std_Name"]);
		$father_Name = mysql_real_escape_string($_POST["father_Name"]);
		$mother_Name = mysql_real_escape_string($_POST["mother_Name"]);
		$std_address = mysql_real_escape_string($_POST["std_address"]);
		$pincode = mysql_real_escape_string($_POST["pincode"]);
		$mobile = mysql_real_escape_string($_POST["mobile"]);
		$blood_group = mysql_real_escape_string($_POST["blood_group"]);
		$user_id = mysql_real_escape_string($_POST["user_id"]);

		if ($std_Name!="" && !is_null($std_Name)) {
			$sql = "UPDATE student
					SET student_name = '$std_Name',
						father_name = '$father_Name',
						mother_name = '$mother_Name',
						address = '$std_address',
						pin_code = '$pincode',
						mobile_no = '$mobile',
						blood_group = '$blood_group',
						updated_by = '$username',
						updated_at = '".date( 'Y-m-d H:i:s')."'
					WHERE user_id = '$user_id'
				";
			$result = mysql_query($sql) or die(mysql_error());

			if ($result) {
				header("Location: student_profile.php");
				exit;
			}
		}
	}
	
?>