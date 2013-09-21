<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./db_config.php");
	include(dirname(dirname(__FILE__))."./function.php");
if(isset($_GET['id'])){
    $institute_No = $_SESSION["institute_id"];
	$username = $_SESSION["username"];
	$instructorid=$_SESSION['instructor_id'];
    $acyear=get_academic_year();
	$session=get_session();
	$courseid=$_GET['id'];
	$assno=$_POST['assign_no'];
	$topic=$_POST['topic'];
	$duedate=$_POST['duedate'];
	$fd=get_column_from_table("name","course","institute_No='$institute_No' AND course_No='$courseid'");
	$nm=get_column_from_table("name","institute","institute_No='$institute_No' ");
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
					if (!file_exists('../files/assignments/'.$dir)) {
			                   mkdir('../files/assignments/'.$dir);
			        }
			        $dir=$dir."/".$session;
			        if (!file_exists('../files/assignments/'.$dir)) {
			                   mkdir('../files/assignments/'.$dir);
			        }
		       			 $dir=$dir."/".$nm;
			        if (!file_exists('../files/assignments/'.$dir)) {
			                   mkdir('../files/assignments/'.$dir);
			        }
			        $dir=$dir."/".$fd;
			         if (!file_exists('../files/assignments/'.$dir)) {
			                   mkdir('../files/assignments/'.$dir);
			        }
						$filename=$_FILES["file"]["name"];
						 $target="C:/xampp/htdocs/cms_summer/files/assignments/".$dir."/".$institute_No.$instructorid.$courseid.$filename;
			 if (!file_exists("../files/assignments/".$dir."/".$institute_No.$instructorid.$courseid.$filename)) {
		                    move_uploaded_file($_FILES['file']['tmp_name'],$target);
		                    $tar="files/assignments/".$dir."/".$institute_No.$instructorid.$courseid.$filename;
				            $sql_user = "INSERT INTO assignment (institute_No,instructor_id,course_id,assignment_id,topic,cur_date,due_date,
												academic_year,session,filename)
							VALUES('$institute_No','$instructorid','$courseid','$assno','$topic','".date( 'Y-m-d H:i:s')."','$duedate',
								'$acyear','$session','$tar')";
				            mysql_query($sql_user, $db)or die("Couldn't execute query.".mysql_error());
						                            
								?>
									<script type="text/javascript">
									alert("upload successful");
									var row_id=<?php echo $courseid; ?>;
									var myurl="allList/assignmentlist.php?id=";
									window.parent.$("#course_of_a_instructor_frame").attr({
								    									"scrolling": "no", 
								    									"src":myurl+row_id,
								    									"width":"700",
								    									"height":"400"
								    								});
								    window.parent.$("#course_of_a_instructor_div").dialog({title:"Assignment List"});
								    window.parent.$("#course_of_a_instructor_div").dialog("open");
										
									</script>
								<?php
		     }else{
		        	?>
		            <script type="text/javascript">
						alert("file exists!!! try changing file name.");
										// to open pop-up dialog from parent window
										var id=<?php echo $courseid; ?>;
										window.parent.$("#course_of_a_instructor_frame").attr({
				    									"scrolling": "no", 
				    									"src":"assignment/upload.php?id="+id,
				    									"width":"400",
				    									"height":"180"
				    								});
					    	window.parent.$("#course_of_a_instructor_div").dialog({title:"Upload New Assignment"});
				             window.parent.$("#course_of_a_instructor_div").dialog("open");
					</script>
		            <?php
		        }
        }
	 
	mysql_close($db);
}
     
	

	
	
if(isset($_GET['p'])){

	$courseid=$_GET['myid'];
 $institute_No = $_SESSION["institute_id"];
	$instructorid=$_SESSION['instructor_id'];
$assn=mysql_real_escape_string($_POST["assign"]);
$sql1="SELECT topic FROM assignment WHERE institute_No='$institute_No' AND instructor_id='$instructorid' AND assignment_id='$assn' AND course_id='$courseid'";
	$result1=mysql_query($sql1) or die("Error Connecting to Server1.".mysql_error());
	if($row=mysql_fetch_array($result1)){
	echo "yes";
	}else{
	echo "no";
	}
}	
?>