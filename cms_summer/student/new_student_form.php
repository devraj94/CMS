<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./db_config.php");

	$institute_id = $_SESSION["institute_id"];
	# Connecting to database
	$connection = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
	mysql_select_db($dbname , $connection);

	$sql = "SELECT * FROM program_m_details WHERE institute_id='$institute_id'";
	$result = mysql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<script src="../jquery_ui_lib/jquery_1.10.1.min.js"></script>
		
		<script src="../bootstrap/js/bootstrap.js"></script>
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-responsive.min.css">

		<script src="../bootstrap/pnotify-1.2.0/jquery.pnotify.js" type="text/javascript"></script>
		<link href="../bootstrap/pnotify-1.2.0/jquery.pnotify.default.css" rel="stylesheet" type="text/css">

		<script src="../jquery_ui_lib/jquery_ui_1.10.3.min.js" type="text/javascript"></script>
		<script src="../bootstrap/select/jquery.selectBoxIt.min.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="../bootstrap/select/jquery.selectBoxIt.css">

		<style type="text/css">
			.control-group{margin: 0px} .ui-pnotify-history-container { display: none; }
		</style>

		<script type="text/javascript">
			$(function(){
				var roll_check=false;
				var email_check=true;
				var prog_check=true;
				var sem_check=true;
				//Calls the selectBoxIt method on your HTML select box.
      			$("select").selectBoxIt({ 
      				showEffect: "fadeIn",
				    showEffectSpeed: 400,
				    hideEffect: "fadeOut",
				    hideEffectSpeed: 400
				});

				var initial_value = "";
				var initial_email_value = "";
				$('#stdRoll_No').focus(function(){ initial_value = $('#stdRoll_No').val(); });
				$('#stdEmail').focus(function(){ initial_email_value = $('#stdEmail').val(); });

				$('input').addClass("ui-corner-all");
				// Event 'Blur' on textField email
				$('#stdRoll_No').blur(function(){
					roll_No = $('#stdRoll_No').val();
					if (roll_No!=initial_value) {
						$("#roll_img").html("<img src='../img/ajax-loader.gif' width='20' height='20'>");
						$("#ta").val("");
						//$("#wait").dialog("open");
						$("#old_new").val("");
						$("#stdName").attr("readonly", false);
						$("#stdEmail").attr("readonly", false);
						$("#stop_blur").val("0");
						// Ajax call to retrieve data from database..
						$.ajax({
				            type: "POST",
				            url: "ajax_Student_data.php",
				            data: {
				                stdRollNo: roll_No,
				                condition: "1",
				            },
				            success: function(json) {
				            	var data = json.split("*");
				            	if (data[0]=="1") {
				            		$("#student_id").val(data[1]);
				            		$("#stdName").val(data[2]);
				            		$("#stdName").attr("readonly", true);
				            		$("#stdEmail").val(data[3]);
				            		$("#stdEmail").attr("readonly", true);
				            		// Change value for program select-Box
				            		var prog_array = data[4].split("&&&");
				            		$("#program").data("selectBox-selectBoxIt").remove();
				            		$("#program").data("selectBox-selectBoxIt").add({ value: prog_array[0], text: prog_array[1] });
				            		// Change value for department select-Box
				            		var dep_array = data[5].split("&&&");
				            		$("#department").data("selectBox-selectBoxIt").remove();
				            		$("#department").data("selectBox-selectBoxIt").add({ value: dep_array[0], text: dep_array[1] });
				            		// Change value for course select-Box
				            		$("#course").data("selectBox-selectBoxIt").remove();
				            		$("#course").data("selectBox-selectBoxIt").add({ value: '---', text: '----' });
				            		$("#roll_img").html("<img src='../img/success.png' width='20' height='20'>");
				            		$("#stop_blur").val("1");
				            		$("#old_new").val("old");
				            		roll_check=true;
				            	};
				            	if (data[0]=="2") {
				            		$("#student_id").val("");
				            		$("#stdName").val("");
				            		$("#stdEmail").val("");
				            		$("#department").data("selectBox-selectBoxIt").remove();
				            		$("#department").data("selectBox-selectBoxIt").add({ value: '---', text: '----' });
				            		$("#course").data("selectBox-selectBoxIt").remove();
				            		$("#course").data("selectBox-selectBoxIt").add({ value: '---', text: '----' });
				            		$.ajax({ type:"POST", url:"ajax_Student_data.php", data:{get_Program:"1"},
				            			success: function(str){ 
				            				$("#roll_img").html("<img src='../img/success.png' width='20' height='20'>");
				            				$("#program").data("selectBox-selectBoxIt").remove();
				            				// adding dynamically option
				            				var array = str.split("**");
				            				for (var i = 0; i < array.length; i++) {
				            					var values = array[i].split("*");
				            					if (values.length==2) {
				            						$("#program").data("selectBox-selectBoxIt").add({ value: values[0], text: values[1] });
				            					};
				            				};
					            			roll_check=true;
					            		}
				            		});
				            		$("#old_new").val("new");
				            	};
				            	if (data[0]=="0") {
				            		roll_check=false;
				            		$("#roll_img").html("<img src='../img/error.png' width='20' height='20'>");
					                $.pnotify({
									    title: 'Error!',
									    text: 'Error while fetching data from database.',
									    type: 'error',
										hide: true
									});
				            	};
				            },
							failure: function() {
								roll_check=false;
								$('form').reset();
								$("#roll_img").html("<img src='../img/error.png' width='20' height='20'>");
					            $.pnotify({
								    title: 'Error!',
								    text: 'Error while fetching data from database.',
								    type: 'error',
									hide: true
								});
							}
						}); // ajax ends
					}; // if ends
				});

				//
				$('#stdEmail').blur(function(){
					var email = $("#stdEmail").val();
					if (initial_email_value!=email) {
						if ($("#stop_blur").val()=="0") {
							$("#email_img").html("<img src='../img/ajax-loader.gif' width='20' height='20'>");
							$("#ta").val("");
							$("#student_id").val("");
							$("#stdName").val("");
							//$("#wait").dialog("open");
							$("#stdName").attr("readonly", false);
							$.ajax({
								type: "POST",
								url: "ajax_Student_data.php",
								data: {email_id:email, check_Email:"1"},
								success: function(data){
									var array = data.split("*");
									if (array[0]=="0") {
										$("#email_img").html("<img src='../img/ww.png' width='20' height='20'>");
										$.pnotify({
										    title: 'Warning!',
										    text: 'A student is already using this email_id.',
										    type: 'warning',
											hide: true
										});
										email_check=false;
									};
									if (array[0]=="1") {
										$("#email_img").html("<img src='../img/success.png' width='20' height='20'>");
										$("#stdName").val(array[1]);
				            			$("#stdName").attr("readonly", true);
				            			$("#ta").val("yes");
				            			check=true;
									};
									if (array[0]=="2") {
										$("#email_img").html("<img src='../img/success.png' width='20' height='20'>");
										email_check=true;
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
									email_check=false;
								}
							});
						}; // ineer if
					};
				});

				//
				$("#program").change(function(){
					$("#program_img").html("<img src='../img/ajax-loader.gif' width='20' height='20'>");
					prog = $("#program").val();
					$.ajax({
						type: "POST",
						url: "ajax_Student_data.php",
						data: {progID: prog, change:"1",},
						success: function(data){
							$("#department").data("selectBox-selectBoxIt").remove();
				           	// adding dynamically option
				       		var array = data.split("**");
			   				for (var i = 0; i < array.length; i++) {
				           		var values = array[i].split("*");
				         		if (values.length==2) {
				        			$("#department").data("selectBox-selectBoxIt").add({ value: values[0], text: values[1] });
				           		};
				           	};
							$("#program_img").html("");
							prog_check=true;
						},
						failure: function(){
							prog_check=false;
							$("#program_img").html("");
							$.pnotify({
							    title: 'Error!',
							    text: 'Error while fetching data from database.',
							    type: 'error',
								hide: true
							});	
						},
					});
				});

				//
				$("#sem").change(function(){
					$("#sem_img").html("<img src='../img/ajax-loader.gif' width='20' height='20'>");
					sem = $("#sem").val();
					$.ajax({ type:"POST", url:"ajax_Student_data.php", data:{semester:sem, get_course:"1"},
			            success: function(str){ 
			            	$("#course").data("selectBox-selectBoxIt").remove();
				            // adding dynamically option
				       		var array = str.split("**");
			     			for (var i = 0; i < array.length; i++) {
				           		var values = array[i].split("*");
				         		if (values.length==2) {
			            			$("#course").data("selectBox-selectBoxIt").add({ value: values[0], text: values[1] });
			            		};
			            	};
			            	$("#sem_img").html("");
			            	sem_check=true;
					    },
					    failure: function(){
					    	sem_check=false;
					    	$("#sem_img").html("");
					        $.pnotify({
							    title: 'Error!',
							    text: 'Error while fetching data from database.',
							    type: 'error',
								hide: true
							});
					    }
			        });
				});

				$("#new_student_form").submit(function(e){
					var prog = $("#program").val();
					var dep = $("#department").val();
					var crs = $("#course").val();
					var sem = $("#sem").val();
					if (!roll_check || !email_check || !prog_check || !sem_check) {
						e.preventDefault();
						$.pnotify({
							title: 'Warning!',
							text: 'Some field(s) are not valid.',
						    type: 'warning',
							hide: true
						});
					};
					if (prog=="---") {
						e.preventDefault();
						$.pnotify({
							title: 'Warning!',
							text: 'Select a program.',
						    type: 'warning',
							hide: true
						});
						$("#program").focus();
					}else if(dep=="---"){
						e.preventDefault();
						$.pnotify({
							title: 'Warning!',
							text: 'Select a department.',
						    type: 'warning',
							hide: true
						});
						$("#department").focus();
					}else if(crs=="---") {
						e.preventDefault();
						$.pnotify({
							title: 'Warning!',
							text: 'Select a course.',
						    type: 'warning',
							hide: true
						});
						$("#course").focus();
					}else if (sem=="---") {
						e.preventDefault();
						$.pnotify({
							title: 'Warning!',
							text: 'Select a semester.',
						    type: 'warning',
							hide: true
						});
						$("#sem").focus();
					};
				});

				$("#reset").click(function(){
					//alert("ok");
					$("#roll_img").html("");
					$("#email_img").html("");
					$("#stdName").attr("readonly", false);
					$("#stdEmail").attr("readonly", false);
					$("#department").data("selectBox-selectBoxIt").remove();
				    $("#department").data("selectBox-selectBoxIt").add({ value: '---', text: '----' });
	        		// Change value for course select-Box
            		$("#course").data("selectBox-selectBoxIt").remove();
            		$("#course").data("selectBox-selectBoxIt").add({ value: '---', text: '----' });
            		$.ajax({ type:"POST", url:"ajax_Student_data.php", data:{get_Program:"1"},
				        success: function(str){ 
				        	$("#program").data("selectBox-selectBoxIt").remove();
				            // adding dynamically option
				            var array = str.split("**");
				            for (var i = 0; i < array.length; i++) {
				            	var values = array[i].split("*");
				            	if (values.length==2) {
				            		$("#program").data("selectBox-selectBoxIt").add({ value: values[0], text: values[1] });
				            	};
				            };
					    }
				    });
				});
			});
		</script>

	</head>
	<body>
		<form class="form-horizontal" id="new_student_form" action="submit.php" method="POST">
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
				<label class="control-label" for="program">Program :</label>
				<div class="controls">
					<select id="program" name="program">
						<option value="---">----</option>
						<?php
							while($row = mysql_fetch_array($result)){
								echo "<option value='".$row['program_id']."'>".$row['program_name']." (".$row['program_code'].")"."</option>";
							}
						?>
					</select>
					<span id="program_img"></span>
				</div>
			</div>

			<div class="control-group span5">
				<label class="control-label" for="department">Department :</label>
				<div class="controls">
					<select id="department" name="department">
						<option value="---">----</option>
					</select>
				</div>
			</div>
			
			<div class="control-group span5">
				<label class="control-label" for="sem">Semester :</label>
				<div class="controls">
					<select id="sem" name="sem" class="selectpicker">
						<option value="---">----</option>
						<?php
							$m = explode("-", date("Y-m-d"));
							$month = intval($m[1]);
							if ($month > 6 && $month <= 12) {
								for ($i=0; $i < 4; $i++) { 
									$x = (2*$i) + 1; 
									echo "<option value='$x'> $x </option>";
								}
							}else{
								for ($i=0; $i < 4; $i++) { 
									$x = (2*$i) + 2; 
									echo "<option value='$x'> $x</option>";
								}
							}
						?>
					</select>
					<span id="sem_img"></span>
				</div>
			</div>

			<div class="control-group span5">
				<label class="control-label" for="course">Choose Course :</label>
				<div class="controls">
					<select id="course" name="course">
						<option value="---">----</option>
					</select>
				</div>
			</div>

				<!-- Hidden button(s) -->
				<input type="text" id="stop_blur" value="0" style="display:none;">
				<input type="text" id="student_id" name="student_id" style="display:none;">
				<input type="text" id="old_new" name="old_new" style="display:none;">
				<input type="text" id="ta" name="ta" value="" style="display:none;">
			<br>
			<div class="control-group span5">
				<div class="controls">
					<button class="btn btn-primary" name="submit" type="submit" id="submit">ADD</button>
					<button class="btn" type="reset" id="reset" style="margin-left:15px;">Clear</button>
				</div>
			</div>

		</form>	
	
	</body>
</html>