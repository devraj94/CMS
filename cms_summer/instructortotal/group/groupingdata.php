<?php
	include(dirname(dirname(__FILE__))."./../user_session.php");
	include(dirname(dirname(__FILE__))."./../db_config.php");
	include(dirname(dirname(__FILE__))."./function.php");
	$username=$_SESSION['username'];
	$res=NULL;
	$results=NULL;
if(!isset($_GET['empty'])){
	$institute_id=$_SESSION['institute_id'];
	$instructor_id=$_SESSION['instructor_id'];
	$courseid=$_GET['id'];
	$pergroup=$_POST['pergroup'];
	$total=$_POST['students'];
	$description=$_POST['description'];
	$session=get_session();
	$acyear=get_academic_year();
	$groupname=$_POST['groupname'];
	$i=$total/$pergroup;
	$xtra=$total%$pergroup;
	if($xtra==0){
	$totalgroups=$i;
	}else{
	$totalgroups=$i+1;
	}
	
	$resulta = get_row_from_table("group_m_details","institute_id='$institute_id' AND course_id='$courseid' AND instructor_id='$instructor_id'");
	if($resulta){
	
	$groupid=get_column_from_table("group_id","group_m_details","course_id='$courseid' AND institute_id='$institute_id' AND instructor_id='$instructor_id'");
    $resultf = delete_row_in_table("group_m_details","institute_id='$institute_id' AND course_id='$courseid' AND instructor_id='$instructor_id'");
		
	$result1 = delete_row_in_table("group_t_details","institute_id='$institute_id' AND group_id='$groupid'");
	}
	
	
	
	
	$results=insert_into_group_m_details($institute_id,$courseid,$instructor_id,$groupname,$description,$totalgroups,$pergroup,$acyear,$session,$username);
	$groupid=get_column_from_table("group_id","group_m_details","course_id='$courseid' AND institute_id='$institute_id' AND instructor_id='$instructor_id'");
	$ac_year=get_academic_year();
	$result2 = get_row_from_table("student_course","institute_id='$institute_id' AND course_id='$courseid' AND academic_year='$ac_year' ORDER BY student_id"); 
	for($m=1;$m<=$i;$m++){
	   for($g=0;$g<$pergroup;$g++){
			$row = mysql_fetch_array($result2,MYSQL_ASSOC); 
			$group_name=$groupname.$m;
			$groupno=$m;
			$studid=$row['student_id'];
			$res=insert_into_group_t_details($institute_id,$groupid,$group_name,$studid,$acyear,$session,$row['semester'],$username);
	   }
	}
	for($r=0;$r<$xtra;$r++){
	        $row = mysql_fetch_array($result2,MYSQL_ASSOC); 
			$h=$i+1;
			$group_name=$groupname.$h;
			$groupno=$h;
			$studid=$row['student_id'];
			$res=insert_into_group_t_details($institute_id,$groupid,$group_name,$studid,$acyear,$session,$row['semester'],$username);
			
	}
	
}

if(isset($_GET['empty'])){
	$total=$_POST['students'];
    $institute_id=$_SESSION['institute_id'];
	$instructor_id=$_SESSION['instructor_id'];
	$courseid=$_GET['id'];
	$noofgroups=$_POST['no_of_groups'];
	$description=$_POST['description'];
	$groupname=$_POST['groupname'];
	$session=get_session();
	$acyear=get_academic_year();
	$fe=get_count("student_course","institute_id='$institute_id' AND course_id='$courseid'");
	$rt=mysql_fetch_array($fe);
	$count=$rt['count'];
	$i=$count/$noofgroups;
	$xtra=$count%$noofgroups;
	if($xtra==0){
	$pergroup=$i;
	}else{
	$pergroup=$i+1;
	}
	$resulta = get_row_from_table("group_m_details","institute_id='$institute_id' AND course_id='$courseid' AND instructor_id='$instructor_id'");
		if($resulta){
			
			$groupid=get_column_from_table("group_id","group_m_details","course_id='$courseid' AND institute_id='$institute_id' AND instructor_id='$instructor_id'");
			$resultf = delete_row_in_table("group_m_details","institute_id='$institute_id' AND course_id='$courseid' AND instructor_id='$instructor_id'");
				
			$result1 = delete_row_in_table("group_t_details","institute_id='$institute_id' AND group_id='$groupid'");
		}
	$results=insert_into_group_m_details($institute_id,$courseid,$instructor_id,$groupname,$description,$noofgroups,$pergroup,$acyear,$session,$username);
	
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
			if ($res || $results) {
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