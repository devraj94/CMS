<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$institute_id = $_SESSION["institute_id"];
	$username = $_SESSION["username"];

	$result=FALSE;
	$update_result=FALSE;
	$check = FALSE;

	if (isset($_POST["submit"]) && !isset($_POST["course_id"])) {
		$check = TRUE;
		//message_box("SUCCESS!","Course successfully added.",1,1); exit();
		$course_code = mysql_real_escape_string($_POST["course_code"]);
		$tar = NULL;

		if($_FILES['file']['error'] >0){
			//echo "error uploading!!". $_FILES["file"]["error"] . "<br>";
		}else{
			if ($_FILES["file"]["type"] == "application/pdf") {

				if (!file_exists('../files/course_description/')) mkdir('../files/course_description/');

				$dir ="/".get_column_from_table("institute_name","institute_m_details","institute_id='$institute_id' ");
		        if (!file_exists('../files/course_description/'.$dir)) mkdir('../files/course_description/'.$dir);

		        $dir.="/".$course_code;
		        if (!file_exists('../files/course_description/'.$dir)) mkdir('../files/course_description/'.$dir);

		        $filename=$_FILES["file"]["name"];
		        # So the final DIRECTORY will be
		        # files/course_description/academic_year/session/institute_Name/course_code/fileName.pdf
		        $target="C:/xampp/htdocs/cms_summer/files/course_description/".$dir."/".$filename;

		        if (!file_exists("../files/course_description/".$dir."/".$filename)) {
		        	move_uploaded_file($_FILES['file']['tmp_name'],$target);
		        	$tar="files/course_description/".$dir."/".$filename;
		        }
			}
		}

		$course_name = mysql_real_escape_string($_POST["course_title"]);
		$description = mysql_real_escape_string($_POST["description"]);

		$result = insert_into_course($course_code,$course_name,$description,$tar,$institute_id,1,$username);
	}elseif (isset($_POST["submit"]) && isset($_POST["course_id"])) {
		$course_id = mysql_real_escape_string($_POST["course_id"]);
		$course_code = mysql_real_escape_string($_POST["course_code"]);
		$course_title = mysql_real_escape_string($_POST["course_title"]);
		$description =mysql_real_escape_string($_POST["description"]);

		$tar = NULL;

		if($_FILES['file']['error'] >0){
			//echo "error uploading!!". $_FILES["file"]["error"] . "<br>";
		}else{
			if ($_FILES["file"]["type"] == "application/pdf") {

				if (!file_exists('../files/course_description/')) mkdir('../files/course_description/');

				$dir ="/".get_column_from_table("institute_name","institute_m_details","institute_id='$institute_id' ");
		        if (!file_exists('../files/course_description/'.$dir)) mkdir('../files/course_description/'.$dir);

		        $dir.="/".$course_code;
		        if (!file_exists('../files/course_description/'.$dir)) mkdir('../files/course_description/'.$dir);

		        $filename=$_FILES["file"]["name"];
		        # So the final DIRECTORY will be
		        # files/course_description/academic_year/session/institute_Name/course_code/fileName.pdf
		        $target="C:/xampp/htdocs/cms_summer/files/course_description/".$dir."/".$filename;

		        $files = glob('../files/course_description/'.$dir.'/*'); // get all file names
				foreach($files as $file){ // iterate files
					if(is_file($file))
						unlink($file); // delete file
				}

		        if (!file_exists("../files/course_description/".$dir."/".$filename)) {
		        	$tar="files/course_description/".$dir."/".$filename;
		        	$update_path = update_a_column_of_table("course_m_details","description_file_path",$tar,"course_code='$course_code' AND institute_id='$institute_id'",$username);

		        	if ($update_path) {
		        		move_uploaded_file($_FILES['file']['tmp_name'],$target);
		        	}
		        }
			}
		} // file update finish

		$SQL = "UPDATE course_m_details SET
					course_code = '$course_code',
					course_title = '$course_title',
					description = '$description',
					updated_by = '$username'
				WHERE course_id = '$course_id' AND institute_id = '$institute_id'";

		$update_result = mysql_query($SQL) or die("Couldn't execute query.".mysql_error());
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
			if ($result && !$update_result) {
				?>
					<h2>Success</h2>
					<p>Course successfully added. <br>Redirecting back to Course-Add Form...</p>
				<?php
				header( "refresh:3;url=course_add.php" );
			}elseif (!$result && $update_result) {
				?>
					<h2>Success</h2>
					<p>Course successfully updated.</p>
					<script type="text/javascript">
						window.parent.$('#my_modal').modal('hide');
					</script>
				<?php
			}elseif (!$result && !$update_result && $check) {
				if ($tar!=NULL) unlink("../".$tar);
			 	?>	
					<div id="warning" class="alert alert-block">
						<h2>Error!</h2>
						<p>Course couldn't added.</p>
					</div>
					<button id="close" class="btn btn-danger">Close</button>
				<?php
			}elseif (!$result && !$update_result && !$check) {
				if ($tar!=NULL) unlink("../".$tar);
			 	?>	
					<div id="warning" class="alert alert-block">
						<h2>Error!</h2>
						<p>Unable to update Course.</p>
					</div>
					<button id="close" class="btn btn-danger">Close</button>
				<?php
			}
		?>
	</body>
</html>