<?php
    include(dirname(dirname(__FILE__))."./user_session.php");
    include(dirname(dirname(__FILE__))."./db_config.php");

	$value = $_POST["status"];
	$institute_No = $_POST["id"];

	// connect to the MySQL database server 
    $db = mysql_connect($dbhost, $dbuser, $dbpass) or die("Connection Error: " . mysql_error()); 
     
    // select the database 
    mysql_select_db($dbname) or die("Error connecting to db.");

    // the actual query for update data 
    $SQL = "UPDATE institute
    		SET status = '$value',
                updated_at = '".date( 'Y-m-d H:i:s')."',
                updated_by = '".$_SESSION["username"]."',
                activation_date ='".date( 'Y-m-d H:i:s')."',
                activated_by = '".$_SESSION["username"]."'
    		WHERE institute_No = '$institute_No'
    		"; 
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error());
?>