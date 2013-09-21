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

		<script type="text/javascript">
			$(function(){
				var initial_value = "";
				$('#instEmail').focus(function(){ initial_value = $('#instEmail').val(); });
				$('input').addClass("ui-corner-all");
				$('textarea').addClass("ui-corner-all");
				// Event 'Blur' on textField email
				$('#instEmail').blur(function(){
					var email_id = $('#instEmail').val();
					if (initial_value!=email_id) {
						$("#email_img").html("<img src='../img/ajax-loader.gif' width='20' height='20'>");
						$('#name').val("");
						$("#condition").val("");
						$('#wait').dialog("open");
						$("#name").attr("readonly", false);
						// Ajax call to retrieve data from database..
				        $.ajax({
				            type: "POST",
					        url: "ajax_Instructor_data.php",
					        data: {
				                email: email_id,
					        },
					        success: function(json) {
					        	var data = json.split("*"); 
				            	if (data[0]=='Exist') {
					           		var str = "User with email_id '"+email_id+"' is already registered as instructor.";
						      		alert(str);
						      		$('#add_inst_form').find('form')[0].reset();
						       	};
						       	if (data[0]!='Exist' && data[0]!=" ") {
						       		if (data[1]!="student") {
						       			$('#name').val(data[0]);
						       			$("#name").attr("readonly", true);
							            $('#user_id').val(data[1]);
							            $("#condition").val("old");
							        };
						        };
						        if (data[0]==" ") {
						        	$("#condition").val("new");
						        };
						        $("#email_img").html("");
					        },
					        failure: function() {
					        	$("#email_img").html("");
					        	$('#instructor_form').find('#reset').click();
					            alert('failed to get data through ajax.');
					        }
					    }); // ajax ends
					}; // end if condition
				}); // End on blur
			});
		</script>
	</head>

	<body>
		<form class="form-horizontal" id="new_student_form" action="submit_form.php" method="POST">

			<div class="control-group span5">
				<label class="control-label" for="instEmail">Email_id :</label>
				<div class="controls">
					<input class="input" type="email" id="instEmail" name="instEmail" placeholder="abc@example.com" required>
					<span id="email_img"></span>
				</div>
			</div>

			<div class="control-group span5">
				<label class="control-label" for="name">Name :</label>
				<div class="controls">
					<input class="input" type="text" id="name" name="name" placeholder="Name of Instructor" required>
				</div>
			</div>

			<div class="control-group span5">
				<label class="control-label" for="instAddress">Address :</label>
				<div class="controls">
					<textarea rows="3" cols="30" id="instAddress" name="instAddress"></textarea>
				</div>
			</div>
			
			<div class="control-group span5">
				<label class="control-label" for="contactNo">Contact-No :</label>
				<div class="controls">
					<input class="input" type="text" id="contactNo" name="contactNo" placeholder="999999999">
				</div>
			</div>

			<!--HIDDEN FIELDS-->
			<input type="text" name="condition" id="condition" style="display:none;">
			<input type="text" name="user_id" id="user_id" style="display:none;">

			<div class="control-group span5">
				<div class="controls">
					<button class="btn btn-primary" type="submit" name="submit">ADD</button>
					<button class="btn" type="reset">Reset</button>
				</div>
			</div>
			
		</form>

	</body>
</html>