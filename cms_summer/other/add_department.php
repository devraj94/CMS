<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$institute_id = $_SESSION["institute_id"];
	$sql = "SELECT * FROM program_m_details WHERE institute_id='$institute_id'";
	$result = mysql_query($sql);
?>
<html>
	<head>
		<script src="../jquery_ui_lib/jquery_1.10.1.min.js"></script>
		<script src="../jquery_ui_lib/jquery_ui_1.10.3.min.js"></script>
		<link href="../css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
			$(function(){
				$('#dcode').blur(function(){
					dcode= $("#dcode").val();
					$.ajax({
						type: "POST",
						url: "ajax_check.php",
						data: {department_code: dcode, dep: "1",},
					    success: function(data){
					    	if (data=="0") {
					    		window.parent.showDialog("Warning..","Department already exist with this code '"+dcode+"'",0,0);
					    		$('#department_form_div').find('form')[0].reset();
					    	};
					    	if (data=="1") {
					    		$("#condition_dep").val("1");
					    	};
					    },
					    failure: function(){
					    	window.parent.showDialog("ERROR!","Error while getiing data.",0,0);
					    }
					}); // ajax end
				});
			});
		</script>
	</head>
	<body>
		<div id="department_form_div">
			<form id="department_form" action="ajax_check.php" method="POST">
				<table>
					<tr>
						<td><label for="dcode">Department Code :</label></td>
						<td><input type="text" id="dcode" name="dcode" required></td>
					</tr>
					<tr>
						<td><label for="dname">Department Name :</label></td>
						<td><input type="text" id="dname" name="dname" required></td>
					</tr>
					<tr>
						<td><label for="prog_id">Choose Program :</label></td>
						<td>
							<select name="prog_id" id="prog_id">
								<?php
									while($row = mysql_fetch_array($result)){
										echo "<option value='".$row['program_id']."'>".$row['program_name']." (".$row['program_code'].")"."</option>";
									}
								?>
							</select>
						</td>
						<input type="text" name="condition_dep" id="condition_dep" style="display:none;">
						<input type="reset" id="reset" style="display:none;">
						<input type="submit" id="submit" style="display:none;">
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>