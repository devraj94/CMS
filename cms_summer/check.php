<?php
	session_start();
	include(dirname(__FILE__)."./function.php");
	
	$_SESSION['instName'] = "";
	$_SESSION['institute_id'] = "";

	$inst_id = mysql_real_escape_string($_POST['instList']); // Get Institute_id
	if ($inst_id=='-') { // If institue is not selected then simply stop the process and alert to user
		?>
			<script type="text/javascript">
				alert("Please select Institute.");
				document.location.href = 'HomePage.php';
			</script>
		<?php
		exit();
	}
	# Get entered 'username' & 'password'
	$username = mysql_real_escape_string($_POST['username']);
	$password = mysql_real_escape_string($_POST['password']);
	$can_login = false;

	# Check in users Table....
	$user_id = get_column_from_table("user_id","users","username = '$username' AND password='$password' AND institute_id='$inst_id'");
	if ($user_id) {
		if (row_exist("users_role","user_id='$user_id' AND role_id='1'")) { // if user is a master
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			$_SESSION['institute_id'] = $inst_id;
			$_SESSION["instName"] = get_column_from_table("institute_name","institute_m_details","institute_id='$inst_id'");
			$_SESSION["user_id"] = $user_id;
			header("Location: DashBoard.php");
			exit();
		}else{ // if user is not a master
			# then check whether institute is active or not
			$status = get_column_from_table("status","institute_m_details","institute_id='$inst_id'");
			if ($status=="0") {
				?>
					<script type="text/javascript">
						alert("Your institute is not active.");
						document.location.href = 'HomePage.php';
					</script>
				<?php
				exit();
			}elseif ($status=="1") { // If institute is active
				$sql = "SELECT role_id FROM users_role WHERE user_id='$user_id'";
				$result = mysql_query($sql) or die("Couldn't execute query.<br><br>".mysql_error()."<br><br>".$sql);
				while ($row = mysql_fetch_array($result)) {
					$role_id = $row["role_id"];
					$table = "";
					if ($role_id=="2" || $role_id=="3") {
						$table = "admin_m_details";
					}elseif ($role_id=="4") {
						$table = "instructor_m_details";
					}elseif ($role_id=="5") {
						$table = "ta_m_details";
					}elseif ($role_id=="6") {
						$table = "student_m_details";
					}

					if (get_column_from_table("status",$table,"user_id='$user_id'")=="1") {
						$can_login = true;
					}

					if ($can_login) {
						$_SESSION['username'] = $username;
						$_SESSION['password'] = $password;
						$_SESSION['institute_id'] = $inst_id;
						$_SESSION["instName"] = get_column_from_table("institute_name","institute_m_details","institute_id='$inst_id'");
						$_SESSION["user_id"] = $user_id;
						header("Location: DashBoard.php");
						exit();
					}
				}
				
				if (!$can_login) { // if user not active for any role
					?>
						<script type="text/javascript">
							alert("Your are not a active user. Please contact your administrator.");
							document.location.href = 'HomePage.php';
						</script>
					<?php
					exit();
				}
			}
		}
	}	
?>