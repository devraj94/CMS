<?php
include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./db_config.php");
	include(dirname(dirname(__FILE__))."./function.php");

    $institute_No=$_SESSION['institute_id'];
	$instructor_id=$_SESSION['instructor_id'];
	
	if(isset($_GET['hai'])){
			$courseid=$_POST['id'];
			$group=$_POST['grp'];
										$result = get_count("studentgroups","institute_id='$institute_No' AND course_id='$courseid' AND instructor_id='$instructor_id' AND group_No='$group'"); 
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
	$groupno=$_POST['group'];
	$name=$name.$groupno;
			foreach($_POST['studentgrp'] as $l){
				$red=insert_into_studentgroups($institute_No,$instructor_id,$id,$l,$groupno,$name,$description,$acyear,$session);
			}
			?>
        		
				<script src="js/jquery.js" type="text/javascript"></script>
		<script src="jquery.jqGrid.js" type="text/javascript"></script>

		<script type="text/javascript">
		
		var id="<?php echo $id; ?>";
		 window.parent.$("#course_of_a_instructor_frame").attr({
								    									"scrolling": "no", 
								    									"src":"allList/groups_list.php?id="+id,
								    									"width":"700",
								    									"height":"400"
								    								});
				    window.parent.$("#course_of_a_instructor_div").dialog({title:"GROUPS"});
				    window.parent.$("#course_of_a_instructor_div").dialog("open");
		
		 	
		</script>
		<?php
	}
	
?>