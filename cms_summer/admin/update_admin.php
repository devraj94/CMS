<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$username = $_SESSION["username"];
	$institute_id = $_SESSION["institute_id"];
	$admin_id = mysql_real_escape_string($_POST['admin_id']);
	$instName = mysql_real_escape_string($_POST['instName']);

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

	        $files = glob('../files/institute_logo/'.$dir.'/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
					unlink($file); // delete file
			}

	        if (!file_exists("../files/institute_logo/".$dir."/".$filename)) {
	        	$tar="files/institute_logo/".$dir."/".$filename;
	        	$update_logo=update_a_column_of_table("institute_m_details","institute_logo",$tar,"institute_id='$institute_id'",$username);

	        	if ($update_logo) {
					move_uploaded_file($_FILES['file']['tmp_name'],$target);
	        	}
	        }
		}
	} // file upload finish
	
	$name = mysql_real_escape_string($_POST['adminName']);
	
	$result_admin = update_a_column_of_table("admin_m_details","admin_name",$name,"admin_id='$admin_id'",$username);

	if ($result_admin) {
		$sql_inst = "UPDATE institute_m_details
				SET 
					institute_short_name = '".mysql_real_escape_string($_POST['instShortName'])."',
					institute_address = '".mysql_real_escape_string($_POST["instAddress"])."',
					city = '".mysql_real_escape_string($_POST["city"])."',
					pin_code = '".mysql_real_escape_string($_POST["pin"])."',
					state = '".mysql_real_escape_string($_POST["state"])."',
					landline_no = '".mysql_real_escape_string($_POST["phone"])."',
					institute_domain = '".mysql_real_escape_string($_POST['instURL'])."',
					email_id = '".mysql_real_escape_string($_POST['instEmail'])."',
					institute_fax = '".mysql_real_escape_string($_POST["fax"])."',
					updated_by = '$username'
				WHERE 
					institute_id = '".$institute_id."'	
				";
		$result_inst = mysql_query($sql_inst) or die(mysql_error());

		if ($result_inst) {
			?>
				<script type="text/javascript">
					window.parent.$("#cong").dialog('option', 'title', 'SUCCESS!');
					window.parent.$("#cong").html("Profile updated successfully.");
					window.parent.$("#inlineframe").attr("src","admin/admin_profile.php");
					window.parent.$('#cong').dialog("open");
				</script>
			<?php
		}else{}
	}else{}
?>