<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./db_config.php");
	include(dirname(dirname(__FILE__))."./function.php");
	
if(!isset($_GET['empty'])){
	$institute_No=$_SESSION['institute_id'];
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
	
	$result = get_row_from_table("studentgroups","institute_id='$institute_No' AND course_id='$courseid' AND instructor_id='$instructor_id'");
	if($result){
        $result1 = delete_row_in_table("studentgroups","institute_id='$institute_No' AND course_id='$courseid' AND instructor_id='$instructor_id'");
		
	}
	
	$resulta = get_row_from_table("groups","institute_id='$institute_No' AND course_id='$courseid' AND instructor_id='$instructor_id'");
	if($resulta){
        $resultf = delete_row_in_table("groups","institute_id='$institute_No' AND course_id='$courseid' AND instructor_id='$instructor_id'");
		
	}
	$results=insert_into_groups($institute_No,$courseid,$instructor_id,$groupname,$description,$totalgroups,$pergroup,$acyear,$session);

	$group_id = get_column_from_table("group_id","groups","institute_id='$institute_No' AND course_id='$courseid' AND instructor_id='$instructor_id'");
	
	$result2 = get_row_from_table("student_reg","institute_No='$institute_No' AND course_id='$courseid' ORDER BY roll_No"); 
	for($m=1;$m<=$i;$m++){
	   for($g=0;$g<$pergroup;$g++){
			$row = mysql_fetch_array($result2,MYSQL_ASSOC); 
			$group_name=$groupname.$m;
			$groupno=$m;
			$student_id=$row['student_id'];
			$res=insert_into_studentgroups($institute_No,$instructor_id,$courseid,$student_id,$group_id,$groupno,$group_name,$description,$acyear,$session);
	   }
	}
	for($r=0;$r<$xtra;$r++){
	        $row = mysql_fetch_array($result2,MYSQL_ASSOC); 
			$h=$i+1;
			$group_name=$groupname.$h;
			$groupno=$h;
			$student_id=$row['student_id'];
			$res=insert_into_studentgroups($institute_No,$instructor_id,$courseid,$student_id,$group_id,$groupno,$group_name,$description,$acyear,$session);
			
	}
	
}

if(isset($_GET['empty'])){
	$total=$_POST['students'];
    $institute_No=$_SESSION['institute_id'];
	$instructor_id=$_SESSION['instructor_id'];
	$courseid=$_GET['id'];
	$noofgroups=$_POST['no_of_groups'];
	$description=$_POST['description'];
	$groupname=$_POST['groupname'];
	$session=get_session();
	$acyear=get_academic_year();
	$result = get_row_from_table("studentgroups","institute_id='$institute_No' AND course_id='$courseid' AND instructor_id='$instructor_id'");
	if($result){
        $result1 = delete_row_in_table("studentgroups","institute_id='$institute_No' AND course_id='$courseid' AND instructor_id='$instructor_id'");
	}
	
	$resulta = get_row_from_table("groups","institute_id='$institute_No' AND course_id='$courseid' AND instructor_id='$instructor_id'");
	if($resulta){
        $resultf = delete_row_in_table("groups","institute_id='$institute_No' AND course_id='$courseid' AND instructor_id='$instructor_id'");
		
	}
	$results=insert_into_groups($institute_No,$courseid,$instructor_id,$groupname,$description,$noofgroups,$total/$noofgroups,$acyear,$session);
	
}
?>
	<script src="js/jquery.js" type="text/javascript"></script>
		<script src="jquery.jqGrid.js" type="text/javascript"></script>

		<script type="text/javascript">
		var con = "<?php echo isset($_GET['empty'])? $_GET['empty']:''; ?>";
		if(con==''){
		var id="<?php echo $courseid; ?>";
		 window.parent.$("#course_of_a_instructor_frame").attr({
								    									"scrolling": "no", 
								    									"src":"allList/groups_list.php?id="+id,
								    									"width":"700",
								    									"height":"400"
								    								});
				    window.parent.$("#course_of_a_instructor_div").dialog({title:"GROUPS"});
				    window.parent.$("#course_of_a_instructor_div").dialog("open");
					window.parent.$("#cong").html("Groups Added Successfully.")
				// to open pop-up dialog from parent window
				window.parent.$('#cong').dialog("open");

		
		 }else{
		 window.parent.$("#cong").html("Groups Added Successfully.")
				// to open pop-up dialog from parent window
				window.parent.$('#cong').dialog("open");
				window.parent.$("#course_of_a_instructor_div").dialog("close");
		 };
		</script>
		<?php
		?>