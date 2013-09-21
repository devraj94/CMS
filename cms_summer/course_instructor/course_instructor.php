<html>
	<HEAD>
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
			.ui-pnotify-history-container { display: none; }
		</style>
		<script type="text/javascript">
			$(function(){
				//Calls the selectBoxIt method on your HTML select box.
      			$("select").selectBoxIt({ 
      				showEffect: "fadeIn",
				    showEffectSpeed: 400,
				    hideEffect: "fadeOut",
				    hideEffectSpeed: 400
				});
				//
				$("#prog").change(function(){
					$("#prog_img").html("<img src='../img/ajax-loader.gif' width='20' height='20'>");
					prog_id = $(this).val();
					$.ajax({
						type: "POST",
						url: "ajax_data.php",
						data: {
							get_dep:"1",
							program_id:prog_id 
						},
						success: function(data){
							var array = data.split("***");
							if (array[0]=="0") {
								$.pnotify({
								    title: 'Error!',
								    text: 'Error while fetching data from database.',
								    type: 'error',
									hide: true
								});
							}else if (array[0]=="1") {
								$("#dep").data("selectBox-selectBoxIt").remove();
				            	// adding dynamically option
				       			var a = array[1].split("**");
			     				for (var i = 0; i < a.length; i++) {
				            		var values = a[i].split("*");
				            		if (values.length==2) {
				            			$("#dep").data("selectBox-selectBoxIt").add({ value: values[0], text: values[1] });
				            		};
				            	};
							};
							$("#prog_img").html("");
						},
						failure: function(){
							$("#prog_img").html("");
							$.pnotify({
							    title: 'Error!',
							    text: 'Error while fetching data from database.',
							    type: 'error',
								hide: true
							});
						}
					});
				});

				//
				$("form").submit(function(e){
					var ins = $("#selInstructor").val();
					var crs = $("#selCourse").val();
					var prog = $("#prog").val();
					var dep = $("#dep").val();
					if (ins=="choose") {
						e.preventDefault();
						$.pnotify({
						    title: 'Warning!',
						    text: 'Please select a instructor.',
						    type: 'warning',
							hide: true
						});
						$("#selInstructor").focus();
					};
					if(crs=="choose"){
						e.preventDefault();
						$.pnotify({
						    title: 'Warning!',
						    text: 'Please select a course.',
						    type: 'warning',
							hide: true
						});
						$("#selCourse").focus();
					};
					if(prog=="choose"){
						e.preventDefault();
						$.pnotify({
						    title: 'Warning!',
						    text: 'Please select a program.',
						    type: 'warning',
							hide: true
						});
						$("#prog").focus();
					};
					if(dep=="choose"){
						e.preventDefault();
						$.pnotify({
						    title: 'Warning!',
						    text: 'Please select a department.',
						    type: 'warning',
							hide: true
						});
						$("#dep").focus();
					};
				});
			});
			
		</script>
	</HEAD>
	<body>
		<?php
		    include(dirname(dirname(__FILE__))."./user_session.php");
	        include(dirname(dirname(__FILE__))."./function.php");

	    	$institute_id = $_SESSION["institute_id"];
	        $username = $_SESSION["username"];

			$course_result = get_row_from_table("course_m_details","institute_id='$institute_id'");
		?>
		<form class="form-horizontal" id="new_student_form" action="addcourse_ins.php" method="POST">

			<div class="control-group span5">
				<label class="control-label" for="selCourse">Select Course :</label>
				<div class="controls">
					<select id="selCourse" name="selCourse">
						<option value="choose">Choose course</option>
						<?php
							if ($course_result) {
								while($row = mysql_fetch_array($course_result)){
									echo "<option value='".$row['course_id']."'>".$row['course_title']." (".$row["course_code"].")</option>";
								}
							}else{
								echo "<option value='---'> ---- </option>";
							}
						?>
					</select>
				</div>
			</div>

			<?php $instructor_result = get_row_from_table("instructor_m_details","institute_id='$institute_id'"); ?>

			<div class="control-group span5">
				<label class="control-label" for="selInstructor">Instructor :</label>
				<div class="controls">
					<select id="selInstructor" name="selInstructor">
						<option value="choose">Select Instructor</option>
						<?php
							if ($course_result) {
								while($ins_row = mysql_fetch_array($instructor_result)){
									echo "<option value='".$ins_row['instructor_id']."'>".$ins_row['instructor_name']."</option>";
								}
							}else{
								echo "<option value='---'> ---- </option>";
							}
						?>
					</select>
				</div>
			</div>

			<?php $prog_result = get_row_from_table("program_m_details","institute_id='$institute_id'"); ?>

			<div class="control-group span5">
				<label class="control-label" for="prog">Program :</label>
				<div class="controls">
					<select id="prog" name="prog">
						<option value="choose">Choose program</option>
						<?php
							if ($prog_result) {
								while($prog_row = mysql_fetch_array($prog_result)){
									echo "<option value='".$prog_row['program_id']."'>".$prog_row['program_name']." (".$prog_row["program_code"].")</option>";
								}
							}else{
								echo "<option value='---'> ---- </option>";
							}
						?>
					</select>
					<span id="prog_img"></span>
				</div>
			</div>

			<div class="control-group span5">
				<label class="control-label" for="dep">Department :</label>
				<div class="controls">
					<select id="dep" name="dep">
						<option value="choose">Choose department</option>
					</select>
				</div>
			</div>

			<div class="control-group span5">
				<label class="control-label" for="semester">Semester :</label>
				<div class="controls">
					<select id="semester" name="semester">
						<?php
							$s = get_session();
							for ($i=0; $i < 4; $i++) { 
								$x = (2*$i) + $s; 
								echo "<option value='$x'> $x </option>";
							}
						?>
					</select>
				</div>
			</div>

			<div class="control-group span5">
				<div class="controls">
					<button class="btn btn-primary" type="submit" name="submit" id="submit">Submit</button>
					<button class="btn" type="reset" id="reset">Reset</button>
				</div>
			</div>

		</form>	

	</body>
</html>