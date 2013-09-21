<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$institute_id = $_SESSION["institute_id"];
	$username = $_SESSION["username"];
	
	# Get POSTED Data
	$course_id = $_POST['selCourse'];
	$instructor_id = $_POST['selInstructor'];
	$prog_id = $_POST["prog"];
	$dep_id = $_POST["dep"];
	$acyear = get_academic_year();
	$session = get_session();
	$sem = $_POST['semester'];

	# Inserting into course_instructor table
	$result = insert_into_course_instructor($course_id,$prog_id,$dep_id,$instructor_id,$acyear,$sem,$session,$institute_id,$username);

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
			if ($result) {
				?>
					<p>Course added for the instructor. <br>Redirecting back to Form...</p>
				<?php
				header( "refresh:3;url=course_instructor.php" );
			}else{
				?>
					<div id="warning" class="alert alert-block">
						<strong>Error!</strong> Could not add course for the instructor.
					</div>
					<button id="close" class="btn btn-danger">Close</button>
				<?php
			}
		?>
	</body>
</html>