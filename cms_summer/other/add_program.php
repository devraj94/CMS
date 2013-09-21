
<?php
	if (isset($_GET["done"])) {
		include(dirname(dirname(__FILE__))."./function.php");
		message_box("SUCCESS!","Program Successfully added.",0,0);
	}
?>
<html>
	<head>
		<script src="../jquery_ui_lib/jquery_1.10.1.min.js"></script>
		<script src="../jquery_ui_lib/jquery_ui_1.10.3.min.js"></script>
		<link href="../css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
			$(function(){
				$('#progCode').blur(function(){
					progCode= $("#progCode").val();
					$.ajax({
						type: "POST",
						url: "ajax_check.php",
						data: {code: progCode, prog: "1",},
					    success: function(data){
					    	if (data=="0") {
					    		alert("Program already exist with this code '"+progCode+"'");
					    		$('#program_form_div').find('form')[0].reset();
					    	};
					    	if (data=="1") {
					    		$("#condition").val("1");
					    	};
					    },
					    failure: function(){
					    	alert("failed");
					    }
					}); // ajax end
				});
			});
		</script>
	</head>
	<body>
		<div id="program_form_div">
			<form id="program_form" action="ajax_check.php" method="POST">
				<table>
					<tr>
						<td><label for="progCode">Program Code :</label></td>
						<td><input type="text" id="progCode" name="progCode" required></td>
					</tr>
					<tr>
						<td><label for="progName">Program Name :</label></td>
						<td><input type="text" id="progName" name="progName" required></td>
						<input type="text" name="condition" id="condition" style="display:none;">
						<input type="reset" id="reset" style="display:none;">
						<input type="submit" id="submit" style="display:none;">
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>