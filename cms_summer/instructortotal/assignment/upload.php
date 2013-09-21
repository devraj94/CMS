<?php
	include(dirname(dirname(__FILE__))."./../user_session.php");
	include(dirname(dirname(__FILE__))."./../db_config.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$institute_No = $_SESSION["institute_id"];
	$instructorid=$_SESSION['instructor_id'];
	// connect to the MySQL database server 
    $db = mysql_connect($dbhost, $dbuser, $dbpass) or die("Connection Error: " . mysql_error()); 
    // select the database 
    mysql_select_db($dbname) or die("Error connecting to db.");

	$id=$_GET['id'];
	$sem=$_GET['sem'];
?>

<html>
	<head>
	
	<title>Assignments</title>
			<script src="../../bootstrap/js/bootstrap.js"></script>
		<link href="../../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap-responsive.min.css">

		<script src="../../bootstrap/pnotify-1.2.0/jquery.pnotify.js" type="text/javascript"></script>
		<link href="../../bootstrap/pnotify-1.2.0/jquery.pnotify.default.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="../../bootstrap/select/jquery.selectBoxIt.css">

		<style type="text/css">
			.control-group{margin: 0px} .ui-pnotify-history-container { display: none; }
		</style>
		<script src="../../jquery_ui_lib/jquery_1.10.1.min.js"></script>
		<script src="../../bootstrap/select/jquery.selectBoxIt.min.js" type="text/javascript"></script>
		<script src="../../jquery_ui_lib/jquery_ui_1.10.3.min.js"></script>
			<script type="text/javascript">
				$(function(){
					$('input').addClass("ui-corner-all");
					$('textarea').addClass("ui-corner-all");
					var initial_value = "";
				$('#assign_no').focus(function(){ initial_value = $('#assign_no').val(); });
					$('#assign_no').blur(function(){
					    assn = $('#assign_no').val();
					if(assn!=initial_value){
					$("#roll_img").html("<img src='../../img/ajax-loader.gif' width='20' height='20'>");
						$.ajax({
				            type: "POST",
				            url: "uploaddata.php?p=1&myid=<?php echo $id;?>",
				            data: {
				                assign: assn,
				            },
				            success: function(data) {
				            	if (data=='yes') {
				            		 $("#roll_img").html("<img src='../../img/ww.png' width='20' height='20'>");
											$.pnotify({
												title: 'Error!',
												text: 'Assignment '+assn+' has already been uploaded!!',
												type: 'error',
												hide: true
											});
				            	}else{
								$("#roll_img").html("<img src='../../img/success.png' width='20' height='20'>");
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
									$('#stdRoll_No').val("");
				            }
				        }); // ajax ends
					};
				    });// End on blur
					
					
				}); 
				          $(function() {
							$( "#duedate" ).datepicker();
							$( "#permissiondate" ).datepicker();
						  });
			</script>
	</head>
	<body>
	
		
			<form class="form-horizontal" id="assign_form" enctype="multipart/form-data" action="uploaddata.php?id=<?php echo $id;?>" method="POST">
			<div class="control-group span5">
				<label class="control-label" for="assign_no">Assignment No :</label>
				<div class="controls">
					<input class="input" type="text" id="assign_no" name="assign_no"  required>
					<span id="roll_img"></span>
				</div>
			</div>
			<div class="control-group span5">
				<label class="control-label" for="topic">Topic :</label>
				<div class="controls">
					<input class="input" type="text" id="topic" name="topic"  required>
				</div>
			</div>
					
					
					
									<style type="text/css">
					.ui-datepicker {
						font-size:10px;
					}
					</style>
			<div class="control-group span5">
				<label class="control-label" for="duedate">Due Date :</label>
				<div class="controls">
					<input class="input" type="text" id="duedate" name="duedate"  required>
				</div>
			</div>
			<div class="control-group span5">
				<label class="control-label" for="permissiondate">Permission Date :</label>
				<div class="controls">
					<input class="input" type="text" id="permissiondate" name="permissiondate"  >
				</div>
			</div>	
            <div class="control-group span5">
				<label class="control-label" for="file">FileName :</label>
				<div class="controls">
					<input class="input" type="file" id="file" name="file"  required>
				</div>
			</div>				
			<div class="control-group span5">
				<div class="controls">
					<button class="btn btn-primary" name="submit" type="submit" id="submit">Submit</button>
					<button class="btn" type="reset" id="reset" style="margin-left:15px;">Clear</button>
				</div>
			</div>

			</form>
	</body>
</html>