<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./db_config.php");

	# Connecting to database
	$connection = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
	mysql_select_db($dbname , $connection);
	$ins_id = mysql_real_escape_string($_POST['instructor_id']);
	$institute_No = $_SESSION["institute_id"];
	$username = $_SESSION["username"];
	$ins_Name = mysql_real_escape_string($_POST['instructorName']);
	$ins_email = mysql_real_escape_string($_POST['instructorEmail']);
	$address = mysql_real_escape_string($_POST['address']);
	$contact = mysql_real_escape_string($_POST['contact']);
	$sql_ins = "UPDATE instructor_m_details
			SET 
				instructor_name = '$ins_Name',
				email_id = '$ins_email',
				address='$address',
				contactNo='$contact',
				updated_at = '".date('Y-m-d H:i:s')."',
				updated_by = '$username'
			WHERE 
				instructor_id='$ins_id' AND institute_id='$institute_No'";
	$result_ins = mysql_query($sql_ins);

	
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
			if ($result_ins) {
				?>
					<p>Instructor successfully updated. <br>Redirecting back to Instructor-Update Form...</p>
					<script type="text/javascript">
			$(function(){
				window.parent.$("#inlineframe").attr("src","instructortotal/instructor_profile.php");
			});
		</script>
				<?php
				header( "refresh:3;url=update_instructor_form.php?instructorName=$ins_Name&instructorEmail=$ins_email&contact=$contact&address=$address&instructorid=$ins_id&institute_No=$institute_No" );
			    
			}else{
				?>
					<div id="warning" class="alert alert-block">
						<strong>Error!</strong> Instructor couldn't be updated.
					</div>
					<button id="close" class="btn btn-danger">Close</button>
				<?php
			}
		?>
	</body>
</html>