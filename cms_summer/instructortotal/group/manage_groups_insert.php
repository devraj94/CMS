<?php
include(dirname(dirname(__FILE__))."./../user_session.php");
	include(dirname(dirname(__FILE__))."./../db_config.php");
	include(dirname(dirname(__FILE__))."./function.php");
   $red=NULL;
    $institute_id=$_SESSION['institute_id'];
	$instructor_id=$_SESSION['instructor_id'];
	$username=$_SESSION['username'];
	if(isset($_GET['hai'])){
			$courseid=$_POST['id'];
			$group=$_POST['grp'];
							$result = get_count("group_t_table","institute_id='$institute_id' group_name='$group'"); 
								if($result){
									$row = mysql_fetch_array($result,MYSQL_ASSOC); 
									$count = $row['count'];
									echo $count;
								}else{
									echo 0;
								}
	}else{
	$number=$_POST['condition'];
	$id=$_GET['id'];
	$name=$_GET['name'];
	$description=$_GET['description'];
	$acyear=get_academic_year();
	$session=get_session();
	$groupname=$_POST['group'];
	$grpid=$_GET['grpid'];
			foreach($_POST['studentgrp'] as $l){
			$sem = get_column_from_table("semester","student_course","institute_id='$institute_id' AND course_id='$id' AND academic_year='$acyear' AND student_id='$l'"); 
				$red=insert_into_group_t_details($institute_id,$grpid,$groupname,$l,$acyear,$session,$sem,$username);
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
			if ($red) {
				?>
					<p>Grouping Successful.</p>
				<?php
			}else{
				?>
					<div id="warning" class="alert alert-block">
						<strong>Error!</strong> Student couldn't registered.
					</div>
					<button id="close" class="btn btn-danger">Close</button>
				<?php
			}
		?>
	</body>
</html>