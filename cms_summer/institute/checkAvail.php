<?php
    include(dirname(dirname(__FILE__))."./function.php");
    
    if (isset($_POST["check_Username"])) {
        $admin_username = mysql_real_escape_string($_POST['adminUsername']); // get the username
        if ($admin_username==""){
            echo "Enter email";
        }else{ 
            if (row_exist("users","username ='$admin_username'")) {
                echo '0';
            }else{ echo '1'; }
        }
    }elseif (isset($_POST["check_Name"])) {
        $name = mysql_real_escape_string($_POST['short_Name']);
        if ($name!="") {
            if (row_exist("INSTITUTE_M_DETAILS","institute_short_name ='$name'")) {
                echo '0';
            }else{ echo '1'; }
        }
    }

?>