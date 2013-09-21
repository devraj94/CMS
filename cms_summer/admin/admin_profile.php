<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");

	$instName = $_SESSION["instName"];
	$username = $_SESSION["username"];
	$user_id = $_SESSION["user_id"];;
	$admin_id = "";
	$adminName = "";
	$adminAddress = "";
	$adminEmail = "";
	$institute_id = $_SESSION["institute_id"];
	$instName = "";
	$instShortName = "";
	$instEmail = "";
	$instURL = "";
	$inst_logo_path = "";

	$passwordFound = 0;
	$_SESSION["successful"]=0; // to check whether password succefully changed

	# Getting details from 'admin_m_details' table
	$sql = "SELECT * FROM admin_m_details WHERE user_id = '$user_id'";
	$result = mysql_query($sql) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{ 
		$adminName = $row["admin_name"];
		$adminEmail = $row["email_id"];
		$admin_id = $row["admin_id"];
	}

	# Getting details from institute_m_details table
	$sql = "SELECT * FROM institute_m_details WHERE institute_id = '$institute_id'";
	$result = mysql_query($sql, $connection) or die(mysql_error());
	while($row = mysql_fetch_array($result)){ 		
		$instName = $row["institute_name"];
		$instShortName = $row["institute_short_name"];
		$instAddress = $row["institute_address"];
		$city = $row["city"];
		$pincode = $row["pin_code"];
		$state = $row["state"];
		$instPhone = $row["landline_no"];
		$instURL = $row["institute_domain"];
		$instEmail = $row["email_id"];
		$instFax = $row["institute_fax"];
		$inst_logo_path = $row["institute_logo"];
		break;
	}

	# For updating username and password
	if (isset($_POST['passChange'])) {
		$_SESSION["user_pass"]=1;

		$old_pass = mysql_real_escape_string($_POST['old_pass']);
		$new_Pass = mysql_real_escape_string($_POST['adminPass']);
		$new_re_Pass = mysql_real_escape_string($_POST['rePass']);
		
		$username_exits = 0;
		if (row_exist("users","user_id = '$user_id' AND username='$username' AND password='$password'")) {
			$passwordFound++;
			if ($new_Pass == $new_re_Pass) {
				$update = update_a_column_of_table("users","password",$new_Pass,"user_id='$user_id'",$username);
				if ($update) {
					$_SESSION["successful"]=1;
					$_SESSION["password"]=$new_Pass;
				}
			}
		}
	}else{}
	
?>

<html>
	<head>
		<title>Admin Profile</title>
		<script src="../jquery_ui_lib/jquery_1.10.1.min.js"></script>
		<script src="../jquery_ui_lib/jquery_ui_1.10.3.min.js"></script>
		<link href="../css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
			body,tbody.form_update_admin {
			    font-size: 75%;
			}
			html{padding: 10;}
			#profile-header{
				border-top-left-radius: 20;
				border-top-right-radius: 20;
				padding-left: 20; 
				width: 160;
				font-size: 20;
			}
			#profile-details{
				width: auto;
				border-bottom-left-radius: 15;
				border-bottom-right-radius: 15;
				border-top-right-radius: 15;
				padding-left: 20;
				padding-top: 10;
				padding-bottom: 10;
				background: rgba(215, 149, 44, 0.2);
			}
			table#mytable{border: 4px ridge;}
			tr.mystyle:nth-child(even) {background: #CCC}
			tr.mystyle:nth-child(odd) {background: #FFF}
			td.mycol{font-weight: 600;}
		</style>
		<script type="text/javascript">
			// increase the default animation speed to exaggerate the effect
			$.fx.speeds._default = 150;
			$(function() {
				$('#update_admin_button').button();
				$('#change_pass_button').button();

				/* Jquery-UI-Dialog defination for Update_Profile Form*/
				$('#form_update_admin').dialog({
					autoOpen: false,
					modal: true,
					width: 'auto',
					height: 'auto',
					show: "blind",
					hide: "fold",
					closeOnEscape: true,
					buttons: {
						Reset: function(){
							$("form")[1].reset();
						},
						Update: function(){
							$('#submitButton2').click();
						},
						Close: function(){
							$("form")[1].reset();
							$(this).dialog("close");
						}
					}
				});

				$('#form1').dialog({
					autoOpen: false,
					modal: true,
					width: 'auto',
					height: 'auto',
					show: "blind",
					hide: "blind",
					closeOnEscape: true,
					buttons: {
						Reset:function(){
							$('#adminPass').val('');
							$('#rePass').val('');
							$('#old_pass').val('');
						},
						Change: function(){
							$('#submit_btn').click();
						},
						Close: function(){
							$("form")[0].reset();
							$(this).dialog("close");
						}
					}
				});
			});	
		</script>
	</head>
	<body>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#pass_msg").delay(2000).hide(1000);
				$("#update_msg").delay(2000).hide(1000);
			});
			 
		</script>

		<!--####################################################################################################-->
		<!-- Admin-Profile view starts from here -->
		<div class="ui-widget">
		<div class="ui-widget-header" id="profile-header">Profile</div>
		<div id="profile-details" style="display:''" class="ui-widget-content">
			<table>
				<tbody>
						<tr>
							<td>
								<table id="mytable" border="0" cellspacing="0">
									<tr class="mystyle">
										<td class="mycol"><label>Institute Name :</label></td>
										<td><label><?php echo $instName;?></label></td>
									</tr>
									<tr class="mystyle">
										<td class="mycol"><label>Institute Short Name :</label></td>
										<td><label><?php echo $instShortName;?></label></td>
									</tr>
									<tr class="mystyle">
										<td class="mycol"><label>Institute-email :</label></td>
										<td><label><?php echo $instEmail;?></label></td>
									</tr>
									<tr class="mystyle">
										<td class="mycol"><label>Institute Domain :</label></td>
										<td><label><?php echo $instURL;?></label></td>
									</tr>
									<tr class="mystyle">
										<td class="mycol"><label>Address :</label></td>
										<td><label><?php echo $instAddress;?></label></td>
									</tr>
									<tr class="mystyle">
										<td class="mycol"><label for="city">City :</label></td>
										<td>
											<table>
												<tr>
													<td><label id="city"><?php echo $city;?></label></td>
													<td width="200" align="right" class="mycol"><label for="pin">PinCode :</label></td>
													<td><label id="pin"><?php echo $pincode;?></label></td>
												</tr>
											</table>
										</td>
									</tr>
									<tr class="mystyle">
										<td class="mycol"><label for="state">State :</label></td>
										<td><label id="state"><?php echo $state;?></label></td>
									</tr>
									<tr class="mystyle">
										<td class="mycol"><label for="phone">Institute Phone :</label></td>
										<td><label id="phone"><?php echo $instPhone;?></label></td>
									</tr>
									<tr class="mystyle">
										<td class="mycol"><label for="fax">Institute Fax :</label></td>
										<td><label id="fax"><?php echo $instFax;?></label></td>
									</tr>
									<tr class="mystyle">
										<td class="mycol"><label for="adminName">Admin Name :</label></td>
										<td><label id="adminName"><?php echo $adminName;?></label></td>
									</tr>
									<tr class="mystyle">
										<td class="mycol"><label for="adminEmail">Admin's Email-id :</label></td>
										<td><label id="adminEmail"><?php echo $adminEmail;?></label></td>
									</tr>
								</table>
							</td>

							<td width="300" align="right">
								<table border="0" cellspacing="0">
									<tr class="ui-widget-header" id="logo_header" align="center">
										<td>Institute Logo</td>
									</tr>
									<tr class="ui-widget-content" id="logo_pic">
										<td align="center">
											<img src='../<?php echo $inst_logo_path;?>' style='width:200; height:150;'>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						
				</tbody>
			</table>
		</div>
		</div>	
		<!-- Admin-Profile View ends here -->
		<!--####################################################################################################-->
		

		<button onclick="$('#form_update_admin').dialog('open');" id="update_admin_button">Edit Profile</button><br>


		<button onclick="$('#form1').dialog('open');" id="change_pass_button">Change Password</button>

		<!--####################################################################################################-->
		<!--Form to change Username and Password-->
		<div id="form1" title="Change Password" style="display:none;">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<table>
					<tbody>
						<tr>
							<td><label for="old_pass">Old Password :</label></td>
							<td><input type="password" name="old_pass" id="old_pass" required></td>
						</tr>
						<tr>
							<td><label for="adminPass">New Password :</label></td>
							<td><input type="password" name="adminPass" id="adminPass" required></td>
						</tr>
						<tr>
							<td><label for="rePass">Confirm Password :</label></td>
							<td><input type="password" name="rePass" id="rePass" required></td>
							<input style="display:none;" type="submit" name="passChange" id="submit_btn">
						</tr>
					</tbody>
				</table><!--Table Ends-->					
		</form>
		</div>
		<!-- Form for change password ends here -->
		<!--####################################################################################################-->

		<!--####################################################################################################-->
		<!-- Form for Update-Profile starts here -->
		<div id="form_update_admin" title="Update Profile" style="display:none;">
		<form action="update_admin.php" enctype="multipart/form-data" method="POST">
			<table>
				<tbody class="form_update_admin">
					<tr>
						<td><label for="instName">Institute Name :</label></td>
						<td><input type="text" size="40" value="<?php echo $instName; ?>" name="instName" id="instName" readonly="readonly"></td>
					</tr>
					<tr>
						<td><label for="instShortName">Institute Short-Name :</label></td>
						<td><input type="text" size="40" value="<?php echo $instShortName; ?>" name="instShortName" id="instShortName"></td>
					</tr>
					<tr>
						<td><label for="instEmail">Institute-email :</label></td>
						<td><input type="email" value="<?php echo $instEmail; ?>" name="instEmail" id="instEmail" required>*</td>
					</tr>
					<tr>
						<td><label for="instURL">Institute Domain :</label></td>
						<td><input type="url" name="instURL" id="instURL" value="<?php echo $instURL; ?>"></td>
					</tr>
					<tr>
						<td><label for="instAddress">Institute-Address :</label></td>
						<td><textarea rows="3" cols="40" id="instAddress" name="instAddress"><?php echo $instAddress;?></textarea></td>
					</tr>
					<tr>
						<td><label for="city">City :</label></td>
						<td>
							<table>
							<tbody class="form_update_admin">
								<tr>
									<td><input type="text" id="city" size="14" name="city" value="<?php echo $city;?>"></td>
									<td align="right"><label for="pin">PinCode :</label></td>
									<td><input type="text" id="pin" name="pin" maxlength="6" size="5" value="<?php echo $pincode;?>"></td>
								</tr>
							</tbody>	
							</table>
						</td>
					</tr>
					<tr>
						<td><label for="state">State :</label></td>
						<td><input type="text" id="state" name="state" value="<?php echo $state;?>"></td>
					</tr>
					<tr>
						<td><label for="phone">Institute Phone :</label></td>
						<td><input type="text" name="phone" id="phone" value="<?php echo $instPhone;?>"></td>
					</tr>
					<tr>
						<td><label for="fax">Institute Fax :</label></td>
						<td><input type="text" name="fax" id="fax" value="<?php echo $instFax;?>"></td>
					</tr>
					<tr>
						<td><label for="adminName">Admin Name :</label></td>
						<td><input type="text" name="adminName" id="adminName" value="<?php echo $adminName; ?>" required>*</td>
					</tr>
					<tr>
						<td><label for="file">Institute-Logo :</label></td>
						<td><input type="file" name="file" id="file"></td>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="admin_id" value="<?php echo $admin_id; ?>">
							<input type="hidden" name="institute_id" value="<?php echo $institute_id; ?>">
						</td>
						<td><input type="submit" id="submitButton2" style="display:none;"></td>
					</tr>
				</tbody>
			</table>
		</form>
		</div>
		<!-- Form for Update-Profile ends here -->
		<!--####################################################################################################-->


	</body>

</html>
<?php
			if ($passwordFound!=0 && $_SESSION["successful"]==0) {
				?>
					<script type="text/javascript">alert("Password not matched") </script>
				<?php
			}
			if ($_SESSION["successful"]==1) {
				$_SESSION["successful"]=0;
				?>
					<script type="text/javascript">alert("Password successfully changed.") </script>
				<?php
			}
			if ($passwordFound==0 && $_SESSION["user_pass"]==1) {
				$_SESSION["user_pass"]=0;
				?>
					<script type="text/javascript">alert("Password is wrong...") </script>
				<?php
			}
			
		?>