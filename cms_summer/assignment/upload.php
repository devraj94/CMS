<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./db_config.php");

	$institute_No = $_SESSION["institute_id"];
	// connect to the MySQL database server 
    $db = mysql_connect($dbhost, $dbuser, $dbpass) or die("Connection Error: " . mysql_error()); 
    // select the database 
    mysql_select_db($dbname) or die("Error connecting to db.");

    $sql1 = "SELECT * FROM program WHERE institute_No='$institute_No'";
	$result = mysql_query($sql1, $db) or die("Couldn't execute query.".mysql_error());
	$id=$_GET['id'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
	
	<title>Assignments</title>
			<style type="text/css"> .ui-widget{font-size: 70%;} #ui-datepicker-div { font-size: 12px; } </style>
			<script src="../jquery_ui_lib/jquery_1.10.1.min.js"></script>
			<script src="../jquery_ui_lib/jquery_ui_1.10.3.min.js"></script>
			<link href="../css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript">
				$(function(){
					$( "#duedate" ).datepicker();
					$('input').addClass("ui-corner-all");
					$('textarea').addClass("ui-corner-all");
					$('#assign_no').blur(function(){
					    assn = $('#assign_no').val();
						$('#wait').dialog("open");
						$.ajax({
				            type: "POST",
				            url: "uploaddata.php?p=1&myid=<?php echo $id;?>",
				            data: {
				                assign: assn,
				            },
				            success: function(data) {
				            	if (data=='yes') {
				            		alert("Assignment "+assn+" has already been uploaded!!");
					       		$('#assignment_form_div').contents().find('#reset').click();
				            	};
								$('#wait').dialog("close");
				            },
				            failure: function() {
				                alert('fail');
								$('#wait').dialog("close");
				            }
				        }); // ajax ends
				    });// End on blur
					
					$("#wait").dialog({
					autoOpen: false,modal: true,closeOnEscape: false,width: 180, height:50,
					create: function (event, ui) {
        				$(".ui-widget-header").hide();
        			}
				});	
				}); 
			</script>
	</head>
	<body>
	<div id="wait">
			<table>
				<tr>
					<td valign="middle"><img src="../img/ajax-loader.gif" width="30" height="30"></td>
					<td valign="middle"> Please Wait..</td>
				</tr>
			</table>
		</div>
		<div id="assignment_form_div">
			<form id="assign_form" enctype="multipart/form-data" action="uploaddata.php?id=<?php echo $id;?>" method="POST">
				<table>
					<tr>
						<td><label for="assign_no">Assignment No :</label></td>
						<td><input id="assign_no" type="text" name="assign_no" required></td>
					</tr>
					<tr>
						<td><label for="topic">Topic :</label></td>
						<td><input id="topic" type="text" name="topic" required></td>
					</tr>
					<tr>
						<td><label for="duedate">Due Date :</label></td>
						<td><input id="duedate" type="text" name="duedate" required></td>
					</tr>
					<tr>
					    <td><label for="file">FileName:</label></td>
					    <td><input type="file" id="file" name="file"/></td>
					</tr>
						<td><input type="reset" id="reset" ></td>
						<td><input type="submit" id="submit" ></td>
					</tr>
				</table>
			</form>
		</div>
	</body>
</html>