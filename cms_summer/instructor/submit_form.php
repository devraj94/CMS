<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$institute_id = $_SESSION["institute_id"];
	$username = $_SESSION["username"];

	if (isset($_POST["condition"])){

		$condition=mysql_real_escape_string($_POST["condition"]);
		$email_id=mysql_real_escape_string($_POST["instEmail"]);
		$user_id = "";

		if ($condition=="new" || $condition=="old") {

			$name = mysql_real_escape_string($_POST["name"]);
			$address = mysql_real_escape_string($_POST["instAddress"]);
			$contactNo = mysql_real_escape_string($_POST["contactNo"]);

			if ($condition=="new") {
				$instPassword = rand_chars("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890", 5,FALSE); // Genrating random string for password
				
				$insert_result = insert_into_users($email_id,$instPassword,$institute_id,$username);

				if ($insert_result) {
					$user_id = get_column_from_table("user_id","users","username = '$email_id'");
					if ($user_id) {
						$insert_role = insert_into_users_role($user_id,4,$username);
						if ($insert_role) {
							$result_inst_sql = insert_into_instructor($name,$address,$email_id,$contactNo,1,$institute_id,$user_id,$username);
							if ($result_inst_sql) {
								//message("Congratulation!","New Instructor added successfully.");
							}else{
								delete_row_in_table("users", "user_id='$user_id'");
								message("ERROR!","Could not insert data for instructor.");
							}
						}else{
							delete_row_in_table("users", "user_id='$user_id'");
							message("ERROR!","Could not create role for this user.");
						}
					}else{
						delete_row_in_table("users", "username='$email_id'");
						message("ERROR!","Could not recieve user_id for this user, query might have failed.");
					}
				}else{
					message("ERROR!","Could not create user, query might have failed.");
				}
			}elseif ($condition=="old") {
				$user_id=mysql_real_escape_string($_POST["user_id"]); // Getting table name via post

				$role_result = insert_into_users_role($user_id,4,$username);
				if ($role_result) {
					$result_inst_sql = insert_into_instructor($name,$address,$email_id,$contactNo,1,$institute_id,$user_id,$username);
					if ($result_inst_sql) {
						//message("Congratulation!","New Instructor added successfully.");
					}else{
						delete_row_in_table("users_role", "user_id='$user_id' AND role_id='4'");
						message("ERROR!","Could not insert data for instructor.");
					}
				}else{
					message("ERROR!","Could not create role for this user, query might have failed.");
				}
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
				$("#close").click(function(){
					window.parent.$('#my_modal').modal('hide');
				});
			});
		</script>
	</head>
	<body>
		<?php
			if ($result_inst_sql) {
				?>
					<p>Instructor successfully registered. <br>Redirecting back to Instructor-Registration Form...</p>
				<?php
				header( "refresh:3;url=new_instructor_form.php" );
			}else{
				?>
					<div id="warning" class="alert alert-block">
						<strong>Error!</strong> Instructor couldn't registered.
					</div>
					<button id="close" class="btn btn-danger">Close</button>
				<?php
			}
		?>
	</body>
</html>