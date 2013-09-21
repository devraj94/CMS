<?php
	include(dirname(dirname(__FILE__))."./../user_session.php");
	include(dirname(dirname(__FILE__))."./../db_config.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$institute_id = $_SESSION["institute_id"];
	// connect to the MySQL database server 
    $db = mysql_connect($dbhost, $dbuser, $dbpass) or die("Connection Error: " . mysql_error()); 
    // select the database 
    mysql_select_db($dbname) or die("Error connecting to db.");

	$result = get_row_from_table("program_m_details","institute_id='$institute_id'");
	$id=$_GET['id'];
	$ac_year=get_academic_year();
	$id=get_column_from_table("course_id","course_m_details","institute_id='$institute_id' AND course_code='$id'");
	$result = get_count("student_course","institute_id='$institute_id' AND course_id='$id' AND academic_year='$ac_year'");
	$rew=mysql_num_rows($result);
    $row = mysql_fetch_array($result,MYSQL_ASSOC); 
    $count = $row['count'];
	
	if(isset($_GET['empty'])){
	$string="groupingdata.php?empty=1&id=".$id;
	}else{
	$string="groupingdata.php?id=".$id;
	}
?>

<html>
	<head>
	<script src="../../bootstrap/js/bootstrap.js"></script>
		<link href="../../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap-responsive.min.css">

		<script src="../../bootstrap/pnotify-1.2.0/jquery.pnotify.js" type="text/javascript"></script>
		<link href="../../bootstrap/pnotify-1.2.0/jquery.pnotify.default.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="../../bootstrap/select/jquery.selectBoxIt.css">

		<style type="text/css">
			.control-group{margin: 0px} .ui-pnotify-history-container { display: none; }
		</style>
		<script src="../../bootstrap/select/jquery.selectBoxIt.min.js" type="text/javascript"></script>
	<title>Grouping</title>
			
	</head>
	<body>
			<form class="form-horizontal" id="assign_form" enctype="multipart/form-data" action="<?php echo $string;?>" method="POST">
					<div class="control-group span5">
						<label class="control-label" for="students">Total no of Students :</label>
						<div class="controls">
							<input class="input" id="students"  value="<?php echo $count; ?>" name="students" readonly>
							<span id="roll_img"></span>
						</div>
					</div>
					<div class="control-group span5">
					<?php
						if(isset($_GET['empty'])){
						echo "<label class='control-label' for='no_of_groups'>No Of Groups :</label>";
						echo "<div class='controls'>";
							echo "<input class='input' type='text' id='no_of_groups' name='no_of_groups' required>";
						echo "</div>";
						}else{
						echo "<label class='control-label' for='pergroup'>Per Group :</label>";
						echo "<div class='controls'>";
							echo "<input class='input' type='text' id='pergroup' name='pergroup' required>";
						echo "</div>";
						}
					?>
					</div>
							
					<div class="control-group span5">
						<label class="control-label" for="groupname">Group Name :</label>
						<div class="controls">
							<input class="input" type="text" id="groupname" name="groupname"  required>
						</div>
					</div>
					<div class="control-group span5">
						<label class="control-label" for="descrition">Description:</label>
						<div class="controls">
							<textarea rows="3" cols="30" id="description" name="description"></textarea>
						</div>
					<div class="control-group span5">
						<div class="controls">
							<button class="btn btn-primary" name="submit" type="submit" id="submit">Submit</button>
							<button class="btn" type="reset" id="reset" style="margin-left:15px;">Clear</button>
						</div>
					</div>
			</form>
	</body>
</html>