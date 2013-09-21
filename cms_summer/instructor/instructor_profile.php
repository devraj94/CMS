<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$instName = $_SESSION["instName"];
	$username = $_SESSION["username"];
	$user_id = "";
	$instructor_id = "";
	$instructorName = "";
	$instructorAddress = "";
	$instructorEmail = "";
	$institute_No = "";

	$passwordFound = 0;
	$_SESSION["successful"]=0; // to check whether password succefully changed


	
	# Getting 'user_id' from 'users' table
	$sql = "SELECT * FROM users WHERE username = '$username'";
	$result = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{ 		
		$user_id=$row["user_id"];
		break;
	}

	# Getting details from 'instructor' table
	$sql = "SELECT * FROM instructor WHERE user_id = '$user_id'";
	$result = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{ 
		$instructorName = $row["name"];
		$instructorEmail = $row["email_id"];
		$contact=$row['contactNo'];
		$address=$row['address'];
		$institute_No = $row["institute_No"];
		$instructorid = $row["instructor_id"];
	}

	# For updating username and password
	if (isset($_POST['passChange'])) {
		$_SESSION["user_pass"]=1;

		$old_pass = mysql_real_escape_string($_POST['old_pass']);
		$new_Pass = mysql_real_escape_string($_POST['instructorPass']);
		$new_re_Pass = mysql_real_escape_string($_POST['rePass']);
		
		$username_exits = 0;
		$user_sql = "SELECT * FROM users WHERE user_id = '$user_id'";
		$user_result = mysql_query($user_sql) or die(mysql_error());
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
		<title>Instructor Profile</title>
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
			#profile-details{
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
				$('#update_instructor_button').button();
				$('#change_pass_button').button();

				/* Jquery-UI-Dialog defination for Update_Profile Form*/
				$('#form_update_instructor').dialog({
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
							$('#instructorPass').val('');
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

				$('.myLink').click(function() { 
				    var data = $(this).attr('data');
				    var array = data.split("*");

				    window.parent.$("#course_of_a_instructor_frame").attr({
								    									"scrolling": "no", 
								    									"src":"allList/studentList.php?id="+array[0],
								    									"width":"760",
								    									"height":"400"
								    								});
				    window.parent.$("#course_of_a_instructor_div").dialog({title:"STUDENTS in "+array[1]});
				    window.parent.$("#course_of_a_instructor_div").dialog("open");
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
		<!-- instructor-Profile view starts from here -->
		<div class="ui-widget">
		<div class="ui-widget-header" id="profile-header">Profile</div>
		<div id="profile-details" style="display:''" class="ui-widget-content">
			<table>
				<tbody>
						<tr>
							<td><label for="instructorName">Your Name :</label></td>
							<td><label id="instructorName"><?php echo $instructorName;?></label></td>
						</tr>
						<tr>
							<td><label for="instructorEmail">Email-id :</label></td>
							<td><label id="instructorEmail"><?php echo $instructorEmail;?></label></td>
						</tr>
						<tr>
							<td><label for="courses">Courses :</label></td>
							<td><label id="courses">
							<?php 
								$sql = "SELECT * FROM course_instructor WHERE institute_No='$institute_No' AND instructor_id='$instructorid'";
				                $result = mysql_query($sql) or die(mysql_error()); 
								while($row=mysql_fetch_array($result)){
									$id=$row['course_id'];
									$sql1 = "SELECT * FROM course WHERE institute_No='$institute_No' AND course_No='$id'";
					                $result1 = mysql_query($sql1) or die(mysql_error()); 
									$rows=mysql_fetch_array($result1);
									//echo $rows['name']."(".$rows['course_id'].")<br />";
									echo "<a href='#' class='myLink' data='".$rows['course_No']."*".$rows['name']."'>".$rows['name']." (".$rows['course_id'].")</a><br />";
								}
							?>
							</label>
							</td>
						</tr>
						<tr>
							<td><label for="address">Address :</label></td>
							<td><label id="address"><?php echo $address;?></label></td>
						</tr>
						<tr>
							<td><label for="contact">Contact :</label></td>
							<td><label id="contact"><?php echo $contact;?></label></td>
						</tr>
				</tbody>
			</table>
		</div>
		</div>	
		<!-- Admin-Profile View ends here -->
		<!--####################################################################################################-->
		

		<button onclick="$('#form_update_instructor').dialog('open');" id="update_instructor_button">Edit Profile</button><br>


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
							<td><label for="instructorPass">New Password :</label></td>
							<td><input type="password" name="instructorPass" id="instructorPass" required></td>
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
		<div id="form_update_instructor" title="Update Profile" style="display:none;">
		<form action="update_instructor.php" method="POST">
			<table>
				<tbody class="form_update_instructor">
					<tr>
						<td><label for="instructorName">Instructor Name :</label></td>
						<td><input type="text" name="instructorName" id="instructorName" value="<?php echo $instructorName; ?>" required>*</td>
					</tr>
					<tr>
						<td><label for="instructorEmail">Instructor Email :</label></td>
						<td><input type="email" name="instructorEmail" id="instructorEmail" value="<?php echo $instructorEmail; ?>" readonly="readonly" required>*</td>
					</tr>
					<tr>
						<td><label for="contact">Contact :</label></td>
						<td><input type="text" name="contact" id="contact" value="<?php echo $contact; ?>" required>*</td>
					</tr>
					<tr>
						<td><label for="address">Address :</label></td>
						<td><TEXTAREA name="address" id="address" ROWS=10 COLS=20 required><?php echo $address; ?></TEXTAREA>*</td>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="instructor_id" value="<?php echo $instructorid; ?>">
							<input type="hidden" name="institute_No" value="<?php echo $institute_No; ?>">
						</td>
						<td><input type="submit" id="submitButton2" style="display:none;"></td>
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