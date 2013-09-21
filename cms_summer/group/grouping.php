<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./db_config.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$institute_No = $_SESSION["institute_id"];
	// connect to the MySQL database server 
    $db = mysql_connect($dbhost, $dbuser, $dbpass) or die("Connection Error: " . mysql_error()); 
    // select the database 
    mysql_select_db($dbname) or die("Error connecting to db.");

	$result = get_row_from_table("program","institute_No='$institute_No'");
	$id=$_GET['id'];
	
	$count = get_count("student_reg","institute_No='$institute_No' AND course_id='$id'");
	
	if(isset($_GET['empty'])){
	$string="groupingdata.php?empty=1&id=".$id;
	}else{
	$string="groupingdata.php?id=".$id;
	}
?>

<html>
	<head>
	
	<title>Grouping</title>
			
	</head>
	<body>
		<div id="assignment_form_div">
			<form id="assign_form" enctype="multipart/form-data" action="<?php echo $string;?>" method="POST">
				<table>
					<tr>
						<td><label for="students">Total no of Students :</label></td>
						<td><input id="students" value="<?php echo $count; ?>" name="students" readonly></td>
					</tr>
					<tr>
					<?php
					if(isset($_GET['empty'])){
						echo "<td><label for='no_of_groups'>No Of Groups :</label></td>";
						echo "<td><input id='no_of_groups' type='text' name='no_of_groups' required></td>";
						}else{
						echo "<td><label for='pergroup'>Students Per Group :</label></td>";
						echo "<td><input id='pergroup' type='text' name='pergroup' required></td>";
						}
					?>
					</tr>
					<tr>
       					<td><label for="groupname">Group Name :</label></td>
						<td><input id="groupname" type="text" name="groupname"></td>
					</tr>
					<tr>
       					<td><label for="description">Description :</label></td>
						<td><input id="decription" type="text" name="description"></td>
					</tr>
					<tr>
					<?php
					if(isset($_GET['group'])){
					   echo "<td><input type='reset' id='reset'></td>";
					   echo	"<td><input type='submit' id='submit'></td>";
					}else{
					   echo "<input type='reset' id='reset' style='display:none;'>";
					   echo	"<input type='submit' id='submit' style='display:none;'>";
					}
					?>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>