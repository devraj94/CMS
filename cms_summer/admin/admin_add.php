<html>
	<head>
			<script src="../jquery_ui_lib/jquery_1.10.1.min.js"></script>
			<script src="../jquery_ui_lib/jquery_ui_1.10.3.min.js"></script>
			<link href="../css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
			<link href="../css/cms.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript">
				$(function(){
					var initial_value = "";
					$('#adminEmail').focus(function(){ initial_value = $('#adminEmail').val(); });
					$('input').addClass("ui-corner-all");
					// Event 'Blur' on textField email
					$('#adminEmail').blur(function(){
						var email_id = $('#adminEmail').val();
						$('#condition').val('');
						if (email_id!=initial_value) {
							$("#name").attr("readonly", false);
							$("#wait").dialog("open");
							// Ajax call to retrieve data from database..
					        $.ajax({
					            type: "POST",
					            url: "ajax_Admin_data.php",
					            data: {
					                email: email_id,
					            },
					            success: function(json) {
					            	//alert(json);
					            	var data = json.split("*"); 
					            	if (data[0]=='Exist' && data[1]=='administrator') {
					            		$("#wait").dialog("close");
					            		alert("This user with email id :"+email_id+" already a Admin.");
										$('#add_admin_form').find('form')[0].reset();
									};
									if(data[0]!='Exist' && data[0]!=" "){
										//alert(data[1]);
									   $('#name').val(data[0]);
									   $("#name").attr("readonly", true);
									   $('#condition').val('old');
									   $('#tab').val(data[1]);
									   $("#wait").dialog("close");
									};
									if(data[0]==" "){
										$('#condition').val('new');
										$("#name").attr("readonly", false);
										$("#wait").dialog("close");
									};
					                
					            },
					            failure: function() {
					            	$("#wait").dialog("close");
					            	$("#name").attr("readonly", false);
					                alert('fail');
					                
					            }
					        }); // ajax ends
						};
					}); // End on blur
					
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
		<div id="wait" style="padding:0;">
			<table>
				<tr>
					<td valign="middle"><img src="../img/ajax-loader.gif" width="30" height="30"></td>
					<td valign="middle"> Please Wait..</td>
				</tr>
			</table>
		</div>

		<div id="add_admin_form">
			<form id="myform" action="ajax_Admin_data.php" method="POST">
				<table>
					<tr>
						<td width="70" align="right"><label for="adminEmail">Email-id :</label></td>
						<td colspan="2"><input id="adminEmail" type="email" name="email_id" class="textwidth" required ></td>
					</tr>
					<tr>
						<td align="right"><label for="name">Name :</label></td>
						<td colspan="2"><input id="name" type="text" name="name" class="textwidth" required></td>
					</tr>
					
					<tr>
						<td align="right"><label for="designation">Designation :</label></td>
						<td colspan="2"><input id="designation" type="text" name="designation" class="textwidth" required></td>
					</tr>
					
					<tr>
						<td align="right"><label for="type">Role :</label></td>
						<td colspan="2">
							<select id="type" name="type" class="optionwidth">
								<option value="2">Primary</option>
								<option value="3" selected>Secondary</option>
							</select>
						</td>
					</tr>
					
					<tr>
						<td align="right"><label for="permission_status">Permission :</label></td>
						<td colspan="2">
							<select id="permission_status" name="permission_status" class="optionwidth">
								<option value="1">Allow</option>
								<option value="0">Disallow</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><input type="submit" id="submit" name="submit" style="display:none;"></td>
						<td><input type="text" name="condition" id="condition" style="display:none;"></td>
						<td><input type="text" name="tab" id="tab" style="display:none;"></td>
						<input type="reset" id="reset" style="display:none;">
					</tr>
				</table>
			</form>
		</div>
	</body>
</html