<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./db_config.php");
    include(dirname(dirname(__FILE__))."./function.php");
	$institute_No = $_SESSION["institute_id"];
	$username = $_SESSION["username"];

    $result_ta_sql = "";
    $result_taa_sql = "";

	if (isset($_POST["condition"])){

		$condition=mysql_real_escape_string($_POST["condition"]);
		$taEmail=mysql_real_escape_string($_POST["taEmail"]);
		$user_id = "";

			$ta_name = mysql_real_escape_string($_POST["name"]);
			$ta_address = mysql_real_escape_string($_POST["taAddress"]);
			$ta_contactNo = mysql_real_escape_string($_POST["contactNo"]);

			if ($condition=="new") {
			
				$taPassword = rand_chars("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890", 5,FALSE); // Genrating random string for password
				
                              $cat=5;
				$rt=insert_into_users($taEmail,$taPassword,$cat,$institute_No,$username);

				# get 'user_id' of newly added user
				$result = get_row_from_table("users","username = '$taEmail' AND cat='5' LIMIT 1");

				while ($row = mysql_fetch_array($result)) {
					$user_id = $row["user_id"];
				}

				
				$result_taa_sql = insert_into_TA($ta_name,$ta_address,$taEmail,$ta_contactNo,$institute_No,$user_id,$username);

			}elseif ($condition=="old") {
				$cat = ""; // To store category for a user 

				$table_name=mysql_real_escape_string($_POST["type"]); // Getting table name via post

				# now we have get 'user_id' from the table where 'user' exist with given 'email_id'
				$result_select = get_row_from_table($table_name,"email_id ='$taEmail' AND institute_No='$institute_No' LIMIT 1");

				while ($row = mysql_fetch_array($result_select)) {
					$user_id = $row["user_id"];
				}

				
				$select_result = get_row_from_table("users","user_id='$user_id'");

				while ($row = mysql_fetch_array($select_result)) {
					$cat = $row["cat"];
				}
				$cat = $cat.",5";

				# now we have to update the column('cat') for the existing 'user'
				$sql = "UPDATE users
						SET cat = '$cat',
							updated_at = '".date( 'Y-m-d H:i:s')."',
							updated_by = '$username'
						WHERE user_id = '$user_id'";
				mysql_query($sql, $db) or die(mysql_error());

				# Now we add new entry in 'instructor' table for the 'user'
				
				$result_ta_sql =insert_into_TA($ta_name,$ta_address,$taEmail,$ta_contactNo,$institute_No,$user_id,$username);
			}elseif ($condition=="ins") {
				$ta_name = mysql_real_escape_string($_POST["name"]);
                $tasem=mysql_real_escape_string($_POST["sem"]);
				$insid=$_SESSION['instructor_id'];
		        $ta_result = get_row_from_table("ta","institute_No = '$institute_No' AND email_id = '".$taEmail."'");
				$array = mysql_fetch_array($ta_result);
				$taid=$array['ta_id'];
				$acyear=get_academic_year();
				$session=get_session();
				$result=insert_into_ta_instructor($taid,$insid,$institute_No,$tasem,$session,$acyear,$username);
				if ($result) {
						?>
							<script type="text/javascript">
								window.parent.$("#cong").html("TA successfully added.")
								window.parent.$("#cong").dialog("open");
							</script>
						<?php
				}elseif (!$result) {
						?>
							<script type="text/javascript">
								alert("Some error occured.");
							</script>
						<?php
				}
	        }

	}else{
		# Data through 'POST'
		$email_id=mysql_real_escape_string($_POST["email"]);

		# SQL Query for searching in 'Administrator' table
		$admin_result = get_row_from_table("administrator","institute_No = '$institute_No' AND email_id = '".$email_id."' LIMIT 1");
		
		# SQL Query for searching in 'ta_instructorr' table
		$ta_result =get_row_from_table("ta","institute_No = '$institute_No' AND email_id = '".$email_id."'");
		$array = mysql_fetch_array($ta_result);
		$taid=$array['ta_id'];

		$instructor_id = get_column_from_table("instructor_id","instructor","user_id='".$_SESSION["user_id"]."'");
		$tains_result = get_row_from_table("ta_instructor","institute_No = '$institute_No' AND ta_id = '".$taid."' AND instructor_id='$instructor_id'");

		# SQL Query for searching in 'Instructor' table
		$ta_result = get_row_from_table("ta","institute_No = '$institute_No' AND email_id = '".$email_id."'
							LIMIT 1");

		# SQL Query for searching in 'Student' table
		$student_result = get_row_from_table("student","institute_No = '$institute_No' AND email_id = '".$email_id."' LIMIT 1");

		if(mysql_num_rows($ta_result) > 0){
		   $array = mysql_fetch_array($ta_result);
			$name = $array["name"];
			$address = $array["address"];
			$contactno=$array["contactNo"];
			if(isset($_GET['ins'])){
					if(mysql_num_rows($tains_result)>0){
					        echo "Exist*no*".$name."*".$address."*".$contactno;
					}else{
					        echo "Exist*yes*".$name."*".$address."*".$contactno;
					}
			}else{
			echo "Exist*no*".$name."*".$address."*".$contactno;
			}
			
		}elseif (mysql_num_rows($admin_result) > 0) {
			$array = mysql_fetch_array($admin_result);
			$name = $array["name"];
			echo $name."*administrator* ";
		}elseif (mysql_num_rows($student_result) > 0) {
			$array = mysql_fetch_array($student_result);
			$name = $array["student_name"];
			$address = $array["address"];
			echo $name."*student*".$address;
		}else{
			echo " * ";
		}
	}// else end
if ($result_ta_sql || $result_taa_sql) { ?>
		<script type="text/javascript">
			window.parent.$('#ta_cong').dialog("open");
		</script>
<?php } ?>
	
