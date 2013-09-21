<?php 
    include(dirname(dirname(__FILE__))."./user_session.php");
    include(dirname(dirname(__FILE__))."./function.php");

    $username = $_SESSION["username"];
    
    $id = $_POST["row_id"];
    $table = $_POST["table"];
    $status = $_POST["status"];
    $id_column = $_POST["id_column"];
   
    $result = update_a_column_of_table($table,"status","$status","$id_column='$id'",$username);

    if ($result) {
    	echo "success";
    }

?>