<?php
		include(dirname(dirname(__FILE__))."./../user_session.php");
	include(dirname(dirname(__FILE__))."./../db_config.php");
    include(dirname(dirname(__FILE__))."./function.php");


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
?>
<html>
	<head>
		<script src="../../jquery_ui_lib/jquery_1.10.1.min.js"></script>
		
		<script src="../../bootstrap/js/bootstrap.js"></script>
		<link href="../../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap-responsive.min.css">

		<script src="../../bootstrap/pnotify-1.2.0/jquery.pnotify.js" type="text/javascript"></script>
		<link href="../../bootstrap/pnotify-1.2.0/jquery.pnotify.default.css" rel="stylesheet" type="text/css">

		<script src="../../jquery_ui_lib/jquery_ui_1.10.3.min.js" type="text/javascript"></script>
		<script src="../../bootstrap/select/jquery.selectBoxIt.min.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="../../bootstrap/select/jquery.selectBoxIt.css">

		<style type="text/css">
			.control-group{margin: 0px} .ui-pnotify-history-container { display: none; }
		</style>
		<script type="text/javascript">
			$(function(){
				$('input').addClass("ui-corner-all");
				$('textarea').addClass("ui-corner-all");
				var initial_value = "";
				$('#taEmail').focus(function(){ initial_value = $('#taEmail').val(); });
				// Event 'Blur' on textField email
				$('#taEmail').blur(function(){
					$("#condition").val("");
					email_id = $('#taEmail').val();
					if (email_id!=initial_value){
					$("#email_img").html("<img src='../../img/ajax-loader.gif' width='20' height='20'>");
						// Ajax call to retrieve data from database..
						$.ajax({
							type: "POST",
							url: "ajax_ta_data.php?ins=1",
							data: {
								email: email_id,
							},
							success: function(json) {
								var data = json.split("*"); 
								if (data[0]=='Exist' && data[1]=='yes') {
								$("#email_img").html("<img src='../../img/success.png' width='20' height='20'>");
									$('#name').val(data[2]);
									$("#taAddress").val(data[3]);
									$("#contactNo").val(data[4]);
									$("#condition").val("ins");
									
								};
								if(data[0]=='Exist' && data[1]=='no'){
								 $("#email_img").html("<img src='../../img/ww.png' width='20' height='20'>");
											$.pnotify({
												title: 'Error!',
												text: 'The user with email :'+email_id+' is already a Student.',
												type: 'error',
												hide: true
											});
									};
									
								if (data[0]!='Exist' && data[0]!=" ") {
								$("#email_img").html("<img src='../../img/success.png' width='20' height='20'>");
									$('#name').val(data[0]);
									$('#type').val(data[1]);
									$("#taAddress").val(data[2]);
									$("#condition").val("old");
								};
								if (data[0]==" ") {
								$("#email_img").html("<img src='../../img/success.png' width='20' height='20'>");
									$("#condition").val("new");
								};
								
							},
							failure: function() {
								$('form').reset();
									$("#roll_img").html("<img src='../../img/error.png' width='20' height='20'>");
					                $.pnotify({
									    title: 'Error!',
									    text: 'Error while fetching data from database.',
									    type: 'error',
										hide: true
									});
									$('#taEmail').val("");
							}
						}); // ajax ends
					};
				});// End on blur			
			});
		</script>
	</head>

	<body>
		<form  class="form-horizontal" action="ajax_ta_data.php" method="POST" id="ta_form">
			<div class="control-group span5">
				<label class="control-label" for="taEmail">Student Email_id :</label>
				<div class="controls">
					<input class="input" type="email" id="taEmail" name="taEmail" placeholder="abc@example.com" required>
					<span id="email_img"></span>
				</div>
			</div>
			<div class="control-group span5">
				<label class="control-label" for="name">Name :</label>
				<div class="controls">
					<input class="input" type="text" id="name" name="name" placeholder="First_Name Last_Name" required>
				</div>
			</div>
			<div class="control-group span5">
				<label class="control-label" for="course">Course :</label>
				<div class="controls">
				<select id="course" name="course" class="selectpicker">
					<?php
					$ac_year=get_academic_year();
					$sql="SELECT * FROM course_instructor WHERE institute_id='$institute_id' AND instructor_id='$instructorid' AND academic_year='$ac_year'";
					$resulta=mysql_query($sql) or die(mysql_error());
					$i=mysql_num_rows($resulta);
					while($i!=0){
					$rowa=mysql_fetch_array($resulta);
					$courseid=$rowa['course_id'];
					  $resultb=get_row_from_table("course_m_details","institute_id='$institute_id' AND course_id='$courseid'");
					  $rowb=mysql_fetch_array($resultb);
					  echo "<option value='".$courseid."'> ".$rowb['course_title']." </option>";
					 $i--;
					}
					?>
				</select>
					<span id="program_img"></span>
				</div>
			</div>
			<div class="control-group span5">
				<label class="control-label" for="taAddress">Address :</label>
				<div class="controls">
					<textarea rows="3" cols="30" id="taAddress" name="taAddress"></textarea>
				</div>
			</div>
				
				<?php
				if(isset($_GET['ins'])){
				$sem="sem";
				echo "<div class='control-group span5'>";
				echo "<label class='control-label' for=".$sem.">Semester:</label>";
				echo "<div class='controls'>";
				echo "<select id=".$sem." name=".$sem." class='selectpicker'>";
				    $s = get_session();
					for ($i=0; $i < 4; $i++) { 
						$x = (2*$i) + $s; 
						echo "<option value='$x'> $x </option>";
					}
					echo "</select>";
					echo "</div>";
				echo "</div>";
				}
				?>
			<div class="control-group span5">
				<label class="control-label" for="contactNo">contact No :</label>
				<div class="controls">
					<input class="input" type="text" id="contactNo" name="contactNo"  required>
				</div>
			</div>
				<input type="text" name="condition" id="condition" style="display:none;">
					<input type="text" name="type" id="type" style="display:none;">
			<div class="control-group span5">
				<div class="controls">
					<button class="btn btn-primary" name="submit" type="submit" id="submit">Submit</button>
					<button class="btn" type="reset" id="reset" style="margin-left:15px;">Clear</button>
				</div>
			</div>
		</form>
	</body>
</html>