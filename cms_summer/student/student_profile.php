<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$username = $_SESSION["username"];
	$std_id = "";
	$std_Name = "";
	$std_Roll_No = "";
	$father_Name = "";
	$mother_Name = "";
	$std_Email = "";
	$program_Nmae = "";
	$department_Name = "";
	$std_address = "";
	$pincode = "";
	$mobile = "";
	$blood_group = "";
	$institute_No = $_SESSION["institute_id"];
	
	# Getting 'user_id' of the student from 'users' table
	$user_id = get_column_from_table("user_id","users","username = '$username'");

	# Getting details from 'student' table
	$result = get_row_from_table("student","user_id = '$user_id'");
	if (mysql_num_rows($result) > 0) {
		$row = mysql_fetch_array($result);
		$std_id = $row["std_id"];
		$std_Name = $row["student_name"];
		$std_Roll_No = $row["roll_no"];
		$father_Name = $row["father_name"];
		$mother_Name = $row["mother_name"];
		$std_Email = $row["email_id"];

		$prog_id = $row["program_id"];
		$program_Nmae = get_column_from_table("program_name","program","program_id='$prog_id'");

		$dep_id = $row["department_id"];
		$department_Name = get_column_from_table("department_name","department","department_id='$dep_id'");

		$std_address = $row["address"];
		$pincode = $row["pin_code"];
		$mobile = $row["mobile_no"];
		$blood_group = $row["blood_group"];
	}

	$passwordFound = 0;
	$_SESSION["successful"]=0;

	# For updating username and password
	if (isset($_POST['passChange'])) {
		$_SESSION["user_pass"]=1;

		$old_pass = mysql_real_escape_string($_POST['old_pass']);
		$new_Pass = mysql_real_escape_string($_POST['stdPass']);
		$new_re_Pass = mysql_real_escape_string($_POST['rePass']);
		
		$username_exits = 0;
		$user_sql = "SELECT * FROM users WHERE user_id = '$user_id'";
		$user_result = mysql_query($user_sql, $connection) or die(mysql_error());
		while ($u_row = mysql_fetch_array($user_result)) {
			if ($u_row["password"]==$old_pass && $u_row["username"]==$username) {
				$passwordFound++;
				break;
			}
		}

		# Check whether passwords match or not
		if ($new_Pass == $new_re_Pass && $passwordFound!=0) {
			$sql = "UPDATE users
					SET 
						password = '$new_Pass',
						updated_at = '".date( 'Y-m-d H:i:s')."',
						updated_by = '$username'
					WHERE 
						user_id = '$user_id'	
					";
			$result = mysql_query($sql) or die(mysql_error()); // Updated 
			if ($result) {
				$_SESSION["successful"]=1;
				$_SESSION["password"]=$new_Pass;
			}else{}
		}else{} 
	}else{}	
?>

<html>
	<head>
		<title>Student Profile</title>
		<script src="../jquery_ui_lib/jquery_1.10.1.min.js"></script>
		<script src="../jquery_ui_lib/jquery_ui_1.10.3.min.js"></script>
		<link href="../css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
			body,tbody.form_update_admin {
			    font-size: 75%;
			}
			html{padding: 10;}
			#profile-header{
				border-top-left-radius: 20;
				border-top-right-radius: 20;
				padding-left: 20; 
				width: 160;
				font-size: 20;
			}
			#profile_view{
				width: auto;
				border-bottom-left-radius: 15;
				border-bottom-right-radius: 15;
				border-top-right-radius: 15;
				padding-left: 20;
				background: rgba(215, 149, 44, 0.2);
			}
		</style>
		<script type="text/javascript">
			// increase the default animation speed to exaggerate the effect
			$.fx.speeds._default = 150;
			$(function() {
				$('#update_student_button').button();
				$('#change_pass_button').button();

				/* Jquery-UI-Dialog defination for Update_Profile Form*/
				$('#form_update_student').dialog({
					autoOpen: false,
					modal: true,
					width: 'auto',
					height: 'auto',
					show: "blind",
					hide: "fold",
					closeOnEscape: true,
					buttons: {
						Reset: function(){
							$("form")[1].reset();
						},
						Update: function(){
							$('#submitButton2').click();
						},
						Close: function(){
							$("form")[1].reset();
							$(this).dialog("close");
						}
					}
				});

				$('#form1').dialog({
					autoOpen: false,
					modal: true,
					width: 'auto',
					height: 'auto',
					show: "blind",
					hide: "blind",
					closeOnEscape: true,
					buttons: {
						Reset:function(){
							$('#adminPass').val('');
							$('#rePass').val('');
							$('#old_pass').val('');
						},
						Change: function(){
							$('#submit_btn').click();
						},
						Close: function(){
							$("form")[0].reset();
							$(this).dialog("close");
						}
					}
				});
			});	
		</script>
	</head>
	<body>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#pass_msg").delay(2000).hide(1000);
				$("#update_msg").delay(2000).hide(1000);
			});
			 
		</script>

		<!--####################################################################################################-->
		<!-- Student-Profile view starts from here -->
		<div class="ui-widget">
		<div class="ui-widget-header" id="profile-header">Profile</div>
		<div id="profile_view" style="display:''" class="ui-widget-content">
			<table cellspacing="0">
				<tbody>
						<tr>
							<td>Name :</td>
							<td><?php echo $std_Name;?></td>
						</tr>
						<tr>
							<td>Roll-No. :</td>
							<td><?php echo $std_Roll_No;?></td>
						</tr>
						<tr>
							<td>Email-id :</td>
							<td><?php echo $std_Email;?></td>
						</tr>
						<tr>
							<td>Program :</td>
							<td><?php echo $program_Nmae;?></td>
						</tr>
						<tr>
							<td>Department :</td>
							<td><?php echo $department_Name;?></td>
						</tr>
						<tr>
							<td>Father's Name :</td>
							<td><?php echo $father_Name;?></td>
						</tr>
						<tr>
							<td>Mother's Name :</td>
							<td><?php echo $mother_Name; ?></td>
						</tr>
						<tr>
							<td>Address :</td>
							<td><?php echo $std_address;?></td>
						</tr>
						<tr>
							<td>Pin-Code :</td>
							<td><?php echo $pincode;?></td>
						</tr>
						<tr>
							<td>Mobile No. :</td>
							<td><?php echo $mobile;?></td>
						</tr>
						<tr>
							<td>Blood-Group :</td>
							<td><?php echo $blood_group;?></td>
						</tr>
				</tbody>
			</table>
		</div>
		</div>	
		<!-- Student-Profile View ends here -->
		<!--####################################################################################################-->
		

		<button onclick="$('#form_update_student').dialog('open');" id="update_student_button">Edit Profile</button><br>


		<button onclick="$('#form1').dialog('open');" id="change_pass_button">Change Password</button>

		<!--####################################################################################################-->
		<!--Form to change Username and Password-->
		<div id="form1" title="Change Password" style="display:none;">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<table>
					<tbody>
						<tr>
							<td><label for="old_pass">Old Password :</label></td>
							<td><input type="password" name="old_pass" id="old_pass" required></td>
						</tr>
						<tr>
							<td><label for="stdPass">New Password :</label></td>
							<td><input type="password" name="stdPass" id="stdPass" required></td>
						</tr>
						<tr>
							<td><label for="rePass">Confirm Password :</label></td>
							<td><input type="password" name="rePass" id="rePass" required></td>
							<input style="display:none;" type="submit" name="passChange" id="submit_btn">
						</tr>
					</tbody>
				</table><!--Table Ends-->					
		</form>
		</div>
		<!-- Form for change password ends here -->
		<!--####################################################################################################-->

		<!--####################################################################################################-->
		<!-- Form for Update-Profile starts here -->
		<div id="form_update_student" title="Update Profile" style="display:none;">
		<form action="update_student.php" method="POST">
			<table>
				<tbody class="form_update_admin">
					<tr>
						<td><label for="std_Name">Name :</label></td>
						<td><input type="text" size="40" value="<?php echo $std_Name; ?>" name="std_Name" id="std_Name" required></td>
					</tr>
					<tr>
						<td><label for="father_Name">Father's Name :</label></td>
						<td><input type="text" name="father_Name" id="father_Name" value="<?php echo $father_Name; ?>"></td>
					</tr>
					<tr>
						<td><label for="mother_Name">Mother's Name :</label></td>
						<td><input type="text" name="mother_Name" id="mother_Name" value="<?php echo $mother_Name; ?>"></td>
					</tr>
					<tr>
						<td><label for="std_address">Address :</label></td>
						<td><textarea id="std_address" name="std_address"><?php echo $std_address; ?></textarea></td>
					</tr>
					<tr>
						<td><label for="pincode">Pincode :</label></td>
						<td><input type="text" name="pincode" id="pincode" value="<?php echo $pincode; ?>"></td>
					</tr>
					<tr>
						<td><label for="mobile">Mobile NO :</label></td>
						<td><input type="tel" name="mobile" id="mobile" value="<?php echo $mobile; ?>"></td>
					</tr>
					<tr>
						<td><label for="blood_group">Mobile NO :</label></td>
						<td><input type="text" name="blood_group" id="blood_group" value="<?php echo $blood_group; ?>"></td>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
						</td>
						<td><input type="submit" name="submit" id="submitButton2" style="display:none;"></td>
					</tr>
				</tbody>
			</table>
		</form>
		</div>
		<!-- Form for Update-Profile ends here -->
		<!--####################################################################################################-->


	</body>

</html>
<?php
			if ($passwordFound!=0 && $_SESSION["successful"]==0) {
				?>
					<script type="text/javascript">alert("Password not matched") </script>
				<?php
			}
			if ($_SESSION["successful"]==1) {
				$_SESSION["successful"]=0;
				?>
					<script type="text/javascript">alert("Password successfully changed.") </script>
				<?php
			}
			if ($passwordFound==0 && $_SESSION["user_pass"]==1) {
				$_SESSION["user_pass"]=0;
				?>
					<script type="text/javascript">alert("Password is wrong...") </script>
				<?php
			}
			
		?>