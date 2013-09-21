<?php
	include(dirname(dirname(__FILE__))."./../user_session.php");
	include(dirname(dirname(__FILE__))."./../db_config.php");
	include(dirname(dirname(__FILE__))."./function.php");
	$success=NULL;
if(isset($_GET['id'])){
    $institute_id = $_SESSION["institute_id"];
	$username = $_SESSION["username"];
	$instructorid=$_SESSION['instructor_id'];
    $acyear=get_academic_year();
	$session=get_session();
	$id=$_GET['id'];
	$courseid=get_column_from_table("course_id","course_m_details","institute_id='$institute_id' AND course_code='$id'");
	$assno=$_POST['assign_no'];
	$topic=$_POST['topic'];
	$duedate=$_POST['duedate'];
	$permissiondate=$_POST['permissiondate'];
	$fd=get_column_from_table("course_title","course_m_details","institute_id='$institute_id' AND course_id='$courseid'");
	$nm=get_column_from_table("institute_name","institute_m_details","institute_id='$institute_id' ");
	// connect to the MySQL database server 
    $db = mysql_connect($dbhost, $dbuser, $dbpass) or die("Connection Error: " . mysql_error()); 
    // select the database 
    mysql_select_db($dbname) or die("Error connecting to db.");

	?>
	<script src="js/jquery.js" type="text/javascript"></script>
	<script type="text/javascript">
	
	<?php
		if (is_uploaded_file($_FILES['file']['tmp_name'])) {
		?>
		   var st=<?php echo "File ". $_FILES['file']['name'] ." uploaded successfully.";?>;
		   alert(st);
		<?php
		} else {
		?> 
		var str=<?php echo "Possible file upload attack:filename '". $_FILES['file']['tmp_name'] . "'. "; ?>;
		alert(str);
		<?php
		}
		?>
	</script>
			
			
			
  <?php
	if($_FILES['file']['error'] >0){
	echo "error uploading!!";
	}else{
						$dir=$acyear;
					if (!file_exists('../../files/assignments/'.$dir)) {
			                   mkdir('../../files/assignments/'.$dir);
			        }
			        $dir=$dir."/".$session;
			        if (!file_exists('../../files/assignments/'.$dir)) {
			                   mkdir('../../files/assignments/'.$dir);
			        }
		       			 $dir=$dir."/".$nm;
			        if (!file_exists('../../files/assignments/'.$dir)) {
			                   mkdir('../../files/assignments/'.$dir);
			        }
			        $dir=$dir."/".$fd;
			         if (!file_exists('../../files/assignments/'.$dir)) {
			                   mkdir('../../files/assignments/'.$dir);
			        }
						$filename=$_FILES["file"]["name"];
						 $target="F:/XAMPP/htdocs/cms_summer/files/assignments/".$dir."/".$institute_id.$instructorid.$courseid.$filename;
			 if (!file_exists("../assignments/".$dir."/".$institute_id.$instructorid.$courseid.$filename)) {
		                    move_uploaded_file($_FILES['file']['tmp_name'],$target);
		                    $tar="files/assignments/".$dir."/".$institute_id.$instructorid.$courseid.$assno.$filename;
				            $sql_user = "INSERT INTO assignment_m_details (institute_id,instructor_id,course_id,assignment_code,assignment_no,topic_name,cur_date,due_date,permission_date,
												academic_year,session,filename,updated_by,created_by,updated_at,created_at)
							VALUES('$institute_id','$instructorid','$courseid','$institute_id.$instructorid.$courseid.$assno','$assno','$topic','".date( 'Y-m-d H:i:s')."','$duedate','$permissiondate',
								'$acyear','$session','$tar','$username','$username','".date( 'Y-m-d H:i:s')."','".date( 'Y-m-d H:i:s')."')";
				            mysql_query($sql_user, $db)or die("Couldn't execute query.".mysql_error());
						                            
								$success=1;
		     }else{
		        	$success=NULL;
		        }
        }
	 
	mysql_close($db);
}
     
	

	
	
if(isset($_GET['p'])){

	$id=$_GET['myid'];
	$courseid=get_column_from_table("course_id","course_m_details","institute_id='$institute_id' AND course_code='$id'");
 $institute_No = $_SESSION["institute_id"];
	$instructorid=$_SESSION['instructor_id'];
$assn=mysql_real_escape_string($_POST["assign"]);
$sql1="SELECT topic_name FROM assignment_m_details WHERE institute_id='$institute_id' AND instructor_id='$instructorid' AND assignment_id='$assn' AND course_id='$courseid'";
	$result1=mysql_query($sql1) or die("Error Connecting to Server1.".mysql_error());
	if($row=mysql_fetch_array($result1)){
	echo "yes";
	}else{
	echo "no";
	}
}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<script src="../../jquery_ui_lib/jquery_1.10.1.min.js"></script>
		<script src="../../jquery_ui_lib/jquery_ui_1.10.3.min.js"></script>
		<script src="../../bootstrap/js/bootstrap.js"></script>
		<link href="../../css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
		<link href="../../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
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
			if ($success && !isset($_POST["q"])) {
				?>
					<p>Assignment successfully uploaded.</p>
				<?php
			}elseif(!isset($_POST["q"]) && !$success){
				?>
					<div id="warning" class="alert alert-block">
						<strong>Error!</strong> Assignment unable to Upload.
					</div>
					<button id="close" class="btn btn-danger">Close</button>
				<?php
			}
		?>
	</body>
</html>