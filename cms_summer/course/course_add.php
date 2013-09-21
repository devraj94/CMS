<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<script src="../jquery_ui_lib/jquery_1.10.1.min.js"></script>
		
		<script src="../bootstrap/js/bootstrap.js"></script>
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">

		<script src="../bootstrap/pnotify-1.2.0/jquery.pnotify.js" type="text/javascript"></script>
		<link href="../bootstrap/pnotify-1.2.0/jquery.pnotify.default.css" rel="stylesheet" type="text/css">

		<script src="../bootstrap/fileupload/bootstrap-fileupload.js"></script>
		<link href="../bootstrap/fileupload/bootstrap-fileupload.css" rel="stylesheet" type="text/css" />

		<script src="../jquery_ui_lib/jquery_ui_1.10.3.min.js" type="text/javascript"></script>

		<style type="text/css">
			.ui-pnotify-history-container { display: none; }
		</style>

		<script type="text/javascript">
			$(function(){
				var check=0;
				var initial_value = "";
				$('#course_code').focus(function(){ initial_value = $('#course_code').val(); });
				// Event 'Blur' on textField
				$('#course_code').blur(function(){
					course_code = $('#course_code').val();
					if (course_code!=initial_value) {
						$("#code_img").html("<img src='../img/ajax-loader.gif' width='20' height='20'>");
						$.ajax({
				            type: "POST",
				            url: "ajax_course.php",
						    data: {
					            c_code: course_code,
					            check_course_code_from_add: "1",
					        },
					        success: function(data) {
					          	if (data=='0') {
					           		$("#code_img").html("<img src='../img/ww.png' width='20' height='20'>");
					           		$.pnotify({
									    title: 'Warning!',
									    text: 'Entered course-code already in use. <br>Choose another one.',
									    type: 'warning',
									    hide: true
									});
									check=0;
								};
								if (data=="1") {
									$("#code_img").html("<img src='../img/success.png' width='20' height='20'>");
									check=1;
								};
				            },
				            failure: function() {
				            	$("#code_img").html("<img src='../img/error.png' width='20' height='20'>");
				                $.pnotify({
								    title: 'Error!',
								    text: 'Error while fetching data from database.',
								    type: 'error',
									hide: true
								});
								check=0;
				            }
					    }); // ajax ends
					};
				}); // End on blur
				
				//
				$("form").submit(function(e){
					if (check==0) {
						e.preventDefault();
						$.pnotify({
						    title: 'Warning!',
						    text: 'Entered course-code is not a valid code. <br>Choose another one.',
						    type: 'warning',
							hide: true
						});
						$("#course_code").focus();
					};
				});
			});
		</script>
	</head>
	<body>
		<form class="form-horizontal" id="course_form" enctype="multipart/form-data" action="new_course_db.php" method="POST">

			<div class="control-group span5">
				<label class="control-label" for="course_code">Course code :</label>
				<div class="controls">
					<input class="input" type="text" id="course_code" name="course_code" placeholder="Type Course-Code here" required>
					<span id="code_img"></span>
				</div>
			</div>

			<div class="control-group span5">
				<label class="control-label" for="course_title">Course title :</label>
				<div class="controls">
					<input class="input" type="text" id="course_title" name="course_title" placeholder="Title of Course" required>
				</div>
			</div>
			
			<div class="control-group span5">
				<label class="control-label" for="description">Description :</label>
				<div class="controls">
					<textarea id="description" name="description"></textarea>
				</div>
			</div>
			
			<div class="control-group span5">
				<label class="control-label" for="file">Description File :</label>
				<div class="controls">

					<div class="fileupload fileupload-new" data-provides="fileupload">
					  	<div class="input-append" style="width:220px;">
					    	<div class="uneditable-input span3">
					    		<i class="icon-file fileupload-exists"></i>
					    		<span class="fileupload-preview"></span>
					    	</div>
					    	<span class="btn btn-file">
					    		<span class="fileupload-new">Select file</span>
					    		<span class="fileupload-exists">Change</span>
					    		<input type="file" name="file" id="file"/>
					    	</span>
					    	<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
					  	</div>
					</div>

				</div>
			</div>
			
			<div class="control-group span5">
				<div class="controls">
					<button class="btn btn-primary" type="submit" name="submit">ADD</button>
					<button class="btn" type="reset">Reset</button>
				</div>
			</div>
			
		</form>
	</body>
</html