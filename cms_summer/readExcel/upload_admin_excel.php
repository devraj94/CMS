<?php
		include(dirname(dirname(__FILE__))."./user_session.php");
		include(dirname(dirname(__FILE__))."./db_config.php"); 
		include 'reader.php';

		# Function for generating random sting of charactors..
		# Where -
		# string $c is the string of characters to use.
		# integer $l is how long you want the string to be. 
		# boolean $u is whether or not a character can appear beside itself. 
		#
		function rand_chars($c, $l, $u) { 
			if (!$u) 
				for ($s = '', $i = 0, $z = strlen($c)-1; $i < $l; $x = rand(0,$z), $s .= $c{$x}, $i++); 
			else for ($i = 0, $z = strlen($c)-1, $s = $c{rand(0,$z)}, $i = 1; $i != $l; $x = rand(0,$z), $s .= $c{$x}, $s = ($s{$i} == $s{$i-1} ? substr($s,0,-1) : $s), $i=strlen($s)); 
			return $s; 
		} // Function end here...


	    $excel = new Spreadsheet_Excel_Reader();
	    $username = $_SESSION["username"];
		
		// Connetion to database
		$con1 = mysql_connect( $dbhost, $dbuser , $dbpass) or die(mysql_error());
		mysql_select_db($dbname , $con1);	  

		$i=0;			
		$excel->read($_FILES["file"]["name"]);    
	    $x=2; // for row in excel sheet
	
	    while($x<=$excel->sheets[0]['numRows']) {
	      	$y=1;
		    while($y<=$excel->sheets[0]['numCols']) {
		        $cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
		        $data[$i] = $cell;
		        $i++;
				$y++;
		    }
			
			if ($data[0]!="") {
				# Inserting into 'institute' table
				$sql ="INSERT INTO institute (name,email_id,url,status,instAdmin,
												created_at,created_by,updated_at,updated_by)
						VALUES
								('$data[0]','$data[1]','$data[2]','inactive','$data[3]',
								'".date( 'Y-m-d H:i:s')."','$username','".date( 'Y-m-d H:i:s')."','$username')";
				mysql_query($sql , $con1) or die(mysql_error());
				//inserted

				# Getting 'institute_No' for above inserted row
				$Institute_No = "";
				$inst_sql = "SELECT * FROM institute WHERE name = '$data[0]' AND instAdmin = '$data[3]'";
				$inst_result = mysql_query($inst_sql , $con1);
				if ($inst_result) {
					while ($inst_row = mysql_fetch_array($inst_result)) {
						if ($inst_row["email_id"]==$data[1] && $inst_row["url"]==$data[2]) {
							$Institute_No = $inst_row["institute_No"];
							break;
						}
					}
				} // got the 'institute_No'

				# SQL Query for administrator Table
				$admin_sql = "INSERT INTO administrator (name, email_id,institute_No,created_at,created_by,updated_at,updated_by)
						VALUES ('$data[3]','$data[4]','$Institute_No',
							'".date( 'Y-m-d H:i:s')."','$username','".date( 'Y-m-d H:i:s')."','$username')"; 
				# Inserting data into table
				mysql_query($admin_sql, $con1) or die(mysql_error()); //inserted

				$admin_id = "";
				# Getting Admin id for above inserted entry
				$admin_sql = "SELECT * FROM administrator WHERE name = '$data[3]' AND institute_No = '$Institute_No'";
				$admin_result = mysql_query($admin_sql, $con1) or die(mysql_error()); 
				while($admin_row = mysql_fetch_array($admin_result)){
					if ($admin_row["email_id"]=$data[4]) {
						$admin_id = $admin_row["admin_id"];
						break;
					}
				} // got 'admin_id'

				$user_id = "2".$admin_id; // because index for 'Admin' is '2'
				$found_username = FALSE;

				while ($found_username==FALSE) {
					$adminUsername = rand_chars("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890", 5,FALSE); // Genrating string

					//Now we will check if above username is available or not..
					$sql1 = "SELECT username FROM users";
					$results = mysql_query($sql1, $con1); 
					if ($results) {
						while ($user_row=mysql_fetch_array($results)) {
							if ($user_row["username"]==$adminUsername) {
								$found_username = FALSE;
							}else{
								$found_username = TRUE;
							}
						}
					}else{
						$found_username = TRUE;
					}

					if ($found_username) {
						$sql = "INSERT INTO users (user_id,username, password,cat,created_at,created_by,updated_at,updated_by) 
								VALUES ('$user_id','$adminUsername','123abc','2',
									'".date( 'Y-m-d H:i:s')."','$username','".date( 'Y-m-d H:i:s')."','$username')"; 
						mysql_query($sql, $con1) or die(mysql_error()); //inserted
						break;
					}
				} // inner while loop ends
			}
			
		  	$x++; $i=0;
   		}

   		echo "Congratulation! File data successfully uploaded.";
    ?>    
  
