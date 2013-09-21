<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<?php
		session_start();
		include(dirname(__FILE__)."./db_config.php");

		# Connecting to database
		$connection = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
		mysql_select_db($dbname , $connection);

		# Getting Institute list
		$sql = "SELECT institute_id,institute_name FROM INSTITUTE_M_DETAILS";
		$result = mysql_query($sql, $connection) or die(mysql_error()); 

		$counter=0;
	?>
	<head>
		<title>HOME</title>
		
		<script src="jquery_ui_lib/jquery_1.10.1.min.js"></script>
		
		<script src="bootstrap/js/bootstrap.js"></script>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />

		<script src="bootstrap/fileupload/bootstrap-fileupload.js"></script>
		<link href="bootstrap/fileupload/bootstrap-fileupload.css" rel="stylesheet" type="text/css" />
		<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet" type="text/css" />

		<script src="jquery_ui_lib/jquery_ui_1.10.3.min.js" type="text/javascript"></script>
		<script src="bootstrap/select/jquery.selectBoxIt.min.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="bootstrap/select/jquery.selectBoxIt.css">

		<style type="text/css">
			
			#reg_modal{
				width: 900px;
				left: 500px;
			}
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
				$("#inst_reg").click(function(){
					$('#login_modal').modal('hide');
					$('#reg_modal').modal('show');
				});
			});
		</script>
	</head>
	
	<body>
		<!-- ######### Simple menu in homepage ######## -->
		<div class="menubar">
			<a href="HomePage.php">Home</a><br/>
			<a href="#reg_modal" class='btn' data-toggle='modal'>Register New Institute</a><br>
			<?php 
				# if user is logged in then change link 'login' to 'dashboard' page
				if(isset($_SESSION['username']) && isset($_SESSION['password']))
				{
					echo "<a href='DashBoard.php'>DashBoard</a><br>";
				}elseif (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
					echo "<a href='#login_modal' class='btn' data-toggle='modal'>Login</a><br>";
				} 
			?>
			
			<button onclick='' id='about' >About Us</button>
		</div>

		<!-- ######### div for log-in box ######## -->
		<div id="login_modal" class="modal hide fade" area-hidden="true">
			<div class="modal-header">
				<h3>Login</h3>
			</div>

			<div class="modal-body">
				<form class="form-horizontal" action="check.php" method="POST">
					<div class="control-group">
					    <label class="control-label" for="institute">Institute :</label>
					    <div class="controls">
					      	<select class="selectpicker" name='instList' id="institute" class="selectpicker">
									<option value='-'>Choose one...</option>
									<?php
										while($row = mysql_fetch_array($result)){
											echo "<option value='".$row['institute_id']."'>".$row['institute_name']."(".$row['institute_id'].")"."</option>";
										}
									?>
							</select>
					    </div>
				  	</div>
					<div class="control-group">
					    <label class="control-label" for="inputEmail">Username :</label>
					    <div class="controls">
					      <input class="input-large" type="email" id="inputEmail" name="username" placeholder="abc@example.com" required>
					    </div>
				  	</div>
				  	<div class="control-group">
					    <label class="control-label" for="inputPassword">Password :</label>
					    <div class="controls">
					      	<input class="input-large" type="password" id="inputPassword" name="password" placeholder="Enter Password" required>
					    </div>
				  	</div>
				  	<div class="control-group">
					    <div class="controls">
					      	<button type="submit" class="btn btn-primary">Login</button>
					      	<button type="reset" style="margin-left:20px;" class="btn">Clear</button> 
					    </div>
				  	</div>
				</form>
				Click <button id="inst_reg" class="btn">Here</button> to open registration form for new institute.
			</div>
		</div>
		<script type="text/javascript">
			$('.selectpicker').selectpicker();
		</script>

		<!-- ######### div for Registration new institute box ######## -->
		<div id="reg_modal"  class="modal hide fade" area-hidden="true" style="margin-top:5px;">
			<div class="modal-header" style="height:20px">
				<button type="button" class="close" data-dismiss="modal">X</button>
				<h4>New Institute Registration</h4>
			</div>

			<div class="modal-body" style="max-height:800px;padding:10px" >
				<iframe src="institute/new_institute_form.php" width="99.6%" height="500" frameborder="0"></iframe>
			</div>
		</div>
	</body>
</html>