<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");
?>

<html>
	<head>
		<script src="../jquery_ui_lib/jquery_1.10.1.min.js"></script>
		<script src="../jquery_ui_lib/jquery_ui_1.10.3.min.js"></script>
		<link href="../css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
			$(function(){
			var ins="<?php echo isset($_GET['ins'])? $_GET['ins']:'';?>";
				   if(ins==''){
			        my_url= "ajax_ta_data.php";
				   }else{
				    my_url= "ajax_ta_data.php?ins=1";
				   }
				$('input').addClass("ui-corner-all");
				$('textarea').addClass("ui-corner-all");
				// hide wait text
				$('#waiting').hide();
				// Event 'Blur' on textField email
				$('#taEmail').blur(function(){
					$("#condition").val("");
					// If radio button 'exist_user' is checked
					$('#waiting').dialog("open");
					email_id = $('#taEmail').val();
					// Ajax call to retrieve data from database..
			        $.ajax({
			            type: "POST",
				        url: my_url,
				        data: {
			                email: email_id,
				        },
				        success: function(json) {
				        	var data = json.split("*"); 
			            	if (data[0]=='Exist' && data[1]=='yes') {
								$('#name').val(data[2]);
					            $("#taAddress").val(data[3]);
								$("#contactNo").val(data[4]);
					            $("#condition").val("ins");
								
								$('#waiting').dialog("close");
					       	};
							if(data[0]=='Exist' && data[1]=='no'){
							
				           		var str = "User with email_id '"+email_id+"' is already registered as ta.";
								alert(str);
					       		$('#add_ta_form').contents().find('#reset').click();
								$('#waiting').dialog("close");
								};
								
					       	if (data[0]!='Exist' && data[0]!=" ") {
					            $('#name').val(data[0]);
					            $('#type').val(data[1]);
					            $("#taAddress").val(data[2]);
					            $("#condition").val("old");
								$('#waiting').dialog("close");
					        };
					        if (data[0]==" ") {
					        	$("#condition").val("new");
								$('#waiting').dialog("close");
					        };
					        
				        },
				        failure: function() {
				            alert('failed to get data through ajax.');
							$('#waiting').dialog("close");
				        }
				    }); // ajax ends
				});// End on blur
                 $("#waiting").dialog({
					autoOpen: false,modal: true,closeOnEscape: false,width: 180, height:50,
					create: function (event, ui) {
        				$(".ui-widget-header").hide();
        			}
				  });				
			});
		</script>
	</head>

	<body>
	<div id="add_ta_form">
		<form action="ajax_ta_data.php" method="POST" id="ta_form">
			<table>
				<tr>
					<td width="70"><label for="taEmail">Email_id :</label></td>
					<td><input id="taEmail" type="email" required  name="taEmail"><span id="waiting">Please Wait...</span></td>
				</tr>
				<tr>
					<td><label for="name">Name :</label></td>
					<td><input id="name" type="text" required name="name"></td>
				</tr>
				<tr>
					<td><label for="taAddress">Address :</label></td>
					<td><textarea rows="3" cols="30" id="taAddress" name="taAddress"></textarea></td>
				</tr>
				<?php
				if(isset($_GET['ins'])){
				echo "<tr>";
				$sem="sem";
				echo "<td><label for=".$sem.">Semester:</label></td>";
				echo "<td>";
				echo "<select id=".$sem." name=".$sem.">";
				    $s = get_session();
					for ($i=0; $i < 4; $i++) { 
						$x = (2*$i) + $s; 
						echo "<option value='$x'> $x </option>";
					}
					echo "</select>";
				echo "</td>";
				echo "</tr>";
				}
				?>
				<tr>
					<td><label for="contactNo">Contact-No :</label></td>
					<td><input id="contactNo" type="tel" name="contactNo"></td>
					<input type="text" name="condition" id="condition" style="display:none;">
					<input type="text" name="type" id="type" style="display:none;">
					<input type="submit" name="submit_button" id="submit" style="display:none;">
					<input type="reset" id="reset" style="display:none;">
				</tr>
			</table>
		</form>
	</div>
	</body>
</html>