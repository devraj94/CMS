<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./db_config.php");
	include(dirname(dirname(__FILE__))."./instructortotal/function.php");

	$institute_id=$_SESSION['institute_id'];
	$instructor_id=$_SESSION['instructor_id'];
	$id=$_GET['id'];
	 $courseid=get_column_from_table("course_id","course_m_details","institute_id='$institute_id' AND course_code='$id'");
	// connect to the MySQL database server 
    $db = mysql_connect($dbhost, $dbuser, $dbpass) or die("Connection Error: " . mysql_error()); 
    // select the database 
    mysql_select_db($dbname) or die("Error connecting to db.");

	$result2 = get_count("student_course","institute_id='$institute_id' AND course_id='$courseid'");
    $row6 = mysql_fetch_array($result2); 
    $total = $row6['count'];
 
 $result3 = get_row_from_table("group_m_details","institute_id='$institute_id' AND course_id='$courseid' AND instructor_id='$instructor_id'");
    $row3 = mysql_fetch_array($result3); 
	$group_id=$row3['group_id'];
	$noofgroups=$row3['total_groups'];
	$description=$row3['description'];
	$groupname=$row3['group_name'];
	$stud=$total/$noofgroups;
	if($total%$noofgroups!=0){
	$stud=$stud+1;
	}
	$number=0;
?>	


<html>
	<head>
	<script src="../bootstrap/js/bootstrap.js"></script>
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-responsive.min.css">

		<script src="../bootstrap/pnotify-1.2.0/jquery.pnotify.js" type="text/javascript"></script>
		<link href="../bootstrap/pnotify-1.2.0/jquery.pnotify.default.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="../bootstrap/select/jquery.selectBoxIt.css">

		<style type="text/css">
			.control-group{margin: 0px} .ui-pnotify-history-container { display: none; }
		</style>
		<script src="../jquery_ui_lib/jquery_1.10.1.min.js"></script>
		<script src="../bootstrap/select/jquery.selectBoxIt.min.js" type="text/javascript"></script>
		<script src="../jquery_ui_lib/jquery_ui_1.10.3.min.js"></script>
		<script type="text/javascript">
			$(function(){
				$('input').addClass("ui-corner-all");
				// Event 'Blur' on textField email
				$('#group').blur(function(){
				var group=$('#group').val();
					var id1=<?php echo $courseid;?>;
					var stud=<?php echo $stud;?>;
					// Ajax call to retrieve data from database..
					$.ajax({
			            type: "POST",
			            url: "group/manage_groups_insert.php?hai=1",
			            data: {
			                grp: group,
							id:id1,
			            },
			            success: function(data) {
						
			            	   stud=stud-data;
			            		alert("You Can Select Only "+stud+" students in this group.");
						},
						failure: function() {
							alert('fail');
						}
					}); // ajax ends
				});

			});
		</script>

	</head>
	<body>
		<div id="add_course_form">
			<form class="form-horizontal" id="course_form" action="group/manage_groups_insert.php?grpid=<?php echo $group_id;?>&id=<?php echo $courseid;?>&name=<?php echo $groupname;?>&description=<?php echo $description;?>" method="POST">
				<table>
					<div class="control-group span5">
						<td><label for="group">Group :</label></td>
						<td>
							<select id="group"  name="group">
								<?php
								for($m=1;$m<=$noofgroups;$m++){
								$groupname=$groupname.$m;
								$result = get_count("group_t_details","institute_No='$institute_id' AND course_id='$courseid' AND instructor_id='$instructor_id' AND group_name='$groupname'");
								$row = mysql_fetch_array($result); 
								$count = $row['count'];
								    if($count<$stud){
										echo "<option value='".$groupname."'>".$groupname."</option>";
								    }
								}
									
						        ?>
							</select>
						</td>
					</div>
					<div class="control-group span5">
					<?php
					$s=1;
					$ac_year=get_academic_year();
                   $result2 = get_row_from_table("student_course","institute_id='$institute_id' AND course_id='$courseid' AND academic_year='$ac_year' ORDER BY student_id"); 
					$resulte = get_count("student_course","institute_id='$institute_id' AND course_id='$courseid' AND academic_year='$ac_year' ORDER BY student_id");
					$rt=mysql_fetch_array($resulte);
					$m=$rt['count'];
					while($m!=0){
					        $row=mysql_fetch_array($result2);
							$result1 = get_count("group_t_details","institute_id='$institute_id' AND student_id='".$row['student_id']."'");
						    $rts=mysql_fetch_array($result1);
					        $ms=$rts['count'];
							$stdname=get_column_from_table("student_name","student_m_details","institute_id='$institute_id' AND student_id='".$row['student_id']."'");
							if ($ms==0) {
                    	        $number++;
								echo "<tr>";
								echo  "<td><input type='checkbox' name='studentgrp[]' value='".$row['student_id']."'>".$stdname."</td><br>";
								echo "</tr>";
								$s++;
                            }
							$m--;
					}
	                
					
					?>
					</div>
					<tr>
					    <input type="text" name="condition" value="<?php echo $number; ?>" id="condition" style="display:none;">
					</tr>
			<div class="control-group span5">
					<td><button class="btn btn-primary" name="submit" type="submit" id="submit">Submit</button></td>
					<td><button class="btn" type="reset" id="reset" style="margin-left:15px;">Clear</button></td>
			</div>
				</table>
			</form>
		</div>
	</body>
</html>