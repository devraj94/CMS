<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<script src="../jquery_ui_lib/jquery_1.10.1.min.js"></script>
		<script src="../jquery_ui_lib/jquery_ui_1.10.3.min.js"></script>
		<script src="../bootstrap/js/bootstrap.js"></script>
		<script src="../bootstrap/fileupload/bootstrap-fileupload.js"></script>
		<link href="../bootstrap/fileupload/bootstrap-fileupload.css" rel="stylesheet" type="text/css" />
		<link href="../css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript">
			// To check username availability
			$(function(){
				function validateEmail($email) {
				  	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				  	if( !emailReg.test( $email ) ) {
				    	return false;
				  	}else{
				    	return true;
				  	}
				}

				$(".alert").hide();
				var Register = false;
				var initial_email = "";
				var initial_name = "";

				$('#adminEmail').focus(function(){ initial_email = $('#adminEmail').val(); });
				$('#instShortName').focus(function(){ initial_name = $('#instShortName').val(); });

				$('#adminEmail').blur(function(){
					var Register = false;
					var focus_id = "";
					var email = $('#adminEmail').val();
					if (initial_email!=email) {
						$.ajax({
							type: "POST",
							url: "checkAvail.php",
							data: { adminUsername: email, check_Username:"1"},
							success: function(response){
								if (validateEmail(email) && response=="1") {
									Register=true;
									$("#email_icon").attr({"height":"16","width":"16","src":"../img/success.png"});
								}else{
									Register=false;
									$("#email_icon").attr({"height":"16","width":"16","src":"../img/warning.png"});
									$("#adminEmail").focus();
									focus_id="adminEmail";
								};
							},
							failure: function(){
								Register=false;
								focus_id="adminEmail";
							}
						});
					};
				});

				//
				$('#instShortName').blur(function(){
					var name = $('#instShortName').val();
					if (initial_name!=name) {
						$("#nameResult").html("<img src='../img/ajax-loader.gif' width='17' height='17'>");
						$("#nameResult").show();
						$.ajax({
							type: "POST",
							url: "checkAvail.php",
							data: { short_Name: name, check_Name:"1" },
							success: function(response){
								if (response=="1") {
									Register=true;
									$("#sn_icon").attr({"height":"16","width":"16","src":"../img/success.png"});
								}else{
									Register=false;
									$("#sn_icon").attr({"height":"16","width":"16","src":"../img/warning.png"});
									$("#instShortName").focus();
									focus_id="instShortName";
								};
							},
							failure: function(){
								Register=false;
								focus_id="instShortName";
							}
						});
					};
				});

				$('#adminPass').blur(function(){
					$(this).val($.trim($(this).val()));
				});

				//
				$("#inst_form").submit(function(e){
					if (!Register) {
						e.preventDefault();
						$("#"+focus_id).focus();
					}else{};
				});

				//
				$("#reset").click(function(){
					$("#email_icon").attr({"height":"16","width":"16","src":""});
					$("#sn_icon").attr({"height":"16","width":"16","src":""});
				});
			});
		</script>
		<style type="text/css">
			#inst_form .control-group{margin: 3px}
		</style>
	</head>
	<body>

				<form class="form-horizontal" id="inst_form" enctype="multipart/form-data" action="new_institute_db.php" method="POST">
					<div class="control-group span5">
					    <label class="control-label" for="instName">Institute Name :</label>
					    <div class="controls">
					      <input class="input-large" type="text" id="instName" name="instName" placeholder="Institute Full Name" required>
					    </div>
				  	</div>

				  	<div class="control-group span5">
					    <label class="control-label" for="instShortName">Institute Short-Name :</label>
					    <div class="controls">
					      	<input class="input-small" type="text" id="instShortName" name="instShortName" placeholder="Short Name">
					      	<span><img id="sn_icon" src=""></span>
					    </div>
				  	</div>
			
				  	<div class="control-group span5">
					    <label class="control-label" for="address">Institute Address :</label>
					    <div class="controls">
					      	<textarea id="address" name="address" rows="4"></textarea>
					    </div>
				  	</div>

				  	

				  	<div class="control-group span4">
					    <label class="control-label" for="cityName">City Name :</label>
					    <div class="controls">
					      	<input class="input-medium" type="text" id="cityName" name="cityName" placeholder="City Name">
					    </div>
					</div>

					<div class="control-group span4">
						<label class="control-label" for="pincode">Pincode :</label>
						<div class="controls">
					    	<input class="input-small" type="text" id="pincode" name="pincode" placeholder="xxxxxx">
					    </div>
					</div>

				  	<div class="control-group span4">
					    <label class="control-label" for="state">State :</label>
					    <div class="controls">
					      	<input class="input-medium" type="text" id="state" name="state" placeholder="State">
					    </div>
				  	</div>

				  	<div class="control-group span5">
				  		<label class="control-label" for="file">Institute-Logo :</label>
				  		<div class="controls">
						    <div class="fileupload fileupload-new" data-provides="fileupload">
						    	<div class="fileupload-new thumbnail" style="width: 200px; height: 100px;">
						    		<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image">
						    	</div>
						    	<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 100px; line-height:0px;"></div>
						    	<div>
	    							<span class="btn btn-file">
	    								<span class="fileupload-new">Select image for Logo</span>
	    								<span class="fileupload-exists">Change</span>
	    								<input id="file" name="file" type="file" />
	    							</span>
	    							<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
	  							</div>
						    </div>
					    </div>
					</div>


				  	<div class="control-group span5">
					    <label class="control-label" for="instEmail">Institute-email :</label>
					    <div class="controls">
					      	<input class="input-large" type="email" id="instEmail" name="instEmail" placeholder="abc@example.com" required>
					    </div>
				  	</div>

				  	<div class="control-group span5">
					    <label class="control-label" for="instURL">Institute Domain :</label>
					    <div class="controls">
					    	<div class="input-prepend">
					    		<input class="input-large" type="url" id="instURL" name="instURL" placeholder="Enter Domain">
					    	</div>
					    </div>
				  	</div>

				  	<div class="control-group span5">
					    <label class="control-label" for="phone">Institute Phone :</label>
					    <div class="controls">
					      	<input class="input-large" type="text" id="phone" name="phone" placeholder="Institute landline_no">
					    </div>
				  	</div>

				  	<div class="control-group span5">
					    <label class="control-label" for="fax">Institute Fax :</label>
					    <div class="controls">
					      	<input class="input-large" type="text" id="fax" name="fax" placeholder="fax">
					    </div>
				  	</div>

				  	<div class="control-group span5">
					    <label class="control-label" for="adminName">Admin Name :</label>
					    <div class="controls">
					      	<input class="input-large" type="text" id="adminName" name="adminName" placeholder="Name of Institute Admin" required>
					    </div>
				  	</div>

				  	<div class="control-group span5">
					    <label class="control-label" for="adminEmail">Admin Email :</label>
					    <div class="controls">
					      	<input class="input-medium" type="email" id="adminEmail" name="adminEmail" placeholder="admin@example.com" required>
					      	<span><img id="email_icon" src=""></span>
					    </div>
				  	</div>

				  	<div class="control-group span5">
					    <label class="control-label" for="designation">Admin Designation :</label>
					    <div class="controls">
					      	<input class="input-large" type="text" id="designation" name="designation" placeholder="Designation">
					    </div>
				  	</div>

				  	<div class="control-group span5">
					    <label class="control-label" for="adminPass">Admin Password :</label>
					    <div class="controls">
					      	<input class="input-large" type="password" id="adminPass" name="adminPass" placeholder="******">
					    </div>
				  	</div>

				  	<div class="control-group span5">
				  		<button class="btn btn-primary span2" style="margin-left:50px;" type="submit" id="submit" name="submit">Register</button>
					    <button class="btn" style="margin-left:10px;" id="reset" type="reset">Clear</button>
				  	</div>

				</form>
		
	</body>
</html>