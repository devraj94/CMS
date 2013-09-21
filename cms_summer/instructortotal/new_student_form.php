<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./db_config.php");
    include(dirname(dirname(__FILE__))."./instructortotal/function.php");

	$instName = $_SESSION["instName"];
	$username = $_SESSION["username"];


	# Connecting to database
	$connection = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
	mysql_select_db($dbname , $connection);

	# Getting 'user_id' from 'users' table
	$sql = "SELECT * FROM users WHERE username = '$username'";
	$result = mysql_query($sql, $connection) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{ 		
		$user_id=$row["user_id"];
		break;
	}

	# Getting details from 'instructor' table
	$sql = "SELECT * FROM instructor_m_details WHERE user_id = '$user_id'";
	$result = mysql_query($sql, $connection) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{ 
		$institute_id = $row["institute_id"];
		$instructorid = $row["instructor_id"];
	}
	$courseid=$_GET['id'];
	$ac_year=get_academic_year();
	$sql="SELECT * FROM course_instructor WHERE institute_id='$institute_id' AND course_id='$courseid' AND instructor_id='$instructorid' AND academic_year='$ac_year'";
	$resulte=mysql_query($sql) or die(mysql_error());
	$rowze=mysql_fetch_array($resulte);
	$departmentid=$rowze['department_id'];
	$programid=$rowze['program_id'];
	$sem=$rowze['semester'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
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
			var courseid='<?php echo $courseid ;?>';
			var depid='<?php echo $departmentid;?>';
			var progid='<?php echo $programid;?>';
				$('input').addClass("ui-corner-all");
				// Event 'Blur' on textField email
				var initial_value = "";
				var initial_email_value = "";
				$('#stdRoll_No').focus(function(){ initial_value = $('#stdRoll_No').val(); });
				$('#stdEmail').focus(function(){ initial_email_value = $('#stdEmail').val(); });
				
				$('#stdRoll_No').blur(function(){
						roll_No = $('#stdRoll_No').val();
						if (roll_No!=initial_value) {
							$("#roll_img").html("<img src='../img/ajax-loader.gif' width='20' height='20'>");
							$("#old_new").val("");
							var id='<?php echo $courseid;?>';
							$("#stop_blur").val("0");
							// Ajax call to retrieve data from database..
							$.ajax({
								type: "POST",
								url: "ajax_Student_data.php",
								data: {
									stdRollNo: roll_No,
									condition: "1",
									courseid:id
								},
								success: function(json) {
									var data = json.split("*");
									if (data[0]=="0") {
									          $("#roll_img").html("<img src='../img/ww.png' width='20' height='20'>");
											$.pnotify({
												title: 'Error!',
												text: 'The user with roll No :'+roll_No+' is already a Student.',
												type: 'error',
												hide: true
											});
									};
									if (data[0]=="1") {
									$("#roll_img").html("<img src='../img/success.png' width='20' height='20'>");
										$("#user_id").val(data[1]);
										$("#stdName").val(data[2]);
										$("#stdEmail").val(data[3]);
										$("#program").val(progid);
										$("#department").val(depid);
										$("#course").val(courseid);
										$("#father").val(data[4]);
										$("#mother").val(data[5]);
										$("#address").val(data[6]);
										$("mobile").val(data[8]);
										$("#pin").val(data[7]);
										$("#blood").val(data[9]);

										$("#stop_blur").val("1");
										$("#old_new").val("old");
									};
									if (data[0]=="2") {
									$("#roll_img").html("<img src='../img/success.png' width='20' height='20'>");
										$("#user_id").val("");
										$("#stdName").val("");
										$("#stdEmail").val("");
										$("#program").val(progid);
										$("#department").val(depid);
										$("#course").val(courseid);
										$("#old_new").val("new");
									};
								},
								failure: function() {
								$('form').reset();
									$("#roll_img").html("<img src='../img/error.png' width='20' height='20'>");
					                $.pnotify({
									    title: 'Error!',
									    text: 'Error while fetching data from database.',
									    type: 'error',
										hide: true
									});
									$('#stdRoll_No').val("");
								}
						
							});
						};			// ajax ends
				});
				
				$('#stdEmail').blur(function(){
					var email = $("#stdEmail").val();
					if (initial_email_value!=email) {
						if ($("#stop_blur").val()=="0") {
							$("#email_img").html("<img src='../img/ajax-loader.gif' width='20' height='20'>");
							//$("#wait").dialog("open");
							$("#stdName").attr("readonly", false);
							$.ajax({
								type: "POST",
								url: "ajax_Student_data.php",
								data: {
								       email_id:email,
								       condition: "2"
									   },
								success: function(json){
								var data=json.split("*");
									if (data[0]=="0") {
										$("#email_img").html("<img src='../img/ww.png' width='20' height='20'>");
										$.pnotify({
										    title: 'Warning!',
										    text: 'A student is already using this email_id.',
										    type: 'warning',
											hide: true
										});
										$('#stdEmail').val();
									};
									if (data[0]=="1") {
										$("#email_img").html("<img src='../img/success.png' width='20' height='20'>");
									};
								},
								failure: function(){
									$("#email_img").html("<img src='../img/error.png' width='20' height='20'>");
									$.pnotify({
									    title: 'Error!',
									    text: 'Error while fetching data from database.',
									    type: 'error',
										hide: true
									});	
									$('#stdEmail').val();
								}
							});
						}; // ineer if
					};
				});


				$("#new_student_form").submit(function(e){
					var roll = $("#stdRoll_No").val();
					var name = $("#stdName").val();
					var email = $("#stdEmail").val();
					var fname = $("#father").val();
					var mname = $("#mother").val();
					var mobile = $("#mobile").val();
					if (roll=="") {
						e.preventDefault();
						$.pnotify({
							title: 'Warning!',
							text: 'Roll number required.',
						    type: 'warning',
							hide: true
						});
						$("#stdRoll_No").focus();
					}else if(name==""){
						e.preventDefault();
						$.pnotify({
							title: 'Warning!',
							text: 'Enter the name.',
						    type: 'warning',
							hide: true
						});
						$("#stdName").focus();
					}else if(email=="") {
						e.preventDefault();
						$.pnotify({
							title: 'Warning!',
							text: 'Email is mandatory.',
						    type: 'warning',
							hide: true
						});
						$("#stdEmail").focus();
					}else if(fname=="") {
						e.preventDefault();
						$.pnotify({
							title: 'Warning!',
							text: 'Enter Father name.',
						    type: 'warning',
							hide: true
						});
						$("#father").focus();
					}else if(mname=="") {
						e.preventDefault();
						$.pnotify({
							title: 'Warning!',
							text: 'Enter mother name.',
						    type: 'warning',
							hide: true
						});
						$("#mother").focus();
					}else if(mobile=="") {
						e.preventDefault();
						$.pnotify({
							title: 'Warning!',
							text: 'Mobile Number required.',
						    type: 'warning',
							hide: true
						});
						$("#mobile").focus();
					};
				});

				$("#wait").dialog({
					autoOpen: false,modal: true,closeOnEscape: false,width: 180, height:50,
					create: function (event, ui) {
        				$(".ui-widget-header").hide();
        			}
				});
			});
		</script>

	</head>
	
	<body>
		<form class="form-horizontal" id="new_student_form" action="ajax_Student_data.php" method="POST">
			<div class="control-group span5">
				<label class="control-label" for="stdRoll_No">Student Roll_No :</label>
				<div class="controls">
					<input class="input" type="text" id="stdRoll_No" name="stdRoll_No" placeholder="abc123xxxxx" required>
					<span id="roll_img"></span>
				</div>
			</div>

			<div class="control-group span5">
				<label class="control-label" for="stdEmail">Student Email_id :</label>
				<div class="controls">
					<input class="input" type="email" id="stdEmail" name="stdEmail" placeholder="abc@example.com" required>
					<span id="email_img"></span>
				</div>
			</div>

			<div class="control-group span5">
				<label class="control-label" for="stdName">Student Name :</label>
				<div class="controls">
					<input class="input" type="text" id="stdName" name="stdName" placeholder="First_Name Last_Name" required>
				</div>
			</div>
			<div class="control-group span5">
				<label class="control-label" for="father">Father Name :</label>
				<div class="controls">
					<input class="input" type="text" id="father" name="father"  required>
				</div>
			</div>
			<div class="control-group span5">
				<label class="control-label" for="mother">Mother Name :</label>
				<div class="controls">
					<input class="input" type="text" id="mother" name="mother"  required>
				</div>
			</div>
            <div class="control-group span5">
				<label class="control-label" for="address">Address :</label>
				<div class="controls">
					<textarea rows="3" cols="30" id="address" name="address"></textarea>
				</div>
			</div>
			<div class="control-group span5">
				<label class="control-label" for="mobile">Mobile No :</label>
				<div class="controls">
					<input class="input" type="text" id="mobile" name="mobile"  required>
				</div>
			</div>
			<div class="control-group span5">
				<label class="control-label" for="pin">Pin Code :</label>
				<div class="controls">
					<input class="input" type="text" id="pin" name="pin">
				</div>
			</div>
			<div class="control-group span5">
				<label class="control-label" for="blood">Blood Group :</label>
				<div class="controls">
					<input class="input" type="text" id="blood" name="blood">
				</div>
			</div>
				<!-- Hidden button(s) -->
							<input type="text" id="stop_blur" value="0" style="display:none;">
							<input type="text" id="user_id" name="user_id" style="display:none;">
							<input type="text" id="old_new" name="old_new" style="display:none;">
							<input type="text" id="father" name="father" style="display:none;">
							<input type="text" id="course" name="course" style="display:none;">
							<input type="text" id="mother" name="mother" style="display:none;">
							<input type="text" id="address" name="address" style="display:none;">
							<input type="text" id="pin" name="pin" style="display:none;">
							<input type="text" id="mobile" name="mobile" style="display:none;">
							<input type="text" id="blood" name="blood" value="<?php echo $courseid;?>" style="display:none;">
							<input type="text" id="program" name="program" value="<?php echo $programid;?>" style="display:none;">
							<input type="text" id="department" name="department" value="<?php echo $departmentid;?>" style="display:none;">
							<input type="text" id="sem" name="sem" value="<?php echo $sem;?>" style="display:none;">
			<br>
			<div class="control-group span5">
				<div class="controls">
					<button class="btn btn-primary" name="submit" type="submit" id="submit">Submit</button>
					<button class="btn" type="reset" id="reset" style="margin-left:15px;">Clear</button>
				</div>
			</div>

		</form>	
	
	</body>
	</html>