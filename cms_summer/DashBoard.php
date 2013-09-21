<?php
	include(dirname(__FILE__)."./function.php");
	session_start();
	if(!isset($_SESSION['username']) || !isset($_SESSION['password']) || !isset($_SESSION["institute_id"]) || !isset($_SESSION["instName"]))
	{
		header("Location: HomePage.php");
		exit();
	}

	$username=$_SESSION['username'];
	$password=$_SESSION['password'];
	$name = $_SESSION['instName'];
	$user_id = $_SESSION['user_id'];
	$institute_id = $_SESSION["institute_id"];
	$stringArray = array(); // declare empty array
	$index = 0;
	
	$sql = "SELECT role_id FROM users_role WHERE user_id='$user_id'";
	$result = mysql_query($sql) or die("Couldn't execute query.<br><br>".mysql_error()."<br><br>".$sql);
	while ($row = mysql_fetch_array($result)) {
		$role_id = $row["role_id"];
		$table = "";
		if ($role_id=="2" || $role_id=="3") {
			$table = "admin_m_details";
		}elseif ($role_id=="4") {
			$table = "instructor_m_details";
		}elseif ($role_id=="5") {
			$table = "ta_m_details";
		}elseif ($role_id=="6") {
			$table = "student_m_details";
		}elseif ($role_id=="1") {
			$stringArray[$index] = $role_id;
			$index++;
		}
		if ($role_id!="1") {
			if (get_column_from_table("status",$table,"user_id='$user_id'")=="1") {
				$stringArray[$index] = $role_id;
				$index++;
			}
		}
	}
?>

<html>
	<head>
		<title>CMS - Dashboard</title>
		<link rel="stylesheet" type="text/css" href="DashBoard.css">
		<link href="css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
		<link href="sidebar/webwidget_vertical_menu.css" rel="stylesheet" type="text/css">
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
			.ui-dialog{font-size: 75%;}
		</style>
		<script src="jquery_ui_lib/jquery_1.10.1.min.js"></script>
		<script src="bootstrap/js/bootstrap.js"></script>
		<script src="jquery_ui_lib/jquery_ui_1.10.3.min.js"></script>
		<script type="text/javascript" src="sidebar/webwidget_vertical_menu.js"></script>
		<script type="text/javascript" src="dashBoard.js"></script>

	</head>
	<body>
			<div title="ERROR!" id="error"></div>
			<div title="Congratulation" id="cong"></div>

			<div class='collegeLogo' style='background-color: rgba(57, 44, 94,0.6); position:relative; align:left;' >
				<table>
					<tr>
						<?php 
							$path = get_column_from_table("institute_logo","institute_m_details","institute_id='$institute_id'");
						?>
						<td width="150"><img src='<?php echo $path;?>' style='width:140; height:120; margin-top:5px; margin-left:10px;'></td>
						<td width="900" align="center"><h1><?php echo $name; ?></h1></td>
					</tr>
				</table>
			</div>
		
		<table>
			<tbody>
				<tr>
					<td valign="top">
						<div class="webwidget_vertical_menu">
								<div id='webwidget_vertical_menu'class="webwidget_vertical_menu" style=' width:200;'>
									<ul>
										<li><button onclick="window.open('logout.php','_top')" id="logout">LogOut</button></li>
										<li><a href="HomePage.php">Home</a></li>
										<li id="my"><a href="">Chat</a></li>
									</ul>
								

					<?php
	############################################################################################################
	################################################### MASTER MENU ############################################	
					    if (in_array("1", $stringArray) ) {
							echo "	
										<ul></br><li class='head'>Master Menu</li>
											<li><a href='allList/instituteList.php' target='inlineframe'>Institue List</a></li>"; 
								
									# If 'master' is also a 'Primary Admin' or 'Secondary Admin'
									if ( in_array("2", $stringArray) || in_array("3", $stringArray) ){
										echo "</br><li class='head'>Admin Menu</li>
										<li><a href='admin/admin_profile.php' target='inlineframe'>Profile</a></li>
										<li><a>Master Lists</a>
											<ul>
												<li><a href='allList/adminList.php' target='inlineframe'>Admin List</a></li>
												<li><a href='allList/instructorList.php' target='inlineframe'>Instructor List</a></li>
												<li><a href='allList/courseList.php' target='inlineframe'>Course List</a></li>
												<li><a href='allList/course_insList.php' target='inlineframe'>Course_Ins List</a></li>
												<li><a href='allList/taList.php' target='inlineframe'>TA List</a></li>
												<li><a href='allList/studentList.php' target='inlineframe'>Student List</a></li>
												<li><a href='allList/student_course_List.php' target='inlineframe'>Student-Course List</a></li>
											</ul>
										</li>
										<li><a>Program Management</a>
											<ul>
												<li><a href='#' onclick='open_program_dialog();'>Add Program</a></li>
												<li><a href='#' onclick='open_department_dialog();'>Add Department</a></li>
											</ul>
										</li>
										<li><a>Personal Calender</a></li>
										<li><a>Event Management</a></li>";
									}

									# If 'master' is also a 'Instructor'
									if ( in_array("4", $stringArray) ) {
										echo "</br><li class='head'>Instructor Menu</li>
										<li><a href='instructortotal/instructor_profile.php' target='inlineframe'>Profile</a></li>
										<li><a href='instructortotal/studentcourseinsmain.php' target='inlineframe'>Students</a></li>
								 		<li><a href='instructortotal/taList.php?ins=1' target='inlineframe'>Add T.A.</a></li>
										<li><a  href='instructortotal/studentcourseinsmain.php?group=1' target='inlineframe'>Creat Group</a></li>
										<li><a href='instructortotal/studentcourseinsmain.php?q=1' target='inlineframe'>Assignment</a></li>";
										#if master is not admin or secAdmin
										if (!in_array("2", $stringArray) && !in_array("3", $stringArray)) {
											echo "<li><a href=''>Students</a></li>
												<li><a href='course/course.php' target='inlineframe'>Courses</a></li>";
										}
										
										echo "<li><a href=''>Creat Group</a></li>
										<li><a href=''>Assignment</a></li>
										";
									}

									# If 'Master' is a 'T.A.' but not a 'Instructor'
									if ( in_array("5", $stringArray) && !in_array("4", $stringArray) ){
										echo "</br><li class='head'>T.A. Menu</li>";
										// If 'Master' is a 'T.A.' but not a 'Primary or Secondary Admin'
										if (!in_array("2", $stringArray) && !in_array("3", $stringArray)) {
											echo "<li><a href=''>Student</a></li>
										          <li><a href='course/course.php' target='inlineframe'>Course</a></li>";
										}
										echo "<li><a href=''>Creat Group</a></li>
										      <li><a href='allList/assignment.php' target='inlineframe'>Assignment</a></li>
											  <li><a href='allList/event.php' target='inlineframe'>Event</a></li>";
									}
									# If 'Primary Admin' is a 'Student'
									if (in_array("6", $stringArray)) {
										echo "</br>Student Menu
										<li><a href='student/student_profile.php' target='inlineframe'>Profile</a></li>
										<li><a href=''>Assignment</a></li>
										<li><a href=''>Course-Content</a></li>";
									}
								echo   "</ul>
									";
						}
	#############################################################################################################
	############################################## PRIMARY ADMIN ################################################
						if ( in_array("2", $stringArray)  && !in_array("1", $stringArray) ) {
							echo "
								
								<ul></br><li><b>Admin Menu</b></li>
									<li><a href='admin/admin_profile.php' target='inlineframe'>Profile</a></li>
									<li id='my'><a href=''>Master Lists</a>
										<ul>
											<li><a href='allList/adminList.php' target='inlineframe'>Admin List</a></li>
											<li><a href='allList/instructorList.php' target='inlineframe'>Instructor List</a></li>
											<li><a href='allList/courseList.php' target='inlineframe'>Course List</a></li>
											<li><a href='allList/course_insList.php' target='inlineframe'>Course_Ins List</a></li>
											<li><a href='allList/taList.php' target='inlineframe'>TA List</a></li>
											<li><a href='allList/studentList.php' target='inlineframe'>Student List</a></li>
											<li><a href='allList/student_course_List.php' target='inlineframe'>Student-Course List</a></li>
										</ul>
									</li>
									<li><a>Program Management</a>
										<ul>
											<li><a href='#' onclick='open_program_dialog();'>Add Program</a></li>
											<li><a href='#' onclick='open_department_dialog();'>Add Department</a></li>
										</ul>
									</li>
									<li><a>Personal Calender</a></li>
									<li><a>Event Management</a></li>";
							# If 'Primary Admin' is also 'Instructor'
							if (in_array("4", $stringArray)) {
								echo "	</br><li><b>Instructor Menu</b></li>
											<li><a href='instructor/instructor_profile.php' target='inlineframe'>Profile</a></li>";

										// if 'Primary Admin' is not 'T.A.'
										if (!in_array("5", $stringArray)) {
											echo "<li><a href='allList/course_ta.php' target='inlineframe'>Add/Remove T.A.</a></li>";;
										}
								//--echo "<li><a href=''>Creat Group</a></li>
									//<li><a href='allList/assignment.php' target='inlineframe'>Assignment</a></li>";
										echo "<li><a href=''>Create Group</a></li>
											<li id='my'><a href=''>Assignment</a>
											<ul>
											<li><a href='allList/assignment.php' target='inlineframe'>Show Assignments</a></li>
											<li><a href='allList/upload_asg.php' target='inlineframe'>Upload Assignment</a></li>
											<li><a href='' >Upload Answer</a></li>
											<li><a href=''>ReEnter Permission Date</a></li>
											</ul>
									</li>";
							}	

							# If 'Primary Admin' is a 'T.A.' but not instructor
							if (in_array("5", $stringArray)) {
									/*echo "</br class='head'><li>T.A. Menu</li>
										<li><a href=''>Creat Group</a></li>
										<li><a href='allList/assignment.php' target='inlineframe'>Assignment</a></li>
										<li><a href='allList/event.php' target='inlineframe'>Event</a></li>";
									*/
									echo "</br><li>T.A. Menu</li>
											<li><a href=''>Creat Group</a></li>
											<li id='my'><a href=''>Assignment</a>
											<ul>
											<li><a href='allList/assignment.php' target='inlineframe'>Show Assignments</a></li>
											<li><a href='allList/upload_asg.php' target='inlineframe'>Upload Assignment</a></li>
											<li><a href='' >Upload Answer</a></li>
											<li><a href=''>ReEnter Permission Date</a></li>
											</ul>
									</li>
									<li><a href='allList/event.php' target='inlineframe'>Event</a></li>";
							}	

							# If 'Primary Admin' is a 'Student'
							if (in_array("6", $stringArray)) {
								$std_id = get_column_from_table("std_id","student","user_id='$user_id'");
								echo "</br><li><b>Student Menu</b></li>
										<li><a href='student/student_profile.php' target='inlineframe'>Profile</a></li>
										<li><a href='student/list/course_of_student_List.php?std_id=".$std_id."' target='inlineframe'>Assignment</a></li>
										<li><a href=''>Course-Content</a></li>";
							}
							echo   "</ul>
									";
						}
						
	############################################################################################################
	########################################## SECONDARY ADMIN #################################################
						if ( in_array("3", $stringArray) && !in_array("2", $stringArray) && !in_array("1", $stringArray)) {
							echo "<ul></br><li class='head' style='font-size:85%;'><b>Sec-Admin Menu</b></li>
									<li id='my'><a href=''>Master Lists</a>
										<ul>
											<li><a href='allList/adminList.php' target='inlineframe'>Admin List</a></li>
											<li><a href='allList/instructorList.php' target='inlineframe'>Instructor List</a></li>
											<li><a href='allList/courseList.php' target='inlineframe'>Course List</a></li>
											<li><a href='allList/course_insList.php' target='inlineframe'>Course_Ins List</a></li>
											<li><a href='allList/taList.php' target='inlineframe'>TA List</a></li>
											<li><a href='allList/studentList.php' target='inlineframe'>Student List</a></li>
											<li><a href='allList/student_course_List.php' target='inlineframe'>Student-Course List</a></li>
										</ul>
									</li>
									<li><a>Program Management</a>
										<ul>
											<li><a href='#' onclick='open_program_dialog();'>Add Program</a></li>
											<li><a href='#' onclick='open_department_dialog();'>Add Department</a></li>
										</ul>
									</li>
									<li><a>Personal Calender</a></li>
									<li><a>Event Management</a></li>";
							
							// If 'Secondary Admin' is also a 'Instructor'
							if (in_array("4", $stringArray)) {
								echo " </br><li class='head'>Instructor Menu</li>
										<li><a href='instructortotal/instructor_profile.php' target='inlineframe'>Profile</a></li>
										<li><a href='instructortotal/studentcourseinsmain.php' target='inlineframe'>Students</a></li>
								 		<li><a href='instructortotal/taList.php?ins=1' target='inlineframe'>Add T.A.</a></li>
										<li><a  href='instructortotal/studentcourseinsmain.php?group=1' target='inlineframe'>Creat Group</a></li>
										<li><a href='instructortotal/studentcourseinsmain.php?q=1' target='inlineframe'>Assignment</a></li>
										";
							}

							// If 'Secondary Admin' is also a 'T.A.' but not 'Instructor'
							if (in_array("5", $stringArray) && !in_array("4", $stringArray)) {
								echo "	</br><li class='head'>T.A. Menu</li>
								        <li><a href=''>Creat Group</a></li>
										<li id='my'><a href=''>Assignment</a>
											<ul>
											<li><a href='allList/assignment.php' target='inlineframe'>Show Assignments</a></li>
											<li><a href='allList/upload_asg.php' target='inlineframe'>Upload Assignment</a></li>
											<li><a href='' >Upload Answer</a></li>
											<li><a href=''>ReEnter Permission Date</a></li>
											</ul>
										</li>
										<li><a href='allList/event.php' target='inlineframe'>Event</a></li>";
							}

							# If 'Secondary Admin' is a 'Student'
							if (in_array("6", $stringArray)) {
								echo "</br>Student Menu
										<li><a href='student/student_profile.php' target='inlineframe'>Profile</a></li>
										<li><a href=''>Assignment</a></li>
										<li><a href=''>Course-Content</a></li>";
							}
							echo   "</ul>
									";
						}
	#############################################################################################################
	############################################ INSTRUCTOR MENU ################################################

						if (in_array("4", $stringArray) && !in_array("1", $stringArray) &&
							 !in_array("2", $stringArray) && !in_array("3", $stringArray)){
							echo "
								
									<ul></br><li class='head'>Instructor Menu</li>
										<li><a href='instructortotal/instructor_profile.php' target='inlineframe'>Profile</a></li>
										<li><a href='allList/studentcourseinsmain.php' target='inlineframe'>Students</a></li>
								 		<li><a href='allList/taList.php?ins=1' target='inlineframe'>Add T.A.</a></li>
										<li><a href='allList/studentcourseinsmain.php?group=1' target='inlineframe'>Creat Group</a></li>
										<li id='my'><a href=''>Assignment</a>
											<ul>
											<li><a href='allList/assignment.php' target='inlineframe'>Show Assignments</a></li>
											<li><a href='allList/upload_asg.php' target='inlineframe'>Upload Assignment</a></li>
											<li><a href='' >Upload Answer</a></li>
											<li><a href=''>ReEnter Permission Date</a></li>
											</ul>
										</li>
									</ul>
								";
						}
	#############################################################################################################
	############################################ T.A. MENU ######################################################
						if (in_array("5", $stringArray) && !in_array("1", $stringArray) &&
							 !in_array("2", $stringArray) && !in_array("3", $stringArray) && !in_array("4", $stringArray)) {
							echo "
								
									<ul></br><li class='head'>T.A. Menu</li>
										<li><a href=''>Students</a></li>
										<li><a href='course/course.php' target='inlineframe'>Courses</a></li>
										<li><a href=''>Creat Group</a></li>
										<li id='my'><a href=''>Assignment</a>
											<ul>
											<li><a href='allList/assignment.php' target='inlineframe'>Show Assignments</a></li>
											<li><a href='allList/upload_asg.php' target='inlineframe'>Upload Assignment</a></li>
											<li><a href='' >Upload Answer</a></li>
											<li><a href=''>ReEnter Permission Date</a></li>
											</ul>
										</li>
								        <li><a href='allList/event.php' target='inlineframe'>Event</a></li>";
							// If 'T.A.' is also a 'Student'
							if (in_array("6", $stringArray)) {
								echo "</br>Student Menu
										<li><a href='student/student_profile.php' target='inlineframe'>Profile</a></li>
										<li><a href=''>Assignment</a></li>
										<li><a href=''>Course-Content</a></li>"	;
							}			
							echo   "</ul>
									";
						}
	#############################################################################################################
	################################################ STUDENT MENU ###############################################					
						if (in_array("6", $stringArray)  && !in_array("1", $stringArray) &&
							 !in_array("2", $stringArray) && !in_array("3", $stringArray) &&
							 !in_array("4", $stringArray) && !in_array("5", $stringArray)){
							echo "<ul>
									</br><li>Student Menu</li>
									<li><a href='student/student_profile.php' target='inlineframe'>Profile</a></li>
									<li><a href=''>Assignment</a></li>
									<li><a href=''>Course-Content</a></li>
								</ul>";
						}
					?>
								
							</div>
					</td>
					<td valign="top">
						<div>
							<iframe id="inlineframe" name='inlineframe' src='' scrolling='auto' width='1150' height='480' marginwidth='5' marginheight='5' style='vertical-align:top;' frameborder='1'>
								Browser not compatible.
							</iframe>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		

		<div id="course_of_a_instructor_div" title="Courses">
			<iframe id="course_of_a_instructor_frame" src="#" style="border:none;">
				Upgrade your browser.
			</iframe>
		</div>

		<div id="iframe_Div">
			<iframe id="iframe" src="#" style="border:none;">Upgrade your browser.</iframe>
		</div>

		<!-- ######### div ######## -->
		<div id="my_modal"  class="modal hide fade" area-hidden="true" style="margin-top:5px; max-width:900px;">
			<div class="modal-header" style="height:20px; max-width:800px;">
				<button type="button" class="close" data-dismiss="modal">X</button>
				<h4></h4>
			</div>

			<div class="modal-body" style="padding:10px; max-height:800px; max-width:800px;" >
				<iframe id="bts_iframe" src="" width="99.6%" height="500" frameborder="0"></iframe>
			</div>
		</div>

		<!-- ######### modal without header ######## -->
		<div id="my_modal_without_header"  class="modal hide fade" area-hidden="true">
			<div id="modal_body" class="modal-body">
				<iframe id="subList_iframe" src="#" width="100%" height="100%" frameborder="0"></iframe>
			</div>
		</div>

	</body>
</html>