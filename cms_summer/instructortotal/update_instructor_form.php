<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<script src="../jquery_ui_lib/jquery_1.10.1.min.js"></script>
		
		<script src="../bootstrap/js/bootstrap.js"></script>
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-responsive.min.css">

		<script src="../jquery_ui_lib/jquery_ui_1.10.3.min.js" type="text/javascript"></script>
		
		<style type="text/css">
			.control-group{margin: 0px}
		</style>
	</head>

	<body>
		<form class="form-horizontal" action="update_instructor.php" method="POST">
			
			<div class="control-group span5">
				<label class="control-label" for="instructorName">Instructor Name :</label>
				<div class="controls">
					<input class="input" type="text" name="instructorName" id="instructorName" value="<?php echo $_GET['instructorName']; ?>" required>
				</div>
			</div>
			<div class="control-group span5">
				<label class="control-label" for="instructorEmail">Instructor Email :</label>
				<div class="controls">
					<input class="input" type="email" name="instructorEmail" id="instructorEmail" value="<?php echo $_GET['instructorEmail']; ?>" readonly>
				</div>
			</div>
			<div class="control-group span5">
				<label class="control-label" for="contact">Contact :</label>
				<div class="controls">
					<input class="input" type="text" name="contact" id="contact" value="<?php echo $_GET['contact']; ?>" required>
				</div>
			</div>
			<div class="control-group span5">
				<label class="control-label" for="address">Address :</label>
				<div class="controls">
					<textarea rows="3" cols="30" id="address" name="address"><?php echo $_GET['address']; ?></textarea>
				</div>
			</div>
			<div class="control-group span5">
				<div class="controls">
							<input type="hidden" name="instructor_id" value="<?php echo $_GET['instructorid']; ?>">
							<input type="hidden" name="institute_No" value="<?php echo $_GET['institute_No']; ?>">
					<button class="btn btn-primary" type="submit" name="submit">Update</button>
					<button class="btn" type="reset">Reset</button>
				</div>
			</div>
				
		</form>

	</body>
</html>